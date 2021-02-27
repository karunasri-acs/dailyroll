<?php
require_once 'class_user.php';
$db = new USER();

// json response array
$response = array();
$data = json_decode(file_get_contents('php://input'), true);
	//$db->event_log("begining of banner ",basename(__FILE__));
	$display=DISPLAY_DIR;

	if (isset($_POST['uid'])) {
	$name = $_POST['uid'];
		//$db->event_log($name,basename(__FILE__));
//	echo $name ='lovely';
  $output["error"] = FALSE;
  $output["message"]="success";
	$sql="SELECT * FROM `advertisement` WHERE page='Mobile' ORDER BY id DESC LIMIT 20";
			//$db->event_log($sql,basename(__FILE__));
    $stmt = $db->runQuery($sql);
    $stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
	$banner=$row['banner'];
	$displayfile1=str_replace('../','',$banner);
			$displayfile=str_replace('uploads/content','content',$displayfile1);
			$img =$display.$displayfile;
		
		$response["url"] = $row["weburl"];
		$response["pic"] = $img;
		$sendres[]=$response;
		 }
		  $output['bannerdata']=$sendres;
    echo json_encode($output);
	 //$db->event_log(json_encode($output),basename(__FILE__));
	
}


?>

