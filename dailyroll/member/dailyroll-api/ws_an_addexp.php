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
	$log->event_log(json_encode($data),'d');
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

	
	/*$unid='5ba89b3a753e89.85393788';
	$account = "7";
	$date = "2018-1-9";
	$category = "8";
	$description = "hello";
	$amount = "337";*/
	if($account !='' && $category ='' &&  $subcategory!='' ){
		try{
			$catdeat=$user_home->get_subcategoryDetails($subcategory);
			$setamount=$catdeat['amount'];
			$log->event_log($setamount,'d');
			if($setamount == $amount){
				$addstatus='non-pending';
			
			}else{
				$addstatus='pending';
			}
				$log->event_log($addstatus,'d');
			
				$sql="INSERT INTO `expenses`(`capture_id`, `account_id`,`amount`, `file_name`, `description`, `cat_id`,`subcat_id`,`tr_date`,`pendingflag`) 
									 VALUES ('$unid','$account','$amount','$file','$description','$category','$subcategory','$date','$addstatus')";
				$log->event_log($sql,'d');
				$stmt=$user_home->runQuery($sql);
				$result = $stmt->execute();
				 echo json_encode("Data saved successfully.");
			 
		}
		catch(PDOException $exception)
			{
			   echo json_encode("Sorry You already added this record with same data");
			}
	}
	else{
		echo json_encode("error while saving expnse.");
	}
	}
	else{
		echo json_encode("error while saving expnse.");
	}
		
?>

