<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST'); 
	//session_start();
	require_once 'class.user.php';
	$user_home = new USER();
	
	//echo "hello everyone";
	$request=file_get_contents('php://input');
	$data = json_decode($request);
	
	$useremail=$data->email;
	$subject=$data->subject;
	$message=$data->description;
	$feedback=$data->type;
	$filepath=$data->filename;
	/*$email="nandinirouthu23@gmail.com";
	$coments="delete it";
	$feedback="suggestion";
	*/
	$date=date('Y-m-d');
	if($data != null){
	$sql="INSERT INTO `feedback`(`email`, `subject`, `date`, `description`,`requesttype`, `status`,`document`) VALUES ('$useremail','$subject','$date','$message','$feedback','new','$filepath')";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	//print_r($row);
	echo json_encode('Feedback added Successfully');
	 //echo "Data saved successfully.";
	}
	else{
		echo json_encode("error while adding feedback.");
	}
?>

