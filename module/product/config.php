<?php
$config->product = new stdclass();
$config->product->orderBy = 'isClosed,order_desc';

$config->product->customBatchEditFields = 'line,PO,QD,RD,status,type,acl';
if($config->systemMode == 'new') $config->product->customBatchEditFields = 'program,' . $config->product->customBatchEditFields;

$config->product->browse = new stdclass();
$config->product->custom = new stdclass();
$config->product->custom->batchEditFields = 'line,PO,QD,RD';
if($config->systemMode == 'new') $config->product->custom->batchEditFields .= ',program';

$config->product->list = new stdclass();
$config->product->list->exportFields = 'id,program,line,name,activeRequirements,changedRequirements,draftRequirements,closedRequirements,requireCompleteRate,activeStories,changedStories,draftStories,closedStories,storyCompleteRate,plans,releases,bugs,unResolvedBugs,assignToNullBugs,closedBugs,bugFixedRate';

global $lang, $app;
$app->loadLang('story');
$config->product->search['module']             = 'story';
$config->product->search['fields']['title']    = $lang->story->title;
$config->product->search['fields']['id']       = $lang->story->id;
$config->product->search['fields']['keywords'] = $lang->story->keywords;
$config->product->search['fields']['stage']    = $lang->story->stage;
$config->product->search['fields']['status']   = $lang->story->status;
$config->product->search['fields']['pri']      = $lang->story->pri;

$config->product->search['fields']['product']  = $lang->story->product;
$config->product->search['fields']['branch']   = '';
$config->product->search['fields']['module']   = $lang->story->module;
$config->product->search['fields']['plan']     = $lang->story->plan;
$config->product->search['fields']['estimate'] = $lang->story->estimate;

$config->product->search['fields']['source']     = $lang->story->source;
$config->product->search['fields']['sourceNote'] = $lang->story->sourceNote;
$config->product->search['fields']['fromBug']    = $lang->story->fromBug;

$config->product->search['fields']['openedBy']     = $lang->story->openedBy;
$config->product->search['fields']['reviewedBy']   = $lang->story->reviewedBy;
$config->product->search['fields']['assignedTo']   = $lang->story->assignedTo;
$config->product->search['fields']['closedBy']     = $lang->story->closedBy;
$config->product->search['fields']['lastEditedBy'] = $lang->story->lastEditedBy;

$config->product->search['fields']['mailto']       = $lang->story->mailto;

$config->product->search['fields']['closedReason'] = $lang->story->closedReason;
$config->product->search['fields']['version']      = $lang->story->version;

$config->product->search['fields']['openedDate']     = $lang->story->openedDate;
$config->product->search['fields']['reviewedDate']   = $lang->story->reviewedDate;
$config->product->search['fields']['assignedDate']   = $lang->story->assignedDate;
$config->product->search['fields']['closedDate']     = $lang->story->closedDate;
$config->product->search['fields']['lastEditedDate'] = $lang->story->lastEditedDate;

$config->product->search['params']['title']          = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->product->search['params']['keywords']       = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->product->search['params']['status']         = array('operator' => '=',       'control' => 'select', 'values' => $lang->story->statusList);
$config->product->search['params']['stage']          = array('operator' => '=',       'control' => 'select', 'values' => $lang->story->stageList);
$config->product->search['params']['pri']            = array('operator' => '=',       'control' => 'select', 'values' => $lang->story->priList);

$config->product->search['params']['product']        = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->product->search['params']['branch']         = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->product->search['params']['module']         = array('operator' => 'belong',  'control' => 'select', 'values' => '');
$config->product->search['params']['plan']           = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->product->search['params']['estimate']       = array('operator' => '=',       'control' => 'input',  'values' => '');

$config->product->search['params']['source']         = array('operator' => '=',       'control' => 'select', 'values' => $lang->story->sourceList);
$config->product->search['params']['sourceNote']     = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->product->search['params']['fromBug']        = array('operator' => '=',       'control' => 'input',  'values' => '');

$config->product->search['params']['openedBy']       = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->product->search['params']['reviewedBy']     = array('operator' => 'include', 'control' => 'select', 'values' => 'users');
$config->product->search['params']['assignedTo']     = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->product->search['params']['closedBy']       = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->product->search['params']['lastEditedBy']   = array('operator' => '=',       'control' => 'select', 'values' => 'users');

$config->product->search['params']['mailto']         = array('operator' => 'include', 'control' => 'select', 'values' => 'users');

$config->product->search['params']['closedReason']   = array('operator' => '=',       'control' => 'select', 'values' => $lang->story->reasonList);
$config->product->search['params']['version']        = array('operator' => '>=',      'control' => 'input',  'values' => '');

$config->product->search['params']['openedDate']     = array('operator' => '=', 'control' => 'input', 'values' => '', 'class' => 'date');
$config->product->search['params']['reviewedDate']   = array('operator' => '=', 'control' => 'input', 'values' => '', 'class' => 'date');
$config->product->search['params']['assignedDate']   = array('operator' => '=', 'control' => 'input', 'values' => '', 'class' => 'date');
$config->product->search['params']['closedDate']     = array('operator' => '=', 'control' => 'input', 'values' => '', 'class' => 'date');
$config->product->search['params']['lastEditedDate'] = array('operator' => '=', 'control' => 'input', 'values' => '', 'class' => 'date');

$config->product->create = new stdclass();
$config->product->edit   = new stdclass();
$config->product->create->requiredFields = 'name,code';
$config->product->edit->requiredFields   = 'name,code';

$config->product->editor = new stdclass();
$config->product->editor->create = array('id' => 'desc', 'tools' => 'simpleTools');
$config->product->editor->edit   = array('id' => 'desc', 'tools' => 'simpleTools');
$config->product->editor->close  = array('id' => 'comment', 'tools' => 'simpleTools');
$config->product->editor->view   = array('id' => 'comment,lastComment', 'tools' => 'simpleTools');

$config->product->report = new stdclass();
$config->product->report->stage = array();
$config->product->report->stageLabels[] = 'wait';
$config->product->report->stageLabels[] = 'planed';
$config->product->report->stageLabels[] = 'released';

$config->product->report->planLabels   = array();
$config->product->report->planLabels[] = '';

$config->product->report->projectLabels   = array();
$config->product->report->projectLabels[] = '';

$config->product->report->planLabels   = array();
$config->product->report->planLabels[] = '';

$config->product->statisticFields = array();
$config->product->statisticFields['requirements'] = array('draftRequirements', 'activeRequirements', 'changedRequirements', 'closedRequirements');
$config->product->statisticFields['stories']      = array('draftStories', 'activeStories', 'changedStories', 'closedStories');
$config->product->statisticFields['bugs']         = array('unResolvedBugs', 'closedBugs', 'fixedBugs');
$config->product->statisticFields['plans']        = array('plans');
$config->product->statisticFields['releases']     = array('releases');
