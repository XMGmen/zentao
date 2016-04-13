<?php
include '../../common/view/chosen.html.php';
include '../../common/view/header.html.php';

//include 'validation.html.php';
?>
<?php js::set('confirmUnlinkMember', $lang->project->confirmUnlinkMember)?>
<div id='titlebar'>
  <div class="heading">
  <?php
    echo html::select('proj', $projects, $projectID, "class='selectbox' onchange='byProj(this.value)'");
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
    <li id="sprintviewid">
    <?php echo html::a($this->createLink('mySprintBoard', 'more', "sprintID=$sprintID"),"留言板");?>
    </li>
  </ul>
</div>
<div>
<div id='featurebar'>
    <div class='heading' >
    <span class='prefix'><?php echo html::icon($lang->icons['team']);?></span>
    <strong><?php echo $lang->sprint->teamMembers;?></strong>
    </div>
  <div class='actions'>  
      <?php common::printLink('sprint', 'managemembers', "projectID=$sprintID", $lang->project->manageMembers, '', "class='btn btn-primary'");?> 
  </div>
</div>
<div id="tablestyle">
<table class='table tablesorter' id='memberList'>
    <thead>
      <tr>
        <th class='w-100px'><?php echo $lang->team->account;?></th> 
        <th class='w-100px'><?php echo $lang->team->role;?></th>
        <th class='w-100px'><?php echo $lang->team->join;?></th>  
        <th class='w-100px'><?php echo $lang->actions;?></th>

      </tr>
    </thead>
    <tbody>
    <?php $totalHours = 0;?>
    <?php foreach($teamMembers as $member):?>
     <tr class='text-center'> 
      <td>
      <?php 
      if(!common::printLink('user', 'view', "account=$member->account", $member->realname)) print $member->realname;
      $memberHours = $member->days * $member->hours;
      $totalHours  += $memberHours;
      ?>
      </td>
      <td><?php 
        if($member->role == 'master') {
          echo 'Master';
        } else {
      	  echo $lang->user->roleList[$member->role];
        }
      ?></td>
      <td><?php echo substr($member->join, 2);?></td>
      <td>
       <?php
       if ($member->role != 'sqa' && $member->role != 'master') {
           if (common::hasPriv('pro', 'unlinkMember')) { 
                $unlinkURL = $this->createLink('pro', 'unlinkMember2', "account=$member->account&projectID=$member->project&confirm=yes");
                echo html::a("javascript:ajaxDelete(\"$unlinkURL\",\"memberList\",confirmUnlinkMember)", '<i class="icon-green-project-unlinkMember icon-remove"></i>', '', "class='btn-icon' title='{$lang->project->unlinkMember}'");
            }
        } 
        ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>     
    <tfoot>
    <tr>
      <td colspan='7'>
      <div class='table-actions clearfix'><div class='text'>
    <?php echo $lang->sprint->totalMemebers . '：';
    echo "<strong>";
    echo count($teamMembersUni);
    echo "</strong>";
    ?></div></div>
      </td>
    </tr>
    </tfoot>
  </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
