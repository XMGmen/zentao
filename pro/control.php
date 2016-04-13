<?php
class pro extends control
{
		
	public $products = array();
	public function __construct(){
		parent::__construct();
		$this->loadModel('story');
		$this->loadModel('project');
		$this->loadModel ( 'user' );
		$this->loadModel('bug');
		$this->products = $this->loadModel('product')->getPairs('nocode');
		$this->moduleName ='pro';
	}
				
	public function index($planID = 0)
	{
					
		/*获取某个plan下的所有sprintID*/
		$sprintIDs = array();
		$sprintIDs = $this->loadModel('productplan')->getSprintsIDs($planID);
		$projectIDs = array();
		$i = 0;
		foreach($sprintIDs as $sprintID){
			$projectIDs[$i++] = $sprintID->project;
		}
		// addedbyheng
		$plan = $this->loadModel('productplan')->getByID($planID, true);
		$products = $this->loadModel('product')->getPairs();
		$productplans = $this->loadModel('productplan')->getPairs($plan->product);

		$this->view->title = $this->lang->sprint->sprintname;
		$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $products[$plan->product]);
		$this->view->position[] = $productplans[$planID];
		// $this->view->position[] = html::select('pro', $productplans, $planID, "onchange='byPros(this.value)'");
		$this->view->sprintStats  = $this->loadModel('project')->getSprintStats($projectIDs);
		$this->view->planID = $planID;
		$this->view->sprintIDs = $sprintIDs;
		$this->view->productplans = $productplans;
		$this->display();
	}
		
	public function bug($planID = 0, $orderBy = 'status,id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
	{
		// addedbyheng
		$plan = $this->loadModel('productplan')->getByID($planID, true);
		$products = $this->loadModel('product')->getPairs();
		$productplans = $this->loadModel('productplan')->getPairs($plan->product);
		$this->view->title = $this->lang->sprint->bugname;
		$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $products[$plan->product]);
		$this->view->position[] = $productplans[$planID];
		// $this->view->position[] = html::select('pro', $productplans, $planID, "class='' onchange='byPro(this.value)'");
		//
		/* Load these two models. */
		//if(!$orderBy) $orderBy = $this->cookie->productStoryOrder ? $this->cookie->productStoryOrder : 'id_desc';
		//setcookie('productStoryOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
			
		$sort = $this->loadModel('common')->appendOrder($orderBy);
		$this->app->loadClass('pager', $static = true);
		$pager = new pager($recTotal, $recPerPage, $pageID);
			
		//$bugs = $this->dao->select('*')->from(TABLE_BUG)->where('plan')->eq($planID)->fi()->orderBy($orderBy)->page($pager)->fetchAll();
		$bugs = $this->dao->select('*')->from(TABLE_BUG)->where('plan')->eq($planID)->andWhere('deleted')->eq(0)->fi()->orderBy($orderBy)->page($pager)->fetchAll();
		$users = $this->loadModel('user')->getPairs('noletter');
		$this->view->users   = $users;	
		$this->view->orderBy = $orderBy;
		$this->view->planID = $planID;
		$this->view->productID = $plan->product;
		$this->view->pager = $pager;
		$this->view->bugs = $bugs;
		
		$this->view->productplans = $productplans;
		$this->view->groupID =$this->loadModel('user')->getGroupID($this->app->user->account);
		$this->view->importButton = $this->lang->pro->importbugs;
		$this->view->downloadExcel = $this->lang->pro->downloadExcel;
		$file    = $this->dao->select('*')->from(TABLE_FILE)->where('objectType')->eq('excelTemplate')->fetch();
		$webPath = $this->app->getWebRoot() . "data/download/" . $file->pathname;
		$this->view->downloadLink  = "http://".$_SERVER['HTTP_HOST'].$webPath;
		$sprintPairsArray = Array();
		foreach ($bugs as $bug) {
			$sprintPairs = $this->loadModel(project)->getPairsByProjectID($bug->project);
			$sprintPairsArray += Array($bug->id => $sprintPairs);
		}
		$this->view->sprintPairsArray = $sprintPairsArray;
		$this->display();
	}
		

		
	public function backlog( $planID = 0,$orderBy = '', $recTotal = 0, $recPerPage = 10, $pageID = 1)
	{
			
			
		// addedbyheng
		$plan = $this->loadModel('productplan')->getByID($planID, true);
		$products = $this->loadModel('product')->getPairs();
		$productplans = $this->loadModel('productplan')->getPairs($plan->product);
		$this->view->title = $this->lang->sprint->backlogname;
		$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $products[$plan->product]);
		$this->view->position[] = $productplans[$planID];
		// $this->view->position[] = html::select('pro', $productplans, $planID, "class='' onchange='byPro(this.value)'");
			
		if(!$orderBy) $orderBy = $this->cookie->productStoryOrder ? $this->cookie->productStoryOrder : 'id_desc';
		setcookie('productStoryOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
			
		$sort = $this->loadModel('common')->appendOrder($orderBy);
			
		$this->app->loadClass('pager', $static = true);
		$pager = new pager($recTotal, $recPerPage, $pageID);
			
		$stories =  $this->story->getProductPlanStories($planID,$sort, $pager);
		$this->view->orderBy = $orderBy;
		$this->view->planID = $planID;
		$this->view->productID = $productID;
		$this->view->pager = $pager;
		$this->view->stories = $stories;
		$this->view->productplans = $productplans;
		$this->display();
	}

	public function createbacklog($productID = 0, $moduleID = 0, $storyID = 0, $projectID = 0, $bugID = 0)
	{
		$this->display();
	}
		
		
		
	/**
	 * View a story.
	 *
	 * @param  int    $storyID
	 * @param  int    $version
	 * @access public
	 * @return void
	 */
	public function backlogview($planID,$storyID=0,$version = 0, $from = 'product', $param = 0)
	{
		//导航栏
		$plan = $this->loadModel('productplan')->getByID($planID, true);
		$products = $this->loadModel('product')->getPairs();
		$productplans = $this->loadModel('productplan')->getPairs($plan->product);
		$this->view->title = $this->lang->sprint->backlogname;
		$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $products[$plan->product]);
		//$this->view->position[] = html::select('pro', $productplans, $planID, "class='' onchange='byPro(this.value)'") ;
		$plans=array();
		$plans=$this->loadModel('productplan')->getPlanByPlanID($planID);
		$this->view->position[] = html::a(helper::createLink("pro", "backlog", "planID=$planID"), current($plans));
			
			
		$storyID = (int)$storyID;
		$story   = $this->story->getById($storyID, $version, true);
		if(!$story) die(js::error($this->lang->notFound) . js::locate('back'));
			
		$story->files = $this->loadModel('file')->getByObject('story', $storyID);
			
			
			
		$product      = $this->dao->findById($story->product)->from(TABLE_PRODUCT)->fields('name, id')->fetch();
		$plan         = $this->dao->findById($story->plan)->from(TABLE_PRODUCTPLAN)->fetch('title');
		$bugs         = $this->dao->select('id,title')->from(TABLE_BUG)->where('story')->eq($storyID)->andWhere('deleted')->eq(0)->fetchAll();
		$fromBug      = $this->dao->select('id,title')->from(TABLE_BUG)->where('toStory')->eq($storyID)->fetch();
		$cases        = $this->dao->select('id,title')->from(TABLE_CASE)->where('story')->eq($storyID)->andWhere('deleted')->eq(0)->fetchAll();
		//$modulePath   = $this->tree->getParents($story->module);
		$users        = $this->user->getPairs('noletter');
		$this->product->setMenu($this->product->getPairs(), $product->id);
		if($from == 'project')
		{
			$project = $this->loadModel('project')->getById($param);
			if($project->status == 'done') $from = '';
		}
		//$this->view->actions    = $this->action->getList('story', $storyID);
		//added by fxq
		$stories=array(''=>'请选择')+$this->loadModel('story')->getStoriesbyBackLogID($storyID);
		$this->view->stories=$stories;
		$this->view->version    = $version == 0 ? $story->version : $version;
		$this->view->preAndNext = $this->loadModel('common')->getPreAndNextObject('story', $storyID);
		$this->view->from       = $from;
		$this->view->param      = $param;
		$this->view->planID = $planID;
			
		$this->view->product    = $product;
		$this->view->story      = $story;
		$this->view->plan       = $plan;
		$this->view->bugs       = $bugs;
		$this->view->fromBug    = $fromBug;
		$this->view->cases      = $cases;
		//$this->view->modulePath = $modulePath;
		$this->view->users      = $users;
		$this->view->projects   = $this->loadModel('project')->getPairs('nocode');
			
		$this->display();
	}
		
	/**
	 * View a bug.
	 *
	 * @param  int    $bugID
	 * @access public
	 * @return void
	 */
	public function bugview($planID,$bugID=0)
	{
		//导航栏
		$plan = $this->loadModel('productplan')->getByID($planID, true);
		$products = $this->loadModel('product')->getPairs();
		$productplans = $this->loadModel('productplan')->getPairs($plan->product);
		$this->view->title = $this->lang->sprint->backlogname;
		$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $products[$plan->product]);
		//$this->view->position[] = html::select('pro', $productplans, $planID, "class='' onchange='byPro(this.value)'") ;
		$plans=array();
		$plans=$this->loadModel('productplan')->getPlanByPlanID($planID);
		$this->view->position[] = html::a(helper::createLink("pro", "backlog", "planID=$planID"), current($plans));
			
			
		//Judge bug exits or not.
		$bug = $this->bug->getById($bugID, true);
		if(!$bug) die(js::error($this->lang->notFound) . js::locate('back'));
			
		if($bug->project and !$this->loadModel('project')->checkPriv($this->project->getByID($bug->project)))
		{
			echo(js::alert($this->lang->project->accessDenied));
			die(js::locate('back'));
		}
			
		// Update action. 
		//if($bug->assignedTo == $this->app->user->account) 
		$this->loadModel('action')->read('bug', $bugID);
			
		//Set menu. 
		$this->bug->setMenu($this->products, $bug->product);
			
		//Get product info.
		$productID   = $bug->product;
		$productName = $this->products[$productID];
			
		$this->view->planID = $planID;
		//$this->view->modulePath  = $this->tree->getParents($bug->module);
		$this->view->bug  = $bug;
		$this->view->productID   = $productID;
		$this->view->productName = $productName;
			
		$this->view->users       = $this->user->getPairs('noletter');
		$this->view->actions     = $this->action->getList('bug', $bugID);
		$this->view->builds      = $this->loadModel('build')->getProductBuildPairs($productID);
		$this->view->preAndNext  = $this->loadModel('common')->getPreAndNextObject('bug', $bugID);
		$this->view->projectID   = $bug->project;
			
		$this->display();
	}
		
	public function team($planID = 0)
	{
		$plan = $this->loadModel('productplan')->getByID($planID, true);
		$products = $this->loadModel('product')->getPairs();
		$productplans = $this->loadModel('productplan')->getPairs($plan->product);
		$this->view->title = $this->lang->pro->teamMembers;
		$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $products[$plan->product]);
		$this->view->position[] = $productplans[$planID];
		// $this->view->position[] = html::select('pro', $productplans, $planID, "class='' onchange='byPro(this.value)'") ;
		$plans=array();
		$plans=$this->loadModel('productplan')->getPlanByPlanID($planID);
		// $this->view->position[] = html::a(helper::createLink("pro", "backlog", "planID=$planID"), current($plans));
		$projects  = $this->loadModel('productplan')->getProjectPairs($planID);

		$teamMembersUni = $this->pro->getTMAccounts($planID);
		$teamMembers    = $this->pro->getTMembers($planID);

		/* The deleted members. */

		$this->view->projects       = $projects;
		$this->view->planID         = $planID;
		$this->view->teamMembers    = $teamMembers;
		$this->view->teamMembersUni = $teamMembersUni;
		$this->view->productplans = $productplans;
		
		$this->display ();
	}
		
		
	public function manageMembers($planID=0, $team2Import = 0)
	{
				
		$plan = $this->loadModel('productplan')->getByID($planID, true);
		$products = $this->loadModel('product')->getPairs();
		$productplans = $this->loadModel('productplan')->getPairs($plan->product);
		$this->view->title = $this->lang->pro->teamManage;
		$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $products[$plan->product]);
		$this->view->position[] = $productplans[$planID];
		// $this->view->position[] = html::select('pro', $productplans, $planID, "class='' onchange='byPro(this.value)'");
		$plans = array();
		$plans = $this->loadModel('productplan')->getPlanByPlanID($planID);
		// $this->view->position[] = html::a(helper::createLink("pro", "backlog", "planID=$planID"), current($plans));
		
		if(!empty($_POST))
		{
			$this->pro->manageMembers($planID);
			$this->locate($this->createLink('pro', 'team', "planID=$planID"));
			exit;
		
		}
		
		$users          = $this->user->getPairs('noclosed, nodeleted, devfirst');
		//$roles          = $this->user->getUserRoles(array_keys($users));
		/* The deleted members. */
		foreach($currentMembers as $account => $member)
		{
			if(!isset($users[$member->account])) $member->account .= $this->lang->user->deleted;
		}
		$projects  = array(0 => "请选择Sprint") + $this->loadModel('productplan')->getProjectPairs($planID);

		// $currentMembers = $this->pro->getTeamMembers($planID);
		$currentMembers = $this->pro->getTMembers($planID);

		$this->view->projects       = $projects;
		$this->view->currentMembers = $currentMembers;
		$this->view->users          = $users;
		$this->view->planID         = $planID;
		$this->view->productplans   = $productplans;
		//$this->view->roles          = $roles;
		$this->display();
		
	}
		
		
	public function unlinkMember($planID, $account, $confirm = 'no')
	{
		if($confirm == 'no')
		{
			die(js::confirm($this->lang->project->confirmUnlinkMember, $this->inlink('unlinkMember', "planID=$planID&account=$account&confirm=yes")));
		}
		else
		{
			$this->pro->unlinkMember($planID, $account);
		
			/* if ajax request, send result. */
			if($this->server->ajax)
			{
				if(dao::isError())
				{
					$response['result']  = 'fail';
					$response['message'] = dao::getError();
				}
				else
				{
					$response['result']  = 'success';
					$response['message'] = '';
				}
				$this->send($response);
			}
			die(js::locate($this->inlink('team', "planID=$planID"), 'parent'));
		}
	}
	public function unlinkMember2($projectID, $account,$confirm = 'no')
	{
		if($confirm == 'no')
		{
			die(js::confirm($this->lang->project->confirmUnlinkMember, $this->inlink('unlinkMember2', "projectID=$projectID&account=$account&confirm=yes")));
		}
		else
		{
			$this->pro->unlinkMember2($projectID, $account);
			
			/* if ajax request, send result. */
			if($this->server->ajax)
			{
				if(dao::isError())
				{
					$response['result']  = 'fail';
					$response['message'] = dao::getError();
				}
				else
				{
					$response['result']  = 'success';
					$response['message'] = '';
				}
				$this->send($response);
			}
			die(js::locate($this->inlink('team', "projectID=$planID"), 'parent'));
		}
	}
	/**addedbygy*/
	/*
	 * Change a story.
	 *
	 * @param  int    $storyID
	 * @access public
	 * @return void
	 */
	public function backlogchange($storyID,$planID)
	{
	//echo empty($_POST);
		  
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
			die(js::locate($this->createLink('pro', 'backlog', "planID=$planID"), 'parent'));
		}
			
		
		$this->commonAction($storyID);
			
		$this->loadModel('story')->getAffectedScope($this->view->story);
		//$plan = $this->loadModel('productplan')->getByID($planID, true);
		$this->app->loadLang('task');
		$this->app->loadLang('bug');
		$this->app->loadLang('testcase');
		$this->app->loadLang('project');			
		$this->app->loadLang('story');
		$plans=array();
		$plans=$this->loadModel('productplan')->getPlanByPlanID($planID);
			
			
		/* Assign. */
		$this->view->title      = $this->lang->story->change . "STORY" . $this->lang->colon . $this->view->story->title;
		$this->view->users      = $this->user->getPairs('nodeleted|pofirst', $this->view->story->assignedTo);
	    //$this->view->position[] = html::a(helper::createLink("product", "productplan", "productID=$plan->product"), $plan->name);
		$this->view->position[] = html::a(helper::createLink("pro", "backlog", "planID=$planID"), current($plans));
		$this->view->position[] = $this->lang->story->changeBacklog;
		$this->view->position[] = $this->view->story->title;
			
			
		$this->view->needReview = $this->config->story->needReview == 0 ? "checked='checked'" : "";
		$this->view->planID=$planID;
		$this->display();
	}
		
		/**
     * Send email.
     * 
     * @param  int    $storyID 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function sendmail($storyID, $actionID)
    {
        /* Reset $this->output. */
        $this->clear();
		
		$this->loadModel('story');
		$this->loadModel('product');
		$this->loadModel('action');
		
		
        $story       = $this->story->getById($storyID);
        $productName = $this->product->getById($story->product)->name;

        /* Get actions. */
        $action          = $this->action->getById($actionID);
        $history         = $this->action->getHistory($actionID);
        $action->history = isset($history[$actionID]) ? $history[$actionID] : array();
        if(strtolower($action->action) == 'opened') $action->comment = $story->spec;

        /* Set toList and ccList. */
        $toList      = $story->assignedTo;
        $ccList      = str_replace(' ', '', trim($story->mailto, ','));

        /* If the action is changed or reviewed, mail to the project team. */
        if(strtolower($action->action) == 'changed' or strtolower($action->action) == 'reviewed')
        {
            $prjMembers = $this->story->getProjectMembers($storyID);
            if($prjMembers)
            {
                $ccList .= ',' . join(',', $prjMembers);
                $ccList = ltrim($ccList, ',');
            }
        }

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
                $toList   = substr($ccList, 0, $commaPos);
                $ccList   = substr($ccList, $commaPos + 1);
            }
        }
        elseif($toList == 'closed')
        {
            $toList = $story->openedBy;
        }

        /* Get the mail content. */
        if($action->action == 'opened') $action->comment = '';
        $this->view->story  = $story;
        $this->view->action = $action;
        $this->view->users  = $this->user->getPairs('noletter');

        /* $mailContent = $this->parse($this->moduleName, 'sendmail'); */
		$mailContent = $this->parse('story', 'sendmail'); // ????

        /* Send it. */
        $this->loadModel('mail')->send($toList, $productName . ':' . 'STORY #' . $story->id . $this->lang->colon . $story->title, $mailContent, $ccList);
        if($this->mail->isError()) trigger_error(join("\n", $this->mail->getError()));
    }
		
		
		/**addedbygy*/
		/*
		 * The common action when edit or change a story.
		 *
		 * @param  int    $storyID
		 * @access public
		 * @return void
		 */
		public function commonAction($storyID)
		{
			
			/* Get datas. */
			$story    = $this->loadModel('story')->getById($storyID);
			$product  = $this->loadModel('product')->getById($story->product);
			$products = $this->loadModel('product')->getPairs();
			$moduleOptionMenu = $this->loadModel('tree')->getOptionMenu($product->id, $viewType = 'story');
		
			/* Set menu. */
			$this->loadModel('product')->setMenu($products, $product->id);
		
			/* Assign. */
			$this->view->position[]       = html::a($this->createLink('product', 'productplan', "product=$product->id"), $product->name);
			//$this->view->position[]       = $this->lang->story->common;
			$this->view->product          = $product;
			$this->view->products         = $products;
			$this->view->story            = $story;
			$this->view->moduleOptionMenu = $moduleOptionMenu;
			$this->view->plans            = $this->loadModel('productplan')->getPairs($product->id);
			$this->view->actions          = $this->loadModel('action')->getList('story', $storyID);
		
		}
		 /**ADDED bygy**/
		 /**
     * Edit a story.
     * 
     * @param  int    $storyID 
     * @access public
     * @return void
     */
    public function backlogedit($storyID, $planID)
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
          	die(js::locate($this->createLink('pro', 'backlog', "planID=$planID"), 'parent'));
        }
        $products = $this->loadModel('product')->getPairs();
        $this->commonAction($storyID);
	$plans = $this->loadModel('productplan')->getPlanByPlanID($planID);
	$productID=$story->product;
        /* Assign. */
        $story = $this->loadModel('story')->getById($storyID, 0, true);
	$this->view->title      = $this->lang->story->edit . "STORY" . $this->lang->colon . $this->view->story->title;
	$this->view->position[] = html::a(helper::createLink("pro", "backlog", "planID=$planID"), current($plans));
	$this->view->position[] = $this->lang->story->editBacklog;
	$this->view->position[] = $this->view->story->title;
        $this->view->planID     = $planID;
        $this->view->story      = $story;
        $this->view->users      = $this->user->getPairs('nodeleted|pofirst', "$story->assignedTo,$story->openedBy,$story->closedBy");
        $this->view->productName= $products[$story->product];
        $this->view->plans      = $plans;
	$this->display();
    }
    /**addedbygy
     * Edit a bug.
     * 
     * @param  int    $bugID 
     * @access public
     * @return void
     */
    public function bugedit($bugID, $planID,$comment = false)
    {
        //echo "ok";
        $this->methodName = 'bugedit';
        $projectIDplus    = $this->dao->select('project')->from(TABLE_BUG)->where('id')->eq($bugID)->fetch('project'); 
        if(!empty($_POST))
        {
            $changes = array();
            $files   = array();
            $oldAss  = $this->dao->select('assignedTo')->from(TABLE_BUG)->where('id')->eq($bugID)->fetch('assignedTo');
            if($comment == false) {
                $changes  = $this->loadModel(bug)->update($bugID);
                if(dao::isError()) die(js::error(dao::getError()));
                $files = $this->loadModel('file')->saveUpload('bug', $bugID);
            }
            if($this->post->comment != '' or !empty($changes) or !empty($files))
            {
                $action = !empty($changes) ? 'Edited' : 'Commented';
                $fileAction = '';
                if(!empty($files)) $fileAction = $this->lang->addFiles . join(',', $files) . "\n" ;
                $actionID = $this->loadModel(action)->create('bug', $bugID, $action, $fileAction . $this->post->comment);
                $this->loadModel(action)->logHistory($actionID, $changes);
                $this->sendmail($bugID, $actionID);
            }
            
            $bug = $this->loadModel(bug)->getById($bugID);
 
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
            $this->loadModel('myFastMsg')->sendBugMsg($bugID,0,$oldAss);
            die(js::locate($this->createLink('pro','bug',"planID=$planID"), 'parent'));
        }
        	
        /* Get the info of bug, current product and modue. */
        $bug             = $this->bug->getById($bugID);
        $productID       = $bug->product;
        $projectID       = $bug->project;
        $currentModuleID = $bug->module;
        $plans           = array();
        $plans           = $this->loadModel('productplan')->getPlanByPlanID($planID);
        /* Set the menu. */
        $this->bug->setMenu($this->products, $productID);
 
        /* Set header and position. */
        $this->view->title      = $this->lang->bug->edit . "BUG #$bug->id $bug->title - " . $this->products[$productID];
        $this->view->position[] = html::a($this->createLink('product', 'productplan', "productID=$productID"), $this->products[$productID]);
        $this->view->position[] = html::a(helper::createLink("pro", "bug", "planID=$planID"), current($plans));
        $this->view->position[] = $this->lang->bug->editbug;
        $this->view->position[] = $bug->title;
        
        //$this->view->position[] = $this->lang->bug->edit;
 
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
        $this->view->productName      = $this->products[$productID];
        $this->view->planID           = $planID;
        $this->view->plans            = $plans;
        $this->view->moduleOptionMenu = $this->loadModel(tree)->getOptionMenu($productID, $viewType = 'bug', $startModuleID = 0);
        $this->view->currentModuleID  = $currentModuleID;
        //$this->view->projects         = $this->loadModel(product)->getProjectPairs($bug->product);
        $id=$this->dao->select('project')->from(TABLE_BUG)->where('id')->eq($bugID)->fetch('project');
        $this->view->projects=$this->loadModel('project')->getPairsByProjectID($id);
        $this->view->stories          = $bug->project ? $this->loadModel(story)->getProjectStoryPairs($bug->project) : $this->loadModel(story)->getProductStoryPairs($bug->product);
        $this->view->tasks            = $this->loadModel(task)->getProjectTaskPairs($bug->project);
        $account   = $this->loadModel('pro')->getAccount($bug->plan);
        $projectID = $this->loadModel('sprint')->getSprintByBugID($bugID);
        //$users     = $this->user->getPairsUsers('nodeleted', $account, $bugID, $projectID, $planID);
        $planID    = $this->dao->select('plan')->from(TABLE_BUG)->where('id')->eq($bugID)->fetch('plan');
        if ( $projectIDplus == 0 ) {
            $users = $this->user->getUsersByPlanID($planID);
        } else {
            $users = $this->user->getUsersByProjectID($projectIDplus);
        }
        $this->view->users   = $users;
        // $this->view->users   = $this->user->getPairs2('nodeleted', $bug->assignedTo,$account);
        //$this->view->users            = $this->loadModel(user)->getPairs('nodeleted', "$bug->assignedTo,$bug->resolvedBy,$bug->closedBy,$bug->openedBy");
        $this->view->resolvedBuilds   = array('' => '') + $this->view->openedBuilds;
        $this->view->actions          = $this->loadModel(action)->getList('bug', $bugID);
        $this->view->templates        = $this->loadModel(bug)->getUserBugTemplates($this->app->user->account);
        $this->view->editSprints      = $this->loadModel(productplan)->getProjectPairs2($planID);
        $this->view->belongToSprint   = $bug->project==0? 0:1;
        $this->display();
    }

    /**
     * Create a sprint.
     * 
     * @access public
     * @return void
     */
    public function sprintcreate($planID = 0, $projectID = '', $copyProjectID = '')
    {

    	$this->loadModel('project');

        if($projectID)
        {
            $this->view->title     = $this->lang->project->tips;
            $this->view->tips      = $this->fetch('project', 'tips', "projectID=$projectID");
            $this->view->projectID = $projectID;
            $this->display();
            exit;
        }

        $name      = '';
        $code      = '';
        $team      = '';
        $products  = '';
        $whitelist = '';
        $acl       = 'open';

        if($copyProjectID)
        {
            $copyProject = $this->dao->select('*')->from(TABLE_PROJECT)->where('id')->eq($copyProjectID)->fetch();
            $name        = $copyProject->name;
            $code        = $copyProject->code;
            $team        = $copyProject->team;
            $acl         = $copyProject->acl;
            $whitelist   = $copyProject->whitelist;
            $products    = join(',', array_keys($this->project->getProducts($copyProjectID))); 
        }

        if(!empty($_POST))
        {
            $projectID = $copyProjectID == '' ? $this->project->create() : $this->project->create($copyProjectID);
            //$this->project->updateProducts($projectID);
            if(dao::isError()) die(js::error(dao::getError()));

            $this->loadModel('action')->create('project', $projectID, 'opened');
            die(js::locate($this->createLink('pro', 'index', "planID=$planID"), 'parent'));
        }

        $this->project->setMenu($this->projects, key($this->projects));

        $products = $this->loadModel('product')->getPairs();
        
        $plan = $this->loadModel('productplan')->getByID($planID, true);
        $currProduct = $this->loadModel('product')->getProdcutById($plan->product);
        $plans = $this->loadModel('productplan')->getPlanByPlanID($planID);

        $this->view->title         = $this->lang->sprint->create;
        $this->view->position[]    = html::a(helper::createLink('product', 'productplan', "productID=$plan->product"), $products[$plan->product]);
        $this->view->position[]    = html::a(helper::createLink('pro', 'index', "planID=$planID"), $plans[$planID]);
        $this->view->position[]    = $this->view->title;
        // $this->view->projects      = array('' => '') + $this->projects;
        $this->view->groups        = $this->loadModel('group')->getPairs();
        // $this->view->allProducts   = $this->loadModel('product')->getPairs('noclosed|nocode');
        $allProducts   = $this->loadModel('product')->getPairs('noclosed|nocode');
        $this->view->allProducts   = $allProducts;
        $this->view->allPlans      = $this->loadModel('productplan')->getForProducts($allProducts);
        $this->view->name          = $name;
        $this->view->code          = $code;
        $this->view->team          = $team;
        $this->view->products      = $products ;
        $this->view->whitelist     = $whitelist;
        $this->view->acl           = $acl      ;
        $this->view->copyProjectID = $copyProjectID;
        $this->view->productID     = $plan->product;
        $this->view->plans         = $plans;
        $this->view->currProduct   = $currProduct;
        $this->view->planID        = $planID;
        $this->view->poUsers       = $this->loadModel('user')->getPairs('noclosed,nodeleted,pofirst', $project->PO);
       	//$this->view->pmUsers       = $this->user->getPairs('noclosed,nodeleted,pmfirst',  $project->PM);
        //added by zzj
       	$users2 = $this->dao->select('t1.*,t2.*')->from(TABLE_TEAM)->alias('t1')
                      ->leftJoin(TABLE_USER)->alias('t2')->on('t1.account = t2.account')
                      ->where('t1.plan')->eq($planID)
                      ->andWhere('t1.isProject')->eq(0)->fetchAll();
        
        $pairs = array(''=>'');
        foreach($users2 as $user)
        {
        	$pairs[$user->account] = $user->realname;
        }
        $users2 = $pairs;
        $this->view->pmUsers = $users2;
       	
       	$this->view->qdUsers       = $this->user->getPairs('noclosed,nodeleted,qdfirst',  $project->QD);
       	$this->view->rdUsers       = $this->user->getPairs('noclosed,nodeleted,devfirst', $project->RD);

        $this->display();
    }
	
	public function sprintedit($projectID)
	{
	$this->loadModel('project');
	$this->loadModel('action');
	$this->loadModel('product');
	$this->loadModel('user');
	if(!empty($_POST))
       {
        $changes = $this->project->update($projectID);
        $this->project->updateProducts($projectID);
        if(dao::isError()) die(js::error(dao::getError()));
        if($changes)
        {
            $actionID = $this->loadModel('action')->create('project', $projectID, 'edited');
            $this->action->logHistory($actionID, $changes);
        }
        if(isonlybody())die(js::closeModal('parent.parent'));

        die(js::locate(inlink('view', "projectID=$projectID"), 'parent'));
       }

        /* Judge a private todo or not, If private, die. */
       /* Set menu. */
	    
       $this->project->setMenu($this->projects, $projectID);
       //$projects = array('' => '') + $this->projects;
       $project  = $this->project->getById($projectID);
       $managers = $this->project->getDefaultManagers($projectID);
	  
       if($project->private and $this->app->user->account != $project->account) die('private');
       /* Remove current project from the projects. */
       unset($projects[$projectID]); 
       $title      = $this->lang->project->edit . $this->lang->colon . $project->name;
       $position[] = html::a($browseProjectLink, $project->name);
       $position[] = $this->lang->project->edit;

       $allProducts    = $this->loadModel('product')->getPairs('noclosed|nocode');
       $linkedProducts = $this->project->getProducts($project->id);
       $allProducts   += $linkedProducts;
       $linkedProducts = join(',', array_keys($linkedProducts));

       $this->view->title          = $title;
       $this->view->position       = $position;
       $this->view->projects       = $projects;
       $this->view->project        = $project;
       $this->view->poUsers        = $this->loadModel('user')->getPairs('noclosed,nodeleted,pofirst', $project->PO);
       //$this->view->pmUsers        = $this->user->getPairs('noclosed,nodeleted,pmfirst',  $project->PM);
       $this->view->pmUsers        = $this->user->getUsersByProjectID($projectID);
       $this->view->qdUsers        = $this->user->getPairs('noclosed,nodeleted,qdfirst',  $project->QD);
       $this->view->rdUsers        = $this->user->getPairs('noclosed,nodeleted,devfirst', $project->RD);
       $this->view->groups         = $this->loadModel('group')->getPairs();
       $this->view->allProducts    = $allProducts;
       $this->view->linkedProducts = $linkedProducts;

       $this->display();	
	}
    public function delete($projectID, $confirm = 'no')
    {
         if($confirm == 'no')
        {

            echo js::confirm($this->lang->project->confirmDelete, $this->createLink('project', 'delete', "projectID=$projectID&confirm=yes"));
            exit;
        }
        else
        {
            // echo "ok";
            $this->dao->delete()->from(TABLE_PROJECT)->where('id')->eq($projectID)->exec();
            $this->loadModel('action')->create('project', $projectID, 'erased');
            
            /* if ajax request, send result. */
            if($this->server->ajax)
            {
                if(dao::isError())
                {
                    $response['result']  = 'fail';
                    $response['message'] = dao::getError();
                }
                else
                {
                    $response['result']  = 'success';
                    $response['message'] = '';
                }
                $this->send($response);
            }
            die(js::locate($this->session->projectList, 'parent'));
            // die(js::locate($this->createLink('my','project', ''), 'parent'));
        }
    }

    /**addedbyheng
     * Change a story.
     * 
     * @param  int    $storyID 
     * @access public
     * @return void
     */
    public function storychange($storyID, $planID)
    {
    	$this->loadModel('story');
    	
        if(!empty($_POST))
        {
            $changes = $this->story->change($storyID);
            if(dao::isError()) die(js::error(dao::getError()));
            $version = $this->dao->findById($storyID)->from(TABLE_STORY)->fetch('version');
            $files = $this->loadModel('file')->saveUpload('story', $storyID, $version);
            if($this->post->comment != '' or !empty($changes) or !empty($files))
            {
                $action = (!empty($changes) or !empty($files)) ? 'Changed' : 'Commented';
                $fileAction = '';
                if(!empty($files)) $fileAction = $this->lang->addFiles . join(',', $files) . "\n" ;
                $actionID = $this->action->create('story', $storyID, $action, $fileAction . $this->post->comment);
                $this->action->logHistory($actionID, $changes);
                $this->sendmail($storyID, $actionID);
            }
            // changedbyheng
            die(js::locate($this->createLink('pro', 'backlogview', "planID=$planID&storyID=$storyID"), 'parent'));
        }

        $this->storyAction($storyID);
        $this->story->getAffectedScope($this->view->story);
        $this->app->loadLang('task');
        $this->app->loadLang('bug');
        $this->app->loadLang('testcase');
        $this->app->loadLang('project');

        /* Assign. */
        $this->view->title      = $this->lang->story->change . "STORY" . $this->lang->colon . $this->view->story->title;
        $this->view->users      = $this->user->getPairs('nodeleted|pofirst', $this->view->story->assignedTo);
        $this->view->position[] = $this->lang->story->change;
        $this->view->needReview = $this->config->story->needReview == 0 ? "checked='checked'" : "";
        $this->view->planID     = $this->view->story->plan;
        $this->display();
    }

    /**
     * The story action when edit or change a story.
     * 
     * @param  int    $storyID 
     * @access public
     * @return void
     */
    public function storyAction($storyID)
    {
        /* Get datas. */
        $story    = $this->loadModel('story')->getById($storyID);
        $product  = $this->loadModel('product')->getById($story->product);
        $products = $this->product->getPairs();
        $moduleOptionMenu = $this->loadModel('tree')->getOptionMenu($product->id, $viewType = 'story');

        /* Set menu. */
        $this->product->setMenu($products, $product->id);

        /* Assign. */
        $this->view->position[]       = html::a($this->createLink('product', 'browse', "product=$product->id"), $product->name);
        $this->view->position[]       = $this->lang->story->common;
        $this->view->product          = $product;
        $this->view->products         = $products;
        $this->view->story            = $story;
        $this->view->moduleOptionMenu = $moduleOptionMenu;
        $this->view->plans            = $this->loadModel('productplan')->getPairs($product->id);
        $this->view->actions          = $this->loadModel('action')->getList('story', $storyID);
    }
	/**
     * Review a backlog.
     * 
     * @param  int    $storyID 
     * @access public
     * @return void
     */
    public function backlogreview($storyID,$planID)
    {
	
	$story   = $this->story->getById($storyID);
	$this->loadModel('story');
	$this->loadModel('action');
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
            die(js::locate(helper::createLink('pro', 'backlog', "planID=$story->plan"), 'parent'));
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
		
        $this->view->title      = $this->lang->story->review . "STORY" . $this->lang->colon . $story->title;
        $this->view->position[] = html::a($this->createLink('product', 'productplan', "product=$product->id"), $product->name);
        $this->view->position[] = html::a($this->createLink('pro', 'backlog', "planID=$story->plan"), $plans[$story->plan]);
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