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
	//$id=$db->get_id($u_id);
	if(!$u_id == ''){
		$sql="SELECT SUM(income_amount) AS Total  FROM income WHERE `capture_id` ='$u_id' ";
		$stmt = $db->runQuery($sql);
		$stmt->execute(); 
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
			   //echo $sql;
		$expenses= $row['Total'];
	  $count= number_format((float)$expenses, 0, '.', '');
		$cars[]=$count;
		// Sanitize.
		echo json_encode($cars);
		}
		
	else{
		echo json_encode('error');
	}

?>
