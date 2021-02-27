<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 

$data = json_decode(file_get_contents('php://input'), true);
$log->event_log(json_encode($data),'d');
 if (isset($data['eventid'])  && isset($data['type'])){
    $log->event_log("begining of table ",'d');
	$captid = $data['eventid'];
	//$account_id = '2';
	$log->event_log($account_id,'d');
	$cat_type = $data['type'];
	//$cat_type = 'expenses';
	$log->event_log($captid,'d');
	
	if($cat_type == 1){
	$sql = "DELETE FROM `income` WHERE `income_id`='$captid'";
	}else{
		$sql = "DELETE FROM `expenses` WHERE `id`='$captid'";
		
	}
	$log->event_log($sql,'d');
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,'d');
	$response["error"] = FALSE;
    $response["error_msg"] = "Deleted Successfully";
	echo json_encode($response);
 }
else {
	$response["error"] = TRUE;
    $response["error_msg"] = "Required Parameters are missing";
	echo json_encode($response);
	$log->event_log("Required Pa missing",'e');      
  }


?>

