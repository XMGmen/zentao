<?php 
    include '../../common/view/header.lite.html.php';
    include '../../common/view/kindeditor.html.php';
?>

<div class='container mw-1400px input'>
  <form class='form-condensed' method='post'  enctype='multipart/form-data' id='dataform' data-type='ajax' >
    <table class='table table-form tablewidth'> 
     
     <tr>     
       <td colspan='3'><?php echo html::input('sprintRecordID', "$sprintRecordID", "class='form-control' readOnly='true' style='display:none'");?></td>       
      </tr>
      
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
       <td colspan='3'><?php echo html::input('username', "$username", "class='form-control' style='display:none'");?></td>
      </tr>
      
      <tr>     
        <th><?php echo $lang->mySprintBoard->spec;?></th>
        <td colspan='3'><?php echo html::textarea('spec', $sprintRecord->spec, "rows='9' class='form-control' ");?></td>
      </tr> 
       
      <tr>
       <td></td>
       <td colspan='3' class='text-center'><?php  //echo html::submitButton();echo html::backButton();?>
       </td>
      </tr>
    </table>
    </form>
</div>


