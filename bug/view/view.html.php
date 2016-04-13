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

<?php
if ($projectID != 0)
{
     echo '<div id="procreatesprint">';
     echo '<ul id="myTab" class="nav nav-tabs">';
     echo '<li id="sprintviewid" >';
     echo  html::a($this->createLink('sprint', 'index', "sprintID=$projectID"),"User Story");
     echo '</li>';
     echo '<li id="sprintviewid">';
     echo html::a($this->createLink('sprint', 'task', "sprintID=$projectID"),"任务");
     echo '</li>';
     echo '<li id="sprintviewid" class="active">';
     echo html::a($this->createLink('sprint', 'bug', "sprintID=$projectID"),"Bug");
     echo '</li>';
     echo '<li id="sprintviewid">';
     echo html::a($this->createLink('sprint', 'review', "sprintID=$projectID"),"回顾会");
     echo '</li>';
     echo '<li id="sprintviewid">';
     echo html::a($this->createLink('sprint', 'burn', "sprintID=$projectID"),"燃尽图");
     echo '</li>';
     echo '</ul>';
     echo '</div>';
} else {
     echo '<div id="procreatesprint">';
      echo '<ul id="myTab" class="nav nav-tabs">';
      echo     '<li id="indexid">';
      echo   html::a($this->createLink('pro', 'index', "planID=$planID"),"Sprint");
      echo '</li>';
      echo '<li id="backlogid" >';
      echo html::a($this->createLink('pro', 'backlog', "planID=$planID"),"项目Back Log");
      echo '</li>';
      echo '<li id="bugid" class="active" >';
      echo html::a($this->createLink('pro', 'bug', "planID=$planID"),"Bug");
      echo '</li>';
      echo '<li id="teamid">';
      echo html::a($this->createLink('pro', 'team', "planID=$planID"),"团队");
      echo '</li>';
      echo '</ul>';
      echo '</div>';
}
?>
<div class='container mw-1400px'style='margin-top:0px'>
<div id='titlebar' style="margin:0px">
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['bug']);?> <strong><?php echo $bug->id;?></strong></span>
    <strong><?php echo $bug->title;?></strong>
    <?php if($bug->deleted):?>
    <span class='label label-danger'><?php echo $lang->bug->deleted;?></span>
    <?php endif; ?>
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
                <td> <?php
                  if(empty($modulePath)) {
                      echo "/";
                  } else {
                     foreach($modulePath as $key => $module) {
                         if(!common::printLink('bug', 'browse', "productID=$bug->product&browseType=byModule&param=$module->id", $module->name)) echo $module->name;
                         if(isset($modulePath[$key + 1])) echo $lang->arrow;
                     }
                  }
                ?> </td>
              </tr>
              <tr valign='middle'>
                <th><?php echo $lang->bug->plan;?></th> <!-- changedbyheng -->
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
      <!-- 这个actions已注释掉 -->
      <div class='actions'><?php // if(!$bug->deleted) echo $actionLinks;?></div>
      <fieldset id='commentBox' class='hide'>
        <legend><?php echo $lang->comment;?></legend>
        <form method='post' action='<?php echo inlink('edit', "bugID=$bug->id&comment=true")?>'>
          <div class="form-group"><?php echo html::textarea('comment', '',"rows='5' class='w-p100'");?></div>
          <?php echo html::submitButton() . html::backButton();?>
        </form>
      </fieldset>
        <!-- <div class='actions'>
	    <?php
	    $browseLink    = $app->session->bugList != false ? $app->session->bugList : inlink('browse', "productID=$bug->product");
	    $params        = "bugID=$bug->id";
	    $copyParams    = "productID=$productID&extras=bugID=$bug->id";
	    $convertParams = "productID=$productID&moduleID=0&from=bug&bugID=$bug->id";
	    if(!$bug->deleted)
	    {
	        ob_start();
	        echo "<div class='btn-group'>";
	        common::printIcon('bug', 'confirmBug', $params, $bug, 'button', 'search', '', 'iframe', true);
	        common::printIcon('bug', 'assignTo',   $params, '',   'button', '', '', 'iframe', true);
	        common::printIcon('bug', 'resolve',    $params, $bug, 'button', '', '', 'iframe showinonlybody', true);
	        common::printIcon('bug', 'close',      $params, $bug, 'button', '', '', 'text-danger iframe showinonlybody', true);
	        common::printIcon('bug', 'activate',   $params, $bug, 'button', '', '', 'text-success iframe showinonlybody', true);
	
	        common::printIcon('bug', 'toStory', "product=$bug->product&module=0&story=0&project=0&bugID=$bug->id", $bug, 'button', $lang->icons['story']);
	        common::printIcon('bug', 'createCase', $convertParams, '', 'button', 'sitemap');
	        echo '</div>';
	
	        echo "<div class='btn-group'>";
	        common::printIcon('bug', 'edit', $params);
	        common::printCommentIcon('bug');
	        common::printIcon('bug', 'create', $copyParams, '', 'button', 'copy');
	        common::printIcon('bug', 'delete', $params, '', 'button', '', 'hiddenwin');
	        echo '</div>';
	
	        echo "<div class='btn-group'>";
	        common::printRPN($browseLink, $preAndNext);
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
  </div> -->
    </div>
  </div>
  </div>
  </div>
<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>
