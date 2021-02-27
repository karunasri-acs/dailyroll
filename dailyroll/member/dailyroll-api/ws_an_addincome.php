<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST'); 
	//session_start();
	require_once 'class.user.php';
	$user_home = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
	$request=file_get_contents('php://input');
	$data = json_decode($request);
	if($data != null){
	$account=$data->account;
	$date=$data->indate;
	$amount=$data->amount;
	$description=$data->description;
	$category=$data->category;
	$unid=$data->uid;
	$subcatid=$data->subcatid;
	$status=$data->addstatus;
	/*	$file =$data->filename;
	echo "hehd";
	$date2= date('Y-m-d', strtotime($date1));
	
	$unid='5ba89b3a753e89.85393788';
	$account = "7";
	$date = "2018-1-9";
	$category = "8";
	$description = "hello";
	$amount = "337";
    */
	$catdeat=$user_home->get_subcategoryDetails($subcatid);
	$setamount=$catdeat['amount'];
	//$log->event_log($setamount);
	if($setamount >= $amount){
		$addstatus='non-pending';
	
	}else if($setamount =='0'){
		$addstatus='non-pending';
	}
	else{
		$addstatus='pending';
	}
	
	$log->event_log('amount'.$amount,'d');
	$log->event_log('setamount'.$setamount,'d');
	$log->event_log('status'.$addstatus,'d');
	
	if($setamount >= $amount){
	$sql="INSERT INTO `income`( `capture_id`, `account_id`, `income_amount`, `cat_id`,`subcat_id`, `description`, `tr_date`,`pendingflag`)  
									VALUES ('$unid','$account','$amount','$category','$subcatid','$description','$date','$addstatus')";
	
	$stmt=$user_home->runQuery($sql);
	$result = $stmt->execute();
	echo json_encode("Data saved successfully.");
	}
	else{
	echo json_encode("Entered Amount is higher than saved Amount");
	$log->event_log('higher','d');
	}
	}else{
		echo json_encode("error while saving Income.");
	} 
?>

