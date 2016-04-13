<?php
include '../../common/view/chosen.html.php';
include '../../common/view/header.html.php';

//include 'validation.html.php';
?>
<?php js::set('confirmUnlinkMember', $lang->project->confirmUnlinkMember)?>


<div id='titlebar'>
  <div class='heading' >
    	<?php echo $lang->my->teammember;?>
  </div>

</div>
<div id="tablestyle">
<table class='table tablesorter' id='memberList' style="margin:0">
    <thead>
      <tr>
        <th class='w-100px'><?php echo $lang->team->account;?></th> 
        <th class='w-100px'><?php echo $lang->team->role;?></th>
        <th class='w-100px'><?php echo $lang->pro->sprintin;?></th> 
        <th class='w-100px'><?php echo $lang->team->join;?></th>
        <!-- <th class='w-100px'><?php echo $lang->team->days;?></th> 
        <th class='w-150px'><?php echo $lang->team->hours;?></th> 
        <th class='w-100px'><?php echo $lang->team->totalHours;?></th>  -->
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
      <td><?php echo $lang->user->roleList[$member->role];?></td>
      <td><?php echo $projects[$member->project];?></td>
      <td><?php echo substr($member->join, 2);?></td>
      <!--  <td><?php echo $member->days;?></td>
      <td><?php echo $member->hours;?></td>
      <td><?php echo $memberHours;?></td> -->
      <td>
       <?php  
        if (common::hasPriv('pro', 'unlinkMember')) 
        { 
            $unlinkURL = $this->createLink('pro', 'unlinkMember', "planID=$planID&account=$member->account&confirm=yes"); 
            echo html::a("javascript:ajaxDelete(\"$unlinkURL\",\"memberList\",confirmUnlinkMember)", '<i class="icon-green-project-unlinkMember icon-remove"></i>', '', "class='btn-icon' title='{$lang->project->unlinkMember}'"); 
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
      <?php echo $lang->pro->totalMemebers . '：';
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
