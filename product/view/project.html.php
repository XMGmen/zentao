<?php
/**
 * The html template file of index method of index module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id: index.html.php 2343 2011-11-21 05:24:56Z wwccss $
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/sparkline.html.php';?>
<?php include '../../common/view/sortable.html.php';?>
<?php js::set('confirmDelete', $lang->project->confirmDelete)?>
<!-- <div class='product_select'>
  <ul> 
    <?php echo "<li>" . html::select('product', $products, $productID, "class='' onchange='byProduct(this.value, $productID)'") . '</li>';?>
    <?php echo "<li>" . html::a(helper::createLink($moduleName, "index", "locate=no&productID="), "查看所有产品") . '</li>';?>

  </ul>
</div> -->

<div id='featurebar'>
  <div class='actions'>
    <?php echo html::a($this->createLink('project', 'create'), "<i class='icon-plus'></i> " . $lang->project->create,'', "class='btn'") ?>
  </div>
  <ul class='nav'>
    <?php echo "<li id='undoneTab'>" . "该产品下的所有项目" . '</li>';?>
  

  </ul>
</div>
<!-- <?php $canOrder = (common::hasPriv('project', 'updateOrder') and strpos($orderBy, 'order') !== false)?> -->
<form class='form-condensed' method='post' action='<?php echo inLink('batchEdit', "projectID=$projectID");?>'>
<table class='table table-condensed table-hover table-striped tablesorter table-fixed' id='projectList'>
  <?php $vars = "status=$status&projectID=$projectID&orderBy=%s&productID=$productID&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";?>
  <thead>
    <tr class='colhead'> 
      <th class='w-id'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th> 
      <th class='w-150px'><?php common::printOrderLink('name', $orderBy, $vars, $lang->project->name);?></th>       
      <th class='w-300px {sorter:false}'><?php echo $lang->project->desc;?></th>     
      <th class='w-90px'><?php common::printOrderLink('begin', $orderBy, $vars, $lang->project->begin);?></th>       
      <th class='w-90px'><?php common::printOrderLink('end', $orderBy, $vars, $lang->project->end);?></th> 
      <th class='w-status'><?php common::printOrderLink('status', $orderBy, $vars, $lang->project->status);?></th>
      <th class='w-80px {sorter:false}'><?php echo $lang->actions;?></th> 
    </tr>
  </thead>

  <?php $canBatchEdit = common::hasPriv('project', 'batchEdit'); ?>
  <tbody class='sortable' id='projectTableList'>
  <?php foreach($projectStats as $project):?>
  <tr class='text-center' data-id='<?php echo $project->id ?>' data-order='<?php echo $project->order ?>'>
    <td>
      <!-- <?php echo html::a($this->createLink('project', 'view', 'project=' . $project->id), sprintf('%03d', $project->id));?> -->
      <?php echo html::a($this->createLink('product', 'viewprojects', 'project=' . $project->id), sprintf('%03d', $project->id));?>
    </td>
    <td title='<?php echo $project->name?>'><?php echo html::a($this->createLink('product', 'viewprojects', 'project=' . $project->id), $project->name);?></td>
    <td><?php echo $project->desc;?></td>
    <td><?php echo $project->begin;?></td>
    <td><?php echo $project->end;?></td>
    <td><?php echo $lang->project->statusList[$project->status];?></td>
    <td class='text-right'> 
        <?php  
        common::printIcon('project', 'finish', "id=$project->id", $project, 'list', 'ok-sign', 'hiddenwin'); 
        common::printIcon('project', 'edit',   "id=$project->id", '', 'list', 'pencil', '', 'iframe', true); 
 
        if(common::hasPriv('project', 'delete')) 
        { 
            $deleteURL = $this->createLink('project', 'delete', "projectID=$project->id&confirm=yes"); 
            echo html::a("javascript:ajaxDelete(\"$deleteURL\",\"projectList\",confirmDelete)", '<i class="icon-remove"></i>', '', "class='btn-icon' title='{$lang->project->delete}'"); 
        } 
        ?> 
        
  </tr>
  <?php endforeach;?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan='<?php echo $canOrder ? 12 : 11?>'>
        <div class='text-right'><?php $pager->show();?></div>
      </td>
    </tr>
  </tfoot>
</table>
</form>
<script>$("#<?php echo $status;?>Tab").addClass('active');</script>
<?php js::set('listName', 'projectList')?>
<?php js::set('orderBy', $orderBy)?>
<?php include '../../common/view/footer.html.php';?>
