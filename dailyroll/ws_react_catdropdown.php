<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
$data = json_decode(file_get_contents('php://input'), true);
$log->event_log(json_encode($data),'d');
 if (isset($data['account_id'])  && isset($data['cat_type'])){
    $log->event_log("begining of get category",'d');
	$account_id = $data['account_id'];
	//$account_id = '2';
	$log->event_log($account_id,'d');
	$cat_type = $data['cat_type'];
	//$cat_type = 'expenses';
	$log->event_log($cat_type,'d');
	if($cat_type == 1){
	$sql = "SELECT * FROM `category` WHERE `account_id` = '$account_id' and cat_type='income' and status = 'active' and cat_id IN (SELECT cat_id FROM `sub_category` WHERE status = 'active' group by cat_id)";
	}else{
		$sql = "SELECT * FROM `category` WHERE `account_id` = '$account_id' and cat_type='expenses' and status = 'active' and cat_id IN (SELECT cat_id FROM `sub_category` WHERE status = 'active' group by cat_id)";
		
	}
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,'d');
	$count=$stmt->rowcount();
	if($count > 0){
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$response["value"] = $row["cat_id"]; 
		$response["label"] = $row["cat_name"];
		$responsearray[] = $response;
		}	
		
		$response["error"] = False;
	$response["datashow"] =$responsearray ;
	echo json_encode($response);
	}
	else{
		$response["error"] = TRUE;
		$response["error_msg"] = "No data available ";
		echo json_encode($response);
		$log->event_log("Required Pa missing",'e'); 
		
	}
 }
else {
	$response["error"] = TRUE;
    $response["error_msg"] = "Required Parameters are missing";
	echo json_encode($response);
	$log->event_log("Required Pa missing",'e');      
  }


?>

