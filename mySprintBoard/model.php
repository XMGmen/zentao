<?php 
class mySprintBoardModel extends Model
{
	public function getRecordsBySprintID($sprintID=0,$orderBy='',$pager=null)
	{
		return $this->dao->select('*')->from(TABLE_SPRINTBOARD)->where('sprintID')->eq($sprintID)->
		orderBy($orderBy)->page($pager)->fetchAll('id');
	}
	public function create()
	{
	    $now = helper::now();
		$sprintBoard->sprintID=$_POST['sprintID'];
		//这一句是我注释掉的    $sprintBoard->openedBy=$this->app->user->account;
		$sprintBoard->openedBy=$_POST['username']; //这一句是我新增的
		$sprintBoard->spec=$_POST['spec'];	
 		$sprintBoard->openedDate=$now;
 		$sprintBoard->lastEditedDate=$now;
 		$sprintBoard->isTop=0;
 		
		//$sprintBoard = fixer::input('post')->get();
		
		//下面5行代码是实现对Users的读取和分类置顶
 		if($this->isSQAorSM($_POST['username'], $_POST['sprintID'])){
 			$this->dao->insert(TABLE_SPRINTBOARD)->data($sprintBoard)->autoCheck($skipFields = 'openedDate,lastEditedDate')->exec();
 			//需求改变，现改为最新的2条数据置顶
 			$lastNewRecords=$this->dao->select('*')->from(TABLE_SPRINTBOARD)
				->where('openedby')->eq($_POST['username'])
 				->andWhere(sprintID)->eq($_POST['sprintID'])
				->orderBy('id_desc')->fetchAll();
 			$this->dao->update(TABLE_SPRINTBOARD)->data();
 			//将结果集中前2条数据置顶
 			$this->dao->update(TABLE_SPRINTBOARD)->set('isTop')->eq(0)
				->where('openedby')->eq($_POST['username'])
 				->andWhere(sprintID)->eq($_POST['sprintID'])->exec();
 			$i = 0;
			while($i<1) {
				$lastNewRecord = current($lastNewRecords);
				$lastNewRecord->isTop=1;
				$this->dao->update(TABLE_SPRINTBOARD)->data($lastNewRecord)
					->where(id)->eq($lastNewRecord->id)
					->andWhere(sprintID)->eq($_POST['sprintID'])->exec();
				next($lastNewRecords);
				$i++;
			}
			return;
 		}
		$this->dao->insert(TABLE_SPRINTBOARD)->data($sprintBoard)->autoCheck($skipFields = 'openedDate,lastEditedDate')->exec();
	}
	
	public function more()
	{
		$now = helper::now();
		$sprintBoard->sprintID=$_POST['sprintID'];
		//这一句是我注释掉的  $sprintBoard->openedBy=$this->app->user->account;
		$sprintBoard->spec=$_POST['spec'];
		$sprintBoard->openedDate=$now;
		$sprintBoard->lastEditedDate=$now;
		//$sprintBoard = fixer::input('post')->get();
		$this->dao->insert(TABLE_SPRINTBOARD)->data($sprintBoard)->autoCheck($skipFields = 'openedDate,lastEditedDate')->exec();
	}
	
	public function getSprintRecordBySprintRecordID($sprintRecordID=0)
	{
		return $this->dao->select('*')->from(TABLE_SPRINTBOARD)->where('id')->eq($sprintRecordID)->fetch();
	}
	public function getSprintNameBySprintRecordID($sprintRecordID=0)
	{
		$sprintID=$this->dao->select('sprintID')->from(TABLE_SPRINTBOARD)->where('id')->eq($sprintRecordID)->fetch('sprintID');
		return $this->loadModel('project')->getProjectNameByProjectId($sprintID);
	}
	public function updateSprintRecord($sprintRecordID=0)
	{
		$now=helper::now();
		$sprintRecord=$this->loadModel('mySprintBoard')->getSprintRecordBySprintRecordID($sprintRecordID);
		$sprintRecord->lastEditedDate=$now;
		$sprintRecord->isTop=($sprintRecord->isTop)?0:1;
		$this->dao->update(TABLE_SPRINTBOARD)->data($sprintRecord)->where('id')->eq($sprintRecordID)->exec();
	}
	
