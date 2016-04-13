<style>
.myScore { /*removed styles by xufangye*/
  /*position:absolute;
  margin-left:-90px;
  top:10%;*/
}
.scoreRes{
  position:absolute;
  top:10%;
  left:40%;
}
.weather_sprint{
  /*margin-left:-25px;*/ /* delete by hongge */
}
.weather_sprint2{
  color: rgba(255,255,255,0.7);
  line-height: 30px;
  vertical-align: middle;
}
.score{
  position:absolute;
  margin-left:10px;
  margin-top:12%;
}
.score_button1 { /*addec by xufangye*/
  padding: 5px 20px 10px;
  width: 150px;
  border-radius: 4px;
  background: rgba(11,114,184,0.80);
  text-align: center;
}
.activebug {
  color: rgb(104, 148, 188);
  margin-top: 5px;
  font-size: 9px;
  text-align: center;
  vertical-align: middle;
}
.activetask{
  color: rgb(104, 148, 188);
  margin-top: 5px;
  font-size: 9px;
  text-align: center;
  vertical-align: middle;
}
#allbug,#alltask{
	text-align: center;
	margin-top:3px;
}
#allbug>a,#alltask>a{
	background: #f4f8fa;
	font-size: 12px;
	padding: 2px 10px;
	border-radius: 15px;
	color: #6894b4;
}
#allbug>a:hover,#alltask>a:hover{
	background: #e8eff4;
	text-decoration: underline;
}
</style>
<div class='panel quarterblock'>
  <div class = "aboutWeather">

    <div class="weather_cur">
      <p class="weather_sprint"><?php echo $lang->weather;?></p>
      <img weather='<?php echo $weatherRes;?>' src='<?php echo $defaultTheme;?>images/main/weather/<?php echo $weatherRes;?>.png' width='80px' height='80px'  class='scoreRes'/>
    </div>

    <div class="weather_button">
      <div class="score_button1">
        <span class="weather_sprint2"><?php echo $lang->myScore;?></span>
        <?php
          if($weatherCurScore) {
              echo "<img src='";
              echo $defaultTheme;
              echo "images/main/weather/";
              echo $weatherCurScore;
              echo ".png'";
              //changed width style by xufangye 09-02 13:44
              echo "width='30px' class='myScore'/>";
          }
          echo common::printIcon('my', 'weatheredit', "id=$sprint->id", '', 'score', 'score' ,'', 'iframe', true);
        ?>
      </div>
    </div>
  </div>
  <div class= "aboutData">	  
    <div class ="bug">
      <p class="bug_count"><?php echo $bugNum;?></p>
      <p class="mybug"><?php echo html::a($this->createLink('sprint', 'bug', "sprintID=$sprint->id&type=assignedTo"),$lang->my->mybug);?><p>
      <p id="allbug"><?php echo html::a($this->createLink('sprint', 'bug', "sprintID=$sprint->id&type=all"),$lang->my->allbug);?><p>
      <p class='activebug'  style="margin-top:1px"><?php echo '剩余bug总数: '.$activeBugsNum;?></p>
    </div>
    <div class="task" >
      <p class="task_count"><?php echo $taskNum;?></p>
      <p class="mytask"><?php echo html::a($this->createLink('sprint', 'task', "sprintID=$sprint->id&type=assignedtome"), $lang->my->mytask);?></p>
      <p id="alltask"><?php echo html::a($this->createLink('sprint', 'task', "sprintID=$sprint->id"), $lang->my->alltask);?></p>
      <p class='activetask'  style="margin-top:1px"> <?php echo '剩余任务总数: '.$activeTasksNum;?></p>
    </div>
    <div class="teammember">
      <p class="teammember_count">
          <?php echo $teamNum;?>
      </p>
      <p class="myteam"><?php echo html::a($this->createLink('sprint', 'team', "sprintID=$sprint->id"),$lang->my->teammember);?></p>
    </div>
  </div>
</div>
