<?php 
    include '../../common/view/header.html.php';
    include '../../common/view/kindeditor.html.php';
?>

<div class='container mw-1400px input'>
  <form class='form-condensed' method='post'  enctype='multipart/form-data' id='dataform' data-type='ajax' >
    <table class='table table-form tablewidth'> 
      <tr>
        <th class='w-80px'><?php //echo $lang->mySprintBoard->sprintID;?></th>
        <td colspan='3'><?php echo html::input('sprintID', "$sprintID", "class='form-control' readOnly='true' style='display:none'");?></td>
      </tr>
      
      <tr>
        <th class='w-80px'><?php //echo $lang->mySprintBoard->sprintName;?></th>
       <td colspan='3'><?php echo html::input('sprintName', "$sprintName", "class='form-control' readOnly='true' style='display:none'");?></td>
      </tr>
      
      
       <tr>
        <th class='w-80px'><?php //echo $lang->mySprintBoard->username;?></th>
       <td colspan='3'><?php echo html::input('username', $this->app->user->account, "class='form-control' style='display:none'");?></td>
       </tr>
      
       <tr>
        <th><?php echo $lang->mySprintBoard->spec;?></th>
        <td colspan='3'><?php echo html::textarea('spec', $sprintRecord->spec, "rows='9' class='form-control'");?></td>
       </tr>  
       
     <tr>
        <td></td>
        <td colspan='3' class='text-center'>
         <input type='button'  class='btn btn-primary' value='保存' onclick='submitForm()'>
        <?php  //echo html::submitButton();echo html::backButton();?>
       </td>
       </tr>
    </table>
    </form>
</div>
<script>
var oldtxt=$('#spec').attr('value');
function submitForm()
{
	var txt=$('#spec').attr('value');
	var txt2=txt.replace(/<[^>]*>/g,'');
	var txt3=txt2.replace(/\n/g,'');
	var txt4=txt3.replace(/&nbsp;/g,'');
	var txt5=$.trim(txt4);
 	if(txt5.length==0){
 		alert('留言内容不能为空！');
 	}else{
 		$('#dataform').submit();
 	}
}
</script>
