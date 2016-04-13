<?php
class mySprintBoard extends control
{
    public function __construct($moduleName='', $methodName='')
    {
         parent::__construct($moduleName, $methodName);
         $this->moduleName='mySprintBoard';
         $this->loadModel('mySprintBoard');
         $this->loadModel('project');
    }  
    
    public function index($sprintID=0,$orderBy='isTop_desc,lastEditedDate_desc', $recTotal=0, $recPerPage=5, $pageID=1)
    {
    	if(!empty($_POST))
    	{
    		$this->mySprintBoard->index();
    		 
    		$response['result']  = 'success';
    		$response['message'] = '';
    		$response['locate'] = $this->createLink('mySprintBoard', 'index', "sprintID=$sprintID");//这一句将index改为more
    		$this->send($response);
    	} 
    	   
    	
    	if(!$orderBy) $orderBy = $this->cookie->sprintBoardOrder ? $this->cookie->sprintBoardOrder : 'id';
    	setcookie('sprintBoardOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
    	$sort = $this->loadModel('common')->appendOrder($orderBy);
    	$this->app->loadClass('pager', $static = true);
    	$pager=new pager($recTotal, $recPerPage, $pageID);
    
    	$sprintRecords=$this->mySprintBoard->getRecordsBySprintID($sprintID,$sort,$pager);
    	$sprintName=$this->project->getProjectNameByProjectId($sprintID);
    	$realnames=array();
    	foreach($sprintRecords as $sprintRecord)
    	{
    		$name=$this->loadModel('mySprintBoard')->getrealname($sprintRecord);
    		$realnames[$sprintRecord->id]=$name;
    	}
    	
    	
    	//$this->view->pager=$pager;                           //首页显示最新5条
    	//$this->view->recTotal=$pager->recTotal;
    	//$this->view->recPerPage=$pager->recPerPage;
    	$this->view->orderBy=$orderBy;
    	$this->view->sprintID=$sprintID;
    	$this->view->sprintRecords=$sprintRecords;
    	$this->view->sprintName=$sprintName;
    	$this->view->realnames=$realnames;
    	
        $this->display();
    }
    
    public function create($sprintID=0,$onlybody='no')
    {
        if(!empty($_POST))
        {  
        	$this->mySprintBoard->create();
         	if(isonlybody())die(js::closeModal('parent.parent'));
        	die(js::locate(inlink('index', "sprintID=$sprintID"), 'parent'));	
        }
        
        $this->methodName='create';      //实现编辑器的头
        $sprintName=$this->project->getProjectNameByProjectId($sprintID);
    	$this->view->sprintID=$sprintID;
    	$this->view->sprintName=$sprintName;
    	$this->view->username=$username;   //在view界面显示username
    	$this->display();
    }
    
    
   
    public function more($sprintID=0,$status = 'all',$orderBy='isTop_desc,lastEditedDate_desc', $recTotal=0, $recPerPage=10, $pageID=1,$isShow2=1)
    {
    	$this->loadModel('mySprintBoard');
    	if(!empty($_POST))
    	{
    		$this->mySprintBoard->create();
    		 
    		$response['result']  = 'success';
    		$response['message'] = '';
    		$response['locate'] = $this->createLink('mySprintBoard', 'more', "sprintID=$sprintID");//这一句将index改为more
    		$this->send($response);
    	}
    	
    	
    	//if(!$orderBy) $orderBy = $this->cookie->sprintBoardOrder ? $this->cookie->sprintBoardOrder : 'id';
    	//setcookie('sprintBoardOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
    	$this->methodName='more';           //显示富文本编辑器的头  	   
    	$sort = $this->loadModel('common')->appendOrder($orderBy);
    	$this->app->loadClass('pager', $static = true);
    	$pager=new pager($recTotal, $recPerPage, $pageID);    
    	$sprintRecords=$this->mySprintBoard->getRecordsBySprintID($sprintID,$sort,$pager);   	
    	$sprintName=$this->project->getProjectNameByProjectId($sprintID);  
    	
    	$isSQAorSM=$this->loadModel('mySprintBoard')->isSQAorSM($this->app->user->account,$sprintID);
    	
    	$realnames=array();
    	$srcs=array();
    	foreach($sprintRecords as $sprintRecord)
    	{
    		$name=$this->loadModel('mySprintBoard')->getrealname($sprintRecord);
    		$realnames[$sprintRecord->id]=$name;
    		$src=$this->mySprintBoard->getSrcBySprintRecord($sprintRecord);
    		$srcs[$sprintRecord->id]=$src;
    	}
    	
    	$planID=$this->loadModel('project')->getPlanByProjectID($sprintID);
    	$sprints=$this->loadModel('productplan')->getProjectPairs($planID);
    	$products=$this->loadModel('productplan')->getProductsByPlanID($planID);
    	$this->view->title='更多留言';
    	$this->view->pager=$pager;
    	$this->view->recTotal=$pager->recTotal;
    	$this->view->recPerPage=$pager->recPerPage;
    	$this->view->orderBy=$orderBy;
    	$this->view->sprintID=$sprintID;
    	$this->view->sprintRecords=$sprintRecords;
    	$this->view->sprintName=$sprintName;
    	$this->view->account=$this->app->user->account;
    	$this->view->isSQAorSM=$isSQAorSM;
    	$this->view->realnames=$realnames;
    	$this->view->srcs=$srcs;
    	$this->view->sprintStats = $sprintStats;
    	//added by fxq
    	$this->view->sprints=$sprints;
    	$isShow=$this->loadModel('mySprintBoard')->isShow($this->app->user->account,$sprintID);
    	$this->view->isShow=$isShow;
        $this->view->isShow2=$isShow2;
        $productID   = key($products);       
        $productName = current($products);
        $planName    = $this->dao->select('title')->from(TABLE_PRODUCTPLAN)->where('id')->eq($planID)->fetch('title');
        $sprintName  = $this->dao->select('name')->from(TABLE_PROJECT)->where('id')->eq($sprintID)->fetch('name');
        $this->view->position[] = html::a(helper::createLink("product", "productplan","productID=$productID"),$productName);
        $this->view->position[] = html::a(helper::createLink("pro", "index","planID=$planID"),$planName); 
        $this->view->position[] = $sprintName;
    	$this->display();    	   		
    }
    
    public function sprintRecordView($sprintRecordID=0,$onlybody='no')
    {
    	if(!empty($_POST))
    	{
    		$this->mySprintBoard->edit($sprintRecordID);
    		$sprintID=$this->loadModel('mySprintBoard')->getSprintIDBySprintRecordID($sprintRecordID);
    		$location  =  $this->createLink('mySprintBoard',  'more',  "sprintID=$sprintID");
    		die(js::locate($location,  'self'));
    		

    	}
    	$this->methodName='sprintRecordView';           //这是我新增的，是为了显示编辑器的头
    	$sprintRecord=$this->mySprintBoard->getSprintRecordBySprintRecordID($sprintRecordID);
    	$sprintName=$this->mySprintBoard->getSprintNameBySprintRecordID($sprintRecordID);
    	$this->view->sprintName=$sprintName;
    	$this->view->sprintRecord=$sprintRecord;
    	
    	$sprintID=$this->loadModel('mySprintBoard')->getSprintIDBySprintRecordID($sprintRecordID);
    	$this->view->sprintID=$sprintID;
    	$this->view->sprintRecordID=$sprintRecordID;
    	$this->display();
    }
    
    public function edit($sprintRecordID=0,$onlybody='no')
    {
    	if(!empty($_POST))
    	{
    		$this->mySprintBoard->edit();
    		$sprintID=$this->loadModel('mySprintBoard')->getSprintIDBySprintRecordID($sprintRecordID);
    		if(isonlybody())die(js::closeModal('parent.parent'));
    		die(js::locate(inlink('index', "sprintID=$sprintID"), 'parent'));
    	
    	}
    	$this->methodName='edit';           //这是我新增的，是为了显示编辑器的头
    	$sprintRecord=$this->mySprintBoard->getSprintRecordBySprintRecordID($sprintRecordID);
    	$sprintName=$this->mySprintBoard->getSprintNameBySprintRecordID($sprintRecordID);
    	$sprintID=$this->loadModel('mySprintBoard')->getSprintIDBySprintRecordID($sprintRecordID);
    	//$sprintRecordID=$this->loadModel('mySprintBoard')->getSprintIDBySprintRecordID($sprintRecordID);
    	$this->view->sprintName=$sprintName;
    	$this->view->sprintRecord=$sprintRecord;   	
    	$this->view->sprintID=$sprintID;
    	$this->view->sprintRecordID=$sprintRecordID;
    	//$this->view->sprintRecordID=$sprintRecord;
    	$this->display();
    }
    
    public function top($sprintRecordID=0)
    {
    	$this->mySprintBoard->updateSprintRecord($sprintRecordID);
        die(js::reload('parent'));
    }
    
    public function delete($sprintRecordID=0,$sprintID=0)
    {
    	$this->loadModel('mySprintBoard')->deleteRecord($sprintRecordID);
    	 die(js::locate($this->createLink('mySprintBoard', 'more', "sprintID=$sprintID"), 'parent'));
    }
}
