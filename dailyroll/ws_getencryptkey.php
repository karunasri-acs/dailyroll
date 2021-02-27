<?php

require_once 'class_user.php';
$db = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
$log->event_log('root file beginning ','d'); 
$sql="SELECT * FROM `config`";
$stmt1 = $db->runQuery($sql);
$stmt1->execute();
$user=$stmt1->fetch(PDO::FETCH_ASSOC);
 // use is found
        $response["error"] = FALSE;
        $response["secretyKey"] =$user['sk'];
        $response["sec"] =$user['sec'];
        $response["ivstring"] =$user['iv'];
        echo json_encode($response);
		$log->event_log(json_encode($response),'d');

?>