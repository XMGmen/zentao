<?php
/**
 * The edit view file of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: edit.html.php 4645 2013-04-11 08:32:09Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>

<?php 
include '../../common/view/header.lite.html.php';
include '../../common/view/chosen.html.php';
include '../../common/view/header.html.php';

?>
<div class='container mw-1400px'style='margin-top:0px'>
<form class='form-condensed' method='post' enctype='multipart/form-data' target='hiddenwin' id='dataform'>
<div id='titlebar' style='margin-top:0px'>
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['story']);?> <strong><?php echo $story->id;?></strong></span>
    <strong><?php echo html::a($this->createLink('story', 'view', "storyID=$story->id"), $story->title);?></strong>
    <small><?php echo html::icon($lang->icons['edit']) . ' ' . $lang->story->edit;?></small>
  </div>
</div>
<div class='row-table'>
  <div class='col-main'>
    <div class='main'>
      <fieldset>
        <legend><?php echo $lang->Backlog->legendSpec;?></legend>
        <div class='article-content'><?php echo $story->spec;?></div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->verify;?></legend>
        <div class='article-content'><?php echo $story->verify;?></div>
      </fieldset>
      <fieldset class='fieldset-pure'>
        <legend><?php echo $lang->story->comment;?></legend>
        <div class='form-group' style='margin:0'>
          <?php echo html::textarea('comment', '', "rows='5' class='form-control'");?>
        </div>
      </fieldset>
      <div class='actions actions-form' style='text-align:center'>
        <?php 
         echo html::submitButton('', '', 'btn-primary');
        echo html::linkButton($lang->goback, helper::createLink('pro', 'backlog', "planID=$planID"));
        ?>
      </div>
      
    </div>
  </div>
  <div class='col-side'>
    <div class='main main-side'>
      <fieldset>
        <legend><?php echo $lang->Backlog->legendBasicInfo;?></legend>
        <table class='table table-form'>
          <tr>
            <th class='w-80px'><?php echo $lang->story->product;?></th>
            <td><?php echo $productName; ?></td>
          </tr>
          <tr>
            <th><?php echo $lang->story->module;?></th>
            <td id='moduleIdBox'>
            <?php
            echo html::select('module', $moduleOptionMenu, $story->module, 'class="form-control chosen"');
            ?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->pro->project;?></th> <!-- changedbyheng -->
            <td id='planIdBox'>
            <?php echo $plans[$planID];?>
            </td>
          </tr>		  
          <tr>
            <th><?php echo $lang->story->source;?></th>
            <td><?php echo html::select('source', $lang->story->sourceList, $story->source, 'class=form-control');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->story->status;?></th>
            <td><span class='story-<?php echo $story->status;?>'><?php echo $lang->story->statusList[$story->status];?></span></td>
          </tr>
          <?php if($story->status != 'draft'):?>
          <tr>
            <th><?php echo $lang->story->stage;?></th>
            <td><?php echo html::select('stage', $lang->story->stageList, $story->stage, 'class=form-control');?></td>
          </tr>
          <?php endif;?>
          <tr>
            <th><?php echo $lang->story->pri;?></th>
            <td><?php echo html::select('pri', $lang->story->priList, $story->pri, 'class=form-control');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->pro->estimate;?></th> <!-- changedbyheng -->
            <td><?php echo html::input('estimate', $story->estimate, "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->story->keywords;?></th>
            <td><?php echo html::input('keywords', $story->keywords, 'class=form-control');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->story->mailto;?></th>
            <td><?php echo html::select('mailto[]', $users, str_replace(' ' , '', $story->mailto), "class='form-control' multiple");?></td>
          </tr>
        </table>
		<table class='table table-form'>
          <tr>
            <th class='w-70px'><?php echo $lang->story->openedBy;?></th>
            <td><?php echo $users[$story->openedBy];?></td>
          </tr>
          <tr>
            <th><?php echo $lang->story->assignedTo;?></th>
            <td><?php echo html::select('assignedTo', $users, $story->assignedTo, 'class="form-control"');?></td>
          </tr>
          <?php if($story->reviewedBy):?>
          <tr>
            <th><?php echo $lang->story->reviewedBy;?></th>
            <td><?php echo html::select('reviewedBy[]', $users, str_replace(' ', '', $story->reviewedBy), 'class="form-control chosen" multiple');?></td>
          </tr>
          <?php endif;?>
          <?php if($story->status == 'closed'):?>
          <tr>
            <th><?php echo $lang->story->closedBy;?></th>
            <td><?php echo html::select('closedBy', $users, $story->closedBy, 'class="form-control"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->story->closedReason;?></th>
            <td><?php echo html::select('closedReason', $lang->story->reasonList, $story->closedReason, 'class="form-control"');?></td>
          </tr>
          <?php endif;?>
        </table>
      </fieldset>
    </div>
  </div>
</div>
</form>
</div>
<?php include '../../common/view/footer.html.php';?>
