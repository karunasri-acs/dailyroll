<?php

require_once 'class_user.php';
$user_home = new USER();
	//json response array
$response = array("error" => FALSE);
$eventlog = EVENTLOG;
	function event_log($text){
	if(EVENTLOG == Y){
		$text=$uid."\t".$text;
		$file = "logs"."/".APP_NAME.date("Y-m-d").".log";
//$file = "logs/dailyroll".date("Y-m-d").".log";
		error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3, $file);
	}		
	}
	return $str;
}
function event_log($text){
if(EVENTLOG==Y){
    $uid=$_SESSION['unique_ID'];
	$text=$uid."\t".$text;
	$file = "logs/dailyroll".date("Y-m-d").".log";
	error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3, $file);	
}	
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    event_log("begining of forgotpassword");
    $email = $_POST['email'];
	//echo $email = 'areef111sayad@gmail.com';
	$phone = $_POST['phone'];
	//echo $phone = '8886230186';
	//echo $user=$user_home->isUserExisted($email);
	if(!$user_home->isUserExisted($email,$phone)){
          //echo "hii";
		  $response["error"] = FALSE;
		  $response["message"] = 'Invalid  Email ..';
		  echo json_encode($response);
		  event_log(json_encode($response));

		} 
	else {
	
       //	echo"kk";
	$sql="SELECT * FROM `users` WHERE email='$email' AND `phone`='$phone'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	//print_r($row);
	$user_id=$row['user_id'];
	$name=$row['name'];	
	if($stmt->rowCount() == 1)
	{
	//echo"hdjh";
	 $pass=randomString(8);
		
		$message= "
				   Hello $name
				   <br /><br />
				   We got requested to Forget your password, if you do this then just login with the password given below and after loggedin change your password 
				   <br /><br />
				Password:      $pass
				   <br /><br />
				   thank you :)
				   ";
		$subject = "Password Reset";
		
		$user_home->send_mail($email,$subject,$message);
		
		echo"we send a mail to your account";
		$hash = $user_home->hashSSHA($pass);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"];
		$sql1="UPDATE `users` SET `encrypted_password`='$encrypted_password',`salt`='$salt' WHERE `user_id` ='$user_id'";
		$stmt1 = $user_home->runQuery($sql1);
	    $stmt1->execute();
		//echo $sql1;
		event_log("message sent to mail");
	//echo $sql1;
	}
	}
}
	else
	{
		echo "please return";
		
	}

?>