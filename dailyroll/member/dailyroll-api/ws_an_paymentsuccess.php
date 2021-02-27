<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST'); 
	//session_start();
	require_once 'class.user.php';
	$user_home = new USER();

	$request=file_get_contents('php://input');
	$data = json_decode($request);
	if($data != null){
	$uid=$data->uid;
	$id=$user_home->get_email($uid);
	$paiddate=date('Y-m-d');
				$ex_date = date('Y-m-d', strtotime("+12 month", strtotime($paiddate)));
	
 $sql2 = "SELECT * FROM `subscriber` WHERE `user_id`= '$id'";
$stmt2 = $user_home->runQuery($sql2);
				$stmt2->execute();
				//echo $sql2;
				$row = $stmt2->fetch(PDO::FETCH_ASSOC);
				 $count=$stmt2->rowCount();
				$date= $row['expiry_date'];
				if($count == 0 ){
				//echo $paiddate;
				$sql="INSERT INTO `subscriber`( `user_id`, `paiddate`, `expiry_date`) VALUES ('$id','$paiddate','$ex_date')";
				$stmt = $user_home->runQuery($sql);
				$stmt->execute();	
				$sql1="UPDATE `users` SET `usertype`='validuser' WHERE user_id='$userid'";
				$stmt1 = $user_home->runQuery($sql1);
				$stmt1->execute();
				}
				else{
				$sql3="UPDATE `subscriber` SET `paiddate`='$paiddate',`expiry_date`='$ex_date' WHERE `user_id`='$id'";
				$stmt3 = $user_home->runQuery($sql3);
				$stmt3->execute(); 
				$sql1="UPDATE `users` SET `usertype`='validuser' WHERE user_id='$id'";
				$stmt1 = $user_home->runQuery($sql1);
				$stmt1->execute();
				//echo $sql1;	
				}
	echo json_encode('Feedback added Successfully');
	 //echo "Data saved successfully.";
	}
?>

