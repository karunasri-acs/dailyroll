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
$response = array("error" => FALSE);
$data = json_decode(file_get_contents('php://input'), true);
if($data !=''){
if (isset($data['account_id']) ) {

  $account_id = $data['account_id'];
$cat_type = $data['cat_type'];
	
//echo"nandini";
	
//echo $account_id = '1';
//	echo $cat_type = 'expenses';

 $sql = "SELECT * FROM `category` WHERE `account_id`='$account_id' AND `cat_type`='$cat_type'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//echo $sql;
  	$log->event_log($sql,'d');
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//print_r($user);
		
		$response["cat_id"] = $row["cat_id"]; 
		$response["cat_name"] = $row["cat_name"];
		$responsearray[] = $response;
		//print_$response);

		//$responseid[] = $response["cd_id"];
		//$responsearr[] = $response["cat_name"];
		}						
		//echo json_encode($responseid, JSON_FORCE_OBJECT);
		echo json_encode($responsearray);
		$log->event_log(json_encode($responsearray),'d');
	 } else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Select any account to get categories";
	echo json_encode($response);
	//$log->event_log(json_encode($response));

}
}
else{
	if (isset($_POST['account_id']) ) {

  $account_id = $_POST['account_id'];
$cat_type = $_POST['cat_type'];
	
//echo"nandini";
	
//echo $account_id = '1';
//	echo $cat_type = 'expenses';

 $sql = "SELECT * FROM `category` WHERE `account_id`='$account_id' AND `cat_type`='$cat_type'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//echo $sql;
  	$log->event_log($sql,'d');
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//print_r($user);
		
		$response["cat_id"] = $row["cat_id"]; 
		$response["cat_name"] = $row["cat_name"];
		$responsearray[] = $response;
		//print_$response);

		//$responseid[] = $response["cd_id"];
		//$responsearr[] = $response["cat_name"];
		}						
		//echo json_encode($responseid, JSON_FORCE_OBJECT);
		echo json_encode($responsearray);
		$log->event_log(json_encode($responsearray),'d');
	 } else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Select any account to get categories";
	echo json_encode($response);
	//$log->event_log(json_encode($response));

}


}
?>

