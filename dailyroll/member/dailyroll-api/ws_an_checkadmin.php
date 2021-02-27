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
	$id=$data->uid;
	//$accid='15';
	$log->event_log($accid,'d');
	
	if(!$accid == ''){
		//echo "sfsdn";
		$sql="SELECT * FROM `accounts` WHERE `account_id`= '$accid'";
			//echo "sfsdn";			
		$stmt = $db->runQuery($sql);
		$stmt->execute();
			//echo $sql;
		$row1 = $stmt->fetch(PDO::FETCH_ASSOC);
		if($id==$row1['user_id']){
		 $cars[]=[
		 'useradmin'=>'admin'
		 ];
			// Sanitize.
		}
		else{
		 $cars[]=[
		 'useradmin'=>'user'
		 ];
		}
		echo json_encode($cars);
	}else{
		echo json_encode('error');
	}

?>