	public function edit()
	{
		$now = helper::now();
		$sprintBoard->sprintID=$_POST['sprintID'];
		//这一句是我注释掉的    $sprintBoard->openedBy=$this->app->user->account;
		$sprintBoard->openedBy=$_POST['username']; //这一句是我新增的
		$sprintBoard->spec=$_POST['spec'];
		$sprintBoard->openedDate=$now;
		$sprintBoard->lastEditedDate=$now;
		$sprintRecordID=$_POST['sprintRecordID'];
		
 		if($this->isSQAorSM($_POST['username'], $_POST['sprintID'])){
 			$sprintBoard->isTop=1;
 			$lastNewRecord=$this->dao->select('*')->from(TABLE_SPRINTBOARD)->where('openedby')->eq($this->app->user->account)
 			->andWhere('isTop')->eq(1)->fetch();
 			$lastNewRecord->isTop=0;
 			//$this->dao->update(TABLE_SPRINTBOARD)->data($lastNewRecord)->exec();
 			$this->dao->delete()->from(TABLE_SPRINTBOARD)->where('id')->eq($lastNewRecord->id)->exec();
 			$this->dao->insert(TABLE_SPRINTBOARD)->data($lastNewRecord)->exec();
 		}		
		$this->dao->update(TABLE_SPRINTBOARD)->data($sprintBoard)->where('id')->eq($sprintRecordID)->exec();
	}
	public function getSprintIDBySprintRecordID($SprintRecordID)
	{
		return $this->dao->select('SprintID')->from(TABLE_SPRINTBOARD)->where('id')->eq($SprintRecordID)->fetch('SprintID');
	}
	public function isSQAorSM($account,$sprintID)
	{
		$accounts=$this->dao->select('account')->from(TABLE_TEAM)->where('project')->eq($sprintID)->andWhere('role')->in('sqa,master')->fetchPairs('account');
		if($accounts[$account])
		{return 1;}
		return 0;
	}
	public function getrealname($sprintRecord){
		return $this->dao->select('realname')->from(TABLE_USER)->where('account')->eq($sprintRecord->openedBy)->fetch('realname');
	}
	public function getSrcBySprintRecord($sprintRecord)
	{
		$userId=$this->dao->select('id')->from(TABLE_USER)->where('account')->eq($sprintRecord->openedBy)->fetch('id');
		$file=$this->loadModel('file')->getByUserId($userId);
		if(!($file->id)) {
			$file=$this->loadModel('myImage')->getFile(0);
		}
		$src="http://".$_SERVER['HTTP_HOST'].'/'.$file->webPath;
		return $src;
	}
	public function deleteRecord($sprintRecordID=0)
	{
		$this->dao->delete()->from(TABLE_SPRINTBOARD)->where('id')->eq($sprintRecordID)->exec();
	}
	//added by fxq
	public function isShow($account,$sprintID) {
		$status=$this->dao->select('status')->from(TABLE_PROJECT)->where('id')->eq($sprintID)->fetch('status');
		if ($status=='done') {
			return 0;
		} else {
			$a=$this->dao->select('account')->from(TABLE_TEAM)->where('account')->eq($account)->andWhere('project')->eq($sprintID)->fetch('account');
			if ($a){
				return 1;
			}
			return 0;
		}
	}

	public function createWeather($recordweather)
	{
		$now = helper::now();
		$sprintBoard->sprintID=$recordweather->sprint;
		$sprintBoard->openedBy=$recordweather->account; 
		$sprintBoard->openedDate=$now;
		$sprintBoard->lastEditedDate=$now;
		$weather=$this->lang->mySprintBoard->weather[$recordweather->weather];
		$remark=$recordweather->remarkweather?$recordweather->remarkweather:'无';
		$sprintBoard->spec="sprint天气投票:"."$weather"."&nbsp;&nbsp;"." 备注：$remark";
		if($this->isSQA($recordweather->account, $recordweather->sprint)){
			$sprintBoard->isTop=1;
		}
			
		$this->dao->insert(TABLE_SPRINTBOARD)->data($sprintBoard)->autoCheck($skipFields = 'openedDate,lastEditedDate')->exec();
	}

	public function isSQA($account,$sprintID)
	{
		$accounts=$this->dao->select('account')->from(TABLE_TEAM)->where('project')->eq($sprintID)->andWhere('role')->in('sqa')->fetchPairs('account');
		if($accounts[$account]) {  return 1;  }
		return 0;
	}
}
?>