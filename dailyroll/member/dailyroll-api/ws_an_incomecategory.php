<?php
 header("Access-Control-Allow-Origin: *");
    include 'class.user.php';
	$db = new USER();
// Get the posted data.
   /* $request=file_get_contents('php://input');
	$data = json_decode($request);

	//$u_id=$data->userid;
	$u_id = '5ba89b3a753e89.85393788';*/
	$cars = [];
	//if(!$u_id == ''){
		
		$sql="SELECT * FROM `income_category`";
						
		$stmt = $db->runQuery($sql);
		$stmt->execute();
			//echo $sql;
		while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$cars["catid"]=$row1['cd_id'];
			//$accountname=$row1['cat_name'];
			$cars["catname"]=$row1['cat_name'];
			$data[]=$cars;
			// Sanitize.
		}
		echo json_encode($data);
	/*}else{
		echo json_encode('error');
	}*/

?>
