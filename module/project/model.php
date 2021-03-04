<?php
class projectModel extends model
{
    /**
     * Get Multiple linked products for project.
     *
     * @param  int    $projectID
     * @access public
     * @return array
     */
    public function getMultiLinkedProducts($projectID)
    {
        $linkedProducts      = $this->dao->select('product')->from(TABLE_PROJECTPRODUCT)->where('project')->eq($projectID)->fetchPairs();
        $multiLinkedProducts = $this->dao->select('t3.id,t3.name')->from(TABLE_PROJECTPRODUCT)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project = t2.id')
            ->leftJoin(TABLE_PRODUCT)->alias('t3')->on('t1.product = t3.id')
            ->where('t1.product')->in($linkedProducts)
            ->andWhere('t1.project')->ne($projectID)
            ->andWhere('t2.type')->eq('project')
            ->andWhere('t2.deleted')->eq('0')
            ->andWhere('t3.deleted')->eq('0')
            ->fetchPairs('id', 'name');

        return $multiLinkedProducts;
    }

    /**
     * Show accessDenied response.
     *
     * @access private
     * @return void
     */
    public function accessDenied()
    {
        echo(js::alert($this->lang->project->accessDenied));

        if(!$this->server->http_referer) die(js::locate(helper::createLink('project', 'browse')));

        $loginLink = $this->config->requestType == 'GET' ? "?{$this->config->moduleVar}=user&{$this->config->methodVar}=login" : "user{$this->config->requestFix}login";
        if(strpos($this->server->http_referer, $loginLink) !== false) die(js::locate(helper::createLink('project', 'browse')));

        die(js::locate('back'));
    }

    /**
     * Judge an action is clickable or not.
     *
     * @param  object    $project
     * @param  string    $action
     * @access public
     * @return bool
     */
    public static function isClickable($project, $action)
    {
        $action = strtolower($action);

        if(empty($project)) return true;
        if(!isset($project->type)) return true;

        if($action == 'start')    return $project->status == 'wait' or $project->status == 'suspended';
        if($action == 'finish')   return $project->status == 'wait' or $project->status == 'doing';
        if($action == 'close')    return $project->status != 'closed';
        if($action == 'suspend')  return $project->status == 'wait' or $project->status == 'doing';
        if($action == 'activate') return $project->status == 'done' or $project->status == 'closed';

        return true;
    }

    /**
     * Check has content for project.
     *
     * @param  int    $projectID
     * @access public
     * @return bool
     */
    public function checkHasContent($projectID)
    {
        $count  = 0;
        $count += (int)$this->dao->select('count(*) as count')->from(TABLE_PROJECT)->where('parent')->eq($projectID)->fetch('count');
        $count += (int)$this->dao->select('count(*) as count')->from(TABLE_TASK)->where('PRJ')->eq($projectID)->fetch('count');

        return $count > 0;
    }

    /**
     * Check has children project.
     *
     * @param  int    $projectID
     * @access public
     * @return bool
     */
    public function checkHasChildren($projectID)
    {
        $count = $this->dao->select('count(*) as count')->from(TABLE_PROGRAM)->where('parent')->eq($projectID)->fetch('count');
        return $count > 0;
    }

    /**
     * Get budget unit list.
     *
     * @access public
     * @return array
     */
    public function getBudgetUnitList()
    {
        $budgetUnitList = array();
        foreach(explode(',', $this->config->project->unitList) as $unit) $budgetUnitList[$unit] = zget($this->lang->project->unitList, $unit, '');

        return $budgetUnitList;
    }

    /**
     * Save project state.
     *
     * @param  int    $projectID
     * @param  array  $projects
     * @access public
     * @return int
     */
    public function saveState($projectID = 0, $projects = array())
    {
        if($projectID > 0) $this->session->set('project', (int)$projectID);
        if($projectID == 0 and $this->cookie->lastProject) $this->session->set('project', (int)$this->cookie->lastProject);
        if($projectID == 0 and $this->session->project == '') $this->session->set('project', key($projects));
        if(!isset($projects[$this->session->project]))
        {
            $this->session->set('project', key($projects));
            if($projectID && strpos(",{$this->app->user->view->projects},", ",{$this->session->project},") === false) $this->accessDenied();
        }

        return $this->session->project;
    }

    /*
     * Get project swapper.
     *
     * @param  int     $projectID
     * @param  string  $currentModule
     * @param  string  $currentMethod
     * @access public
     * @return string
     */
    public function getSwitcher($projectID, $currentModule, $currentMethod)
    {
        $this->session->set('moreProjectLink', $this->app->getURI(true));

        $this->loadModel('project');
        $currentProjectName = $this->lang->project->common;
        if($projectID)
        {
            $currentProject     = $this->getById($projectID);
            $currentProjectName = $currentProject->name;
        }

        $dropMenuLink = helper::createLink('project', 'ajaxGetDropMenu', "objectID=$projectID&module=$currentModule&method=$currentMethod");
        $output  = "<div class='btn-group header-angle-btn' id='swapper'><button data-toggle='dropdown' type='button' class='btn' id='currentItem' title='{$currentProjectName}'><span class='text'><i class='icon icon-project'></i> {$currentProjectName}</span> <span class='caret'></span></button><div id='dropMenu' class='dropdown-menu search-list' data-ride='searchList' data-url='$dropMenuLink'>";
        $output .= '<div class="input-control search-box has-icon-left has-icon-right search-example"><input type="search" class="form-control search-input" /><label class="input-control-icon-left search-icon"><i class="icon icon-search"></i></label><a class="input-control-icon-right search-clear-btn"><i class="icon icon-close icon-sm"></i></a></div>';
        $output .= "</div></div>";

        return $output;
    }

