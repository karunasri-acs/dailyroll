<?php
 header("Access-Control-Allow-Origin: *");
    include 'class.user.php';
	$db = new USER();
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
// Get the posted data.
    $request=file_get_contents('php://input');
	$data = json_decode($request);

	$accid=$data->accountid;
	$todate=$data->todate;
	//$accid='15';
	$log->event_log($accid,'d');
	
	if(!$accid == ''){
		//echo "sfsdn";
		$sql="UPDATE `expenses` SET `freeze`='freeze' WHERE `account_id`='$accid' and `tr_date` <='$todate'";
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		$sql1="UPDATE `income` SET `freeze`='freeze' WHERE `account_id`='$accid' and `tr_date` <='$todate'";
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		$sql2="UPDATE `accounts` SET `freezedate`= '$todate' WHERE  `account_id`='$accid' ";
		$stmt2 = $db->runQuery($sql2);
		$stmt2->execute();
		echo  json_encode('Freezed Successfully');
	}else{
		echo json_encode('error');
	}

?>
