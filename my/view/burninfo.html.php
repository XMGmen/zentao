<?php 
if ($delayMsg != '') {
    echo "<script>alert('$delayMsg')</script>";
}
else if($isSprintDone == true) {
    echo "<script>alert('$isDoneMsg')</script>";
}?>
<div class='panel quarterblock'>
  <div class='panel-heading'>
    <strong><?php echo $lang->my->burninfo;?></strong>
    <div class='pull-right'>
      <?php common::printLink('project', 'computeBurn', 'reload=yes', $lang->my->computeBurn, 'hiddenwin', "title='{$lang->project->computeBurn}{$lang->project->burn}' class='btn btn-primary' id='computeBurn' style='display:none'"); ?>
      <?php echo html::a($this->createLink('sprint', 'burn',"projectID=$sprintID"), $lang->look . "&nbsp;<i class='icon icon-double-angle-right'></i>");?>
    </div>
  </div>
  
  <div class='container text-center bd-0'>
  <?php if($isOpeSprint):?>
  <div style="margin-top:70px;margin-bottom:70px">
    <div><span style="color:#ff5151;font-size:22px;font-weight:bold">运维Sprint不支持燃尽图查看</span></div>
  </div>
  <?php endif;?>
  <?php if(!$isOpeSprint):?>
  <div class='canvas-wrapper'>
    <div class='chart-canvas'>
      <!-- add style=width:300px by xufangye -->
      <canvas id='burnChart' width='800' height='400' data-bezier-curve='false' data-responsive='false' style="width:300px;"></canvas>
    </div>
  </div>
  <?php endif;?>
  <h4>
    <?php echo $projectName . ' ' . $this->lang->project->burn; ?>
  </h4>
</div>
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

    var burnChart = $("#burnChart").lineChart(data, { 
      animation: !($.zui.browser && $.zui.browser.ie === 8)
    });
}

// Update automatically
var update = '<?php echo $updateJudge;?>';
$(document).ready(function(){
    if (update == 1){
        document.getElementById("computeBurn").click();
    }
});

</script>
