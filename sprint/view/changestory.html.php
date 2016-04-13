<?php
/**
 * The change view file of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: change.html.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php 
include '../../common/view/header.lite.html.php';
include '../../common/view/chosen.html.php';
include '../../common/view/header.html.php';
?>
 <div id="procreatesprint">
  <ul id="myTab" class="nav nav-tabs">
    <li id="sprintviewid" class="active">
    <?php echo html::a($this->createLink('sprint', 'index', "projectID=$projectID"),"User Story");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'task', "projectID=$projectID"),"任务");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'bug', "projectID=$projectID"),"Bug");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'review', "projectID=$projectID"),"回顾会");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'burn', "projectID=$projectID"),"燃尽图");?>
    </li>
	<li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'team', "projectID=$projectID"),"团队");?>
    </li>
  </ul>
</div>
<div class='container mw-1400px'style='margin-top:0px'>

  <div id='titlebar' style='margin-top:0px'>
    <div class='heading'>
      <span class='prefix'><?php echo html::icon($lang->icons['story']);?> <strong><?php echo $story->id;?></strong></span>
      <strong><?php echo html::a($this->createLink('sprint', 'storyview', "storyID=$story->id&version=$story->version&from=project&param=$projectID"), $story->title);?></strong>
      <small><?php echo html::icon($lang->icons['change']) . ' ' . $lang->story->change;?></small>
    </div>
  </div>
  <form method='post' enctype='multipart/form-data' target='hiddenwin' class='form-condensed'>
    <table class='table table-form'>
      <tr>
        <th class='w-80px'><?php echo $lang->story->reviewedBy;?></th>
        <td>
          <div class="input-group w-p35-f">
            <?php echo html::select('assignedTo', $users, $story->assignedTo, 'class="form-control chosen"');?>
            <span class="input-group-addon">
            <?php echo html::checkbox('needNotReview', $lang->story->needNotReview, '', "id='needNotReview' {$needReview}");?>
            </span>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->story->storytitle;?></th>
        <td><?php echo html::input('title', $story->title, 'class="form-control"');?></td>
      </tr>
      <tr>
        <th><?php echo $lang->story->storyspec;?></th>
        <td><?php echo html::textarea('spec', htmlspecialchars($story->spec), 'rows=8 class="form-control"');?><span class='help-block'><?php echo $lang->story->specTemplate;?></span></td>
      </tr>
      <tr>
        <th><?php echo $lang->story->verify;?></th>
        <td><?php echo html::textarea('verify', htmlspecialchars($story->verify), 'rows=6 class="form-control"');?></td>
      </tr>
      <tr>
        <th><?php echo $lang->story->comment;?></th>
        <td><?php echo html::textarea('comment', '', 'rows=5 class="form-control"');?></td>
      </tr>
      <tr>
        <th><?php echo $lang->attatch;?></th>
        <td><?php echo $this->fetch('file', 'buildform', 'filecount=2');?></td>
      </tr>
      <tr>
        <td></td><td class='text-center'>
        <?php 
        echo html::submitButton('', '', 'btn-primary');
        echo html::linkButton($lang->goback, helper::createLink('sprint', 'index', "projectID=$projectID"));
        ?>
        </td>
      </tr>
    </table>
  </form>
</div>

</div>
<?php include '../../common/view/footer.html.php';?>
