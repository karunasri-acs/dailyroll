<?php
header("Access-Control-Allow-Origin: *");
$request=file_get_contents('php://input');
$data = json_decode($request);
$projectname=$data->projectname;
$response= array();	
$servername =  "dinkhoocom.ipagemysql.com";
$username = "jwproddb";
$password = "JwtAcsUSA2018!";
$dbname = "jwtsupport";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `version` FROM `versions` WHERE `projectname`='$projectname'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
	$version=$row['version'];
}
$year = date("Y");
$year1=$year+1;
$response['version']=$version;
$response['present']=$year;
$response['futureyear']=$year1;
$senddata[]=$response;
echo json_encode($senddata);
		//	event_log(json_encode($curr));
?>