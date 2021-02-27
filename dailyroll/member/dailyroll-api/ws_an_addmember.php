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
	$name=$data->name;
	$accid=$data->accountid;
	$email = $data->email;
    $upass = $data->password;
	$uid = $data->uid;
	$log->event_log(accid,'d');
	$u_id=$db->get_email($uid);
	$sql2="select * from users where email='$email'";
	$stmt2 = $user_home->runQuery($sql2);
	$stmt2->execute();
	//echo $sql2;
	$stmt2->rowCount();
	$userRow=$stmt2->fetch(PDO::FETCH_ASSOC);
	if($stmt2->rowCount() >= 1){
	//echo"dhj";
	$addid=$userRow['user_id'];
	$salt = $userRow['salt'];
	$encrypted_password = $userRow['encrypted_password'];
	$hash1=base64_encode(sha1($upass));
	$hash = $user_home->checkhashSSHA($salt,$upass);
	if ($encrypted_password == $hash){
	$sql3="select * from `groups` where `added_user_id`='$addid' and `account_id`='$accid'";
	$stmt3= $user_home->runQuery($sql3);
	$stmt3->execute();
	//echo $sql3;
	$stmt3->rowCount();
	if($stmt3->rowCount() == 0){
	 $sql="INSERT INTO `groups`(`account_id`,`group_status`, `added_user_id`, `user_id`) 
	VALUES ('$groupid','N','$addid','$u_id')";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	$code = $user_home->lasdID();
	$key=base64_encode($addid);
	 	$message = "					
					Hello,
					<br /><br />
					Your Fa
					mily member added your account into his family group <br/>
					To complete your registration  please , just click following link<br/>
					<br /><br />
					<a href='http://dailyroll.dinkhoo.com/accept.php?id=$key&code=$code'=>Click HERE to Accept :)</a>
					<br /><br />
					Thanks,";
						
		$subject = "Family request";
		$user_home->send_mail($email,$subject,$message);
		
	}
	else
	{
	  
      echo json_encode("you  already added this person into group.");		  
	}
	
	}
	else
	{
	  
      echo json_encode("Password wrong please enter right password.");			  
	}
	} 
	else{
    
     echo json_encode("There is no user with this email");
    }
	
}
	
?>

