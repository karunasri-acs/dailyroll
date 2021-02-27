<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();

 $eventlog = EVENTLOG;
	function event_log($text){
	if(EVENTLOG == Y){
		$text=$uid."\t".$text;
		$file = "logs"."/".APP_NAME.date("Y-m-d").".log";
//$file = "logs/dailyroll".date("Y-m-d").".log";
		error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3, $file);
	}		
	}

$data = json_decode(file_get_contents('php://input'), true);
if($data !=''){
if (isset($data['user_id'])) {
	event_log("begining of get account");
	//$user_id = '5c2dcee2e21538.17188314';
	$user_id = $data['user_id'];
	event_log($user_id);
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT * FROM `expenses` WHERE `capture_id`='$user_id' order by id desc";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
    event_log($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      
        	$responsearray[] = $row;
		}
	$response["error"] = FALSE;
	$response["msg"] = "Success";
	$response["Expences"] = $responsearray;
	echo json_encode($response);
	event_log(json_encode($responsearray));
	event_log("End of get account");
 }
else {
	$response["error"] = TRUE;
    $response["msg"] = "Required Parameters are missing";
	echo json_encode($response);
	event_log("Required Parameters missing");      
  }
}
else{
if (isset($_POST['user_id'])) {
	event_log("begining of get account");
	//$user_id = '5c2dcee2e21538.17188314';
	$user_id = $_POST['user_id'];
	event_log($user_id);
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT * FROM `expenses` WHERE `capture_id`='$user_id' order by id desc";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
    event_log($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      
        	$responsearray[] = $row;
		}
	$response["error"] = FALSE;
	$response["msg"] = "Success";
	$response["Expences"] = $responsearray;
	echo json_encode($responsearray);
	event_log(json_encode($responsearray));
	event_log("End of get account");
 }
else {
	$response["error"] = TRUE;
    $response["msg"] = "Required Parameters are missing";
	echo json_encode($response);
	event_log("Required Parameters missing");      
  }


}

?>