    /**
     * Get project main menu action.
     *
     * @param  string $module
     * @param  string $method
     * @access public
     * @return string
     */
    public function getMainAction($module, $method)
    {
        $link = html::a(helper::createLink('project', 'prjbrowse'), "<i class='icon icon-list'></i>", '', "style='border: none;'");
        $html = "<p style='padding-top:5px;'>" . $link . "</p>";
        return common::hasPriv('project', 'prjbrowse') ? $html : '';
    }

    /**
     * Get a project by id.
     *
     * @param  int    $projectID
     * @access public
     * @return object
     */
    public function getByID($projectID)
    {
        $project = $this->dao->select('*')->from(TABLE_PROJECT)->where('id')->eq($projectID)->andWhere('`type`')->eq('project')->fetch();
        if(!$project) return false;

        if($project->end == '0000-00-00') $project->end = '';
        return $project;
    }

    /**
     * Get project info.
     *
     * @param  string    $status
     * @param  int       $itemCounts
     * @param  string    $orderBy
     * @param  int       $pager
     * @access public
     * @return array
     */
    public function getInfoList($status = 'undone', $itemCounts = 30, $orderBy = 'order_desc', $pager = null)
    {
        /* Init vars. */
        $projects = $this->loadModel('program')->getProjectList(0, $status, 0, $orderBy, $pager);
        if(empty($projects)) return array();

        $projectIdList = array_keys($projects);
        $teams = $this->dao->select('root, count(*) as count')->from(TABLE_TEAM)
            ->where('root')->in($projectIdList)
            ->groupBy('root')
            ->fetchAll('root');

        $estimates = $this->dao->select('PRJ, sum(estimate) as estimate')->from(TABLE_TASK)
            ->where('PRJ')->in($projectIdList)
            ->andWhere('deleted')->eq(0)
            ->andWhere('parent')->lt(1)
            ->groupBy('PRJ')
            ->fetchAll('PRJ');

        $this->app->loadClass('pager', $static = true);
        $this->loadModel('execution');
        foreach($projects as $projectID => $project)
        {
            $orderBy = $project->model == 'waterfall' ? 'id_asc' : 'id_desc';
            $pager   = $project->model == 'waterfall' ? null : new pager(0, 1, 1);
            $project->executions = $this->execution->getStats($projectID, 'undone', 0, 0, 30, $orderBy, $pager);
            $project->teamCount  = isset($teams[$projectID]) ? $teams[$projectID]->count : 0;
            $project->estimate   = isset($estimates[$projectID]) ? round($estimates[$projectID]->estimate, 2) : 0;
            $project->parentName = $this->getParentName($project->parent);
        }
        return $projects;
    }

    /**
     * Gets the top-level project name.
     *
     * @param  int       $parentID
     * @access private
     * @return string
     */
    public function getParentName($parentID = 0)
    {
        if($parentID == 0) return '';

        static $parent;
        $parent = $this->dao->select('id,parent,name')->from(TABLE_PROJECT)->where('id')->eq($parentID)->fetch();
        if($parent->parent) $this->getParentName($parent->parent);

        return $parent->name;
    }

