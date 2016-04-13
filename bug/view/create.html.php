<?php
/**
 * The create view of bug module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     bug
 * @version     $Id: create.html.php 4903 2013-06-26 05:32:59Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
include '../../common/view/header.html.php';
include '../../common/view/kindeditor.html.php';
js::set('holders', $lang->bug->placeholder);
js::set('page', 'create');
js::set('createRelease', $lang->release->create);
js::set('createBuild', $lang->build->create);
js::set('refresh', $lang->refresh);
?>
<div class='container mw-1400px'style='margin-top:15px'>
  <div id='titlebar' style="margin:0px">
    <div class='heading'>
      <span class='prefix'><?php echo html::icon($lang->icons['bug']);?></span>
      <strong><small class='text-muted'><?php echo html::icon($lang->icons['create']);?></small> <?php echo $lang->bug->create;?></strong>
    </div>
  </div>
  <form class='form-condensed' method='post' enctype='multipart/form-data' id='dataform' data-type='ajax'>
    <table class='table table-form'> 
      <tr>
        <th class='w-110px'><?php //echo $lang->bug->lblProductAndModule;
        	echo $lang->bug->product;
         ?></th>
        <td class='w-p35-f'>
          <?php echo html::select('product', $products, $productID, "onchange=loadAll(this.value) class='form-control' autocomplete='off' style='display:none'");
          		echo current($products);?>
        </td>
        <td>
          <div class='input-group w-p35-f' id='moduleIdBox'>
          <?php
          echo html::select('module', $moduleOptionMenu, $moduleID, "onchange='loadModuleRelated()' class='form-control chosen'");
          if(count($moduleOptionMenu) == 1)
          {
              echo "<span class='input-group-addon'>";
              echo html::a($this->createLink('tree', 'browse', "rootID=$productID&view=bug"), $lang->tree->manage, '_blank');
              echo '&nbsp; ';
              echo html::a("javascript:loadProductModules($productID)", $lang->refresh);
              echo '</span>';
          }
          ?>
          </div>
        </td>
      </tr>
      <tr>
        <th class='w-110px'><?php //echo $lang->bug->lblProductAndModule;
        	echo $lang->bug->plan;
         ?></th>
        <td class='w-p35-f'>
          <?php echo html::select('plan', $plans, $planID, "onchange=loadAll(this.value) class='form-control ' autocomplete='off' style='display:none'");
          echo current($plans);
      ?>
        </td>
      </tr>
      <?php 
      if(!$planIDplus){
      echo '<tr>';
        echo '<th>'; echo $lang->bug->project; echo '</th>';
        echo "<td><span id='projectIdBox'>";
        echo html::select('project', $projects, $projectID, "class='form-control ' onchange='loadProjectRelated(this.value)' autocomplete='off' style='display:none'");
        echo  current($projects);
        echo '</span></td>';
      echo '</tr>';
      }
      ?>
      <tr>
        <th><nobr><?php echo $lang->bug->lblAssignedTo;?></nobr></th>
        <td><span><?php echo html::select('assignedTo', $users, $assignedTo, "class='form-control'");?></span></td>
      </tr>
	  <tr>
        <th><?php echo $lang->bug->stage;?></th>
        <td>
          <div class='input-group'>
            <div class="required required-wrapper"></div>
            <?php
            echo html::select('stage', $lang->bug->stageList, $stage, "onchange=JugechooseRv() class='form-control'");
            ?>
          </div>
        </td>
      </tr>
	  <tr>
        <th><?php echo $lang->bug->type;?></th>
        <td>
          <div class='input-group'>
            <div class="required required-wrapper"></div>
            <?php
            echo html::select('type', $lang->bug->typeList, $type, "class='form-control'");
            ?>
          </div>
        </td>
      </tr>
	  <tr>
        <th><?php echo $lang->bug->severity;?></th>
        <td>
          <div class='input-group'>
            <div class="required required-wrapper"></div><?php echo html::select('severity', $lang->bug->severityList, $severity, "class='form-control'");?>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->bug->title;?></th>
        <td colspan='2'><?php echo html::input('title', $bugTitle, "class='form-control'");?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->bug->steps;?></th>
        <td colspan='2'>
          <div id='tplBoxWrapper'>
            <div class='btn-toolbar'>
              <div class='btn-group'><button id='saveTplBtn' type='button' class='btn btn-mini'><?php echo $lang->bug->saveTemplate?></button></div>
              <div class="btn-group">
              <button type='button' class='btn btn-mini dropdown-toggle' data-toggle='dropdown'><?php echo $lang->bug->applyTemplate?> <span class='caret'></span></button>
                <ul id='tplBox' class='dropdown-menu pull-right'>
                  <?php echo $this->fetch('bug', 'buildTemplates');?>
                </ul>
              </div>
            </div>
          </div>
          <?php echo html::textarea('steps', $steps, "rows='10' class='form-control'");?>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->bug->lblStory;?></th>
        <td colspan='2'>
          <span><?php echo html::select('story', $stories, $storyID, "class='form-control chosen'");?></span>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->bug->task;?></th>
        <td colspan='2'><span ><?php echo html::select('task', $task, $taskID, "class='form-control chosen'");?></span></td>
      </tr>
      <tr>
        <th><nobr><?php echo $lang->bug->lblMailto;?></nobr></th>
        <td colspan='2'>
          <?php 
          echo html::select('mailto[]', $users, str_replace(' ', '', $mailto), "class='form-control chosen' multiple");
          ?>
        </td>
        <td class='text-top'>
          <?php
          if($contactLists) echo html::select('', $contactLists, '', "class='form-control chosen' onchange=\"setMailto('mailto', this.value)\"");
          ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->bug->keywords;?></th>
        <td colspan='2'><?php echo html::input('keywords', $keywords, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->bug->files;?></th>
        <td colspan='2'><?php echo $this->fetch('file', 'buildform', 'fileCount=2&percent=0.85');?></td>
      </tr>
      <tr>
        <td></td>
        <td colspan='2'>
          <?php
          echo html::submitButton('',"onclick='return checkData()'") . html::backButton();
          echo html::hidden('case', (int)$caseID) . html::hidden('caseVersion', (int)$version);
          echo html::hidden('result', (int)$runID) . html::hidden('testtask', (int)$testtask);
          ?>
        </td>
      </tr>
    </table>
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
  passValue();
}

function checkData()
{
	var title=$("#title").val();
	var stage=$("#stage option:selected").text();
	var type=$("#type option:selected").text();
	var severity=$("#severity option:selected").text();
	
	if(stage==""){
		alert('Bug阶段不能为空！')
		return false;
	}
	if(type==""){
		alert('Bug类型不能为空！')
		return false;
	}
	if(severity==""){
		alert('Bug严重程度不能为空！')
		return false;
	}
	if(title==""){
		alert('Bug标题不能为空！')
		return false;
	}
	return true;
}

function passValue(){
	$("#title").val("【"+$("#stage option:selected").text()+"】");
}
</script>
<?php include '../../common/view/footer.html.php';?>
