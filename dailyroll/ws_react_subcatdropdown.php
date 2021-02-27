<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 	
$data = json_decode(file_get_contents('php://input'), true);
$log->event_log(json_encode($data),'d');
 if (isset($data['subcat_id'])) {
    $log->event_log("begining of get subcategory",'d');
	$cat_id = $data['subcat_id'];
	//$cat_id ='16';
	$log->event_log($cat_id,'d');
	$sql = "SELECT * FROM `sub_category` WHERE `cat_id`='$cat_id' and status='active'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	$log->event_log($sql,'d');
	//$response =  array();
	//$x = 1;
	$rowcount=$stmt->rowcount();
	if($rowcount > 0){
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$response["value"] = $row["subcat_id"]; 
		$response["label"] = $row["subcat_name"];
		$responsearray[] = $response;
		//print_$response);
		$log->event_log($responsearray,'d');
		}						
		$response["error"] = FALSE;
		$response["datashow"] =$responsearray ;
		echo json_encode($response);
	}
	else{
		$response["error"] = TRUE;
		$response["error_msg"] = "No data available";
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

