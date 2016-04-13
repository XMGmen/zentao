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
class sprint extends control
{
    
	public $projects;
    public function __construct($moduleName = '', $methodName = '')
    {
        parent::__construct($moduleName, $methodName);
	$this->moduleName='sprint';
    }  
    public function index($projectID=0, $orderBy = '', $type = 'byModule', $param = 0)
    {
    	$this->app->loadClass('pager', $static = true);
    	$pager = new pager($recTotal, $recPerPage, $pageID);
    	
    	$users = $this->loadModel('user')->getPairs('noletter');
        if(!$orderBy) $orderBy = $this->cookie->projectStoryOrder ? $this->cookie->projectStoryOrder : 'pri';
        setcookie('projectStoryOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

    
        $sort = $this->loadModel('common')->appendOrder($orderBy);
        $stories = $this->loadModel('story')->getProjectStories($projectID, $sort);
        $storyTasks = $this->loadModel('task')->getStoryTaskCounts(array_keys($stories), $projectID);
    	
    	$products = $this->loadModel('product')->getPairs();
    	$product_id = $this->sprint->getProductIDBySprintID($projectID);
    	$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
    	$plans = $this->loadModel('productplan')->getPairs($product_id);
    	$plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);
    	$this->view->title = $plans[$plan_id];
    	$this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$plan_id"), $plans[$plan_id]);
    	
    	$projectStats  = $this->loadModel('productplan')->getProjectPairs($plan_id);
        $this->view->position[] = $projectStats[$projectID];
    	// $this->view->position[] = html::select('proj', $projectStats, $projectID, "class='' onchange='byProj(this.value)'");
    	
    	$this->view->orderBy    = $orderBy;
        $this->view->storyTasks = $storyTasks;
        $this->view->projectID = $projectID;
        $this->view->sprintID = $projectID;
        $this->view->productID = $product_id;
        $this->view->planID    = $planID;
        $this->view->stories = $stories;
        $this->view->users = $users;
        $this->view->pager = $pager;
        $this->view->param = $param;
        $this->view->projectStats = $projectStats;
        $this->display();
    }

