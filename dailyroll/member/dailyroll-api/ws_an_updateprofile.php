	<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST'); 
	//session_start();
	require_once 'class.user.php';
	$user_home = new USER();
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	//echo "befor";
	$file_path = DIR_PROFILE;
	
	$request=file_get_contents('php://input');
	$data = json_decode($request);
	
	//echo "after";
	
	$name =$data->name;
	$lname =$data->lname;
	$email =$data->email;
	$address =$data->address;
	$country =$data->country;
	$phone =$data->phone;
	$log->event_log($name."-".$lname."-".$email."-".$phone."-".$address,'d');
	
	$name =$user_home->encrypted($name);
	$lname =$user_home->encrypted($lname);
	$email =$user_home->encryptedstatic($email);
	$address =$user_home->encrypted($address);
	$country =$user_home->encrypted($country);
	$phone =$user_home->encrypted($phone);
	$log->event_log($name."-".$lname."-".$email."-".$phone."-".$address,'d');

	$uid =$data->uid;
   /* $name="hii";
	$lname= "gg";
	$email= "viswakkk@gmail.com";
	$address= "bjkkaja";
	$country= "india";
	$phone= "3654889";
	$filepath= "../../../uploads/content/dailyroll/profile/5ba89b3a753e89.85393788-arif.jpg";
	 $uid= "5ba89b3a753e89.85393788";*/
	if($uid != ''){
		$length=strlen($phone);
	
	$log->event_log($uid,'d');
	$id=$user_home->get_email($uid);
	$log->event_log($id,'d');
	$sql="select * from `users` where `user_id`='$id'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	// echo $sql;			
	$row1= $stmt->fetch(PDO::FETCH_ASSOC);
	$sql1="select * from `profile` where `user_id`='$id'";
	$stmt1 = $user_home->runQuery($sql1);
	$stmt1->execute();
	// echo $sql;			
	$row= $stmt1->fetch(PDO::FETCH_ASSOC);
	$count=$stmt1->rowcount();
	$log->event_log($count,'d');
	if($count==0){
		$sql="UPDATE `users`SET `name`='$name',`email`='$email',`phone`='$phone' WHERE `user_id`='$id'";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		$sql="INSERT INTO `profile`(`user_id`, `name`, `lastname`, `email`, `address`, `phone`, `country`) 
					VALUES ('$id','$name','$lname','$email','$address','$phone','$country')";
					$log->event_log($sql,'d');
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		echo json_encode("Profile Updated successfully.");
		
	}else{
		$sql1="UPDATE`users` SET `name`='$name',`email`='$email',`phone`='$phone' WHERE `user_id`='$id'";
		$stmt1 = $user_home->runQuery($sql1);
		$stmt1->execute();
		$log->event_log($sql1,'d');
		$sql="UPDATE `profile` SET `name`='$name',`lastname`='$lname',`email`='$email',`address`='$address',`phone`='$phone',`country`='$country' WHERE `user_id`='$id'";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		$log->event_log($sql,'d');
		echo json_encode("Profile Updated successfully.");
		
	}


	}else{
	echo json_encode("error");
}
?>
