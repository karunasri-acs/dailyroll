<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
$data = json_decode(file_get_contents('php://input'), true);
$log->event_log(json_encode($data),'d');
if (isset($data['user_id'])) {
	$log->event_log("begining of get account",'d');
	//$user_id = '5c2dcee2e21538.17188314';
	$user_id = $data['user_id'];
	$log->event_log($user_id,'d');
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT * FROM `profile` WHERE `user_id`='$id'";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
    $log->event_log($sql,'d');

   $row1 = $stmt->fetch(PDO::FETCH_ASSOC);
		$phone=$row1['phone'];
	$email=$row1['email'];
	$name=$row1['name'];
	$lastname=$row1['lastname'];
	$country=$row1['country'];
	$address=$row1['address'];
	$photo = $row1['photo'];
		$log->event_log($photo,'d');
	$filepath=DIRPAY_PROFILE;
	$log->event_log($filepath,'d');
		$display=str_replace('../','', $filepath);
		$display1=str_replace('uploads/content','content', $display);
			$log->event_log($display1,'d');
		//$url='http://uploads.dinkhoo.com/uploads/content/dailyroll/profile/';
		$url=DISPLAY_DIR.$display1;
		$log->event_log($url,'d');
		$displayfile=$url.$photo;
        if(strlen(trim($photo))>0){
           $displayfile=$url.$photo;
        }else{
           $displayfile="NoPath";
        }
		$res=$displayfile;
		$log->event_log($res,'d');
		   $response["error"] = FALSE;
		   $response["phone"] = $phone;
		   $response["email"] = $email;
		   $response["firstName"] = $name;
		   $response["lastName"] = $lastname;
		   $response["country"] = $country;
		   $response["address"] = $address;
		   $response["photo"] = $res;
	echo json_encode($response);
		$log->event_log(json_encode($response),'d');
		
		
		
       
    }
	
 


?>

