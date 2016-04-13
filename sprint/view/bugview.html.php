<?php
/**
 * The view file of bug module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     bug
 * @version     $Id: view.html.php 4728 2013-05-03 06:14:34Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<style>
.myedit {
  margin-left:20px;
  float:right;
}
</style>
<div id="procreatesprint">
  <ul id="myTab" class="nav nav-tabs">
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'index', "sprintID=$sprintID"),"User Story");?>
    </li>
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'task', "sprintID=$sprintID"),"任务");?>
    </li>
    <li id="sprintviewid" class="active">
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

<div class='container mw-1400px'style='margin-top:0px'>
<div id='titlebar' style="margin:0px">
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['bug']);?> <strong><?php echo $bug->id;?></strong></span>
    <strong><?php echo $bug->title;?></strong>
    <?php if($bug->deleted):?>
    <span class='label label-danger'><?php echo $lang->bug->deleted;?></span>
    <?php endif; ?>
    <?php echo html::a($this->createLink('sprint', 'bugedit', "bugID=$bug->id",'',false),'编辑'."<i class='icon icon-pencil'></i>",'',"class='myedit '",true);?>
  </div>
</div>
<div class='row-table'>
  <div class='col-side'>
    <div class='main main-side'>
      <div class='tabs'>
       <fieldset>
      <legend><?php echo $lang->bug->legendBasicInfo;?></legend>      
        <div class='content'>
            <table class='table table-data table-condensed table-borderless table-fixed'>
              <tr valign='middle'>
                <th class='w-60px'><?php echo $lang->bug->product;?></th>
                <td><?php if(!common::printLink('product', 'productplan', "productID=$bug->product", $productName)) echo $productName;?></td>
              </tr>
              <tr>
                <th><?php echo $lang->bug->module;?></th>
                <td> 
                  <?php
                  if(empty($modulePath))
                  {
                      echo "/";
                  }
                  else
                  {
                     foreach($modulePath as $key => $module)
                     {
                         if(!common::printLink('bug', 'browse', "productID=$bug->product&browseType=byModule&param=$module->id", $module->name)) echo $module->name;
                         if(isset($modulePath[$key + 1])) echo $lang->arrow;
                     }
                  }
                  ?>
                </td>
              </tr>
              <tr valign='middle'>
                <th><?php echo $lang->sprint->project;?></th> <!-- changedbyheng -->
                <td><?php if(!$bug->plan or !common::printLink('pro', 'index', "planID=$bug->plan", $bug->planName)) echo $bug->planName;?></td>
              </tr>
              <tr>
                <th class='w-60px'><?php echo $lang->bug->project;?></th>
                <td><?php if($bug->project) echo html::a($this->createLink('sprint', 'index', "projectid=$bug->project"), $bug->projectName);?></td>
              </tr>
              <tr>
                <th class='w-60px'><?php echo $lang->bug->stage;?></th>
                <td><?php if(isset($lang->bug->stageList[$bug->stage])) echo $lang->bug->stageList[$bug->stage]; else echo $bug->stage;?></td>
              </tr>
              <tr>
                <th><?php echo $lang->bug->type;?></th>
                <td><?php if(isset($lang->bug->typeList[$bug->type])) echo $lang->bug->typeList[$bug->type]; else echo $bug->type;?></td>
              </tr>
              <tr>
                <th><?php echo $lang->bug->severity;?></th>
                <td><strong><?php echo zget($lang->bug->severityList, $bug->severity, $bug->severity);?></strong></td>
              </tr>
              <tr>
                <th><?php echo $lang->bug->status;?></th>
                <td class='bug-<?php echo $bug->status?>'><strong><?php echo $lang->bug->statusList[$bug->status];?></strong></td>
              </tr>
              <tr>
                <th><?php echo $lang->bug->activatedCount;?></th>
                <td><?php echo $bug->activatedCount;?></td>
              </tr>
              <tr>
                <th><?php echo $lang->bug->confirmed;?></th>
                <td><?php echo $lang->bug->confirmedList[$bug->confirmed];?></td>
              </tr>
              <tr>
                <th><?php echo $lang->bug->lblAssignedTo;?></th>
                <td><?php if($bug->assignedTo) echo $users[$bug->assignedTo] . $lang->at . $bug->assignedDate;?></td>
              </tr>
              <tr>
                <th><?php echo $lang->bug->mailto;?></th>
                <td><?php $mailto = explode(',', str_replace(' ', '', $bug->mailto)); foreach($mailto as $account) echo ' ' . $users[$account]; ?></td>
              </tr>
            </table>
          </div>
          </fieldset>
        </div>
      </div>
    </div>
      <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->bug->legendSteps;?></legend>
        <div class='content'><?php echo str_replace('<p>[', '<p class="stepTitle">[', $bug->steps);?></div>
      </fieldset>
      <?php echo $this->fetch('file', 'printFiles', array('files' => $bug->files, 'fieldset' => 'true'));?>
      <?php include '../../common/view/action.html.php';?>
      <fieldset id='commentBox' class='hide'>
        <legend><?php echo $lang->comment;?></legend>
        <form method='post' action='<?php echo inlink('edit', "bugID=$bug->id&comment=true")?>'>
          <div class="form-group"><?php echo html::textarea('comment', '',"rows='5' class='w-p100'");?></div>
          <?php echo html::submitButton() . html::backButton();?>
        </form>
      </fieldset>
        <div class='actions'>
	    <?php
	    $browseLink    = inlink('bug', "projectID=$sprintID");
	    $params        = "bugID=$bug->id";
	    $copyParams    = "productID=$productID&extras=bugID=$bug->id&planIDplus=0&projectIDplus=$projectID";
	    $convertParams = "productID=$productID&moduleID=0&from=bug&bugID=$bug->id";
	    if(!$bug->deleted)
	    {
	        ob_start();
	        echo "<div class='btn-group'>";
	        common::printIcon('bug', 'confirmBug', $params, $bug, 'button', 'search', '', 'iframe', true);
	        common::printIcon('bug', 'assignTo',   $params, '',   'button', '', '', 'iframe', true);
	        common::printIcon('bug', 'resolve',    $params, $bug, 'button', '', '', 'iframe showinonlybody', true);
	        //common::printIcon('bug', 'close',      $params, $bug, 'button', '', '', 'text-danger iframe showinonlybody', true);
	        if($bug->status == 'resolved') {
	        	common::printIcon('bug', 'close',      $params);
	        }
	        common::printIcon('bug', 'activate',   $params, $bug, 'button', '', '', 'text-success iframe showinonlybody', true);
	
	        $this->lang->story->create = $this->lang->story->createStory;
 	        common::printIcon('story', 'create', "projectID=$projectID&productID=0&moduleID=0&storyID=0&isStory=1&bugID=0&planIDplus=0");
	        common::printIcon('bug', 'createCase', $convertParams, '', 'button', 'sitemap');
	        echo '</div>';
	
	        echo "<div class='btn-group'>";
	        common::printIcon('sprint', 'bugedit', $params);
	        common::printCommentIcon('bug');
	        common::printIcon('bug', 'create', $copyParams, '', 'button', 'copy');
	        common::printIcon('bug', 'delete', $params, '', 'button', '', 'hiddenwin');
	        echo '</div>';
	
	        echo "<div class='btn-group'>";
	        common::printRPN2($browseLink, $preAndNext);
	        echo '</div>';
	
	        $actionLinks = ob_get_contents();
	        ob_end_clean();
	        echo $actionLinks;
	    }
	    else
	    {
	        common::printRPN($browseLink);
	    }
	    ?>
  </div>
  </div>
  </div>
  </div>
  </div>
<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>
