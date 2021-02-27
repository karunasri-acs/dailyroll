<?php
	//require_once 'class.user.php';
	$servername = 'localhost' ;
	$username = 'root' ;
	$password = '' ;
	$dbname = 'support' ;
	$connect = new mysqli($servername, $username, $password, $dbname);
	if($connect->connect_error) {
		die("Connection Failed : " . $connect->connect_error);
	} else {
		// echo "Successfully Connected";
	} 

?>