    /**
     * Get project overview for block.
     *
     * @param  string     $queryType byId|byStatus
     * @param  string|int $param
     * @param  string     $orderBy
     * @param  int        $limit
     * @access public
     * @return array
     */
    public function getOverviewList($queryType = 'byStatus', $param = 'all', $orderBy = 'id_desc', $limit = 15)
    {
        $queryType = strtolower($queryType);
        $projects = $this->dao->select('*')->from(TABLE_PROJECT)
            ->where('type')->eq('project')
            ->andWhere('deleted')->eq(0)
            ->beginIF(!$this->app->user->admin)->andWhere('id')->in($this->app->user->view->projects)->fi()
            ->beginIF($queryType == 'bystatus' and $param != 'all')->andWhere('status')->eq($param)->fi()
            ->beginIF($queryType == 'byid')->andWhere('id')->eq($param)->fi()
            ->orderBy($orderBy)
            ->limit($limit)
            ->fetchAll('id');

        if(empty($projects)) return array();
        $projectIdList = array_keys($projects);

        $teams = $this->dao->select('root, count(*) as teams')->from(TABLE_TEAM)->where('root')->in($projectIdList)->groupBy('root')->fetchPairs();

        $hours = $this->dao->select('PRJ,
            cast(sum(consumed) as decimal(10,2)) as consumed,
            cast(sum(estimate) as decimal(10,2)) as estimate')
            ->from(TABLE_TASK)
            ->where('PRJ')->in($projectIdList)
            ->andWhere('deleted')->eq(0)
            ->andWhere('parent')->lt(1)
            ->groupBy('PRJ')
            ->fetchAll('PRJ');

        $leftTasks = $this->dao->select('PRJ, count(*) as tasks')->from(TABLE_TASK)
            ->where('PRJ')->in($projectIdList)
            ->andWhere('deleted')->eq(0)
            ->andWhere('status')->in('wait,doing,pause')
            ->groupBy('PRJ')
            ->fetchPairs();

        foreach($projectIdList as $projectID)
        {
            $productIdList = $this->loadModel('product')->getProductIDByProject($projectID, false);
            $allStories[$projectID]  = $this->product->getTotalStoriesByProduct($productIdList, 'story');
            $doneStories[$projectID] = $this->product->getTotalStoriesByProduct($productIdList, 'story', 'closed');
            $leftStories[$projectID] = $this->product->getTotalStoriesByProduct($productIdList, 'story', 'active');
        }

        $leftBugs = $this->getTotalBugByProject($projectIdList, 'active');
        $allBugs  = $this->getTotalBugByProject($projectIdList, 'all');
        $doneBugs = $this->getTotalBugByProject($projectIdList, 'resolved');

        foreach($projects as $projectID => $project)
        {
            $project->consumed    = isset($hours[$projectID]) ? $hours[$projectID]->consumed : 0;
            $project->estimate    = isset($hours[$projectID]) ? $hours[$projectID]->estimate : 0;
            $project->teamCount   = isset($teams[$projectID]) ? $teams[$projectID] : 0;
            $project->leftTasks   = isset($leftTasks[$projectID]) ? $leftTasks[$projectID] : 0;
            $project->leftBugs    = isset($leftBugs[$projectID])  ? $leftBugs[$projectID]  : 0;
            $project->allBugs     = isset($allBugs[$projectID])   ? $allBugs[$projectID]   : 0;
            $project->doneBugs    = isset($doneBugs[$projectID])  ? $doneBugs[$projectID]  : 0;
            $project->allStories  = $allStories[$projectID];
            $project->doneStories = $doneStories[$projectID];
            $project->leftStories = $leftStories[$projectID];
        }

        return $projects;
    }

    /**
     * Get project workhour info.
     *
     * @param  int    $projectID
     * @access public
     * @return object
     */
    public function getWorkhour($projectID)
    {
        $executions = $this->loadModel('project')->getExecutionPairs($projectID);

        $total = $this->dao->select('
            ROUND(SUM(estimate), 2) AS totalEstimate,
            ROUND(SUM(consumed), 2) AS totalConsumed,
            ROUND(SUM(`left`), 2) AS totalLeft')
            ->from(TABLE_TASK)
            ->where('project')->in(array_keys($executions))
            ->andWhere('deleted')->eq(0)
            ->andWhere('parent')->lt(1)
            ->fetch();
        $closedTotalLeft = $this->dao->select('ROUND(SUM(`left`), 2) AS totalLeft')->from(TABLE_TASK)
            ->where('project')->in(array_keys($executions))
            ->andWhere('deleted')->eq(0)
            ->andWhere('parent')->lt(1)
            ->andWhere('status')->in('closed,cancel')
            ->fetch('totalLeft');

        $workhour = new stdclass();
        $workhour->totalHours    = $this->dao->select('sum(days * hours) AS totalHours')->from(TABLE_TEAM)->where('root')->in(array_keys($executions))->andWhere('type')->eq('project')->fetch('totalHours');
        $workhour->totalEstimate = round($total->totalEstimate, 1);
        $workhour->totalConsumed = round($total->totalConsumed, 1);
        $workhour->totalLeft     = round($total->totalLeft - $closedTotalLeft, 1);

        return $workhour;
    }

    /**
     * Get project stat data .
     *
     * @param  int    $projectID
     * @access public
     * @return object
     */
    public function getStatData($projectID)
    {
        $executions = $this->loadModel('project')->getExecutionPairs($projectID);
        $storyCount = $this->dao->select('count(t2.story) as storyCount')->from(TABLE_STORY)->alias('t1')
            ->leftJoin(TABLE_PROJECTSTORY)->alias('t2')->on('t1.id = t2.story')
            ->where('t2.project')->eq($projectID)
            ->andWhere('t1.deleted')->eq(0)
            ->fetch('storyCount');

        $taskCount = $this->dao->select('count(id) as taskCount')->from(TABLE_TASK)->where('project')->in(array_keys($executions))->andWhere('deleted')->eq(0)->fetch('taskCount');
        $bugCount  = $this->dao->select('count(id) as bugCount')->from(TABLE_BUG)->where('project')->in(array_keys($executions))->andWhere('deleted')->eq(0)->fetch('bugCount');

        $statData = new stdclass();
        $statData->storyCount = $storyCount;
        $statData->taskCount  = $taskCount;
        $statData->bugCount   = $bugCount;

        return $statData;
    }

    /**
     * Get project pairs.
     *
     * @param  int    $projectID
     * @param  status $status    all|wait|doing|suspended|closed|noclosed
     * @access public
     * @return object
     */
    public function getPairs($projectID = 0, $status = 'all')
    {
        return $this->dao->select('id, name')->from(TABLE_PROJECT)
            ->where('type')->eq('project')
            ->andWhere('deleted')->eq(0)
            ->beginIF($projectID)->andWhere('parent')->eq($projectID)->fi()
            ->beginIF($status != 'all' && $status != 'noclosed')->andWhere('status')->eq($status)->fi()
            ->beginIF($status == 'noclosed')->andWhere('status')->ne('closed')->fi()
            ->beginIF(!$this->app->user->admin)->andWhere('id')->in($this->app->user->view->projects)->fi()
            ->fetchPairs();
    }

    /**
     * Get project by id list.
     *
     * @param  array    $projectIdList
     * @access public
     * @return object
     */
    public function getByIdList($projectIdList = array())
    {
        return $this->dao->select('*')->from(TABLE_PROJECT)
            ->where('type')->eq('project')
            ->andWhere('deleted')->eq(0)
            ->andWhere('id')->in($projectIdList)
            ->beginIF(!$this->app->user->admin)->andWhere('id')->in($this->app->user->view->projects)->fi()
            ->fetchAll('id');
    }

    /**
     * Get project pairs by id list.
     *
     * @param  array  $projectIdList
     * @access public
     * @return array
     */
    public function getPairsByIdList($projectIdList = array())
    {
        return $this->dao->select('id, name')->from(TABLE_PROJECT)
            ->where('type')->eq('project')
            ->andWhere('deleted')->eq(0)
            ->andWhere('id')->in($projectIdList)
            ->beginIF(!$this->app->user->admin)->andWhere('id')->in($this->app->user->view->projects)->fi()
            ->fetchPairs('id', 'name');
    }

    /**
     * Get associated bugs by project.
     *
     * @param  array  $projectIdList
     * @param  string $status   active|resolved|all
     * @access public
     * @return array
     */
    public function getTotalBugByProject($projectIdList, $status)
    {
        return $this->dao->select('PRJ, count(*) as bugs')->from(TABLE_BUG)
            ->where('PRJ')->in($projectIdList)
            ->andWhere('deleted')->eq(0)
            ->beginIF($status != 'all')->andWhere('status')->eq($status)->fi()
            ->groupBy('PRJ')
            ->fetchPairs('PRJ');
    }

    /**
     * Build the query.
     *
     * @param  int    $projectID
     * @param  string $type   list|dropmenu
     * @access public
     * @return object
     */
    public function buildMenuQuery($projectID = 0, $type = 'list')
    {
        $path    = '';
        $project = $this->getByID($projectID);
        if($project) $path = $project->path;

        return $this->dao->select('*')->from(TABLE_PROJECT)
            ->where('deleted')->eq('0')
            ->beginIF($type == 'list')->andWhere('type')->eq('project')->fi()
            ->beginIF($type == 'dropmenu')->andWhere('type')->in('project,project')->fi()
            ->andWhere('status')->ne('closed')
            ->beginIF(!$this->app->user->admin and $type == 'list')->andWhere('id')->in($this->app->user->view->projects)->fi()
            ->beginIF(!$this->app->user->admin and $type == 'dropmenu')->andWhere('id')->in($this->app->user->view->projects . ',' . $this->app->user->view->projects)->fi()
            ->beginIF($projectID > 0)->andWhere('path')->like($path . '%')->fi()
            ->orderBy('grade desc, `order`')
            ->get();
    }

    /**
     * Get project pairs by model and project.
     *
     * @param  string $model all|scrum|waterfall
     * @param  int    $projectID
     * @access public
     * @return array
     */
    public function getPairsByModel($model = 'all', $projectID = 0)
    {
        return $this->dao->select('id, name')->from(TABLE_PROJECT)
            ->where('type')->eq('project')
            ->beginIF($projectID)->andWhere('parent')->eq($projectID)->fi()
            ->beginIF($model != 'all')->andWhere('model')->eq($model)->fi()
            ->andWhere('deleted')->eq('0')
            ->beginIF(!$this->app->user->admin)->andWhere('id')->in($this->app->user->view->projects)->fi()
            ->orderBy('id_desc')
            ->fetchPairs();
    }

    /**
     * Get the tree menu of project.
     *
     * @param  int       $projectID
     * @param  string    $userFunc
     * @param  int       $param
     * @param  string    $type  list|dropmenu
     * @access public
     * @return string
     */
    public function getTreeMenu($projectID = 0, $userFunc, $param = 0, $type = 'list')
    {
        $projectMenu = array();
        $stmt        = $this->dbh->query($this->buildMenuQuery($projectID, $type));

        while($project = $stmt->fetch())
        {
            $linkHtml = call_user_func($userFunc, $project, $param);

            if(isset($projectMenu[$project->id]) and !empty($projectMenu[$project->id]))
            {
                if(!isset($projectMenu[$project->parent])) $projectMenu[$project->parent] = '';
                $projectMenu[$project->parent] .= "<li>$linkHtml";
                $projectMenu[$project->parent] .= "<ul>".$projectMenu[$project->id]."</ul>\n";
            }
            else
            {
                if(isset($projectMenu[$project->parent]) and !empty($projectMenu[$project->parent]))
                {
                    $projectMenu[$project->parent] .= "<li>$linkHtml\n";
                }
                else
                {
                    $projectMenu[$project->parent] = "<li>$linkHtml\n";
                }
            }
            $projectMenu[$project->parent] .= "</li>\n";
        }

        krsort($projectMenu);
        $projectMenu = array_pop($projectMenu);
        $lastMenu    = "<ul class='tree' data-ride='tree' id='projectTree' data-name='tree-project'>{$projectMenu}</ul>\n";

        return $lastMenu;
    }

    /**
     * Create the manage link.
     *
     * @param  object    $project
     * @access public
     * @return string
     */
    public function createManageLink($project)
    {
        $link = $project->type == 'project' ? helper::createLink('project', 'browse', "projectID={$project->id}&status=all") : helper::createLink('project', 'index', "projectID={$project->id}", '', '', $project->id);
        $icon = $project->type == 'project' ? "<i class='icon icon-folder-open-o'></i> " : "<i class='icon icon-project'></i> ";
        return html::a($link, $icon . $project->name, '_self', "id=project{$project->id} title='{$project->name}' class='text-ellipsis'");
    }

    /**
     * Create a project.
     *
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $project = fixer::input('post')
            ->setDefault('status', 'wait')
            ->setIF($this->post->delta == 999, 'end', LONG_TIME)
            ->setIF($this->post->delta == 999, 'days', 0)
            ->setIF($this->post->acl   == 'open', 'whitelist', '')
            ->setIF($this->post->budget != 0, 'budget', round($this->post->budget, 2))
            ->setDefault('openedBy', $this->app->user->account)
            ->setDefault('openedDate', helper::now())
            ->setDefault('team', substr($this->post->name, 0, 30))
            ->setDefault('lastEditedBy', $this->app->user->account)
            ->setDefault('lastEditedDate', helper::now())
            ->add('type', 'project')
            ->join('whitelist', ',')
            ->stripTags($this->config->project->editor->prjcreate['id'], $this->config->allowedTags)
            ->remove('products,branch,plans,delta,newProduct,productName,future')
            ->get();

        $linkedProductsCount = 0;
        if(isset($_POST['products']))
        {
            foreach($_POST['products'] as $product)
            {
                if(!empty($product)) $linkedProductsCount++;
            }
        }

        $parentProject = new stdClass();
        if($project->parent)
        {
            $parentProject = $this->dao->select('*')->from(TABLE_PROGRAM)->where('id')->eq($project->parent)->fetch();
            if($parentProject)
            {
                /* Child project begin cannot less than parent. */
                if($project->begin < $parentProject->begin) dao::$errors['begin'] = sprintf($this->lang->project->beginGreateChild, $parentProject->begin);

                /* When parent set end then child project end cannot greater than parent. */
                if($parentProject->end != '0000-00-00' and $project->end > $parentProject->end) dao::$errors['end'] = sprintf($this->lang->project->endLetterChild, $parentProject->end);

                if(dao::isError()) return false;
            }

            /* The budget of a child project cannot beyond the remaining budget of the parent project. */
            $project->budgetUnit = $parentProject->budgetUnit;
            if(isset($project->budget) and $parentProject->budget != 0)
            {
                $availableBudget = $this->getAvailableBudget($parentProject);
                if($project->budget > $availableBudget) dao::$errors['budget'] = $this->lang->project->beyondParentBudget;
            }

            /* Judge products not empty. */
            if(empty($linkedProductsCount) and !isset($_POST['newProduct']))
            {
                dao::$errors[] = $this->lang->project->productNotEmpty;
                return false;
            }
        }