    public function story($projectID = 0, $orderBy = '', $type = 'byModule', $param = 0)
	{
		
        $this->loadModel('story');
        $this->loadModel('user');
        $this->loadModel('task');
        $users= $this->user->getPairs('noletter');
        if(!$orderBy) $orderBy = $this->cookie->projectStoryOrder ? $this->cookie->projectStoryOrder : 'pri';
        setcookie('projectStoryOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);

    
        $sort = $this->loadModel('common')->appendOrder($orderBy);
        $stories=$this->story->getProjectStories($projectID, $sort);
        $storyTasks = $this->task->getStoryTaskCounts(array_keys($stories), $projectID);
	 	
        $this->view->orderBy    = $orderBy;
        $this->view->storyTasks = $storyTasks;
		$this->view->projectID=$projectID;
	 	$this->view->stories=$stories;
		$this->view->users = $users;
        $this->display();
	}
	 
     public function task($projectID = 0, $status = 'all', $param = 0, $orderBy = '', $recTotal = 0, $recPerPage = 100, $pageID = 1)
    {
        $this->loadModel('task');
    	$users= $this->loadModel('user')->getPairs('noletter');
        if(!$orderBy) $orderBy = $this->cookie->projectTaskOrder ? $this->cookie->projectTaskOrder : 'status,id_desc';
        setcookie('projectTaskOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        $sort = $this->loadModel('common')->appendOrder($orderBy);
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        
        $qureyStatus=$status;
        if($qureyStatus == 'unclosed')
        {
        	$qureyStatus = $this->lang->task->statusList;
        	unset($qureyStatus['closed']);
        	$qureyStatus = array_keys($qureyStatus);
        }

        $tasks = $this->loadModel('task')->getProjectTasks($projectID,$qureyStatus,$sort,$pager);

        $products = $this->loadModel('product')->getPairs();
        $productsAllbyheng = $this->loadModel('project')->getProducts($projectID);
        foreach($productsAllbyheng as $productID => $productName)
        {
        
            $product_id = $productID;
            $product_name = $productName;
        
        }
        $this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
        $plans = $this->loadModel('productplan')->getPairs($product_id);
        $plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);
        $this->view->title = $plans[$plan_id];
        $this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$plan_id"), $plans[$plan_id]);
        
        $projectStats  = $this->loadModel('productplan')->getProjectPairs($plan_id);
        $this->view->position[] = $projectStats[$projectID];
        // $this->view->position[] = html::select('proj', $projectStats, $projectID, "class='' onchange='byProj(this.value)'") ;

        $this->view->summary      = $this->project->summary($tasks);
        $this->view->pager        = $pager;
        $this->view->recTotal     = $pager->recTotal;
        $this->view->recPerPage   = $pager->recPerPage;
        $this->view->orderBy      = $orderBy;
        $this->view->tasks        = $tasks;
        $this->view->projectID    = $projectID;
        $this->view->sprintID     = $projectID;
        $this->view->status       = $status;
        $this->view->projectStats = $projectStats;
        $this->view->users        = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Edit a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function taskedit($taskID, $comment = false)
    {

        $this->taskAction($taskID);
        $projectID = $this->view->project->id;
        $projectName = $this->view->project->name;

        if(!empty($_POST))
        {
           
            $this->loadModel('action');
            $changes = array();
            $files   = array();
            //added by zzj
            $oldAss  = $this->dao->select('assignedTo')->from(TABLE_TASK)->where('id')->eq($taskID)->fetch('assignedTo');
            if($comment == false)
            {
                $changes = $this->loadModel('task')->update($taskID);
                if(dao::isError()) die(js::error(dao::getError()));
                $files = $this->loadModel('file')->saveUpload('task', $taskID);
            }

            $task = $this->loadModel('task')->getById($taskID);
            if($this->post->comment != '' or !empty($changes) or !empty($files))
            {
                $action = !empty($changes) ? 'Edited' : 'Commented';
                $fileAction = !empty($files) ? $this->lang->addFiles . join(',', $files) . "\n" : '';
                $actionID = $this->action->create('task', $taskID, $action, $fileAction . $this->post->comment);
                if(!empty($changes)) $this->action->logHistory($actionID, $changes);
                $this->sendmail($taskID, $actionID);
            }

            if($task->fromBug != 0)
            {
                foreach($changes as $change)
                {
                    if($change['field'] == 'status')
                    {
                        $confirmURL = $this->createLink('bug', 'view', "id=$task->fromBug");
                        $cancelURL  = $this->server->HTTP_REFERER;
                        die(js::confirm(sprintf($this->lang->task->remindBug, $task->fromBug), $confirmURL, $cancelURL, 'parent', 'parent'));
                    }
                }
            }
            //added by zzj
            $this->loadModel('myFastMsg')->sendTaskMsg(0,$taskID,$oldAss);
            die(js::locate($this->createLink('sprint', 'task', "projectID=$projectID"), 'parent')); // addedbyheng
           
        }
    
        // added
        $products = $this->loadModel('product')->getPairs();
        $productsAllbyheng = $this->loadModel('project')->getProducts($projectID);
        foreach($productsAllbyheng as $productID => $productName)
        {
        
            $product_id = $productID;
            $product_name = $productName;
        
        }
        $this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
        $plans = $this->loadModel('productplan')->getPairs($product_id);
        $plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);
        
        $noclosedProjects = $this->loadModel('project')->getPairs('noclosed,nocode');
        unset($noclosedProjects[$projectID]);
        $this->view->projects = array($projectID => $projectName) + $noclosedProjects;

        if(!isset($members[$this->view->task->assignedTo])) $members[$this->view->task->assignedTo] = $this->view->task->assignedTo;
        $this->view->title      = $this->lang->task->edit . 'TASK' . $this->lang->colon . $this->view->task->name;
        $this->view->position[] = html::a($this->createLink('pro', 'index', "planID=$plan_id"), $plans[$plan_id]);
        $projectStats  = $this->loadModel('productplan')->getProjectPairs($plan_id);
        $this->view->position[] = html::a($this->createLink('sprint', 'task', "projectID=$projectID"), $projectStats[$projectID]);
        $this->view->position[] = $this->view->task->name;
        // $this->view->position[] = $this->lang->task->common;
        // $this->view->position[] = $this->lang->task->edit;
        $this->view->stories    = $this->loadModel('story')->getProjectStoryPairs($this->view->project->id);
        // $this->view->users     = $this->loadModel('user')->getPairs('nodeleted|noletter', "{$this->view->task->openedBy},{$this->view->task->canceledBy},{$this->view->task->closedBy}"); 
        //added by zzj
        $this->view->users=$this->loadModel('user')->getUsersByTaskID($taskID);
        $this->view->modules    = $this->loadModel('tree')->getTaskOptionMenu($this->view->task->project);
        $this->view->sprintID   = $projectID;
        $this->view->projectID  = $projectID;
        $this->view->projectStats = $projectStats;

        $projects = $this->dao->select('id,name')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetchPairs('id,name');
        $this->view->projects = $projects;	    
        // $this->view->task       = $task;
        $this->display();
    }


    public function sendmail($taskID, $actionID)
    {
        /* Reset $this->output. */
        $this->clear();

        /* Set toList and ccList. */
        $task        = $this->loadModel('task')->getById($taskID);
        $projectName = $this->loadModel('project')->getById($task->project)->name;
        $users       = $this->loadModel('user')->getPairs('noletter');
        $toList      = $task->assignedTo;
        $ccList      = trim($task->mailto, ',');

        if($toList == '')
        {
            if($ccList == '') return;
            if(strpos($ccList, ',') === false)
            {
                $toList = $ccList;
                $ccList = '';
            }
            else
            {
                $commaPos = strpos($ccList, ',');
                $toList = substr($ccList, 0, $commaPos);
                $ccList = substr($ccList, $commaPos + 1);
            }
        }
        elseif(strtolower($toList) == 'closed')
        {
            $toList = $task->finishedBy;
        }

        /* Get action info. */
        $action          = $this->loadModel('action')->getById($actionID);
        $history         = $this->loadModel('action')->getHistory($actionID);
        $action->history = isset($history[$actionID]) ? $history[$actionID] : array();

        /* Create the email content. */
        $this->view->task   = $task;
        $this->view->action = $action;
        $this->view->users  = $users;

        $mailContent = $this->parse('task', 'sendmail'); //changed

        /* Send emails. */
        $this->loadModel('mail')->send($toList, $projectName . ':' . 'TASK#' . $task->id . $this->lang->colon . $task->name, $mailContent, $ccList);
        if($this->loadModel('mail')->isError()) trigger_error(join("\n", $this->loadModel('mail')->getError()));
    }

    public function bug($projectID = 0, $type='', $orderBy = 'status,id_desc', $build = 0, $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
    	$users = $this->loadModel('user')->getPairs('noletter');

    	if(!$orderBy) $orderBy = $this->cookie->projectTaskOrder ? $this->cookie->projectTaskOrder : 'status,id_desc';
    	setcookie('projectTaskOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
    	$sort = $this->loadModel('common')->appendOrder($orderBy);
    	$this->app->loadClass('pager', $static = true);
    	$pager = new pager($recTotal, $recPerPage, $pageID);
    	$bugs  = $this->loadModel('bug')->getProjectBugs($projectID,$type,$this->app->user->account,$orderBy,$pager);

        $products = $this->loadModel('product')->getPairs();
        $productsAllbyheng = $this->loadModel('project')->getProducts($projectID);
        foreach($productsAllbyheng as $productID => $productName)
        {
            $product_id = $productID;
            $product_name = $productName;
        }
        $this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
        $plans = $this->loadModel('productplan')->getPairs($product_id);
        $plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);
        $this->view->title = $plans[$plan_id];
        $this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$plan_id"), $plans[$plan_id]);
        
        $projectStats  = $this->loadModel('productplan')->getProjectPairs($plan_id);
        $this->view->position[] = $projectStats[$projectID];
        // $this->view->position[] = html::select('proj', $projectStats, $projectID, "class='' onchange='byProj(this.value)'");
        $memberPairs = $this->user->getPairs('noletter|nodeleted');
        $this->view->memberPairs=$memberPairs;
    	$this->view->pager        = $pager;
    	$this->view->bugs         = $bugs;
    	$this->view->orderBy      = $orderBy;
    	$this->view->users        = $users;
    	$this->view->projectID    = $projectID;
        $this->view->sprintID     = $projectID;
        $this->view->productID    = $product_id;
        $this->view->planID       = $plan_id;
        $this->view->projectStats = $projectStats;
        $this->view->type         = $type;
        $this->view->buildID      = $build;
        $this->view->groupID      = $this->loadModel('user')->getGroupID($this->app->user->account);
        $userId = $this->app->user->id;
        $this->view->userId       = $userId;
        $this->view->importButton = $this->lang->sprint->importbugs;
        $this->view->downloadExcel = $this->lang->sprint->downloadExcel;
        $file    = $this->dao->select('*')->from(TABLE_FILE)->where('objectType')->eq('excelTemplate')->fetch();
        $webPath = $this->app->getWebRoot() . "data/download/" . $file->pathname;
        $this->view->downloadLink  = "http://".$_SERVER['HTTP_HOST'].$webPath;
    	$this->display();
    }

    public function review($projectID = 0, $orderBy = 'status,id_desc', $build = 0, $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $users = $this->loadModel('user')->getPairs('noletter');

        if(!$orderBy) $orderBy = $this->cookie->projectTaskOrder ? $this->cookie->projectTaskOrder : 'status,id_desc';
        setcookie('projectTaskOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
        $sort = $this->loadModel('common')->appendOrder($orderBy);
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $products = $this->loadModel('product')->getPairs();
        $productsAllbyheng = $this->loadModel('project')->getProducts($projectID);
        foreach($productsAllbyheng as $productID => $productName)
        {
        
            $product_id = $productID;
            $product_name = $productName;
        
        }
	$reviewID = $this->LoadModel('sprint')->getReviewID($projectID);
	$this->view->reviewStatus = $reviewID;
	
	if($reviewID != 0){
		$review = $this->loadModel('sprint')->getReview($projectID);
		$this->view->real_begin = $review->real_begin;
		$this->view->real_end = $review->real_end;
		$this->view->estimatePoints = $review->estimatePoints;
		$this->view->realPoints = $review->realPoints;
		$this->view->expl = $review->expl;
		$this->view->referenceStory = $review->referenceStory;
		$this->view->date = $review->date;
		$this->view->time = $review->time;
		$this->view->place = $review->place;
		$this->view->persons = $review->persons;
		$this->view->completeFunc = $review->completeFunc;
		$this->view->summary = $review->summary;
		$this->view->other = $review->other;
		 
		$sprintBegin = $this->loadModel('sprint')->getBegin($projectID);
		$this->view->sprintBegin = $sprintBegin;
		 
		$sprintEnd = $this->loadModel('sprint')->getEnd($projectID);
		$this->view->sprintEnd = $sprintEnd;
		 
		$sprintDesc = $this->sprint->getDesc($projectID);
		$this->view->sprintDesc = $sprintDesc;
	}		
	
        $this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
        $plans = $this->loadModel('productplan')->getPairs($product_id);
        $plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);
        $this->view->title = $plans[$plan_id];
        $this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$plan_id"), $plans[$plan_id]);
        
        $projectStats  = $this->loadModel('productplan')->getProjectPairs($plan_id);
        $this->view->position[] = $projectStats[$projectID];
        // $this->view->position[] = html::select('proj', $projectStats, $projectID, "class='' onchange='byProj(this.value)'") ;

        $this->view->pager       = $pager;
        $this->view->orderBy     = $orderBy;
        $this->view->users       = $users;
        $this->view->projectID   = $projectID;
        $this->view->sprintID    = $projectID;
        $this->view->projectStats = $projectStats;
        $this->display();
    }

    public function burn($projectID = 0, $type = 'noweekend', $interval = 0)
    {
        /* Header and position. */
        $products = $this->loadModel('product')->getPairs();
        $productsAllbyheng = $this->loadModel('project')->getProducts($projectID);
        foreach($productsAllbyheng as $productID => $productName)
        {
        
            $product_id = $productID;
            $product_name = $productName;
        
        }
        $this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
        $plans = $this->loadModel('productplan')->getPairs($product_id);
        $plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);
        $this->view->title = $plans[$plan_id];
        $this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$plan_id"), $plans[$plan_id]);
        
        $projectStats  = $this->loadModel('productplan')->getProjectPairs($plan_id);
        $this->view->position[] = $projectStats[$projectID];
        // $this->view->position[] = html::select('proj', $projectStats, $projectID, "class='' onchange='byProj(this.value)'") ;

    	$this->loadModel('report');
    	// $project     = $this->commonAction(2);
    	$projectInfo = $this->loadModel("project")->getByID($projectID);
    
    	/* Get date list. */
    	list($dateList, $interval) = $this->loadModel("project")->getDateList($projectInfo->begin, $projectInfo->end, $type, $interval, 'Y-m-d');
    
        // echo "$interval";

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
        $isDone = $this->dao->select('status')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetch('status');
        if ($endDate < $today && ($isDone !='done'))
        {
            //$cdate = $today_num + 7*$time_cont;
            //$ndate = date("Y-m-d",$cdate);
            $proj = $this->dao->select('*')->from(TABLE_PROJECT)->where('id')->eq($projectID)->fetch();
            //$proj->end = $ndate;
            $proj->end = $today;
            $this->dao->delete()->from(TABLE_PROJECT)->where('id')->eq($projectID)->exec();
            $this->dao->insert(TABLE_PROJECT)->data($proj)->exec();
            $delayMsg = $proj->name ." " . $this->lang->sprint->delayWarn;
            $this->view->delayMsg = $delayMsg;
        } else {
            $this->view->delayMsg = '';
        }

        // Update automatically
        $burnFromTask = $this->dao->select("sum(`left`) AS `left`")
            ->from(TABLE_TASK)
            ->where('project')->eq($projectID)
            ->andWhere('deleted')->eq('0')
            ->andWhere('status')->notin('cancel,closed')
            ->groupBy('project')
            ->fetch('left');
        // echo $burnFromTask . "1-";
        $burnFromBurn = $this->dao->select('*')
            ->from(TABLE_BURN)
            ->where('project')->eq($projectID)
            ->andWhere('date')->eq($today)
            ->fetch('left');
        // echo $burnFromBurn . "-1";
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

        /* Assign. */
        $this->view->tabID       = 'burn';
        $this->view->charts      = $charts;
        $this->view->projectID   = $projectID;
        $this->view->sprintID    = $projectID;
        $this->view->projectName = $projectInfo->name;
        $this->view->type        = $type;
        $this->view->interval    = $interval;
        $this->view->chartData   = $chartData;
        $this->view->dayList     = array('full' => $this->lang->project->interval . $space . 1 . $space . $this->lang->day) + $dayList;
        $this->view->projectStats = $projectStats;
        $this->view->isOpeSprint = $this->loadModel(project)->isOperSprint($projectID);
        $this->display();
    }
     
