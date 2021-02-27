<?php
 header("Access-Control-Allow-Origin: *");

//print_r($_REQUEST);
include 'class.user.php';
//require_once 'constants.php';
$user_home = new USER;
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->event_log('root file beginning ','d'); 

$request=file_get_contents('php://input');
$data = json_decode($request);

require_once 'googleLib/GoogleAuthenticator.php';
$ga = new GoogleAuthenticator();
$secret = $ga->createSecret();	

    event_log("begining of Register",'d');
    // receiving the post params
	$name=$data->firstname;
    $email=$data->email;
    $password=$data->password;
    $phone=$data->phone;
	event_log("after values get",'d');
    /*$name ='virtual';
    $email    ='vila@gmail.com';
    $password ='abc123';
    $phone = '8747847449';*/

    // check if user is already existed with the same email
    if ($user_home->isUserExisted($email)) {
        // user already existed
       // $data["error"] =TRUE;

		//header('Content-Type: application/json');
		$error='user already existed';
		echo json_encode($error);
		//event_log(json_encode($data));
    } else {
        // create a new user
		event_log("create a new user",'d');
        $user = $user_home->storeUser($name, $email, $password,$phone,$secret);
          if ($user) {
		$date=date('Y-m-d');
		 $user_id=$user["unique_id"];
		 $id=$user['user_id'];
		 	event_log($id,'d');
		$ex_date = date('Y-m-d', strtotime("+3 month", strtotime($date)));		
		$sql="INSERT INTO `accounts`(`user_id`, `accountname`, `date`, `accountstatus`) 
		VALUES ('$user_id','family','$date','active')";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		
	
		$code = $user_home->lasdID();
		$expense= array(
				'Food'=>array(
					'Cafes, Restaurants, Bars',
					'Tobacco and alcohol',
					'Groceries',
					'Other Groceries'
					
					),
				'Transportation'=>array(
					'Parking',
					'Fuel',
					'Vehicle purchase, maintenance',
					'Transportation expenses'
					),
				'Household'=>array(
					'House insurance',
					'Health expenses',
					'House / tenant insurance',
					'Property taxes',
					'Magazines / newspapers / books'
				),
				'Utility services'=>array(
					'Natural gas',
					'Electricity',
					'Telephone, internet, TV, computer',
					'Water',
					'Other utility expenses'
					)
				
		
		);
		foreach( $expense as $value=>$sub_cat ) {
			$sql1="INSERT INTO `category`(`cat_name`, `status`, `account_id`, `cat_type`)
			   VALUES ('$value','active','$code','expenses')";
			$stmt1 = $user_home->runQuery($sql1);
			$stmt1->execute();
			//echo $sql1;
			 $hello = $user_home->lasdID();
			//$i=1;
			foreach( $sub_cat as $sub_cat_name ){
				
				$sql5="INSERT INTO `sub_category`(`cat_id`, `subcat_name`, `amount`, `status`)
				   VALUES ('$hello','$sub_cat_name','1000','active')";
				$stmt5 = $user_home->runQuery($sql5);
				$stmt5->execute();
				//echo $sql5;
				
				
				}
		 }
		$income= array("Salary","Other incoming payments");
		foreach( $income as $values ) {
			$sql6="INSERT INTO `category`(`cat_name`, `status`, `account_id`, `cat_type`)
			   VALUES ('$values','active','$code','income')";
			$stmt6 = $user_home->runQuery($sql6);
			$stmt6->execute();
		}
		
		$sql1="INSERT INTO `groups`(`account_id`, `group_status`,`added_user_id`,`userstatus`)
		   VALUES ('$code','Y','$id','active')";
		$stmt1 = $user_home->runQuery($sql1);
		$stmt1->execute();	
		$sql2="INSERT INTO `subscriber`( `user_id`, `paiddate`, `expiry_date`)
		   VALUES ('$id','$date','$ex_date')";
		$stmt2 = $user_home->runQuery($sql2);
		$stmt2->execute();
		$sql3="INSERT INTO `profile`(`user_id`,`name`, `email`, `phone`)VALUES ('$id','$name','$email','$phone')";
		$stmt3 = $user_home->runQuery($sql3);
		$stmt3->execute();
			$id=$user["user_id"];
			$code = $user["unique_id"];
			$fname = $user["name"];
			$sql4="SELECT * FROM `users` WHERE `email`='$email'";
			$stmt4 = $user_home->runQuery($sql4);
			$stmt4->execute();
			$userRow4=$stmt4->fetch(PDO::FETCH_ASSOC);
			$secret=$userRow4['google_auth_code'];			
			$qrCodeUrl = $ga->getQRCodeGoogleUrl($email, $secret,'DailyRoll App');
			$key = base64_encode($id);
			$message = "					
					Hello $fname,
						<br /><br />
						Welcome to Daillyroll!<br/>
						To complete your registration  please , just click following link<br/>
						<br /><br />
						<a href=".REG_URL."verify.php?id=$key&code=$code>Click HERE to Activate :)</a>
						<br /><br />
						Thanks,";	
			$message .= '<html><body>';
		
		$message .= '	<tr>
					<td colspan="2">
						<p><strong>To Login in Dailyroll:</strong> 
						<br/>scan the QR code from your mobile device.
						</p>
					</td>
				</tr>
				<tr>
					<td><img id="barcode" src='.$qrCodeUrl.'  width="180" height="180"/></td>
				</tr>';
		$message .= '</body></html>';
			$subject = "Confirm Registration";
				//echo"sdgshag";	
				event_log("before mail sent",'d');				
			$decryptemail=$user_home->dencryptedstatic($email);
			$user_home->send_mail($decryptemail,$subject,$message);
				$data='Registered Successfully';
				echo json_encode($data);
				   event_log(json_encode($data),'d');
			
        }
		else {
            //$data["error"] =TRUE;
			$dataarray = 'unknown';
			//header('Content-Type: application/json');
			echo json_encode($dataarray);
			//event_log(json_encode($data));
  
        }
    }

?>