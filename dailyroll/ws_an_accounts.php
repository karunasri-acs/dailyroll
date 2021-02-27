<?php
header("Access-Control-Allow-Origin: *");
include 'class.user.php';
$db = new USER();
// Get the posted data.
$request=file_get_contents('php://input');
$data = json_decode($request);

//$uid="5c33c2262050b0.40319083";
$uid=$data->uid;
  
$account_id=$data->accountid;
$memberemail=$data->memberemail;
$membername=$data->membername;
$memberphoneno=$data->memberphoneno;
//$accountname=$data->accountname;
$accountname=$data->accountname;
$currency=$data->currency;

$memberid=$data->memberid;
$memid=$db->getuserdata($memberid);
$captureid=$memid['unique_id'];
$lid=$data->userid;

//$account_id='2';
function event_log($text){

    	$uid=$_SESSION['unique_ID'];
	$text=$uid."\t".$text;	
	$file = "logs/dailyrollaccounts".date("Y-m-d").".log";
	error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3, $file);	
	
}
$u_id=$db->getuserid($uid);
 /*
if(!$data == ''){*/
	$q=$data->q;
//	$q =6;
	event_log($q);
    if($q == 1){
        //get Admin Cases		
		$sql="SELECT  b.user_id,a.account_id,b.accountname,b.date,b.accountstatus FROM  groups a,accounts b WHERE  a.`account_id`=b.account_id AND a.`added_user_id`='$u_id' group by a.account_id";
		event_log($sql);
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		
		$cars[]=$row;
		}
		echo json_encode($cars);
	}
	elseif($q  == 2){
		$details=$db->get_accountdetails($account_id);
		 $account_name = $details['accountname'];
		 $captid = $details['user_id'];
		 $userid=$db->getUseridByUniq($captid);
		$sql1="SELECT a.added_user_id,a.userstatus,a.group_status,b.user_id FROM `groups` a , accounts b  WHERE  a.`account_id`=b.`account_id`  and a.`account_id`='$account_id'";
		 
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		//echo $sql1;
		
		event_log($sql1);
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
		$adduserid=$row['added_user_id'];
		$isid=$row['user_id'];
		$groupstatus=$row['group_status'];
		$userstatus=$row['userstatus'];
		$familydata=$db->getuserdata($adduserid);
			$name=$familydata['name'];
			$email=$familydata['email'];
			$phone=$familydata['phone'];
			$unid=$familydata['unique_id'];
			if($adduserid == $userid){
			$adminid="admin";
			}else{
			$adminid="member";
			}
			
			
			$data=[
			 'add_user_id' => $adduserid,
			 'account_name' => $account_name,
			  'email' => $email,
			  'name'    => $name,
			  'phone' => $phone,
			  'groupstatus' => $groupstatus,
			  'userstatus' => $userstatus,
			  'adminstatus' =>$adminid,
			  'uniqid'=>$isid,
			  'unique_id'=>$adduserid,
			 
			];
			$output[]=$data;
		}
			
	echo json_encode($output);
	event_log(json_encode($output));
		
	}
	elseif($q  == 3){
	 $sql="SELECT * FROM `expenses` a,sub_category b WHERE a.capture_id='$captureid' and a.subcat_id=b.subcat_id and a.account_id='$account_id' and permissionflag !='archive'";
	 event_log($sql);
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
	$sql="INSERT INTO `accounts`(`user_id`, `currcode`, `accountname`, `date`, `accountstatus`) VALUES ('$uid','$currency','$accountname','$date','active')";
	 event_log($sql);
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
	$sql1="UPDATE `accounts` SET `accountname`='$accountname',`currcode`='$currency' WHERE account_id='$account_id'";
	 event_log($sql1);
	$stmt1 = $db->runQuery($sql1);
	$stmt1->execute();
	echo  json_encode('Updated Successfully');
	}
	elseif($q  == 6){
		$details=$db->get_accountdetails($account_id);
			$account_id=$details['account_id'];
		$user_id=$details['user_id'];
		$accountname=$details['accountname'];		 
		$currcode=$details['currcode'];
		
		if($user_id==$uid){ 
		$admin='admin';
		}else{
		$admin='member';
		}
		$data=[
			
			 'account_id' => $account_id,
			 'user_id'    => $user_id,
			'accountname'    => $accountname,
			'currcode'    => $currcode,
			'status'    => $admin,
			
	  
			];
		$output[]=$data;
		
		echo json_encode($output);
 event_log(json_encode($output));		
	}
	elseif($q  == 8){
	$lid=$data->userid;
    $sql2="UPDATE `groups` SET `userstatus`='inactive' WHERE added_user_id='$lid' and account_id='$account_id'";
	event_log($sql2);
	$stmt2 = $db->runQuery($sql2);
	$stmt2->execute();
		echo json_encode('User In-activated Successfully');
			
	}
	elseif($q  == 9){
	$lid=$data->userid;	
	$unid=$db->getuserdata($lid);
	$uid=$unid['unique_id'];
	$sql2="UPDATE `accounts` SET `user_id`='$uid' WHERE  account_id='$account_id'";
	event_log($sql2);
	$stmt2 = $db->runQuery($sql2);
	$stmt2->execute();
		echo json_encode('Successfully Admin Changed');
			
	}
	elseif($q  == 7){
			$sql2="select * from users where email='$memberemail'";
			event_log($sql2);
	$stmt2 = $db->runQuery($sql2);
	$stmt2->execute();
	//echo $sql2;
	$stmt2->rowCount();
	$userRow=$stmt2->fetch(PDO::FETCH_ASSOC);
	if($stmt2->rowCount() >= 1){
	//echo"dhj";
$phone=$userRow['phone'];
	if ($phone == $memberphoneno){
	event_log("phone number verified");
$addid=$userRow['user_id'];
$sql3="select * from `groups` where `added_user_id`='$addid' and `account_id`='$account_id'";
	$stmt3= $db->runQuery($sql3);
	$stmt3->execute();
	//echo $sql3;
	event_log($sql3);
	$stmt3->rowCount();
	if($stmt3->rowCount() == 0){
	event_log($account_id);
	$accontdetails=$db->get_accountdetails($account_id);
	
	$accountname=$accontdetails['accountname'];
	event_log($accountname);
	$userd=$accontdetails['user_id'];
	event_log($userd);
	$holdername=$db->getname($userd);
	event_log($holdername);
	 $sql="INSERT INTO `groups`(`account_id`,`group_status`, `added_user_id`,`userstatus` ) 
	VALUES ('$account_id','N','$addid','active')";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	event_log($sql);
	//echo $sql;
	$code = $db->lasdID();
	$key=base64_encode($addid);
	 	$message = "					
					Hello,
					<br /><br />
					DailyRoll Admin : $holdername added you as a member to Account : $accountname<br/>
					<br /><br />
					<a href=".REG_URL."accept.php?id=$key&code=$code>Click HERE to Accept :)</a><br /><br />
					Thank You,";
						
		$subject = "DailyRoll Request";
		event_log("before mail sent");
		$db->send_mail($memberemail,$subject,$message);
			event_log("after mail sent");
			echo  json_encode('Member added  Successfully');
		
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
	event_log($sql2);
	  $stmt2 = $db->runQuery($sql2);
	  $stmt2->execute();
	$sql1="UPDATE `accounts` SET `accountstatus`='inactive' WHERE account_id='$account_id'";
	event_log($sql1);
	$stmt1 = $db->runQuery($sql1);
	$stmt1->execute();
	
	echo  json_encode('Account In-Activated Successfully');
	
	
	
	}
	elseif($q==11){
	$sql2="UPDATE `groups` SET `account_status`='active' WHERE `account_id`='$account_id'";	
	event_log($sql2);
	  $stmt2 = $db->runQuery($sql2);
	  $stmt2->execute();
	$sql1="UPDATE `accounts` SET `accountstatus`='active' WHERE account_id='$account_id'";
	event_log($sql1);
	$stmt1 = $db->runQuery($sql1);
	$stmt1->execute();
	
	echo  json_encode('Account Activated Successfully');
	}
	elseif($q==12){
    $sql2="UPDATE `groups` SET `userstatus`='active' WHERE added_user_id='$lid' and account_id='$account_id'";
	event_log($sql2);
	$stmt2 = $db->runQuery($sql2);
	$stmt2->execute();
	
	echo  json_encode('User Activated Successfully');
	
	
	
	}
	elseif($q==13){
    $sql="SELECT b.user_id,b.account_id,b.accountname,b.date,b.accountstatus FROM groups a,accounts b WHERE b.`user_id`='$uid' AND b.accountstatus!='active' group by b.`account_id`
";
	event_log($sql);
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	event_log($sql);
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		
		$cars[]=$row;
		event_log($cars);
		}
		echo json_encode($cars);
		event_log(json_encode($cars));		
	//echo  json_encode('User Activated Successfully');
	}
	elseif($q==14){
	event_log("expenses list");
    $sql="SELECT * FROM `expenses`a,accounts b,category c,sub_category d WHERE  a.account_id='$account_id' and a.account_id = b.account_id and a.cat_id=c.cat_id and a.subcat_id = d.subcat_id ORDER BY a.id DESC";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	event_log($sql);
	//echo $sql;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		
		$cars[]=$row;
		event_log($cars);
		}
		echo json_encode($cars);
	event_log(json_encode($cars));		
	//echo  json_encode('User Activated Successfully');
	}
	elseif($q==15){
	event_log("income list");
		$sql = "SELECT * FROM `income` a,accounts b,category c,sub_category d WHERE a.account_id = '$account_id' and a.account_id = b.account_id and a.cat_id=c.cat_id and a.subcat_id = d.subcat_id ORDER BY a.income_id DESC" ;
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		event_log($sql);
	//echo $sql;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		
		$cars[]=$row;
		event_log($cars);
		}
		echo json_encode($cars);
	event_log(json_encode($cars));		
	//echo  json_encode('User Activated Successfully');
	}	
	
	
/*}
else{
		echo json_encode('error');
	}*/

?>


