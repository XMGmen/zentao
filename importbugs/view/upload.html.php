<?php include '../../common/view/header.lite.html.php';?>
<div class='uploadExcel'>
<form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform' data-type='ajax'>
	<div class='excel'>
		<input type='file' name='excelFile' id='excelfile'>
	</div>
	<div id="savebtn">
		<?php echo html::submitButton();?>
	</div>
</form>
</div>