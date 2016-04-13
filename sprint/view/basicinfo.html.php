<?php
/**
 * The view file of task module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     task
 * @version     $Id: view.html.php 4808 2013-06-17 05:48:13Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>

<!--<section>
  <article>
    <div  contenteditable="false">
      <div>
        <div style="border-bottom:2px solid">基本信息</div>
        <div style="margin-top:5px">Scrum Master:</div>
		<div style="border-bottom:1px solid">Sprint 周期:</div>
		<div>目标:</div>
		<div>实现sprint功能</div>
      </div>
    </div>
  </article>
</section> -->

<div style="border-bottom:1px solid">基本信息</div>
<div style="margin: 10px 20px 10px 20px">
<table>
    <tr>
	<th style="color: grey">Scrum Master:</th>
	<td><?php echo $scrummaster;?></td>
	</tr>
	
	<tr>
	<th style="color: grey">  Sprint 周期  :</th>
	<td><?php echo $begin;?><?php echo 至;?><?php echo $end;?></td>
	</tr>  
</table>
</div>

<div style="border-bottom:1px solid;margin-left:20px;margin-right:20px"></div>

<div style="color: grey;margin:10px 20px ">目标:</div>

<div style="margin-left:20px;margin-right:20px"><?php echo $desc;?></div>



