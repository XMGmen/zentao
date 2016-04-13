<?php
include '../../common/view/header.html.php';
include '../../common/view/sparkline.html.php';
include '../../common/view/datepicker.html.php';
include '../../common/view/treeview.html.php';

?>
<?php js::set('moduleID', $moduleID);?>
<?php js::set('productID', $productID);?>
<?php js::set('browseType', $browseType);?>
<div id='titlebar'>
  <div class="heading">
  <?php
    echo html::select('proj', $projectStats, $projectID, "class='selectbox' onchange='byProj(this.value)'");
  ?>
  </div>
</div>
<div class="tabsbar"> <!-- change classname from "sprint_index" to "tabsbar" by xufangye  -->
  <ul id="myTab" class="nav nav-tabs">
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'index', "sprintID=$sprintID"),"User Story");?>
    </li>
    <li id="sprintviewid" class="active">
    <?php echo html::a($this->createLink('sprint', 'task', "sprintID=$sprintID"),"任务");?>
    </li>
    <li id="sprintviewid">
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
<?php include './taskheader.html.php';?>
<div id="tablestyle">
  <form method='post' id='projectTaskForm'>
    <table class='table table-condensed table-hover table-striped tablesorter table-fixed' id='taskList'>
      <?php $vars = "projectID=$projectID&status=$status&parma=$param&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage"; ?>
      <thead>
        <tr>
          <th class='w-id'>    <?php common::printOrderLink('id',           $orderBy, $vars, $lang->idAB);?></th>
          <th class='w-pri'>   <?php common::printOrderLink('pri',          $orderBy, $vars, $lang->priAB);?></th>
          <th class='w-p30'>   <?php common::printOrderLink('name',         $orderBy, $vars, $lang->task->name);?></th>
          <th class='w-p30'>   <?php common::printOrderLink('type',         $orderBy, $vars, $lang->task->type);?></th>
          <th class='w-status'><?php common::printOrderLink('status',       $orderBy, $vars, $lang->statusAB);?></th>
          <th class='w-70px'>  <?php common::printOrderLink('deadline',     $orderBy, $vars, $lang->task->deadlineAB);?></th>

          <?php if($this->cookie->windowWidth > $this->config->wideSize):?>
          <th class='w-id'>   <?php common::printOrderLink('openedDate',   $orderBy, $vars, $lang->task->openedDateAB);?></th>
          <?php endif;?>

          <th class='w-user'>  <?php common::printOrderLink('assignedTo',   $orderBy, $vars, $lang->task->assignedToAB);?></th>
          <th class='w-user'>  <?php common::printOrderLink('finishedBy',   $orderBy, $vars, $lang->task->finishedByAB);?></th>

          <?php if($this->cookie->windowWidth > $this->config->wideSize):?>
          <th class='w-50px'>  <?php common::printOrderLink('finishedDate', $orderBy, $vars, $lang->task->finishedDateAB);?></th>
          <?php endif;?>

          <th class='w-35px'>  <?php common::printOrderLink('estimate',     $orderBy, $vars, $lang->task->estimateAB);?></th>
          <th class='w-50px'>  <?php common::printOrderLink('consumed',     $orderBy, $vars, $lang->task->consumedAB);?></th>
          <th class='w-40px nobr'>  <?php common::printOrderLink('left',         $orderBy, $vars, $lang->task->leftAB);?></th>
          <?php if(1) print '<th>' and common::printOrderLink('story', $orderBy, $vars, $lang->task->story) and print '</th>';?>
          <th class='w-150px {sorter:false}'><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($tasks as $task):?>
      <?php $class = $task->assignedTo == $app->user->account ? 'style=color:red' : ''; ?>
      <tr class='text-center'>
        <td>
          <input type='checkbox' name='taskIDList[]'  value='<?php echo $task->id;?>'/> 
          <?php if(!common::printLink('sprint', 'taskview', "task=$task->id", sprintf('%03d', $task->id))) printf('%03d', $task->id);?>
        </td>
        <td><span class='<?php echo 'pri' . zget($lang->task->priList, $task->pri, $task->pri)?>'><?php echo zget($lang->task->priList, $task->pri, $task->pri);?></span></td>
        <td class='text-left' title="<?php echo $task->name?>">
          <?php 
          if(!common::printLink('sprint', 'taskview', "task=$task->id", $task->name)) echo $task->name;
          if($task->fromBug) echo html::a($this->createLink('bug', 'view', "id=$task->fromBug"), "[BUG#$task->fromBug]", '_blank', "class='bug'");
          ?>
        </td>
        <td><?php print($lang->task->typeList[$task->type]); ?></td>
        <td class="<?php echo $task->status;?>">
          <?php
          $storyChanged = ($task->storyStatus == 'active' and $task->latestStoryVersion > $task->storyVersion);
          $storyChanged ? print("<span class='warning'>{$lang->story->changed}</span> ") : print($lang->task->statusList3[$task->status]);
          ?>
        </td>
        <td class="<?php if(isset($task->delay)) echo 'delayed';?>"><?php if(substr($task->deadline, 0, 4) > 0) echo substr($task->deadline, 5, 6);?></td>

        <?php if($this->cookie->windowWidth > $this->config->wideSize):?>
        <td><?php echo substr($task->openedDate, 5, 6);?></td>
        <?php endif;?>

        <td <?php if($task->assignedTo == $this->app->user->account){ echo " style='color:red'";}?>><?php echo $task->assignedTo == 'closed' ? 'Closed' : $task->assignedToRealName;?></td>
        <td><?php echo zget($users, $task->finishedBy, $task->finishedBy);?></td>

        <?php if($this->cookie->windowWidth > $this->config->wideSize):?>
        <td><?php echo substr($task->finishedDate, 5, 6);?></td>
        <?php endif;?>

        <td><?php echo $task->estimate;?></td>
        <td><?php echo $task->consumed;?></td>
        <td><?php echo $task->left;?></td>
        <?php
        if(1)
        {
            echo '<td class="text-left" title="' . $task->storyTitle . '">';
            if($task->storyID)
            {
              if(!common::printLink('sprint', 'storyview', "storyID=$task->story&version=$task->storyVersion&from=project&param=$task->project",$task->storyTitle)) print $task->storyTitle;
            }
            echo '</td>';
        }
        ?>
        <td class='text-right'>
        <?php
        common::printIcon('task', 'assignTo', "projectID=$task->project&taskID=$task->id", $task, 'list', '', '', 'iframe', true);
        common::printIcon('task', 'start',    "taskID=$task->id", $task, 'list', '', '', 'iframe', true);

        common::printIcon('task', 'recordEstimate', "taskID=$task->id", $task, 'list', 'time', '', 'iframe', true);
        if($browseType == 'needconfirm')
        {
            $lang->task->confirmStoryChange = $lang->confirm;
            common::printIcon('task', 'confirmStoryChange', "taskid=$task->id", '', 'list', '', 'hiddenwin');
        }
        common::printIcon('task', 'finish', "taskID=$task->id", $task, 'list', '', '', 'iframe', true);
        common::printIcon('task', 'close',    "taskID=$task->id", $task, 'list', '', '', 'iframe', true);
        // common::printIcon('task', 'edit',"taskID=$task->id", '', 'list');
        common::printIcon('sprint', 'taskedit',"taskID=$task->id", '','list', 'pencil');
        common::printIcon('task', 'delete', "projectID=$task->project&taskid=$task->id", '', 'list', '', 'hiddenwin');
        ?>
        </td>
      </tr>
      <?php endforeach;?>
      </tbody>
      <tfoot>
        <tr>
          <?php $columns = ($this->cookie->windowWidth > $this->config->wideSize ? 15 : 13) - ($project->type == 'sprint' ? 0 : 1);?>
          <td colspan='<?php echo $columns;?>'>
           <div class='table-actions clearfix'>
             <?php echo "<div class='text'>" . $summary . "</div>"; ?>
           </div>
           <?php $pager->show();?>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
 </div>

 <?php include '../../common/view/footer.html.php';?>
