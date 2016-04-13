<?php
/**
 * The create view of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id: create.html.php 4728 2013-05-03 06:14:34Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php if(isset($tips)):?>
<?php $defaultURL = $this-> createLink('project', 'task', 'projectID=' . $projectID);?>
<?php include '../../common/view/header.lite.html.php';?>
<div style='background: #e5e5e5'>
  <div class='modal-dialog mw-500px' id='tipsModal'>
    <div class='modal-header'>
      <a href='<?php echo $defaultURL;?>' class='close'>&times;</a>
      <h4 class='modal-title' id='myModalLabel'><?php echo $lang->project->tips;?></h4>
    </div>
    <div class='modal-body'>
    <?php echo $tips;?>
    </div>
  </div>
</div>

<?php exit;?>
<?php endif;?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::import($jsRoot . 'misc/date.js');?>
<?php js::set('holders', $lang->project->placeholder);?>

<div id="procreatesprint">
  <ul id="myTab" class="nav nav-tabs">
    <li id='proviewid' class="active">
    <?php echo html::a($this->createLink('pro', 'index', "planID=$planID"),"Sprint");?>
    </li>
    <li id='proviewid'>
    <?php echo html::a($this->createLink('pro', 'backlog', "planID=$planID"),"Back Log");?>
    </li>
    <li id='proviewid'>
    <?php echo html::a($this->createLink('pro', 'bug', "planID=$planID"),"Bug");?>
    </li>
    <li id='proviewid'>
    <?php echo html::a($this->createLink('pro', 'team', "planID=$planID"),"团队");?>
    </li>
  </ul>
</div>

<div class='container mw-1400px' style='margin-top:0px'>
  <div id='titlebar' style='margin-top:0px'>
    <div class='heading'>
      <span class='prefix'><?php echo html::icon($lang->icons['project']);?></span>
      <strong><small class='text-muted'><i class='icon icon-plus'></i></small> <?php echo $lang->sprint->create;?></strong>
    </div>
  </div>
  <form class='form-condensed' method='post' target='hiddenwin' id='dataform'>
    <table class='table table-form'> 
      <tr>
        <th class='w-90px'><?php echo $lang->sprint->name;?></th>
        <td class='w-p25-f'>
        <div class='input-group'>
		    <div class="required required-wrapper"></div>
        <?php echo html::input('name', $name, "class='form-control'");?>
        </div>
        </td><td></td>
      </tr>
      <!--  
      <tr>
        <th><?php echo $lang->sprint->code;?></th>
        <td><?php echo html::input('code', $code, "class='form-control'");?></td>
      </tr>  
      -->
      <tr>
        <th><?php echo $lang->project->dateRange;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('begin',date('Y-m-d'), "class='form-control w-100px form-date' onchange='computeWorkDays()' placeholder='" . $lang->project->begin . "'");?>
            <span class='input-group-addon'><?php echo $lang->project->to;?></span>
            <div class="required required-wrapper"></div>
            <?php echo html::input('end', '', "class='form-control form-date' onchange='computeWorkDays()' placeholder='" . $lang->project->end . "'");?>
          </div>
        </td>
        <td style='text-align:left'>
          &nbsp; &nbsp; <?php echo html::radio('delta', $lang->project->endList , '', "onclick='computeEndDate(this.value)'");?>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->project->days;?></th>
        <td>
          <div class='input-group'>
          <?php echo html::input('days', '', "class='form-control'");?>
            <span class='input-group-addon'><?php echo $lang->project->day;?></span>
            <div class="required required-wrapper"></div>
          </div>
        </td>
      </tr>  
      <tr>
        <th><?php echo $lang->project->teamname;?></th>
        <td><?php echo html::input('team', $team, "class='form-control'");?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->sprint->type;?></th>
        <td>
          <?php echo html::select('type', $lang->project->typeList, '', "class='form-control'");?>
        </td>
        <td style='text-align:left'>
          <div class='help-block'><?php echo $lang->project->typeDesc;?></div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->project->manageProducts;?></th>        
        <td class="w-p25-f" id='productsBox' colspan="2" style='text-align:left'>
          <?php 
          echo html::select("products[]", $currProduct, $productID, "class='form-control' style='display:none' data-placeholder='{$lang->project->linkProduct}' multiple");
          echo current($currProduct);
          ?>
        </td>
      </tr>
       <tr>
        <th><?php echo $lang->sprint->managePlans;?></th>       
        <td class='w-p25-f' id='plansBox' colspan="2" style='text-align:left'>
          <?php 
            echo html::select("plans[]", $allPlans, $planID, "class='form-control' style='display:none' data-placeholder='{$lang->sprint->linkPlan}' multiple ");
            echo current($plans);
          ?>
        </td>
      </tr>
      <tr>
        <th rowspan='2'><?php echo $lang->project->PM;?></th>
      </tr>
      <tr>
        <td style='padding-left: 5px;' >
          <div class='input-group'>
            <?php echo html::select('PM', $pmUsers, $project->PM, "class='form-control chosen'");?>
            <div class="required required-wrapper"></div>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->sprint->desc;?></th>
        <td colspan='2'>
        <div class='input-group'>
        <?php echo html::textarea('descrip', '', "rows='6' class='form-control '");?>
        </div>
        </td><td ><div class="required required-wrapper"></div></td>
      </tr>  
      <tr>
        <th><?php echo $lang->project->acl;?></th>
        <td colspan='2' style='text-align:left'><?php echo nl2br(html::radio('acl', $lang->project->aclList, $acl, "onclick='setWhite(this.value);'", 'block'));?></td>
      </tr>  
      <tr id='whitelistBox' <?php if($acl != 'custom') echo "class='hidden'";?>>
        <th><?php echo $lang->project->whitelist;?></th>
        <td colspan='2'><?php echo html::checkbox('whitelist', $groups, $whitelist);?></td>
      </tr>
      <tr>
        <td></td><td colspan='2' class='text-center'><?php echo html::submitButton('',"onclick='return checkData2()';") . html::backButton();?></td>
      </tr>
    </table>
  </form>
</div>
<div class='modal fade' id='copyProjectModal'>
  <div class='modal-dialog mw-800px'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'>&times;</button>
      <h4 class='modal-title' id='myModalLabel'><?php echo $lang->project->copyTitle;?></h4>
    </div>
    <div class='modal-body'>
      <?php if(count($projects) == 1):?>
      <div class='alert alert-warning'>
        <i class='icon-info-sign'></i>
        <div class='content'>
          <p><?php echo $lang->project->copyNoProject;?></p>
        </div>
      </div>
      <?php else:?>
      <div id='copyProjects' class='row'>
      <?php foreach ($projects as $id => $name):?>
      <?php if(empty($id)):?>
        <?php if($copyProjectID != 0):?>
        <div class='col-md-4 col-sm-6'><a href='javascript:;' data-id='' class='cancel'><?php echo html::icon($lang->icons['cancel']) . ' ' . $lang->project->cancelCopy;?></a></div>
        <?php endif;?>
      <?php else: ?>
        <div class='col-md-4 col-sm-6'><a href='javascript:;' data-id='<?php echo $id;?>' class='nobr <?php echo ($copyProjectID == $id) ? ' active' : '';?>'><?php echo html::icon($lang->icons['project'], 'text-muted') . ' ' . $name;?></a></div>
      <?php endif; ?>
      <?php endforeach;?>
      </div>
      <?php endif;?>
    </div>
  </div>
</div>
<script>
function checkData2(){
	var PM = $("#PM").val();
	var descrip = $("#descrip").val();

	if(PM == '' ){
		alert("Sprint Master不能为空");
		return false;
	}
	
	if(descrip == '' ){
		alert("Sprint目标不能为空");
		return false;
	}

	return true;
}
</script>
<?php include '../../common/view/footer.html.php';?>
