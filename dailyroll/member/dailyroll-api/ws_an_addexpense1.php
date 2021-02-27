<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST'); 
	//session_start();
	require_once 'class.user.php';
	$user_home = new USER();

	$request=file_get_contents('php://input');
	$data = json_decode($request);
	if($data != null){
	$account=$data->accountid;
	$date=$data->expdate;
	$amount=$data->amount;
	$description=$data->description;
	$category=$data->catid;
	$subcategory=$data->subcatid;
	$unid=$data->uid;
	$file =$data->filename;
	//echo "hehd";
	$addstatus=$data->addstatus;
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
	/*$unid='5ba89b3a753e89.85393788';
	$account = "7";
	$date = "2018-1-9";
	$category = "8";
	$description = "hello";
	$amount = "337";*/
			   $sql1="SELECT * FROM  groups a,accounts b  WHERE  a.account_id=b.account_id and b.accountname='$account' and a.`account_status`='active' and a.`added_user_id`='$id'";
	   $log->event_log($sql1,'d');
	$stmt1 = $db->runQuery($sql1);
	$stmt1->execute();
	$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
	$resultaccid=$row1['account_id'];
	$sql = "SELECT * FROM `category` WHERE `account_id`='$resultaccid' AND `cat_name`='$category' and `cat_type`='expenses'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,'d');
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$catid = $row["cat_id"]; 
	$sql2 = "SELECT * FROM `sub_category` WHERE `cat_id`='$catid' and `subcat_name`='subcategory'";
	$stmt2 = $db->runQuery($sql2);
	$stmt2->execute();
	$log->event_log($sql2,'d');
	$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
	$subcatid=$row2['subcat_id'];
    $sql="INSERT INTO `expenses`(`capture_id`, `account_id`,`amount`, `file_name`, `description`, `cat_id`,`subcat_id`,`tr_date`,`pendingflag`) 
		                 VALUES ('$unid','$resultaccid','$amount','$file','$description','$catid','$subcatid','$date','$addstatus')";
	$log->event_log($sql,'d');
	$stmt=$user_home->runQuery($sql);
	$result = $stmt->execute();
	 echo json_encode("Data saved successfully.");
	}
	else{
		echo json_encode("error while saving expnse.");
	}
		
?>

