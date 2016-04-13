<?php
class myFastMsgModel extends model
{
    public function sendBugMsg($bugID=0,$projectIDplus=0,$oldAssignedTo=null)
    {
        #return;
        
        $assignedTo=$_POST['assignedTo'];
        $planID=$this->dao->select('plan')->from(TABLE_BUG)->where('id')->eq($bugID)->fetch('plan');
        $realname=$this->dao->select('realname')->from(TABLE_USER)->where('account')->eq($assignedTo)->fetch('realname');
        
        if ($projectIDplus) {
            $msg="$realname,您被指派了Bug,信息链接:".'http://'.$_SERVER['HTTP_HOST'].'/zentao/sprint-bugview-'."$bugID.html";
        } else {
            $msg="$realname,您被指派了Bug,信息链接:".'http://'.$_SERVER['HTTP_HOST'].'/zentao/pro-bugview-'.$planID."-$bugID.html";
        }
        $fastMsg=$this->dao->select('fastMsg')->from(TABLE_USER)->where('account')->eq($assignedTo)->fetch('fastMsg');
        try {
            $client = new SoapClient("http://99.48.237.125:5880/openapi/openapi.php?wsdl");
            $parm1='5DEDD10D2E434A139A05953BDB66CC68';
            $parm2='600000';
            $parm3=$fastMsg;
            $parm4=$msg;
            $param = array('key' => $parm1,'from'=>$parm2,'sendto'=>$parm3,'content'=>$parm4);  
            if($oldAssignedTo!=$assignedTo)
                $arr=$client->__soapCall('SendMessage',$param);
        } catch (SOAPFault $e) {
            print $e;
        }
    }
    public function sendTaskMsg($projectID=0,$taskID=0,$oldAssignedTo=null,$isFromCreate)
    {
        #return;

        if($isFromCreate) {
            $assignedTo=current($_POST['assignedTo']);
        } else {
            $assignedTo=$_POST['assignedTo'];
        }
        $realname=$this->dao->select('realname')->from(TABLE_USER)->where('account')->eq($assignedTo)->fetch('realname');
        $msg="$realname,您被指派了任务,信息链接:   ".'http://'.$_SERVER['HTTP_HOST'].'/zentao/sprint-taskview-'."$taskID.html";
        $fastMsg=$this->dao->select('fastMsg')->from(TABLE_USER)->where('account')->eq($assignedTo)->fetch('fastMsg');
        try {
            $client = new SoapClient("http://99.48.237.125:5880/openapi/openapi.php?wsdl");
            $parm1='5DEDD10D2E434A139A05953BDB66CC68';
            $parm2='600000';
            $parm3=$fastMsg;
            $parm4=$msg;
            $param = array('key' => $parm1,'from'=>$parm2,'sendto'=>$parm3,'content'=>$parm4);
            if($oldAssignedTo!=$assignedTo)
                $arr=$client->__soapCall('SendMessage',$param);
        }catch (SOAPFault $e) {
            print $e;
        }
    }
}
