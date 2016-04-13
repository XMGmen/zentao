<?php
/**
 * The control file of dashboard module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     dashboard
 * @version     $Id: control.php 5020 2013-07-05 02:03:26Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
class my extends control
{
    /**
     * Construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('user');
        $this->loadModel('dept');
        $this->my->setMenu();
    }

    /**
     * Index page, goto todo.
     * 
     * @access public
     * @return void
     */
    public function index($sprintID = 0,$orderBy='isTop_desc,lastEditedDate_desc', $recTotal=0, $recPerPage=5, $pageID=1)
    {
        $this->loadModel('report');
        $this->loadModel('sprint');
        $account = $this->app->user->account;

        $sprints = $this->sprint->getSprintsByAccount($account);
        $sprintNames = $this->sprint->getPairs('', $account);
        if ($sprintID == 0)
        {
            $sprintID = $sprints[$sprintID]->id;
        }
        $sprint = $this->sprint->getSprintByID($sprintID);
        
        $projectID = $sprintID;
        $type = 'noweekend';
        $interval = 0;
        $projectInfo = $this->loadModel("project")->getByID($projectID);
        
        /* Get date list. */
        list($dateList, $interval) = $this->loadModel("project")->getDateList($projectInfo->begin, $projectInfo->end, $type, $interval, 'Y-m-d');
        
        $sets          = $this->loadModel("project")->getBurnDataFlot($projectID);
        $limitJSON     = '[]';
        $baselineJSON  = '[]';
        
        $firstBurn    = empty($sets) ? 0 : reset($sets);
        $firstTime    = isset($firstBurn->value) ? $firstBurn->value : 0;
        $days         = count($dateList) - 1;
        $rate         = round($firstTime / $days, 2);
        $baselineJSON = '[';
        foreach($dateList as $i => $date) $baselineJSON .= ($days - $i) * $rate . ',';
        $baselineJSON = rtrim($baselineJSON, ',') . ']';
        
        $chartData['labels']   = $this->report->convertFormat($dateList, 'j/n');
        $chartData['burnLine'] = $this->report->createSingleJSON($sets, $dateList);
        $chartData['baseLine'] = $baselineJSON;
        
        /* Set a space when assemble the string for english. */
        $space   = $this->app->getClientLang() == 'en' ? ' ' : '';
        $dayList = array_fill(1, floor($projectInfo->days / $this->config->project->maxBurnDay) + 5, '');
        foreach($dayList as $key => $val) $dayList[$key] = $this->lang->project->interval . $space . ($key + 1) . $space . $this->lang->day;
        
        $today = helper::today();
        //$today_num = strtotime($today);
        //$time_cont = 1*24*3600;
        $endDate = $this->dao->select('end')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetch('end');
        if ($endDate < $today)
        {
            //$cdate = $today_num + 7*$time_cont;
            //$ndate = date("Y-m-d",$cdate);
            $proj = $this->dao->select('*')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetch();
            //$proj->end = $ndate;
            $proj->end = $today;
            $this->dao->delete()->from(TABLE_PROJECT)->where('id')->eq($projectID)->exec();
            $this->dao->insert(TABLE_PROJECT)->data($proj)->exec();
            $delayMsg = $proj->name. " " . $this->lang->my->delayWarn;
            $this->view->delayMsg = $delayMsg;
        } else {
            $this->view->delayMsg = '';
        }
        
        $isSprintDone = $this->loadModel(sprint)->isSprintDone($sprintID);
        if($isSprintDone) {
            $proj = $this->dao->select('*')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetch();
            $this->view->isDoneMsg = $proj->name.' '.$this->lang->my->doneWarn;
        }else {
            $this->view->isDoneMsg ='';
        }
        // Update automatically
        $burnFromTask = $this->dao->select("sum(`left`) AS `left`")
        ->from(TABLE_TASK)
        ->where('project')->eq($projectID)
        ->andWhere('deleted')->eq('0')
        ->andWhere('status')->notin('cancel,closed')
        ->groupBy('project')
        ->fetch('left');
        // echo $burnFromTask;
        $burnFromBurn = $this->dao->select('*')
        ->from(TABLE_BURN)
        ->where('project')->eq($projectID)
        ->andWhere('date')->eq($today)
        ->fetch('left');
        // echo $burnFromBurn;
        $burnDiff = $burnFromTask - $burnFromBurn;
        if ($burnDiff == 0)
        {
            $this->view->updateJudge = 0;
        }
        else
        {
            $this->view->updateJudge = 1;
        }
        if ($this->view->delayMsg != '') $this->view->updateJudge = 1;
        
        $bugs   = $this->sprint->getBugs($account, $sprintID, $type='assignedTo');
        $tasks  = $this->sprint->getTasks($account, $sprintID, $type='assignedTo');
        $planID = $this->sprint->getPlanIDBySprintID($sprintID);
        $teams  = $this->sprint->getTMAccounts($sprintID);
        
        $scrummaster = $this->loadModel('sprint')->getMaster($sprintID);
        $scrumasterrealname =$this->dao->select('realname')->from(TABLE_USER)->where('account')->eq($scrummaster)->fetch('realname');
        $begin = $this->loadModel('sprint')->getBegin($sprintID);
        $end = $this->loadModel('sprint')->getEnd($sprintID);
        $desc = $this->loadModel('sprint')->getDesc($sprintID);

        // $weatherCur = $this->my->getWeatherCur($sprintID, $account);
        // $weatherRes = $this->my->computeWeatherRes($sprintID);
        // if($weatherCur == null or $weatherRes == null) 
        // { 
        //   $weatherCur = 'default'; 
        // }
        $weatherCurScore = $this->my->getWeatherCur($sprintID, $account);
        $weatherScore    = $this->my->getWeatherScore($sprintID);
        $weatherRes      = $this->my->computeWeatherRes($sprintID);

        // $this->view->weatherCur   = $weatherCur;
        $this->view->weatherCurScore   = $weatherCurScore;
        $this->view->weatherScore      = $weatherScore;
        
        $this->view->weatherRemarkCur  = $this->my->getWeatherCurRemark($sprintID, $account);
        $this->view->weatherRes        = $weatherRes;
        $this->view->scrummaster       = $scrummaster;
        $this->view->begin             = $begin;
        $this->view->end               = $end;
        $this->view->desc              = $desc;
        $this->view->projectID         = $sprintID;

        $this->view->title         = $this->lang->my->common;
        $this->view->sprint        = $sprint;
        $this->view->sprintID      = $sprint->id;
        $this->view->sprints       = $sprints;
        $this->view->bugNum        = count($bugs);
        $this->view->taskNum       = count($tasks);
        $this->view->teamNum       = count($teams);
        
        $this->view->tabID       = 'burn';
        $this->view->charts      = $charts;
        $this->view->projectID   = $projectID;
        $this->view->sprintID    = $projectID;
        $this->view->projectName = $projectInfo->name;
        $this->view->type        = $type;
        $this->view->interval    = $interval;
        $this->view->chartData   = $chartData;
        $this->view->dayList     = array('full' => $this->lang->project->interval . $space . 1 . $space . $this->lang->day) + $dayList;
        //added by fxq

        if(!$orderBy) $orderBy = $this->cookie->sprintBoardOrder ? $this->cookie->sprintBoardOrder : 'id';
        setcookie('sprintBoardOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        $sort = $this->loadModel('common')->appendOrder($orderBy);
        $this->app->loadClass('pager', $static = true);
        $pager=new pager($recTotal, $recPerPage, $pageID);
        
        $sprintRecords=$this->loadModel('mySprintBoard')->getRecordsBySprintID($sprintID,$sort,$pager);
        $sprintName=$this->loadModel('project')->getProjectNameByProjectId($sprintID);
        $realnames=array();
        foreach($sprintRecords as $sprintRecord)
        {
            $name=$this->loadModel('mySprintBoard')->getrealname($sprintRecord);
            $realnames[$sprintRecord->id]=$name;
        }
         
        $this->view->pager=$pager;                           //这三行注释掉是为了首页显示最新5条
        $this->view->recTotal=$pager->recTotal;
        $this->view->recPerPage=$pager->recPerPage;
        $this->view->orderBy=$orderBy;
        $this->view->sprintID=$sprintID;
        $this->view->sprintRecords=$sprintRecords;
        $this->view->sprintName=$sprintName;
        $this->view->realnames=$realnames;
        $this->view->scrumasterrealname=$scrumasterrealname;
        
        $activeBugs = $this->dao->select('id')->from(TABLE_BUG)->where('project')->eq($sprintID)->andWhere('status')->eq('active')->fetchAll();
        $this->view->activeBugsNum  = count($activeBugs);
        $activeTasks = $this->dao->select('id')->from(TABLE_TASK)->where('project')->eq($sprintID)->andWhere('status')->in('wait,doing,pause')->fetchAll();
        $this->view->activeTasksNum = count($activeTasks);
        $planNamesArray = Array();
        foreach ($sprints as $sprint) {
            $planName = $this->loadModel('project')->getPlanNameByProjectID($sprint->id);
            $planNamesArray += Array($sprint->id => $planName);
        }
        $this->view->planNamesArray = $planNamesArray;
        $this->view->isSprintDone = $isSprintDone;
        $this->view->isOpeSprint = $this->loadModel(project)->isOperSprint($projectID);
        $this->display();
    }

    /**
     * My todos. 
     * 
     * @param  string $type 
     * @param  string $account 
     * @param  string $status 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function todo($type = 'today', $account = '', $status = 'all', $orderBy = "date_desc,status,begin", $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $uri = $this->app->getURI(true);
        $this->session->set('todoList', $uri);
        $this->session->set('bugList',  $uri);
        $this->session->set('taskList', $uri);

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        if($this->app->getViewType() == 'mhtml') $recPerPage = 10;
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* The title and position. */
        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->todo;
        $this->view->position[] = $this->lang->my->todo;

        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);

        /* Assign. */
        $this->view->todos        = $this->loadModel('todo')->getList($type, $account, $status, 0, $pager, $sort);
        $this->view->date         = (int)$type == 0 ? date(DT_DATE1) : date(DT_DATE1, strtotime($type));
        $this->view->type         = $type;
        $this->view->recTotal     = $recTotal;
        $this->view->recPerPage   = $recPerPage;
        $this->view->pageID       = $pageID;
        $this->view->status       = $status;
        $this->view->account      = $this->app->user->account;
        $this->view->orderBy      = $orderBy == 'date_desc,status,begin,id_desc' ? '' : $orderBy;
        $this->view->pager        = $pager;
        $this->view->importFuture = ($type != 'today');

        $this->display();
    }

    /**
     * My stories 
     * @param  string $type 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function story($type = 'assignedTo', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $this->session->set('storyList', $this->app->getURI(true));

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        if($this->app->getViewType() == 'mhtml') $recPerPage = 10;
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);

        /* Assign. */
        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->story;
        $this->view->position[] = $this->lang->my->story;
        $this->view->stories    = $this->loadModel('story')->getUserStories($this->app->user->account, $type, $sort, $pager);
        $this->view->users      = $this->user->getPairs('noletter');
        $this->view->type       = $type;
        $this->view->recTotal   = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->pager      = $pager;

        $this->display();
    }

    /**
     * My tasks
     * 
     * @param  string $type 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function task($type = 'assignedTo', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $this->session->set('taskList',  $this->app->getURI(true));
        $this->session->set('storyList', $this->app->getURI(true));

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        if($this->app->getViewType() == 'mhtml') $recPerPage = 10;
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);
        $projects =$this->loadModel('user')->getProjectsID($this->app->user->account); 
        /* Assign. */
        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->task;
        $this->view->position[] = $this->lang->my->task;
        $this->view->tabID      = 'task';
        $this->view->tasks      = $this->loadModel('task')->getUserTasks($this->app->user->account, $type, 0, $pager, $sort, $projects);
        $this->view->type       = $type;
        $this->view->recTotal   = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->users      = $this->loadModel('user')->getPairs('noletter');
        $this->view->pager      = $pager;
        $this->display();
    }

    /**
     * My bugs.
     * 
     * @param  string $type 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function bug($type = 'assignedTo', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. load Lang. */
        $this->session->set('bugList', $this->app->getURI(true));
        $this->app->loadLang('bug');
 
        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        if($this->app->getViewType() == 'mhtml') $recPerPage = 10;
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);
        $bugs = $this->loadModel('bug')->getUserBugs($this->app->user->account, $type, $sort, 0, $pager);

        /* Save bugIDs session for get the pre and next bug. */
        $bugIDs = '';
        foreach($bugs as $bug) $bugIDs .= ',' . $bug->id;
        $this->session->set('bugIDs', $bugIDs . ',');

        /* assign. */
        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->bug;
        $this->view->position[] = $this->lang->my->bug;
        $this->view->bugs       = $bugs;
        $this->view->users      = $this->user->getPairs('noletter');
        $this->view->tabID      = 'bug';
        $this->view->type       = $type;
        $this->view->recTotal   = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->pager      = $pager;

        $this->display();
    }

    /**
     * My test task.
     * 
     * @access public
     * @return void
     */
    public function testtask($type = 'wait', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Save session. */
        $this->session->set('testtaskList', $this->app->getURI(true));

        $this->app->loadLang('testcase');

        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);

        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->testTask;
        $this->view->position[] = $this->lang->my->testTask;
        $this->view->tasks      = $this->loadModel('testtask')->getByUser($this->app->user->account, $pager, $sort, $type);
        
        $this->view->recTotal   = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->type       = $type;
        $this->view->pager      = $pager;
        $this->display();

    }

    /**
     * My test case.
     * 
     * @param  string $type 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function testcase($type = 'assigntome', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session, load lang. */
        $this->session->set('caseList', $this->app->getURI(true));
        $this->app->loadLang('testcase');
        $this->app->loadLang('testtask');
        
        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);

        $cases = array();
        if($type == 'assigntome')
        {
            $cases = $this->dao->select('t1.assignedTo AS assignedTo, t2.*')->from(TABLE_TESTRUN)->alias('t1')
                ->leftJoin(TABLE_CASE)->alias('t2')->on('t1.case = t2.id')
                ->leftJoin(TABLE_TESTTASK)->alias('t3')->on('t1.task = t3.id')
                ->Where('t1.assignedTo')->eq($this->app->user->account)
                ->andWhere('t1.status')->ne('done')
                ->andWhere('t3.status')->ne('done')
                ->andWhere('t3.deleted')->eq(0)
                ->andWhere('t2.deleted')->eq(0)
                ->orderBy($sort)->page($pager)->fetchAll();
        }
        elseif($type == 'donebyme')
        {
            $cases = $this->dao->select('t1.assignedTo AS assignedTo, t2.*')->from(TABLE_TESTRUN)->alias('t1')
                ->leftJoin(TABLE_CASE)->alias('t2')->on('t1.case = t2.id')
                ->Where('t1.assignedTo')->eq($this->app->user->account)
                ->andWhere('t1.status')->eq('done')
                ->andWhere('t2.deleted')->eq(0)
                ->orderBy($sort)->page($pager)->fetchAll();
        }
        elseif($type == 'openedbyme')
        {
            $cases = $this->dao->findByOpenedBy($this->app->user->account)->from(TABLE_CASE)
                ->andWhere('deleted')->eq(0)
                ->orderBy($sort)->page($pager)->fetchAll();
        }
        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'testcase', $type == 'assigntome' ? false : true);
        
        /* Assign. */
        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->testCase;
        $this->view->position[] = $this->lang->my->testCase;
        $this->view->cases      = $cases;
        $this->view->users      = $this->user->getPairs('noletter');
        $this->view->tabID      = 'test';
        $this->view->type       = $type;
        $this->view->recTotal   = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->pager      = $pager;
        
        $this->display();
    }

    // /**
    //  * My projects.
    //  * 
    //  * @access public
    //  * @return void
    //  */
    // public function project()
    // {
    //     $this->app->loadLang('project');

    //     $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->myProject;
    //     $this->view->position[] = $this->lang->my->myProject;
    //     $this->view->tabID      = 'project';
    //     $this->view->projects   = @array_reverse($this->user->getProjects($this->app->user->account));

    //     $this->display();
    // }

    // addedbygy
    public function project($type = 'all', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1) 
    { 
        /* Save session. load Lang. */ 
        $this->session->set('projectList', $this->app->getURI(true)); 
        $this->app->loadLang('project'); 

        /* Load pager. */ 
        $this->app->loadClass('pager', $static = true); 
        if($this->app->getViewType() == 'mhtml') $recPerPage = 10; 
        $pager = pager::init($recTotal, $recPerPage, $pageID); 
        /* Append id for secend sort. */ 
        $sort = $this->loadModel('common')->appendOrder($orderBy); 
        // echo "$orderBy";
        // addedbygy
        $projects =$this->loadModel('user')->getProjects($this->app->user->account, $type, $sort, 0, $pager); 
        
        $projectIDs = ''; 
        foreach($projectIDs as $project) $projectIDs .= ',' . $project->id; 
        $this->session->set('projectIDs', $projectIDs . ','); 
        /*assign*/ 
        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->myProject; 
        $this->view->position[] = $this->lang->my->myProject; 
        $this->view->users      = $this->user->getPairs('noletter'); 
        $this->view->type       = $type; 
        $this->view->recTotal   = $recTotal; 
        $this->view->recPerPage = $recPerPage; 
        $this->view->pageID     = $pageID; 
        $this->view->orderBy    = $orderBy; 
        $this->view->pager      = $pager; 
        $this->view->tabID      = 'project'; 
        //$this->view->projects   = @array_reverse($this->user->getProjects($this->app->user->account)); 
        $this->view->projects =$projects; 
        $this->display(); 
    }

    /**
     * Edit profile 
     * 
     * @access public
     * @return void
     */
     public function editProfile()
     {
        if($this->app->user->account == 'guest') die(js::alert('guest') . js::locate('back'));
        if(!empty($_POST))
        {
            //modified by zzj
            $user=$this->loadModel('user')->getById($this->app->user->id);
            $user->realname=trim($_POST['realname']);
            $user->gender=$_POST['gender'];
            $realname=$_POST['realname'];
            $_SESSION['realname']=$realname;
            //$this->user->update($this->app->user->id);
            $this->dao->update(TABLE_USER)->data($user)->where('id')->eq($this->app->user->id)->exec();
            if(dao::isError()) die(js::error(dao::getError()));
            //die(js::locate($this->createLink('my', 'profile'), 'parent'));
            die(js::reload('parent.parent'));
        }

        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->editProfile;
        $this->view->position[] = $this->lang->my->editProfile;
        $this->view->user       = $this->user->getById($this->app->user->id);

        $this->display();
    }

    /**
     * Change password 
     * 
     * @access public
     * @return void
     */
    public function changePassword()
    {
        if($this->app->user->account == 'guest') die(js::alert('guest') . js::locate('back'));
        if(!empty($_POST))
        {
            $this->user->updatePassword($this->app->user->id);
            if(dao::isError()) die(js::error(dao::getError()));
            //die(js::locate($this->createLink('my', 'profile'), 'parent'));
            die(js::reload('parent.parent'));
        }

        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->changePassword;
        $this->view->position[] = $this->lang->my->changePassword;
        $this->view->user       = $this->user->getById($this->app->user->id);

        $this->display();
    }

    /**
     * View my profile.
     * 
     * @access public
     * @return void
     */
    public function profile()
    {
        if($this->app->user->account == 'guest') die(js::alert('guest') . js::locate('back'));

        $user = $this->user->getById($this->app->user->account);
        //modified by zzj
        $this->view->title      = '个人资料';
        //$this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->profile;
        $this->view->position[] = $this->lang->my->profile;
        $this->view->user       = $user;
        $this->view->groups     = $this->loadModel('group')->getByAccount($this->app->user->account);
        $this->view->deptPath   = $this->dept->getParents($user->dept); 
        $this->display();
    }

    /**
     * My dynamic.
     * 
     * @param  string $type 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function dynamic($type = 'today', $orderBy = 'date_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $uri = $this->app->getURI(true);
        $this->session->set('productList',     $uri);
        $this->session->set('productPlanList', $uri);
        $this->session->set('releaseList',     $uri);
        $this->session->set('storyList',       $uri);
        $this->session->set('projectList',     $uri);
        $this->session->set('taskList',        $uri);
        $this->session->set('buildList',       $uri);
        $this->session->set('bugList',         $uri);
        $this->session->set('caseList',        $uri);
        $this->session->set('testtaskList',    $uri);

        /* Set the pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);

        /* The header and position. */
        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->dynamic;
        $this->view->position[] = $this->lang->my->dynamic;

        /* Assign. */
        $this->view->type       = $type;
        $this->view->recTotal   = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->pager      = $pager;
        $this->view->actions    = $this->loadModel('action')->getDynamic($this->app->user->account, $type, $sort, $pager);
        $this->display();
    }

    public function weatheredit($sprintID=0) 
    { 
      if(!empty($_POST)) 
      {       
        $this->my->create();              
        die(js::closeModal('parent.parent')); 
      }
      $this->view->sprintID = $sprintID; 
      $this->display(); 
    }

    public function sprintTeam($sprintID = 0)
    {

	$planID = $this->loadModel('sprint')->getPlanIDBySprintID($sprintID);
	$plan = $this->loadModel('productplan')->getByID($planID, true);
	$products = $this->loadModel('product')->getPairs();
	$productplans = $this->loadModel('productplan')->getPairs($plan->product);
	$this->view->title = $this->lang->sprint->backlogname;
	$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $products[$plan->product]);
	$plans = $this->loadModel('productplan')->getPlanByPlanID($planID);
	$this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$planID"), $plans[$planID]);

        // $teamMembers = $this->loadModel('pro')->getTeamMembers($planID);
        $teamMembers    = $this->loadModel('pro')->getTMembers($planID);
        $teamMembersUni = $this->loadModel('pro')->getTMAccounts($planID);
        $projects  = $this->loadModel('productplan')->getProjectPairs($planID);
        $this->view->projects = $projects;
        $this->view->planID = $planID;
        $this->view->teamMembers = $teamMembers;
        $this->view->teamMembersUni = $teamMembersUni;
        
        $this->display ();
    }

	/**
     * My sprintbugs.
     * 
     * @param  string $type 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function sprintbug($sprintID=0, $type = 'assignedTo', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. load Lang. */
        $this->session->set('bugList', $this->app->getURI(true));
        $this->app->loadLang('bug');
        
        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        if($this->app->getViewType() == 'mhtml') $recPerPage = 10;
        $pager = pager::init($recTotal, $recPerPage, $pageID);
       
        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);
        $bugs = $this->loadModel('bug')->getUserSprintBugs($this->app->user->account,$sprintID,$type, $sort, 0, $pager);
        /* Save bugIDs session for get the pre and next bug. */
        $bugIDs = '';
        foreach($bugs as $bug) $bugIDs .= ',' . $bug->id;
        $this->session->set('bugIDs', $bugIDs . ',');

        /* assign. */
		$this->view->sprintID   = $sprintID;
        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->bug;
        $this->view->position[] = $this->lang->my->bug;
        $this->view->bugs       = $bugs;
        $this->view->users      = $this->user->getPairs('noletter');
        $this->view->tabID      = 'bug';
        $this->view->type       = $type;
        $this->view->recTotal   = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->pager      = $pager;

        $this->display();
    }
    
  	/**
     * My sprinttasks
     * 
     * @param  string $type 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
 	public function sprinttask($sprintID=0, $type = 'assignedTo', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Save session. */
        $this->session->set('taskList',  $this->app->getURI(true));
        $this->session->set('storyList', $this->app->getURI(true));

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        if($this->app->getViewType() == 'mhtml') $recPerPage = 10;
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Append id for secend sort. */
        $sort = $this->loadModel('common')->appendOrder($orderBy);

        /* Assign. */
	$this->view->sprintID   = $sprintID;
        $this->view->title      = $this->lang->my->common . $this->lang->colon . $this->lang->my->task;
        $this->view->position[] = $this->lang->my->task;
        $this->view->tabID      = 'task';
        $this->view->tasks      = $this->loadModel('task')->getUserSprintTasks($this->app->user->account, $sprintID, $type, 0, $pager, $sort);
        $this->view->type       = $type;
        $this->view->recTotal   = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->users      = $this->loadModel('user')->getPairs('noletter');
        $this->view->pager      = $pager;
        $this->display();
    }
}
