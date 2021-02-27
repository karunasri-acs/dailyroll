<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */
require_once 'class_user.php';
//require_once 'constants.php';
$db = new USER();
// json response array
$response = array();
 if(isset($_GET['password']) && isset($_GET['email']))
{
	 //$email = 'leg@gmail.com';
	 $email = $_GET['email'];
	 $upass = $_GET['password'];
	//$upass = 'abc123';

    // get the user by email and password
     $user = $db->getUserByEmailAndPassword($email, $upass);
//print_r($user);
    if ($user == false) {
        // use is found
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $uid = $user["unique_id"];
        $sql = "SELECT * FROM  event_log WHERE CaptureID='$uid' AND `permission_flag`!='Delete' AND  LENGTH(YouTubeUrl)>5 ORDER BY ID DESC";
		 $stmt = $db->runQuery($sql);
		 $stmt->execute();
		 //echo$sql;
		//$response =  array();
	    //$x = 1;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//print_r($user);
		$response[] = $row;
		//print_r($response);
		}						
		echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>

