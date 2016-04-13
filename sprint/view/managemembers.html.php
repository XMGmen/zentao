<?php include '../../common/view/header.html.php';?>
<div id='titlebar'>
  <div class="heading">
  <?php
    echo html::select('proj', $projs, $projectID, "class='selectbox' onchange='byProj(this.value)'");
  ?>
  </div>
</div>
<div class="tabsbar"> <!-- change classname from "sprint_index" to "tabsbar" by xufangye  -->
  <ul id="myTab" class="nav nav-tabs">
    <li id="sprintviewid">
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
	<li id="sprintviewid" class="active">
    <?php echo html::a($this->createLink('sprint', 'team', "sprintID=$sprintID"),"团队");?>
    </li>
  </ul>
</div>
    
<div>
  <div id='featurebar'>
    <div class='heading'>
      <span class='prefix'><?php echo html::icon($lang->icons['team']);?></span>
      <strong> <?php echo $lang->project->manageMembers;?></strong>
      <small class='text-muted'><i class='icon icon-cogs'></i></small>
    </div>
    
  </div>
  <div id="tablestyle">
  <form class='form-condensed' method='post' >
    <table class='table table-form' style="margin:0">
      <thead>
        <tr class='text-center'>
          <th><?php echo $lang->team->account;?></th>
          <th><?php echo $lang->team->role;?></th>
        </tr>
      </thead>
      
      <?php $i = 1; $memberCount = 0;?>
      <?php foreach($currentMembers as $member):?>

      <?php if(!isset($users[$member->account])) continue; $realname = substr($users[$member->account], 0);?>
     
      <tr>
        <td><input type='text' name="realnames[<?php echo $memberCount;?>]" id='account<?php echo $i;?>' value='<?php echo $realname;?>' readonly class='form-control' /></td>
        <input type='text' name="exsitAccounts<?php echo $memberCount;?>" id='account<?php echo $i;?>' value='<?php echo $member->account?>' readonly class='form-control' style='display: none'/>
        <td>
          <input type='text' value='<?php echo $lang->user->roleList[$member->role];?>'  class='form-control' style=' display:none'/>
          <?php 
          if($member->role == 'master') {
              $list['master'] = 'Master';
              echo html::select("roles$memberCount", $list, 'master', "class='form-control' style='display:block' readonly");
          } else {
              echo html::select("roles$memberCount", $lang->user->teamRoleList, $member->role, "class='form-control' style='display:block'");
          }?>
	</td>
      </tr>
      <?php $i ++; $memberCount ++;?>
      <?php endforeach;?>
      
      <?php
      $count = count($users) - 1;
      if($count > PROJECTMODEL::LINK_MEMBERS_ONE_TIME)
      {
        $count = PROJECTMODEL::LINK_MEMBERS_ONE_TIME;
      }
      ?>

      <tr>
        <td><?php echo html::select("accounts", $users2, '', "class='form-control chosen' onchange='setRole(this.value, $i)'");?></td>
        <td><?php echo html::select('roles', $lang->user->teamRoleList, '', "class='form-control'");?></td>
      </tr>
      
      <tr>
        <td colspan='4' class='text-center'>
          <?php echo html::submitButton(); echo html::backButton();?>
        </td>
      </tr>
    </table>
  </form>
  </div>
</div>

<?php include '../../common/view/footer.html.php';?>
