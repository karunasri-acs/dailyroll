<?php
header("Access-Control-Allow-Origin: *");
include 'class.user.php';
$db = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
// Get the posted data.
$request=file_get_contents('php://input');
$data = json_decode($request);
$u_id=$data->uid;
//$u_id='5c2dcee2e21538.17188314';

 $id=$db->getuserid($u_id);
 $accountid=$data->accountid;
 $type=$data->type;
 $cat_id=$data->catid;
 $subcat_id=$data->subcatid;

/*
 if(!$data == ''){*/
	$q=$data->q;
	//$q =1;
	$log->event_log($q,'d');
	//5d30d6019ae6a1.53712840
    if($q == 1){
    $sql="SELECT * FROM  groups a,accounts b  WHERE a.account_id=b.account_id and  a.`account_status`='active'  and a.group_status ='Y' and a.userstatus ='active' and a.`added_user_id`='$id' and  a.usertype = 'writeonly' and b.accountstatus='active'  group by a.account_id";
	$log->event_log($sql,'d');
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	$row=$db->get_accountdetails($row1['account_id']);
	$cars[]=$row;
	}
	echo json_encode($cars);
	//$log->event_log(json_encode($cars));
	} 
	else if($q == 2){
	if($type==1){
   $sql = "SELECT * FROM `category` WHERE `account_id`='$accountid' AND `cat_type`='expenses' and status ='active'";
   }else if($type==2){
   $sql = "SELECT * FROM `category` WHERE `account_id`='$accountid' AND `cat_type`='income' and status ='active'";
   
   }
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,'d');
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	$response["cat_id"] = $row["cat_id"]; 
	$response["cat_name"] = $row["cat_name"];
	$responsearray[] = $response;
	}
	echo json_encode($responsearray);
	//$log->event_log(json_encode($responsearray));
	
	}
	else if($q == 3){

    $sql = "SELECT * FROM `sub_category` WHERE `cat_id`='$cat_id' and status ='active'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	$log->event_log($sql,'d');
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		
	$response["sub_id"] = $row["subcat_id"]; 
	$response["subcat_name"] = $row["subcat_name"];
	$responsearray[] = $response;
	//print_$response);
	$log->event_log($responsearray,'d');
	}						
	echo json_encode($responsearray);
	//$log->event_log(json_encode($responsearray));
	$log->event_log("ending of get subcategory",'d');
	}
	else if($q  == 5){
	$sql1="SELECT * FROM `category` a, accounts b WHERE a.`account_id`=b.account_id and b.user_id='$u_id' and status ='active'";
	$stmt = $db->runQuery($sql1);
	$stmt->execute();
	while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	
		$cat_name=$row1['cat_name'];
		$cat_id=$row1['cat_id'];
		$cat_type=$row1['cat_type'];		 
	

		$data=[
			
			 'cat_type' => $cat_type,
			 'cat_id'    => $cat_id,
			'cat_name'    => $cat_name,
			
	  
			];
		$output[]=$data;
	}
    echo json_encode($data);
	//$log->event_log(json_encode($data));
	
	}
	else if($q == 6){

    $sql = "SELECT * FROM `sub_category` WHERE `subcat_id`='$subcat_id'  and status ='active'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//echo $sql;
	//$log->event_log($sql,true);
	//$response =  array();
	//$x = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	$response["amount"] = $row["amount"]; 
	$responsearray[] = $response;
	//print_$response);
	
	}						
	echo json_encode($responsearray);
	//$log->event_log(json_encode($responsearray));
	$log->event_log("ending of get amount",'d');
	}
		else if($q == 7){
if($type =='Income'){
   $sql = "SELECT * FROM `category` WHERE `account_id`='$accountid' AND `cat_type`='income' and status ='active'";
 }else{
  $sql = "SELECT * FROM `category` WHERE `account_id`='$accountid' AND `cat_type`='expenses' and status ='active'";

 }
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,true,'d');
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	$response["cat_id"] = $row["cat_id"]; 
	$response["cat_name"] = $row["cat_name"];
	$responsearray[] = $response;
	}
	echo json_encode($responsearray);
	//$log->event_log(json_encode($responsearray));
	
	}
	 else if($q == 8){
    $sql="SELECT * FROM  accounts  WHERE  `account_status`='active' and `user_id`='$u_id'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	$cars[]=$row1;
	}
	echo json_encode($cars);
	//$log->event_log(json_encode($cars));
	
	}
	else if($q == 9){
     $sql="SELECT * FROM  groups a, accounts b   WHERE  a.account_id = b.account_id and b.user_id='$u_id' and a.`account_status`='active'  and a.group_status ='Y' and a.userstatus ='active' and a.`added_user_id`='$id' group by a.account_id";
	$log->event_log($sql,'d');
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	$row=$db->get_accountdetails($row1['account_id']);
	$cars[]=$row;
	}
	echo json_encode($cars);
	//$log->event_log(json_encode($cars));
	}
	else if($q == 10){
     $sql="SELECT * FROM  groups  WHERE  `account_status`='active'  and group_status ='Y' and userstatus ='active' and `added_user_id`='$id'  group by account_id";
	$log->event_log($sql,'d');
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	$row=$db->get_accountdetails($row1['account_id']);
	$cars[]=$row;
	}
	echo json_encode($cars);
	//$log->event_log(json_encode($cars));
	}
	/*
}else{
		echo json_encode('error');
	}*/

?>

