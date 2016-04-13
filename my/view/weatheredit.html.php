<?php
/**
 * The edit view of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id: edit.html.php 4728 2013-05-03 06:14:34Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/header.lite.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::import($jsRoot . 'misc/date.js');?>
<div style= 'background-color:white' class='container mw-1400px' style='margin-top:0px'>
  <form class='form-condensed' method='post' target='hiddenwin' id='dataform'> 
    <table class='table table-form'>   
    <tr> 
      <th style='display:none' class='w-80px'><?php echo $lang->my->sprintID;?></th> 
      <td style='display:none' colspan='3'><?php echo html::input('sprintID', "$sprintID", "class='form-control' readOnly='true' ");?></td> 
    </tr> 
    <tr> 
      <th style='display:none'><?php echo $lang->my->weather;?></th> 
      <div style='text-align:center;'><?php echo html::textarea('weather', htmlspecialchars($weather), "rows='6' class='form-control' style='display:none'");?> 
        <img id="sunny" src="/zentao/theme/default/images/main/weather/sunny.png" onclick="myFun(this.id)" width="80px" height="80px" style="" class="weather_select"> 
        <img id="cloudy" src="/zentao/theme/default/images/main/weather/cloudy.png" onclick="myFun(this.id)" width="80px" height="80px" style="" class="weather_select"> 
        <img id="windy" src="/zentao/theme/default/images/main/weather/windy.png" onclick="myFun(this.id)" width="80px" height="80px" style="" class="weather_select">       
        <img id="rainy" src="/zentao/theme/default/images/main/weather/rainy.png" onclick="myFun(this.id)" width="80px" height="80px" style="" class="weather_select">
        <img id="thunder" src="/zentao/theme/default/images/main/weather/thunder.png" onclick="myFun(this.id)" width="80px" height="80px" style="" class="weather_select"> 
      </div>
    </tr> 
    <tr> 
      <th><?php echo $lang->my->weatherRemark;?></th> 
      <td colspan='2'> 
      <div id="titleLabel" class="text-danger" style="display:none;margin-top:10px">当天气状态不为晴天时，备注必填！</div> 
      <div><?php echo html::textarea('weatherRemark', htmlspecialchars($weatherRemark),"rows='6' cols= '80' style='margin-top: 20px;' class='form-control'");?></div> 
      </td> 
    </tr>  
      <tr><td></td><td colspan='2' class='text-center'><?php echo html::submitButton('保存',"onclick='return checkData()'");?></td></tr> 
    </table> 
  </form> 
</div> 
<script>  
function myFun(sId) {  
  var oImg = document.getElementsByTagName('img');  
  for (var i = 0; i < oImg.length; i++) {  
    if (oImg[i].id == sId) {  
      oImg[i].previousSibling.previousSibling.checked = true;  
      oImg[i].style.border = '3px solid #55aaff';  
    
      document.getElementById('weather').value =  oImg[i].id;  
      if( oImg[i].id!='sunny')  
       $("#titleLabel").show();  
      else $("#titleLabel").hide();  
    } else {  
      oImg[i].style.border = '1px solid rgb(180, 168, 168)';  
      
    }  
  }  
}  
function checkData(){  
  var weatherRemark=$("#weatherRemark").val();  
  var weatherState=document.getElementById("weather").value;  
  if(weatherState !="sunny"){  
  if(weatherRemark=="")  
  {  
     $("#titleLabel").show();      
    return false;  
  }  
  else return true;  
  }  
  return true;  
}  
</script> 
<?php include '../../common/view/footer.html.php';?>
