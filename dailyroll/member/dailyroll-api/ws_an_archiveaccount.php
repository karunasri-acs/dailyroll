<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST'); 
	//session_start();
	require_once 'class.user.php';
	$user_home = new USER();

	$request=file_get_contents('php://input');
	$data = json_decode($request);
	if($data != null){
		//$account=$data->account;
		$id=$data->id;
		$sql1="UPDATE `accounts` SET `accountstatus`='inactive' WHERE `account_id`='$id'";	
		$stmt1 = $user_home->runQuery($sql1);
		$stmt1->execute();
		 // echo $sql1;
		$sql2="UPDATE `groups` SET `account_status`='inactive' WHERE `account_id`='$id'";	
		$stmt2 = $user_home->runQuery($sql2);
		$stmt2->execute();
		echo json_encode("Data saved successfully.");
	}
	else{
		echo json_encode("error while saving acc.");
	
	}
?>

