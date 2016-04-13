<?php

try {
    $client = new SoapClient("http://99.48.237.125:5880/openapi/openapi.php?wsdl");
    $parm1='5DEDD10D2E434A139A05953BDB66CC68';
    $parm2='672918';
    $parm3='672907';
    $parm4='haha';
    $param = array('key' => $parm1,'from'=>$parm2,'sendto'=>$parm3,'content'=>$parm4);
    $arr=$client->__soapCall('SendMessage',$param);
    
    print_r($arr);
} catch (SOAPFault $e) {
    print $e;
}
?>
