<?php include '../../common/view/header.lite.html.php';?>
<?php // include '../../common/view/sparkline.html.php';?>
<?php // include '../../common/view/sorter.html.php';?>
<?php js::set('confirmDelete', $lang->mySprintBoard->confirmDelete)?>
<style>
tr{
	height:35px;
}
td{
    width:50px;
}
</style>

<div class='myIndex'>
<form method='post' id='sprintBoardForm'>
  <table class='table tablesorter table-condensed table-fixed tablewidth' id='sprintRecordList'>
  
  <thead>
    <tr class='colhead'><?php $vars = "sprintID=$sprintID&orderBy=%s"; ?>
    </tr>
  </thead>
  
  <tbody>
    <?php foreach($sprintRecords as $sprintRecord):?>
    <tr class='text' id="sprintRecord<?php echo $sprintRecord->id?>">
      <td><?php echo $realnames[$sprintRecord->id];?></td>
      <td align="left" ><?php echo html::a(helper::createLink('mySprintBoard', 'sprintRecordView', "sprintRecordID=$sprintRecord->id",'',true),$sprintRecord->spec,'',"class='iframe' title='查看留言'",true);?></td>      
      
      <td class='text-right'>     
      <?php
      
      if($sprintRecord->isTop)
      {
      echo ' <img src='.$defaultTheme.'images/main/weather/'.$sprintRecord->isTop.'.png style=\'width: 20px;height:20px\'/>'; 
      } 
      ?>
      </td>
      
      <td align="right"><?php 
      $tm=explode(" ",$sprintRecord->lastEditedDate);
      
      $s1=explode('-',$tm[0]);
      $s2=explode(':',$tm[1]);
      
      
      echo date('m-d  H:i',mktime($s2[0],$s2[1] , $s2[2], $s1[1], $s1[2], $s1[0]));
      ?></td>
     
    <?php endforeach;?>
  </tbody>
  
  <tfoot>
    <tr>
      <td colspan=4>     
      <?php //下面这段代码是为了实现发表留言的模态框;?>
      <?php common::printIcon('mySprintBoard', 'create', "sprintID=$sprintID",'', 'button', '', '', 'iframe', true);?>
           
      <?php //$pager->show();?>
      </td>
    </tr>
  </tfoot>
  </table>
</form>
</div>


<?php include '../../common/view/footer.html.php';?>

