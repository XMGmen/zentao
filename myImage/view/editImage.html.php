<?php include '../../common/view/header.lite.html.php';?>
<div class='uploadImg'>
 <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform' data-type='ajax'>
<div class='img'>
<img src="http://<?php echo $_SERVER['HTTP_HOST'].'/'.$file->webPath; ?>" class='myimage' id='myimage'/>
<input type='file' name='myFile' id='file'>
</div>
<div>
<!-- <input type='button' id='cancel' value='取消' class='btn'> -->
<?php echo html::submitButton();?>
</div>
</form>
</div>
<script></script>