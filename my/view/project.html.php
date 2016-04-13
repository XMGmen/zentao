<?php
/**
 * The project view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: project.html.php 5095 2013-07-11 06:03:40Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/sparkline.html.php';?>
<?php include '../../common/view/sorter.html.php';?>
<?php js::set('confirmDelete', $lang->project->confirmDelete)?>

<div id='featurebar'>
  <ul class='heading'><i class='icon-folder-open-alt'></i> <?php echo $lang->my->myProject;?></ul>
  <div class='hidden'>
    <?php echo html::a(helper::createLink('project', 'create'), "<i class='icon-plus'></i> " . $lang->my->home->createProject, '', "class='btn'") ?>
  </div>
</div>
<div id="tablestyle">
<form method='post' id='myProjectForm'>
<table class='table' id='projectList'>
<!-- <table class='table table-condensed table-hover table-striped tablesorter table-fixed' id='projectList'> -->
 <?php $vars = "type=$type&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
  <thead>
  <tr class='text-center'>
    <th class='w-id'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
    <th class='w-160px'><?php common::printOrderLink('code', $orderBy, $vars,$lang->project->code);?></th>
    <th><?php common::printOrderLink('name', $orderBy, $vars, $lang->project->name);?></th>
    <th class='w-date'><?php common::printOrderLink( 'begin', $orderBy, $vars, $lang->project->begin);?></th>
    <th class='w-date'><?php common::printOrderLink( 'end',    $orderBy, $vars, $lang->project->end);?></th>
    <th class='w-status'><?php common::printOrderLink('status', $orderBy, $vars, $lang->statusAB);?></th>
    <!-- <th class='w-user'><?php common::printOrderLink( 'user',   $orderBy,   $vars, $lang->team->role);?></th> -->
    <th class='w-date'><?php common::printOrderLink( 'date',   $orderBy,   $vars, $lang->team->join);?></th>
    <th class='w-110px'><?php common::printOrderLink('hours', $orderBy, $vars, $lang->team->hours);?></th>
    <th class='w-80px {sorter:false}'><?php echo $lang->actions;?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($projects as $project):?>
  <?php $projectLink = $this->createLink('sprint', 'index', "projectID=$project->id");?>
  <tr class='text-center'>
    <td><?php echo html::a($projectLink, $project->id);?></td>
    <td class='text-center'><?php echo $project->code;?></td>
    <td class='text-center'><?php echo html::a($projectLink, $project->name);?></td>
    <td><?php echo $project->begin;?></td>
    <td><?php echo $project->end;?></td>
    <td class='project-<?php echo $project->status?>'><?php echo $lang->project->statusList[$project->status];?></td>
    <!-- <td><?php echo $project->role;?></td> -->
    <td><?php echo $project->join;?></td>
    <td><?php echo $project->hours;?></td>
    <td class='text-right'>
        <?php 
        common::printIcon('project', 'finish', "id=$project->id", $project, 'list', 'ok-sign', 'hiddenwin');
        common::printIcon('pro', 'sprintedit',   "id=$project->id", '', 'list', 'pencil', '', 'iframe', true);

        if(common::hasPriv('project', 'delete'))
        {

            $deleteURL = $this->createLink('project', 'delete', "projectID=$project->id&confirm=yes");
            
            echo html::a("javascript:ajaxDelete(\"$deleteURL\",\"projectList\",confirmDelete)", '<i class="icon-remove"></i>', '', "class='btn-icon' title='{$lang->project->delete}'");
        }
        ?>
      </td>
  </tr>
  <?php endforeach;?>
  </tbody>
  <tfoot> 
      <tr> 
        <td colspan='10'>    
          <?php $pager->show();?> 
        </td> 
      </tr> 
    </tfoot>
</table> 
</form>
</div>
<script>$("#<?php echo $status;?>Tab").addClass('active');</script>
<?php js::set('listName', 'projectList')?>
<?php js::set('orderBy', $orderBy)?>
<?php include '../../common/view/footer.html.php';?>
