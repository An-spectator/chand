<?php
/**
 * The manage view file of branch module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Qiyu Xie <xieqiyu@easycorp.ltd>
 * @package     branch
 * @version     $Id$
 * @link        https://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/sortable.html.php';?>
<?php js::set('orderBy', $orderBy)?>
<?php $canCreate      = common::hasPriv('branch', 'create');?>
<?php $canOrder       = common::hasPriv('branch', 'sort');?>
<?php $canBatchEdit   = common::hasPriv('branch', 'batchEdit');?>
<?php $canMergeBranch = common::hasPriv('branch', 'mergeBranch');?>
<?php $canBatchAction = ($canBatchEdit or $canMergeBranch);?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <?php foreach(customModel::getFeatureMenu($this->moduleName, $this->methodName) as $menuItem):?>
    <?php if(isset($menuItem->hidden)) continue;?>
    <?php $label  = "<span class='text'>{$menuItem->text}</span>";?>
    <?php $label .= $menuItem->name == $browseType ? " <span class='label label-light label-badge'>{$pager->recTotal}</span>" : '';?>
    <?php $active = $menuItem->name == $browseType ? 'btn-active-text' : '';?>
    <?php echo html::a($this->inlink('manage', "productID=$productID&browseType={$menuItem->name}&orderBy=$orderBy&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"), $label, '', "class='btn btn-link $active' id='{$menuItem->name}'");?>
    <?php endforeach;?>
  </div>
  <div class="btn-toolbar pull-right">
    <?php if($canCreate) common::printLink('branch', 'create', "productID=$productID", "<i class='icon icon-plus'></i> " . sprintf($lang->branch->create, $lang->product->branchName[$product->type]), '', "class='btn btn-primary iframe'", true, true);?>
  </div>
</div>
<div id="mainContent">
  <?php if(empty($branchList)):?>
  <div class="table-empty-tip">
    <p>
      <span class="text-muted"><?php echo $lang->branch->noData;?></span>
      <?php if($canCreate) echo html::a($this->createLink('branch', 'create', "productID=$productID", '', true), "<i class='icon icon-plus'></i> " . sprintf($lang->branch->create, $lang->product->branchName[$product->type]), '', "class='btn btn-info iframe'");?>
    </p>
  </div>
  <?php else:?>
  <form class='main-table' data-ride='table' method='post' id='branchForm'>
    <table id="branchList" class="table has-sort-head">
      <thead>
        <tr>
          <?php $vars = "productID=$productID&browseType=$browseType&orderBy=%s&recTotal=$pager->recTotal&recPerPage=$pager->recPerPage&pageID=$pager->pageID"; ?>
          <?php if($canBatchAction):?>
          <th class='c-check'>
            <div class="checkbox-primary check-all" title="<?php echo $lang->selectAll?>"><label></label></div>
          </th>
          <?php endif;?>
          <?php if($canOrder):?>
          <th class='c-order sort-default'><?php echo $lang->branch->order;?></th>
          <?php endif;?>
          <th class='text-left'><?php common::printOrderLink('name', $orderBy, $vars, sprintf($lang->branch->name, $lang->product->branchName[$product->type]));?></th>
          <th class='c-status'><?php common::printOrderLink('status', $orderBy, $vars, $lang->branch->status);?></th>
          <th class='c-date'><?php common::printOrderLink('createdDate', $orderBy, $vars, $lang->branch->createdDate);?></th>
          <th class='c-date'><?php common::printOrderLink('closedDate', $orderBy, $vars, $lang->branch->closedDate);?></th>
          <th class='c-desc'><?php echo sprintf($lang->branch->desc, $lang->product->branchName[$product->type]);?></th>
          <th class='c-actions-2'><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody id='branchTableList'>
        <?php foreach($branchList as $branch):?>
        <?php $isMain = $branch->id == BRANCH_MAIN;?>
        <tr data-id='<?php echo $branch->id;?>'>
          <?php if($canBatchAction):?>
          <td class='cell-id'>
            <?php echo html::checkbox('branchIDList', array($branch->id => ''));?>
          </td>
          <?php endif;?>
          <?php if($canOrder):?>
          <td class='c-actions <?php echo $isMain ? '' : 'sort-handler';?>'>
            <?php echo $isMain ? '' : '<i class="icon icon-move"></i>';?>
          </td>
          <?php endif;?>
          <td class='c-name flex' title='<?php echo $branch->name;?>'>
            <span class="text-ellipsis"><?php echo $branch->name;?>&nbsp;</span>
            <?php
            if($branch->default)
            {
                echo '<span class="label label-primary label-badge">' . $lang->branch->default . '</span>';
            }
            elseif($branch->status == 'active')
            {
                $setDefaultLink = helper::createLink('branch', 'setDefault', "productID=$productID&branchID=$branch->id", '', true);
                $setDefaultHtml = html::a($setDefaultLink, "<span><i class='icon icon-hand-right'></i> {$lang->branch->setDefault}</span>", 'hiddenwin', "class='btn btn-icon-left btn-sm setDefault hidden'");

                echo common::hasPriv('branch', 'setDefault') ? $setDefaultHtml : '';
            }
            ?>
          </td>
          <td><?php echo zget($lang->branch->statusList, $branch->status);?></td>
          <td><?php echo helper::isZeroDate($branch->createdDate) ? '' : $branch->createdDate;?></td>
          <td><?php echo helper::isZeroDate($branch->closedDate) ? '' : $branch->closedDate;?></td>
          <td class='c-name' title='<?php echo $branch->desc;?>'><?php echo $branch->desc;?></td>
          <td class='c-actions'>
          <?php
            $disabled = $isMain ? 'disabled' : '';
            common::printIcon('branch', 'edit', "branchID=$branch->id&productID=$productID", $branch, 'list', '', '', "$disabled iframe", true);
            if($branch->status == 'active')
            {
                common::printIcon('branch', 'close', "branchID=$branch->id", $branch, 'list', 'off', 'hiddenwin', $disabled);
            }
            else
            {
                common::printIcon('branch', 'activate', "branchID=$branch->id", $branch, 'list', 'active', 'hiddenwin', $disabled);
            }
          ?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <div class="table-footer">
      <?php if($canBatchAction):?>
      <div class="checkbox-primary check-all">
        <label><?php echo $lang->selectAll?></label>
      </div>
      <?php if($canBatchEdit):?>
      <div class="table-actions btn-toolbar">
        <?php
        $batchEditLink = $this->createLink('branch', 'batchEdit', "productID=$productID");
        echo html::submitButton($lang->edit, "data-form-action='$batchEditLink'", 'btn');
        ?>
      </div>
      <?php endif;?>
      <?php endif;?>
      <?php $pager->show('right', 'pagerjs');?>
    </div>
  </form>
  <?php endif;?>
</div>
<?php include '../../common/view/footer.html.php';?>
