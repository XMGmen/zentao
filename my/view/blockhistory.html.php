<div class='panel panel-block2' >
   <div class="panel-heading">
    <i class='icon icon-list-ul'></i> <strong><?php echo $lang->my->history;?></strong>
   </div>
   <?php if(empty($productStats)):?>
   <div class='panel-heading'>
     <i class='icon-cube icon'></i> <strong><?php echo $lang->my->home->products;?></strong>
   </div>
   <div class='panel-body text-center'><br><br>
      <?php echo html::a($this->createLink('product', 'create'), "<i class='icon-plus'></i> " . $lang->my->home->createProduct,'', "class='btn btn-primary'");?> &nbsp; &nbsp; <?php echo " <i class='icon-question-sign text-muted'></i> " . $lang->my->home->help; ?>
   </div>
   <?php else:?>
  <div id="product" class="nav-parent">   
      <a href="javascript:;"><i class="icon-chevron-right nav-parent-fold-icon"></i> <?php echo $lang->product->name2;?></a>
   </div>
    <div id="nav">
      <?php foreach($productStats as $product):?>   
      <p><?php echo html::a($this->createLink('product', 'productplan', 'productID=' . $product->id), $product->name, '', "title='$product->name'");?></p>
     <?php endforeach;?>
    </div>
  <?php endif;?>
  <?php if(count($projectStats) == 0):?>
   <div class='panel-heading'>
    <i class='icon-folder-close-alt icon'></i> <strong><?php echo $lang->my->home->projects;?></strong>
   </div>
   <div class='panel-body text-center'><br><br>
   <?php echo html::a($this->createLink('project', 'create'), "<i class='icon-plus'></i> " . $lang->my->home->createProject,'', "class='btn btn-primary'");?> &nbsp; &nbsp; <?php echo " <i class='icon-question-sign text-muted'></i> " . $lang->my->home->help; ?>
   </div>
   <?php else:?>
   <div id="project" class="nav-parent">
      <a href="javascript:;"><i class="icon-chevron-right nav-parent-fold-icon"></i> <?php echo $lang->project->name2;?></a>
   </div>
   <div id="nav">
     <?php $id = 0; ?>
     <?php foreach($projectStats as $project):?>   
      <p><?php echo html::a($this->createLink('sprint', 'index', 'project=' . $project->id), $project->name, '', "title='$project->name'");?></p>
     <?php endforeach;?>
     </div> 
  <?php endif;?> 
 </div>
<script>
$(function()
{
    var $projectbox = $('#projectbox');
    var $sparks = $projectbox.find('.spark');
    $sparks.filter(':lt(6)').addClass('sparked').projectLine();
    $sparks = $sparks.not(':lt(6)');
    var rowHeight = $sparks.first().closest('tr').outerHeight() - ($.zui.browser.ie === 8 ? 0.3 : 0);

    var scrollFn = false, scrollStart, i, id, $spark;
    $projectbox.on('scroll.spark', function(e)
    {
        if(!$sparks.length)
        {
            $projectbox.off('scroll.spark');
            return;
        }
        if(scrollFn) clearTimeout(scrollFn);

        scrollFn = setTimeout(function()
        {
            scrollStart = Math.floor(($projectbox.scrollTop() - 30) / (rowHeight)) + 1;
            for(i = scrollStart; i <= scrollStart + 7; i++)
            {
                id = '#spark-' + i;
                $spark = $(id);
                if($spark.hasClass('sparked')) continue;
                $spark.addClass('sparked').projectLine();
                $sparks = $sparks.not(id);
            }
        },100);
    });
});
$(document).ready(function() {
	
	$('#product').toggle(function() {
		//window.alert("ok");
		$(this).next("#nav").css("display","none");},
		function() {
			$(this).next("#nav").css("display","block");});
});
$(document).ready(function() {
	
	$('#project').toggle(function() {
		//window.alert("ok");
		$(this).next("#nav").css("display","none");},
		function() {
			$(this).next("#nav").css("display","block");});
});
</script>
