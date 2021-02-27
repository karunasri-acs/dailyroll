<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$file_path = DIR_VEDIOS;
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	$response = array("error" => FALSE);

$data = json_decode(file_get_contents('php://input'), true);
$log->event_log("beginning of offline data",'d');
//if($_SERVER['REQUEST_METHOD']=='POST'){
if($data !=''){
if(isset($data['uid']) && isset($data['trnno']) && isset($data['amount'])&& isset($data['account']) && isset($data['filename'])&& isset($data['description'])&& isset($data['lastdatetime'])&& isset($data['category'])&& isset($data['subcategory'])){

	$uid = $data['uid'];
	$log->event_log($uid,'d');
	$trnno = $data['trnno'];
	//$trnno = '400';
	$log->event_log($trnno,'d');
    $amount = $data['amount'];
    $account = $data['account'];
    $file= $data['filename'];
    $description = $data['description'];
    $var = $data['lastdatetime'];
	$log->event_log($var,'d');
	$var = date("Y-m-d", strtotime($var));
	$log->event_log($var,'d');
	 $category = $data['category']; 
	 $subcategory = $data['subcategory'];
	 $row2=$user_home->get_accountdetails($account);
	$freezedate=$row2['freezedate'];
	$log->event_log($freezedate,'d');
	/*$uid = '5b962b04470455.88496761';
    $amount ='100';
    $account ='5';
    $file=''];
    $description ='hello mummmy';
    $var ='2018-11-15';*/
	//$account=$user_home->getaccountid($account);
	//$date = str_replace('/', '-', $var);
    //$date1= date('Y-m-d', strtotime($date));
   // $category = '3';
	

	$filename = str_replace('"', '', $file);
	$url=$filename;
	$videoname =  substr($filename, strrpos($filename, '/') + 1);
	$userid=$user_home->getUseridByUniq($uid);
	$pdate=date('Y-m-d');
	$check = $user_home->checkForSubscribe($userid);
	$result = $check['result'];
	if($result == "FALSE"){
	  $response["error"] = TRUE;
	 $response["error_msg"] = "Please Renew Subscription";
        echo json_encode($response);
		$log->event_log(json_encode($response),'e');
		
	}
	else if($result == "TRUE"){
	$log->event_log("Begining of the offline Data",'e');
	 try
	 {
	 if($trnno > 0){
	    if (strstr($file, 'aaa')) {
		
		 $sql1="select * from expenses WHERE `id`='$trnno'";
		 $log->event_log($sql1,'d');
		 $stmt1=$user_home->runQuery($sql1);
		 $stmt1->execute();
		 $fetcdat=$stmt1->fetch(PDO::FETCH_ASSOC);
		 $log->event_log(json_encode($fetcdat),'d');
		 $url=$fetcdat['file_name'];
		 
		}
		else{
				
		 $sql1="select * from expenses WHERE `id`='$trnno'";
		 $log->event_log($sql1,'d');
		 $stmt1=$user_home->runQuery($sql1);
		 $stmt1->execute();
		
		 $fetcdat=$stmt1->fetch(PDO::FETCH_ASSOC);
		 $log->event_log(json_encode($fetcdat),'d');
		 $deletedfile=$fetcdat['file_name'];
		 $log->event_log($deletedfile,'d');
		 $rdeletedfile = str_replace('../', '', $deletedfile);
			$log->event_log($rdeletedfile,'d');
			$unlinkpath='../../'.$rdeletedfile;
			$log->event_log($unlinkpath,'d');
			 if (file_exists($unlinkpath)) {
				unlink($unlinkpath);
				$log->event_log('image is deleted','d');
   
			}
			else{
				$log->event_log('No file in desired path','d');
			}	
		
		}
		
		
	 $sql="UPDATE `expenses` SET `account_id`='$account',`amount`='$amount', `file_name`='$url',`description`='$description',`subcat_id`='$subcategory',`cat_id`='$category',`tr_date`='$var',`updateddate`='$pdate',`updatedby`='$userid' WHERE `id`='$trnno'";
	 $log->event_log($sql,'d');
	 $stmt=$user_home->runQuery($sql);
		$result = $stmt->execute();
			$user_home->createjson($account);
		 $response["error"] = FALSE;
	    $response["error_msg"] = "Updated Successfully";
		$response["trnno"] = $trnno;
        echo json_encode($response);
		$log->event_log(json_encode($response),'d');
	 }
	 
	 else {
		 if($freezedate <= $var){
		$sql="INSERT INTO `expenses`(`capture_id`, `account_id`,`amount`, `file_name`, `description`, `subcat_id`, `cat_id`,`tr_date`) 
							 VALUES ('$uid','$account','$amount','$url','$description','$subcategory','$category','$var')";
			$log->event_log($sql,'d');
		$stmt=$user_home->runQuery($sql);
		$result = $stmt->execute();
			$user_home->createjson($account);
		$eventId=$user_home->lasdID();
		 $response["error"] = FALSE;
	    $response["error_msg"] = "Added Successfully";
		$response["trnno"] = $eventId;
        echo json_encode($response);
		
		$log->event_log(json_encode($response),'d');
		}
		else{
		  $response["error"] = TRUE;
			$response["error_msg"] = "Transaction  Freezed on selected date ";
			echo json_encode($response);
			$log->event_log(json_encode($response),'d');
		}
		$log->event_log("Ending of the offline Data",'d');
		}
	}
	 catch(PDOException $ex)
	  {
	   $response["error"] = TRUE;
	    $response["error_msg"] = "Duplicate Entry";
        echo json_encode($response);
		$log->event_log();
	  }
	 } 

} 
else{
    echo 'error';
	$log->event_log("Nodatasend",'d');
}
}else{

if($_SERVER['REQUEST_METHOD']=='POST'){
	$uid = $_POST['uid'];
	$log->event_log($uid,'d');
	$trnno = $_POST['trnno'];
	//$trnno = '400';
	$log->event_log($trnno,'d');
    $amount = $_POST['amount'];
    $account = $_POST['account'];
    $file= $_POST['filename'];
    $description = $_POST['description'];
    $var = $_POST['lastdatetime'];
	$log->event_log($var,'d');
	$var = date("Y-m-d", strtotime($var));
	$log->event_log($var,'d');
	 $category = $_POST['category']; 
	 $subcategory = $_POST['subcategory'];
	 $row2=$user_home->get_accountdetails($account);
	$freezedate=$row2['freezedate'];
	$log->event_log($freezedate,'d');
	/*$uid = '5b962b04470455.88496761';
    $amount ='100';
    $account ='5';
    $file=''];
    $description ='hello mummmy';
    $var ='2018-11-15';*/
	//$account=$user_home->getaccountid($account);
	//$date = str_replace('/', '-', $var);
    //$date1= date('Y-m-d', strtotime($date));
   // $category = '3';
	

	$filename = str_replace('"', '', $file);
	$url=$filename;
	$videoname =  substr($filename, strrpos($filename, '/') + 1);
	$userid=$user_home->getUseridByUniq($uid);
	$pdate=date('Y-m-d');
	$check = $user_home->checkForSubscribe($userid);
	$result = $check['result'];
	if($result == "FALSE"){
	  $response["error"] = TRUE;
	 $response["error_msg"] = "Please Renew Subscription";
        echo json_encode($response);
		$log->event_log(json_encode($response),'d');
		
	}
	else if($result == "TRUE"){
	$log->event_log("Begining of the offline Data",'e');
	 try
	 {
	 if($trnno > 0){
	    if (strstr($file, 'aaa')) {
		
		 $sql1="select * from expenses WHERE `id`='$trnno'";
		 $log->event_log($sql1,'d');
		 $stmt1=$user_home->runQuery($sql1);
		 $stmt1->execute();
		 $fetcdat=$stmt1->fetch(PDO::FETCH_ASSOC);
		 $log->event_log(json_encode($fetcdat),'d');
		 $url=$fetcdat['file_name'];
		 
		}
		else{
				
		 $sql1="select * from expenses WHERE `id`='$trnno'";
		 $log->event_log($sql1,'d');
		 $stmt1=$user_home->runQuery($sql1);
		 $stmt1->execute();
		
		 $fetcdat=$stmt1->fetch(PDO::FETCH_ASSOC);
		 $log->event_log(json_encode($fetcdat),'d');
		 $deletedfile=$fetcdat['file_name'];
		 $log->event_log($deletedfile,'d');
		 $rdeletedfile = str_replace('../', '', $deletedfile);
			$log->event_log($rdeletedfile,'d');
			$unlinkpath='../../'.$rdeletedfile;
			$log->event_log($unlinkpath,'d');
			 if (file_exists($unlinkpath)) {
				unlink($unlinkpath);
				$log->event_log('image is deleted','d');
   
			}
			else{
				$log->event_log('No file in desired path','d');
			}	
		
		}
		
		
	 $sql="UPDATE `expenses` SET `account_id`='$account',`amount`='$amount', `file_name`='$url',`description`='$description',`subcat_id`='$subcategory',`cat_id`='$category',`tr_date`='$var',`updateddate`='$pdate',`updatedby`='$userid' WHERE `id`='$trnno'";
	 $log->event_log($sql,'d');
	 $stmt=$user_home->runQuery($sql);
		$result = $stmt->execute();
			$user_home->createjson($account);
		 $response["error"] = FALSE;
	    $response["error_msg"] = "Updated Successfully";
		$response["trnno"] = $trnno;
        echo json_encode($response);
		$log->event_log(json_encode($response),'d');
	 }
	 
	 else {
		 if($freezedate <= $var){
		$sql="INSERT INTO `expenses`(`capture_id`, `account_id`,`amount`, `file_name`, `description`, `subcat_id`, `cat_id`,`tr_date`) 
							 VALUES ('$uid','$account','$amount','$url','$description','$subcategory','$category','$var')";
			$log->event_log($sql,'d');
		$stmt=$user_home->runQuery($sql);
		$result = $stmt->execute();
		$eventId=$user_home->lasdID();
			$user_home->createjson($account);
		 $response["error"] = FALSE;
	    $response["error_msg"] = "Added Successfully";
		$response["trnno"] = $eventId;
        echo json_encode($response);
		
		$log->event_log(json_encode($response),'d');
		}
		else{
		  $response["error"] = TRUE;
			$response["error_msg"] = "Transaction  Freezed on selected date ";
			echo json_encode($response);
			$log->event_log(json_encode($response),'d');
		}
		$log->event_log("Ending of the offline Data",'d');
		}
	}
	 catch(PDOException $ex)
	  {
	   $response["error"] = TRUE;
	    $response["error_msg"] = "Duplicate Entry";
        echo json_encode($response);
		$log->event_log();
	  }
	 } 

} 
else{
    echo 'error';
	$log->event_log("Nodatasend",'d');
}
}
?>

