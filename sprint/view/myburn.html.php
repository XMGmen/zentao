<?php include '../../common/view/header.lite.html.php';?>


  <div style="border-bottom:1px solid;font-size:20px;">
    <?php echo 燃尽图;?>
      <span style="float: right">
      <?php echo html::a($this->createLink('sprint', 'burn',"projectID=$projectID"), $lang->look . "&nbsp;<i class='icon icon-double-angle-right'></i>");?>
      </span> 
  </div>


<div class='container text-center bd-0'>

  <div class='canvas-wrapper'>
    <div class='chart-canvas'>
      <canvas id='burnChart' width='800' height='400' data-bezier-curve='true' data-responsive='false'></canvas>
    </div>
  </div>
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
            color: "#CCC",
            fillColor: "rgba(0,0,0,0)",
            showTooltips: false,
            data: <?php echo $chartData['baseLine']?>
        },
        {
            label: "<?php echo $lang->project->Left?>",
            color: "#0033CC",
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