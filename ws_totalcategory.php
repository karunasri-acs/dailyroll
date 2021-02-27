<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();

 $eventlog = EVENTLOG;
	function event_log($text){
	if(EVENTLOG == Y){
		$text=$uid."\t".$text;
		$file = DIR_LOGS."dailyroll".date("Y-m-d").".log";
//$file = "logs/dailyroll".date("Y-m-d").".log";
		error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3, $file);
	}		
	}

$data = json_decode(file_get_contents('php://input'), true);
if($data !=''){
if (isset($data ['user_id'])) {
	event_log("begining of get category");

	$user_id = $data['user_id'];
	//$user_id = '5c2dcee2e21538.17188314';
	
	event_log($user_id);
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT c.cat_id,c.cat_name,c.account_id,c.cat_type FROM  groups a , accounts b, category c   WHERE  a.account_id = b.account_id  and a.account_id=c.account_id and b.account_id=c.account_id and c.status='active' and a.`account_status`='active'  and a.`added_user_id`='$id'";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
 //   event_log($sql);
    while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){
         $accountid = $row1['account_id'];
		 $response1=[
		 'cat_id' => $row1['cat_id'],
		 'cat_name' => $row1['cat_name'],
		 'account_id' => $row1['account_id'],
		'cat_type' => $row1['cat_type']
		];
        $responsearray[] = $response1;
    }
	$response["error"] = FALSE;
    $response["error_msg"] = "Total Accounts";
	$response["totaccounts"] = $responsearray;
	echo json_encode($response);
	event_log(json_encode($responsearray));
	event_log("End of get category");
 }
else {
	$response["error"] = TRUE;
    $response["error_msg"] = "Required Parameters are missing";
	echo json_encode($response);
	event_log("Required Pa missing");      
  }
}else{
if (isset($_POST['user_id'])) {
	event_log("begining of get category");

	$user_id = $_POST['user_id'];
	//$user_id = '5c2dcee2e21538.17188314';
	
	event_log($user_id);
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT c.cat_id,c.cat_name,c.account_id,c.cat_type FROM  groups a , accounts b, category c   WHERE  a.account_id = b.account_id  and a.account_id=c.account_id and b.account_id=c.account_id and c.status='active' and a.`account_status`='active'  and a.`added_user_id`='$id'";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
 //   event_log($sql);
    while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){
         $accountid = $row1['account_id'];
		 $response1=[
		 'cat_id' => $row1['cat_id'],
		 'cat_name' => $row1['cat_name'],
		 'account_id' => $row1['account_id'],
		'cat_type' => $row1['cat_type']
		];
        $responsearray[] = $response1;
    }
	$response["error"] = FALSE;
    $response["error_msg"] = "Total Accounts";
	$response["totaccounts"] = $responsearray;
	echo json_encode($responsearray);
	event_log(json_encode($responsearray));
	event_log("End of get category");
 }
else {
	$response["error"] = TRUE;
    $response["error_msg"] = "Required Parameters are missing";
	echo json_encode($response);
	event_log("Required Pa missing");      
  }


}

?>

