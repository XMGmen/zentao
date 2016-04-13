<?php
include '../../common/view/header.html.php';
include '../../common/view/sparkline.html.php';
include '../../common/view/tablesorter.html.php';?>
<?php js::set('confirmDelete', $lang->project->confirmDelete)?>
<div id='titlebar'>
  <div class="heading">
  <?php
    echo html::select('pro', $productplans, $planID, "class='selectbox' onchange='byPros(this.value)'");
  ?>
  </div>
</div>
<div class="tabsbar">
  <ul id="myTab" class="nav nav-tabs">
    <li id='proviewid'class="active">
    <?php echo html::a($this->createLink('pro', 'index', "planID=$planID"),"Sprint");?>
    </li>
    <li id='proviewid'>
    <?php echo html::a($this->createLink('pro', 'backlog', "planID=$planID"),"Back Log");?>
    </li>
    <li id='proviewid'>
    <?php echo html::a($this->createLink('pro', 'bug', "planID=$planID"),"Bug");?>
    </li>
    <li id='proviewid'>
    <?php echo html::a($this->createLink('pro', 'team', "planID=$planID"),"团队");?>
    </li>
  </ul>
</div>
<div id='featurebar'>
  <ul class='heading'><i class='icon-folder-open-alt'></i> Sprint列表 </ul>
  <div class='actions'>
  <?php 
    if(common::hasPriv('pro', 'sprintcreate')) {
        echo html::a(helper::createLink('pro', 'sprintcreate', "planID=$planID"), "<i class='icon-plus'></i> " . $lang->my->home->createProject, '', "class='btn'"); 
    }
  ?>  </div>
</div>
<div id="tablestyle">
<table class='table' id='projectList'>
  <thead>
  <?php $vars = "planID=$planID"; ?>
    <tr class='text-center'>	 
      <!-- <th class='w-id'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th> -->
	  <th class='w-100px'><?php echo $lang->sprint->weather;?></th>
      <!-- <th class='w-160px'><?php common::printOrderLink('code', $orderBy, $vars,$lang->sprint->code);?></th> -->
      <!-- add class w-100 by xufangye -->
      <th class='w-100px'><?php common::printOrderLink('name', $orderBy, $vars, $lang->sprint->name);?></th>
      <th class='w-date'><?php common::printOrderLink( 'begin', $orderBy, $vars, $lang->sprint->begin);?></th>
      <th class='w-date'><?php common::printOrderLink( 'end',    $orderBy, $vars, $lang->sprint->end);?></th>
      <th class='w-100px'><?php common::printOrderLink('status', $orderBy, $vars, $lang->sprint->status);?></th>
      <th class='w-100px'><?php echo $lang->sprint->totalEstimate;?></th>
      <th class='w-100px'><?php echo $lang->sprint->totalConsumed;?></th>
      <th class='w-100px'><?php echo $lang->sprint->totalLeft;?></th>
      <th class='w-100px'><?php echo $lang->sprint->progess;?></th>
	  <th class='w-80px {sorter:false}'><?php echo $lang->actions;?></th>
      <!-- <th class='w-150px'><?php echo $lang->sprint->burn;?></th> -->
    </tr>
  </thead>
  <tbody>
  <?php foreach($sprintStats as $sprint):?>
  <tr class='text-center'>
  <!-- 改一下模块和方法************************************************************************************ -->
    <!-- <td class='text-center' ><?php echo html::a($this->createLink('sprint', 'index',"id=$sprint->id"),$sprint->id);?></td> -->
    <td class='text-center w-150px'>
        <img weather='<?php echo $sprint->weather;?>' src='<?php echo $defaultTheme;?>images/main/weather/<?php echo $sprint->weather;?>.png' title='<?php echo $sprint->weatherRemark ?>' width='32px' height='32px'/>
    </td>
    <td><?php echo html::a($this->createLink('sprint', 'index',"id=$sprint->id"),$sprint->name);?></td>
    <!-- <td><?php echo html::a($this->createLink('sprint', 'index',"id=$sprint->id"),$sprint->code);?></td> -->
	<td><?php echo $sprint->begin;?></td>
    <td><?php echo $sprint->end;?></td>
    <td class='status-<?php echo $sprint->status;?>'><?php echo $lang->project->statusList[$sprint->status];?></td>
    <td><?php echo $sprint->hours->totalEstimate;?></td>
    <td><?php echo $sprint->hours->totalConsumed;?></td>
    <td><?php echo $sprint->hours->totalLeft;?></td>
    <td class='text-center w-150px'>
   		<img src='<?php echo $defaultTheme;?>images/main/green.png' width=<?php echo $sprint->hours->progress;?> height='13' text-align: />
      <small><?php echo $sprint->hours->progress;?>%</small>
    </td>
	<td class='text-right'>
	<?php  	
        if(common::hasPriv('pro', 'sprintedit')) {
            common::printIcon('pro', 'sprintedit',   "id=$sprint->id", '', 'list', 'pencil', '', 'iframe', true);
        }
	if(common::hasPriv('pro', 'delete')) {
            $deleteURL = $this->createLink('pro', 'delete', "projectID=$sprint->id&confirm=yes");
            echo html::a("javascript:ajaxDelete(\"$deleteURL\",\"projectList\",confirmDelete)", '<i class="icon-remove"></i>', '', "class='btn-icon' title='{$lang->project->delete}'");
        } ?>
      </td>
	</td>
    <!-- <td class='projectline text-center' values='<?php //echo join(',', $sprint->burns);?>'></td> -->
 </tr>
 <?php endforeach;?>
</table>
</div>
<?php js::set('listName', 'projectList')?>
<?php js::set('orderBy', $orderBy)?>
<?php include '../../common/view/footer.html.php';?>