     public function commonAction($projectID = 0, $extra = '')
    {
        $this->loadModel('product');
        $this->loadModel('project');

        /* Get projects and products info. */
        $projectID     = $this->project->saveState($projectID, array_keys($this->projects));
        $project       = $this->project->getById($projectID);
        $products      = $this->project->getProducts($project->id);
        $childProjects = $this->project->getChildProjects($project->id);
        $teamMembers   = $this->project->getTeamMembers($project->id);
        $actions       = $this->loadModel('action')->getList('project', $project->id);

        /* Set menu. */
        $this->project->setMenu($this->projects, $project->id, $extra);

        /* Assign. */
        $this->view->projects      = $this->projects;
        $this->view->project       = $project;
        $this->view->childProjects = $childProjects;
        $this->view->products      = $products;
        $this->view->teamMembers   = $teamMembers;
        $this->view->actions       = $actions;

        return $project;
    }


    public function taskAction($taskID)
    {
        $this->view->task    = $this->loadModel('task')->getByID($taskID);
        $this->view->project = $this->loadModel('project')->getById($this->view->task->project);
        $this->view->members = $this->loadModel('project')->getTeamMemberPairs($this->view->project->id ,'nodeleted');
        $this->view->actions = $this->loadModel('action')->getList('task', $taskID);

        /* Set menu. */
        $this->project->setMenu($this->project->getPairs(), $this->view->project->id);
        // $this->view->position[] = html::a($this->createLink('project', 'browse', "project={$this->view->task->project}"), $this->view->project->name);
    }

