<?php
	header("Access-Control-Allow-Origin: *");
	include 'class.user.php';
	$user_home = new USER();
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d');  
	$request=file_get_contents('php://input');
	$data = json_decode($request);
    if($data!=''){
	$opass=$data->opass;
	$log->event_log($opass,'d');
	$npass=$data->npass;
	$log->event_log($npass,'d');
	$rpass=$data->rpass;
	$log->event_log(rpass,'d');
	$uid= $data->uid;
	$log->event_log($uid,'d');
	/*$opass="abc123";
	$npass="abc1234";
	$rpass="abc1234";
	$uid= "5ba89b3a753e89.85393788";*/
	$id=$user_home->get_email($uid);
	$log->event_log($id,'d');
	$sql = "SELECT * FROM `users` WHERE `user_id`= '$id'";
	$log->event_log($sql,'d');
	//echo $sql;
	$stmt = $user_home->runQuery($sql);
    $stmt->execute();
	$log->event_log($sql,'d');
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$original = $row['encrypted_password'];
    $log->event_log($original,'d');
	$salt=$row['salt'];
    $log->event_log($salt,'d');
	$hash =$user_home->checkhashSSHA($salt, $opass);
	$log->event_log($hash,'d');
 // echo $original."  ".$enter;
  if($original == $hash){
	 //echo"hii";
	 $log->event_log("old password and enter password same",'d');
   if($npass == $rpass){
	   //echo "hello";
	   $log->event_log("both new passwords same",'d');
    $hash = $user_home->hashSSHA($npass);
	$encrypted_password = $hash["encrypted"];
	$salt1 = $hash["salt"];
    $sql = "UPDATE `users` SET `encrypted_password`= '$encrypted_password',`salt`='$salt1' WHERE `user_id` = '$id'";
    $log->event_log($sql,'d');
    $stmt = $user_home->runQuery($sql);
    $stmt->execute(); 
	//echo $sql;
    
		echo json_encode("password changed successfully");
		$log->event_log(json_encode("password changed successfully"),'d');
   }else{
    
	echo json_encode("Please check the Entered Password");
		$log->event_log(json_encode("Please check the Entered Password"),'d');
   }
   
  }else{
   echo json_encode("Please check the Entered Password");
		
		$log->event_log(json_encode("Please check the Entered Password"),'d');
  }
}
  else{
  echo json_encode("error reseting password");
		$log->event_log(json_encode("error reseting password"),'d');
  }
?>
