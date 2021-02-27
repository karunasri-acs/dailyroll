<?php

require_once 'class_user.php';
$db = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
	$data = json_decode(file_get_contents('php://input'), true);
//if($_SERVER['REQUEST_METHOD']=='POST'){
if($data !=''){
if(isset($data['email']) && isset($data['oldpass']) && isset($data['newpass'])){
  
  $log->event_log("begining of changepassword",'d');

    // receiving the post params
   // $email = 'kk@gmail.com';
	$orginalemail = $data['email'];
	$email=$db->encryptedstatic($orginalemail);
	 //$oldpass = 'abc123';
	 $oldpass = $data['oldpass'];
	 //$newpass = 'abc1234';
	 $newpass = $data['newpass'];
    //$repass = $_POST['repass'];
   // $repass = '';
	$user = $db->getUserByEmailAndPassword($email, $oldpass);
   if($user == false){

		  $response["error"] = FALSE;
		  $response["message"] = 'Invalid  Email or Old password';
		  echo json_encode($response);
		  $log->event_log(json_encode($response),'d');
		  

		} else {

				$hash = $db->hashSSHA($newpass);
				$encrypted_password = $hash["encrypted"]; // encrypted password
				$salt = $hash["salt"]; // salt

				 $sql = "UPDATE users SET encrypted_password = '$encrypted_password', salt = '$salt', updated_at ='Now()' WHERE email = '$email'";
				$stmt = $db->runQuery($sql);

				$result = $stmt->execute();
				//echo $sql;
				//$stmt->close();
			   //$result = $db -> changePassword($email, $new_password);

			  if($result) {

				$response["error"] = TRUE;
				$response["message"] = "Password Changed Successfully";
				echo json_encode($response);
				$log->event_log(json_encode($response),'e');

			  } else {

				$response["error"] = FALSE;
				$response["message"] = 'Error Updating Password';
				echo json_encode($response);
				$log->event_log(json_encode($response),'d');

			  }

		   } 

}else{
echo 'error';
}
}
else{
	if(isset($_POST['email']) && isset($_POST['oldpass']) && isset($_POST['newpass'])){
  
  $log->event_log("begining of changepassword",'d');

    // receiving the post params
   // $email = 'kk@gmail.com';
	//$email = $_POST['email'];
	$orginalemail = $_POST['email'];
	$email=$db->encryptedstatic($orginalemail);	
		
	 //$oldpass = 'abc123';
	 $oldpass = $_POST['oldpass'];
	 //$newpass = 'abc1234';
	 $newpass = $_POST['newpass'];
    //$repass = $_POST['repass'];
   // $repass = '';
	$user = $db->getUserByEmailAndPassword($email, $oldpass);
   if($user == false){

		  $response["error"] = FALSE;
		  $response["message"] = 'Invalid  Email or Old password';
		  echo json_encode($response);
		  $log->event_log(json_encode($response),'d');
		  

		} else {

				$hash = $db->hashSSHA($newpass);
				$encrypted_password = $hash["encrypted"]; // encrypted password
				$salt = $hash["salt"]; // salt

				 $sql = "UPDATE users SET encrypted_password = '$encrypted_password', salt = '$salt', updated_at ='Now()' WHERE email = '$email'";
				$stmt = $db->runQuery($sql);

				$result = $stmt->execute();
				//echo $sql;
				//$stmt->close();
			   //$result = $db -> changePassword($email, $new_password);

			  if($result) {

				$response["error"] = FALSE;
				$response["message"] = "Password Changed Successfully";
				echo json_encode($response);
				$log->event_log(json_encode($response),'d');

			  } else {

				$response["error"] = TRUE;
				$response["message"] = 'Error Updating Password';
				echo json_encode($response);
				$log->event_log(json_encode($response),'e');

			  }

		   } 

}else{
echo 'error';
}
}

?>