        /* When select create new product, product name cannot be empty and duplicate. */
        if(isset($_POST['newProduct']))
        {
            if(empty($_POST['productName']))
            {
                $this->app->loadLang('product');
                dao::$errors['productName'] = sprintf($this->lang->error->notempty, $this->lang->product->name);
                return false;
            }
            else
            {
                $existProductName = $this->dao->select('name')->from(TABLE_PRODUCT)->where('name')->eq($_POST['productName'])->fetch('name');
                if(!empty($existProductName))
                {
                    dao::$errors['productName'] = $this->lang->project->existProductName;
                    return false;
                }
            }
        }

        $requiredFields = $this->config->project->create->requiredFields;
        if($this->post->delta == 999) $requiredFields = trim(str_replace(',end,', ',', ",{$requiredFields},"), ',');

        /* Redefines the language entries for the fields in the project table. */
        foreach(explode(',', $requiredFields) as $field)
        {
            if(isset($this->lang->project->$field)) $this->lang->project->$field = $this->lang->project->$field;
        }

        $project = $this->loadModel('file')->processImgURL($project, $this->config->project->editor->prjcreate['id'], $this->post->uid);
        $this->dao->insert(TABLE_PROJECT)->data($project)
            ->autoCheck()
            ->batchcheck($requiredFields, 'notempty')
            ->checkIF(!empty($project->name), 'name', 'unique')
            ->exec();

