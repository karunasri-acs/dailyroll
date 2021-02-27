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
	$date=$data->date1;
	$amount=$data->amount;
	$description=$data->description;
	$category=$data->category;
	$subcategory=$data->subcategory;
	$expenseid=$data->id;
	$log->event_log($expenseid,'d');
	//$file =$data->filename;
	//echo "hehd";
	//$date2= date('Y-m-d', strtotime($date1));
	
	/*$unid='5ba89b3a753e89.85393788';
	$account = "7";
	$date = "2018-1-9";
	$category = "8";
	$description = "hello";
	$amount = "337";*/
	$catdeat=$user_home->get_subcategoryDetails($subcategory);
	$setamount=$catdeat['amount'];
	$log->event_log($setamount,'d');
	if($setamount == $amount){
		$addstatus='non-pending';
	
	}else{
		$addstatus='pending';
	}
	if($setamount > $amount){
    $sql="UPDATE `income` SET `account_id`='$account',`income_amount`='$amount',`cat_id`='$category',`subcat_id`='$subcategory',`description`='$description',`tr_date`='$date' WHERE `income_id`='$expenseid'";
	    $log->event_log($sql,'d');
	$stmt=$user_home->runQuery($sql);
	$result = $stmt->execute();
	 echo json_encode("Updated Successfully.");
	
	 }
	else{
		echo json_encode("Entered Amount is higher than saved Amount");
		$log->event_log('higher','d');
	}
	}
?>

