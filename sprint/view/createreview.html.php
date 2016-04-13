<?php
include '../../common/view/header.html.php';
include '../../common/view/datepicker.html.php';
include '../../common/view/kindeditor.html.php';
include '../../common/view/sparkline.html.php';
include '../../common/view/chosen.html.php';
include '../../common/view/treeview.html.php';
include '../../common/view/tablesorter.html.php';
js::import($jsRoot . 'misc/date.js');
?>
<div id='titlebar'>
  <div class="heading">
  <?php  echo html::select('proj', $projectStats, $projectID, "class='selectbox' onchange='byProj(this.value)'"); ?>
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
  </ul>
</div>
<div id="tablestyle">
<div class='container mw-1400px'>
  <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform' data-type='ajax'>
  <div id='titlebar'  style='margin-top:0px;background-color:#F7F7F7;margin:0px'>
	  <div class='heading'>
	    <strong><?php echo $lang->review->legendBasicInfo;?></strong>
	  </div>
  </div>
  <div id='titlebar'  style='margin-top:0px;background-color:#F7F7F7;margin:0px'>
	  <div class='heading'>
	    <strong><?php echo $lang->review->sprintInfo;?></strong>
	  </div>
  </div>
    <table class='table table-form'> 
 	  <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->planRange;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('begin',$sprintBegin, "class='form-control w-100px ' readOnly='true'");?>
            <span class='input-group-addon' style='background-color:#F7F7F7'><?php echo $lang->project->to;?></span>
            <?php echo html::input('end', $sprintEnd, "class='form-control' readOnly='true' ");?>
          </div>
        </td>
        <td style='visibility:hidden'>
          &nbsp; &nbsp; <?php echo html::radio('delta', $lang->project->endList , '', "onclick='computeEndDate(this.value)'");?>
        </td>
      </tr>
      <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->realRange;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('real_begin','', "class='form-control w-100px form-date' onchange='computeWorkDays()' placeholder='" . $lang->project->begin . "'");?>
            <span class='input-group-addon' style='background-color:#F7F7F7'><?php echo $lang->project->to;?></span>
            <?php echo html::input('real_end', '', "class='form-control form-date' onchange='computeWorkDays()' placeholder='" . $lang->project->end . "'");?>
          </div>
        </td>
        <td style='visibility:hidden'>
          &nbsp; &nbsp; <?php echo html::radio('delta', $lang->project->endList , '', "onclick='computeEndDate(this.value)'");?>
        </td>
      </tr>
      <tr style="display:none">
        <th><?php echo "SprintID";?></th>
        <td colspan='2'>
          <div class='input-group'>
            <?php echo html::input('sprintID', $sprintID, "class='form-control' readOnly='true'");?>
          </div>
        </td>
      </tr>
      <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->goal;?></th>
        <td colspan='2'><?php echo html::textarea('sprintDesc', $sprintDesc, "rows='3' class='form-control' readOnly='true'");?></td>
      </tr> 
    </table>
    
	<div id='titlebar'  style='margin-top:0px;background-color:#F7F7F7;margin:0px'>
	  <div class='heading'>
	    <strong><?php echo $lang->sprint->stroyPoint;?></strong>
	  </div>
	</div>
    <table class='table table-form'> 
 	  <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->estimatePoints;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('estimatePoints',$estimatePoints, "style='width:15%'");?>点
          </div>
        </td>
      </tr>
      <tr>
        <th  style="font-weight:lighter"><?php echo $lang->sprint->realPoints;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('realPoints',$realPoints, "style='width:15%'");?>点
          </div>
        </td>
      </tr>
      <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->explain;?></th>
        <td colspan='2'><?php echo html::textarea('expl', $expl, "rows='7' class='form-control'");?></td>
      </tr>
      <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->referenceStory;?></th>
        <td colspan='2'><?php echo html::textarea('referenceStory', $referenceStory, "rows='15' class='form-control'");?></td><td></td>
      </tr> 
    </table>
    
    <div id='titlebar'  style='margin-top:0px;background-color:#F7F7F7;margin:0px'>
	  <div class='heading'>
	    <strong><?php echo $lang->sprint->conference;?></strong>
	  </div>
	</div>
    <table class='table table-form'> 
 	 <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->time;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('date','', "class=' w-140px form-date h-30px'  onchange='computeWorkDays()' placeholder='" . $lang->sprint->conferenceTime . "'");?>
          	&nbsp; &nbsp;
          	<?php echo html::input('time',$time, "style='width:25%;height:120%'");?>
          	<span style="font-style:italic;color:gray">建议填写格式如 12:35 - 15:00</span>
          </div>
        </td>
      </tr>
      <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->place;?></th>
        <td colspan='2'><?php echo html::textarea('place', $place, "rows='1' class='form-control' style='width:100%'");?></td>
      </tr>
      <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->person;?></th>
        <td colspan='2'><?php echo html::textarea('persons', $persons, "rows='1' class='form-control' style='width:100%'");?></td>
      </tr>
      <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->completeFuncReview;?></th>
        <td colspan='2'><?php echo html::textarea('completeFunc', $completeFunc, "rows='15' class='form-control'");?></td><td></td>
      </tr> 
      <tr>
      <th style="font-weight:lighter"><?php echo $lang->sprint->summary;?></th>
        <?php $summary=$lang->sprint->steps ;?>
        <td colspan='2'><?php echo html::textarea('summary', $summary, "rows='15' class='form-control'");?></td><td></td>
      </tr> 
      <tr>
        <th style="font-weight:lighter"><?php echo $lang->sprint->other;?></th>
        <td colspan='2'><?php echo html::textarea('other', $other, "rows='15' class='form-control'");?></td><td></td>
      </tr> 
      <tr>
      <th></th>
      <td style='text-align: center'> 
      <?php echo html::submitButton('',"onclick='return checkData()'").html::backButton();?>
      </td>
      </tr>
    </table>
  </form>
