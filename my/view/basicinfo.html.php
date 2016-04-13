<style>
.form-control {  border: none; }
</style>
<div class='panel quarterblock'>
  <div class='panel-heading'>
    <strong><?php echo $lang->my->basicinfo;?></strong>
    <div class='pull-right'>
      <?php echo html::a($this->createLink('sprint', 'index', "sprintID=$sprintID",'',false),'详情  '."<i class='icon icon-double-angle-right'></i>",'',"",true);?>
    </div>
  </div>
<div style="margin: 10px 20px 10px 20px">
<table>
<thead></thead>
    <tr>
        <!-- removed style "color:grey" / added class "basicinfo-title"  by xufangye -->
        <th class="basicinfo-title">Scrum Master :</th>
        <td style="width:70%"><?php echo $scrumasterrealname;?></td>
    </tr>
    <tr>
        <!-- removed style "color:grey" / added class "basicinfo-title"  by xufangye -->
        <th class="basicinfo-title">Sprint 周期 :</th>
        <td style="width:70%"><?php echo $begin;?><?php echo "至";?><?php echo $end;?></td>
    </tr>  
</table>
</div>
<!-- changed style border-bottom by xufangye -->
<div style="border-bottom:1px dotted #DEE1E4; margin-left:20px;margin-right:20px"></div>
<div style="color: grey;margin:10px 20px ">目标 :</div>
<div style="margin-left:20px;margin-right:20px;"><?php echo html::textarea('descrip', $desc, "rows='4' class='form-control ' style='background-color:white;cursor:auto' readonly='true'");?></div>
</div>