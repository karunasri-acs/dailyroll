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
	$id=$data->id;
	
    $sql="UPDATE `accounts` SET `accountname`='$account' WHERE `account_id`='$id'";
	
	$stmt=$user_home->runQuery($sql);
	$result = $stmt->execute();
	echo json_encode("Data saved successfully.");
	}
	else{
		echo json_encode("error while saving acc.");
	}
?>

