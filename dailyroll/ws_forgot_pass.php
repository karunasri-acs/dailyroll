<?php

require_once 'class_user.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	//json response array
$response = array("error" => FALSE);
 
function randomString($length) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	//echo  $str;
	return $str;
}
$data = json_decode(file_get_contents('php://input'), true);
if($data !=''){
//if($_SERVER['REQUEST_METHOD']=='POST'){
if(isset($data['email']) && isset($data['phone'])){	
    $log->event_log("begining of forgotpassword",'d');
    $orginalemail = $data['email'];
	$email=$user_home->encryptedstatic($orginalemail);
	//echo $email = 'areef111sayad@gmail.com';
	$phone = $data['phone'];
	//echo $phone = '8886230186';
	//echo $user=$user_home->isUserExisted($email);
	if(!$user_home->isUserExisted($email,$phone)){
          //echo "hii";
		  $response["error"] = FALSE;
		  $response["message"] = 'Invalid  Email ..';
		  echo json_encode($response);
		  $log->event_log(json_encode($response),'d');

		} 
	else {
	
       //	echo"kk";
	$sql="SELECT * FROM `users` WHERE email='$email' AND `phone`='$phone'";
	$log->event_log($sql,'d');
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	//print_r($row);
	$user_id=$row['user_id'];
	$name=$user_home->dencrypted($row['name']);	
	$status=$row['userstatus'];
	if($stmt->rowCount() == 1)
	{
	if($status == 'N'){
		$code=$row['unique_id'];
		$key = base64_encode($user_id);
		$subject = "Activation Need";
		$message = "
		Dear $fname,
		<br /><br />
		Thank you for starting your Voter Survey registration. To protect your identity, we need to verify your email address.<br/>
		Please click the link below and continue your VoterSurvey registration. $countrycode<br/>
		<br /><br />
		<a href=".MOBREG_URL."verify.php?id=$key&code=$code>Click HERE to Activate :)</a>
		<br /><br />
		Thanks,";
		$user_home->send_mail($orginalemail,$subject,$message);
		
		$response["error"] = FALSE;
        $response["message"] = "You have to Activate Your Account please check Email ";
        echo json_encode($response);
	}
	else{
	//echo"hdjh";
	$log->event_log("userexisted",'d');
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
		
		//echo "we send a mail to your account";
		$hash = $user_home->hashSSHA($pass);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"];
		$sql1="UPDATE `users` SET `encrypted_password`='$encrypted_password',`salt`='$salt' WHERE `user_id` ='$user_id'";
		$log->event_log($sql1,'d');
		$stmt1 = $user_home->runQuery($sql1);
	    $stmt1->execute();
		//echo $sql1;
		$log->event_log("message sent to mail",'d');
		
		$response["error"] = FALSE;
        $response["message"] = "We send a mail to your account";
        echo json_encode($response);
	//echo $sql1;
	}
	}
	else
	{
		$response["error"] = TRUE;
        $response["message"] = "No User Found";
        echo json_encode($response);
	}
	}
}
	else
	{
		$response["error"] = FALSE;
        $response["message"] = "please return";
        echo json_encode($response);
	}
}
else{
	if($_SERVER['REQUEST_METHOD']=='POST'){
    $log->event_log("begining of forgotpassword",'d');
    $orginalemail = $_POST['email'];
	$email=$user_home->encryptedstatic($orginalemail);
	//echo $email = 'areef111sayad@gmail.com';
	$phone = $_POST['phone'];
	//echo $phone = '8886230186';
	//echo $user=$user_home->isUserExisted($email);
	if(!$user_home->isUserExisted($email,$phone)){
          //echo "hii";
		  $response["error"] = FALSE;
		  $response["message"] = 'Invalid  Email ..';
		  echo json_encode($response);
		  $log->event_log(json_encode($response),'d');

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
	$name=$user_home->dencrypted($row['name']);	
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
		
		$user_home->send_mail($orginalemail,$subject,$message);
		
		//echo "we send a mail to your account";
		$hash = $user_home->hashSSHA($pass);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"];
		$sql1="UPDATE `users` SET `encrypted_password`='$encrypted_password',`salt`='$salt' WHERE `user_id` ='$user_id'";
		$stmt1 = $user_home->runQuery($sql1);
	    $stmt1->execute();
		//echo $sql1;
		$log->event_log("message sent to mail",'d');
		
		$response["error"] = FALSE;
        $response["message"] = "We send a mail to your account";
        echo json_encode($response);
	//echo $sql1;
	}
	else
	{
		$response["error"] = True;
        $response["message"] = "No User Found ";
        echo json_encode($response);
	}
	}
}
	else
	{
		$response["error"] = TRUE;
        $response["message"] = "please return";
        echo json_encode($response);
	}




}
?>