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

	


	
	$uids=$data->uid;
	$uid=$db->getUseridByUniq($uids);
	$sql="SELECT * FROM  groups  WHERE   `added_user_id`='$uid' group by account_id";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	
	$row=$db->get_accountdetails($row1['account_id']);
	if($uids == $row['user_id']){
				$status=$row['accountstatus'];
	}
	else{
		$status="not";
	}
	$currencyid=$row['currcode'];
	$catergory=$db->getexpensebusinessac($row1['account_id'],$status,$currencyid);
	$excount=$db->getexpensecount($row1['account_id']);
	$incatergory=$db->getincomebusinessac($row1['account_id'],$status,$currencyid);
	$incount=$db->getincomecount($row1['account_id']);
	if($catergory == 'empty'){
		$catergory=[];
		
	}
	
	if($incatergory == 'empty'){
		$incatergory=[];
		
	}
	$default[]=array(
				"name"=>'Expenses',"type"=>"no","status"=>$status,"amount"=>'0',"symbol"=>'0',"id"=>$row1['account_id'],"count"=>$excount,"children" =>$catergory);
	array_push($default,array(
				"name"=>'Income',"type"=>"no","status"=>$status,"amount"=>'0',"symbol"=>'0',"id"=>$row1['account_id'],"count"=>$incount,"children" =>$incatergory));
			
	$cars[]=array(
        			"name" => $row['accountname'],
					"id"=>$row1['account_id'],
					"type"=>'business',
					"status"=>$status,
					"accname"=>'noname',
					"busname"=> $row['accountname'],
					"subcatname"=>"noname",
					"showtype"=>"no",
					"amount"=>'0',
					"symbol"=>'0',
					"count"=>'0',
        			"children" => $default,   
				);
	
	$default=array();
    
 }
	print_r(json_encode($cars, true));
?>
