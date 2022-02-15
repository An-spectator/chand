<?php
/**
 * The html template file of importNotice method of convert module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     convert
 * @version     $Id: execute.html.php 4129 2013-01-18 01:58:14Z wwccss $
 */
?>
<?php include '../../common/view/header.html.php';?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <?php echo html::a("javascript::void(0);", "<span class='text'>" . $lang->convert->jira->mapJira2Zentao . '</span>', '', "class='btn btn-link btn-active-text'");?>
  </div>
</div>
<div id='mainContent' class='main-content'>
  <form class='main-form form-ajax' method='post'>
    <div class='main-header text-center'>
      <ul class='nav nav-primary'>
        <?php foreach($lang->convert->jira->steps as $key => $label):?>
        <?php $active = $step == $key ? 'class="active"' : '';?>
        <li <?php echo $active;?>>
          <a><?php echo $label;?></a>
        </li>
        <?php endforeach;?>
      </ul>
      <div class='btn-toolbar pull-right'>
        <?php echo html::submitButton($lang->convert->jira->next);?>
      </div>
    </div>
    <?php if($step == 1):?>
    <table class='table table-form'>
      <thead>
        <tr class='text-center'>
          <th><?php echo $lang->convert->jira->jiraObject;?></th>
          <th><?php echo $lang->convert->jira->zentaoObject;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($issueTypeList as $id => $issueType):?>
        <?php $value = $method == 'db' ? $issueType->pname : $issueType['name'];?>
        <tr>
          <td><?php echo html::select('jiraObject[]', array($id => $value), $id, "class='form-control chosen'");?></td>
          <td><?php echo html::select('zentaoObject[]', $lang->convert->jira->zentaoObjectList, '', "class='form-control chosen'");?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <hr />
    <?php endif;?>
    <?php if($step == 2):?>
    <table class='table table-form'>
      <thead>
        <tr class='text-center'>
          <th><?php echo $lang->convert->jira->jiraLinkType;?></th>
          <th><?php echo $lang->convert->jira->zentaoLinkType;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($linkTypeList as $id => $linkType):?>
        <?php $value = $method == 'db' ? $linkType->linkname : $linkType['linkname'];?>
        <tr>
          <td><?php echo html::select('jiraLinkType[]', array($id => $value), $id, "class='form-control chosen'");?></td>
          <td><?php echo html::select('zentaoLinkType[]', $lang->convert->jira->zentaoLinkTypeList, '', "class='form-control chosen'");?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <hr />
    <?php endif;?>
    <?php if($step == 3):?>
    <table class='table table-form'>
      <thead>
        <tr class='text-center'>
          <th><?php echo $lang->convert->jira->jiraResolution;?></th>
          <th><?php echo $lang->convert->jira->zentaoResolution;?></th>
          <th><?php echo $lang->convert->jira->zentaoReason;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($resolutionList as $id => $resolution):?>
        <?php $value = $method == 'db' ? $resolution->pname : $resolution['name'];?>
        <tr>
          <td><?php echo html::select('jiraResolution[]', array($id => $value), $id, "class='form-control chosen'");?></td>
          <td><?php echo html::select('zentaoResolution[]', $lang->bug->resolutionList, '', "class='form-control chosen'");?></td>
          <td><?php echo html::select('zentaoReason[]', $lang->story->reasonList, '', "class='form-control chosen'");?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <hr />
    <?php endif;?>
    <?php if($step == 4):?>
    <table class='table table-form'>
      <thead>
        <tr class='text-center'>
          <th><?php echo $lang->convert->jira->jiraStatus;?></th>
          <th><?php echo $lang->convert->jira->storyStatus;?></th>
          <th><?php echo $lang->convert->jira->storyStage;?></th>
          <th><?php echo $lang->convert->jira->taskStatus;?></th>
          <th><?php echo $lang->convert->jira->bugStatus;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($statusList as $id => $status):?>
        <?php $value = $method == 'db' ? $status->pname : $status['name'];?>
        <tr>
          <td><?php echo html::select('jiraStatus[]', array($id => $value), $id, "class='form-control chosen'");?></td>
          <td><?php echo html::select('storyStatus[]', $lang->story->statusList, '', "class='form-control chosen'");?></td>
          <td><?php echo html::select('storyStage[]', $lang->story->stageList, '', "class='form-control chosen'");?></td>
          <td><?php echo html::select('taskStatus[]', $lang->task->statusList, '', "class='form-control chosen'");?></td>
          <td><?php echo html::select('bugStatus[]', $lang->bug->statusList, '', "class='form-control chosen'");?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <?php endif;?>
  </form>
</div>
