<?php 
class myImageModel extends Model
{
	public function getFile($userId)
	{
		$file=$this->loadModel('file')->getByUserId($userId);
		return $file;
	}
	public function getRealName($userId)
	{
		return $this->dao->select('realname')->from(TABLE_USER)->where('id')->eq($userId)->fetch('realname');
	}
	public function uploadImg($filename='')
	{

 		if($_FILES['myFile']['size'] == 0) return;
 		
		$file['title'] = $_FILES['myFile']['name'];
		$file['extension'] = $this->getExtension($file['title']);
		$file['size']=$_FILES['myFile']['size'];
		$file['pathname']=$this->setPathName(0,$file['extension']);
		$file['objectType'] = 'user';
		$file['objectID']   = $this->app->user->id;
		$file['addedBy']    = $this->app->user->account;
		$file['addedDate']  = helper::now();
		$file['extra']      = '';
		
		$oldFile=$this->getFile($this->app->user->id);
		if(move_uploaded_file($_FILES['myFile']["tmp_name"], $this->getSavePath(). $file['pathname'])){
		if(!empty($oldFile->id))
		{
			unlink("../../www/data/upload/{$this->app->company->id}/$oldFile->pathname");
		}
			$this->dao->delete()->from(TABLE_FILE)->where('objectID')->eq((int)$this->app->user->id)->exec();
			$this->dao->insert(TABLE_FILE)->data($file)->exec();
		}
	}
	public function getSavePath()
	{
		$savePath = $this->app->getAppRoot() . "www/data/upload/{$this->app->company->id}/" . date('Ym/', time());
        if(!file_exists($savePath))
        {
            @mkdir($savePath, 0777, true);
            touch($savePath . 'index.html');
        }
        return dirname($savePath) . '/';
	}
	public function getExtension($filename)
	{
		$extension = trim(strtolower(pathinfo($filename, PATHINFO_EXTENSION)));
		return $extension;
	}
	public function setPathName($fileID, $extension)
	{
		$sessionID  = session_id();
		$randString = substr($sessionID, mt_rand(0, strlen($sessionID) - 5), 3);
		return date('Ym/dHis', time()) . $fileID . mt_rand(0, 10000) . $randString . '.' . $extension;
	}
}
?>