<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
$data = json_decode(file_get_contents('php://input'), true);
$log->event_log(json_encode($data),'d');
if (isset($data['user_id'])) {
	$log->event_log("begining of get account",'d');
	//$user_id = '5c2dcee2e21538.17188314';
	$user_id = $data['user_id'];
	$type=$data['type'];
	$log->event_log($user_id,'d');
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT a.account_id,b.accountname FROM  groups a , accounts b   WHERE  a.account_id = b.account_id and a.`account_status`='active'and a.group_status='Y' and  a.userstatus='active'  and a.`added_user_id`='$id' group by a.account_id ";
	 $stmt = $user_home->runQuery($sql);
    $stmt->execute();
    $log->event_log($sql,'d');
	$rowcount=$stmt->rowcount();
	if($rowcount > 0){
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$accountid=$row['account_id'];
				$response['value'] = $row['account_id'];
				$response['label'] = $row['accountname'];
				$responsearray[] = $response;
			
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

