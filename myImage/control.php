<?php
class myImage extends control
{
    public function __construct($moduleName='', $methodName='')
    {
         parent::__construct($moduleName, $methodName);
     
    }  
    public function showImage()
	{
		$userId=$this->app->user->id;
		$file=$this->loadModel('myImage')->getFile($userId);
		$realName=$this->loadModel('myImage')->getRealName($userId);
		if(!($file->id))
		{
			$file=$this->loadModel('myImage')->getFile(0);
		    $userId=0;
		}
		$userName=$this->app->user->realname;
			
		$this->view->userId=$userId;
		$this->view->realName=$realName;
		$this->view->file=$file;
		$this->display();
	}
	public function editImage($userId)
	{
		if(!empty($_FILES)){
			$this->loadModel('myImage')->uploadImg();
			if(isonlybody())die(js::closeModal('parent'));
		}
		$file=$this->loadModel('myImage')->getFile($userId);
		$this->view->file=$file;
		$this->display();
	}
}
