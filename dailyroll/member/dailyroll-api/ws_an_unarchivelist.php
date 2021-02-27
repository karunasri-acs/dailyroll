<?php
 header("Access-Control-Allow-Origin: *");
    include 'class.user.php';
	$db = new USER();
// Get the posted data.
    $request=file_get_contents('php://input');
	$data = json_decode($request);
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 


	$uid=$data->userid;
	//$uid = '5ba89b3a753e89.85393788';
	//$u_id=$db->get_email($uid);
	//$cars = [];
	//echo "sfsdn";
	if(!$uid == ''){
		//echo "sfsdn";
		$sql="SELECT * FROM `accounts` WHERE `user_id`='$uid'  and `accountstatus`!='active'";
			//echo "sfsdn";			
			$log->event_log($sql,'d');
		$stmt = $db->runQuery($sql);
		$stmt->execute();
			//echo $sql;
		while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		    $row=$db->get_accountdetails($row1['account_id']);
			$cars[]=$row;
			// Sanitize.
		}
		echo json_encode($cars);
	}else{
		echo json_encode('error');
	}

?>
