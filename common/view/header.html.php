<?php
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
include 'header.lite.html.php';
include 'chosen.html.php'; // changed
?>
<?php if(empty($_GET['onlybody']) or $_GET['onlybody'] != 'yes'):?>
<div id='topbar'>
	<!-- changed zentaotitle & img width by xufangye -->
	<div id="zentaotitle"><img src="/zentao/theme/default/images/main/zentao_logo.png" width="110px"></div>
	<div id="crumbs">
		<?php commonModel::printBreadMenu($this->moduleName, isset($position) ? $position : '',$sprintID); ?>
	</div>		
	<div class='pull-right' id='topnav'>
		<?php commonModel::printTopBar();?>
	</div>
	<div class='pull-right' id='topnav'>
		<?php commonModel::printSearchBox();?>
	</div>
</div>
<div id='header'>
	<?php echo $this->fetch('myImage','showImage');?>
	<?php commonModel::printMainAndModulemenu($this->moduleName, '', $defaultTheme);?>
</div>

<div id='wrap'>
<?php endif;?>
