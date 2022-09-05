<?php if(!empty($task) and !empty($task->team) and $task->mode == 'linear'):?>
<style>
#linearefforts .nav-tabs{margin-bottom:20px;}
#linearefforts div.caption {height:25px; margin:10px 0px;}
#linearefforts div.caption .account{font-weight: bolder;}
</style>
<?php
$this->app->loadLang('execution');
$teamOrders = array();
foreach($task->team as $team) $teamOrders[$team->order] = $team->account;

$myOrders   = array();
$allEfforts = array();
$recorders   = array();
foreach($efforts as $effort)
{
    $order   = $effort->order;
    $account = $effort->account;
    $allEfforts[$order][] = $effort;
    $recorders[$order][$account] = $account;
    if($app->user->account == $account) $myOrders[$order] = $order;
}
?>
<?php if($myOrders):?>
<div class='tabs' id='linearefforts'>
  <ul class='nav nav-tabs'>
    <li class='active'><a href='#legendMyEffort' data-toggle='tab'><?php echo $lang->task->myEffort;?></a></li>
    <li><a href='#legendAllEffort' data-toggle='tab'><?php echo $lang->task->allEffort;?></a></li>
  </ul>
  <div class='tab-content'>
    <div class='tab-pane active' id='legendMyEffort'>
      <?php foreach($myOrders as $order):?>
      <div class='caption'>
        <span class='label label-badge'><?php echo $order + 1;?></span>
        <span class='account'><?php echo zget($users, $app->user->account);?></span>
      </div>
      <table class='table table-bordered table-fixed table-recorded'>
        <thead>
          <tr class='text-center'>
            <th class="w-120px"><?php echo $lang->task->date;?></th>
            <th class="w-120px"><?php echo $lang->task->recordedBy;?></th>
            <th><?php echo $lang->comment;?></th>
            <th class="thWidth"><?php echo $lang->task->consumed;?></th>
            <th class="thWidth"><?php echo $lang->task->left;?></th>
            <th class='c-actions-2'><?php echo $lang->actions;?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($allEfforts[$order] as $effort):?>
          <tr class="text-center">
            <td><?php echo $effort->date;?></td>
            <td><?php echo zget($users, $effort->account);?></td>
            <td class="text-left" title="<?php echo $effort->work;?>"><?php echo $effort->work;?></td>
            <td title="<?php echo $effort->consumed . ' ' . $lang->execution->workHour;?>"><?php echo $effort->consumed . ' ' . $lang->execution->workHourUnit;?></td>
            <td title="<?php echo $effort->left     . ' ' . $lang->execution->workHour;?>"><?php echo $effort->left     . ' ' . $lang->execution->workHourUnit;?></td>
            <td align='center' class='c-actions'>
              <?php
              $canOperateEffort = $this->task->canOperateEffort($task, $effort);
              common::printIcon($this->config->edition == 'open' ? 'task' : 'effort', $this->config->edition == 'open' ? 'editEstimate' : 'edit', "effortID=$effort->id", '', 'list', 'edit', '', 'showinonlybody', true, $canOperateEffort ? '' : 'disabled');
              common::printIcon($this->config->edition == 'open' ? 'task' : 'effort', $this->config->edition == 'open' ? 'deleteEstimate' : 'delete', "effortID=$effort->id", '', 'list', 'trash', 'hiddenwin', 'showinonlybody', false, ($canOperateEffort and $effort->left > 0) ? '' : 'disabled');
              ?>
            </td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
      <?php endforeach;?>
    </div>
    <div class='tab-pane' id='legendAllEffort'>
<?php endif;?>
      <?php foreach($recorders as $order => $accounts):?>
      <div class='caption'>
        <span class='label label-badge'><?php echo $order + 1;?></span>
        <span class='account'><?php foreach($accounts as $account) echo zget($users, $account) . ' ';?></span>
      </div>
      <table class='table table-bordered table-fixed table-recorded'>
        <thead>
          <tr class='text-center'>
            <th class="w-120px"><?php echo $lang->task->date;?></th>
            <th class="w-120px"><?php echo $lang->task->recordedBy;?></th>
            <th><?php echo $lang->comment;?></th>
            <th class="thWidth"><?php echo $lang->task->consumed;?></th>
            <th class="thWidth"><?php echo $lang->task->left;?></th>
            <th class='c-actions-2'><?php echo $lang->actions;?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($allEfforts[$order] as $effort):?>
          <tr class="text-center">
            <td><?php echo $effort->date;?></td>
            <td><?php echo zget($users, $effort->account);?></td>
            <td class="text-left" title="<?php echo $effort->work;?>"><?php echo $effort->work;?></td>
            <td title="<?php echo $effort->consumed . ' ' . $lang->execution->workHour;?>"><?php echo $effort->consumed . ' ' . $lang->execution->workHourUnit;?></td>
            <td title="<?php echo $effort->left     . ' ' . $lang->execution->workHour;?>"><?php echo $effort->left     . ' ' . $lang->execution->workHourUnit;?></td>
            <td align='center' class='c-actions'>
              <?php
              $canOperateEffort = $this->task->canOperateEffort($task, $effort);
              common::printIcon($this->config->edition == 'open' ? 'task' : 'effort', $this->config->edition == 'open' ? 'editEstimate' : 'edit', "effortID=$effort->id", '', 'list', 'edit', '', 'showinonlybody', true, $canOperateEffort ? '' : 'disabled');
              common::printIcon($this->config->edition == 'open' ? 'task' : 'effort', $this->config->edition == 'open' ? 'deleteEstimate' : 'delete', "effortID=$effort->id", '', 'list', 'trash', 'hiddenwin', 'showinonlybody', false, ($canOperateEffort and $effort->left > 0) ? '' : 'disabled');
              ?>
            </td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
      <?php endforeach;?>
<?php if($myOrders):?>
    </div>
  </div>
</div>
<?php endif;?>
<?php endif;?>