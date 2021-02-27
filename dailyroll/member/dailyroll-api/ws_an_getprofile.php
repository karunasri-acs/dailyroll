<?php
	header("Access-Control-Allow-Origin: *");
	include 'class.user.php';
	$user_home = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	$request=file_get_contents('php://input');
	$data = json_decode($request);
   
	$uid=$data->uid;
	$q=$data->q;
	$log->event_log($uid,'d');
	//$uid='5f7b7841f27911.57535717';
	if($uid!=''){
	if($q==1){
	$id=$user_home->get_email($uid);
	$sql="select * from `users` where `user_id`='$id'";

	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	// echo $sql;			
	$row1= $stmt->fetch(PDO::FETCH_ASSOC);
	$sql1="select * from `profile` where `user_id`='$id'";
	$stmt1 = $user_home->runQuery($sql1);
	$stmt1->execute();
	// echo $sql;			
	$row= $stmt1->fetch(PDO::FETCH_ASSOC);
		$photo = $row['photo'];
		
	//$displayfile1=str_replace('"','',$photo);
	$filepath=DIRPAY_PROFILE;
		$display=str_replace('../','', $filepath);
		$display=str_replace('uploads/content','content', $display);
		//$url='http://uploads.dinkhoo.com/uploads/content/dailyroll/profile/';
		$url=DISPLAY_DIR;
		$displayfile=$url.$display;
		$res=$displayfile;
			$data = [
      
      'photo' => $res
    ];
	$profile[]=$data;
	echo json_encode($profile);
	}
	else{
	 $id=$user_home->get_email($uid);
		$log->event_log($id,'d');
	$sql="select * from `users` where `user_id`='$id'";

	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	
	$log->event_log($sql,'d');	
	$row1= $stmt->fetch(PDO::FETCH_ASSOC);
	$sql1="select * from `profile` where `user_id`='$id'";
	$stmt1 = $user_home->runQuery($sql1);
	$stmt1->execute();
	
	$log->event_log($sql1,'d');	
	$row= $stmt1->fetch(PDO::FETCH_ASSOC);
	
$phone=$user_home->dencrypted($row['phone']);
	$email=$user_home->dencryptedstatic($row['email']);
	$name=$user_home->dencrypted($row['name']);
	$lastname=$row['lastname'];
	$country=$row['country'];
	$address=$row['address'];
	if($lastname == ''){
		$lastname=$lastname;
	}
	else{
		$lastname=$user_home->dencrypted($lastname);
	}
	if($country ==''){
		$country=$country;
	}
	else{
		$country=$user_home->dencrypted($country);
	}
	if($address ==''){
		$address=$address;
	}
	else{
		$address=$user_home->dencrypted($address);
	}
	
	$photo = $row['photo'];
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
		$res=$displayfile;
		$log->event_log($res,'d');
		
	$data = [
      'phone' =>$phone,
      'email' => $email,
      'firstName' => $name,
	  'lastName' =>$lastname,
      'country' => $country,
      'address' =>$address,
      'photo' => $res
    ];
	$profile[]=$data;
	echo json_encode($profile);
	$log->event_log( json_encode($profile),'d');
	}
	
	}else{
		echo 'error';
	}
	?>
	