    /**changed
     * Edit a bug.
     * 
     * @param  int    $bugID 
     * @access public
     * @return void
     */
    public function bugedit($bugID, $comment = false)
    {
        $this->loadModel('bug');
        $this->loadModel('action');
        $this->loadModel('product');
        $this->loadModel('task');
        $this->loadModel('tree');
        $this->loadModel('user');
        $this->loadModel('story');

        /* Get the info of bug, current product and modue. */
        $bug             = $this->bug->getById($bugID);
        $productID       = $bug->product;
        $projectID       = $bug->project;
        $currentModuleID = $bug->module;

        if(!empty($_POST))
        {
            $changes = array();
            $files   = array();
            $oldAss  = $this->dao->select('assignedTo')->from(TABLE_BUG)->where('id')->eq($bugID)->fetch('assignedTo');
            if($comment == false)
            {
                $changes  = $this->bug->update($bugID);
                if(dao::isError()) die(js::error(dao::getError()));
                $files = $this->loadModel('file')->saveUpload('bug', $bugID);
            }
            if($this->post->comment != '' or !empty($changes) or !empty($files))
            {
                $action = !empty($changes) ? 'Edited' : 'Commented';
                $fileAction = '';
                if(!empty($files)) $fileAction = $this->lang->addFiles . join(',', $files) . "\n" ;
                $actionID = $this->action->create('bug', $bugID, $action, $fileAction . $this->post->comment);
                $this->action->logHistory($actionID, $changes);
                $this->sendmail($bugID, $actionID);
            }

            $bug = $this->bug->getById($bugID);
            if($bug->toTask != 0) 
            {
                foreach($changes as $change)
                {
                    if($change['field'] == 'status') 
                    {
                        $confirmURL = $this->createLink('task', 'view', "taskID=$bug->toTask");
                        $cancelURL  = $this->server->HTTP_REFERER;
                        die(js::confirm(sprintf($this->lang->bug->remindTask, $bug->Task), $confirmURL, $cancelURL, 'parent', 'parent'));
                    }
                }
            } 
            // die(js::locate($this->createLink('bug', 'view', "bugID=$bugID"), 'parent'));
            $projectIDplus = $this->dao->select('project')->from(TABLE_BUG)->where('id')->eq($bugID)->fetch('project');
            $this->loadModel('myFastMsg')->sendBugMsg($bugID,$projectIDplus,$oldAss);
            die(js::locate($this->createLink('sprint', 'bug', "projectID=$projectID"), 'parent'));
        }

        $products = $this->loadModel('product')->getPairs();

        /* Set the menu. */
        $this->bug->setMenu($products, $productID);

        /* Set header and position. */
        $this->view->title      = $this->lang->bug->edit . "BUG #$bug->id $bug->title - " . $products[$productID];
        


        // $this->view->position[] = html::a($this->createLink('bug', 'browse', "productID=$productID"), $this->products[$productID]);
        // $this->view->position[] = $this->lang->bug->edit;

        /* Assign. */
        if($projectID)
        {
            $this->view->openedBuilds     = $this->loadModel('build')->getProjectBuildPairs($projectID, $productID, 'noempty');
        }
        else
        {
            $this->view->openedBuilds     = $this->loadModel('build')->getProductBuildPairs($productID, 'noempty');
        }
       
        $this->view->bug              = $bug;
        $this->view->productID        = $productID;
        $this->view->productName      = $products[$productID];
        $this->view->plans            = $this->loadModel('productplan')->getPlanByPlanID($bug->plan);;
        $this->view->moduleOptionMenu = $this->tree->getOptionMenu($productID, $viewType = 'bug', $startModuleID = 0);
        $this->view->currentModuleID  = $currentModuleID;
        $this->view->projects         =$this->loadModel('project')->getPairsByProjectID($bug->project);
        
   
        $this->view->stories          = $bug->project ? $this->story->getProjectStoryPairs($bug->project) : $this->story->getProductStoryPairs($bug->product);
         
        $this->view->tasks            = $this->task->getProjectTaskPairs($bug->project);
         
        //$this->view->users            = $this->user->getPairs('nodeleted', "$bug->assignedTo,$bug->resolvedBy,$bug->closedBy,$bug->openedBy");
        $account=$this->loadModel('pro')->getAccount($bug->plan);
        // added
        $projectID = $this->loadModel('sprint')->getSprintByBugID($bugID);
        $planID    = $this->loadModel('sprint')->getPlanByBugID($bugID);
        // $users     = $this->user->getPairsUsers('nodeleted', $account, $bugID, $projectID, $planID);
        //added by zzj
        $users     = $this->loadModel('user')->getUsersByBugID($bugID);
        $this->view->users   = $users;
        //
        // $this->view->users   = $this->user->getPairs2('nodeleted', $bug->assignedTo,$account);
        
        $this->view->resolvedBuilds   = array('' => '') + $this->view->openedBuilds;
        $this->view->actions          = $this->action->getList('bug', $bugID);
        $this->view->templates        = $this->bug->getUserBugTemplates($this->app->user->account);
        $this->view->projectID        = $bug->project;

        $this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$productID"), $this->view->productName);
        $this->view->position[] = html::a($this->createLink('pro', 'index', "planID=$bug->plan"), $this->view->plans[$bug->plan]);
        $projectStats           = $this->loadModel('productplan')->getProjectPairs($bug->plan);
        $this->view->position[] = html::a($this->createLink('sprint', 'bug', "projectID=$projectID"), $projectStats[$projectID]);

        if(strlen($bug->title) > 50) {
            $bugTitle = substr($bug->title, 0, 48).'...';
        } else {
            $bugTitle = $bug->title;
        }
        $this->view->position[] = $bugTitle;

        //$this->view->position[] = $bug->title;
        $this->display();
    }


    /** added
     * Create a task.
     * 
     * @param  int    $projectID 
     * @param  int    $storyID 
     * @param  int    $moduleID 
     * @param  int    $taskID
     * @access public
     * @return void
     */
    public function taskcreate($projectID = 0, $storyID = 0, $moduleID = 0, $isFromStory=0,$taskID = 0)
    {
        $this ->loadModel('project');
        $this ->loadModel('task');
        $this ->loadModel('action');
        $this ->loadModel('story');
        $this ->loadModel('user');
        $this ->loadModel('tree');
       
        $task = new stdClass();
        $task->module      = $moduleID;
        $task->assignedTo  = '';
        $task->name        = '';
        $task->story       = $storyID;
        $task->type        = '';
        $task->pri         = '';
        $task->estimate    = '';
        $task->desc        = '';
        $task->estStarted  = '';
        $task->deadline    = '';
        $task->mailto      = '';
        if($taskID > 0)
        {
            $task      = $this->task->getByID($taskID);
            $projectID = $task->project;
        }

        $project   = $this->project->getById($projectID); 
        $taskLink  = $this->createLink('sprint', 'index', "projectID=$projectID");
        $storyLink = $this->session->storyList ? $this->session->storyList : $this->createLink('project', 'story', "projectID=$projectID");
        // $this->view->users    = $this->loadModel('user')->getPairs('nodeleted|noletter');
	//added by zzj
        $this->view->users=$this->loadModel('user')->getUsersByProjectID($projectID);
        /* Set menu. */
        $this->project->setMenu($this->project->getPairs(), $project->id);

        if(!empty($_POST))
        {
            $response['result']  = 'success';
            $response['message'] = '';

            $tasksID = $this->task->create($projectID);
            if(dao::isError())
            {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                $this->send($response);
            }

            /* if the count of tasksID is 1 then check exists. */
            if(count($tasksID) == 1)
            {
                $taskID = current($tasksID);
                if($taskID['status'] == 'exists')
                {
                    $response['locate']  = $this->createLink('task', 'view', "taskID={$taskID['id']}");
                    $response['message'] = sprintf($this->lang->duplicate, $this->lang->task->common);
                    $this->send($response);
                }
                //added by zzj
                $this->loadModel('myFastMsg')->sendTaskMsg(0,$taskID['id'],null,1);
            }

            /* Create actions. */
            //$this->loadModel('action');
            foreach($tasksID as $taskID)
            {
                /* if status is exists then this task has exists not new create. */
                if($taskID['status'] == 'exists') continue;

                $taskID   = $taskID['id'];
                $actionID = $this->action->create('task', $taskID, 'Opened', '');
                $this->sendmail($taskID, $actionID);
            }            

            /* Locate the browser. */
            if($this->post->after == 'continueAdding')
            {
                $response['message'] = $this->lang->task->successSaved . $this->lang->task->afterChoices['continueAdding'];
                $response['locate']  = $this->createLink('sprint', 'taskcreate', "projectID=$projectID&storyID={$this->post->story}&moduleID=$moduleID");
                $this->send($response);
            }
            elseif($this->post->after == 'toTaskList')
            {
                $response['locate'] = $taskLink;
                $this->send($response);
            }
            elseif($this->post->after == 'toStoryList')
            {
                $response['locate'] = $storyLink;
                $this->send($response);
            }
            else
            {
                $response['locate'] = $taskLink;
                $this->send($response);
            }
        }
        if($isFromStory)
        {
            $stories=$this->story->getPairsByID($storyID);
        }else{
            $stories          = $this->story->getProjectStoryPairs($projectID);
        }
        $members          = $this->project->getTeamMemberPairs($projectID, 'nodeleted');
        $contactLists     = $this->user->getContactLists($this->app->user->account, 'withnote');
        $moduleOptionMenu = $this->tree->getTaskOptionMenu($projectID);


        // addedbyheng
        $products = $this->loadModel('product')->getPairs();
        $productsAllbyheng = $this->loadModel('project')->getProducts($projectID);
        foreach($productsAllbyheng as $productID => $productName)
        {
        
            $product_id = $productID;
            $product_name = $productName;
        
        }
        $plans = $this->loadModel('productplan')->getPairs($product_id);
        $plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);

        $title      = $project->name . $this->lang->colon . $this->lang->task->create;
        $position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
        $position[] = html::a(helper::createLink("pro", "index", "planID=$plan_id"), $plans[$plan_id]);
        $position[] = html::a($taskLink, $project->name);
        $position[] = $stories[$storyID];
        // $position[] = $this->lang->task->common;
        // $position[] = $this->lang->task->create;
        
