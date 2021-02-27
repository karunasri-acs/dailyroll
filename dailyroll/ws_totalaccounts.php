<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();

require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 

$data = json_decode(file_get_contents('php://input'), true);
if($data !=''){
if (isset($data['user_id'])) {
	$log->event_log("begining of get account",'d');
	//$user_id = '5c326b8115a2a8.52878195';
	$user_id = $data['user_id'];
	//$user_id = '5c2dcee2e21538.17188314';
	//$log->event_log($user_id);
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT a.account_id,b.accountname FROM  groups a , accounts b   WHERE  a.account_id = b.account_id and a.`account_status`='active' and a.group_status='Y' and a.userstatus='active'  and a.`added_user_id`='$id'  and a.usertype ='writeonly' group by a.account_id ";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
    //$log->event_log($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $response1['account_id'] = $row['account_id'];
        $response1['accountname'] = $row['accountname'];
		
        $responsearray[] = $response1;
    }

	$response["error"] = FALSE;
    $response["error_msg"] = "Total Accounts";
	$response["totaccounts"] = $responsearray;
	echo json_encode($response);
	$log->event_log(json_encode($responsearray),'d');
	$log->event_log("End of get account",'d');
 }
else {
	$response["error"] = TRUE;
    $response["error_msg"] = "Required Parameters are missing";
	echo json_encode($response);
	$log->event_log("Required Pa missing",'e');      
  }
}
else{
	if (isset($_POST['user_id'])) {
	$log->event_log("begining of get account",'d');
	//$user_id = '5c326b8115a2a8.52878195';
	$user_id = $_POST['user_id'];
	//$user_id = '5c2dcee2e21538.17188314';
	//$log->event_log($user_id);
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT a.account_id,b.accountname FROM  groups a , accounts b   WHERE  a.account_id = b.account_id and a.`account_status`='active' and a.group_status='Y' and a.userstatus='active'  and a.`added_user_id`='$id'  and a.usertype ='writeonly' group by a.account_id ";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
    //$log->event_log($sql);
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $response1['account_id'] = $row['account_id'];
        $response1['accountname'] = $row['accountname'];
		
        $responsearray[] = $response1;
    }

	$response["error"] = FALSE;
    $response["error_msg"] = "Total Accounts";
	$response["totaccounts"] = $responsearray;
	echo json_encode($responsearray);
	$log->event_log(json_encode($responsearray),'d');
	$log->event_log("End of get account",'d');
 }
else {
	$response["error"] = TRUE;
    $response["error_msg"] = "Required Parameters are missing";
	echo json_encode($response);
	$log->event_log("Required Pa missing",'e');      
  }


}

?>

