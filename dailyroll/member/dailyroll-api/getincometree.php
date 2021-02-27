<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST'); 
	require_once 'class.user.php';
	$user_home = new USER();
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	$request=file_get_contents('php://input');
	$data = json_decode($request);
	

	$log->event_log(json_encode($data),'d');
	if($data != null){
		$q=$data->q;
		if($q==1){
			$starting_year  =2018;
			$log->event_log($starting_year,'d');
			$ending_year = date('Y');
			$current_year = date('Y');
			$log->event_log($current_year,'d');
			for($starting_year; $starting_year <= $ending_year; $starting_year++) {
				$cars[]=
				[
				'year'=>$starting_year
				];
			}
			echo json_encode($cars);
			$log->event_log(json_encode($cars),'d');
		}
	
	else if($q==2){
		$uid=$data->uid;
		$accountid=$data->accountid;
		$penstatus=$data->penstatus;
		$selectyear=$data->selectyear;
		if($penstatus !='Both'){
		$sql="SELECT * FROM `income` WHERE year(`tr_date`)='$selectyear'  and account_id ='$accountid'  and pendingflag='$penstatus' group by month(`tr_date`) order by  month(`tr_date`) DESC";
		}else{
			
			$sql="SELECT * FROM `income` WHERE year(`tr_date`)='$selectyear'  and account_id ='$accountid'  group by month(`tr_date`) order by  month(`tr_date`) DESC";
		}
		$log->event_log($sql,'d');
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$mydate = $row1['tr_date'];
			$month = date("m",strtotime($mydate));
			$log->event_log($month,'d');
			$log->event_log($selectyear,'d');
			$trdate=$selectyear."-".$month."-01";			
			$monthname=$user_home->getMonth_Name($month);
			$getcategories=$user_home->incomecatbyaccmonth($uid,$month,$accountid,$selectyear,$penstatus);
			$rowcount=$user_home->getincomeacccount($month,$selectyear,$accountid,$penstatus);
			$cars[]=array(
        			"name" => $monthname,
					"income_id"=>'0',
					"accoun"=>$accountid,
					"cat_id"=>'0',
					"capture_id"=>'0',
					"count"=>$rowcount,
					"subcat_id"=>'0',
					"type"=>'busi',
					"username"=>"no",
					"tr_date"=>$trdate,
					"income_amount"=>'0',
					"filepath"=>'aaa',
					"symbol"=>$symbol,
					'description' => $des,
					"accountstatus"=>$status,
					"adminstatus"=>$adminstatus,
					"pendingstatus"=>$penstatus,
					"pendingamount"=>$pendingamount,
					"accountadmin"=>'0',
					"children" =>$getcategories,   

				);
			$getcategories=array();
		}
		print_r(json_encode($cars, true));
		$log->event_log(json_encode($cars),'d');
	}	
		
		
		
		
	
	
	}


  ?>

