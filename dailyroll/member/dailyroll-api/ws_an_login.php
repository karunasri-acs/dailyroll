<?php
	header("Access-Control-Allow-Origin: *");
	include 'class.user.php';
	$db = new USER();
	require_once 'googleLib/GoogleAuthenticator.php';
	$ga = new GoogleAuthenticator();
	$secret = $ga->createSecret();	
	$request=file_get_contents('php://input');
	$data = json_decode($request);
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	$originalemail=$data->username;
	$email=$db->encryptedstatic($originalemail);
	$password=$data->password;
	//$email='kuru@gmail.com';
	//$password='abc123';
	$datas= [];
  // get the user by email and password
    $user = $db->getUserByEmailAndPassword($email,$password,$secret);
$log->event_log($email,'d');
$log->event_log($password,'d');
    if ($user) {
		$log->event_log(json_encode($user),'d');
        // use is found
        //$data["error"] = FALSE;
		$id=$user["user_id"];
    $sql1="select * from `profile` where `user_id`='$id'";
	$log->event_log($sql1,'d');
	$stmt1 = $db->runQuery($sql1);
	$stmt1->execute();
	// echo $sql;			
	$row= $stmt1->fetch(PDO::FETCH_ASSOC);
	$photo = $row['photo'];
	$displayfile1=str_replace('"','',$photo);
		$display=str_replace('../','',$displayfile1);
		$url=DISPLAY_DIR.'/content/dailyroll/profile/';
		$displayfile=$url.$display;
		$res=$displayfile;
	
       $datas["uid"] = $user["unique_id"];
       $datas["name"] = $db->dencrypted($user["name"]);
       $datas["email"] = $db->dencryptedstatic($user["email"]);
       $datas["usertype"] = $user["usertype"];
	   $datas["userid"] = $id;
       $datas["photo"] = $res;
		/* $car = [
      'uid' => $user["unique_id"],
      'name' => $user["name"],
      'email'    => $user["email"]
    ];
	  echo json_encode(['data'=>$car]);*/
       // $data["created_at"] = $user["created_at"];
        //$data["updated_at"] = $user["updated_at"];
		//$data["phone"] = $user["phone"];
		$dataarray[] = $datas;
		//header('Content-Type: application/json');
        echo json_encode($dataarray);
		$log->event_log(json_encode($dataarray),'d'); 
    }
?>

