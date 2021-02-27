<?php
	header("Access-Control-Allow-Origin: *");
	include 'class.user.php';
	$user_home = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	require_once 'googleLib/GoogleAuthenticator.php';
	$ga = new GoogleAuthenticator();
	$secret = $ga->createSecret();	
	$request=file_get_contents('php://input');
	$data = json_decode($request);

	$id=$data->userid;
	$log->event_log($id,'d');
	$q=$data->q;
	$log->event_log($q,'d');
	$code=$data->authcode;
	$datad=[];
	if($q == 1){
  // get the user by email and password
    $userDetails=$user_home->userDetails($id);
	$secret=$userDetails['google_auth_code'];
	$log->event_log($secret,'d');
	$email=$userDetails['email'];

	$log->event_log($email,'d');

	$qrCodeUrl = $ga->getQRCodeGoogleUrl($email, $secret,'DailyRoll App');
       
       $datad["qrcode"] = $qrCodeUrl;
		$log->event_log($qrCodeUrl,'d'); 
		$dataarray[] = $datad;
		//header('Content-Type: application/json');
        echo json_encode($dataarray);
		$log->event_log(json_encode($datad),'d'); 
    }
	elseif($q == 2){
		//$id=$data->userid;
		
		$log->event_log($code,'d');
        $userDetails=$user_home->userDetails($id);
		$secret=$userDetails['google_auth_code'];
		$log->event_log($secret,'d');
		//require_once 'googleLib/GoogleAuthenticator.php';
		//$ga = new GoogleAuthenticator();
		$checkResult = $ga->verifyCode($secret, $code, 2);    // 2 = 2*30sec clock tolerance

		if ($checkResult) 
		{
			$datad["code"] = $code;
		$log->event_log("getting code",'d');
			$dataarray[] = $datad;
			//header('Content-Type: application/json');
			echo json_encode($dataarray);
		  
		} 
		else 
		{
			$code = "failed";
		$datad["code"] = 'failed';
		$log->event_log("failed",'d');
			$dataarray[] = $datad;
			//header('Content-Type: application/json');
			echo json_encode($dataarray);
		}
	}



	elseif($q == 3){
		//$id=$data->userid;
		
	$email=$data->email;
	$sql="SELECT * FROM `users` WHERE `email`='$email'";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		$secret=$userRow['google_auth_code'];			
		$qrCodeUrl = $ga->getQRCodeGoogleUrl($email, $secret,'DailyRoll App');
		$datad["qrcode"] = $qrCodeUrl;
		$log->event_log($qrCodeUrl,'d'); 
		$dataarray[] = $datad;
		
		$subject="Barcode from DailyRoll";
		$message = '<html><body>';
		$message .= '<h1 style="color:#f40;">Hi '.$userRow['name'].'!</h1>';
		$message .= '	<tr>
					<td colspan="2">
						<p><strong>To Login in Dailyroll:</strong> 
						<br/>scan the QR code from your mobile device.
						</p>
					</td>
				</tr>
				<tr>
					<td><img id="barcode" src='.$qrCodeUrl.' width="180" height="180"/></td>
				</tr>';
		$message .= '</body></html>';

		$send=$user_home->send_mail($email,$subject,$message);
		//header('Content-Type: application/json');
		echo json_encode('Please Check mail for barcode');
	
	}



?>

