<?php
include '../../common/view/chosen.html.php';
include '../../common/view/header.html.php';
//include 'validation.html.php';
?>
<div id='titlebar'>
  <div class="heading">
  <?php
    echo html::select('pro', $productplans, $planID, "class='selectbox' onchange='byPro(this.value)'");
  ?>
  </div>
</div>
<div class="tabsbar">
  <ul id="myTab" class="nav nav-tabs">
    <li id="indexid">
    	<?php echo html::a($this->createLink('pro', 'index', "planID=$planID"),"Sprint");?>
    </li>
    <li id="backlogid">
    <?php echo html::a($this->createLink('pro', 'backlog', "planID=$planID"),"Back Log");?>
    </li>
    <li id="bugid" class="active">
    <?php echo html::a($this->createLink('pro', 'bug', "planID=$planID"),"Bug");?>
    </li>
    <li id="teamid">
    <?php echo html::a($this->createLink('pro', 'team', "planID=$planID"),"团队");?>
    </li>
  </ul>
</div>
    
<div id='featurebar'>
  <div class='heading' >
    <?php echo html::icon($lang->icons['bug']);?> <?php echo $lang->project->bug;?>
  </div>
  <div class='actions'>
  <div class='btn-group'>
    <?php common::printIcon('bug', 'create', "productID=0&extra=projectID=0&planIDplus=$planID&projectIDplus=0");?>
    <?php common::printIcon('bug', 'export', "productID=0&planID=$planID&sprintID=0&orderBy=id_desc", '', 'button', '', '', 'export');?>
    <?php common::printIcon('importbugs', 'upload', "productID=$productID&planID=$planID&sprintID=0",'','button','','','export');?>
    <div class='excelTemplate'><?php echo html::a($downloadLink, $downloadExcel);?></div>
  </div>
  </div>
</div>
<div id="tablestyle">
<form method='post' id='projectBugForm'>
  <table class='table table-condensed table-hover table-striped tablesorter table-fixed' id='bugList' style="margin:0">
    <thead>
      <tr>
         <?php $vars = "planID=$planID&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
        <th class='w-id'> <?php common::printOrderLink('id',           $orderBy, $vars, $lang->idAB);?></th>
        <th class='w-severity'> <?php common::printOrderLink('severity',     $orderBy, $vars, $lang->bug->severityAB);?></th>
        <th class='w-pri'>      <?php common::printOrderLink('pri',          $orderBy, $vars, $lang->priAB);?></th>
        <th >                   <?php common::printOrderLink('title',        $orderBy, $vars, $lang->bug->title);?></th>
        <th >                   <?php common::printOrderLink('project',      $orderBy, $vars, '所属sprint');?></th>
        <th class='w-user'>     <?php common::printOrderLink('openedBy',     $orderBy, $vars, $lang->openedByAB);?></th>
        <th class='w-user'>     <?php common::printOrderLink('assignedTo',   $orderBy, $vars, $lang->assignedToAB);?></th>
        <th class='w-user'>     <?php common::printOrderLink('resolvedBy',   $orderBy, $vars, $lang->bug->resolvedBy);?></th>
        <th class='w-resolution'><?php common::printOrderLink('resolution', $orderBy, $vars, $lang->bug->resolutionAB);?></th>
        <th class='w-140px {sorter:false}'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($bugs as $bug):?>
    <tr class='text-center'>
      <td>
        <input type='checkbox' name='bugIDList[]'  value='<?php echo $bug->id;?>'/> 
        <?php echo html::a($this->createLink('pro', 'bugview', "planID=$planID&bugID=$bug->id"), sprintf('%03d', $bug->id));?>
      </td>
      <td><span class='<?php echo 'severity' . zget($lang->bug->severityList2, $bug->severity, $bug->severity)?>'><?php echo zget($lang->bug->severityList2, $bug->severity, $bug->severity)?></span></td>
      <td><span class='<?php echo 'pri' . zget($lang->bug->priList, $bug->pri, $bug->pri)?>'><?php echo zget($lang->bug->priList, $bug->pri, $bug->pri)?></span></td>
      <td class='text-left' title="<?php echo $bug->title?>"><?php echo html::a($this->createLink('pro', 'bugview', "planID=$planID&bugID=$bug->id"), $bug->title);?></td>
      <td><?php echo current($sprintPairsArray[$bug->id]);?></td>
      <td><?php echo zget($users, $bug->openedBy, $bug->openedBy);?></td>
      <td <?php if($bug->assignedTo == $this->app->user->account){ echo " style='color:red'";}?>><?php echo zget($users, $bug->assignedTo, $bug->assignedTo);?></td>
      <td><?php echo zget($users, $bug->resolvedBy, $bug->resolvedBy);?></td>
      <td class='w-180px'> <?php echo $lang->bug->resolutionList[$bug->resolution];?></td>
      <td class='text-right'>
        <?php
        $params = "bugID=$bug->id";
        common::printIcon('bug', 'confirmBug', $params, $bug, 'list', 'search', '', 'iframe', true);
        common::printIcon('bug', 'assignTo',   $params, $bug,  'list', '', '', 'iframe', true);
        common::printIcon('bug', 'resolve',    $params, $bug, 'list', '', '', 'iframe', true);
        common::printIcon('bug', 'close',      $params, $bug, 'list', '', '', 'iframe', true,'',$this->app->user->account,$groupID);
        common::printIcon('pro', 'bugedit',    "$params&planID=$planID", $bug, 'list','pencil');
        common::printIcon('bug', 'create',     "product=$bug->product&extra=bugID=$bug->id&planIDplus=$planID&projectID=0", $bug, 'list', 'copy');
        common::printIcon('bug', 'open',       $params, $bug, 'list', 'unlock-alt', '', 'iframe', true);
        ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
  </table>
</form>
</div>
<?php js::set('replaceID', 'bugList')?>
<?php include '../../common/view/footer.html.php';?>

