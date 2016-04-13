<?php
/**
 * The create view of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: create.html.php 4902 2013-06-26 05:25:58Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
 <?php 
//include './header.html.php';
// include '../../common/view/header.lite.html.php';
// if($isStory) {     
	//include '../../common/view/header.lite.html.php';
//}else{
	include '../../common/view/kindeditor.html.php';
	include '../../common/view/header.html.php';
//}
?>


<?php include '../../common/view/form.html.php';?>
<?php js::set('holders', $lang->story->placeholder); ?>
<?php 
if($projectID==0) {
	echo '<div id="procreatesprint">';
	echo '<ul id="myTab" class="nav nav-tabs">';
	echo     '<li id="indexid">';
     	echo  	 html::a($this->createLink('pro', 'index', "planID=$planIDplus"),"Sprint");
       	echo '</li>';
        echo '<li id="backlogid" class="active">';
        echo html::a($this->createLink('pro', 'backlog', "planID=$planIDplus"),"Back Log");
        echo '</li>';
        echo '<li id="bugid" >';
        echo html::a($this->createLink('pro', 'bug', "planID=$planIDplus"),"Bug");
        echo '</li>';
        echo '<li id="teamid">';
        echo html::a($this->createLink('pro', 'team', "planID=$planIDplus"),"团队");
        echo '</li>';
        echo '</ul>';
        echo '</div>';
} else {
	echo '<div id="procreatesprint">';
	echo '<ul id="myTab" class="nav nav-tabs">';
	echo'<li id="sprintviewid" class="active">';
	echo  html::a($this->createLink('sprint', 'index', "sprintID=$projectID"),"User Story");
	echo '</li>';
	echo '<li id="sprintviewid">';
	echo html::a($this->createLink('sprint', 'task', "sprintID=$projectID"),"任务");
	echo '</li>';
	echo '<li id="sprintviewid">';
	echo html::a($this->createLink('sprint', 'bug', "sprintID=$projectID"),"Bug");
	echo '</li>';
	echo '<li id="sprintviewid">';
	echo html::a($this->createLink('sprint', 'review', "sprintID=$projectID"),"回顾会");
	echo '</li>';
	echo '<li id="sprintviewid">';
	echo html::a($this->createLink('sprint', 'burn', "sprintID=$projectID"),"燃尽图");
	echo '</li>';
	echo '</ul>';
	echo '</div>';
}
?>
<div class='container mw-1400px' style="padding:0 30px;">
  <div id='titlebar' style='background:none; padding-left:0;'>
    <div class='heading'>
      <span class='prefix'><?php echo html::icon($lang->icons['story']);?></span>
      <strong><small class='text-muted'><?php echo html::icon($lang->icons['create']);?></small> <?php if($isStory) echo $lang->story->createStory;else echo $lang->story->create;?></strong>
    </div>
  </div>
  <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform' data-type='ajax'>
    <table class='table table-form'> 
      <tr>
        <th class='w-110px'><?php echo $lang->story->product;?></th>
        <td class='w-p25-f'>
          <?php 
          echo html::select('product', $products, $productID, "onchange='loadProduct(this.value);' class='form-control ' style='display: none'");
          echo current($products);
          ?>
        </td>
         
        <td class='w-p15-f'>
          <div class='input-group' id='moduleIdBox'>
         <?php 
          //echo html::select('module', $moduleOptionMenu, $moduleID, "class='form-control chosen'style='display: none'");
          /*
          if(count($moduleOptionMenu) == 1)
          {
              echo "<span class='input-group-addon'>";
              echo html::a($this->createLink('tree', 'browse', "rootID=$productID&view=story"), $lang->tree->manage, '_blank');
              echo '&nbsp; ';
              echo html::a("javascript:loadProductModules($productID)", $lang->refresh);
              echo '</span>';
          }
          */
          ?>
          </div>
        </td>
       <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->story->plan;?></th> <!-- changedbyheng -->
        <td>
          <div class='input-group' id='planIdBox'>
          <?php 
          echo html::select('plan', $plans, $planID, "onchange='loadPlan(this.value);'class='form-control ' style='display: none'");
          echo current($plans);
          ?>
          </div>
        </td>
      </tr>
      <?php 
      if($isStory){
	echo '<tr>';
	echo '<th style="padding-top: 7px">';echo $lang->story->sprint;echo '</th>'; // changedbyheng
	echo '<td style="padding-top: 7px">';
	echo "<div class='input-group' id='projectIdBox'>";
	echo html::select('project', $projects, $projectID, "class='form-control ' style='display: none'");
	echo $projectName;
	echo '</div>';
	echo '</td>';
	echo '</tr>';
	
	//added by fxq	
	echo '<tr>';
	echo '<th style="padding-top: 7px">';echo $lang->story->backlogsource;echo '</th>'; // changedbyfxq
	echo '<td style="padding-top: 7px">';
	echo "<div class='input-group' id='projectIdBox'>";
	echo html::select('backLog', $backLogs, $backLogID, "class='form-control ' ");
	echo '</div>';
	echo '</td>';
	echo '</tr>';
      }
      ?>
      <tr>
        <th><?php echo $lang->story->source;?></th>
        <td><?php echo html::select('source', $lang->story->sourceList, $source, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php if($projectID==0) {echo $lang->story->backlogtitle;} else {echo $lang->story->storytitle;}?></th>
        <td colspan='3'><?php echo html::input('title', $storyTitle, "class='form-control'");?></td>
      </tr>  
      <tr>
        <th><?php if($projectID==0) {echo $lang->story->backlogdesc;} else {echo $lang->story->storyspec;}?></th>
        <td colspan='3'><div class="required required-wrapper"></div><?php echo html::textarea('spec', $spec, "rows='9' class='form-control'");?><div class='help-block'><?php echo $lang->story->specTemplate;?></div></td>
      </tr>  
         <tr>
        <th><?php echo $lang->story->verify;?></th>
        <td colspan='3'><?php echo html::textarea('verify', $verify, "rows='6' class='form-control'");?></td>
      </tr> 
       <tr>
        <th><?php echo $lang->story->pri;?></th>
        <td><?php echo html::select('pri', (array)$lang->story->priList, $pri, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->story->estimatetime;?></th>  <!-- changedbyheng -->
        <td>
          <div class='input-group'>
            <?php echo html::input('estimate', $estimate, "class='form-control'");?>
            <span class='input-group-addon'><?php echo $lang->story->hourtime;?></span> <!-- changedbyheng -->
          </div>
        </td>
      </tr> 
      <tr>
        <th><?php echo $lang->story->reviewedBy;?></th>
        <td><?php echo html::select('assignedTo', $users, '', "class='form-control chosen'");?></td>
        <td><?php echo html::checkbox('needNotReview', $lang->story->needNotReview, '', "id='needNotReview' {$needReview}");?></td>
      </tr>  
       <tr>
        <th><nobr><?php echo $lang->story->mailto;?></nobr></th>
        <td colspan='3'>
          <div class='input-group'>
            <?php 
            echo html::select('mailto[]', $users, str_replace(' ' , '', $mailto), "multiple"); 
            if($contactLists) echo html::select('', $contactLists, '', "class='form-control' style='width: 150px' onchange=\"setMailto('mailto', this.value)\"");
            ?>
          </div>
        </td>
      </tr>

      <tr>
        <th><nobr><?php echo $lang->story->keywords;?></nobr></th>
        <td colspan='3'><?php echo html::input('keywords', $keywords, 'class="form-control"');?></td>
      </tr>
     <tr>
        <th><?php echo $lang->story->legendAttatch;?></th>
        <td colspan='3'><?php echo $this->fetch('file', 'buildform');?></td>
      </tr>  
      <tr><td></td><td colspan='3' class='text-center'><?php echo html::submitButton("保存","onclick='return checkData()'") . html::backButton();?></td></tr>
    </table>
    <span id='responser'></span>
  </form>
</div>
<script>
var arr="<?php echo $isStory;?>"
function checkData()
{
	var spec=$("#spec").val();
	if(spec==""){
		alert('描述不能为空！')
		return false;
	}
	return true;
}
function goback(){
	if(arr==1){
		url=parent.location;
		parent.location=url;
	}else{
		//alert(1);
		url=window.location.href;
		//alert(2);
		url=url.replace('story-create-0-0-0-0-0-0','pro-backlog',url);
		//alert(3);
		window.location=url;
		alert(4);
		//,"onclick='goback()'"
	}
}
//$("#submit").click(function(){
	//alert(1);
	//url=window.location.href;
	//alert(2);
	//url=url.replace('story-create-0-0-0-0-0-0','pro-backlog',url);
	//alert(3);
	//window.location=url;
	//alert(4);
//});
</script>
<?php 
		include '../../common/view/footer.html.php';
?>
