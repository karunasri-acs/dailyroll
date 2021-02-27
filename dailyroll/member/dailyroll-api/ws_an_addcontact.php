<?php
 header("Access-Control-Allow-Origin: *");
	include 'class.user.php';
	$db = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
 function RemoveSpecialChar($str) {
      $res = str_replace( array( '\'', '"',',' , ';', '<', '>','-' ), ' ', $str);   
	  return $res; 
    } 
	$request=file_get_contents('php://input');
	$data = json_decode($request);
	$log->event_log(json_encode($data),'d');
	$q=$data->q;
	if($q==1){
		
		$accountid=$data->selectaccountid;
		$contactemail=$data->contactemail;
		$contactname=$data->contactname;
		$contactaddress=$data->contactaddress;
		$contactphone=$data->contactphone;
		$sql="INSERT INTO `contact`(`id`, `name`, `email`, `address`, `phone`, `type`) VALUES ('$accountid','$contactname','$contactemail','$contactaddress','$contactphone','business')";
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
			echo json_encode('Contact Saved Sucessfully');

	
	} 
	else if($q==2){
		
		$accountid=$data->selectaccountid;
		
		$sql="SELECT  *  from `contact` WHERE id='$accountid' and type='business'";
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
		$output[]=$row;
		}
			
	echo json_encode($output);
	//$log->event_log(json_encode($output));
	
	}
	else if($q==3){
		
		$accountid=$data->selectaccountid;
		$contactemail=$data->contactemail;
		$contactname=$data->contactname;
		$contactaddress=$data->contactaddress;
		$contactphone=$data->contactphone;
		$sql="INSERT INTO `contact`(`id`, `name`, `email`, `address`, `phone`, `type`) VALUES ('$accountid','$contactname','$contactemail','$contactaddress','$contactphone','account')";
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
			echo json_encode('Contact Saved Sucessfully');

	
	} 
	else if($q==4){
		
		$accountid=$data->selectaccountid;
		
		$sql="SELECT  *  from `contact` WHERE id='$accountid' and type='account'";
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
		$output[]=$row;
		}
			
	echo json_encode($output);
	//$log->event_log(json_encode($output));
	
	}
	else if($q==5){
		
		$accountid=$data->selectaccountid;
		$contactemail=$data->contactemail;
		$contactname=$data->contactname;
		$contactaddress=$data->contactaddress;
		$contactphone=$data->contactphone;
		$sql="INSERT INTO `contact`(`id`, `name`, `email`, `address`, `phone`, `type`) VALUES ('$accountid','$contactname','$contactemail','$contactaddress','$contactphone','sub-account')";
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
			echo json_encode('Contact Saved Sucessfully');

	
	} 
	else if($q==6){
		
		$accountid=$data->selectaccountid;
		
		$sql="SELECT  *  from `contact` WHERE id='$accountid' and type='sub-account'";
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
		while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
		$output[]=$row;
		}
			
	echo json_encode($output);
	//$log->event_log(json_encode($output));
	
	}
	
	else if($q==7){

			$accountid=$data->selectaccountid;
			$contactemail=$data->contactemail;
			$contactname=$data->contactname;
			$contactaddress=$data->contactaddress;
			$contactphone=$data->contactphone;
			$type=$data->selecttype;
			$date=date('Y-m-d');
			try{
				$contactphone=RemoveSpecialChar($contactphone);
			$sql="INSERT INTO `contact`(`id`, `name`, `email`, `address`, `phone`, `type`,`adddate`) VALUES ('$accountid','$contactname','$contactemail','$contactaddress','$contactphone','$type','$date')";
			$log->event_log($sql,'d');
			$stmt1 = $db->runQuery($sql);
			$stmt1->execute();
				echo json_encode('Contact Saved Sucessfully');
			}
		catch(PDOException $ex)
			  {
			   echo json_encode('Error While Adding');
			  }

	}
	else if($q==8){

			$accountid=$data->selectaccountid;
			$type=$data->selecttype;
			
			$sql="SELECT  *  from `contact` WHERE id='$accountid' and type='$type'";
			$stmt1 = $db->runQuery($sql);
			$stmt1->execute();
			$rowcount=$stmt1->rowcount();
			if($rowcount >0){
			while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
			$output[]=$row;
			}
				
		echo json_encode($output);
			}else{
echo json_encode('empty');
				
			}


	}
	else if($q==9){

			$accountid=$data->selectaccountid;
			$type=$data->selecttype;
			$name=$data->selectname;
			if($type=='business'){
				$sql="UPDATE `accounts` SET `accountname`='$name' WHERE `account_id`='$accountid'";
				
			}else if($type=='account'){
				
				$sql="UPDATE `category` SET `cat_name`='$name' WHERE `cat_id`='$accountid'";
			}
			elseif($type=='sub-account'){
		
				$sql="UPDATE `sub_category` SET `subcat_name`='$name' WHERE  `subcat_id`='$accountid'";		
			}
			$log->event_log($sql,'d');
			$stmt1 = $db->runQuery($sql);
			$stmt1->execute();
			$log->event_log($sql,'d');
			echo json_encode('updated Sucessfully');


	}
	else if($q==10){
		$accountid=$data->selectaccountid;
		$type=$data->selectname;
		$name=$data->addname;
		if($type=='Expenses'){
			$sql="INSERT INTO `category`( `cat_name`, `status`, `account_id`, `cat_type`) VALUES ('$name','active','$accountid','expenses')";
			
		}else if($type=='Income'){
			
			$sql="INSERT INTO `category`(`cat_name`, `status`, `account_id`, `cat_type`) VALUES ('$name','active','$accountid','income')";
		}
		$log->event_log($sql,'d');
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
		$log->event_log($sql,'d');
		echo json_encode('Added Sucessfully');


	}
	else if($q==11){
		$accountid=$data->selectaccountid;
		$name=$data->addaccname;
		$amount=$data->addamount;
		$sql="INSERT INTO `sub_category`(`cat_id`, `subcat_name`, `amount`, `status`) VALUES ('$accountid','$name','$amount','active')";
		$log->event_log($sql,'d');
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
		$log->event_log($sql,'d');
		echo json_encode('Added Sucessfully');


	}
	
	else if($q==12){
		$accountid=$data->selectaccountid;
		$type=$data->selecttype;
		$name=$data->selectname;
		$amount=$data->selectamount;
		$sql="UPDATE `sub_category` SET `subcat_name`='$name',amount='$amount' WHERE  `subcat_id`='$accountid'";		
	
		$log->event_log($sql,'d');
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
		$log->event_log($sql,'d');
		echo json_encode('Updated Sucessfully');


	}
	
	else if($q==13){
		$accountid=$data->selectaccountid;
		$type=$data->selecttype;
		
		if($type=='business'){
				$sql="UPDATE `accounts` SET `accountstatus`='active' WHERE `account_id`='$accountid'";
				
			}else if($type=='account'){
				
				$sql="UPDATE `category` SET `status`='active'  WHERE `cat_id`='$accountid'";
			}
			elseif($type=='sub-account'){
		
				$sql="UPDATE `sub_category` SET `status`='active'  WHERE  `subcat_id`='$accountid'";		
			}
		$log->event_log($sql,'d');
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
		$log->event_log($sql,'d');
		echo json_encode('Updated Sucessfully');


	}
	
	else if($q==14){
		$accountid=$data->selectaccountid;
		$type=$data->selecttype;
		
		
		if($type=='business'){
				$sql="UPDATE `accounts` SET `accountstatus`='inactive' WHERE `account_id`='$accountid'";
				
			}else if($type=='account'){
				
				$sql="UPDATE `category` SET `status`='inactive'  WHERE `cat_id`='$accountid'";
			}
			elseif($type=='sub-account'){
		
				$sql="UPDATE `sub_category` SET `status`='inactive'  WHERE  `subcat_id`='$accountid'";		
			}
		$log->event_log($sql,'d');
		$stmt1 = $db->runQuery($sql);
		$stmt1->execute();
		$log->event_log($sql,'d');
		echo json_encode('Updated Sucessfully');


	}
	
	else if($q==15){
		$name=$data->addname;
		$uid=$data->uid;
		$u_id=$db->getUseridByUniq($uid);
		$date=date('Y-m-d');
		$sql="INSERT INTO `accounts`(`user_id`, `accountname`, `date`, `accountstatus`) VALUES ('$uid','$name',NOW(),'active')";
		$log->event_log($sql,'d');
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		$log->event_log($sql,'d');
		$code = $db->lasdID();
		$log->event_log($code,'d');
		$sql1="INSERT INTO `groups`(`account_id`, `group_status`, `added_user_id`)
			   VALUES ('$code','Y','$u_id')";
		$log->event_log($sql1,'d');	   
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		$log->event_log($sql1,'d');
		echo json_encode('Added Sucessfully');


	}
	else if($q==16){
		$name=$data->name;
		$email=$data->email;
		$phone=$data->phone;
		$address=$data->address;
		$id=$data->id;
		$sql1="UPDATE `contact` SET `name`='$name',`email`='$email',`address`='$address',`phone`='$phone'  WHERE `contactID`='$id'";
		$log->event_log($sql1,'d');	   
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		$log->event_log($sql1,'d');
		echo json_encode('Updated Sucessfully');


	}else if($q==17){
		$name=$data->name;
		$email=$data->email;
		$phone=$data->phone;
		$address=$data->address;
		$id=$data->id;
		$sql1="DELETE FROM `contact` WHERE  `contactID`='$id'";
		$log->event_log($sql1,'d');	   
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		$log->event_log($sql1,'d');
		echo json_encode('Deleted Sucessfully');


	}
	
	

?>
