<?php
class docTest
{
    public function __construct()
    {
         global $tester;
         $this->objectModel = $tester->loadModel('doc');
    }

    /**
     * Function createLib test by doc
     *
     * @param  array $param
     * @access public
     * @return object
     */
    public function createLibTest($param)
    {
        $createFields = array('type' => '', 'name' => '', 'acl' => '');

        foreach($createFields as $field => $defaultValue) $_POST[$field] = $defaultValue;
        foreach($param as $key => $value) $_POST[$key] = $value;
        $objectID = $this->objectModel->createLib();

        unset($_POST);

        if(dao::isError()) return dao::getError();

        $objects = $this->objectModel->getLibById($objectID);

        return $objects;
    }

    /**
     * Function createApiLib test by doc
     *
     * @param  array $param
     * @access public
     * @return object
     */
    public function createApiLibTest($param)
    {
        global $tester;
        $tester->app->loadConfig('api');
        $tester->app->loadLang('doclib');

        $createFields = array('name' => '', 'baseUrl' => '', 'acl' => '', 'desc' => '测试详情');

        foreach($createFields as $field => $defaultValue) $_POST[$field] = $defaultValue;
        foreach($param as $key => $value) $_POST[$key] = $value;
        $objectID = $this->objectModel->createApiLib();

        unset($_POST);

        if(dao::isError()) return dao::getError();

        $objects = $this->objectModel->getLibById($objectID);

        return $objects;
    }

