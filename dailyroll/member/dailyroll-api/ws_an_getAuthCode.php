<?php
	header("Access-Control-Allow-Origin: *");
	include 'class.user.php';
	$db = new USER();
	$request=file_get_contents('php://input');
	$data = json_decode($request);
	require_once 'googleLib/GoogleAuthenticator.php';
	$ga = new GoogleAuthenticator();
	$secret = $ga->createSecret();	
	
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d');  
	
	$uid=$data->uid;
	$log->event_log($uid,'d');
	//$datas= [];
	$q=$data->q;
	if($q==1){
		$sql="SELECT * FROM `config`";
		$stmt= $db->runQuery($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$output = $row['auth_code'];
		//$dataarray[] = $output;
		echo json_encode($output);
		$log->event_log(json_encode($output),'d');
	}else if ($q==2){
		$key= GOOGLRCAPCTCHA;
		echo json_encode($key);
		$log->event_log(json_encode($key),'d');
	}
?>

