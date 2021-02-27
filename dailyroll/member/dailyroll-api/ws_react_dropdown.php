<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
$data = json_decode(file_get_contents('php://input'), true);

$log->event_log((json_encode($data),'d');
if (isset($data['user_id'])) {
	$log->event_log("begining of get account",'d');
	//$user_id = '5c2dcee2e21538.17188314';
	$user_id = $data['user_id'];
	$log->event_log($user_id,'d');
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT a.account_id,b.accountname FROM  groups a , accounts b   WHERE  a.account_id = b.account_id and a.`account_status`='active'and a.group_status='Y' and  a.userstatus='active'  and a.`added_user_id`='$id' group by a.account_id ";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
    $log->event_log($sql,'d');
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $response['value'] = $row['account_id'];
        $response['label'] = $row['accountname'];
        $responsearray[] = $response;
    }
	echo json_encode($responsearray);
	$log->event_log(json_encode($responsearray),'d');
	$log->event_log("End of get account",'d');
 }
else if (isset($data['account_id'])  && isset($data['cat_type'])){
    $log->event_log("begining of get category",'d');
	$account_id = $data['account_id'];
	//$account_id = '2';
	$log->event_log($account_id,'d');
	$cat_type = $data['cat_type'];
	//$cat_type = 'expenses';
	$log->event_log($cat_type,'d');
	$sql = "SELECT * FROM `category` WHERE `account_id`='$account_id' AND `cat_type`='$cat_type'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,'d');
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	$response["value"] = $row["cat_id"]; 
	$response["label"] = $row["cat_name"];
	$responsearray[] = $response;
	}						
	echo json_encode($responsearray);
	$log->event_log(json_encode($responsearray),'d');
	$log->event_log("ending of get category",'d');
 }
else if (isset($_POST['subcat_id'])) {
    $log->event_log("begining of get subcategory",'d');
	$cat_id = $_POST['subcat_id'];
	//$cat_id ='16';
	$log->event_log($cat_id,'d');
	$sql = "SELECT * FROM `sub_category` WHERE `cat_id`='$cat_id'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	$log->event_log($sql,'d');
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	$response["sub_id"] = $row["subcat_id"]; 
	$response["subcat_name"] = $row["subcat_name"];
	$responsearray[] = $response;
	//print_$response);
	$log->event_log($responsearray,'d');
	}						
	echo json_encode($responsearray);
	$log->event_log(json_encode($responsearray),'d');
	$log->event_log("ending of get subcategory",'d');
  }
  else if (isset($_POST['subcat'])) {
    $log->event_log("begining of get amount",'d');
	$cat_id = $_POST['subcat'];
	//$cat_id ='16';
	$log->event_log($cat_id,'d');
	$sql = "SELECT * FROM `sub_category` WHERE `subcat_id`='$cat_id'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	$log->event_log($sql,'d');
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

	$response["amount"] = $row["amount"];
	$responsearray[] = $response;
	//print_$response);
	$log->event_log($responsearray,'d');
	}						
	echo json_encode($responsearray);
	$log->event_log(json_encode($responsearray),'d');
	$log->event_log("ending of get Amount",'d');
  }
else {
	$response["error"] = TRUE;
    $response["error_msg"] = "Required Parameters are missing";
	echo json_encode($response);
	$log->event_log("Required Pa missing",'e');      
  }


?>

