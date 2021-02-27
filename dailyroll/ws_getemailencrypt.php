<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
$response = array("error" => FALSE);
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 

$data = json_decode(file_get_contents('php://input'), true);

if($data != ''){
	if (isset($data['email'])) {
		$email = $data['email'];
		$log->event_log($email,'d');
		$encrypt=$user_home->encryptedstatic($email);
		 $response["error"] = FALSE;
        $response["encryptemail"] =$encrypt ;
        echo json_encode($response);
		$log->event_log(json_encode($response),'d');
} 
}
else{
	if (isset($_POST['email'])) {
		$log->event_log("begining of Register",'d');
		$email = $_POST['email'];
		//$email = 'karunasrivelagala@gmail.com';
		$encrypt=$user_home->encryptedstatic($email);
		 $response["error"] = FALSE;
        $response["encryptemail"] =$encrypt ;
        echo json_encode($response);
		$log->event_log(json_encode($response),'d');
	}
}
?>

