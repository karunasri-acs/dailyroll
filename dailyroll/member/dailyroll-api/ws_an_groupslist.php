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
if($data != null){
	$accid=$data->accountid;
	//$accid='9';
	$log->event_log($accid,'d');
	$sql="SELECT c.name,c.email,c.phone,b.accountname FROM `groups` a,accounts b,users c WHERE a.`added_user_id`=c.user_id AND a.account_id=b.account_id AND a.account_id='$accid'";
		//echo "sfsdn";			
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		$data=$row;
		
		// Sanitize.
	}
	$cars[]=$data;
	$log->event_log($cars,'d');
	echo json_encode($cars);
	}else{
		echo json_encode('error');
	}

?>