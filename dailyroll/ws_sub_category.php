<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */
require_once 'class_user.php';
//require_once 'constants.php';
$db = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
// json response array
$response = array("error" => FALSE);

$data = json_decode(file_get_contents('php://input'), true);
if($data !=''){
if (isset($data['subcat_id'])) {
	$cat_id = $data['subcat_id'];
	//$cat_id = '5';
	$log->event_log($cat_id,'d');
	
    $sql = "SELECT * FROM `sub_category` WHERE `cat_id`='$cat_id'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	$log->event_log($sql,'d');
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//print_r($user);
		
		$response["sub_id"] = $row["subcat_id"]; 
		$response["subcat_name"] = $row["subcat_name"];
		$responsearray[] = $response;
		//print_$response);
$log->event_log($responsearray,'d');
		//$responseid[] = $response["cd_id"];
		//$responsearr[] = $response["cat_name"];
		}						
		//echo json_encode($responseid, JSON_FORCE_OBJECT);
		echo json_encode($responsearray);
		$log->event_log(json_encode($responsearray),'d');
		 } else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Select any category to get sub-categories";
	echo json_encode($response);
	$log->event_log(json_encode($response),'e');
        
}
}
else{
if (isset($_POST['subcat_id'])) {
	$cat_id = $_POST['subcat_id'];
	//$cat_id = '5';
	$log->event_log($cat_id,'d');
	
    $sql = "SELECT * FROM `sub_category` WHERE `cat_id`='$cat_id'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	$log->event_log($sql,'d');
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//print_r($user);
		
		$response["sub_id"] = $row["subcat_id"]; 
		$response["subcat_name"] = $row["subcat_name"];
		$responsearray[] = $response;
		//print_$response);
$log->event_log($responsearray,'d');
		//$responseid[] = $response["cd_id"];
		//$responsearr[] = $response["cat_name"];
		}						
		//echo json_encode($responseid, JSON_FORCE_OBJECT);
		echo json_encode($responsearray);
		$log->event_log(json_encode($responsearray),'d');
		 } else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Select any category to get sub-categories";
	echo json_encode($response);
	$log->event_log(json_encode($response),'e');
        
}

}
?>

