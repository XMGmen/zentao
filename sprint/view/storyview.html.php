<?php
/**
 * The view file of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: view.html.php 4952 2013-07-02 01:14:58Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
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
<div class='container mw-1400px'style='margin-top:0px'>
<div id='titlebar' style='margin:0px'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['story']);?> <strong><?php echo $story->id;?></strong></span>
    <strong><?php echo $story->title;?></strong>
    <?php if($story->version > 1):?>
    <small class='dropdown'>
      <a href='#' data-toggle='dropdown' class='text-muted'><?php echo '#' . $version;?> <span class='caret'></span></a>
      <ul class='dropdown-menu'>
      <?php
      for($i = $story->version; $i >= 1; $i --)
      {
          $class = $i == $version ? " class='active'" : '';
          echo '<li' . $class .'>' . html::a(inlink('view', "storyID=$story->id&version=$i"), '#' . $i) . '</li>'; 
      }
      ?>
      </ul>
    </small>
    <?php endif; ?>
  </div>
</div>

<div class='row-table'>
  <div class='col-side'>
    <div class='main main-side'>
      <div class='tabs'>
	   <fieldset>       
          <legend><?php echo $lang->story->legendBasicInfo;?></legend>  
        <div class='content'>
          <div class='tab-pane active' id='legendBasicInfo'>
            <table class='table table-data table-condensed table-borderless'>
              <tr>
                <th class='w-70px'><?php echo $lang->story->product;?></th>
                <td><?php common::printLink('product', 'productplan', "productID=$story->product", $product->name);?></td>
              </tr>
              <tr>
                <th><?php echo $lang->story->module;?></th>
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
                        if(!common::printLink('product', 'browse', "productID=$story->product&browseType=byModule&param=$module->id", $module->name)) echo $module->name;
                        if(isset($modulePath[$key + 1])) echo $lang->arrow;
                    }
                }
                ?>
                </td>
              </tr>
              <tr>
                <th><?php echo $lang->story->plan;?></th> 
                <td><?php if(isset($story->planTitle)) if(!common::printLink('pro', 'index', "planID=$story->plan", $story->planTitle)) echo $story->planTitle;?></td>
              </tr>
            <tr>
              <th><?php echo $lang->story->sprint;?></th>                        
              <td><?php if($story->project) echo html::a(helper::createLink('sprint', 'index', "projectID=$story->project"), $projectName);?></td>
            </tr>
             <tr>
              <th><?php echo $lang->story->backlogsource;?></th>                        
              <td><?php if($story->backLog) echo html::a(helper::createLink('pro', 'backlogview', "planID=$story->plan&backLogID=$story->backLog"),$backLogTitle);?></td>
            </tr>
              <tr>
                <th><?php echo $lang->story->source;?></th>
                <td><?php echo $lang->story->sourceList[$story->source];?></td>
              </tr>
              <tr>
                <th><?php echo $lang->story->status;?></th>
                <td class='story-<?php echo $story->status?>'><?php echo $lang->story->statusList[$story->status];?></td>
              </tr>
              <tr>
                <th><?php echo $lang->story->stage;?></th>
                <td><?php echo $lang->story->stageList[$story->stage];?></td>
              </tr>
              <tr>
                <th><?php echo $lang->story->pri;?></th>
                <td><?php echo $lang->story->priList[$story->pri];?></td>
              </tr>
              <tr>
                <th><?php echo $lang->story->estimatetime;?></th> <!-- changedbyheng -->
                <td><?php echo $story->estimate;?></td>
              </tr>
              <tr>
                <th><?php echo $lang->story->keywords;?></th>
                <td><?php echo $story->keywords;?></td>
              </tr>
              <tr>
                <th><?php echo $lang->story->legendMailto;?></th>
                <td><?php $mailto = explode(',', $story->mailto); foreach($mailto as $account) {if(empty($account)) continue; echo "<span>" . $users[trim($account)] . '</span> &nbsp;'; }?></td>
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
        <legend><?php echo $lang->story->legendSpec;?></legend>
        <div class='article-content'><?php echo $story->spec;?></div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendVerify;?></legend>
        <div class='article-content'><?php echo $story->verify;?></div>
      </fieldset>
      <?php echo $this->fetch('file', 'printFiles', array('files' => $story->files, 'fieldset' => 'true'));?>
      <?php include '../../common/view/action.html.php';?>
      <div class='actions'>
        <?php if(!$story->deleted) echo $actionLinks;?>
      </div>
      <fieldset id='commentBox' class='hide'>
        <legend><?php echo $lang->comment;?></legend>
        <form method='post' action='<?php echo inlink('edit', "storyID=$story->id")?>'>
          <div class="form-group"><?php echo html::textarea('comment', '',"rows='5' class='w-p100'");?></div>
          <?php echo html::submitButton() . html::backButton();?>
        </form>
      </fieldset>
    </div>
  </div>
</div>
</div>
<?php include '../../common/view/syntaxhighlighter.html.php';?>
<?php include '../../common/view/footer.html.php';?>
