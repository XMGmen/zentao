<?php
/**
 * The edit file of bug module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     bug
 * @version     $Id: edit.html.php 4259 2013-01-24 05:49:40Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
include '../../common/view/header.html.php';
include '../../common/view/kindeditor.html.php';
js::set('page'                   , 'edit');
js::set('changeProductConfirmed' , false);
js::set('changeProjectConfirmed' , false);
js::set('confirmChangeProduct'   , $lang->bug->confirmChangeProduct);
js::set('planID'                 , $bug->plan);
js::set('oldProjectID'           , $bug->project);
js::set('oldStoryID'             , $bug->story);
js::set('oldTaskID'              , $bug->task);
js::set('oldOpenedBuild'         , $bug->openedBuild);
js::set('oldResolvedBuild'       , $bug->resolvedBuild);
?>
<div class='container mw-1400px'style='margin-top:0px'>
<form class='form-condensed' method='post' enctype='multipart/form-data' target='hiddenwin' id='dataform' style="margin-top:0px">
<div id='titlebar'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['bug']);?> <strong><?php echo $bug->id;?></strong></span>
    <strong><?php echo html::a($this->createLink('bug', 'view', "bugID=$bug->id"), $bug->title);?></strong>
    <small><?php echo html::icon($lang->icons['edit']) . ' ' . $lang->bug->edit;?></small>
  </div>
</div>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <div class='form-group'>
        <?php echo html::input('title', str_replace("'","&#039;",$bug->title), 'class="form-control" placeholder="' . $lang->bug->title . '"');?>
      </div>
      <fieldset class='fieldset-pure'>
        <legend><?php echo $lang->bug->legendSteps;?></legend>
        <div class='form-group'><?php echo html::textarea('steps', htmlspecialchars($bug->steps), "rows='18' class='form-control'");?></div>
      </fieldset>
      <fieldset class='fieldset-pure'>
        <legend><?php echo $lang->bug->legendComment;?></legend>
        <div class='form-group'><?php echo html::textarea('comment', '', "rows='6' class='form-control'");?></div>
      </fieldset>
      <fieldset class='fieldset-pure'>
        <legend><?php echo $lang->bug->legendAttatch;?></legend>
        <div class='form-group'><?php echo $this->fetch('file', 'buildform', 'filecount=2');?></div>
      </fieldset>
      <div class='actions' style='text-align:center'>
        <?php 
        echo html::submitButton();
        
        echo html::backButton();
        ?>
      </div>    
    </div>
  </div>
  <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->bug->legendBasicInfo;?></legend>
        <table class='table table-form'>
          <tr>
            <th class='w-80px'><?php echo $lang->bug->product;?></th>
            <td><?php echo $productName;?>
            <td><?php //echo html::select('product', $products, $productID, "onchange=loadAll(this.value); class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->productplan;?></th>
          <td><?php echo html::select('plan', $plans, $planID, "onchange=loadAll(this.value) class='form-control ' autocomplete='off' style='display:none'");
          echo current($plans);
          ?></td>
          </tr>
	  <tr>
            <th class='w-80px'><?php echo $lang->bug->project;?></th>
            <td><?php 
            if($belongToSprint) {
               echo html::select('project', $editSprints, key($projects), "onchange=loadAll(this.value) class='form-control ' autocomplete='off' ");
            }else {
               echo html::select('project', $editSprints, $planID, "onchange=loadAll(this.value) class='form-control ' autocomplete='off'");
            }
            ?></td>
          </tr>
           <tr>
            <th><?php echo $lang->bug->stage;?></th>
            <td><?php echo html::select('stage', $lang->bug->stageList, $bug->stage, "class='form-control' onChange=JugechooseRv()");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->type;?></th>
            <td>
              <?php
              if($bug->type != 'designchange') unset($lang->bug->typeList['designchange']);
              if($bug->type != 'newfeature')   unset($lang->bug->typeList['newfeature']);
              if($bug->type != 'trackthings')  unset($lang->bug->typeList['trackthings']);
              echo html::select('type', $lang->bug->typeList, $bug->type, "class='form-control'");
              ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->severity;?></th>
            <td><?php echo html::select('severity', $lang->bug->severityList, $bug->severity, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->pri;?></th>
            <td><?php echo html::select('pri', $lang->bug->priList, $bug->pri, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->status;?></th>
            <td><?php echo html::select('status', $lang->bug->statusList, $bug->status, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->confirmed;?></th>
            <td><?php echo $lang->bug->confirmedList[$bug->confirmed];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->assignedTo;?></th>
            <td><?php echo html::select('assignedTo', $users, $bug->assignedTo, "class='form-control '");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->story;?></th>
            <td><div id='storyIdBox'><?php echo html::select('story', $stories, $bug->story, "class='form-control '");?></div>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->task;?></th>
            <td><div id='taskIdBox'><?php echo html::select('task', $tasks, $bug->task, "class='form-control '");?></div></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->keywords;?></th>
            <td><?php echo html::input('keywords', $bug->keywords, 'class="form-control"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->mailto;?></th>
            <td><?php echo html::select('mailto[]', $users, str_replace(' ', '', $bug->mailto), 'class="form-control " multiple');?></td>
          </tr>
          <tr>
            <th class='w-80px'><?php echo $lang->bug->openedBy;?></th>
            <td><?php echo $users[$bug->openedBy];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->openedBuild;?></th>
            <td><span id='openedBuildBox'><?php echo html::select('openedBuild[]', $openedBuilds, $bug->openedBuild, 'size=4 multiple=multiple class="chosen form-control"');?></span></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->resolvedBy;?></th>
            <td><?php echo html::select('resolvedBy', $users, $bug->resolvedBy, "class='form-control '");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->resolvedDate;?></th>
            <td><?php echo html::input('resolvedDate', $bug->resolvedDate, 'class=form-control');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->resolvedBuild;?></th>
            <td><span id='resolvedBuildBox'><?php echo html::select('resolvedBuild', $resolvedBuilds, $bug->resolvedBuild, "class='form-control '");?></span></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->resolution;?></th>
            <td><?php echo html::select('resolution', $lang->bug->resolutionList, $bug->resolution, 'class=form-control onchange=setDuplicate(this.value)');?></td>
          </tr>
          <tr id='duplicateBugBox' <?php if($bug->resolution != 'duplicate') echo "style='display:none'";?>>
            <th><?php echo $lang->bug->duplicateBug;?></th>
            <td><?php echo html::input('duplicateBug', $bug->duplicateBug, 'class=form-control');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->closedBy;?></th>
            <td><?php echo html::select('closedBy', $users, $bug->closedBy, "class='form-control '");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->bug->closedDate;?></th>
            <td><?php echo html::input('closedDate', $bug->closedDate, 'class=form-control');?></td>
          </tr>
      </fieldset>
    </div>
  </div>
</div>
</form>
</div>
<script>
function JugechooseRv() {
  var stage = $("#stage").val();
  if(stage == 'codeReview') {
    $("#type").empty();
    $("#type").append("<option value=''></option>"); 
    $("#type").append("<option value='RVinterface'>RV-接口问题</option>"); 
    $("#type").append("<option value='RVlogistic'>RV-代码逻辑问题</option>"); 
    $("#type").append("<option value='RVformulation'>RV-代码规范</option>"); 
    $("#type").append("<option value='RVperformance'>RV-性能问题</option>"); 
    $("#type").append("<option value='RVrepeat'>RV-重复代码</option>"); 
    $("#type").append("<option value='RVrepeat'>RV-参数校验</option>"); 
    $("#type").append("<option value='RVconstruct'>RV-数据重构</option>"); 
    $("#type").append("<option value='others'>----------</option>"); 
  } else {
    $("#type").empty();
    $("#type").append("<option value=''></option>"); 
    $("#type").append("<option value='function'>功能问题</option>"); 
    $("#type").append("<option value='data'>数据问题</option>"); 
    $("#type").append("<option value='userview'>用户界面问题</option>"); 
    $("#type").append("<option value='design'>设计问题</option>"); 
    $("#type").append("<option value='performance'>性能问题</option>"); 	
    $("#type").append("<option value='config'>环境/配置问题</option>"); 
    $("#type").append("<option value='compatible>兼容问题</option>"); 
    $("#type").append("<option value='improvement'>业务改进</option>"); 
    $("#type").append("<option value='friendly'>易用性问题</option>"); 
    $("#type").append("<option value='security'>安全性问题</option>"); 
    $("#type").append("<option value='others'>----------</option>"); 
  }
}
</script>
<?php include '../../common/view/footer.html.php';?>
