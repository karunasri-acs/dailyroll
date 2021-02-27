<?php
session_start();
include 'class_user.php';
$user_home= new USER ();
//$eventlog = EVENTLOG;

function event_log($text,$filename){
	if(EVENTLOG == Y){
		$text=$uid."\t".$text;
		$file = DIR_LOGS."dailyroll".date("Y-m-d").".log";
		error_log(date("[Y-m-d H:i:s]")."\t[INFO][".$filename."]\t".$text."\r\n", 3, $file);
	}		
	}
$response = array("error" => FALSE);
$data = json_decode(file_get_contents('php://input'), true);
event_log(json_encode($data),basename(__FILE__));
	if($data !=''){
if (isset($data['socialname'])&& isset($data['socialid'])) {
	$originalemail=$data['socialemail'];
	
	event_log($email,basename(__FILE__));
	$name=$data['socialname'];
	event_log($name,basename(__FILE__));
	$id=$data['socialid'];
	event_log($id,basename(__FILE__));
	
	$laststring = substr($id, -10);
	if($originalemail ==''){
	$originalemail=$id.'@dailyroll.org';
	
	}
	$date=date('Y-m-d');
	$laststring=$user_home->encrypted($laststring);
	$email=$user_home->encryptedstatic($originalemail);
	event_log($email,basename(__FILE__));
	if($originalemail !='' ){
		$emailcheck=$user_home->isEmailExists($email);
		event_log(json_encode($emailcheck),basename(__FILE__));
		if($emailcheck == 'null'){
				$uuid = uniqid('', true);
				$sql="INSERT INTO `users`( `unique_id`, `name`, `email`,`created_at`,`userStatus`,`phone`) VALUES ('$uuid','$name','$email',NOW(),'Y','$laststring')";
				event_log($sql,basename(__FILE__));
				$stmt = $user_home->runQuery($sql);
				$stmt->execute();
				$sql1="select * from users WHERE  `email` ='$email'";
				$stmt1 = $user_home->runQuery($sql1);
				$stmt1->execute();
				$user=$stmt1->fetch(PDO::FETCH_ASSOC);
				$response["error"] = FALSE;
				$response["message"] = "Loggined successfully";
				$response["uid"] = $user["unique_id"];
				$response["name"] = $user["name"];
				$response["email"] = $originalemail;
				$response["created_at"] = $user["created_at"];
			    $response["phone"] = $user["phone"];
				echo json_encode($response);
				event_log(json_encode($response),basename(__FILE__));
				 $user_id=$user["unique_id"];
				 $id=$user['user_id'];
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
		$stmt4 = $user_home->runQuery($sql4);
		$stmt4->execute();
		}
		else{
			event_log('else',basename(__FILE__));
			$response["error"] = FALSE;
			$response["message"] = "Loggined successfully";
			$response["uid"] = $emailcheck["unique_id"];
			$response["name"] = $emailcheck["name"];
			$response["email"] = $originalemail;
			$response["created_at"] = $emailcheck["created_at"];
			$response["phone"] = $emailcheck["phone"];
			echo json_encode($response);
			event_log(json_encode($response),basename(__FILE__));
		}
	}
	else {
    // required post params is missing
		$response["error"] = TRUE;
		$response["error_msg"] = "Required parameters is missing!";
		echo json_encode($response);
	//event_log1(json_encode($response));
        
	}
	}
	else {
    // required post params is missing
		$response["error"] = TRUE;
		$response["error_msg"] = "Required parameters missing!";
		echo json_encode($response);
	//event_log1(json_encode($response));
        
	}
}
else{
	if (isset($_POST['socialname']) && isset($_POST['socialid'])) {
	$originalemail=trim($_POST['socialemail']);
	event_log($originalemail,basename(__FILE__));
	$name=trim($_POST['socialname']);
	event_log($name,basename(__FILE__));
	$socialid=trim($_POST['socialid']);
	event_log($socialid,basename(__FILE__));
	$type=$_POST['socialtype'];
	event_log('type'.$type,basename(__FILE__));
	$laststring = substr($socialid, -10);
	if($originalemail =='' && $type !='APPLE'){
		$originalemail=$socialid.'@dailyroll.org';
	}
	$email=$user_home->encryptedstatic($originalemail);
	event_log('email'.$email,basename(__FILE__));
	$laststring=$user_home->encrypted($laststring);
	if($originalemail !='' ){
		event_log('email not null'.$type,basename(__FILE__));
			$emailcheck=$user_home->isEmailExists($email);
		$date=date('Y-m-d');
		event_log(json_encode($emailcheck),basename(__FILE__));
		if($emailcheck == 'null'){
				$uuid = uniqid('', true);
				if($type=='APPLE'){
				$sql="INSERT INTO `users`( `unique_id`, `name`, `email`,`created_at`,`userStatus`,`phone`,`appleid`) VALUES ('$uuid','$name','$email',NOW(),'Y','$laststring','$socialid')";
				}else{
				$sql="INSERT INTO `users`( `unique_id`, `name`, `email`,`created_at`,`userStatus`,`phone`) VALUES ('$uuid','$name','$email',NOW(),'Y','$laststring')";
					
				}
				event_log($sql,basename(__FILE__));
				$stmt = $user_home->runQuery($sql);
				$stmt->execute();
				$sql1="select * from users WHERE  `email` ='$email'";
				$stmt1 = $user_home->runQuery($sql1);
				$stmt1->execute();
				$user=$stmt1->fetch(PDO::FETCH_ASSOC);
				$response["error"] = FALSE;
				$response["message"] = "Loggined successfully";
				$response["uid"] = $user["unique_id"];
				$response["name"] = $user["name"];
				$response["email"] = $originalemail;
				$response["created_at"] = $user["created_at"];
			    $response["phone"] = $user["phone"];
				echo json_encode($response);
				event_log(json_encode($response),basename(__FILE__));
				 $user_id=$user["unique_id"];
				 $id=$user['user_id'];
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
		$stmt4 = $user_home->runQuery($sql4);
		$stmt4->execute();
		}
		else{
			event_log('type'.$type,basename(__FILE__));
			$uid=$emailcheck["unique_id"];
			if($type=='APPLE'){
				$updatesql="UPDATE  users SET  `appleid` ='$socialid' WHERE unique_id='$uid'";
				$stmt1 = $user_home->runQuery($updatesql);
				$stmt1->execute();
				event_log($updatesql,basename(__FILE__));
			}
			$userid=$emailcheck['user_id'];
			$check = $user_home->checkForSubscribe($userid);
			$result = $check['result'];
			if($result == "FALSE"){
				$response["error"] = TRUE;
			  	$response["uid"] = $emailcheck["unique_id"];
				$response["error_msg"] = "EXPIRED";
			  echo json_encode($response);
		   }else{
				event_log('else',basename(__FILE__));
				$response["error"] = FALSE;
				$response["message"] = "Loggined successfully";
				$response["uid"] = $emailcheck["unique_id"];
				$response["name"] = $emailcheck["name"];
				$response["email"] = $originalemail;
				$response["created_at"] = $emailcheck["created_at"];
				$response["phone"] = $emailcheck["phone"];
				echo json_encode($response);
			}	 
		}
	}
	
	elseif($type == "APPLE" ){
		$sql1="select * from users WHERE  `appleid` ='$socialid'";
		$stmt1 = $user_home->runQuery($sql1);
		$stmt1->execute();
		$user=$stmt1->fetch(PDO::FETCH_ASSOC);
		$userid=$user['user_id'];
		$check = $user_home->checkForSubscribe($userid);
		$result = $check['result'];
		if($result == "FALSE"){
		  $response["error"] = TRUE;
		  $response["uid"] = $user["unique_id"];
		  $response["error_msg"] = "EXPIRED";
		  echo json_encode($response);
	   }else{
			$response["error"] = FALSE;
			$response["message"] = "Loggined successfully";
			$response["uid"] = $user["unique_id"];
			$response["name"] = $user["name"];
			$response["email"] = $user_home->dencryptedstatic($user['email']);
			$response["created_at"] = $user["created_at"];
			$response["phone"] = $user["phone"];
			echo json_encode($response);
			event_log(json_encode($response),basename(__FILE__));
	   }
	
	}			

	else {  
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters are is missing!";
	echo json_encode($response);
	//event_log1(json_encode($response));
        
}
	
	}
else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters are missing!";
	echo json_encode($response);
	//event_log1(json_encode($response));
        
}
}
?>