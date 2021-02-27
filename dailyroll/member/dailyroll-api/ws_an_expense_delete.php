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
	
	$delete=$data->id;
	$log->event_log($delete,'d');
	//echo $delete ='58';
	
    $sql="DELETE FROM `expenses` WHERE `id`='$delete' ";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	 echo json_encode("Data deleted successfully.");
	}
	else{
		echo json_encode("error while deleting acc.");
	}
?>