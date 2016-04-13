<?php
/**
 * The html template file of index method of index module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id: index.html.php 1947 2011-06-29 11:58:03Z wwccss $
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/sparkline.html.php';?>
<?php css::import($defaultTheme . 'index.css',   $config->version);?>
<?php if(count($sprints) != 0):?>
<div id="procreatesprint">
	<ul id="myTab" class="nav nav-tabs">
		<?php foreach ($sprints as $key => $value) :?>
		<li id="sprintviewid" <?php if($sprintID == $value->id) echo "class='active mytab'";?>>
			<?php echo html::a($this->createLink('my', 'index', "sprintID=$value->id"), (current($planNamesArray[$value->id])).'-'.($value->name));?>
		</li>
		<?php endforeach;?>
	</ul>
</div>
<div class="sprintrow_left">
  <div class="quarterpart">
    <?php include './weatherinfo.html.php';?>
  </div>
  <div class="quarterpart">
    <?php include './basicinfo.html.php';?>
  </div>
  <div class="quarterpart">
    <?php include './burninfo.html.php';?>
  </div>
  <div class="quarterpart">
    <?php include './msginfo.html.php';?>
  </div>

</div>

<div class="sprintrow_right">
  <div class="quarterpart_right">
    <?php include './otherinfo.html.php';?>
  </div>
</div>

<?php else:?>
  <div class="sprintrow">
  <?php include './empty.html.php';?>
  </div>
<?php endif;?>
<?php if(count($sprints) == 0):?>
<style>
.nosprint{
	color:red;
	font-size: 70px;
	margin-left:20%;
	margin-top:20%
	/*font-family:Aria*/
}
</style>
<p class='nosprint'> 啊哦，打的一手好酱油！</p>
<?php endif;?>
<?php include '../../common/view/footer.html.php';?>
