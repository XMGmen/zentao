<?php
/**
 * The model file of importbugs currentModule of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     importbugs
 * @version     $Id: control.php 5107 2013-07-12 01:46:12Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class importbugsModel extends model
{
    public function uploadExcel($filename = '', $productID, $planID, $sprintID)
    {
        if($_FILES['excelFile']['size'] == 0) return;

        // uploadFile
        $filePath    = $this->getSavePath();
        $fname       = $this->setPathName(0, $file['extension']);
        $uploadfile  = $filePath . $fname;
        $tmp_name    = $_FILES['excelFile']["tmp_name"];

        require_once 'PHPExcel.php';
        require_once 'PHPExcel/IOFactory.php';
        require_once 'PHPExcel/Reader/Excel2007.php';
    
        $result = move_uploaded_file($_FILES['excelFile']["tmp_name"], $this->getSavePath(). $fname);
        if($result)
        {
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = PHPExcel_IOFactory::load($uploadfile);
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
  
            for($j = 2; $j <= $highestRow; $j++)
            {
                $str = "";
                for($k = 'A'; $k <= $highestColumn; $k++)
                {
                    // $str .= iconv('utf-8', 'gbk', $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue())."|";//读取单元格
                    $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue()."|";//读取单元格
                }
                $strs = explode("|", $str);
                $bug = new stdclass();
                $bug->product  = $productID;
                $bug->plan     = $planID;

                if ($sprintID) $bug->project  = $sprintID;
        
                $bug->title    = $strs[0];
                $bug->stage    = $this->lang->importbugs->stageMap[$strs[1]];
                $bug->type     = $this->lang->importbugs->typeMap[$strs[2]];
                $bug->severity = $strs[3];
                $bug->steps    = $strs[4];
                $bug->openedBy = $this->app->user->account;

                $this->dao->insert(TABLE_BUG)->data($bug)->exec();

               	$bugID = $this->dao->lastInsertID();
               	$action = new stdclass();
               	$action->objectType = 'bug';
               	$action->objectID   = $bugID;
               	$action->product    = $productID;
               	$action->project    = $sprintID;
               	$action->actor      = $this->app->user->account;
               	$action->action     = 'opened';
               	$action->date       = helper::now();
               	$action->read       = 0;

                $this->dao->insert(TABLE_ACTION)->data($action)->exec();
            }
            unlink ($uploadfile);
            $msg = $this->lang->importbugs->success;
        } else {
            $msg = $this->lang->importbugs->fail;
        }
        return $msg;
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
