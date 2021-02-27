<?php
header("Access-Control-Allow-Origin: *");
include 'class.user.php';
$db = new USER();
// Get the posted data.
$request=file_get_contents('php://input');
$data = json_decode($request);
//$u_id='5c2dcee2e21538.17188314';
$sql="SELECT * FROM `newsfeed` ORDER by `newsid` DESC";
			$stmt = $db->runQuery($sql);
			$stmt->execute();
			while($user = $stmt->fetch(PDO::FETCH_ASSOC)){
			$filepath=$user['filename'];
			 $displayfile1=str_replace('"','',$filepath);
			$display=str_replace('../','',$displayfile1);
			$url1='https://www.dailyroll.org/dailyroll-api/';
			$dd=$url1.$countrycode.'/news/'.$display;
			$url=$dd;
			 $cars=[
			 'desc'=>$user['shortdesc'],
			 'sdate'=>$user['date'],
			 'id'=>$user['newsid'],
			 'link'=>$url
			 
			 ];
			 $dataarray[]=$cars;
			 
			
			}
			echo json_encode($dataarray);

	

?>

