<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
$response = array("error" => FALSE);
 

$data = json_decode(file_get_contents('php://input'), true);
if($data != ''){
if (isset($data['name']) && isset($data['email']) && isset($data['password'])&& isset($data['phone'])) {
    $log->event_log("begining of Register",'d');
    // receiving the post params
    $name = trim($data['name']);
	$log->event_log($name,'d');
	$orginalemail = trim($data['email']);
	$log->event_log($email,'d');
	$password = trim($data['password']);
	$log->event_log($password,'d');
	$phone = trim($data['phone']);
	$log->event_log($phone,'d');
	/*$name = 'karuna';
	$email = 'k2@gmail.com';
	$password = 'abc123';
	$phone = '7934542301';
	*/
$email=$user_home->encryptedstatic($orginalemail);
      // check if user is already existed with the same email
    if ($user_home->isUserExisted($email,$phone)) {
        // user already existed
        $response["error"] = TRUE;
        $response["message"] = "User already existed with " . $email." or ".$phone;
        echo json_encode($response);
		$log->event_log(json_encode($response),'e');
    } 
	else {
        // create a new user
        $user = $user_home->storeUser($name,$email,$password,$phone);
        if ($user) {
		$date=date('Y-m-d');
		 $user_id=$user["unique_id"];
		 $id=$user['user_id'];
		
		
            // user stored successfully
           $response["error"] = FALSE;
			$response["message"] = "Registerd successfully";
			
	    //echo json_encode($response);
		//$log->event_log(json_encode($response));
		$ex_date = date('Y-m-d', strtotime("+3 month", strtotime($date)));		
		$sql="INSERT INTO `accounts`(`user_id`, `accountname`, `date`, `accountstatus`) 
		VALUES ('$user_id','family','$date','active')";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		//echo $sql;
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
		 
		$sql2="INSERT INTO `groups`(`account_id`, `group_status`,`added_user_id`,`userstatus`)
		   VALUES ('$code','Y','$id','active')";
		$stmt2 = $user_home->runQuery($sql2);
		$stmt2->execute();	
		//echo $sql2;
		$sql3="INSERT INTO `subscriber`( `user_id`, `paiddate`, `expiry_date`)
		   VALUES ('$id','$date','$ex_date')";
		$stmt3 = $user_home->runQuery($sql3);
		$stmt3->execute();
		//echo $sql3;
		$sql4="INSERT INTO `profile`(`user_id`,`name`, `email`, `phone`)VALUES ('$id','$name','$email','$phone')";
		$log->event_log($sql4,'d');
		$stmt4 = $user_home->runQuery($sql4);
		$stmt4->execute();
		//echo $sql4;
			$id=$user["user_id"];
			$code = $user["unique_id"];
			$fname =$user_home->dencrypted($user["name"]);
			$key = base64_encode($id);
			$message = "					
					Hello $fname,
						<br /><br />
						Welcome to Daillyroll!<br/>
						To complete your registration  please , just click following link<br/>
						<br /><br />
						<a href=".MOBREG_URL."verify.php?id=$key&code=$code>Click HERE to Activate :)</a>
						<br /><br />
						Thanks,";	
			$subject = "Confirm Registration";
				//echo"sdgshag";	
		$log->event_log("mail starting",'d');				
			$user_home->send_mail($orginalemail,$subject,$message);
			//echo"gftrte";
            //echo json_encode($response);
			$log->event_log("mailsent",'d');
			
		echo json_encode($response);
		$log->event_log(json_encode($response),'d');					
			
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
			$log->event_log(json_encode($response),'d');
  
        }
    }
} else {
    $response["error"] = TRUE;
    $response["message"] = "Required parameters (name, email,phone or password) is missing!";
    echo json_encode($response);
	$log->event_log(json_encode($response),'d');
  
}
}else{
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])&& isset($_POST['phone'])) {
    $log->event_log("begining of Register",'d');
    // receiving the post params
    $name = trim($_POST['name']);
	$orginalemail = trim($_POST['email']);
	$password = trim($_POST['password']);
	$phone = trim($_POST['phone']);
	/*$name = 'karuna';
	$email = 'k2@gmail.com';
	$password = 'abc123';
	$phone = '7934542301';
	*/
	$email=$user_home->encryptedstatic($orginalemail);
      // check if user is already existed with the same email
    if ($user_home->isUserExisted($email,$phone)) {
        // user already existed
        $response["error"] = TRUE;
        $response["message"] = "User already existed with " . $email." or ".$phone;
        echo json_encode($response);
		$log->event_log(json_encode($response),'d');
    } 
	else {
        // create a new user
        $user = $user_home->storeUser($name,$email,$password,$phone);
        if ($user) {
		$date=date('Y-m-d');
		 $user_id=$user["unique_id"];
		 $id=$user['user_id'];
		
		
            // user stored successfully
            $response["error"] = FALSE;
			$response["message"] = "Registerd successfully";
            $response["uid"] = $user["unique_id"];
            $response["name"] = $user["name"];
            $response["email"] = $user["email"];
            $response["created_at"] = $user["created_at"];
            $response["updated_at"] = $user["updated_at"];
            $response["phone"] = $user["phone"];
	    //echo json_encode($response);
		//$log->event_log(json_encode($response));
		$ex_date = date('Y-m-d', strtotime("+3 month", strtotime($date)));		
		$sql="INSERT INTO `accounts`(`user_id`, `accountname`, `date`, `accountstatus`) 
		VALUES ('$user_id','family','$date','active')";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		//echo $sql;
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
		 
		$sql2="INSERT INTO `groups`(`account_id`, `group_status`,`added_user_id`,`userstatus`)
		   VALUES ('$code','Y','$id','active')";
		$stmt2 = $user_home->runQuery($sql2);
		$stmt2->execute();	
		//echo $sql2;
		$sql3="INSERT INTO `subscriber`( `user_id`, `paiddate`, `expiry_date`)
		   VALUES ('$id','$date','$ex_date')";
		$stmt3 = $user_home->runQuery($sql3);
		$stmt3->execute();
		//echo $sql3;
		$sql4="INSERT INTO `profile`(`user_id`,`name`, `email`, `phone`)VALUES ('$id','$name','$email','$phone')";
		$log->event_log($sql4,'d');
		$stmt4 = $user_home->runQuery($sql4);
		$stmt4->execute();
		//echo $sql4;
			$id=$user["user_id"];
			$code = $user["unique_id"];
			$fname = $user_home->dencrypted($user["name"]);
			$key = base64_encode($id);
			$message = "					
					Hello $fname,
						<br /><br />
						Welcome to Daillyroll!<br/>
						To complete your registration  please , just click following link<br/>
						<br /><br />
						<a href=".MOBREG_URL."verify.php?id=$key&code=$code>Click HERE to Activate :)</a>
						<br /><br />
						Thanks,";	
			$subject = "Confirm Registration";
				//echo"sdgshag";	
		$log->event_log("mail starting",'d');				
			$user_home->send_mail($orginalemail,$subject,$message);
			//echo"gftrte";
            //echo json_encode($response);
			$log->event_log("mailsent",'d');
				$log->event_log('else',basename(__FILE__),'d');
	    echo json_encode($response);
		$log->event_log(json_encode($response),'d');
						
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["message"] = "Unknown error occurred in registration!";
            echo json_encode($response);
			$log->event_log(json_encode($response),'e');
  
        }
    }
} else {
    $response["error"] = TRUE;
    $response["message"] = "Required parameters (name, email,phone or password) is missing!";
    echo json_encode($response);
	$log->event_log(json_encode($response),'e');
  
}


}
?>

