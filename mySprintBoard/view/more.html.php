<?php
include '../../common/view/header.html.php';
include '../../common/view/sparkline.html.php';
include '../../common/view/sorter.html.php';
include '../../common/view/kindeditor.html.php';
include '../../common/view/datepicker.html.php';
include '../../common/view/treeview.html.php';
include '../../common/view/form.html.php';
?>

<?php js::set('confirmDelete', $lang->mySprintBoard->confirmDelete)?>
<style>
 .mylink {color:black;} 
 .mylink2{color:orange;}
 .mylink :visited {color:black;}
 .mylink :active {color:black;}
 tr active{background-color:'black'!important;}
 .notshow{display:none;}
 .show{display:block;}
</style>
<div id='titlebar'>
  <div class="heading">
    <?php echo html::select('sprint', $sprints, $sprintID, "class='selectbox' onchange='bySprint(this.value)'");?>
  </div>
</div>
<div class="tabsbar notshow" id='myshowTitleBar' >
  <ul id="myTab" class="nav nav-tabs">
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('sprint', 'index', "sprintID=$sprintID"),"User Story");?>
    </li>
    <li id="sprintviewid" >
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
    <li id="sprintviewid" class="active">
	<?php echo html::a($this->createLink('mySprintBoard', 'more', "sprintID=$sprintID"),"留言板");?>
    </li>
  </ul>
</div>

<div id='featurebar'>
    <div class='heading' >
    <span class='prefix'><?php echo html::icon($lang->icons['team']);?></span>
    <strong><?php echo $lang->mySprintBoard->title;echo " ($recTotal)"?> </strong>
    </div>  
</div>
<div id="tablestyle">
<form method='post' id='sprintBoardForm'>
  <table class='table tablesorter table-condensed table-fixed tablewidth' id='sprintRecordList'>
      <?php $vars = "projectID=$projectID&status=$status&parma=$param&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage"; ?>
  <thead>
  <tr class='colhead'><?php $vars = "sprintID=$sprintID&orderBy=%s"; ?>
    <th class='w-40px ' ><?php echo $lang->mySprintBoard->username;?></th>
    <th class='w-200px '><?php echo $lang->mySprintBoard->spec;?></th>
    <th class='w-20px ' ><?php echo $lang->mySprintBoard->edit;?></th>
    <th class='w-20px ' ><?php echo $lang->mySprintBoard->top;?></th>
    <th class='w-30px ' ><?php echo $lang->mySprintBoard->openedDate;?></th>
    </tr>
  </thead>
  
  <tbody>
  <?php foreach($sprintRecords as $sprintRecord):?>
 
    <tr  class='text' id="sprintRecord<?php echo $sprintRecord->id?>" onmouseover='show(this.id)'  onmouseout='hide(this.id)' onclick='bgcolor(this.id)'>
     <td align="center"><img src='<?php echo $srcs[$sprintRecord->id];?>' style='width:40px;height:40px;border-radius:50%;'/>
     <?php
      if($sprintRecord->isTop) {
          echo '<span style="color:orange">'.$realnames[$sprintRecord->id].'</span>';
      } else {
          echo $realnames[$sprintRecord->id];
      }
      ?></td>
     <td align="left" ><?php 
        $simpleSpec = preg_replace('/<p[^>]*>/', '<span>&nbsp;', $sprintRecord->spec);
        $simpleSpec = preg_replace('/<\/p>/', '</span>', $simpleSpec);
        $simpleSpec = preg_replace('/<div[^>]*>/', '<span>&nbsp;', $simpleSpec);
        $simpleSpec = preg_replace('/<\/div>/', '</span>', $simpleSpec);
        
        $os = $simpleSpec;
        $simpleSpec = preg_replace('/(<ol>)/', '', $simpleSpec);
        $simpleSpec = preg_replace('/(<\/ol>)/', '', $simpleSpec);
        if ( $os != $simpleSpec ) {
            $i = 1;
            do {
                $s = $simpleSpec;
                $simpleSpec = preg_replace('/<li[^>]*>/', "<span>&nbsp;&nbsp;$i.&nbsp;", $simpleSpec,1);
                $simpleSpec = preg_replace('/<\/li[^>]*>/', '</span>', $simpleSpec,1);
                $i++;
            } while ( $s != $simpleSpec );
        } else {
            $simpleSpec =preg_replace('/(<ul>)/', '', $simpleSpec);
            $simpleSpec =preg_replace('/(<\/ul>)/', '', $simpleSpec);
            $simpleSpec =preg_replace('/<li[^>]*>/', "<span>&nbsp;&nbsp;•", $simpleSpec);
            $simpleSpec =preg_replace('/<\/li[^>]*>/', '</span>', $simpleSpec);
        }
        $simpleSpec=preg_replace('/<br \/>/', '', $simpleSpec);
        $mystyle=$sprintRecord->isTop?'mylink2':'mylink';
        echo html::a(helper::createLink('mySprintBoard', 'sprintRecordView', "sprintRecordID=$sprintRecord->id",'',true),$simpleSpec,'',"class='iframe $mystyle' title='查看留言'",true);
    ?></td>
     <td align="center" > 
     <div id="sprintRecord<?php echo $sprintRecord->id?>edit" style="display:none" >
     <?php 
      if($isSQAorSM||$sprintRecord->openedBy==$account) {
          common::printIcon('mySprintBoard', 'edit', "sprintRecord=$sprintRecord->id",'', '', 'pencil', '', 'iframe', true,'');
          if(common::hasPriv('mySprintBoard', 'delete')) {     
              common::printIcon('mySprintBoard', 'delete', "sprintRecordID=$sprintRecord->id&sprintID=$sprintID", '', 'list', '', 'hiddenwin');
          }
      } ?>
     </div>
     </td>
     <td class='text-center'> 
      <?php
      if($sprintRecord->isTop) {
          echo '<img src='.$defaultTheme.'images/main/weather/'.$sprintRecord->isTop.'.png style=\'width: 40px;height:20px\'/>'; 
      } 
      ?>     
     </td>    
     <td align="center"><?php  $tm=explode(" ",$sprintRecord->lastEditedDate);    
      $s1=explode('-',$tm[0]);
      $s2=explode(':',$tm[1]);
      echo date('m-d  H:i',mktime($s2[0],$s2[1] , $s2[2], $s1[1], $s1[2], $s1[0]));?>
      </td>  
     </tr>
     
    
    <?php endforeach;?>
  </tbody>
  
  <tfoot>
    <tr>
      <td colspan=5>
        <?php $pager->show();?>
      </td>
    </tr>
  </tfoot>
    </table>
  </form>
 </div>
 
 <div class='container mw-1400px input notshow' id='myshowtext'>
  <form class='form-condensed' method='post'  enctype='multipart/form-data' id='dataform' data-type='ajax' >
    <table class='table table-form tablewidth'> 
      <tr>
        <th class='w-80px'><?php // echo $lang->mySprintBoard->sprintID;?></th>
       <td colspan='3'><?php echo html::input('sprintID', "$sprintID", "class='form-control' readOnly='true' style='display:none'");?></td>
      <tr>
       <tr>
        <th class='w-80px'><?php // echo $lang->mySprintBoard->sprintName;?></th>
       <td colspan='3'><?php echo html::input('sprintName', "$sprintName", "class='form-control' readOnly='true' style='display:none'");?></td>
      <tr>    
       <tr>
        <th class='w-80px'><?php //echo $lang->mySprintBoard->username;?></th>
       <td colspan='3'><?php echo html::input('username', $this->app->user->account, "class='form-control' readOnly='true' style='display:none'");?></td>
      <tr>
      
        <th><?php echo $lang->mySprintBoard->spec;?></th>
        <td colspan='3'><?php echo html::textarea('spec', $spec, "rows='9' class='form-control'");?></td>
      </tr>  
      <tr><td></td><td colspan='3' class='text-center'>
      <input type='button'  class='btn btn-primary' value='保存' onclick='submitForm()'>
      <?php
      	echo html::a(helper::createLink('my', 'index', "sprintID=$sprintID",'',false),'返回','',"class='btn' ",true);
      ?>
      </td></tr>
    </table>
  </form>
