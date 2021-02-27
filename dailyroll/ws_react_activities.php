<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 

$data = json_decode(file_get_contents('php://input'), true);
$log->event_log(json_encode($data),'d');
 if (isset($data['userid'])  && isset($data['type'])){
    $log->event_log("begining of table ",'d');
	$captid = $data['userid'];
	//$account_id = '2';
	$log->event_log($account_id,'d');
	$cat_type = $data['type'];
	//$cat_type = 'expenses';
	$log->event_log($captid,'d');
	
	if($cat_type == 1){
	$sql = "SELECT  a.income_id as id,a.account_id as accid,a.cat_id ,a.subcat_id ,a.income_amount as amount,a.description,a.tr_date,b.accountname,a.file_name FROM `income` a , accounts b WHERE a.account_id=b.account_id and a.`capture_id`='$captid' order by a.income_id desc limit 15";
	}else{
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,b.accountname,a.file_name FROM `expenses` a,accounts b WHERE  a.account_id=b.account_id and a.`capture_id`='$captid' order by a.id desc limit 15";
		
	}
	$log->event_log($sql,'d');
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,'d');
	$rowcount=$stmt->rowcount();
	if($rowcount > 0){
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		
		$photo=$row['file_name'];
		$result = substr($photo, 0, 3);
			if($result=='aaa'){
				$file='nofile';
			}
			else{
				$displayfile1=str_replace('"','',$photo);
				$display=str_replace('../','',$displayfile1);
				$displays=str_replace('uploads/content','/content',$display);
				$url=DISPLAY_DIR;
				$file=$url.$displays;
			}
		$res=[
			'id'=>$row['id'],
			'accid'=>$row['accid'],
			'cat_id'=>$row['cat_id'],
			'subcat_id'=>$row['subcat_id'],
			'amount'=>$row['amount'],
			'tr_date'=>$row['tr_date'],
			'description'=>$row['description'],
			'accountname'=>$row['accountname'],
			'file_name'=>$file
		
		
		];
	$responsearray[] = $res;
	}						
		$response["error"] = FALSE;
		$response["datashow"] =$responsearray ;
		echo json_encode($response);
		$log->event_log(json_encode($response),'d');
	}
	else{
		$response["error"] = TRUE;
		$response["error_msg"] = "No data available";
		echo json_encode($response);
		$log->event_log("Required Pa missing",'e');    	
		
	}
 }
else {
	$response["error"] = TRUE;
    $response["error_msg"] = "Required Parameters are missing";
	echo json_encode($response);
	$log->event_log("Required Pa missing",'e');      
  }


?>

