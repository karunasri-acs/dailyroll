<?php
 header("Access-Control-Allow-Origin: *");
    include 'class.user.php';
	$db = new USER();
// Get the posted data.
    $request=file_get_contents('php://input');
	$data = json_decode($request);

	$u_id=$data->docid;
	//$u_id = '1';
	//$cars = [];
	if(!$u_id == ''){
		
		$sql = "SELECT * FROM `expenses` WHERE `id` = '$u_id'";
		$stmt = $db->runQuery($sql);
		$stmt->execute();		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	    $filepath=$row['file_name'];
		$displayfile1=str_replace('"','',$filepath);
		$display=str_replace('../','',$displayfile1);
		//echo $display;
		//$displayfile = DIR_APPLICATION_REQUEST."/".$college_id."/".$row['application_number']."/".$row['document_name'];
		//$displayfile=
	//	$url='http://apps.dinkhoo.com/';
	$url="https://upload.dailyroll.org/";
		$displayfile=$url.$display;
		$data=['photo' =>$displayfile];
	    $cars[]=$data;
	
		echo json_encode($cars);
	}else{
		echo json_encode('error');
	}

?>