</div>
</div>
<script>
function checkData(){
	var real_begin = $("#real_begin").val();
	var real_end = $("#real_end").val();
	var estimatePoints = $("#estimatePoints").val();
	var realPoints = $("#realPoints").val();
	var expl = $("#expl").val();
	var referenceStory = $("#referenceStory").val();
	var date = $("#date").val();
	var time = $("#time").val();
	var place = $("#place").val();
	var persons = $("#persons").val();
	var completeFunc = $("#completeFunc").val();
	var summary = $("#summary").val();
	var other = $("#other").val();

	if(real_begin == '' ){
		alert("迭代实际开始时间不能为空");
		return false;
	}
	
	if(real_end == '' ){
		alert("迭代实际结束时间不能为空");
		return false;
	}
	
	if(estimatePoints == "" ){
		alert("预估点数不能为空");
		return false;
	}
	if(isNaN(estimatePoints)){
		alert("预估点数只能为数字");
		return false;
	}
	if(realPoints == ""){
		alert("实际点数不能为空");
		return false;
	}
	if(isNaN(realPoints)){
		alert("实际点数只能为数字");
		return false;
	}
	if(expl == "" ){
		alert("调整说明不能为空");
		return false;
	}
	if(referenceStory == "" ){
		alert("基准故事不能为空");
		return false;
	}
	if(date == "" ){
		alert("会议日期不能为空");
		return false;
	}
	if(time == "" ){
		alert("会议时间不能为空");
		return false;
	}
	if(place == "" ){
		alert("地点不能为空");
		return false;
	}
	if(persons == "" ){
		alert("与会人员不能为空");
		return false;
	}
	if(completeFunc == "" ){
		alert("完成功能演示不能为空");
		return false;
	}
	if(summary == "" ){
		alert("总结内容不能为空");
		return false;
	}

	return true;
}
</script>
<?php include '../../common/view/footer.html.php';?>