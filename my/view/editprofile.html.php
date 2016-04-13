<?php
/**
 * The edit view of user module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id: editprofile.html.php 4728 2013-05-03 06:14:34Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='container mw-800px'>
  <div id='titlebar'>
    <div class='heading'><i class='icon-pencil'></i> <?php echo $lang->my->editProfile;?></div>
  </div>
  <form method='post' target='hiddenwin' class='form-condensed' id='dataform'>
   
      <table class='table table-form'> 
        <tr>
          <th class='w-90px'><?php echo $lang->user->realname;?></th>
          <td><?php echo html::input('realname', $user->realname, "class='form-control' id='realname' onkeypress='return noAuto(event)'");?></td>
        <tr>
          <th><?php echo $lang->user->gender;?></th>
          <td><?php echo html::radio('gender', $lang->user->genderList, $user->gender);?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->join;?></th>
          <td><?php
              echo $user->join;
              echo html::hidden('join',$user->join);
              ?>
          </td>
        </tr>
      </table>
    <div class='text-center'>
     <input type='button'  class='btn btn-primary' value='保存' onclick='submitForm()'>
    <?php //echo html::submitButton('', '', 'btn-primary') . ' &nbsp; ' . html::backButton();?></div>
  </form>
</div>
<script>
function submitForm()
{
 	var name=$("#realname").val();	
 	if(name=='')
 	{
 		alert('真实姓名不能为空!');
 	}else if(name.length>5)
 	{
 		alert('真实姓名不能超过5个字符!');
 	}
	else{
		$('#dataform').submit();
	}
}
$('#realname').keyup(function(event){
	var keyCode=event.keyCode;
	if(keyCode==32)
	{	
		alert('真实姓名不能包含空格!');
		var name=$("#realname").val();
		name=name.replace(new RegExp("　","gm"),"");	
		name=name.replace(new RegExp(" ","gm"),"");	
		$('#realname').attr('value',name);
	}
})
function noAuto(event)
{
	if(event.keyCode==13)
		return false;
}
</script>

<?php include '../../common/view/footer.html.php';?>
