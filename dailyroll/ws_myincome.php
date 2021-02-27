<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log(('root file beginning ','d'); 
	$log->event_log(('myincome beggining','d');
	$response = array("error" => FALSE);
	
$data = json_decode(file_get_contents('php://input'), true);
//if($_SERVER['REQUEST_METHOD']=='POST'){
	$log->event_log((json_encode($data),'d');
if($data !=''){
if(isset($data['uid']) && isset($data['trnno']) && isset($data['date'])&& isset($data['account']) && isset($data['filename']) && isset($data['category'])&& isset($data['subcategory'])&& isset($data['description'])&& isset($data['amount'])){
	
	$uid = $data['uid'];
	$log->event_log(($uid,'d');
	$trnno = $data['trnno'];
	$log->event_log(($trnno,'d');
	$date=$data['date'];
	$date = date("Y-m-d", strtotime($date));
	$log->event_log(($date,'d');
		//$log->event_log(($var);
	$account=$data['account'];
	$log->event_log(($account,'d');
	$category=$data['category'];
	$log->event_log(($category,'d');
	$subcategory=$data['subcategory'];
	$log->event_log(($subcategory,'d');
	$description=$data['description'];
	$log->event_log(($description,'d');
	$amount=$data['amount'];
	$log->event_log(($amount,'d');
	$pdate=date('Y-m-d');
	$log->event_log(($pdate,'d');
	$file= $data['filename'];
	$log->event_log(($file,'d');
	$filename = str_replace('"', '', $file);
	$log->event_log(($filename,'d');
	$url=$filename;
	$log->event_log(($url,'d');
	$videoname =  substr($filename, strrpos($filename, '/') + 1);
	$log->event_log(($videoname,'d');
	$userid=$user_home->getUseridByUniq($uid);
	$log->event_log(($userid,'d');
	$row2=$user_home->get_accountdetails($account);
	$freezedate=$row2['freezedate'];
	$log->event_log(($freezedate,'d');
	$check = $user_home->checkForSubscribe($userid);
	$log->event_log(($check,'d');
	$result = $check['result'];
	if($result == "FALSE"){
		 $response["error"] = TRUE;
	 $response["error_msg"] = "Please Renew Subscription";
        echo json_encode($response);
		$log->event_log((json_encode($response),'e');
		
	}
	elseif($result == "TRUE"){
	$log->event_log(("Begining of the offline Data when True",'d');
	 try
	 {
		 $log->event_log(("Subscribed",'d');
	 if($trnno > 0){
		  if (strstr($file, 'aaa')) {
		
		 $sql1="select * from income WHERE `income_id`='$trnno'";
		 $log->event_log(($sql1,'d');
		 $stmt1=$user_home->runQuery($sql1);
		 $stmt1->execute();
		 $fetcdat=$stmt1->fetch(PDO::FETCH_ASSOC);
		 $log->event_log((json_encode($fetcdat),'d');
		 $url=$fetcdat['file_name'];
		 
		}
		else{
				
		 $sql1="select * from income WHERE `income_id`='$trnno'";
		 $log->event_log(($sql1,'d');
		 $stmt1=$user_home->runQuery($sql1);
		 $stmt1->execute();
		
		 $fetcdat=$stmt1->fetch(PDO::FETCH_ASSOC);
		 $log->event_log((json_encode($fetcdat),'d');
		 $deletedfile=$fetcdat['file_name'];
		 $log->event_log(($deletedfile,'d');
		 $rdeletedfile = str_replace('../', '', $deletedfile);
			$log->event_log(($rdeletedfile,'d');
			$unlinkpath='../../'.$rdeletedfile;
			$log->event_log(($unlinkpath,'d');
			 if (file_exists($unlinkpath)) {
				unlink($unlinkpath);
				$log->event_log(('image is deleted','d');
			}
			else{
				$log->event_log(('No file in desired path','d');
			}	
		
		}
	$sql=" UPDATE `income` SET `account_id`='$account',`income_amount`='$amount',`subcat_id`='$subcategory',`cat_id`='$category',`description`='$description',`tr_date`='$date',`updateddate`='$pdate',`file_name`='$url',`updatedby`='$userid' WHERE income_id='$trnno'";
	$log->event_log(($sql,'d');
	$stmt=$user_home->runQuery($sql);
		$result = $stmt->execute();	
		 $response["error"] = FALSE;
			$response["error_msg"] = "Updated Successfully";
			$response["trnno"] = $trnno;
			echo json_encode($response);
			$log->event_log((json_encode($response),'d');
	}
	 else{
		 if($freezedate <= $date){
			$sql="INSERT INTO `income`( `capture_id`, `account_id`, `income_amount`, `subcat_id`, `cat_id`,`description`,`tr_date`,`file_name`) VALUES ('$uid','$account','$amount','$subcategory','$category','$description','$date','$url')";
			$log->event_log(($sql,'d');
			$stmt=$user_home->runQuery($sql);
			$result = $stmt->execute();
			$trno1=$user_home->lasdID();
			 $response["error"] = FALSE;
			$response["error_msg"] = "Added Successfully";
			$response["trnno"] = $trno1;
			echo json_encode($response);
			$log->event_log((json_encode($response),'d');
		   $log->event_log(("Ending of the income ",'d');
		   }
		   else{
			 $response["error"] = TRUE;
			$response["error_msg"] = "Transaction  Freezed on selected date ";
			echo json_encode($response);
			$log->event_log((json_encode($response),'e');
		   
		   
		   }
		 }
	   }
	 catch(PDOException $ex)
	  {
		$response["error"] = TRUE;
	    $response["error_msg"] = "Duplicate Entry";
        echo json_encode($response);
		$log->event_log((json_encode($response),'e');
	  }
	} 
	// let postParameters = "account="+account!+"&uid="+suid+"&date="+udate1!+"&category="+catgory!+"&amount="+amount!+"&description="+desc!
} 
else{
    echo 'error';
	$log->event_log(("Nodatasend",'d');
}
}
else{
	if($_SERVER['REQUEST_METHOD']=='POST'){
	
	$uid = $_POST['uid'];
	$trnno = $_POST['trnno'];
	$log->event_log(($trnno,'d');
	$date=$_POST['date'];
	$date = date("Y-m-d", strtotime($date));
	$log->event_log(($var,'d');
		//$log->event_log(($var);
	$account=$_POST['account'];
	$category=$_POST['category'];
	$subcategory=$_POST['subcategory'];
	$description=$_POST['description'];
	$amount=$_POST['amount'];
	$pdate=date('Y-m-d');
	$userid=$user_home->getUseridByUniq($uid);
	 $row2=$user_home->get_accountdetails($account);
	$freezedate=$row2['freezedate'];
	$check = $user_home->checkForSubscribe($userid);
	$result = $check['result'];
	if($result == "FALSE"){
		 $response["error"] = TRUE;
	 $response["error_msg"] = "Please Renew Subscription";
        echo json_encode($response);
		$log->event_log((json_encode($response),'e');
		
	}
	elseif($result == "TRUE"){
	$log->event_log(("Begining of the offline Data",'d');
	 try
	 {
	 if($trnno > 0){
	$sql=" UPDATE `income` SET `account_id`='$account',`income_amount`='$amount',`subcat_id`='$subcategory',`cat_id`='$category',`description`='$description',`tr_date`='$date',`updateddate`='$pdate',`updatedby`='$userid' WHERE income_id='$trnno'";
	$log->event_log(($sql,'d');
	$stmt=$user_home->runQuery($sql);
		$result = $stmt->execute();	
		 $response["error"] = FALSE;
			$response["error_msg"] = "Updated Successfully";
			$response["trnno"] = $trnno;
			echo json_encode($response);
			$log->event_log((json_encode($response),'d');
	}
	 else{
		 if($freezedate <= $date){
		 $sql="INSERT INTO `income`( `capture_id`, `account_id`, `income_amount`, `subcat_id`, `cat_id`,`description`,`tr_date`)  
							VALUES ('$uid','$account','$amount','$subcategory','$category','$description','$date')";
			$log->event_log(($sql,'d');
			
		$stmt=$user_home->runQuery($sql);
		$result = $stmt->execute();
		$trno1=$user_home->lasdID();
			 $response["error"] = FALSE;
			$response["error_msg"] = "Added Successfully";
			$response["trnno"] = $trno1;
			echo json_encode($response);
			$log->event_log((json_encode($response),'d');
		   $log->event_log(("Ending of the income ",'d');
		   }
		   else{
			 $response["error"] = TRUE;
			$response["error_msg"] = "Transaction  Freezed on selected date ";
			echo json_encode($response);
			$log->event_log((json_encode($response),'e');
		   
		   
		   }
		 }
	   }
	 catch(PDOException $ex)
	  {
		$response["error"] = TRUE;
	    $response["error_msg"] = "Duplicate Entry";
        echo json_encode($response);
		$log->event_log((json_encode($response),'e');
	  }
	} 

	// let postParameters = "account="+account!+"&uid="+suid+"&date="+udate1!+"&category="+catgory!+"&amount="+amount!+"&description="+desc!
	
	

} 
else{
    echo 'error';
	$log->event_log(("Nodatasend",'d');
}



}

?>

