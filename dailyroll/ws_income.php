<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 */
require_once 'class_user.php';
//require_once 'constants.php';
$db = new USER();
// json response array
$response = array();
    $sql = "SELECT * FROM `income_category`";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//echo$sql;
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//print_r($user);
		// $response['cd_id'] = $row['cd_id'];
		 //$response['cat_name'] = $row['cat_name'];
		 $response[] = $row;
		//print_$response);
		
		}						
		echo json_encode($response);
		
?>

