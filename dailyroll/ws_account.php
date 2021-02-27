<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'class_user.php';
$db = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 

// json response array
$response = array("error" => FALSE);
$data = json_decode(file_get_contents('php://input'), true);
if($data !=''){
if (isset($data['user_id'])) {
	$log->event_log("begining of login",'d');
	
	$user_id = $data['user_id'];
	$log->event_log($user_id,'d');
	
	//echo $user_id = '5c2dcee2e21538.17188314';
	$id=$db->getUseridByUniq($user_id);
   $sql="SELECT * FROM  groups  WHERE  `account_status`='active' and   `added_user_id`='$id'group by account_id ";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//echo$sql;
	$log->event_log($sql,'d');
	
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//print_r($user);
		$accountname=$db->get_account($row['account_id']);
		$data=[
		'account_id'=> $row['account_id'],
		 'accountname' =>$accountname
		 ];
		 $responsearray[] = $data;
		//print_$response);
		
		}						
		echo json_encode($responsearray);
		$log->event_log(json_encode($responsearray),'d');
    //$password = 'abc123';
  } else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
	echo json_encode($response);
	$log->event_log(json_encode($response),'e');
        
}
}
else{
if (isset($_POST['user_id'])) {
	$log->event_log("begining of login",'d');
	
	$user_id = $_POST['user_id'];
	$log->event_log($user_id,'d');
	
	//echo $user_id = '5c2dcee2e21538.17188314';
	$id=$db->getUseridByUniq($user_id);
   $sql="SELECT * FROM  groups  WHERE  `account_status`='active' and   `added_user_id`='$id'group by account_id ";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//echo$sql;
	$log->event_log($sql,'d');
	
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//print_r($user);
		$accountname=$db->get_account($row['account_id']);
		$data=[
		'account_id'=> $row['account_id'],
		 'accountname' =>$accountname
		 ];
		 $responsearray[] = $data;
		//print_$response);
		
		}						
		echo json_encode($responsearray);
		$log->event_log(json_encode($responsearray),'d');
    //$password = 'abc123';
  } else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
	echo json_encode($response);
	$log->event_log(json_encode($response),'e');
        
}



}
?>

