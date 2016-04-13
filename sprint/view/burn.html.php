<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/chart.html.php';?>

<?php js::set('projectID', $projectID);?>
<?php js::set('type', $type);?>
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
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'bug', "sprintID=$sprintID"),"Bug");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'review', "sprintID=$sprintID"),"回顾会");?>
    </li>
    <li id="sprintviewid" class="active">
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
<?php if ($delayMsg != '') echo "<script>alert('$delayMsg')</script>";?>
<div class='container text-center bd-0'>
  <div class='clearfix'>
    <div class='actions pull-right'>
      <?php if($interval):?>
      <div class='input-group input-group-sm pull-left w-100px'>
        <?php echo html::select('interval', $dayList, $interval, "class='form-control' style='display:none' ");?>
      </div>
      <?php endif;?>
      <?php if(!$isOpeSprint):?>
      <div class='input-group input-group-sm pull-left w-100px'>
        <?php
        $weekend = ($type == 'noweekend') ? 'withweekend' : "noweekend";
        echo "<span class='input-group-btn'>";
        echo html::a($this->createLink('sprint', 'burn', "projectID=$projectID&type=$weekend&interval=$interval"), $lang->project->$weekend, '', "class='btn'");
        echo '</span>';
        echo "<span class='input-group-btn'>";
        common::printLink('project', 'computeBurn', 'reload=yes', $lang->project->computeBurn, 'hiddenwin', "title='{$lang->project->computeBurn}{$lang->project->burn}' class='btn btn-primary' id='computeBurn'");
        echo '</span>';
        ?>
      </div>
      <?php endif;?>
    </div>
  </div>
  <?php if($isOpeSprint):?>
  <div style="margin-top:200px;margin-bottom:200px">
    <div width='800' height='400'><span style="color:red;font-size:40px;font-weight:bold">运维Sprint不支持燃尽图查看！</span></div>
  </div>
  <?php endif;?>
  <?php if(!$isOpeSprint):?>
  <div class='canvas-wrapper'>
    <div class='chart-canvas'>
      <canvas id='burnChart' width='800' height='400' data-bezier-curve='false' data-responsive='false'></canvas>
    </div>
  </div>
  <?php endif;?>
  <h2>
    <?php 
      echo $projectName . ' ' . $this->lang->project->burn;
    ?>
  </h2>
</div>
<script>
function initBurnChar()
{
    var data = 
    {
        labels: <?php echo json_encode($chartData['labels'])?>,
        datasets: [
        {
            label: "<?php echo $lang->project->baseline;?>",
            color: "#b5d3e9",
            fillColor: "rgba(0,0,0,0)",
            showTooltips: false,
            data: <?php echo $chartData['baseLine']?>
        },
        {
            label: "<?php echo $lang->project->Left?>",
            color: "#007eff",
            data: <?php echo $chartData['burnLine']?>
        }]
    };

    var burnChart = $("#burnChart").lineChart(data, {animation: !($.zui.browser && $.zui.browser.ie === 8)});
}

// Update automatically
var update = '<?php echo $updateJudge;?>';
$(document).ready(function(){
    if (update == 1){
        document.getElementById("computeBurn").click();
    }
});

</script>

<?php include '../../common/view/footer.html.php';?>
