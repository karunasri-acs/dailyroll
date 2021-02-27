<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'class_user.php';
$db = new USER();

require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
// json response array
$response = array("error" => FALSE);
$data = json_decode(file_get_contents('php://input'), true);
if($data !=''){
if (isset($data['email']) && isset($data['password'])) {
	//$db->$log->event_log("begining of login",'i',LOG_FILE);
	$log->event_log("begining of login",'d');
   // receiving the post params
   // $email = 'leg@gmail.com';
    $email = $data['email'];
    //$password = 'abc123';
    $password = $data['password'];

    // get the user by email and password
     $user = $db->getUserByEmailAndPassword($email, $password);

    if ($user != false) {
        // use is found
        $response["error"] = FALSE;
        $response["uid"] = $user["unique_id"];
        $response["name"] = $user["name"];
        $response["email"] = $user["email"];
        $response["created_at"] = $user["created_at"];
        $response["updated_at"] = $user["updated_at"];
		$response["phone"] = $user["phone"];
        echo json_encode($response);
		$log->event_log(json_encode($response),'d');
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
		echo json_encode($response);
		$log->event_log(json_encode($response),'e');
        
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
	echo json_encode($response);
	$log->event_log(json_encode($response),'e');
        
}
}
else{
	if (isset($_POST['email']) && isset($_POST['password'])) {
	//$db->$log->event_log("begining of login",'i',LOG_FILE);
	$log->event_log("begining of login",'d');
   // receiving the post params
   // $email = 'leg@gmail.com';
    $email = $_POST['email'];
    //$password = 'abc123';
    $password = $_POST['password'];

    // get the user by email and password
     $user = $db->getUserByEmailAndPassword($email, $password);

    if ($user != false) {
        // use is found
        $response["error"] = FALSE;
        $response["uid"] = $user["unique_id"];
        $response["name"] = $user["name"];
        $response["email"] = $user["email"];
        $response["created_at"] = $user["created_at"];
        $response["updated_at"] = $user["updated_at"];
		$response["phone"] = $user["phone"];
        echo json_encode($response);
		$log->event_log(json_encode($response),'d');
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
		echo json_encode($response);
		$log->event_log(json_encode($response),'e');
        
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
	echo json_encode($response);
	$log->event_log(json_encode($response),'e');
        
}



}
?>

