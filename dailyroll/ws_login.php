<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'class_user.php';
$db = new USER();
$eventlog = EVENTLOG;
	function event_log($text){
	
		$text=$uid."\t".$text;
		$file = DIR_LOGS."dailyroll".date("Y-m-d").".log";
//$file = "logs/dailyroll".date("Y-m-d").".log";
		error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3, $file);
			
	}
// json response array
$response = array("error" => FALSE);
$data = json_decode(file_get_contents('php://input'), true);
if($data !=''){
if (isset($data['email']) && isset($data['password'])) {
	//$db->event_log("begining of login",'i',LOG_FILE);
	event_log("begining of login");
   // receiving the post params
   // $email = 'leg@gmail.com';
    $orginalemail = $data['email'];
	$email=$db->encryptedstatic($orginalemail);
	event_log($email);
    //$email ='karunasrivelagala@gmail.com';
    //$password = 'abc123';
    $password = $data['password'];
	event_log($password);
    // get the user by email and password
     $user = $db->getUserByEmailAndPassword($email, $password);
	 event_log($user);
		if ($user != false) {
			if ( $user == "NOTACTIVE" ) {
				// user is not found with the credentials
				$response["error"] = TRUE;
				$response["error_msg"] = "Activate your account from your email and try to login again!";
				echo json_encode($response);
				event_log(json_encode($response));					
			} else {
				$userid=$user["user_id"];
				$check = $db->checkForSubscribe($userid);
				$result = $check['result'];
				if($result == "FALSE"){
					$response["error"] = TRUE;
					$response["uid"] = $user["unique_id"];
					$response["error_msg"] = "EXPIRED";
					echo json_encode($response);
					event_log(json_encode($response));
				}			
				else if($result == "TRUE"){
					$response["error"] = FALSE;
					$response["error_msg"] = "Success";
					$response["uid"] = $user["unique_id"];
					$response["name"] = $user["name"];
					$response["email"] =$orginalemail;
					$response["created_at"] = $user["created_at"];
					$response["updated_at"] = $user["updated_at"];
					$response["phone"] = $user["phone"];
					echo json_encode($response);
					event_log(json_encode($response));
				}
			}

		} else {
			// user is not found with the credentials
			$response["error"] = TRUE;
			$response["error_msg"] = "Login credentials are wrong. Please try again!";
			echo json_encode($response);
			event_log(json_encode($response));        
		}
} 
else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
	echo json_encode($response);
	event_log(json_encode($response));
        
}
}
else{
	if (isset($_POST['email']) && isset($_POST['password'])) {
		//$db->event_log("begining of login",'i',LOG_FILE);
		event_log("begining of login");
	   // receiving the post params
	   // $email = 'leg@gmail.com';
		$orginalemail = $_POST['email'];
		$email=$db->encryptedstatic($orginalemail);
		event_log($email);
		//$email ='karunasrivelagala@gmail.com';
		//$password = 'abc123';
		$password = $_POST['password'];

		// get the user by email and password
		$user = $db->getUserByEmailAndPassword($email, $password);

		if ($user != false) {
			if ( $user == "NOTACTIVE" ) {
				// user is not found with the credentials
				$response["error"] = TRUE;
				$response["error_msg"] = "Activate your account from your email and try to login again!";
				echo json_encode($response);
				event_log(json_encode($response));					
			} else {
			$userid=$user["user_id"];
			$check = $db->checkForSubscribe($userid);
			$result = $check['result'];
				if($result == "FALSE"){
					$response["error"] = TRUE;
					$response["uid"] = $user["unique_id"];
					$response["error_msg"] = "EXPIRED";
					echo json_encode($response);
					event_log(json_encode($response));
				}			
				else if($result == "TRUE"){
					$response["error"] = FALSE;
					$response["error_msg"] = "Success";
					$response["uid"] = $user["unique_id"];
					$response["name"] = $user["name"];
					$response["email"] =$orginalemail;
					$response["created_at"] = $user["created_at"];
					$response["updated_at"] = $user["updated_at"];
					$response["phone"] = $user["phone"];
					echo json_encode($response);
					event_log(json_encode($response));
				}
			}
		} else {
			// user is not found with the credentials
			$response["error"] = TRUE;
			$response["error_msg"] = "Login credentials are wrong. Please try again!";
			echo json_encode($response);
			event_log(json_encode($response));
			
		}
	} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
	echo json_encode($response);
	event_log(json_encode($response));
        
}



}
?>

