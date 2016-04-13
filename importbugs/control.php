<?php
/**
 * The control file of importbugs module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     importbugs
 * @version     $Id: model.php 5079 2013-07-10 00:44:34Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class importbugs extends control
{
	public function __construct($moduleName = '', $methodName = '')
    {
         parent::__construct($moduleName, $methodName);
     
    }
    
	public function upload($productID, $planID, $sprintID)
	{

		if(!empty($_FILES)){
			$msg = $this->importbugs->uploadExcel('', $productID, $planID, $sprintID);
			echo "<script>alert('$msg')</script>";
			// if(isonlybody()) die(js::closeModal('parent'));
			die(js::closeModal('parent'));
		}

		$this->display();
	}
}
?>