<?php /* include '../../common/view/form.html.php' */;?>
 <?php js::set('confirmDelete', $lang->mySprintBoard->confirmDelete)?>
 <style>
tr {
  height:30px;
}
td{
 width:15px;
}
 .mylink {color:black;} 
 .mylink2{color:orange;}
 .mylink :visited {color:black;}
 .mylink :active {color:black;}
 .center { width: 200px; display: block; margin: 0 auto; } /*changed by xufangye*/
.mycreate{margin-left:20px;display:none;}
#sprintRecordList{ margin: 0 auto; margin-bottom: 10px; }
</style>

<div class='panel quarterblock'>
  <div class='panel-heading'>
    <strong><?php echo $lang->my->msginfo;?></strong>
    <div class='pull-right'>
      <?php echo html::a($this->createLink('mySprintBoard', 'create', "sprintID=$sprintID",'',true),'发表'."<i class='icon icon-plus'></i>&nbsp;&nbsp;",'',"class='iframe' title='发表留言'",true);?>
      <?php echo html::a($this->createLink('mySprintBoard', 'more',"SprintID=$sprintID&status=all&orderBy=isTop_desc,lastEditedDate_desc&recTotal=0&recPerPage=10&pageID=1&isShow2=0"), $lang->more . "&nbsp;<i class='icon icon-double-angle-right'></i>");?>
    </div>
  </div>
  <div>
  <?php //include "../../mySprintBoard/view/index.html.php";?>
  <?php js::set('confirmDelete', $lang->mySprintBoard->confirmDelete)?>
 <div>
<form method='post' id='sprintBoardForm'>
  <!-- table styles fixed by xufangye / 修改了下面留言板table/tr/td的若干样式 -->
  <table class='table tablesorter table-condensed table-fixed tablewidth' id='sprintRecordList' style="width:96%" >
  <thead style="display:none">
    <tr class='colhead' style='visibility:hidden'><?php $vars = "sprintID=$sprintID&orderBy=%s"; ?>
     <th class='w-20px  {sorter:false}'> </th>
     <th class='w-70px {sorter:false}'> </th>
     <th class='w-30px {sorter:false}'> </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($sprintRecords as $sprintRecord):?>
    <tr class='text' id="sprintRecord<?php echo $sprintRecord->id?>" onmouseover='show(this.id)' onmouseout='hide(this.id)' style="height:41px;">  
      <td align="center" style='width:15px; color:#888; font-weight:bold;'><?php 
      if($sprintRecord->isTop){
        echo '<span style="color:orange">'.$realnames[$sprintRecord->id];}
      else
        echo $realnames[$sprintRecord->id];
      ?></td>
      <td align="left" style='width:50px;'><?php  
          $simpleSpec=preg_replace('/<p[^>]*>/', '<span>&nbsp;', $sprintRecord->spec);
          $simpleSpec=preg_replace('/<\/p>/', '</span>', $simpleSpec);
          $simpleSpec=preg_replace('/<div[^>]*>/', '<span>&nbsp;', $simpleSpec);
          $simpleSpec=preg_replace('/<\/div>/', '</span>', $simpleSpec);
          
          $os=$simpleSpec;
          $simpleSpec=preg_replace('/(<ol>)/', '', $simpleSpec);
          $simpleSpec=preg_replace('/(<\/ol>)/', '', $simpleSpec);
          if($os!=$simpleSpec) {
              $i=1;
              do {
                  $s=$simpleSpec;
                  $simpleSpec=preg_replace('/<li[^>]*>/', "<span>&nbsp;$i.", $simpleSpec,1);
                  $simpleSpec=preg_replace('/<\/li[^>]*>/', '</span>', $simpleSpec,1);
                  $i++;
              }while($s!=$simpleSpec);
          } else {
              $simpleSpec=preg_replace('/(<ul>)/', '', $simpleSpec);
              $simpleSpec=preg_replace('/(<\/ul>)/', '', $simpleSpec);
              $simpleSpec=preg_replace('/<li[^>]*>/', "<span>&nbsp;•", $simpleSpec);
              $simpleSpec=preg_replace('/<\/li[^>]*>/', '</span>', $simpleSpec);
          }
          $simpleSpec=preg_replace('/<br \/>/', '', $simpleSpec);
          $mystyle=$sprintRecord->isTop?'mylink2':'mylink';
          echo html::a(helper::createLink('mySprintBoard', 'sprintRecordView', "sprintRecordID=$sprintRecord->id",'',true),$simpleSpec,'',"class='iframe $mystyle' title='查看留言'",true);
      ?></td>
      <td align="right" style="color:#ccc; font-style:italic;"><?php  $tm=explode(" ",$sprintRecord->lastEditedDate);    
      $s1=explode('-',$tm[0]);
      $s2=explode(':',$tm[1]);
      echo date('m-d  H:i',mktime($s2[0],$s2[1] , $s2[2], $s1[1], $s1[2], $s1[0]));?>
      </td>
     
    <?php endforeach;?>
  </tbody>
  
  <tfoot>
  </tfoot>
  </table>
  <?php common::printIcon('mySprintBoard', 'create', "sprintID=$sprintID",'', 'button', '', '', 'iframe', true,"id='mycreate'");?>
</form>
</div>
</div>
</div>
<?php 
echo '<script>';
if($recTotal==0)
{	
	echo '$(\'#mycreate\').removeClass(\'mycreate\');';
	echo '$(\'#mycreate\').addClass(\'center\');';
}else{
	echo '$(\'#mycreate\').removeClass(\'center\');';
	echo '$(\'#mycreate\').addClass(\'mycreate\');';
}
echo '</script>';
?>
<script>
function hide(id)
{
	$('#'+id).removeAttr('bgcolor');
	$('#'+id).removeClass('active');
	id='#'+id+'edit';
	//$(id).hide(1000);
	$(id).removeAttr("style").attr("style", "display: none;");
}
function show(id)
{
	$('#'+id).attr('bgcolor','#f5f5f5');
	id='#'+id+'edit';
	//$(id).show(1000);
	$(id).removeAttr("style").attr("style", "display: block;");
}
</script>
