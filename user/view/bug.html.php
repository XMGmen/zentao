<?php
/**
 * The bug view file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: bug.html.php 4771 2013-05-05 07:41:02Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php //include '../../common/view/tablesorter.html.php';?>
<?php include './featurebar.html.php';?>
<div class='sub-featurebar'>
  <ul class='nav'>
    <?php
    echo "<li id='assignedToTab'>"  . html::a(inlink('bug', "account=$account&type=assignedTo"), $lang->user->assignedTo) . "</li>";
    echo "<li id='openedByTab'>"    . html::a(inlink('bug', "account=$account&type=openedBy"),   $lang->user->openedBy)   . "</li>";
    echo "<li id='resolvedByTab'>"  . html::a(inlink('bug', "account=$account&type=resolvedBy"), $lang->user->resolvedBy) . "</li>";
    echo "<li id='closedByTab'>"    . html::a(inlink('bug', "account=$account&type=closedBy"),   $lang->user->closedBy)   . "</li>";
    ?>
  </ul>
</div>
<table class='table tablesorter table-fixed'>
   <thead>
      <tr>
        <?php $vars = "account=$account&type=$type&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
        <th class='w-id'>      <?php common::printOrderLink('id',           $orderBy, $vars, $lang->idAB);?></th>
        <th class='w-severity'><?php common::printOrderLink('severity',     $orderBy, $vars, $lang->bug->severityAB);?></th>
        <th class='w-pri'>     <?php common::printOrderLink('pri',          $orderBy, $vars, $lang->priAB);?></th>
        <th class='w-type'>    <?php common::printOrderLink('type',         $orderBy, $vars, $lang->typeAB);?></th>
        <th>                   <?php common::printOrderLink('title',        $orderBy, $vars, $lang->bug->title);?></th>
        <th class='w-user'>    <?php common::printOrderLink('openedBy',     $orderBy, $vars, $lang->openedByAB);?></th>
        <th class='w-user'>    <?php common::printOrderLink('resolvedBy',   $orderBy, $vars, $lang->bug->resolvedBy);?></th>
        <th class='w-resolution'><?php common::printOrderLink('resolution', $orderBy, $vars, $lang->bug->resolutionAB);?></th>
      </tr>
    </thead>
  <tbody>
  <?php foreach($bugs as $bug):?>
  <tr class='text-center'>
    <td><?php echo html::a($this->createLink('bug', 'view', "bugID=$bug->id"), $bug->id, '_blank');?></td>
    <td><span class='<?php echo 'severity' . zget($lang->bug->severityList2, $bug->severity, $bug->severity)?>'><?php echo zget($lang->bug->severityList2, $bug->severity, $bug->severity)?></span></td>
    <td><span class='<?php echo 'pri' . zget($lang->bug->priList, $bug->pri, $bug->pri)?>'><?php echo zget($lang->bug->priList, $bug->pri, $bug->pri)?></span></td>
    <td><?php echo $lang->bug->typeList[$bug->type]?></td>
    <td class='text-left nobr'><?php echo html::a($this->createLink('bug', 'view', "bugID=$bug->id"), $bug->title);?></td>
    <td><?php echo $users[$bug->openedBy];?></td>
    <td><?php echo $users[$bug->resolvedBy];?></td>
    <td><?php echo $lang->bug->resolutionList[$bug->resolution];?></td>
  </tr>
  <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='8'><?php echo $pager->show();?></td></tr></tfoot>
</table>
<script language='javascript'>$("#bugTab").removeClass('active');</script>
<?php include '../../common/view/footer.html.php';?>
