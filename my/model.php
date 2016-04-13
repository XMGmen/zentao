<?php
/**
 * The model file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: model.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php
class myModel extends model
{
    /**
     * Set menu.
     * 
     * @access public
     * @return void
     */
    public function setMenu()
    {
        $this->lang->my->menu->account = sprintf($this->lang->my->menu->account, $this->app->user->realname);

        /* Adjust the menu order according to the user role. */
        $role = $this->app->user->role;
        if($role == 'qa')
        {
            unset($this->lang->my->menuOrder[20]);
            $this->lang->my->menuOrder[32] = 'task';
        }
        elseif($role == 'po')
        {
            unset($this->lang->my->menuOrder[35]);
            unset($this->lang->my->menuOrder[20]);
            $this->lang->my->menuOrder[17] = 'story';
            $this->lang->my->menuOrder[42] = 'task';
        }
        elseif($role == 'pm')
        {
            unset($this->lang->my->menuOrder[40]);
            $this->lang->my->menuOrder[17] = 'myProject';
        }
    }

    public function create() 
    {
      $recordweather->sprint           = $_POST['sprintID']; 
      $recordweather->account          = $this->app->user->account; 
      $recordweather->remarkweather    = $_POST['weatherRemark'];  
      $recordweather->weather          = $_POST['weather'];
      $recordweather->recordDate       = date('Y-m-d');
      $this->dao->delete()->from(TABLE_RECORDWEATHER)
          ->where('sprint')->eq($recordweather->sprint)
          ->andWhere('account')->eq($recordweather->account)->exec();
      $this->dao->insert(TABLE_RECORDWEATHER)->data($recordweather)->exec();
      $this->loadModel('mySprintboard')->createWeather($recordweather);

    }

/* -------------------------
    public function getWeatherCur($sprintID, $account) {
      $weatherCur = $this->dao->select('weather')->from(TABLE_RECORDWEATHER)
                      ->where('sprint')->eq($sprintID)
                      ->andWhere('account')->eq($account)
                      ->andWhere('recordDate')->eq(date('Y-m-d'))
                      ->fetch('weather');
      return $this->lang->my->weatherLis[$weatherCur];

    }
 ------------------------- */
 
    public function getWeatherCur($sprintID, $account) {
        $weatherCur = $this->dao->select('weather')->from(TABLE_RECORDWEATHER) 
                        ->where('sprint')->eq($sprintID) 
                        ->andWhere('account')->eq($account) 
                        ->andWhere('recordDate')->eq(date('Y-m-d')) 
                        ->fetch('weather'); 
        if($weatherCur) {
            return $weatherCur;
        } else {
            return 'default';
        }
    }

    public function getWeatherCurRemark($sprintID, $account) {
      return $this->dao->select('remarkweather')->from(TABLE_RECORDWEATHER)
              ->where('sprint')->eq($sprintID)
              ->andWhere('account')->eq($account)
              ->andWhere('recordDate')->eq(date('Y-m-d'))
              ->fetch('remarkweather');

    }

    public function computeWeatherRes($sprintID) {

      $weather =  $this->dao->select('*')->from(TABLE_RECORDWEATHER)  
                  ->where('sprint')->eq($sprintID)
                  ->andWhere('recordDate')->eq(date('Y-m-d'))
                  ->fetchAll();
      $sum     = 0;

      foreach ($weather as $key => $value)
      {
    		$roleJdu = $this->dao->select('role')->from(TABLE_TEAM)
                    ->where('project')->eq($value->sprint)
                    ->andWhere('account')->eq($value->account)
                    ->fetch('role');
        
        if ($roleJdu == "sqa")
        {
          if ($value->weather != '')
          {
            $sum = $this->lang->my->weatherLis[$value->weather];
            $weatherResult = $this->lang->my->weatherRes[$sum];
            $this->updateProject($sprintID, $weatherResult);
            return $weatherResult;
          }
          
        }
        $rec = $value->weather;
        $sum += $this->lang->my->weatherLis[$rec];
    	}
      
      $result = round($sum / count($weather));
      if ($this->lang->my->weatherRes[$result] != '') $weatherResult = $this->lang->my->weatherRes[$result];
      else $weatherResult = "default";

      $this->updateProject($sprintID, $weatherResult);
      return $weatherResult;
    }

    public function updateProject($sprintID, $weatherResult) {

      $project = $this->dao->select('*')->from(TABLE_PROJECT)->where('id')->eq($sprintID)->fetch();
      $project->weather = $weatherResult;
      $this->dao->update(TABLE_PROJECT)->data($project)->where('id')->eq($sprintID)->exec();

    }

    public function getWeatherScore($sprintID) {
      $weather =  $this->dao->select('*')->from(TABLE_RECORDWEATHER)  
                  ->where('sprint')->eq($sprintID)
                  ->andWhere('recordDate')->eq(date('Y-m-d'))
                  ->fetchAll();
      $sum     = 0;    
      foreach ($weather as $key => $value)
      {	
    	$roleJdu = $this->dao->select('role')->from(TABLE_TEAM)
                ->where('project')->eq($value->sprint)
                ->andWhere('account')->eq($value->account)
                ->fetch('role');        
        if ($roleJdu == "sqa")
        {
          if ($value->weather != '')
          {
            $sum = $this->lang->my->weatherLis[$value->weather];
            $weatherResult = $this->lang->my->weatherRes[$sum];
            $this->updateProject($sprintID, $weatherResult);
            return $sum;
          }
          
        }
        $rec = $value->weather;
        $sum += $this->lang->my->weatherLis[$rec];
      }
      $result = round($sum / count($weather));
      if ($this->lang->my->weatherRes[$result] != '') 
      {
      return $result;
      } else {
        $result=0;
        return $result;
      }
    }
}
