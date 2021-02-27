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
	//$file =$data->filename;
	//echo "hehd";
	$date2= date('Y-m-d', strtotime($date1));
	//$pendingstatus=$data->pendingstatus;
	$catdeat=$user_home->get_subcategoryDetails($subcategory);
	$setamount=$catdeat['amount'];
	$log->event_log($setamount,'d');
	$pendingstatus=$data->pendingstatus;
	/*$unid='5ba89b3a753e89.85393788';
	$account = "7";
	$date = "2018-1-9";
	$category = "8";
	$description = "hello";
	$amount = "337";*/

    $sql="UPDATE `expenses` SET `account_id`='$account',`amount`='$amount',`description`='$description',`subcat_id`='$subcategory',`cat_id`='$category',`tr_date`= '$date', pendingflag='$pendingstatus' WHERE `id`='$expenseid'";
	 $log->event_log($sql,'d');
	$stmt=$user_home->runQuery($sql);
	$result = $stmt->execute();
	 echo json_encode("Updated Successfully.");
	
	 
	}
?>

