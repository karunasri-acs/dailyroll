<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST'); 
	//session_start();
	require_once 'class.user.php';
	$user_home = new USER();

	$request=file_get_contents('php://input');
	$data = json_decode($request);
	if($data != null){
	$account=$data->account;
	$unid=$data->uid;
	$u_id=$user_home->get_email($unid);
	/*$unid='5ba89b3a753e89.85393788';
	$account = "7";
	$date = "2018-1-9";
	$category = "8";
	$description = "hello";
	$amount = "337";*/
    //$account=$_POST['account'];
    $date=date('Y-m-d');
    $sql="INSERT INTO `accounts`(`user_id`, `accountname`, `date`, `accountstatus`) VALUES ('$unid','$account','$date','Y')";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$code = $user_home->lasdID();
	$sql1="INSERT INTO `groups`(`account_id`, `group_status`, `added_user_id`)
		   VALUES ('$code','Y','$u_id')";
	$stmt1 = $user_home->runQuery($sql1);
	$stmt1->execute();
	echo json_encode('Account added Successfully');
	 //echo "Data saved successfully.";
	}
?>

