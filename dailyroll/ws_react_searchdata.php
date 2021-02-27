<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 

$data = json_decode(file_get_contents('php://input'), true);
$log->event_log(json_encode($data),'d');

$accountid=$data['businessid'];
$catid=$data['accountid'];
$subcatid=$data['subaccid'];
$des=$data['description'];
$expdate=$data['expdate'];
$todate=$data['todate'];
$type=$data['type'];
if($accountid !=''){
if($expdate !='' && $todate !=''){

if(($expdate <= $todate)){
	
	
}
else{
	$response["error"] = True;
	$response["error_msg"] = "Fromdate must be lessthan todate";
	echo json_encode($response);
	exit;
}	
	
}

if($type == '0'){
	if ($accountid !='' && $catid !='' && $subcatid !='' && $des !='' && $expdate !='' && $todate !='' ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid' and a.description='$des' and a.tr_date  BETWEEN '$expdate' AND  '$todate' order by a.id desc limit 15";
		
	}elseif ($accountid !='' && $catid !='' && $subcatid !='' && $des !='' && $expdate !=''  ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid' and a.description='$des' and a.tr_date  = '$expdate'  order by a.id desc limit 15";
		
	}else if ($accountid !='' && $catid !='' && $subcatid !='' && $des !=''  && $todate !='' ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid' and a.description='$des' and a.tr_date  =  AND  '$todate' order by a.id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $subcatid !='' && $expdate !='' && $todate !='' ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid'  and a.tr_date  BETWEEN '$expdate' AND  '$todate'  order by a.id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $subcatid !='' && $des !=''  ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid' and a.description='$des' order by a.id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $subcatid !='' && $todate !=''   ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid'   and a.tr_date  = '$todate' order by a.id desc limit 15";
		
	
	}
	else if ($accountid !='' && $catid !='' && $expdate !=''  && $todate !='' ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid'  and a.tr_date  BETWEEN '$expdate' AND  '$todate' order by a.id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $subcatid !='' && $expdate !=''   ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid'  and a.tr_date  = '$expdate' order by a.id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $subcatid !='' && $todate !=''   ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid'  and a.tr_date  = '$todate' order by a.id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $subcatid !=''  ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid' order by a.id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $expdate !=''  && $todate !=''  ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.tr_date  BETWEEN '$expdate' AND  '$todate' order by a.id desc limit 15";
		
	}else if ($accountid !='' && $catid !='' && $expdate !=''  ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid'  and a.tr_date  = '$expdate' order by a.id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $todate !=''  ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid'   and a.tr_date  = '$todate' order by a.id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !=''  ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.cat_id='$catid' order by a.id desc limit 15";
		
	}
	else if ($accountid !=''  && $des !='' && $expdate !='' && $todate !='' ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid'  and a.description='$des' and a.tr_date  BETWEEN '$expdate' AND  '$todate' order by a.id desc limit 15";
		
	}
	else if ($accountid !=''  && $expdate !='' && $todate !='' ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid'  and a.tr_date  BETWEEN '$expdate' AND  '$todate'  order by a.id desc limit 15";
		
	}
	else if ($accountid !=''  && $des !=''){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid'  and a.description='$des' order by a.id desc limit 15";
		
	}
	else if ($accountid !='' && $todate !='' ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid' and a.tr_date  = '$expdate'  order by a.id desc limit 15";
		
	}
	else if ($accountid !=''  && $expdate !='' ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid'  and a.tr_date  = '$expdate'  order by a.id desc limit 15";
		
	}
	else if ($accountid !=''  ){
		$sql = "SELECT a.id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.amount,a.description,a.tr_date,a.file_name FROM `expenses` a WHERE a.account_id='$accountid'  order by a.id desc limit 15";
		
	}
	
}
else{
	//all fields
	if ($accountid !='' && $catid !='' && $subcatid !='' && $des !='' && $expdate !='' && $todate !='' ){
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid' and a.description='$des'  and a.tr_date  BETWEEN '$expdate' AND  '$todate'order by a.income_id desc limit 15";
		
	}else if ($accountid !='' && $catid !='' && $subcatid !='' && $des !='' && $expdate !='' && $todate =='' ){
		//all fields except todate
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid' and a.description='$des'  and a.tr_date ='$expdate' order by a.income_id desc limit 15";
		
	}else if ($accountid !='' && $catid !='' && $subcatid !='' && $des !='' && $expdate =='' && $todate !='' ){
		//all fields except expdate
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid' and a.description='$des'  and a.tr_date ='$todate' order by a.income_id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $subcatid !='' && $expdate !=''  && $todate !=''){
		//all fields with out desc
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid'   and a.tr_date  BETWEEN '$expdate' AND  '$todate' order by a.income_id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $subcatid !='' && $expdate !='' ){
		//with out ddesc and todate
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid'   and a.tr_date  ='$expdate' order by a.income_id desc limit 15";
		
	}else if ($accountid !='' && $catid !='' && $subcatid !='' && $todate !='' ){
		//without desc and expdate
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid'   and a.tr_date  ='$todate' order by a.income_id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $subcatid !='' && $des !=''  ){
		//without dates 
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid' and a.description='$des' order by a.income_id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !='' && $subcatid !=''  ){

		//with out dates and desc
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.subcat_id='$subcatid' order by a.income_id desc limit 15";
		
	}
	else if ($accountid !='' && $catid !=''  && $expdate !=''  && $todate !=''  ){
		//without desc subcat 
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.tr_date  BETWEEN '$expdate' AND  '$todate' order by a.income_id desc limit 15";
		
	}else if ($accountid !='' && $catid !=''  && $expdate !=''  ){
		//without desc subcat and todate
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.tr_date  = '$expdate' order by a.income_id desc limit 15";
		
	}else if ($accountid !='' && $catid !=''  && $todate !=''  ){
		//without desc subcat and expdate
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.cat_id='$catid' and a.tr_date  = '$todate' order by a.income_id desc limit 15";
		
	}
	else if ($accountid !=''  && $des !='' && $expdate !=''  && $todate !=''){
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid'  and a.description='$des'  and a.tr_date  BETWEEN '$expdate' AND  '$todate' order by a.income_id desc limit 15";
		
	
	}else if ($accountid !='' && $todate !=''  ){
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.tr_date  = '$todate'  order by a.income_id desc limit 15";
		
	}else if ($accountid !='' && $expdate !=''  ){
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid' and a.tr_date  = '$expdate'  order by a.income_id desc limit 15";
		
	}else if ($accountid !=''  && $expdate !=''  && $todate !=''){
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid'   and a.tr_date  BETWEEN '$expdate' AND  '$todate' order by a.income_id desc limit 15";
		
	}else if ($accountid !=''  && $des !=''){
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid'  and a.description='$des' order by a.income_id desc limit 15";
		
	}else if ($accountid !=''  ){
		$sql = "SELECT a.income_id as id,a.account_id as accid,a.cat_id,a.subcat_id,a.income_amount as amount,a.description,a.tr_date,a.file_name FROM `income` a WHERE a.account_id='$accountid'   order by a.income_id desc limit 15";
		
	}
	
	
	
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
				$log->event_log($photo,'d');
				$displayfile1=str_replace('"','',$photo);
				$display=str_replace('../','',$displayfile1);
				$log->event_log($display,'d');
				$displays=str_replace('uploads/content','/content',$display);
				$log->event_log($displays,'d');
				$url=DISPLAY_DIR;
				$file=$url.$displays;
			}
			$accid=$row['accid'];
		$account=$user_home->get_accountdetails($accid);
		
	$res=[
		'id'=>$row['id'],
		'accid'=>$row['accid'],
		'cat_id'=>$row['cat_id'],
		'subcat_id'=>$row['subcat_id'],
		'amount'=>$row['amount'],
		'tr_date'=>$row['tr_date'],
		'description'=>$row['description'],
		'accountname'=>$account['accountname'],
		'file_name'=>$file
	
	
	];
	$responsearray[] = $res;
	}						
	$response["error"] = False;
	$response["datashow"] =$responsearray ;
	echo json_encode($response);
	$log->event_log(json_encode($response),'d');
	}
	else{
		
	
	$response["error"] = True;
	$response["error_msg"] = "No data  to show";
	echo json_encode($response);
	

	}
}else{
		
	
	$response["error"] = True;
	$response["error_msg"] = "Please Select Bussiness";
	echo json_encode($response);
	

	}

?>

