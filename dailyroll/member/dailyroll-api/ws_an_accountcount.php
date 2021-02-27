<?php
 header("Access-Control-Allow-Origin: *");
    include 'class.user.php';
	$db = new USER();
// Get the posted data.
    $request=file_get_contents('php://input');
	$data = json_decode($request);

	$u_id=$data->userid;
	//$u_id = '5ba89b3a753e89.85393788';
	//$cars = [];
	$id=$db->get_email($u_id);
	if(!$u_id == ''){
		$sql="SELECT * FROM `groups` WHERE `account_status`='active' and`added_user_id`='$id' group by `account_id` ";
		$stmt = $db->runQuery($sql);
		$stmt->execute(); 
		$count=$stmt->rowcount();
		
		$cars[]=$count;
			// Sanitize.
		echo json_encode($cars);
	}
		
	else{
		echo json_encode('error');
	}

?>
