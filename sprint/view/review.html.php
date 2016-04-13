<?php
include '../../common/view/header.html.php';
include '../../common/view/datepicker.html.php';
include '../../common/view/kindeditor.html.php';
include '../../common/view/sparkline.html.php';
include '../../common/view/chosen.html.php';
include '../../common/view/treeview.html.php';
include '../../common/view/tablesorter.html.php';
?>
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
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'task', "sprintID=$sprintID"),"任务");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'bug', "sprintID=$sprintID"),"Bug");?>
    </li>
    <li id="sprintviewid" class="active">
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

<div >
<?php if($reviewStatus == 0):?>
<div class='panel-body text-center'><br><br>
  <?php echo html::a($this->createLink('sprint', 'createreview',"sprintID=$sprintID"), "<i class='icon-plus'></i> " . "创建回顾会",'', "class='btn btn-primary'");?>
</div>
    
<?php else:?>
<div id="tablestyle">
<div class='container mw-1400px'>
  <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform' data-type='ajax'>
  <div id='featurebar'> <!-- change idname from "titlebar" to "featurebar" / removed style by xufangye  -->
   <div class='heading'>
     <?php echo $lang->review->legendBasicInfo;?> <!-- remove "strong" tag by xufangye -->
   </div>
   <div class='actions'>
     <?php 
       $link = helper::createLink('sprint', 'reviewedit',"projectID=$projectID", '', false); 
       echo html::a($link, "<button type='button' id='mybutton' >编辑</button>"); 
     ?>
     <?php 
       $link = helper::createLink('sprint', 'reviewdelete',"sprintID=$projectID", '', false); 
       echo html::a($link, "<button type='button' id='mybutton' >删除</button>"); 
     ?>
  </div>
  </div>
  <h4> <!-- change div to h4 by xufangye -->
    <div class='heading'>
      <strong><?php echo $lang->review->sprintInfo;?></strong>
    </div>
  </h4>
    <!-- change style width by xufangye -->
    <table class='table table-form' style="width:70%"> 
 	  <tr>
        <!-- change th style to class by xufangye -->
        <th class="sprint-review-th"><?php echo $lang->sprint->planRange;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('begin',$sprintBegin, "class='form-control w-100px ' style='background-color:#F7F7F7' ");?>
            <span class='input-group-addon' style='background-color:#F7F7F7'><?php echo $lang->project->to;?></span>
            <?php echo html::input('end', $sprintEnd, "class='form-control' style='background-color:#F7F7F7' ");?>
          </div>
        </td>
        <td style='visibility:hidden'>
          &nbsp; &nbsp; <?php echo html::radio('delta', $lang->project->endList , '', "onclick='computeEndDate(this.value)'");?>
        </td>
      </tr>
      <tr>
        <!-- change th style to class by xufangye -->
        <th class="sprint-review-th"><?php echo $lang->sprint->realRange;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('real_begin',$real_begin, "class='form-control w-100px' style='background-color:#F7F7F7'  placeholder='" . $lang->project->begin . "'");?>
            <span class='input-group-addon' style='background-color:#F7F7F7'><?php echo $lang->project->to;?></span>
            <?php echo html::input('real_end', $real_end, "class='form-control ' style='background-color:#F7F7F7' placeholder='" . $lang->project->end . "'");?>
          </div>
        </td>
        <td style='visibility:hidden'>
          &nbsp; &nbsp; <?php echo html::radio('delta', $lang->project->endList , '', "onclick='computeEndDate(this.value)'");?>
        </td>
      </tr>
      <tr style="display:none">
        <!-- change th style to class by xufangye -->
        <th class="sprint-review-th"><?php echo "SprintID";?></th>
        <td colspan='2'>
          <div class='input-group'>
            <?php echo html::input('sprintID', $sprintID, "class='form-control' readOnly='true'");?>
          </div>
        </td>
      </tr>
      <tr>
        <!-- change th style to class by xufangye -->
        <th class="sprint-review-th"><?php echo $lang->sprint->goal;?></th>
        <td colspan='2'>
         <!--<?php echo html::textarea('sprintDesc', $sprintDesc, "rows='3' class='form-control' style='background-color:#F7F7F7' ");?>--!>
         <fieldset>
           <div class='content'><?php echo  $sprintDesc;?></div>
         </fieldset>		
       </td><td></td>
      </tr> 
    </table>
    
	<h4> <!-- change div to h4 by xufangye -->
	  <div class='heading'>
	    <strong><?php echo $lang->sprint->stroyPoint;?></strong>
	  </div>
	</h4>
    <!-- change style width by xufangye -->
    <table class='table table-form' > 
 	  <tr>
        <!-- change th style to class by xufangye -->
        <th class="sprint-review-th"><?php echo $lang->sprint->estimatePoints;?></th>
        <td>
          <div class='input-group'>
             <?php echo html::input('estimatePoints',$estimatePoints, "style='background-color:#F7F7F7' readOnly='true' ");?>点
          </div>
        </td>
      </tr>
      <tr>
        <!-- change th style to class by xufangye -->
        <th class="sprint-review-th"><?php echo $lang->sprint->realPoints;?></th>
        <td>
          <div class='input-group'>
             <?php echo html::input('realPoints',$realPoints, "style='background-color:#F7F7F7' readOnly='true'");?>点
          </div>
        </td>
      </tr>
      <tr>
        <!-- change th style to class by xufangye -->
        <th class="sprint-review-th"><?php echo $lang->sprint->explain;?></th>
        <td colspan='2'>
          <!--<?php echo html::textarea('expl', $expl, "rows='7'  class='form-control' style='background-color:#F7F7F7'  ");?>--!>
          <fieldset>
            <div class='content'><?php echo  $expl;?></div>
          </fieldset>
        </td>
      </tr>
      <tr>
        <!-- change th style to class by xufangye -->
        <th class="sprint-review-th"><?php echo $lang->sprint->referenceStory;?></th>
        <td >
         <fieldset style='width:1200px'> 
           <div class='content' ><?php echo  $referenceStory;?></div>
      	 </fieldset> 
        </td>      
      </tr> 
    </table>
    <h4> <!-- change div to h4 by xufangye -->
  	  <div class='heading'>
  	    <strong><?php echo $lang->sprint->conference;?></strong>
  	  </div>
	   </h4>
    <!-- change style width by xufangye -->
    <table class='table table-form' style="width:70%;"> 
 	 <tr>
        <!-- change th style to class by xufangye -->
        <th class="sprint-review-th"><?php echo $lang->sprint->time;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('date',$date, "style='width:25%;height:120%;background-color:#F7F7F7' readOnly='true'");?>
            &nbsp; &nbsp;
            <?php echo html::input('time',$time, "style='width:25%;height:120%;background-color:#F7F7F7' readOnly='true'");?>
            <span style="font-style:italic;color:gray">建议填写格式如  12:35 - 15:00</span>
          </div>
        </td>
      </tr>
      <tr>
        <th class="sprint-review-th"><?php echo $lang->sprint->place;?></th>
        <td colspan='2'>
          <!--<?php echo html::textarea('place', $place, "rows='1' class='form-control' style='background-color:#F7F7F7' ");?>--!>
          <fieldset>
            <div class='content'><?php echo  $place;?></div>
          </fieldset>
        </td>
      </tr>
      <tr>
        <th class="sprint-review-th"><?php echo $lang->sprint->person;?></th>
        <td colspan='2'>
          <!--<?php echo html::textarea('persons', $persons, "rows='1' class='form-control' style='background-color:#F7F7F7' ");?>--!>
          <fieldset>
            <div class='content'><?php echo  $persons;?></div>
          </fieldset>
        </td>
      </tr>
      <tr>
        <th class="sprint-review-th"><?php echo $lang->sprint->completeFuncReview;?></th>
        <td colspan='2'>
        <fieldset>
        	 	<div class='content'><?php echo  $completeFunc;?></div>
      	</fieldset>
        </td><td></td>      
	</tr> 
      <tr>
        <th class="sprint-review-th"><?php echo $lang->sprint->summary;?></th>
        <td colspan='2'>
	<fieldset>
        <div class='content'><?php echo  $summary;?></div>
      	</fieldset>
      	</td><td></td>      
	</tr> 
	
      <tr>
        <th class="sprint-review-th"><?php echo $lang->sprint->other;?></th>
        <td colspan='2'>
	<fieldset>
        <div class='content'><?php echo  $other;?></div>
      	</fieldset>
        </td>
      </tr> 
    </table>
    
    <span id='responser'></span>
  </form>
</div>
</div>
<?php endif;?>
</div>
<?php include '../../common/view/footer.html.php';?>