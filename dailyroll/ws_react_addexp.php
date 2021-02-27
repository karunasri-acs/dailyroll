<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
function getDatePath(){
	//Year in YYYY format.
	$year = date("Y");
	 
	//Month in mm format, with leading zeros.
	 $month = date("m");
	 
	//Day in dd format, with leading zeros.
	 $day = date("d");
	 
	//The folder path for our file should be YYYY/MM/DD
	$directory = "$year/$month/$day/";
	return $directory;
}	

$data = json_decode(file_get_contents('php://input'), true);
$log->event_log(json_encode($data),'d');
$file= $_FILES['fileToUpload']['name'];
$uid = $_POST['userid'];
$log->event_log($uid,'d');
$amount = $_POST['amount'];
$account = $_POST['bussinessid'];  
$description = $_POST['description'];
$var = $_POST['expdate'];
$log->event_log('send date'.$var,'d');
$category = $_POST['accountid']; 
$subcategory = $_POST['subaccid'];
$type = $_POST['type'];
$log->event_log($type,'d');
$row2=$user_home->get_accountdetails($account);
$freezedate=$row2['freezedate'];
if($account !=''){
$log->event_log($freezedate,'d');
if(($freezedate <= $var) ||($freezedate =='0000-00-00') ){
	if($file !=''){
		$log->event_log($file,'d');
		$ret = explode('-', $file);
		$userid=$ret[0];
		$log->event_log($userid,'d');
		$datedir=getDatePath();
		$file_path  = DIR_VEDIOS."".$userid."/".$datedir;
		$log->event_log($file_path,'d');
		if(!is_dir($file_path)){
			//echo"Create our directoryeach";
			mkdir($file_path, 0777, true);
		}	
		$file_path = $file_path.$file;
		$log->event_log($fle_path,'d');
		if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_path)){
		   $res=$file_path;
		  if($type==1){
			$sql="INSERT INTO `income`(`capture_id`, `account_id`,`income_amount`, `file_name`, `description`, `subcat_id`, `cat_id`,`tr_date`) 
								 VALUES ('$uid','$account','$amount','$res','$description','$subcategory','$category','$var')";
		 

		 }else{
			 $sql="INSERT INTO `expenses`(`capture_id`, `account_id`,`amount`, `file_name`, `description`, `subcat_id`, `cat_id`,`tr_date`) 
								 VALUES ('$uid','$account','$amount','$res','$description','$subcategory','$category','$var')";
		  
			  
		  }
			$log->event_log($sql,'d');
			$stmt=$user_home->runQuery($sql);
			$result = $stmt->execute();
			$user_home->createjson($account);
			$response["error"] = FALSE;
			$response["error_msg"] = "Added Successfully";
			echo json_encode($response);
		  
		}
		 
	}else{
		$res='aaaa';
		 if($type==1){
			$sql="INSERT INTO `income`(`capture_id`, `account_id`,`income_amount`, `file_name`, `description`, `subcat_id`, `cat_id`,`tr_date`) 
								 VALUES ('$uid','$account','$amount','$res','$description','$subcategory','$category','$var')";
		 

		 }else{
			 $sql="INSERT INTO `expenses`(`capture_id`, `account_id`,`amount`, `file_name`, `description`, `subcat_id`, `cat_id`,`tr_date`) 
								 VALUES ('$uid','$account','$amount','$res','$description','$subcategory','$category','$var')";
		  
			  
		  }
		  $log->event_log($sql,'d');
			$stmt=$user_home->runQuery($sql);
			$result = $stmt->execute();
			$user_home->createjson($account);
			$response["error"] = FALSE;
			$response["error_msg"] = "Added Successfully";
			echo json_encode($response);
		
	}
 }
 else{
  $response["error"] = TRUE;
	$response["error_msg"] = "Transaction  Freezed on selected date ";
	echo json_encode($response);
	$log->event_log(json_encode($response),'e');
}
}
?>