</div>
<script>
var isShow=<?php echo $isShow;?>;
if(isShow){
	$('#myshowtext').removeClass('notshow');
	$('#myshowtext').addClass('show');
}else
{
	$('#myshowtext').removeClass('show');
	$('#myshowtext').addClass('notshow');
}

var isShow2=<?php echo $isShow2?>;
if(isShow2){
	$('#myshowTitleBar').removeClass('notshow');
	$('#myshowTitleBar').addClass('show');
}else
{
	$('#myshowTitleBar').removeClass('show');
	$('#myshowTitleBar').addClass('notshow');
}
function hide(id)
{
	$('#'+id).removeAttr('bgcolor');
	id='#'+id+'edit';
	//$(id).hide(1000);
	$(id).removeAttr("style").attr("style", "display: none;");
}
function show(id)
{
	$('#'+id).attr('bgcolor','#f5f5f5');
	id='#'+id+'edit';
	//$(id).show(1000);
	$(id).removeAttr("style").attr("style", "display: block;");
}
function bgcolor(id)
{
	//$('#'+id).removeClass('active');
}
var oldtxt=$('#spec').attr('value');
function submitForm()
{
	var txt=$('#spec').attr('value');
	var txt2=txt.replace(/<[^>]*>/g,'');
	var txt3=txt2.replace(/\n/g,'');
	var txt4=txt3.replace(/&nbsp;/g,'');
	var txt5=$.trim(txt4);
 	if(txt5.length==0){
 		alert('留言内容不能为空！');
 	}else{
 		$('#dataform').submit();
 	}
}
function bySprint(sprintID)
{
	if(sprintID)
	location.href = createLink('mySprintBoard', 'more', "sprintID=" + sprintID);
}
</script>
<?php include '../../common/view/footer.lite.html.php';?>
<?php include '../../common/view/footer.html.php';?>