    /**
     * Function updateApiLib test by doc
     *
     * @param  int $id
     * @param  array $param
     * @access public
     * @return void
     */
    public function updateApiLibTest($id, $param)
    {
        global $tester;
        $tester->app->loadConfig('api');
        $tester->app->loadLang('doclib');

        $oldDoc = $this->objectModel->getLibById($id);
        $data = new stdClass;
        foreach($param as $key => $value) $data->$key = $value;

        $objects = $this->objectModel->updateApiLib($id, $oldDoc, $data);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    /**
     * Function updateLib test by doc
     *
     * @param  int $libID
     * @param  array $param
     * @access public
     * @return array
     */
    public function updateLibTest($libID, $param)
    {
        global $tester;
        $tester->app->loadConfig('doc');

        foreach($param as $key => $value) $_POST[$key] = $value;
        $objects = $this->objectModel->updateLib($libID);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    /**
     * Function getDocsByBrowseType test by doc
     *
     * @param  string $browseType
     * @param  array  $moduleID
     * @param  string $sort
     * @param  mixed $pager
     * @access public
     * @return array
     */
    public function getDocsByBrowseTypeTest($browseType, $moduleID, $sort = 'id_desc', $pager = null)
    {
        global $tester;
        $tester->app->loadConfig('doc');

        $objects = $this->objectModel->getDocsByBrowseType($browseType, $queryID = '', $moduleID, $sort, $pager);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    /**
     * Function create test by doc
     *
     * @param  array $param
     * @access public
     * @return array
     */
    public function createTest($param)
    {
        global $tester;
        $tester->app->loadConfig('api');
        $tester->app->loadLang('doclib');

        $labels = array();
        $files  = array();

        $createFields = array('lib' => '', 'module' => '', 'title' => '', 'keywords' => '', 'type' => '', 'content' => '', 'contentMarkdown' => '', 'contentType' => '',
        'url' => '', 'labels' => $labels, 'files' => $files, 'contactListMenu' => '', 'acl' => '');

        foreach($createFields as $field => $defaultValue) $_POST[$field] = $defaultValue;
        foreach($param as $key => $value) $_POST[$key] = $value;

        $this->objectModel->create();

        if(dao::isError()) return dao::getError();

        $objects = $tester->dao->select('*')->from(TABLE_DOC)->where('title')->eq($_POST['title'])->andwhere('lib')->eq($_POST['lib'])->fetchAll();
        unset($_POST);

        return $objects;
    }

    /**
     * Function update test by doc
     *
     * @param  int $docID
     * @param  array $param
     * @access public
     * @return array
     */
    public function updateTest($docID, $param)
    {
        global $tester;
        $tester->app->loadConfig('api');
        $tester->app->loadLang('doclib');

        $labels = array();
        $files  = array();

        $createFields = array('lib' => '', 'module' => '', 'title' => '', 'keywords' => '', 'type' => '', 'content' => '', 'contentType' => '',
        'url' => '', 'labels' => $labels, 'files' => $files, 'contactListMenu' => '', 'acl' => '');

        foreach($createFields as $field => $defaultValue) $_POST[$field] = $defaultValue;
        foreach($param as $key => $value) $_POST[$key] = $value;

        $objects = $this->objectModel->update($docID);

        if(dao::isError()) return dao::getError();

        return $objects["changes"];
    }

    /**
     * Function saveDraft test by doc
     *
     * @param mixed $docID
     * @param array $param
     * @access public
     * @return void
     */
    public function saveDraftTest($docID, $param = array())
    {
        global $tester;
        $tester->app->loadConfig('doc');
        $tester->app->loadConfig('allowedTags');
        $createFields = array('content' => '');

        foreach($createFields as $field => $defaultValue) $_POST[$field] = $defaultValue;
        foreach($param as $key => $value) $_POST[$key] = $value;

        $this->objectModel->saveDraft($docID);

        if(dao::isError()) return dao::getError();

        $objects = $tester->dao->select('id,draft')->from(TABLE_DOC)->where('id')->eq($docID)->fetchAll('id');
        unset($_POST);

        return $objects;
    }

    public function extractKETableCSSTest($content)
    {
        $objects = $this->objectModel->extractKETableCSS($content);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function checkPrivLibTest($object, $extra = '')
    {
        $objects = $this->objectModel->checkPrivLib($object, $extra = '');

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function checkPrivDocTest($object)
    {
        $objects = $this->objectModel->checkPrivDoc($object);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getAllLibsByTypeTest($type, $pager = null, $product = '')
    {
        $objects = $this->objectModel->getAllLibsByType($type, $pager = null, $product = '');

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getAllLibGroupsTest($appendLibs = '')
    {
        $objects = $this->objectModel->getAllLibGroups($appendLibs = '');

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getLimitLibsTest($type, $limit = 0)
    {
        $objects = $this->objectModel->getLimitLibs($type, $limit = 0);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getSubLibGroupsTest($type, $idList)
    {
        $objects = $this->objectModel->getSubLibGroups($type, $idList);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getLibsByObjectTest($type, $objectID, $mode = '', $appendLib = 0)
    {
        $objects = $this->objectModel->getLibsByObject($type, $objectID, $mode = '', $appendLib = 0);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getOrderedObjectsTest($objectType = 'product')
    {
        $objects = $this->objectModel->getOrderedObjects($objectType = 'product');

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function statLibCountsTest($idList)
    {
        $objects = $this->objectModel->statLibCounts($idList);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getLibFilesTest($type, $objectID, $orderBy, $pager = null)
    {
        $objects = $this->objectModel->getLibFiles($type, $objectID, $orderBy, $pager = null);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getFileSourcePairsTest($files)
    {
        $objects = $this->objectModel->getFileSourcePairs($files);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getFileIconTest($files)
    {
        $objects = $this->objectModel->getFileIcon($files);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getDocTreeTest($libID)
    {
        $objects = $this->objectModel->getDocTree($libID);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function fillDocsInTreeTest($node, $libID)
    {
        $objects = $this->objectModel->fillDocsInTree($node, $libID);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getProductCrumbTest($productID, $executionID = 0)
    {
        $objects = $this->objectModel->getProductCrumb($productID, $executionID = 0);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function setLibUsersTest($type, $objectID)
    {
        $objects = $this->objectModel->setLibUsers($type, $objectID);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getLibIdListByProjectTest($projectID = 0)
    {
        $objects = $this->objectModel->getLibIdListByProject($projectID);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getStatisticInfoTest()
    {
        $objects = $this->objectModel->getStatisticInfo();

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getPreAndNextDocTest($docID, $libID)
    {
        $objects = $this->objectModel->getPreAndNextDoc($docID, $libID);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function printChildModuleTest($module, $libID, $methodName, $browseType, $moduleID)
    {
        $objects = $this->objectModel->printChildModule($module, $libID, $methodName, $browseType, $moduleID);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function buildCrumbTitleTest($libID = 0, $param = 0, $title = '')
    {
        $objects = $this->objectModel->buildCrumbTitle($libID = 0, $param = 0, $title = '');

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function buildCreateButton4DocTest($objectType, $objectID, $libID)
    {
        $objects = $this->objectModel->buildCreateButton4Doc($objectType, $objectID, $libID);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function buildCollectButton4DocTest()
    {
        $objects = $this->objectModel->buildCollectButton4Doc();

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function buildBrowseSwitchTest($type, $objectID, $viewType)
    {
        $objects = $this->objectModel->buildBrowseSwitch($type, $objectID, $viewType);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function setFastMenuTest($fastLib)
    {
        $objects = $this->objectModel->setFastMenu($fastLib);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getToAndCcListTest($doc)
    {
        $objects = $this->objectModel->getToAndCcList($doc);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function selectTest($type, $objects, $objectID, $libs, $libID = 0)
    {
        $objects = $this->objectModel->select($type, $objects, $objectID, $libs, $libID = 0);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getApiModuleTreeTest($rootID, $docID = 0, $release = 0)
    {
        $objects = $this->objectModel->getApiModuleTree($rootID, $docID = 0, $release = 0);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function getTreeMenuTest($type, $objectID, $rootID, $startModule = 0, $docID = 0)
    {
        $objects = $this->objectModel->getTreeMenu($type, $objectID, $rootID, $startModule = 0, $docID = 0);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function summaryTest($files)
    {
        $objects = $this->objectModel->summary($files);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function setMenuByTypeTest($type, $objectID, $libID, $appendLib = 0)
    {
        $objects = $this->objectModel->setMenuByType($type, $objectID, $libID, $appendLib = 0);

        if(dao::isError()) return dao::getError();

        return $objects;
    }

    public function checkAutoloadPageTest($doc)
    {
        $objects = $this->objectModel->checkAutoloadPage($doc);

        if(dao::isError()) return dao::getError();

        return $objects;
    }
}
