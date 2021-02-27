<?php
	header("Access-Control-Allow-Origin: *");
	include 'class.user.php';
	$db = new USER();
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	$request=file_get_contents('php://input');
	$data = json_decode($request);

	$email=$data->email;
	$email1=$db->encryptedstatic($email);
	//$password=$data->password;
	//$email='kuru@gmail.com';
	//$password='abc123';
	 $sql="SELECT email from users WHERE email = '$email1'";
	$stmt = $user->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	$row = $stmt->fetch(PDO::FETCH_ASSOC);	
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
		Thank you for starting your DailyRollt registration. To protect your identity, we need to verify your email address.<br/>
		Please click the link below and continue your DailyRoll registration. $countrycode<br/>
		<br /><br />
		<a href=".MOBREG_URL."verify.php?id=$key&code=$code>Click HERE to Activate :)</a>
		<br /><br />
		Thanks,";
		$user_home->send_mail($email,$subject,$message);
		$countrydata='You have to Activate Your Account please check Email ';
		echo json_encode($countrydata);
		$log->event_log(json_encode($countrydata),basename(__FILE__),'d');
	
	}
	else{	
		$id = base64_encode($row['user_id']);
		$message= "
				   Hello , $email
				   <br /><br />
				   We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore                   this email,
				   <br /><br />
				   Click Following Link To Reset Your Password 
				   <br /><br />
				   <a href=".SERVER_URL."=$id>click here to reset your password</a>
				   <br /><br />
				   thank you :)
				   ";
		$subject = "Password Reset";
		
		$user->send_mail($email,$subject,$message);
		
		$msg = "<div class='alert alert-success'>
					<button class='close' data-dismiss='alert'>&times;</button>
					We've sent an email to $email.
                    Please click on the password reset link in the email to generate new password. 
			  	</div>";
				echo $msg;
	}
	}
	else
	{
		$msg = "<div class='alert alert-danger'>
					<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry!</strong>  this email not found. 
			    </div>";
				echo $msg;
	}
?>