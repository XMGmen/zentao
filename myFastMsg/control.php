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
class myFastMsg extends control
{
    public function __construct($moduleName = '', $methodName = '')
    {
         parent::__construct($moduleName, $methodName);
    }
    public function index($projectID=0)
    {
        $this->display();
    }
}
