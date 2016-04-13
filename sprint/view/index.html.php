<?php
include '../../common/view/header.html.php';
include '../../common/view/sparkline.html.php';
include '../../common/view/chosen.html.php';
include '../../common/view/treeview.html.php';
include '../../common/view/tablesorter.html.php';
?>
<?php js::set('confirmUnlinkStory', $lang->project->confirmUnlinkStory)?>
<div id='titlebar'>
  <div class="heading">
  <?php
    echo html::select('proj', $projectStats, $projectID, "class='selectbox' onchange='byProj(this.value)'");
  ?>
  </div>
</div>
<div class="tabsbar"> <!-- change classname from "sprint_index" to "tabsbar" by xufangye  -->
	<ul id="myTab" class="nav nav-tabs">
		<li id="sprintviewid" class="active">
		<?php echo html::a($this->createLink('sprint', 'index', "sprintID=$sprintID"),"User Story");?>
		</li>
		<li id="sprintviewid">
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

<div id='featurebar'>
	<div class='heading'>
		<?php echo $lang->sprint->story;?>
	</div>
	<div class='actions'>
		<div class='btn-group'>
		<?php 
		$this->lang->story->create = $this->lang->story->createStory;
		common::printIcon('story', 'create', "projectID=$projectID&productID=0&moduleID=0&storyID=0&isStory=1&bugID=0&planIDplus=0");
		common::printIcon('story', 'export', "productID=0&planID=0&sprintID=$sprintID&orderBy=id_desc", '', 'button', '', '', 'export');
		?>
		</div>
	</div>
</div>

<div id="tablestyle">
<form method='post' id='projectStoryForm'>
  <table class='table tablesorter table-condensed table-fixed' id='storyList'>
  <thead>
  <tr class='colhead'>
  <?php $vars = "projectID=$projectID&orderBy=%s&type=$type&param=$param"; ?>
  <th class='w-id  {sorter:false}'> <?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
  <th class='w-pri {sorter:false}'> <?php common::printOrderLink('pri', $orderBy, $vars, $lang->priAB);?></th>
  <th class='{sorter:false}'> <?php common::printOrderLink('title', $orderBy, $vars, $lang->story->title);?></th>
  <th class='w-user {sorter:false}'> <?php common::printOrderLink('openedBy', $orderBy, $vars, $lang->openedByAB);?></th>
  <th class='w-80px {sorter:false}'> <?php common::printOrderLink('assignedTo', $orderBy, $vars, $lang->assignedToAB);?></th>
  <th class='w-hour {sorter:false}'> <?php common::printOrderLink('estimate', $orderBy, $vars, $lang->story->estimateAB);?></th>
  <th class='w-hour {sorter:false}'> <?php common::printOrderLink('status', $orderBy, $vars, $lang->statusAB);?></th>
  <th class='w-70px {sorter:false}'> <?php common::printOrderLink('stage', $orderBy, $vars, $lang->story->stageAB);?></th>
  <th class='w-70px'> <?php echo $lang->story->taskCount;?></th>
  <th class='w-130px {sorter:false}'>  <?php echo $lang->actions;?></th>
  </tr>
  </thead>
  <tbody>
    <?php
    $totalEstimate = 0;
    $canBatchEdit  = common::hasPriv('story', 'batchEdit');
    $canBatchClose = common::hasPriv('story', 'batchClose');
    ?>
    <?php foreach($stories as $key => $story):?>
    <?php
    // echo $projectID;
    $storyLink = $this->createLink('sprint', 'storyview', "storyID=$story->id&version=$story->version&from=project&param=$projectID");
    // $storyLink = $this->createLink('sprint', 'storyview', "story=$story&projectID=$projectID"); // addedbyheng
    $totalEstimate += $story->estimate;
    ?>
    <tr class='text-center' id="story<?php echo $story->id?>">
      <td class='text-left'>
        <?php if($canBatchEdit or $canBatchClose):?>
        <input type='checkbox' name='storyIDList[<?php echo $story->id;?>]' value='<?php echo $story->id;?>' /> 
        <?php endif;?>
        <?php echo html::a($storyLink, sprintf('%03d', $story->id));?>
      </td>
      <td><span class='<?php echo 'pri' . zget($lang->story->priList, $story->pri, $story->pri)?>'><?php echo zget($lang->story->priList, $story->pri, $story->pri);?></span></td>
      <td class='text-left' title="<?php echo $story->title?>"><?php echo html::a($storyLink,$story->title);?></td>
      <td><?php echo $users[$story->openedBy];?></td>
      <td><?php echo $users[$story->assignedTo];?></td>
      <td><?php echo $story->estimate;?></td>
      <td class='story-<?php echo $story->status;?>'><?php echo $lang->story->statusList[$story->status];?></td>
      <td><?php echo $lang->story2->stageList[$story->stage];?></td>
      <td class='linkbox'>
        <?php
        $tasksLink = $this->createLink('story', 'tasks', "storyID=$story->id&projectID=$project->id");
        $storyTasks[$story->id] > 0 ? print(html::a($tasksLink, $storyTasks[$story->id], '', 'class="iframe"')) : print(0);
        ?> 
      </td>
      <td>
        <?php 
        $param = "projectID=$projectID&story={$story->id}&moduleID={$story->module}&isFromStory=1";
       
        $lang->task->create = $lang->project->wbs;
        common::printIcon('sprint', 'changestory',  "projectID=$projectID&story={$story->id}", $story, 'list', 'random');
        common::printIcon('sprint', 'taskcreate', $param, '', 'list', 'smile');
        // common::printIcon('task', 'assignTo', $param, '', 'list', 'smile');

        $lang->task->batchCreate = $lang->project->batchWBS;
        common::printIcon('sprint', 'taskbatchCreate', "projectID=$projectID&story={$story->id}", '', 'list', 'stack');

        // $lang->testcase->batchCreate = $lang->testcase->create;
        // if($productID) common::printIcon('testcase', 'batchCreate', "productID=$story->product&moduleID=$story->module&storyID=$story->id", '', 'list', 'sitemap');
        common::printIcon('sprint', 'storyreview',     "storyID=$story->id&projectID=$story->project", $story, 'list', 'search');
        common::printIcon('sprint', 'storyedit',"projectID=$projectID&story={$story->id}",'','list', 'pencil');
        common::printIcon('story', 'delete', "storyID={$story->id}&sprintID=$sprintID", '', 'list', '', 'hiddenwin');
        ?>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  </table>
</form>
 </div>
<?php include '../../common/view/footer.html.php';?>

