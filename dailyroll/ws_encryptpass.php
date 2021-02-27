<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */

require_once 'class.user.php';

$db = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->event_log('root file beginning ','d'); 
// json response array
$response = array("error" => FALSE);

if (isset($_POST['strval'])) {
	$strval = $_POST['strval'];
	 //$strval = "abc123";
//echo $date = date ('1');
    $key1=$db->encstr($strval);
    // use is found
        $response["key"] = $key1;
        echo json_encode($response);
		
		
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters  strval is missing!";
	echo json_encode($response);
	$log->event_log(json_encode($response),'e');
        
}
?>