        $this->view->isFromStory      = $isFromStory;
        $this->view->title            = $title;
        $this->view->position         = $position;
        $this->view->project          = $project;
        $this->view->task             = $task;
        $this->view->stories          = $stories;
        $this->view->members          = $members;
        $this->view->contactLists     = $contactLists;
        $this->view->moduleOptionMenu = $moduleOptionMenu;
        $this->view->sprintID         = $projectID;
        $this->display();
    }

    /**added
     * Batch create task.
     * 
     * @param  int    $projectID 
     * @param  int    $storyID 
     * @access public
     * @return void
     */
    public function taskbatchCreate($projectID = 0, $storyID = 0, $iframe = 0)
    {

        $this ->loadModel('project');
        $this ->loadModel('task');
        $this ->loadModel('action');
        $this ->loadModel('story');
        $this ->loadModel('user');
        $this ->loadModel('tree');

        $project   = $this->project->getById($projectID); 
        $taskLink  = $this->createLink('sprint', 'task', "projectID=$projectID");
        //$storyLink = $this->session->storyList ? $this->session->storyList : $this->createLink('project', 'story', "projectID=$projectID");
        $storyLink = $taskLink;
        /* Set menu. */
        $this->project->setMenu($this->project->getPairs(), $project->id);

        if(!empty($_POST))
        {
            $mails = $this->task->batchCreate($projectID);
            if(dao::isError()) die(js::error(dao::getError()));

            foreach($mails as $mail) $this->sendmail($mail->taskID, $mail->actionID);

            /* Locate the browser. */
            if($iframe) die(js::reload('parent.parent'));
            die(js::locate($this->createLink('sprint', 'task', "projectID=$project->id"), 'parent'));
        }

        $stories = $this->story->getProjectStoryPairs($projectID, 0, 0, 'short');
        $members = $this->project->getTeamMemberPairs($projectID, 'nodeleted');
        $modules = $this->loadModel('tree')->getTaskOptionMenu($projectID);
        $title      = $project->name . $this->lang->colon . $this->lang->task->batchCreate;

        // addedbyheng
        $products = $this->loadModel('product')->getPairs();
        $productsAllbyheng = $this->loadModel('project')->getProducts($projectID);
        foreach($productsAllbyheng as $productID => $productName)
        {
        
            $product_id = $productID;
            $product_name = $productName;
        
        }
        $plans = $this->loadModel('productplan')->getPairs($product_id);
        $plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);
        $story = $this->loadModel('story')->getByID($storyID);

        $title      = $project->name . $this->lang->colon . $this->lang->task->create;
        $position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
        $position[] = html::a(helper::createLink("pro", "index", "planID=$plan_id"), $plans[$plan_id]);

        $position[] = html::a($taskLink, $project->name);
        $position[] = $story->title;
        
        // $position[] = $this->lang->task->common;
        $position[] = $this->lang->task->batchCreate;

        $this->view->title    = $title;
        $this->view->position = $position;
        $this->view->project  = $project;
        $this->view->stories  = $stories;
        $this->view->modules  = $modules;
        $this->view->storyID  = $storyID;
        $this->view->story    = $this->loadModel('story')->getByID($storyID);
        $this->view->members  = $members;
        $this->view->sprintID = $projectID;
        $this->display();
    }

    /**added
     * View a story.
     * 
     * @param  int    $storyID 
     * @param  int    $version 
     * @access public
     * @return void
     */
    public function storyview($storyID, $version = 0, $from = 'product', $param = 0)
    {
        // echo "$storyID";
        // echo "$version";
        // echo "$from";
        // echo "$param";

        $this->loadModel('story');
        $this->loadModel('tree');
        $this->loadModel('user');
        $this->loadModel('product');
        $this->loadModel('action');
        $storyID = (int)$storyID;
        $story   = $this->story->getById($storyID, $version, true);
        if(!$story) die(js::error($this->lang->notFound) . js::locate('back'));

        $story->files = $this->loadModel('file')->getByObject('story', $storyID);
        $product      = $this->dao->findById($story->product)->from(TABLE_PRODUCT)->fields('name, id')->fetch();
        $plan         = $this->dao->findById($story->plan)->from(TABLE_PRODUCTPLAN)->fetch('title');
        $bugs         = $this->dao->select('id,title')->from(TABLE_BUG)->where('story')->eq($storyID)->andWhere('deleted')->eq(0)->fetchAll();
        $fromBug      = $this->dao->select('id,title')->from(TABLE_BUG)->where('toStory')->eq($storyID)->fetch();
        $cases        = $this->dao->select('id,title')->from(TABLE_CASE)->where('story')->eq($storyID)->andWhere('deleted')->eq(0)->fetchAll();
        $modulePath   = $this->tree->getParents($story->module);
        $users        = $this->user->getPairs('noletter');

        /* Set the menu. */
        $this->product->setMenu($this->product->getPairs(), $product->id);

        if($from == 'project')
        {
            $project = $this->loadModel('project')->getById($param);
            if($project->status == 'done') $from = '';
        }
        $plans = $this->loadModel('productplan')->getPairs($story->product);
        $projectStats  = $this->loadModel('productplan')->getProjectPairs($story->plan);
        $title      = "STORY #$story->id $story->title - $product->name";
        $projectName=$projectStats[$story->project];
        //echo $projectName;
        $position[] = html::a($this->createLink('product', 'productplan', "product=$product->id"), $product->name);
        $position[] = html::a(helper::createLink("pro", "index", "planID=$story->plan"), $plans[$story->plan]);
        $position[] = html::a(helper::createLink("sprint", "index", "projectID=$story->project"), $projectStats[$story->project]);
        $position[] = $story->title;
        // $position[] = $this->lang->story->common;
        // $position[] = $this->lang->story->view;

        //added by fxq
        $backLogTitle=$this->loadModel('story')->getBackLogTitlebyStoryID($storyID);
        $this->view->backLogTitle    = $backLogTitle;
        $this->view->title      = $title;
        $this->view->position   = $position;
        $this->view->projectName =$projectName;
        $this->view->product    = $product;
        $this->view->$projectStats =$this->loadModel('productplan')->getProjectPairs($story->plan);        
        $this->view->plan       = $plan;
        $this->view->bugs       = $bugs;
        $this->view->fromBug    = $fromBug;
        $this->view->cases      = $cases;
        $this->view->story      = $story;
        $this->view->users      = $users;
        $this->view->projects   = $this->loadModel('project')->getPairs('nocode');
        $this->view->actions    = $this->action->getList('story', $storyID);
        $this->view->modulePath = $modulePath;
        $this->view->version    = $version == 0 ? $story->version : $version;
        $this->view->preAndNext = $this->loadModel('common')->getPreAndNextObject('story', $storyID);
        $this->view->from       = $from;
        $this->view->param      = $param;
        $this->view->sprintID   = $story->project;

        // echo "$story->project";

        $this->display();

    }


    /**added
     * View a task.
     * 
     * @param  int    $taskID 
     * @access public
     * @return void
     */
    public function taskview($taskID)
    {
        $this->loadModel('task');

        $task = $this->task->getById($taskID, true);
        if(!$task) die(js::error($this->lang->notFound) . js::locate('back'));

        $story           = $this->loadModel('story')->getById($task->story);
        $task->storySpec = ($story != null) ? $story->spec : '';

        /* Update action. */
        if($task->assignedTo == $this->app->user->account) $this->loadModel('action')->read('task', $taskID);

        /* Set menu. */
        $project = $this->loadModel('project')->getById($task->project);
        $this->project->setMenu($this->project->getPairs(), $project->id);


        $products = $this->loadModel('product')->getPairs();
        $plans = $this->loadModel('productplan')->getPairs($story->product);
        $productsAllbyheng = $this->loadModel('project')->getProducts($project->id);
        foreach($productsAllbyheng as $productID => $productName)
        {
        
            $product_id = $productID;
            $product_name = $productName;
        
        }
        $proID      = $this->dao->select('project')->from(TABLE_TASK)->where('id')->eq($taskID)->fetch('project');
        $planID     = $this->dao->select('plan')->from(TABLE_PROJECTPLAN)->where('project')->eq($proID)->fetch('plan');
        $planname   = $this->dao->select('title')->from(TABLE_PRODUCTPLAN)->where('id')->eq($planID)->fetch('title');
        $title      = "TASK#$task->id $task->name / $project->name";
        $position[] = html::a($this->createLink('product', 'productplan', "product=$product_id"), $products[$product_id]);
        $position[] = html::a(helper::createLink("pro", "index", "planID=$planID"), $planname);
        $position[] = html::a($this->createLink('sprint', 'task', "projectID=$task->project"), $project->name);
        $position[] = $task->name;

        // $position[] = $this->lang->task->common;
        // $position[] = $this->lang->task->view;


        $this->view->title       = $title;
        $this->view->position    = $position;
        $this->view->project     = $project;
        $this->view->task        = $task;
        $this->view->actions     = $this->loadModel('action')->getList('task', $taskID);
        $this->view->users       = $this->loadModel('user')->getPairs('noletter');
        $this->view->preAndNext  = $this->loadModel('common')->getPreAndNextObject('task', $taskID);
        $this->view->product     = $this->loadModel('tree')->getProduct($task->module);
        $this->view->modulePath  = $this->loadModel('tree')->getParents($task->module);
        $this->view->sprintID    = $task->project;
        $this->display();
    }


    /**added
     * View a bug.
     * 
     * @param  int    $bugID 
     * @access public
     * @return void
     */
    public function bugview($bugID)
    {
        $this->loadModel('bug');
        $this->loadModel('project');
        $this->loadModel('user');
        $this->loadModel('tree');
        $this->loadModel('action');
        /* Judge bug exits or not. */
        $bug = $this->bug->getById($bugID, true);
        if(!$bug) die(js::error($this->lang->notFound) . js::locate('back'));

        if($bug->project and !$this->loadModel('project')->checkPriv($this->project->getByID($bug->project)))
        {
            echo(js::alert($this->lang->project->accessDenied));
            die(js::locate('back'));
        }

        /* Update action. */
        if($bug->assignedTo == $this->app->user->account) $this->loadModel('action')->read('bug', $bugID);

        /* Set menu. */
        $this->bug->setMenu($products, $bug->product);

        /* Get product info. */
        $products = $this->loadModel('product')->getPairs();
        $productID   = $bug->product;
        $productName = $products[$productID];
        
        // echo "$bug->project";
        $plans = $this->loadModel('productplan')->getPairs($productID);
        $projectStats  = $this->loadModel('productplan')->getProjectPairs($bug->plan);

        /* Header and positon. */
        $this->view->title      = "BUG #$bug->id $bug->title - " . $products[$productID];
        $this->view->position[] = html::a($this->createLink('product', 'productplan', "productID=$productID"), $productName);
        $this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$bug->plan"), $plans[$bug->plan]);
        $this->view->position[] = html::a($this->createLink('sprint', 'bug', "projectID=$bug->project"), $projectStats[$bug->project]);

        if(strlen($bug->title) > 50) {
            $bugTitle = substr($bug->title, 0, 48).'...';
        } else {
            $bugTitle = $bug->title;
        }
        $this->view->position[] = $bugTitle;
        //$this->view->position[] = $bug->title;
        //$this->view->position[] = $this->lang->bug->view;

        /* Assign. */
        $this->view->productID   = $productID;
        $this->view->productName = $productName;
        $this->view->modulePath  = $this->tree->getParents($bug->module);
        $this->view->bug         = $bug;
        $this->view->users       = $this->user->getPairs('noletter');
        $this->view->actions     = $this->action->getList('bug', $bugID);
        $this->view->builds      = $this->loadModel('build')->getProductBuildPairs($productID);
        $this->view->preAndNext  = $this->loadModel('common')->getPreAndNextObject('bug', $bugID);
        $this->view->sprintID    = $bug->project;
        $this->view->projectID   = $bug->project;
        $this->view->preAndNext  = $this->loadModel('common')->getPreAndNextObject('bug', $bugID);
        $this->view->bugID       = $bugID;

        $this->display();
    }
    
    public function basicinfo($projectID = 0)
    {
    	 
    	$scrummaster = $this->loadModel('sprint')->getMaster($projectID);
    	$begin = $this->loadModel('sprint')->getBegin($projectID);
    	$end = $this->loadModel('sprint')->getEnd($projectID);
    	$desc = $this->loadModel('sprint')->getDesc($projectID);
    	 
    	 
    	$this->view->scrummaster = $scrummaster;
    	$this->view->begin = $begin;
    	$this->view->end = $end;
    	$this->view->desc = $desc;
    	 
    	$this->display();
    }
    
    public  function myburn($projectID = 0, $type = 'noweekend', $interval = 0)
    {
    	$products = $this->loadModel('product')->getPairs();
    	$productsAllbyheng = $this->loadModel('project')->getProducts($projectID);
    	foreach($productsAllbyheng as $productID => $productName)
    	{
    
    		$product_id = $productID;
    		$product_name = $productName;
    
    	}
    	$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
    	$plans = $this->loadModel('productplan')->getPairs($product_id);
    	$plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);
    	$this->view->title = $plans[$plan_id];
    	$this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$plan_id"), $plans[$plan_id]);
    
    	$projectStats  = $this->loadModel('productplan')->getProjectPairs($plan_id);
    	$this->view->position[] = html::select('proj', $projectStats, $projectID, "class='' onchange='byProj(this.value)'") ;
    
    	$this->loadModel('report');
    	// $project     = $this->commonAction(2);
    	$projectInfo = $this->loadModel("project")->getByID($projectID);
    
    	/* Get date list. */
    	list($dateList, $interval) = $this->loadModel("project")->getDateList($projectInfo->begin, $projectInfo->end, $type, $interval, 'Y-m-d');
    
    	// echo "$interval";
    
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
    
    	// Update automatically
    	$today = helper::today();
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
    
    
    	/* Assign. */
    	$this->view->tabID       = 'burn';
    	$this->view->charts      = $charts;
    	$this->view->projectID   = $projectID;
    	$this->view->sprintID    = $projectID;
    	$this->view->projectName = $projectInfo->name;
    	$this->view->type        = $type;
    	$this->view->interval    = $interval;
    	$this->view->chartData   = $chartData;
    	$this->view->dayList     = array('full' => $this->lang->project->interval . $space . 1 . $space . $this->lang->day) + $dayList;
    	$this->display();
    }

    public function createreview($projectID=0)
    {
    	if(!empty($_POST))
    	{
    		$this->sprint->createreview();
    		 
    		/*
    		$response['result']  = 'success';
    		$response['message'] = '';
    		$response['locate'] = $this->createLink('sprint', 'review', "projectID=$projectID");
    		$this->send($response);
    		*/
    		$location = $this->createLink('sprint', 'review', "projectID=$projectID");
    		die(js::locate($location, 'self'));
    		 
    		return;
    	}

    	$this->methodName='createreview';
    	$users = $this->loadModel('user')->getPairs('noletter');

        $products = $this->loadModel('product')->getPairs();
        $productsAllbyheng = $this->loadModel('project')->getProducts($projectID);
        foreach($productsAllbyheng as $productID => $productName)
        {
            $product_id = $productID;
            $product_name = $productName;
        }
        
        $reviewStatus = $this->LoadModel('sprint')->getReviewID($projectID);
        $this->view->reviewStatus = $reviewStatus;
        $sprintBegin = $this->loadModel('sprint')->getBegin($projectID);
        $this->view->sprintBegin = $sprintBegin;

        $sprintEnd = $this->loadModel('sprint')->getEnd($projectID);
        $this->view->sprintEnd = $sprintEnd;

        $sprintDesc = $this->sprint->getDesc($projectID);
        $this->view->sprintDesc = $sprintDesc;

        $this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
        $plans = $this->loadModel('productplan')->getPairs($product_id);
        $plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);
        $this->view->title = $plans[$plan_id];
        $this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$plan_id"), $plans[$plan_id]);

        $projectStats  = $this->loadModel('productplan')->getProjectPairs($plan_id);
        $this->view->position[] = $projectStats[$projectID];
        // $this->view->position[] = html::select('proj', $projectStats, $projectID, "class='' onchange='byProj(this.value)'") ;

        $this->view->projectID   = $projectID;
        $this->view->sprintID    = $projectID;
        $this->view->projectStats = $projectStats;

        $this->display();
    }
    
    public function reviewedit($projectID=0)
    {
    	
    	if(!empty($_POST))
    	{
    		$this->sprint->updateReview();
    		 
    		$location = $this->createLink('sprint', 'review', "projectID=$projectID");
    		die(js::locate($location, 'self'));
    		 
    		return;
    	}
    
    	$this->methodName='reviewedit';
    	 
    	$users = $this->loadModel('user')->getPairs('noletter');

    	$products = $this->loadModel('product')->getPairs();
    	$productsAllbyheng = $this->loadModel('project')->getProducts($projectID);
    	foreach($productsAllbyheng as $productID => $productName)
    	{
            $product_id = $productID;
            $product_name = $productName;
    	}

        $review = $this->loadModel('sprint')->getReview($projectID);
        $this->view->real_begin = $review->real_begin;
        $this->view->real_end = $review->real_end;
        $this->view->estimatePoints = $review->estimatePoints;
        $this->view->realPoints = $review->realPoints;
        $this->view->expl = $review->expl;
        $this->view->referenceStory = $review->referenceStory;
        $this->view->date = $review->date;
        $this->view->time = $review->time;
        $this->view->place = $review->place;
        $this->view->persons = $review->persons;
        $this->view->completeFunc = $review->completeFunc;
        $this->view->summary = $review->summary;
        $this->view->other = $review->other;

        $sprintBegin = $this->loadModel('sprint')->getBegin($projectID);
        $this->view->sprintBegin = $sprintBegin;
    	
        $sprintEnd = $this->loadModel('sprint')->getEnd($projectID);
        $this->view->sprintEnd = $sprintEnd;

        $sprintDesc = $this->sprint->getDesc($projectID);
        $this->view->sprintDesc = $sprintDesc;
    
    	$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$product_id"), $products[$product_id]);
    	$plans = $this->loadModel('productplan')->getPairs($product_id);
    	$plan_id = $this->loadModel('project')->getPlanByProjectID($projectID);
    	$this->view->title = $plans[$plan_id];
    	$this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$plan_id"), $plans[$plan_id]);
    
    	$projectStats  = $this->loadModel('productplan')->getProjectPairs($plan_id);
        $this->view->position[] = $projectStats[$projectID];
        // $this->view->position[] = html::select('proj', $projectStats, $projectID, "class='' onchange='byProj(this.value)'") ;
    
    	$this->view->projectStats = $projectStats;
    	$this->view->projectID   = $projectID;
    	$this->view->sprintID    = $projectID;
    
    	$this->display();
    }

    public function reviewdelete($sprintID=0,$confirm = 'no') {
    	if($confirm == 'no') {
    		die(js::confirm("确定删除这个回顾会吗", inlink('reviewdelete', "sprintID=$sprintID&confirm=yes"),inlink('review', "sprintID=$sprintID")));
    	} else { 
    		$this->sprint->deleteReview($sprintID);
    		die(js::locate($this->createLink('sprint', 'review', "projectID=$sprintID"), 'parent'));
    	}
    	$this->display();
    }
    public function storyedit($projectID, $storyID )
    {
	
        if(!empty($_POST))
        {
            $changes = $this->loadModel('story')->update($storyID);
            if(dao::isError()) die(js::error(dao::getError()));
            if($this->post->comment != '' or !empty($changes))
            {
                $action   = !empty($changes) ? 'Edited' : 'Commented';
                $actionID = $this->loadModel('action')->create('story', $storyID, $action, $this->post->comment);
                $this->loadModel('action')->logHistory($actionID, $changes);
                $this->sendmail($storyID, $actionID);
            }
          	die(js::locate($this->createLink('sprint', 'index', "projectID=$projectID"), 'parent'));
        }
		
        $products = $this->loadModel('product')->getPairs();
        $story    = $this->loadModel('story')->getById($storyID);
	$product  = $this->loadModel('product')->getById($story->product);
	$products = $this->loadModel('product')->getPairs();
	$moduleOptionMenu = $this->loadModel('tree')->getOptionMenu($product->id, $viewType = 'story');
	$planID =$story->plan;
	$plans = $this->loadModel('productplan')->getPlanByPlanID($planID);
	$productID=$story->product;
	$projectStats  = $this->loadModel('productplan')->getProjectPairs($story->plan);
		
        /* Assign. */		
        $story = $this->loadModel('story')->getById($storyID, 0, true);
	$this->view->title      = $this->lang->story->edit . "STORY" . $this->lang->colon . $this->view->story->title;
	$this->view->position[] = $this->lang->story->editBacklog;
	$this->view->position[] = $this->view->story->title;
	$this->view->position[] = html::a($this->createLink('product', 'productplan', "productID=$productID"),$products[$story->product]);
        $this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$story->plan"), $plans[$story->plan]);
        $this->view->position[] = html::a($this->createLink('sprint', 'index', "projectID=$story->project"), $projectStats[$story->project]);
        $this->view->planID     = $planID;
        $this->view->story      = $story;		
        $this->view->users      = $this->loadModel('user')->getPairs('nodeleted|pofirst', "$story->assignedTo,$story->openedBy,$story->closedBy");
	$this->view->productName= $products[$story->product];
	$this->view->projectName= $projectStats[$story->project];	
        $this->view->plans      = $plans;		
	$this->display();
    }

    public function team($projectID = 0)
    {

        $products     = $this->loadModel('product')->getPairs();
        $productID    = $this->sprint->getProductIDBySprintID($projectID);
        $planID       = $this->loadModel('project')->getPlanByProjectID($projectID);
        $plan         = $this->loadModel('productplan')->getByID($planID, true);
        $productplans = $this->loadModel('productplan')->getPairs($plan->product);
        $plans        = $this->loadModel('productplan')->getPlanByPlanID($planID);
        $projects     = $this->loadModel('productplan')->getProjectPairs($planID);

        $teamMembersUni = $this->sprint->getTMAccounts($projectID);
        $teamMembers    = $this->sprint->getTMembers($projectID);

        $this->view->position[]     = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $products[$plan->product]);
        $this->view->position[]     = html::a(helper::createLink("pro", "index", "planID=$planID"), $plans[$planID]);
        $this->view->position[]     = $projects[$projectID];
        // $this->view->position[]     = html::select('proj', $projects, $projectID, "class='' onchange='byProj(this.value)'");
        $this->view->title          = $plans[$planID];
        $this->view->projects       = $projects;
        $this->view->planID         = $planID;
        $this->view->teamMembers    = $teamMembers;
        $this->view->teamMembersUni = $teamMembersUni;
        $this->view->sprintID       = $projectID;
        $this->view->projectID      = $projectID;
        
        $this->display();
    }

    public function managemembers($projectID = 0)
    {

        $products     = $this->loadModel('product')->getPairs();
        $productID    = $this->sprint->getProductIDBySprintID($projectID);
        $planID       = $this->loadModel('project')->getPlanByProjectID($projectID);
        $plan         = $this->loadModel('productplan')->getByID($planID, true);
        $productplans = $this->loadModel('productplan')->getPairs($plan->product);
        $plans        = $this->loadModel('productplan')->getPlanByPlanID($planID);

        if(!empty($_POST))
        {
            $this->sprint->manageMembers($projectID);
            $this->locate($this->createLink('sprint', 'team', "projectID=$projectID"));
            exit;
        }
        
        $users = $this->loadModel('user')->getPairs('noclosed, nodeleted, devfirst');
        
        $users2 = $this->dao->select('t1.*,t2.*')->from(TABLE_TEAM)->alias('t1')
            ->leftJoin(TABLE_USER)->alias('t2')->on('t1.account = t2.account')
            ->where('t1.plan')->eq($planID)->andWhere('t1.isProject')->eq(0)->fetchAll();
        
        $pairs = array(''=>'');
        foreach($users2 as $user)
        {
        	$pairs[$user->account] = $user->realname;
        }
        $users2 = $pairs;

        foreach($currentMembers as $account => $member)
        {
            if(!isset($users[$member->account])) $member->account .= $this->lang->user->deleted;
        }
        $projects  = array(0 => "请选择Sprint") + $this->loadModel('productplan')->getProjectPairs($planID);
        $projs  = $this->loadModel('productplan')->getProjectPairs($planID);

        $currentMembers = $this->sprint->getTMembers($projectID);

        $this->view->title          = $plans[$planID];;
        $this->view->position[]     = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $products[$plan->product]);
        $this->view->position[]     = html::a(helper::createLink("pro", "index", "planID=$planID"), $plans[$planID]);
        $this->view->position[]     = $projs[$projectID];
        // $this->view->position[]     = html::select('proj', $projs, $projectID, "class='' onchange='byProj(this.value)'") ;
        $this->view->sprintID       = $projectID;
        $this->view->projects       = $projects;
        $this->view->currentMembers = $currentMembers;
        $this->view->users          = $users;
        $this->view->users2         = $users2;
        $this->view->planID         = $planID;
        $this->view->projs          = $projs;
        $this->view->projectID      = $projectID;
        
        $this->display();
        
    }
	/*
	 * Change a story.
	 *
	 * @param  int    $storyID
	 * @access public
	 * @return void
	 */
	public function changestory($projectID,$storyID)
	{
	
		  
		if(!empty($_POST))
		{
				
			$changes = $this->loadModel('story')->change($storyID);
			if(dao::isError()) die(js::error(dao::getError()));
			$version = $this->dao->findById($storyID)->from(TABLE_STORY)->fetch('version');
			$files = $this->loadModel('file')->saveUpload('story', $storyID, $version);
			if($this->post->comment != '' or !empty($changes) or !empty($files))
			{
				$action = (!empty($changes) or !empty($files)) ? 'Changed' : 'Commented';
				$fileAction = '';
				if(!empty($files)) $fileAction = $this->lang->addFiles . join(',', $files) . "\n" ;
				$actionID = $this->loadModel('action')->create('story', $storyID, $action, $fileAction . $this->post->comment);
				$this->loadModel('action')->logHistory($actionID, $changes);
				$this->sendmail($storyID, $actionID);
			}
			//echo empty($_POST);
			die(js::locate($this->createLink('sprint', 'index', "projectID=$projectID"), 'parent'));
		}
		/* Get datas. */
		$story    = $this->loadModel('story')->getById($storyID);			
		$product  = $this->loadModel('product')->getById($story->product);
		$products = $this->loadModel('product')->getPairs();
		$moduleOptionMenu = $this->loadModel('tree')->getOptionMenu($product->id, $viewType = 'story');		
		/* Set menu. */
		$this->loadModel('product')->setMenu($products, $product->id);		
		/* Assign. */
		$this->view->position[]       = html::a($this->createLink('product', 'productplan', "product=$product->id"), $product->name);
		$this->loadModel('story')->getAffectedScope($this->view->story);
		//$plan = $this->loadModel('productplan')->getByID($planID, true);
		$this->app->loadLang('task');
		$this->app->loadLang('bug');
		$this->app->loadLang('testcase');
		$this->app->loadLang('project');			
		$this->app->loadLang('story');
		$plans=array();
		$planID   =$story->plan;
		$projectID=$story->project;
		$plans=$this->loadModel('productplan')->getPlanByPlanID($story->plan);					
		/* Assign. */
		$this->view->title      = $this->lang->story->change . "STORY" . $this->lang->colon . $story->title;
		$this->view->users      = $this->loadModel('user')->getPairs('nodeleted|pofirst', $this->view->story->assignedTo);	
		//$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $plan->name);
		$this->view->position[] = html::a(helper::createLink("pro", "index", "planID=$story->plan"), current($plans));
		$this->view->projects   = $this->loadModel('project')->getPairsByProjectID($projectID);
		$projectStats           = $this->loadModel('productplan')->getProjectPairs($planID);
		$this->view->position[] = html::a($this->createLink('sprint', 'index', "projectID=$projectID"), $projectStats[$projectID]);
		$this->view->position[] = $this->lang->story->change;
		$this->view->position[] = $story->title;						
		$this->view->needReview = $this->config->story->needReview == 0 ? "checked='checked'" : "";
		$this->view->story	    = $story;
		$this->view->planID		= $planID;
		$this->view->projectID	= $projectID;
		$this->display();
	}
    public function storyreview($storyID,$projectID)
    {
	$this->loadModel('story');
	$this->loadModel('action');
	$this->loadModel('product');
	$story   = $this->story->getById($storyID);
        if(!empty($_POST))
        {
            $this->story->review($storyID);
            if(dao::isError()) die(js::error(dao::getError()));
            $result = $this->post->result;
            if($this->post->closedReason != '' and strpos('done,postponed,subdivided', $this->post->closedReason) !== false) $result = 'pass';
            $actionID = $this->action->create('story', $storyID, 'Reviewed', $this->post->comment, ucfirst($result));
            $this->action->logHistory($actionID, array());
            $this->sendmail($storyID, $actionID);
            if($this->post->result == 'reject')
            {
                $this->action->create('story', $storyID, 'Closed', '', ucfirst($this->post->closedReason));
            }
            //die(js::locate(inlink('view', "storyID=$storyID"), 'parent'));
			
            //changed
            die(js::locate(helper::createLink('sprint', 'index', "projectID=$story->project"), 'parent'));
        }

        /* Get story and product. */
        // $story   = $this->story->getById($storyID);
        $product = $this->dao->findById($story->product)->from(TABLE_PRODUCT)->fields('name, id')->fetch();
		
        /* Set menu. */
        $this->product->setMenu($this->product->getPairs(), $product->id);
        /* Set the review result options. */
        if($story->status == 'draft' and $story->version == 1) unset($this->lang->story->reviewResultList['revert']);
        if($story->status == 'changed') unset($this->lang->story->reviewResultList['reject']);
		
        $plans = $this->loadModel('productplan')->getPlanByPlanID($story->plan);
		$projectStats  = $this->loadModel('productplan')->getProjectPairs($story->plan);
        $this->view->title      = $this->lang->story->review . "STORY" . $this->lang->colon . $story->title;
        $this->view->position[] = html::a($this->createLink('product', 'productplan', "product=$product->id"), $product->name);
        $this->view->position[] = html::a($this->createLink('pro', 'backlog', "planID=$story->plan"), $plans[$story->plan]);
        $this->view->position[] = html::a($this->createLink('sprint', 'index', "projectID=$story->project"), $projectStats[$story->project]);
        $this->view->position[] = $story->title;
        // $this->view->position[] = $this->lang->story->common;
        // $this->view->position[] = $this->lang->story->review;
        $this->view->product = $product;
        $this->view->story   = $story;
        $this->view->actions = $this->loadModel('action')->getList('story', $storyID);
        $this->view->users   = $this->loadModel('user')->getPairs('nodeleted', "$story->lastEditedBy,$story->openedBy");
		
        // added
        $this->view->planID  = $story->plan;

        /* Get the affcected things. */
        $this->story->getAffectedScope($this->view->story);
        $this->app->loadLang('task');
        $this->app->loadLang('bug');
        $this->app->loadLang('testcase');
        $this->app->loadLang('project');

        $this->display();
    }

    
}
