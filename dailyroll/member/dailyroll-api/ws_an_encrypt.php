<?php
 header("Access-Control-Allow-Origin: *");
include '../../constants/constants.php';

require_once 'class.user.php';
$db = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
$request=file_get_contents('php://input');
$data = json_decode($request);

    $log->event_log("begining of encrypt",'d');
    // receiving the post params
	
	$stringvalue=$data->stringvalue;
	$decryptvalue=$db->encryptedstatic($stringvalue);
	echo  json_encode($decryptvalue);
   $log->event_log(json_encode($decryptvalue),'d');
?>