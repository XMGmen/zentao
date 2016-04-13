<?php
include '../../common/view/header.html.php';
include '../../common/view/sparkline.html.php';
include '../../common/view/chosen.html.php';
include '../../common/view/treeview.html.php';
include '../../common/view/tablesorter.html.php';
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
      <li id="proviewid" >
      	<?php echo html::a($this->createLink('pro', 'index', "planID=$planID"),"Sprint");?>
      </li>
      <li id="proviewid" class="active">
      <?php echo html::a($this->createLink('pro', 'backlog', "planID=$planID"),"Back Log");?>
      </li>
      <li id="proviewid">
      <?php echo html::a($this->createLink('pro', 'bug', "planID=$planID"),"Bug");?>
      </li>
      <li id="proviewid">
      <?php echo html::a($this->createLink('pro', 'team', "planID=$planID"),"团队");?>
      </li>
    </ul>
  </div>
<div id='featurebar'>
  <div class='heading' >
    <?php echo $lang->pro->backloglist?>
  </div>
  <div class='actions'>
    <div class='btn-group'>
    <?php 
    //common::printIcon('pro', 'create', "productID=$productID&moduleID=$moduleID", '', 'button', 'plus');
     common::printIcon('story', 'create', "projectID=0&productID=0&moduleID=0&storyID=0&isStory=0&bugID=0&planIDplus=$planID"); 
    ?>
    <?php $this->lang->story->export =$this->lang->story->exportBacklog ;
          common::printIcon('story', 'export', "productID=0&planID=$planID&sprintID=0&orderBy=id_desc", '', 'button', '', '', 'export');?>
    </div>
  </div>
  <div id='querybox' class='<?php if($browseType =='bysearch') echo 'show';?>'></div>
</div>
<div id="tablestyle">
<div class='main'>
  <form method='post' id='productStoryForm'>
    <table class='table table-condensed table-hover table-striped tablesorter table-fixed' id='storyList' style="margin:0">
      <thead>
      <tr>
        <?php $vars = "planID=$planID&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
 		<th class='w-id'>  <?php common::printOrderLink('id',         $orderBy, $vars, $lang->idAB);?> </th>
        <th class='w-pri'> <?php common::printOrderLink('pri',        $orderBy, $vars, $lang->priAB);?></th>
        <th class='w-p30'> <?php common::printOrderLink('title',      $orderBy, $vars, $lang->story->title);?></th>
        <th class='w-100px'>               <?php common::printOrderLink('plan',       $orderBy, $vars, $lang->story->planAB);?></th>
        <th class='w-100px'>               <?php common::printOrderLink('source',     $orderBy, $vars, $lang->story->source);?></th>
        <th class='w-110px'>               <?php common::printOrderLink('openedBy',   $orderBy, $vars, $lang->openedByAB);?></th>
        <th class='w-110px'>               <?php common::printOrderLink('assignedTo', $orderBy, $vars, $lang->assignedToAB);?></th>
        <th class='w-hour'><?php common::printOrderLink('estimate',   $orderBy, $vars, $lang->story->estimateAB);?></th>
        <th class='w-110px'>               <?php common::printOrderLink('status',     $orderBy, $vars, $lang->statusAB);?></th>
        <th class='w-110px'>               <?php common::printOrderLink('stage',      $orderBy, $vars, $lang->story->stageAB);?></th>
        <th class='w-140px {sorter:false}'><?php echo $lang->actions;?></th>
      </tr>
      </thead>
      <tbody>
      
        <?php foreach($stories as $key => $story):?>
      
      <?php
      $viewLink = $this->createLink('pro', 'backlogview', "planID=$planID&storyID=$story->id");
      $canView  = common::hasPriv('story', 'view');
      ?>
      
      <tr class='text-center'>
        <td class='text-left'>
          <input type='checkbox' name='storyIDList[<?php echo $story->id;?>]' value='<?php echo $story->id;?>' /> 
          <?php if($canView) echo html::a($viewLink, sprintf('%03d', $story->id)); else printf('%03d', $story->id);?>
        </td>
        <td>
	  <span class='<?php echo 'pri' . zget($lang->story->priList, $story->pri, $story->pri);?>'><?php echo zget($lang->story->priList, $story->pri, $story->pri)?></span>
	</td>
        <td class='text-center' title="<?php echo $story->title?>"><nobr><?php echo html::a($viewLink, $story->title);?></nobr></td>
        <td title="<?php echo $story->planTitle?>"><?php echo $story->planTitle;?></td>
        <td><?php echo $lang->story->sourceList[$story->source];?></td>
        <td><?php echo zget($users, $story->openedBy, $story->openedBy);?></td>
        <td><?php echo zget($users, $story->assignedTo, $story->assignedTo);?></td>
        <td><?php echo $story->estimate;?></td>
        <td class='story-<?php echo $story->status;?>'><?php echo $lang->story->statusList[$story->status];?></td>
        <td class='text-center'><?php echo $lang->story->stageList[$story->stage];?></td>
        <td class='text-left'>
		<?php 
          $vars = "story={$story->id}";
		  
          common::printIcon('pro', 'backlogchange',  "$vars&planID=$planID", $story, 'list', 'random');
          common::printIcon('pro', 'backlogreview',     "$vars&planID=$planID", $story, 'list', 'search');
          common::printIcon('story', 'close',      $vars, $story, 'list', 'off', '', 'iframe', true);
          common::printIcon('pro', 'backlogedit',     "$vars&planID=$planID", $story, 'list', 'pencil');
          // common::printIcon('story', 'createCase', "productID=$story->product&module=0&from=&param=0&$vars", $story, 'list', 'sitemap');
          ?>
		</td>
      </tr>
      <?php endforeach;?>
      </tbody>
      <tfoot><tr><td colspan='11'><?php $pager->show();?></td></tr></tfoot>
    </table>
  </form>
</div>
</div>
<script language='javascript'>

$('#module<?php echo $moduleID;?>').addClass('active');
$('#<?php echo $browseType;?>Tab').addClass('active');
</script>
<?php include '../../common/view/footer.html.php';?>
