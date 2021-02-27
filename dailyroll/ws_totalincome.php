<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 


$data = json_decode(file_get_contents('php://input'), true);
$log->event_log(json_encode($data),'d');
if($data != ''){
if(isset($data['user_id'])) {
	$log->event_log("begining of get account",'d');
	//$user_id = '5c2dcee2e21538.17188314';
	$user_id = $data['user_id'];
	$log->event_log($user_id,'d');
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT * FROM `income` WHERE `capture_id`='$user_id'";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
    $log->event_log($sql,'d');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      
        $responsearray[] = $row;
    }
	$response["error"] = FALSE;
	$response["msg"] = "Success";
	$response["Income"] = $responsearray;
	echo json_encode($response);
	$log->event_log(json_encode($responsearray),'d');
	$log->event_log("End of get account",'d');
 }
else {
	$response["error"] = TRUE;
    $response["msg"] = "Required Parameters are missing";
	echo json_encode($response);
	$log->event_log("Required Pa missing",'e');      
  }
}
else{
	if(isset($_POST['user_id'])) {
	$log->event_log("begining of get account",'d');
	//$user_id = '5c2dcee2e21538.17188314';
	$user_id = $_POST['user_id'];
	$log->event_log($user_id,'d');
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT * FROM `income` WHERE `capture_id`='$user_id'";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
    $log->event_log($sql,'d');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      
        $responsearray[] = $row;
    }
	$response["error"] = FALSE;
	$response["msg"] = "Success";
	$response["Income"] = $responsearray;
	echo json_encode($responsearray);
	$log->event_log(json_encode($responsearray),'d');
	$log->event_log("End of get account",'d');
 }
else {
	$response["error"] = TRUE;
    $response["msg"] = "Required Parameters are missing";
	echo json_encode($response);
	$log->event_log("Required Pa missing",'e');      
  }



}

?>

