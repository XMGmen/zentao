<?php  //include '../../common/view/header.lite.html.php';
?>
<div id="personImg">
<?php 

// $img='<img src='."'http://127.0.0.1/".$file->webPath."' class="."'myimage' ". "id='myimage'".'/>';
$img='<img src='."'http://".$_SERVER['HTTP_HOST'].'/'.$file->webPath."' class="."'myPersonImage' ". "id='myPersonImage'".'/>';
echo html::a(helper::createLink('myImage', 'editImage', "userId=$userId",'',true),$img,'',"class='iframe' title='编辑头像'",true);
?>
<div class='realname'><span class='myrealname'><?php echo $realName;?></span></div>
</div>

<?php include '../../common/view/footer.lite.html.php';?>