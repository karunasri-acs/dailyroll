<?php
 header("Access-Control-Allow-Origin: *");
	include 'class.user.php';
	$db = new USER();
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	$request=file_get_contents('php://input');
	$data = json_decode($request);
	$q=$data->q;
	if($q==1){
	$accountid=$data->accountid;
	$seltype=$data->seltype;
	$description=$data->description;
	$uid=$data->uid;
	$sql="INSERT INTO `notification`( `userid`, `description`, `type`, `createddate`, `accountid`) VALUES ('$uid','$description','$seltype',NOW(),'$accountid')";
	$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
			echo json_encode('Added Sucessfully');

	}
	elseif($q==2){
		$sql="select * from  `notification`";
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
		$accountid=$row['accountid'];
		$userid=$row['userid'];
		$accountname=$db->get_account($accountid);
		$username=$db->get_names($userid);
		$output[]=[
		'description'=>$row['description'],
		'accountname'=>$accountname,
		'username'=>$username,
		'type'=>$row['type'],
		'date'=>$row['createddate']
		
		];
		}
		echo json_encode($output);
	}
	

?>
