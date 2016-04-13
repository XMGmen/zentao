<?php
/**
 * The browse view file of plan module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     plan
 * @version     $Id: browse.html.php 4707 2013-05-02 06:57:41Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/sparkline.html.php';?>
<?php include '../../common/view/sortable.html.php';?>
<?php js::set('confirmDelete', $lang->productplan->confirmDelete)?>
<div id='titlebar'>
  <div class="heading">
    <?php
      echo html::select('product', $products, $productID, "class='selectbox' onchange='byProductplan(this.value, $productID)'");
    ?>
    <div id="allbutton">
    <?php
      echo html::a(helper::createLink($this->moduleName, "index", "locate=no"), "查看所有产品");
    ?>
    </div>
  </div>
</div>
<div id='featurebar'>
  <div class='heading'><i class='icon-flag'></i> <?php echo $lang->product->browseAll;?></div>
  <div class='actions'>
    <?php 
      if ($productplanID !=0) 
      {
          common::printIcon('productplan', 'create', "productID=$productplanID", '', 'button', 'plus');
      };
    ?>
    </div>
</div>
<div id="tablestyle">
<table class='table' id="productplan">
  <thead>
  <?php $vars = "productID=$productID&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
  <tr class='colhead'>
    <th class='w-id'>    <?php common::printOrderLink('id',    $orderBy, $vars, $lang->idAB);?></th>
    <th>                 <?php common::printOrderLink('title', $orderBy, $vars, $lang->productplan->title);?></th>
    <!-- <th class='w-p50'>   <?php common::printOrderLink('desc',  $orderBy, $vars, $lang->productplan->desc);?></th> -->
    <th class='w-p50'>   <?php echo $lang->productplan->desc;?></th>
    <th class='w-100px'> <?php common::printOrderLink('begin', $orderBy, $vars, $lang->productplan->begin);?></th>
    <th class='w-100px'> <?php common::printOrderLink('end',   $orderBy, $vars, $lang->productplan->end);?></th>
    <th class="w-100px {sorter: false}"><?php echo $lang->actions;?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($plans as $plan):?>
  <tr class='text-center'>
    <td><?php echo $plan->id;?></td>
    <td  title="<?php echo $plan->title?>"><?php echo html::a($this->createLink('pro', 'index', "id=$plan->id"), $plan->title);?></td>
    <td class='content'><div style="height:25px;margin-top:10px"><?php echo $plan->desc;?></div></td>
    <td><?php echo $plan->begin;?></td>
    <td><?php echo $plan->end;?></td>
    <td >
      <?php
      common::printIcon('productplan', 'edit', "planID=$plan->id&product=$productplanID", '', 'list');

      if(common::hasPriv('productplan', 'delete'))
      {
          $deleteURL = $this->createLink('productplan', 'delete', "planID=$plan->id&confirm=yes");
          echo html::a("javascript:ajaxDelete(\"$deleteURL\",\"productplan\",confirmDelete)", '<i class="icon-remove"></i>', '', "class='btn-icon' title='{$lang->productplan->delete}'");
      }
      ?>
    </td>
  </tr>
  <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='6'><?php $pager->show();?></td></tr></tfoot>
</table>
</div>
<?php js::set('orderBy', $orderBy)?>
<?php include '../../common/view/footer.html.php';?>
