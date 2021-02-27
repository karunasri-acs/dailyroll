<?php
session_start();	
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
$request=file_get_contents('php://input');
$data = json_decode($request);	
include 'class.user.php';
$user_home = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	if($data !=''){
		$userid=$data->userid;
		$sql1="SELECT * FROM `users` WHERE `unique_id`='$userid'";
		$stmt1 = $user_home->runQuery($sql1);
		$stmt1->execute();
		// echo $sql;			
		$user= $stmt1->fetch(PDO::FETCH_ASSOC);
		$id=$user["user_id"];
		$sql1="select * from `profile` where `user_id`='$id'";
		$log->event_log($sql1,'d');
		$stmt1 = $user_home->runQuery($sql1);
		$stmt1->execute();
		// echo $sql;			
		$row= $stmt1->fetch(PDO::FETCH_ASSOC);
		$photo = $row['photo'];
		$displayfile1=str_replace('"','',$photo);
		$display=str_replace('../','',$displayfile1);
		$url=DISPLAY_DIR.'/content/dailyroll/profile/';
		$displayfile=$url.$display;
		$res=$displayfile;
		$datas["uid"] = $user["unique_id"];
		$datas["name"] = $user_home->dencrypted($user["name"]);
		$datas["email"] = $user_home->dencryptedstatic($user["email"]);
		$datas["usertype"] = $user["usertype"];
		$datas["userid"] = $id;
		$datas["photo"] = $res;
		$dataarray[] = $datas;
		 echo json_encode($dataarray);
		$log->event_log(json_encode($dataarray),'d'); 
  

	
	
	}
		
		
	
		
?>

