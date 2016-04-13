<?php
/**
 * The model file of sprint module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id: model.php 5118 2013-07-12 07:41:41Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class sprintModel extends model
{
    /**
     * Get sprints.
     * 
     * @param  string $account
     * @access public
     * @return array
     */
    public function getSprintsByAccount($account) 
    { 
        $sprints = $this->dao->select('t1.*,t2.*')->from(TABLE_TEAM)->alias('t1') 
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project = t2.id') 
            ->where('t1.account')->eq($account) 
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.status')->notin('done,suspended')
            ->fetchAll();
        return $sprints ? $sprints : array(); 
    }

    /**
     * Get sprint pairs.
     * 
     * @param  string $mode     all|noclosed or empty 
     * @param  string $account
     * @access public
     * @return array
     */
    public function getPairs($mode = '', $account)
    {
        $orderBy  = !empty($this->config->sprint->orderBy) ? $this->config->sprint->orderBy : 'isDone, status';
        $mode    .= $this->cookie->projectMode;
        /* Order by status's content whether or not done */
        $projects = $this->dao->select('t1.*,t2.*')->from(TABLE_TEAM)->alias('t1') 
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project = t2.id') 
            ->where('t1.account')->eq($account) 
            ->andWhere('t2.deleted')->eq(0)
            ->fetchAll();
        $pairs = array();
        foreach($projects as $project)
        {
            if(strpos($mode, 'noclosed') !== false and $project->status == 'done') continue;
            if($this->loadModel('project')->checkPriv($project)) $pairs[$project->id] = $project->name;
        }

        /* If the pairs is empty, to make sure there's an project in the pairs. */
        if(empty($pairs) and isset($projects[0]) and $this->loadModel('project')->checkPriv($projects[0]))
        {
            $firstProject = $projects[0];
            $pairs[$firstProject->id] = $firstProject->name;
        }
        return $pairs;
    }

    /** 
     * Get userSprint bugs.  
     *  
     * @param  int    $sprintID  
     * @access public 
     * @return array 
     */ 
    public function getSprintByID($sprintID)
    {
        return $this->dao->select('*')->from(TABLE_PROJECT)
            ->where('id')->eq($sprintID)
            ->fetch();
    }

    /** 
     * Get userSprint bugs.  
     *  
     * @param  string $account  
     * @param  string $type  
     * @param  int    $sprintID  
     * @access public 
     * @return array 
     */ 
    public function getBugs($account, $sprintID, $type = 'assignedTo') 
    {
        $bugs = $this->dao->select('*')->from(TABLE_BUG) 
            ->where('deleted')->eq(0)->andWhere('project')->eq($sprintID) 
            ->beginIF($type != 'all')->andWhere("$type")->eq($account)->fi() 
            ->fetchAll();
        return $bugs ? $bugs : array(); 
    }

    /** 
     * Get userSprint tasks.  
     *  
     * @param  string $account  
     * @param  string $type  
     * @param  int    $sprintID  
     * @access public 
     * @return array 
     */ 
    public function getTasks($account, $sprintID, $type = 'assignedTo') 
    {
        $tasks = $this->dao->select('*')->from(TABLE_TASK) 
            ->where('deleted')->eq(0)->andWhere('project')->eq($sprintID) 
            ->beginIF($type != 'all')->andWhere("$type")->eq($account)->fi() 
            ->fetchAll();
        return $tasks ? $tasks : array(); 
    }

    /** 
     * Get teams.  
     *  
     * @param  int    $planID  
     * @access public 
     * @return array 
     */ 
    public function getTeams($planID) 
    {
        $teams = $this->dao->select('*')->from(TABLE_TEAM) 
            ->where('plan')->eq($planID) 
            ->fetchAll('account');
        return $teams ? $teams : array(); 
    }

    /** 
     * Get planID.  
     *  
     * @param  int    $sprintID  
     * @access public 
     * @return int 
     */ 
    public function getPlanIDBySprintID($sprintID) 
    {
        $planID = $this->dao->select('plan')->from(TABLE_PROJECTPLAN) 
            ->where('project')->eq($sprintID) 
            ->fetch('plan');
        return $planID; 
    }

    /** 
     * Get productID.  
     *  
     * @param  int    $sprintID  
     * @access public 
     * @return int 
     */ 
    public function getProductIDBySprintID($sprintID) 
    {
        $productID = $this->dao->select('product')->from(TABLE_PROJECTPRODUCT) 
            ->where('project')->eq($sprintID) 
            ->fetch('product');
        return $productID; 
    }

    public function getTMAccounts($sprintID)
    {
        return $this->dao->select('account')->from(TABLE_TEAM)
        ->where('project')->eq((int)$sprintID)
        ->fetchAll('account');
    }

    public function getTMembers($sprintID)
    {
        return $this->dao->select('t1.*, t2.realname')->from(TABLE_TEAM)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')->on('t1.account = t2.account')
            ->where('t1.project')->eq((int)$sprintID)->andWhere('t1.isProject')->eq(1)
            ->fetchAll();
    }

    public function manageMembers($sprintID)
    {
        $sprint = $this->getSprintByID($sprintID);
            
        $acc = $_POST["accounts"];
        if($acc) {
            $member = new stdclass();
            $member->role    = $_POST["roles"];
            $member->account = $acc;
            $member->days    = $sprint->days;
            $member->hours   = $sprint->hours;
            $member->project = $sprintID;
            $member->plan    = $this->getPlanIDBySprintID($sprintID);
          
            $member->join    = helper::today();
            $member->isProject = 1;
            $this->dao->delete()->from(TABLE_TEAM)
                ->where('project')->eq($member->project)
                ->andWhere('account')->eq($acc)->exec();
            $this->dao->insert(TABLE_TEAM)->data($member)->exec();
        }
        
        $plan    = $this->getPlanIDBySprintID($sprintID);
        $members = $this->dao->select('count(*)')->from(TABLE_TEAM)
                       ->where('plan')->eq($plan)
                       ->andWhere('project')->eq($sprintID)->fetchAll();
        $members=current($members[0]);
        
        $sqas = $this->dao->select('account')->from(TABLE_USER)
                    ->where('role')->eq('sqa')->fetchAll();
        
        $sqanum = count($sqas);
        for($i = 0; $i <= ($members - 1 - $sqanum); $i++) {
            $member = $this->dao->select('*')->from(TABLE_TEAM)
                          ->where('account')->eq($_POST["exsitAccounts$i"])
                          ->andWhere('project')->eq($sprintID)->fetch();
            $member->role = $_POST["roles$i"];
            
            $this->dao->delete()->from(TABLE_TEAM)
                ->where('account')->eq($member->account)
                ->andWhere('project')->eq($sprintID)->exec();
            
            $this->dao->insert(TABLE_TEAM)->data($member)->exec();
            $this->dao->delete()->from(TABLE_TEAM)
                ->where('plan')->eq(0)->exec();
        }
    }

    public function getSprintByBugID($bugID)
    {
        return $this->dao->select('project')->from(TABLE_BUG)
                ->where('id')->eq($bugID)->fetch('project');
    }

    public function getPlanByBugID($bugID)
    {
        return $this->dao->select('plan')->from(TABLE_BUG)
                ->where('id')->eq($bugID)->fetch('plan');
    }
    
    public function getMaster($projectID)
    {
        return $this->dao->select('PM')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetch('PM');
    }
    
    public function getBegin($projectID)
    {
        return $this->dao->select('begin')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetch('begin');
    }
    
    public function getEnd($projectID)
    {
        return $this->dao->select('end')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetch('end');
    }
    
    public function getDesc($projectID)
    {
        return $this->dao->select('descrip')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetch('descrip');
    }
    
    public function getReviewID($sprintID){
        return $this->dao->select('sprintID')->from(TABLE_REVIEW)->where('sprintID')->eq((int)$sprintID)->fetch('sprintID');
    }
    
    public function getReviewContent($sprintID){
         return $this->dao->select('content')->from(TABLE_REVIEW)->where('sprintID')->eq((int)$sprintID)->fetch('content');
    }
    
    public function updateReview(){
        $sprintID=$_POST['sprintID'];
        $real_begin=$_POST['real_begin'];
        $real_end=$_POST['real_end'];
        $estimatePoints=$_POST['estimatePoints'];
        $realPoints=$_POST['realPoints'];
        $expl=$_POST['expl'];
        $referenceStory=$_POST['referenceStory'];
        $date=$_POST['date'];
        $time=$_POST['time'];
        $place=$_POST['place'];
        $persons=$_POST['persons'];
        $completeFunc=$_POST['completeFunc'];
        $summary=$_POST['summary'];
        $other=$_POST['other'];
        $this->dao->update(TABLE_REVIEW)->set('real_begin')->eq($real_begin)
        ->set('real_end')->eq($real_end)
        ->set('estimatePoints')->eq($estimatePoints)
        ->set('realPoints')->eq($realPoints)
        ->set('expl')->eq($expl)
        ->set('referenceStory')->eq($referenceStory)
        ->set('date')->eq($date)
        ->set('time')->eq($time)
        ->set('place')->eq($place)
        ->set('persons')->eq($persons)
        ->set('completeFunc')->eq($completeFunc)
        ->set('summary')->eq($summary)
        ->set('other')->eq($other)
        ->where('sprintID')->eq($sprintID)->exec();    }
    
    public function createreview(){
        $review->sprintID=$_POST['sprintID'];
        $review->real_begin=$_POST['real_begin'];
        $review->real_end=$_POST['real_end'];
        $review->estimatePoints=$_POST['estimatePoints'];
        $review->realPoints=$_POST['realPoints'];
        $review->expl=$_POST['expl'];
        $review->referenceStory=$_POST['referenceStory'];
        $review->date=$_POST['date'];
        $review->time=$_POST['time'];
        $review->place=$_POST['place'];
        $review->persons=$_POST['persons'];
        $review->completeFunc=$_POST['completeFunc'];
        $review->summary=$_POST['summary'];
        $review->other=$_POST['other'];
        $this->dao->insert(TABLE_REVIEW)->data($review)->exec();
    }
    public function getReview($sprintID){
        return $this->dao->select('*')->from(TABLE_REVIEW)->where('sprintID')->eq((int)$sprintID)->fetch();
    }
    
    public function deleteReview($sprintID){
        $this->dao->delete()->from(TABLE_REVIEW)->where('sprintID')->eq((int)$sprintID)->exec();
        return;
    }
    
    public function isSprintDone($sprintID)
    {
        $isDone = true;
        $tasks = $this->dao->select('*')->from(TABLE_TASK)
            ->where('deleted')->eq(0)
            ->andWhere('project')->eq($sprintID)
            ->fetchAll();
        if(count($tasks) == 0) return false;
        foreach ($tasks as $task) {
            if($task->status != 'done' && $task->status != 'cancel'){
                $isDone = false;
                break;
            }
        }
        return $isDone;
    }
}
