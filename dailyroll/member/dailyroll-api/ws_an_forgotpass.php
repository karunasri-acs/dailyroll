<?php
header("Access-Control-Allow-Origin: *");
include 'class.user.php';
$user = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
// Get the posted data.
$request=file_get_contents('php://input');
$data = json_decode($request);
$email=$data->email;
//$u_id='5c2dcee2e21538.17188314';

$email1=$user->encryptedstatic($email);
	
	$log->event_log($email,'d');
	$sql="select * from users WHERE `email`='$email1'";
	$log->event_log($sql,'d');
	$stmt = $user->runQuery($sql);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
	//print_r($row);
	$status=$row['userstatus'];
	if($stmt->rowCount() == 1)
	{
		if($status == 'N'){
			$id=$row["user_id"];
			$code=$row['unique_id'];
			$key = base64_encode($id);
			$subject = "Activation Need";
			$message = "
			Dear $fname,
			<br /><br />
			Thank you for starting your DailyRoll registration. To protect your identity, we need to verify your email address.<br/>
			Please click the link below and continue your DailyRoll registration. $countrycode<br/>
			<br /><br />
			<a href=".REG_URL."verify.php?id=$key&code=$code>Click HERE to Activate :)</a>
			<br /><br />
			Thanks,";
			$user->send_mail($email,$subject,$message);
			$countrydata='You have to Activate Your Account please check Email ';
			echo json_encode($countrydata);
			$log->event_log(json_encode($countrydata),basename(__FILE__),'d');
		}
		else{
		$id = base64_encode($row['user_id']);
		
		
		$message= "
				   Hello , $email
				   <br /><br />
				   We got requested to Set  your password, if you  want to do this then just click the following link to set new  password, if not just ignore this email,
				   <br /><br />
				   Click Following Link To Set New  Password 
				   <br /><br />
				   <a href='".REG_URL."ws_an_changepassword.php?id=$id'>click here to Set New  password</a>
				   <br /><br />
				   thank you :)
				   ";
		$subject = "Set New Password  ";
		
		$user->send_mail($email,$subject,$message);
		
		$msg = "We've sent an email to $email.
                    Please click on the password reset link in the email to generate new password.";
					echo json_encode($msg);
				$log->event_log(json_encode($msg),'d');
	}
	}
	else
	{
		$msg = "This email not found.";
			   echo json_encode($msg);
				$log->event_log(json_encode($msg),'d');
	}

?>

