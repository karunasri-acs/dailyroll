<?php
 header("Access-Control-Allow-Origin: *");
	include 'class.user.php';
	$db = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	$request=file_get_contents('php://input');
	$data = json_decode($request);

	$uid=$data->uid;
	//$uid = '5ba89b3a753e89.85393788';
	//$uid=$db->get_email($uid);
	$sql = "SELECT * FROM `users` WHERE `unique_id` = '$uid'";
	$log->event_log($sql,'d');
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$userid = $row['user_id'];
	//echo $u_id;
	//$cars = [];
	if(!$userid == ''){
		
		$sql="SELECT * FROM  groups  WHERE  `account_status`='active' and (`user_id`='$userid' or `added_user_id`='$userid') group by account_id ";
	    $log->event_log($sql,'d');		
		$stmt = $db->runQuery($sql);
		$stmt->execute();
			//echo $sql;
		while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$cars["accountid"]=$row1['account_id'];
			 $log->event_log($row1['account_id'],'d');
			$accountname=$db->get_account($row1['account_id']);
			$cars["accountname"]=$accountname;
			$data[]=$cars;
			// Sanitize.
		}
		$log->event_log(print_r($data),'d');
		echo json_encode($data);
	}else{
		echo json_encode('error');
	}

?>
