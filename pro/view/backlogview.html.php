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
<?php
include '../../common/view/header.lite.html.php';
include '../../common/view/chosen.html.php';

include '../../common/view/header.html.php';
//include 'validation.html.php';
?>
<div id="procreatesprint">
  <ul id="myTab" class="nav nav-tabs">
    <li id="proviewid" >
    	<?php echo html::a($this->createLink('pro', 'index', "planID=$planID"),"Sprint");?>
    </li>
    <li id="proviewid" class="active">
    <?php echo html::a($this->createLink('pro', 'backlog', "planID=$planID"),"Back Log");?>
    </li>
    <li id="proviewid">
    <?php echo html::a($this->createLink('pro', 'bug', "planID=$planID"),"Bug");?>
    </li>
    <li id="proviewid">
    <?php echo html::a($this->createLink('pro', 'team', "planID=$planID"),"团队");?>
    </li>
  </ul>
</div>

<div class='container mw-1400px'style='margin-top:0px'>
<div id='titlebar' style="margin:0px">
  <div class='heading'>
    <span class='prefix'><?php echo html::icon($lang->icons['story']);?> <strong><?php echo $story->id;?></strong></span>
    <strong><?php echo $story->title;?></strong>
    <?php if($story->version > 1):?>
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
                <th><?php echo $lang->pro->project;?></th> <!-- changedbyheng -->
                <td><?php if(isset($story->planTitle)) if(!common::printLink('pro', 'index', "planID=$story->plan", $story->planTitle)) echo $story->planTitle;?></td>
              </tr>
              
              <tr>
              <th><?php echo '下属story';?></th>    <!-- changedbyfxq -->   
              <td><?php  echo html::select('backLog', $stories, $backLogID, "class='form-control ' onchange='byStory(this.value)'");?></td>
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
                <th><?php echo $lang->pro->estimate;?></th>
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
        <legend><?php echo "Backlog描述";?></legend>
        <div class='article-content'><?php echo $story->spec;?></div>
      </fieldset>
      <fieldset>
        <legend><?php echo $lang->story->legendVerify;?></legend>
        <div class='article-content'><?php echo $story->verify;?></div>
      </fieldset>
      <?php echo $this->fetch('file', 'printFiles', array('files' => $story->files, 'fieldset' => 'true'));?>
      <?php include '../../common/view/action.html.php';?>
    </div>
  </div>
</div>
</div>
<script>
function byStory(storyID) {
    if(storyID) {
        location.href = createLink('sprint', 'storyview', "storyID=" + storyID);
    }
}
</script>
<?php include '../../common/view/footer.html.php';?>
