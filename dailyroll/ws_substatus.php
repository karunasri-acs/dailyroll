<?php
require_once 'class_user.php';
$db = new USER();
require_once 'class.logger.php';
$logger = new LOGGER(basename(__FILE__),__DIR__);
	
if (isset($_POST['uid'])) {
	$uid = $_POST['uid'];
	$logger->event_log('uid'.$uid,'d');
	$userid=$db->getUseridByUniq($uid);
	$check = $db->checkForSubscribe($userid);
	$result = $check['result'];
	$logger->event_log($result,'d');
	if($result == "FALSE"){
		$response["error"] = TRUE;
		$response["error_msg"] = "EXPIRED";
		echo json_encode($response);
		$logger->event_log(json_encode($response),'i');
	}
	else if($result == "TRUE"){
		$response["error"] = FALSE;
		$response["error_msg"] = "NOTEXPIRED";
		echo json_encode($response); 
		$logger->event_log(json_encode($response),'i');
	}
}  
?>

