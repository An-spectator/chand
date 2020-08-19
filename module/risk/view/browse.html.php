<?php include "../../common/view/header.html.php"?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toobar pull-left">
    <a href="" class="btn btn-link btn-active-text">
    <span class="text"><?php echo $lang->risk->browse;?></span>
  </div>
  <div class="btn-toolbar pull-right">
    <?php common::printLink('risk', 'batchCreate', "", "<i class='icon icon-plus'></i>" . $lang->risk->batchCreate, '', "class='btn btn-primary'");?>
    <?php common::printLink('risk', 'create', "", "<i class='icon icon-plus'></i>" . $lang->risk->create, '', "class='btn btn-primary'");?>
  </div>
</div>
<div id="mainContent" class="main-table">
<?php if(empty($risks)):?>
  <div class="table-empty-tip">
    <p> 
      <span class="text-muted"><?php echo $lang->noData;?></span>
      <?php if(common::hasPriv('risk', 'create')):?>
      <?php echo html::a($this->createLink('risk', 'create'), "<i class='icon icon-plus'></i> " . $lang->risk->create, '', "class='btn btn-info'");?>
      <?php endif;?>
    </p>
  </div>
  <?php else:?>
  <table class="table has-sort-head" id='riskList'>
    <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
    <thead>
      <tr>
        <th class='text-left w-60px'><?php common::printOrderLink('id', $orderBy, $vars, $lang->risk->id);?></th>
        <th class='text-left'><?php common::printOrderLink('name', $orderBy, $vars, $lang->risk->name);?></th>
        <th class='w-80px'><?php common::printOrderLink('strategy', $orderBy, $vars, $lang->risk->strategy);?></th>
        <th class='w-80px'><?php common::printOrderLink('status', $orderBy, $vars, $lang->risk->status);?></th>
        <th class='w-120px'><?php common::printOrderLink('identifiedDate', $orderBy, $vars, $lang->risk->identifiedDate);?></th>
        <th class='w-80px'><?php common::printOrderLink('riskindex', $orderBy, $vars, $lang->risk->riskindex);?></th>
        <th class='w-80px'><?php common::printOrderLink('pri', $orderBy, $vars, $lang->risk->pri);?></th>
        <th class='w-120px'><?php common::printOrderLink('assignedTo', $orderBy, $vars, $lang->risk->assignedTo);?></th>
        <th class='w-120px'><?php common::printOrderLink('category', $orderBy, $vars, $lang->risk->category);?></th>
        <th class='w-180px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($risks as $risk):?>
      <tr>
        <td><?php echo $risk->id;?></td>
        <td><?php echo html::a($this->createLink('risk', 'view', "riskID=$risk->id"), $risk->name);?></td>
        <td><?php echo zget($lang->risk->strategyList, $risk->strategy);?></td>
        <td><?php echo zget($lang->risk->statusList, $risk->status);?></td>
        <td><?php echo $risk->identifiedDate == '0000-00-00' ? '' : $risk->identifiedDate;?></td>
        <td><?php echo $risk->riskindex;?></td>
        <td><?php echo zget($lang->risk->priList, $risk->pri)?></td>
        <td><?php echo $this->risk->printAssignedHtml($risk, $users);;?></td>
        <td><?php echo zget($lang->risk->categoryList, $risk->category);?></td>
        <td class='c-actions'>
          <?php
          $params = "riskID=$risk->id";
          common::printIcon('risk', 'track', $params, $risk, "list", 'checked');
          common::printIcon('risk', 'close', $params, $risk, "list", '', '', 'iframe', true);
          common::printIcon('risk', 'cancel', $params, $risk, "list", '', '', 'iframe', true);
          common::printIcon('risk', 'hangup', $params, $risk, "list", 'arrow-up', '', 'iframe', true);
          common::printIcon('risk', 'activate', $params, $risk, "list", '', '', 'iframe', true);
          common::printIcon('risk', 'edit', $params, $risk, "list");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <div class='table-footer'>
  <?php $pager->show('right', 'pagerjs');?>
  </div>
  <?php endif;?>
</div>
<?php include "../../common/view/footer.html.php"?>
