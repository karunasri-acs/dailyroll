<?php
header("Access-Control-Allow-Origin: *");
include 'class.user.php';
$db = new USER();
// Get the posted data.
$request=file_get_contents('php://input');
$data = json_decode($request);

//$uid="5c33c2262050b0.40319083";

//$account_id='2';
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 

 /*
if(!$data == ''){*/
	$q=$data->q;
//	$q =6;
	$log->event_log($q,'d');
    if($q == 1){
	$email=$data->email;
	$log->event_log($email,'d');
	$password=$data->password;
	$log->event_log($password,'d');
	$datas=[];
        //get Admin Cases		
		$user = $db->login1($email,$password);

    if ($user) {
        // use is found
        //$data["error"] = FALSE;
		
       $datas["uid"] = $user["unique_id"];
       $datas["userid"] = $user["user_id"];
      $datas["usertype"]=$user["usertype"];
	
		$dataarray[] = $datas;
		  echo json_encode($dataarray);
	
    }
	
	}
	elseif($q  == 2){
		$accountid=$data->accountid;
		$type=$data->type;
		$name=$data->name;
		
		 $sql="INSERT INTO `category`(`cat_name`, `status`, `account_id`, `cat_type`) VALUES ('$name','active','$accountid','$type')";
	$stmt = $db->runQuery($sql);
	$stmt->execute();

	echo json_encode('Category added Successfully');
	$log->event_log(json_encode($output),'d');
		
	}
	elseif($q  == 3){
	 $sql="SELECT * FROM `expenses` a,sub_category b WHERE a.capture_id='$captureid' and a.subcat_id=b.subcat_id and a.account_id='$account_id' and permissionflag !='archive'";
	 $log->event_log($sql,'d');
		//SELECT * FROM `expenses` a,sub_category b WHERE a.capture_id='5c2dcee2e21538.17188314' and a.subcat_id=b.subcat_id and a.account_id='2' and a.permissionflag !='archive'
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//echo $sql;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 

		 $amount=$row['amount'];
		 $date=$row['tr_date'];
		 $description=$row['description'];
		 $catname=$row['subcat_name'];
		// $catname=$db->get_subcategory($sub_id);
		
		$data=[
			 'amount' => $amount,
			 'date' => $date,
			 'description' => $description,
			'catname'    => $catname
	  
			];
			$output[]=$data;
		}
	
	echo json_encode($output);
	}
	elseif($q  == 4){
	$date=date('Y-m-d');
	$sql="INSERT INTO `accounts`(`user_id`, `accountname`, `date`, `accountstatus`) VALUES ('$uid','$accountname','$date','active')";
	 $log->event_log($sql,'d');
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	$code = $db->lasdID();
	$sql1="INSERT INTO `groups`(`account_id`, `group_status`, `added_user_id`,`userstatus`)
		   VALUES ('$code','Y','$u_id','active')";
	$stmt1 = $db->runQuery($sql1);
	$stmt1->execute();
		echo json_encode('Added Successfully');
	}
	elseif($q  == 5){
	$account_id=$data->account_id;
	$accountname=$data->accountname;
	$sql1="UPDATE `accounts` SET `accountname`='$accountname' WHERE account_id='$account_id'";
	 $log->event_log($sql1,'d');
	$stmt1 = $db->runQuery($sql1);
	$stmt1->execute();
	echo  json_encode('Updated Successfully');
	}
	elseif($q  == 6){
		$details=$db->get_accountdetails($account_id);
			$account_id=$details['account_id'];
		$user_id=$details['user_id'];
		$accountname=$details['accountname'];		 
		if($user_id==$uid){ 
		$admin='admin';
		}else{
		$admin='member';
		}
		$data=[
			
			 'account_id' => $account_id,
			 'user_id'    => $user_id,
			'accountname'    => $accountname,
			'status'    => $admin,
			
	  
			];
		$output[]=$data;
		
		echo json_encode($output);
 $log->event_log(json_encode($output),'d');		
	}
	elseif($q  == 8){
	$lid=$data->userid;
    $sql2="UPDATE `groups` SET `userstatus`='inactive' WHERE added_user_id='$lid' and account_id='$account_id'";
	$log->event_log($sql2,'d');
	$stmt2 = $db->runQuery($sql2);
	$stmt2->execute();
		echo json_encode('User In-activated Successfully');
			
	}
	elseif($q  == 9){
	$lid=$data->userid;	
	$unid=$db->getuserdata($lid);
	$uid=$unid['unique_id'];
	$sql2="UPDATE `accounts` SET `user_id`='$uid' WHERE  account_id='$account_id'";
	$log->event_log($sql2,'d');
	$stmt2 = $db->runQuery($sql2);
	$stmt2->execute();
		echo json_encode('Successfully Admin Changed');
			
	}
	elseif($q  == 7){
			$sql2="select * from users where email='$memberemail'";
			$log->event_log($sql2,'d');
	$stmt2 = $db->runQuery($sql2);
	$stmt2->execute();
	//echo $sql2;
	$stmt2->rowCount();
	$userRow=$stmt2->fetch(PDO::FETCH_ASSOC);
	if($stmt2->rowCount() >= 1){
	//echo"dhj";
$phone=$userRow['phone'];
	if ($phone == $memberphoneno){
	$log->event_log("phone number verified",'d');
$addid=$userRow['user_id'];
$sql3="select * from `groups` where `added_user_id`='$addid' and `account_id`='$account_id'";
	$stmt3= $db->runQuery($sql3);
	$stmt3->execute();
	//echo $sql3;
	$log->event_log($sql3,'d');
	$stmt3->rowCount();
	if($stmt3->rowCount() == 0){
	 $sql="INSERT INTO `groups`(`account_id`,`group_status`, `added_user_id`,`userstatus` ) 
	VALUES ('$account_id','N','$addid','active')";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,'d');
	//echo $sql;
	$code = $db->lasdID();
	$key=base64_encode($addid);
	 	$message = "					
					Hello,
					<br /><br />
					Your Family member added your account into his family group <br/>
					To complete your registration  please , just click following link<br/>
					<br /><br />
					<a href=".REG_URL."accept.php?id=$key&code=$code>Click HERE to Accept :)</a><br /><br />
					Thanks,";
						
		$subject = "Family request";
		$log->event_log("before mail sent",'d');
		$db->send_mail($memberemail,$subject,$message);
			$log->event_log("after mail sent",'d');
			echo  json_encode('member added  Successfully');
		
	}
	else
	{
	  
echo  json_encode(' you  already added this person into group');			  
	}
	
	}
	else
	{
	echo  json_encode('Phone Number wrong please enter right Phone Number');			  
	  
	}
	}
	else{
  
		echo  json_encode('There is no user with this email');			  
		  
	}	
	}
	elseif($q==10){
	$sql2="UPDATE `groups` SET `account_status`='inactive' WHERE `account_id`='$account_id'";	
	$log->event_log($sql2,'d');
	  $stmt2 = $db->runQuery($sql2);
	  $stmt2->execute();
	$sql1="UPDATE `accounts` SET `accountstatus`='inactive' WHERE account_id='$account_id'";
	$log->event_log($sql1,'d');
	$stmt1 = $db->runQuery($sql1);
	$stmt1->execute();
	
	echo  json_encode('Account In-Activated Successfully');
	
	
	
	}
	elseif($q==11){
	$sql2="UPDATE `groups` SET `account_status`='active' WHERE `account_id`='$account_id'";	
	$log->event_log($sql2,'d');
	  $stmt2 = $db->runQuery($sql2);
	  $stmt2->execute();
	$sql1="UPDATE `accounts` SET `accountstatus`='active' WHERE account_id='$account_id'";
	$log->event_log($sql1,'d');
	$stmt1 = $db->runQuery($sql1);
	$stmt1->execute();
	
	echo  json_encode('Account Activated Successfully');
	}
	elseif($q==12){
    $sql2="UPDATE `groups` SET `userstatus`='active' WHERE added_user_id='$lid' and account_id='$account_id'";
	$log->event_log($sql2,'d');
	$stmt2 = $db->runQuery($sql2);
	$stmt2->execute();
	
	echo  json_encode('User Activated Successfully');
	
	
	
	}
	elseif($q==13){
    $sql="SELECT b.user_id,b.account_id,b.accountname,b.date,b.accountstatus FROM groups a,accounts b WHERE b.`user_id`='$uid' AND b.accountstatus!='active' group by b.`account_id`
";
	$log->event_log($sql,'d');
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,'d');
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		
		$cars[]=$row;
		$log->event_log($cars,'d');
		}
		echo json_encode($cars);
		$log->event_log(json_encode($cars),'d');		
	//echo  json_encode('User Activated Successfully');
	}
	elseif($q==14){
	$log->event_log("expenses list",'d');
    $sql="SELECT * FROM `expenses`a,accounts b,category c,sub_category d WHERE  a.account_id='$account_id' and a.account_id = b.account_id and a.cat_id=c.cat_id and a.subcat_id = d.subcat_id ORDER BY a.id DESC";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,'d');
	//echo $sql;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		
		$cars[]=$row;
		$log->event_log($cars,'d');
		}
		echo json_encode($cars);
	$log->event_log(json_encode($cars),'d');		
	//echo  json_encode('User Activated Successfully');
	}
	elseif($q==15){
	$log->event_log("income list",'d');
		$sql = "SELECT * FROM `income` a,accounts b,category c,sub_category d WHERE a.account_id = '$account_id' and a.account_id = b.account_id and a.cat_id=c.cat_id and a.subcat_id = d.subcat_id ORDER BY a.income_id DESC" ;
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		$log->event_log($sql,'d');
	//echo $sql;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		
		$cars[]=$row;
		$log->event_log($cars,'d');
		}
		echo json_encode($cars);
	$log->event_log(json_encode($cars),'d');		
	//echo  json_encode('User Activated Successfully');
	}	
	
	
/*}
else{
		echo json_encode('error');
	}*/

?>