        /* Add the creater to the team. */
        if(!dao::isError())
        {
            $projectID = $this->dao->lastInsertId();

            /* Add the creator to team. */
            $this->app->loadLang('user');
            $member = new stdclass();
            $member->root    = $projectID;
            $member->account = $this->app->user->account;
            $member->role    = $this->lang->user->roleList[$this->app->user->role];
            $member->join    = helper::today();
            $member->type    = 'project';
            $member->hours   = $this->config->project->defaultWorkhours;
            $this->dao->insert(TABLE_TEAM)->data($member)->exec();

            $whitelist = explode(',', $project->whitelist);
            $this->loadModel('personnel')->updateWhitelist($whitelist, 'project', $projectID);
            if($project->acl != 'open') $this->loadModel('user')->updateUserView($projectID, 'project');

            $this->loadModel('project')->updateProducts($projectID);

            if(isset($_POST['newProduct']) || (!$project->parent && empty($linkedProductsCount)))
            {
                /* If parent not empty, link products or create products. */
                $product = new stdclass();
                $product->name         = $this->post->productName ? $this->post->productName : $project->name;
                $product->bind         = $this->post->productName ? 0 : 1;
                $product->project      = $project->parent ? current(array_filter(explode(',', $parentProject->path))) : 0;
                $product->acl          = $project->acl = 'open' ? 'open' : 'private';
                $product->PO           = $project->PM;
                $product->createdBy    = $this->app->user->account;
                $product->createdDate  = helper::now();
                $product->status       = 'normal';

                $this->dao->insert(TABLE_PRODUCT)->data($product)->exec();
                $productID = $this->dao->lastInsertId();
                if($product->acl != 'open') $this->loadModel('user')->updateUserView($productID, 'product');

                $projectProduct = new stdclass();
                $projectProduct->project = $projectID;
                $projectProduct->product = $productID;

                $this->dao->insert(TABLE_PROJECTPRODUCT)->data($projectProduct)->exec();

                /* Create doc lib. */
                $this->app->loadLang('doc');
                $lib = new stdclass();
                $lib->product = $productID;
                $lib->name    = $this->lang->doclib->main['product'];
                $lib->type    = 'product';
                $lib->main    = '1';
                $lib->acl     = 'default';
                $this->dao->insert(TABLE_DOCLIB)->data($lib)->exec();
            }

            /* Save order. */
            $this->dao->update(TABLE_PROJECT)->set('`order`')->eq($projectID * 5)->where('id')->eq($projectID)->exec();
            $this->file->updateObjectID($this->post->uid, $projectID, 'project');
            $this->setTreePath($projectID);

            /* Add project admin. */
            $groupPriv = $this->dao->select('t1.*')->from(TABLE_USERGROUP)->alias('t1')
                ->leftJoin(TABLE_GROUP)->alias('t2')->on('t1.group = t2.id')
                ->where('t1.account')->eq($this->app->user->account)
                ->andWhere('t2.role')->eq('PRJAdmin')
                ->fetch();

            if(!empty($groupPriv))
            {
                $newProject = $groupPriv->PRJ . ",$projectID";
                $this->dao->update(TABLE_USERGROUP)->set('PRJ')->eq($newProject)->where('account')->eq($groupPriv->account)->andWhere('`group`')->eq($groupPriv->group)->exec();
            }
            else
            {
                $PRJAdminID = $this->dao->select('id')->from(TABLE_GROUP)->where('role')->eq('PRJAdmin')->fetch('id');
                $groupPriv  = new stdclass();
                $groupPriv->account = $this->app->user->account;
                $groupPriv->group   = $PRJAdminID;
                $groupPriv->PRJ     = $projectID;
                $this->dao->insert(TABLE_USERGROUP)->data($groupPriv)->exec();
            }

            return $projectID;
        }
    }

    /**
     * Update project.
     *
     * @param  int    $projectID
     * @access public
     * @return array
     */
    public function update($projectID = 0)
    {
        $oldProject        = $this->dao->findById($projectID)->from(TABLE_PROJECT)->fetch();
        $linkedProducts    = $this->dao->select('product')->from(TABLE_PROJECTPRODUCT)->where('project')->eq($projectID)->fetchPairs();
        $_POST['products'] = isset($_POST['products']) ? $_POST['products'] : $linkedProducts;

        $project = fixer::input('post')
            ->setDefault('team', substr($this->post->name, 0, 30))
            ->setDefault('lastEditedBy', $this->app->user->account)
            ->setDefault('lastEditedDate', helper::now())
            ->setIF($this->post->delta == 999, 'end', LONG_TIME)
            ->setIF($this->post->delta == 999, 'days', 0)
            ->setIF($this->post->begin == '0000-00-00', 'begin', '')
            ->setIF($this->post->end   == '0000-00-00', 'end', '')
            ->setIF($this->post->acl   == 'open', 'whitelist', '')
            ->setIF($this->post->future, 'budget', 0)
            ->setIF($this->post->budget != 0, 'budget', round($this->post->budget, 2))
            ->join('whitelist', ',')
            ->stripTags($this->config->project->editor->prjedit['id'], $this->config->allowedTags)
            ->remove('products,branch,plans,delta,future')
            ->get();

        if($project->parent)
        {
            $parentProject = $this->dao->select('*')->from(TABLE_PROGRAM)->where('id')->eq($project->parent)->fetch();

            if($parentProject)
            {
                /* Child project begin cannot less than parent. */
                if($project->begin < $parentProject->begin) dao::$errors['begin'] = sprintf($this->lang->project->beginGreateChild, $parentProject->begin);

                /* When parent set end then child project end cannot greater than parent. */
                if($parentProject->end != '0000-00-00' and $project->end > $parentProject->end) dao::$errors['end'] = sprintf($this->lang->project->endLetterChild, $parentProject->end);

                if(dao::isError()) return false;
            }

            /* The budget of a child project cannot beyond the remaining budget of the parent project. */
            $project->budgetUnit = $parentProject->budgetUnit;
            if($project->budget != 0 and $parentProject->budget != 0)
            {
                $availableBudget = $this->getAvailableBudget($parentProject);
                if($project->budget > $availableBudget + $oldProject->budget) dao::$errors['budget'] = $this->lang->project->beyondParentBudget;
            }
        }

        /* Judge products not empty. */
        $linkedProductsCount = 0;
        foreach($_POST['products'] as $product)
        {
            if(!empty($product)) $linkedProductsCount++;
        }
        if(empty($linkedProductsCount))
        {
            dao::$errors[] = $this->lang->project->errorNoProducts;
            return false;
        }

        $project = $this->loadModel('file')->processImgURL($project, $this->config->project->editor->prjedit['id'], $this->post->uid);

        $requiredFields = $this->config->project->edit->requiredFields;
        if($this->post->delta == 999) $requiredFields = trim(str_replace(',end,', ',', ",{$requiredFields},"), ',');

        /* Redefines the language entries for the fields in the project table. */
        foreach(explode(',', $requiredFields) as $field)
        {
            if(isset($this->lang->project->$field)) $this->lang->project->$field = $this->lang->project->$field;
        }

        $this->dao->update(TABLE_PROJECT)->data($project)
            ->autoCheck($skipFields = 'begin,end')
            ->batchcheck($requiredFields, 'notempty')
            ->checkIF($project->begin != '', 'begin', 'date')
            ->checkIF($project->end != '', 'end', 'date')
            ->checkIF($project->end != '', 'end', 'gt', $project->begin)
            ->check('name', 'unique', "id!=$projectID and deleted='0'")
            ->where('id')->eq($projectID)
            ->exec();

        if(!dao::isError())
        {
            $this->updateProductProgram($oldProject->parent, $project->parent, $_POST['products']);
            $this->loadModel('project')->updateProducts($projectID, $_POST['products']);
            $this->file->updateObjectID($this->post->uid, $projectID, 'project');

            $whitelist = explode(',', $project->whitelist);
            $this->loadModel('personnel')->updateWhitelist($whitelist, 'project', $projectID);
            if($project->acl != 'open') $this->loadModel('user')->updateUserView($projectID, 'project');

            if($oldProject->parent != $project->parent) $this->processNode($projectID, $project->parent, $oldProject->path, $oldProject->grade);

            return common::createChanges($oldProject, $project);
        }
    }

    /**
     * Batch update projects.
     *
     * @access public
     * @return array
     */
    public function batchUpdate()
    {
        $projects    = array();
        $allChanges  = array();
        $data        = fixer::input('post')->get();
        $oldProjects = $this->getByIdList($this->post->projectIdList);
        $nameList    = array();

        foreach($data->projectIdList as $projectID)
        {
            $projectName   = $data->names[$projectID];

            $projectID = (int)$projectID;
            $projects[$projectID] = new stdClass();
            $projects[$projectID]->name           = $projectName;
            $projects[$projectID]->parent         = $data->parents[$projectID];
            $projects[$projectID]->PM             = $data->PMs[$projectID];
            $projects[$projectID]->begin          = $data->begins[$projectID];
            $projects[$projectID]->end            = isset($data->ends[$projectID]) ? $data->ends[$projectID] : LONG_TIME;
            $projects[$projectID]->days           = $data->dayses[$projectID];
            $projects[$projectID]->acl            = $data->acls[$projectID];
            $projects[$projectID]->lastEditedBy   = $this->app->user->account;
            $projects[$projectID]->lastEditedDate = helper::now();

            /* Check unique name for edited projects. */
            if(isset($nameList[$projectName])) dao::$errors['name'][] = 'project#' . $projectID . sprintf($this->lang->error->unique, $this->lang->project->name, $projectName);
            $nameList[$projectName] = $projectName;

            if($projects[$projectID]->parent)
            {
                $parentProject = $this->dao->select('*')->from(TABLE_PROGRAM)->where('id')->eq($projects[$projectID]->parent)->fetch();

                if($parentProject)
                {
                    /* Child project begin cannot less than parent. */
                    if($projects[$projectID]->begin < $parentProject->begin) dao::$errors['begin'] = sprintf($this->lang->project->beginGreateChild, $parentProject->begin);

                    /* When parent set end then child project end cannot greater than parent. */
                    if($parentProject->end != '0000-00-00' and $projects[$projectID]->end > $parentProject->end) dao::$errors['end'] =  sprintf($this->lang->project->endLetterChild, $parentProject->end);

                }
            }
        }

        foreach($projects as $projectID => $project)
        {
            $oldProject = $oldProjects[$projectID];
            $this->dao->update(TABLE_PROJECT)->data($project)
                ->autoCheck($skipFields = 'begin,end')
                ->batchCheck($this->config->project->edit->requiredFields , 'notempty')
                ->checkIF($project->begin != '', 'begin', 'date')
                ->checkIF($project->end != '', 'end', 'date')
                ->checkIF($project->end != '', 'end', 'gt', $project->begin)
                ->check('name', 'unique', "id NOT " . helper::dbIN($data->projectIdList) . " and deleted='0'")
                ->where('id')->eq($projectID)
                ->exec();

            if(dao::isError()) die(js::error('project#' . $projectID . dao::getError(true)));
            if(!dao::isError())
            {
                $linkedProducts = $this->dao->select('product')->from(TABLE_PROJECTPRODUCT)->where('project')->eq($projectID)->fetchPairs();
                $this->updateProductProgram($oldProject->parent, $project->parent, $linkedProducts);

                if($oldProject->parent != $project->parent) $this->processNode($projectID, $project->parent, $oldProject->path, $oldProject->grade);
                /* When acl is open, white list set empty. When acl is private,update user view. */
                if($project->acl == 'open') $this->loadModel('personnel')->updateWhitelist('', 'project', $projectID);
                if($project->acl != 'open') $this->loadModel('user')->updateUserView($projectID, 'project');
            }
            $allChanges[$projectID] = common::createChanges($oldProject, $project);
        }
        return $allChanges;
    }

    /**
     * Update the program of the product.
     *
     * @param  int    $oldProgram
     * @param  int    $newProgram
     * @param  array  $products
     * @access public
     * @return void
     */
    public function updateProductProgram($oldProgram, $newProgram, $products)
    {
        $this->loadModel('action');
        /* Product belonging project set processing. */
        $oldTopProgram = $this->program->getTopByID($oldProgram);
        $newTopProgram = $this->program->getTopByID($newProgram);
        if($oldTopProgram != $newTopProgram)
        {
            foreach($products as $productID => $product)
            {
                $oldProduct = $this->dao->findById($productID)->from(TABLE_PRODUCT)->fetch();
                $this->dao->update(TABLE_PRODUCT)->set('project')->eq((int)$newTopProgram)->where('id')->eq((int)$productID)->exec();
                $newProduct = $this->dao->findById($productID)->from(TABLE_PRODUCT)->fetch();
                $changes    = common::createChanges($oldProduct, $newProduct);
                $actionID   = $this->action->create('product', $productID, 'edited');
                $this->action->logHistory($actionID, $changes);
            }
        }
    }

    /**
     * Print datatable cell.
     *
     * @param  object $col
     * @param  object $project
     * @param  array  $users
     * @param  int    $projectID
     * @access public
     * @return void
     */
    public function printCell($col, $project, $users, $projectID = 0)
    {
        $canOrder     = common::hasPriv('project', 'updateOrder');
        $canBatchEdit = common::hasPriv('project', 'batchEdit');
        $projectLink  = $this->config->systemMode == 'new' ? helper::createLink('project', 'index', "projectID=$project->id", '', '', $project->id) : helper::createLink('project', 'task', "projectID=$project->id");
        $account      = $this->app->user->account;
        $id           = $col->id;

        if($col->show)
        {
            $title = '';
            $class = "c-$id" . (in_array($id, ['budget', 'teamCount']) ? ' c-number' : ' c-name');

            if($id == 'id') $class .= ' cell-id';

            if($id == 'name')
            {
                $class .= ' text-left';
                $title  = "title='{$project->name}'";
            }

            if($id == 'budget')
            {
                $projectBudget = in_array($this->app->getClientLang(), ['zh-cn','zh-tw']) && $project->budget >= 10000 ? number_format($project->budget / 10000, 1) . $this->lang->project->tenThousand : number_format((float)$project->budget, 1);
                $budgetTitle   = $project->budget != 0 ? zget($this->lang->project->currencySymbol, $project->budgetUnit) . ' ' . $projectBudget : $this->lang->project->future;

                $title = "title='$budgetTitle'";
            }

            if($id == 'estimate') $title = "title='{$project->hours->totalEstimate} {$this->lang->execution->workHour}'";
            if($id == 'consume')  $title = "title='{$project->hours->totalConsumed} {$this->lang->execution->workHour}'";
            if($id == 'surplus')  $title = "title='{$project->hours->totalLeft} {$this->lang->execution->workHour}'";

            echo "<td class='$class' $title>";
            switch($id)
            {
                case 'id':
                    if($canBatchEdit)
                    {
                        echo html::checkbox('projectIdList', array($project->id => '')) . html::a($projectLink, sprintf('%03d', $project->id));
                    }
                    else
                    {
                        printf('%03d', $project->id);
                    }
                    break;
                case 'name':
                    echo html::a($projectLink, $project->name);
                    if($project->model === 'waterfall') echo "<span class='project-type-label label label-outline label-warning'>{$this->lang->project->waterfall}</span>";
                    if($project->model === 'scrum')     echo "<span class='project-type-label label label-outline label-info'>{$this->lang->project->scrum}</span>";
                    break;
                case 'PM':
                    $user   = $this->loadModel('user')->getByID($project->PM, 'account');
                    $userID = !empty($user) ? $user->id : '';
                    $PMLink = helper::createLink('user', 'profile', "userID=$userID", '', true);
                    echo empty($project->PM) ? '' : html::a($PMLink, zget($users, $project->PM), '', "data-toggle='modal' data-type='iframe' data-width='600'");
                    break;
                case 'begin':
                    echo $project->begin;
                    break;
                case 'end':
                    echo $project->end == LONG_TIME ? $this->lang->project->longTime : $project->end;
                    break;
                case 'status':
                    echo "<span class='status-task status-{$project->status}'> " . zget($this->lang->project->statusList, $project->status) . "</span>";
                    break;
                case 'budget':
                    echo $budgetTitle;
                    break;
                case 'teamCount':
                    echo $project->teamCount;
                    break;
                case 'estimate':
                    echo $project->hours->totalEstimate . ' ' . $this->lang->execution->workHourUnit;
                    break;
                case 'consume':
                    echo $project->hours->totalConsumed . ' ' . $this->lang->execution->workHourUnit;
                    break;
                case 'surplus':
                    echo $project->hours->totalLeft     . ' ' . $this->lang->execution->workHourUnit;
                    break;
                case 'progress':
                    echo "<div class='progress-pie' data-doughnut-size='80' data-color='#00da88' data-value='{$project->hours->progress}' data-width='24' data-height='24' data-back-color='#e8edf3'><div class='progress-info'>{$project->hours->progress}%</div></div>";
                    break;
                case 'actions':
                    if($project->status == 'wait' || $project->status == 'suspended') common::printIcon('project', 'start', "projectID=$project->id", $project, 'list', 'play', '', 'iframe', true);
                    if($project->status == 'doing') common::printIcon('project', 'close', "projectID=$project->id", $project, 'list', 'off', '', 'iframe', true);
                    if($project->status == 'closed') common::printIcon('project', 'activate', "projectID=$project->id", $project, 'list', 'magic', '', 'iframe', true);

                    if(common::hasPriv('project','suspend') || (common::hasPriv('project','close') && $project->status != 'doing') || (common::hasPriv('project','activate') && $project->status != 'closed'))
                    {
                        echo "<div class='btn-group'>";
                        echo "<button type='button' class='btn icon-caret-down dropdown-toggle' data-toggle='context-dropdown' title='{$this->lang->more}' style='width: 16px; padding-left: 0px; border-radius: 4px;'></button>";
                        echo "<ul class='dropdown-menu pull-right text-center' role='menu' style='position: unset; min-width: auto; padding: 5px 6px;'>";
                        common::printIcon('project', 'suspend', "projectID=$project->id", $project, 'list', 'pause', '', 'iframe btn-action', true);
                        if($project->status != 'doing') common::printIcon('project', 'close', "projectID=$project->id", $project, 'list', 'off', '', 'iframe btn-action', true);
                        if($project->status != 'closed') common::printIcon('project', 'activate', "projectID=$project->id", $project, 'list', 'magic', '', 'iframe btn-action', true);
                        echo "</ul>";
                        echo "</div>";
                    }

                    $from      = $project->from == 'PRJ' ? 'PRJ' : 'pgmproject';
                    $openGroup = $project->from == 'PRJ' ? 'project' : 'project';
                    common::printIcon('project', 'edit', "projectID=$project->id&from=$from", $project, 'list', 'edit', '', '', '', "data-group=$openGroup", '', $project->id);
                    common::printIcon('project', 'manageMembers', "projectID=$project->id", $project, 'list', 'group', '', '', '', '', $this->lang->execution->team, $project->id);
                    if($this->config->systemMode == 'new') common::printIcon('project', 'group', "projectID=$project->id&projectID=$projectID", $project, 'list', 'lock', '', '', '', '', '', $project->id);

                    if(common::hasPriv('project','manageProducts') || common::hasPriv('project','whitelist') || common::hasPriv('project','delete'))
                    {
                        echo "<div class='btn-group'>";
                        echo "<button type='button' class='btn dropdown-toggle' data-toggle='context-dropdown' title='{$this->lang->more}'><i class='icon-more-alt'></i></button>";
                        echo "<ul class='dropdown-menu pull-right text-center' role='menu'>";
                        common::printIcon('project', 'manageProducts', "projectID=$project->id&projectID=$projectID&from=$from", $project, 'list', 'link', '', 'btn-action', '', "data-group=$openGroup", $this->lang->project->manageProducts, $project->id);
                        if($this->config->systemMode == 'new') common::printIcon('project', 'whitelist', "projectID=$project->id&projectID=$projectID&module=project&from=$from", $project, 'list', 'shield-check', '', 'btn-action', '', "data-group=$openGroup", '', $project->id);
                        if(common::hasPriv('project','delete')) echo html::a(inLink("delete", "projectID=$project->id"), "<i class='icon-trash'></i>", 'hiddenwin', "class='btn btn-action' title='{$this->lang->project->delete}'");
                        echo "</ul>";
                        echo "</div>";
                    }
                    break;
            }
            echo '</td>';
        }
    }
}
