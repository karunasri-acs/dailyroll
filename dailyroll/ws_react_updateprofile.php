<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
	
	$data = json_decode(file_get_contents('php://input'), true);
	$log->event_log(json_encode($data),'d');
	$file= $_FILES['fileToUpload']['name'];
	$log->event_log($file,'d');
	$file_path = DIR_REACTPROFILE;
	$firstname=$_POST['firstname'];
	$log->event_log($firstname,'d');
	$lastname=$_POST['lastname'];
	$log->event_log($lastname,'d');
	$phone=$_POST['phone'];
	$log->event_log($phone,'d');
	$userid=$_POST['userid'];
	$log->event_log($userid,'d');
	$id=$user_home->getUseridByUniq($userid);
	$log->event_log($id,'d');
	try{

	if($file !=''){
		$randam= uniqid(rand());
		$conv=explode(".",$file);
		$ext=$conv['1'];
		$url=$randam.".".$ext;
		$file_path = $file_path.$url;
		$log->event_log($file_path,'d');
		if (file_exists($file_path))
		{
				$log->event_log($file_path,'d');
					unlink($file_path);
		}
		
	if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_path)){
	$sql="UPDATE`users` SET `name`='$firstname',`phone`='$phone' WHERE `user_id`='$id'";
	$log->event_log($sql,'d');
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		$sql1="UPDATE `profile` SET `name`='$firstname',`lastname`='$lastname',`phone`='$phone',`photo`='$url' WHERE `user_id`='$id'";
		$stmt1 = $user_home->runQuery($sql1);
		$stmt1->execute();
		
		$response["error"] = FALSE;
			$response["error_msg"] = "Updated Successfully";
			echo json_encode($response);
		
		
	} 
   }	
   else{
	   $sql="UPDATE`users` SET `name`='$firstname',`phone`='$phone' WHERE `user_id`='$id'";
	   $log->event_log($sql,'d');
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		 $log->event_log($sql,'d');
		$sql1="UPDATE `profile` SET `name`='$firstname',`lastname`='$lastname',`phone`='$phone' WHERE `user_id`='$id'";
		 $log->event_log($sql1,'d');
		$stmt1 = $user_home->runQuery($sql1);
		$stmt1->execute();
		$log->event_log($sql1,'d');
		$response["error"] = FALSE;
			$response["error_msg"] = "Updated Successfully";
			echo json_encode($response);
		
			
			
	}     
	}
			catch(PDOException $ex)
	  {
			$response["error"] = FALSE;
			$response["error_msg"] = "Error  while Updating ";
			echo json_encode($response);
	  }


?>

