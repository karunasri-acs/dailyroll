<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
	function getDatePath(){
	//Year in YYYY format.
	$year = date("Y-m-d");
	 
	//Month in mm format, with leading zeros.
	 
	//The folder path for our file should be YYYY/MM/DD
	$directory = "$year/";
	return $directory;
}
$data = json_decode(file_get_contents('php://input'), true);
$log->event_log(json_encode($data),'d');
	$file= $_FILES['fileToUpload']['name'];
	$log->event_log($file,'d');
	$useremail=$_POST['email'];
	$log->event_log($useremail,'d');
	$type = $_POST['feedback'];
	$log->event_log($type,'d');
	$date = date("Y-m-d");
	$message=$_POST['message'];
	$log->event_log($message,'d');
	$subject=$_POST['subject'];
	
	$log->event_log($subject,'d');
if($type =='1'){
	
	$feedback='request';
}else{
	
	$feedback='suggestions';
}
	
	
	if($file !=''){
		$datedir=getDatePath();
		$file_path  = DIR_REACTSUPPORT."".$datedir;
		$target_file = $file_path."".$file;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$lastid = uniqid(rand());
		$url=$lastid.".".$imageFileType;	
		$log->event_log($file_path,'d');
		if(!is_dir($file_path)){
		$log->event_log('is directory exist','d');
		//echo"Create our directoryeach";
			mkdir($file_path, 0777, true);
		}
		$filepath= $file_path."".$url;	
		$log->event_log($filepath,'d');
	if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $filepath)){
		$log->event_log('react file movied','d');
		$sql="INSERT INTO `feedback`(`email`, `subject`, `date`, `description`,`requesttype`, `status`,`document`,`dbtype`) VALUES ('$useremail','$subject','$date','$message','$feedback','new','$filepath','prod')";
		$log->event_log($sql,'d');
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		$response["error"] = FALSE;
			$response["error_msg"] = "Added Successfully";
			echo json_encode($response);
		
		
	} 
   }	
   else{
			$sql="INSERT INTO `feedback`(`email`, `subject`,  `date`, `description`, `requesttype`,`status`,`dbtype`) VALUES ('$useremail','$subject','$date','$message','$feedback','new','prod')";
			$stmt = $user_home->runQuery($sql);
			$stmt->execute();
			 $log->event_log($sql,'d');
			$response["error"] = FALSE;
			$response["error_msg"] = "Added Successfully";
			echo json_encode($response);
			
			
	}     
	



?>

