<?php include '../../common/view/header.html.php';?>
<div id='titlebar'>
  <div class="heading">
  <?php
    echo html::select('pro', $productplans, $planID, "class='selectbox' onchange='byPro(this.value)'");
  ?>
  </div>
</div>
 <div class="tabsbar">
      <ul id="myTab" class="nav nav-tabs">
        <li id='proviewid'>
        <?php echo html::a($this->createLink('pro', 'index', "planID=$planID"),"Sprint");?>
        </li>
        <li id='proviewid'>
        <?php echo html::a($this->createLink('pro', 'backlog', "planID=$planID"),"Back Log");?>
        </li>
        <li id='proviewid'>
        <?php echo html::a($this->createLink('pro', 'bug', "planID=$planID"),"Bug");?>
        </li>
        <li id='proviewid' class="active">
        <?php echo html::a($this->createLink('pro', 'team', "planID=$planID"),"团队");?>
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
          <th style="display: none"><?php echo $lang->team->role;?></th>
          <th style="display: none"><?php echo $lang->pro->sprintin;?></th>
        </tr>
      </thead>
      
      <?php $i = 1; $memberCount = 0;?>
      <?php foreach($currentMembers as $member):?>

      <!-- <?php //if(!isset($users[$member->account])) continue; $realname = substr($users[$member->account], 2);?>
      <?php //unset($users[$member->account]);?> -->

      <!-- <?php //if(!isset($users[$member->account])) continue; $realname = substr($users[$member->account], 2);?> -->
      <?php if(!isset($users[$member->account])) continue; $realname = substr($users[$member->account], 0);?>
     
      <tr>
        <td><input type='text' name='realnames[]' id='account<?php echo $i;?>' value='<?php echo $realname;?>' readonly class='form-control' /></td>
        <td style="display: none">
        <input type='text' value='<?php echo $lang->user->roleList[$member->role];?>' readonly class='form-control' />
        <?php echo html::select('roles[]', $lang->user->teamRoleList, $member->role, "class='form-control' style='display:none'");?>
        </td>
        <td style="display: none">
        <input type='text' value='<?php echo $projects[$member->project];?>' readonly class='form-control' />
        <?php echo html::select('projs[]', $projects, $member->project, "class='form-control' style='display:none'");?>
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

      <?php for($j = 0; $j < $count; $j ++):?>
      <tr>
        <td><?php echo html::select("accounts[$memberCount]", $users, '', "class='form-control chosen' onchange='setRole(this.value, $i)'");?></td>
        <td><?php echo html::select('roles[]', $lang->user->teamRoleList, '', "class='form-control' style='display:none'");?></td>
        <td><?php echo html::select('projs[]', $projects, '', "class='form-control' style='display:none'");?></td>
      </tr>
      <?php $i ++; $memberCount ++;?>
      <?php endfor;?>
      
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
