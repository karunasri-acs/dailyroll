<?php
require_once 'class_user.php';
$user_home = new USER();


	if (isset($_POST['uid'])) {
		$uid=$_POST['uid'];
		$userid=$user_home->getUseridByUniq($uid);
		
		$paiddate=date('Y-m-d');
		$ex_date = date('Y-m-d', strtotime("+12 month", strtotime($paiddate)));
		$sql3="UPDATE `subscriber` SET `paiddate`='$paiddate',`expiry_date`='$ex_date' WHERE `user_id`='$userid'";
		$stmt3 = $user_home->runQuery($sql3);
		$stmt3->execute();
		
		$sql1="UPDATE `users` SET `usertype`='validuser' WHERE user_id='$userid'";
		$stmt1 = $user_home->runQuery($sql1);
		$stmt1->execute();
		
		$sql="select * from `users`   WHERE user_id='$userid'";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		$user=$stmt->fetch(PDO::FETCH_ASSOC);
		
	    $response["error"] = FALSE;
		$response["error_msg"] = "Success";
        $response["uid"] = $user["unique_id"];
        $response["name"] = $user["name"];
        $response["email"] = $user_home->dencryptedstatic($user['email']);
        $response["created_at"] = $user["created_at"];
        $response["updated_at"] = $user["updated_at"];
		$response["phone"] = $user["phone"];
        echo json_encode($response);
		event_log(json_encode($response));
	}
     else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "uid is missing";
		echo json_encode($response);
		event_log(json_encode($response));
        
    }

?>

