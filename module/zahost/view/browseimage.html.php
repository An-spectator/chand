<?php
/**
 * The image browse view file of zahost module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2022 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      xiawenlong <liyuchun@easycorp.ltd>
 * @package     zahost
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php js::set('hostID', $hostID);?>
<?php js::set('downloadLink', $hostID);?>
<div id='mainMenu' class='clearfix'>
  <div class='pull-left btn-toolbar'>
    <?php echo isonlybody() ? ('<span title="' . $lang->zahost->image->browseImage . '">' . $lang->zahost->image->browseImage . '</span>') : html::a($this->createLink('zahost', 'browseimage', "hostID=$hostID"), "<span class='text'>{$lang->zahost->image->browseImage}</span>", '', "class='btn btn-link btn-active-text'");?>
  </div>
</div>
<div id='queryBox' class='cell <?php if($browseType =='bysearch') echo 'show';?>' data-module='vmTemplate'></div>
<div id='mainContent' class='main-table'>
  <?php $vars = "hostID=$hostID&browseType=all&param=0&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
  <?php if(empty($imageList)):?>
  <div class="table-empty-tip">
    <p>
      <span class="text-muted"><?php echo $lang->zahost->image->imageEmpty;?></span>
    </p>
  </div>
  <?php else:?>
  <table class='table has-sort-head table-fixed' id='imageList'>
    <thead>
      <tr>
        <th class='c-name'><?php common::printOrderLink('name', $orderBy, $vars, $lang->zahost->image->name);?></th>
        <th class='c-name'><?php common::printOrderLink('osName', $orderBy, $vars, $lang->zahost->image->os);?></th>
        <th><?php echo $lang->zahost->status;?></th>
        <th><?php echo $lang->zahost->image->path;?></th>
        <th><?php echo $lang->zahost->image->progress;?></th>
        <th class='c-actions-3'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($imageList as $image):?>
      <tr>
        <td title="<?php echo $image->name;?>"><?php echo $image->name;?></td>
        <td><?php echo $image->osName;?></td>
        <td class='image-status-<?php echo zget($image, 'id', 0);?>'><?php echo zget($lang->zahost->image->statusList, $image->status, '');?></td>
        <td><?php echo $image->status == 'completed' ? zget($image, 'path', '') : '';?></td>
        <td class="image-progress-<?php echo zget($image, 'id', 0);?>"><?php echo $image->status == 'completed' ? '100%' : '';?></td>
        <td class='c-actions'>
          <?php if(common::hasPriv('zahost', 'downloadImage')) echo html::a($this->createLink('zahost', 'downloadImage', "hostID={$hostID}&imageName={$image->name}&imageID={$image->id}"), '<i class="icon-download"></i>', 'hiddenwin', zget($image, 'downloadMisc', ''));?>
          <?php if(common::hasPriv('zahost', 'cancelDownload')) echo html::a($this->createLink('zahost', 'cancelDownload', "id={$image->id}"), '<i class="icon-close"></i>', 'hiddenwin', zget($image, 'cancelMisc', ''));?>
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
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
