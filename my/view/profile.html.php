<?php
/**
 * The profile view file of my module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     my
 * @version     $Id: profile.html.php 4694 2013-05-02 01:40:54Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='container mw-600px'>
  <table class='table table-borderless table-data ' style="margin-left: 25px">
    <tr>
      <th><?php echo $lang->user->realname;?></th>
      <td><?php echo $user->realname;?></td>
    </tr>
     <tr>
      <th><?php echo $lang->user->gender;?></th>
      <td><?php echo $lang->user->genders[$user->gender];?></td>
    </tr>  
    <tr>
      <th><?php echo $lang->user->join;?></th>
      <td><?php echo $user->join;?></td>
    </tr> 
  </table>
</div>
<div class='actions edit'>
      <?php echo html::a($this->createLink('my', 'editprofile'), $lang->user->editProfile, '', "class='btn btn-primary'");?>
</div>
<?php include '../../common/view/footer.html.php';?>
