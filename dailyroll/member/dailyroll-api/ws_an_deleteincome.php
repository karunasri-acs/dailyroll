<?php
	header("Access-Control-Allow-Origin: *");
	
	require_once 'class.user.php';
	$db = new USER();
	
	$request=file_get_contents('php://input');
	$data = json_decode($request);
	if($data != null){
	
	$delete=$data->id;
	//$delete ='5';
	
    $sql="DELETE FROM `income` WHERE `income_id`='$delete'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode("Data DELETEd successfully.");
	}
	else{
		echo json_encode("error while delete inc.");
	}
?>