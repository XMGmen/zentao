<?php
include '../../common/view/header.html.php';
include '../../common/view/sparkline.html.php';
include '../../common/view/chosen.html.php';
include '../../common/view/treeview.html.php';

?>
<div id='titlebar'>
  <div class="heading">
  <?php
    echo html::select('proj', $projectStats, $projectID, "class='selectbox' onchange='byProj(this.value)'");
  ?>
  </div>
</div>
<div class="tabsbar">
  <ul id="myTab" class="nav nav-tabs">
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'index', "sprintID=$sprintID"),"User Story");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'task', "sprintID=$sprintID"),"任务");?>
    </li>
    <li id="sprintviewid" class="active">
    <?php echo html::a($this->createLink('sprint', 'bug', "sprintID=$sprintID"),"Bug");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'review', "sprintID=$sprintID"),"回顾会");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'burn', "sprintID=$sprintID"),"燃尽图");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'team', "sprintID=$sprintID"),"团队");?>
    </li>
    <li id="sprintviewid">
      <?php echo html::a($this->createLink('mySprintBoard', 'more', "sprintID=$sprintID"),"留言板");?>
    </li>
  </ul>
</div>


<div id='featurebar'>
   <ul class='nav'>
    <?php
    echo "<li id='assignedToTab'>" . html::a(inlink('bug', "sprintID=$sprintID&type=assignedTo"),  $lang->Bug->assignedToMe) . "</li>";
    echo "<li id='allTab'>" .        html::a(inlink('bug', "sprintID=$sprintID&type=all"),         $lang->Bug->all) . "</li>";
    ?>
  </ul>	
  <div class='actions'>
  <div class='btn-group'>
    <?php common::printIcon('bug', 'create', "productID=$productID&extra=projectID=$projectID&planIDplus=0&projectIDplus=$projectID");?>
    <?php common::printIcon('bug', 'export', "productID=0&planID=0&sprintID=$sprintID&orderBy=id_desc", '', 'button', '', '', 'export');?>
    <?php common::printIcon('importbugs', 'upload', "productID=$productID&planID=$planID&sprintID=$sprintID",'','button','','','export');?>
    <div class='excelTemplate'><?php echo html::a($downloadLink, $downloadExcel);?></div>
  </div>
  </div>
</div>
<div id="tablestyle">
<form method='post' id='projectBugForm'>
  <table class='table table-condensed table-hover table-striped tablesorter table-fixed' id='bugList'>
    <thead>
      <tr>
        <?php $vars = "projectID=$projectID&type=$type&orderBy=%s&build=$buildID&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
        <th class='w-id'><?php common::printOrderLink('id',           $orderBy, $vars, $lang->idAB);?></th>
        <th class='w-severity'><?php common::printOrderLink('severity',     $orderBy, $vars, $lang->bug->severityAB);?></th>
        <th class='w-pri'><?php common::printOrderLink('pri',          $orderBy, $vars, $lang->priAB);?></th>
        <th stype="text-align: left"><?php common::printOrderLink('title',        $orderBy, $vars, $lang->bug->title);?></th>
        <th class='w-user'><?php common::printOrderLink('openedBy',     $orderBy, $vars, $lang->openedByAB);?></th>
        <th class='w-user'><?php common::printOrderLink('assignedTo',   $orderBy, $vars, $lang->assignedToAB);?></th>
        <th class='w-user'><?php common::printOrderLink('resolvedBy',   $orderBy, $vars, $lang->bug->resolvedBy);?></th>
        <th class='w-resolution'><?php common::printOrderLink('resolution', $orderBy, $vars, $lang->bug->resolutionAB);?></th>
        <th class='w-140px {sorter:false}'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($bugs as $bug):?>
    <tr class='text-center'>
      <td>
        <input type='checkbox' name='bugIDList[]'  value='<?php echo $bug->id;?>'/> 
        <?php echo html::a($this->createLink('sprint', 'bugview', "bugID=$bug->id"), sprintf('%03d', $bug->id));?>
      </td>
      <td><span class='<?php echo 'severity' . zget($lang->bug->severityList2, $bug->severity, $bug->severity)?>'><?php echo zget($lang->bug->severityList2, $bug->severity, $bug->severity)?></span></td>
      <td><span class='<?php echo 'pri' . zget($lang->bug->priList, $bug->pri, $bug->pri)?>'><?php echo zget($lang->bug->priList, $bug->pri, $bug->pri)?></span></td>
      <td class='text-left' title="<?php echo $bug->title?>"><?php echo html::a($this->createLink('sprint', 'bugview', "bugID=$bug->id"), $bug->title);?></td>
      <td><?php echo zget($users, $bug->openedBy, $bug->openedBy);?></td>
      <td <?php if($bug->assignedTo == $this->app->user->account){ echo " style='color:red'";}?>>
      	<?php echo zget($users, $bug->assignedTo, $bug->assignedTo); ?>
      </td>
      <td ><?php echo zget($users, $bug->resolvedBy, $bug->resolvedBy);?></td>
      <td><?php echo $lang->bug->resolutionList[$bug->resolution];?></td>
      <td class='text-right'>
        <?php
        $params = "bugID=$bug->id";
        common::printIcon('bug', 'confirmBug', $params, $bug, 'list', 'search', '', 'iframe', true);
        common::printIcon('bug', 'assignTo',   $params, $bug,   'list', '', '', 'iframe', true);
        common::printIcon('bug', 'resolve',    $params, $bug, 'list', '', '', 'iframe', true);
        common::printIcon('bug', 'close',      $params, $bug, 'list', '', '', 'iframe', true,'',$this->app->user->account,$groupID);
        common::printIcon('sprint', 'bugedit',       $params, $bug, 'list','pencil');
        //common::printIcon('bug', 'create',     "product=$bug->product&extra=bugID=$bug->id", $bug, 'list', 'copy');
        common::printIcon('bug', 'create',     "product=$bug->product&extra=bugID=$bug->id&planIDplus=0&projectIDplus=$projectID", $bug, 'list', 'copy');
        common::printIcon('bug', 'open',      $params, $bug, 'list', 'unlock-alt', '', 'iframe', true);
        ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan='9'>
          <div class='table-actions clearfix'>
          </div>
          <?php $pager->show();?>
        </td>
      </tr>
    </tfoot>
  </table>
</form>
</div>
<?php include '../../common/view/footer.html.php';?>