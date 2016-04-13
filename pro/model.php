<?php
class proModel extends model
{
	
	public function manageMembers($planID)
	{
		extract($_POST);
		
		// $accounts = array_unique($accounts);
		foreach($accounts as $key => $account)
		{
			if(empty($account)) continue;
	
			$member = new stdclass();
			$member->role    = $roles[$key];
			$member->days    = $days[$key];
			$member->hours   = $hours[$key];
			$member->project = $projs[$key];
			$member->plan    = (int)$planID;
			$member->account = $account;
			$member->join    = helper::today();
			$this->dao->delete()->from(TABLE_TEAM)
                            ->where('plan')->eq($member->plan)
                            ->andWhere('account')->eq($account)
                            ->andWhere('project')->eq('0')->exec();
 			//$this->dao->delete()->from(TABLE_TEAM)
                        //     ->where('project')->eq($member->project)
                        //     ->andWhere('account')->eq($account)->exec();
			$this->dao->insert(TABLE_TEAM)->data($member)->exec();
	
			// $mode = $modes[$key];
			// if($mode == 'update')
			// {
			// 	$this->dao->update(TABLE_TEAM)
			// 	->data($member)
			// 	->where('plan')->eq((int)$planID)
			// 	->andWhere('account')->eq($account)
			// 	->exec();
			// }
			// else
			// {
			// 	// $member->plan = (int)$planID;
			// 	$member->account = $account;
			// 	$member->join    = helper::today();
			// 	$this->dao->insert(TABLE_TEAM)->data($member)->exec();
			// }
		}
	}

	public function getTMAccounts($planID)
	{
		return $this->dao->select('account')->from(TABLE_TEAM)
		->where('plan')->eq((int)$planID)
		->fetchAll('account');
	}

	public function getTMembers($planID)
	{
		return $this->dao->select('t1.*, t1.hours * t1.days AS totalHours, t2.realname')->from(TABLE_TEAM)->alias('t1')
		->leftJoin(TABLE_USER)->alias('t2')->on('t1.account = t2.account')
		->where('t1.plan')->eq((int)$planID)->andWhere('t1.isProject')->eq(0)
		->fetchAll('account');
	}
	
	//by clj
	public function getTeamMembers($planID)
	{
		return $this->dao->select('t1.*, t1.hours * t1.days AS totalHours, t2.realname')->from(TABLE_TEAM)->alias('t1')
		->leftJoin(TABLE_USER)->alias('t2')->on('t1.account = t2.account')
		->where('t1.plan')->eq((int)$planID)
		->fetchAll('account');
	}
	
	public function unlinkMember($account,$plan = 0)
	{
		if ($plan) {
			$this->dao->delete()->from(TABLE_TEAM)
				->where('account')->eq($account)
				->andWhere('plan')->eq($plan)->exec();
		} 
	}
	public function unlinkMember2($account, $projectID = 0)
	{
		if($projectID) {
			$this->dao->delete()->from(TABLE_TEAM)
			->where('account')->eq($account)
			->andWhere('project')->eq($projectID)
			->andWhere('isProject')->eq(1)->exec();
		}
	}
	
	public function getAccount($planID)
	{
		return $this->dao->select('account')->from(TABLE_TEAM)->where('plan')->eq($planID)->fetchPairs();
	}

}