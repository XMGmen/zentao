<?php
/**
 * The create view of task module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     task
 * @version     $Id: create.html.php 5090 2013-07-10 05:49:24Z zhujinyonging@gmail.com $
 * @link        http://www.zentao.net
 */
?>

<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/form.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>

<div id="procreatesprint">
  <ul id="myTab" class="nav nav-tabs">
    <li id="sprintviewid" class="active">
    <?php echo html::a($this->createLink('sprint', 'index', "sprintID=$sprintID"),"User Story");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'task', "sprintID=$sprintID"),"任务");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'bug', "sprintID=$sprintID"),"Bug");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'review', "sprintID=$sprintID"),"回顾会");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'burn', "sprintID=$sprintID"),"燃尽图");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'team', "sprintID=$sprintID"),"团队");?>
    </li>
  </ul>
</div>

<div class='container mw-1400px'>
  <div id='titlebar' style='margin-top:0px'>
    <div class='heading'>
      <span class='prefix'><?php echo html::icon($lang->icons['task']);?></span>
      <strong><small class='text-muted'><?php echo html::icon($lang->icons['create']);?></small> <?php echo $lang->task->create;?></strong>
    </div>
  </div>
  <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform' data-type='ajax'>
    <table class='table table-form'> 
      <tr>
        <th class='w-100px'><?php echo $lang->task->project;?></th>
        <td colspan='3' style='text-align:left'><?php echo $project->name;?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->task->module;?></th>
        <td id='moduleIdBox' class='w-p25-f'><?php echo html::select('module', $moduleOptionMenu, $task->module, "class='form-control chosen' onchange='setStories(this.value,$project->id)'");?></td><td></td><td class='w-150px'></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->type;?></th>
        <td><?php echo html::select('type', $lang->task->typeList, $task->type, 'class=form-control onchange="setOwners(this.value)"');?></td><td></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->assignedTo;?></th>
        <td><?php echo html::select('assignedTo[]', $members, $task->assignedTo, "class='form-control chosen'");?></td>
        <td>
          <button type='button' class='btn btn-link<?php echo $task->type == 'affair' ? '' : ' hidden'?>' id='selectAllUser'><?php echo $lang->task->selectAllUser ?></button>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->task->story;?></th>
        <td colspan='2' style='text-align:left'>
        
          <div class='input-group' id='input-group' style='margin-top: 13px'>
            <?php 
            if($isFromStory){
              echo current($stories);
            	echo html::select('story', $stories, $task->story, "class='form-control' onchange='setStoryRelated();' style='display:none;'");
            }else{
            echo html::select('story', $stories, $task->story, "class='form-control' onchange='setStoryRelated();'");
            }?>
          </div>
        </td>
      </tr>  
      <tr>
        <th><?php echo $lang->task->name;?></th>
        <td colspan='2'>
          <div class='input-group'>
            <?php echo html::input('name', $task->name, "class='form-control'");?>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->task->desc;?></th>
        <td colspan='2'><?php echo html::textarea('desc', $task->desc, "rows='7' class='form-control'");?></td><td></td>
      </tr>  
      <tr>
        <th><?php echo $lang->task->pri;?></th>
        <td><?php echo html::select('pri', $lang->task->priList, $task->pri, 'class=form-control');?></td><td></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->estimate;?></th>
        <td>
          <div class="input-group">
            <?php echo html::input('estimate', $task->estimate, "class='form-control'")?>
            <span class="input-group-addon"><?php echo $lang->sprint->taskhour;?></span> <!-- changedbyheng -->
          </div>
        </td><td><div class='help-block' style='text-align:left'><?php echo $lang->task->estimateTip?></div></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->estStarted;?></th>
        <td><?php echo html::input('estStarted', $task->estStarted, "class='form-control form-date'");?></td><td></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->deadline;?></th>
        <td><?php echo html::input('deadline', $task->deadline, "class='form-control form-date'");?></td><td></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->mailto;?></th>
        <td colspan='2'><?php echo html::select('mailto[]', $project->acl == 'private' ? $members : $users, str_replace(' ', '', $task->mailto), "multiple class='form-control'");?></td>
        <td class='text-top'><?php if($contactLists) echo html::select('', $contactLists, '', "class='form-control chosen' onchange=\"setMailto('mailto', this.value)\"");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->files;?></th>
        <td colspan='2'><?php echo $this->fetch('file', 'buildform');?></td>
      </tr>
      <tr>
        <th><?php echo $lang->task->afterSubmit;?></th>
        <td colspan='3' style='text-align:left'><?php echo html::radio('after', $lang->task->afterChoices, 'continueAdding');?></td>
      </tr>
      <tr>
        <td></td>
        <td colspan='3'><?php echo html::submitButton() . html::backButton();?></td>
      </tr>
    </table>
    <span id='responser'></span>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
