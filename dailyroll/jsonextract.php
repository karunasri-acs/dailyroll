<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();
$id = $_SESSION['userSession'];
$unid = $_SESSION['unique_ID'];


	
	$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE `account_id`='$accid'" ;
	$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  `account_id`='$accid'";
	$sql1="select subcat_id,SUM(amount) as number from `expenses` where account_id ='$accid'";
	$sql1=$sql1."GROUP BY `subcat_id`";
	$stmt1=$user_home->runQuery($sql1);
	$stmt1->execute();

	while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
		$category_name=$user_home->get_subcategory($row1['subcat_id']);
		$category=$category_name;
		$response['y'] = $row1['number'];
		$response['label'] = $category;
		$responsearray[] = $response;
	}
	$stmt2=$user_home->runQuery($sql);
	$stmt2->execute();
	$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
	$stmt1=$user_home->runQuery($sql2);
	$stmt1->execute();
	$row1=$stmt1->fetch(PDO::FETCH_ASSOC);
	$percentage = $row2['expenses'];
	$percentage1 = $row1['income'];
	$dataPoints = array( 
				  array("label"=>"Expenses", "y"=>$percentage),
				  array("label"=>"Income", "y"=>$percentage1),
					
				 )	
?>
