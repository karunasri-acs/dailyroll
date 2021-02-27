<?php
 header("Access-Control-Allow-Origin: *");
    include 'class.user.php';
	$user_home = new USER();
	
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d');  
// Get the posted data.

$request=file_get_contents('php://input');
$data = json_decode($request);

$log->event_log('begining of the balance sheet','d');	
if(!$data == ''){	
	$accid=$data->accountid;
	$log->event_log($accid,'d');
	$durationtype = $data->type;
	$log->event_log($durationtype,'d');
	$status = $data->status;
	$log->event_log($status,'d');
	$month=date('m');
	$log->event_log($month,'d');
	$year=date('Y');
	$log->event_log($year,'d');
	if($durationtype =='' or $durationtype =='undefined'){
	$durationtype='UntillToday';
	}
	else{
	$durationtype =$durationtype;
	}
	if($accid !='' and $accid !='undefined'){
	if($status == 'All'){
		if($durationtype =='CurrentMonth'){  
			$sql = "SELECT * FROM `expenses` WHERE `account_id`='$accid' and month(`tr_date`)='$month' and year(`tr_date`)='$year'";
			$sql1 = "SELECT * FROM `income` WHERE `account_id`='$accid'  and month(`tr_date`)='$month' and year(`tr_date`)='$year'" ;
			$ex2 = "SELECT sum(amount) as expenseamount FROM `expenses` WHERE `account_id`='$accid' and month(`tr_date`)='$month' and year(`tr_date`)='$year'" ;
			$ex3 = "SELECT sum(income_amount) as incomeamount FROM `income` WHERE `account_id`='$accid' and month(`tr_date`)='$month' and year(`tr_date`)='$year'" ;
		}
		elseif($durationtype =='CurrentYear'){
			$sql = "SELECT * FROM `expenses` WHERE `account_id`='$accid' and year(`tr_date`)='$year'" ;
			$sql1 = "SELECT * FROM `income` WHERE `account_id`='$accid'  and year(`tr_date`)='$year'" ;
			$ex2 = "SELECT sum(amount) as expenseamount FROM `expenses` WHERE `account_id`='$accid' and year(`tr_date`)='$year'" ;
			$ex3 = "SELECT sum(income_amount) as incomeamount FROM `income` WHERE `account_id`='$accid'  and year(`tr_date`)='$year'" ;
		
		}
		elseif($durationtype =='UntillToday'){
			$sql = "SELECT * FROM `expenses` WHERE `account_id`='$accid'" ;
			$sql1 = "SELECT * FROM `income` WHERE `account_id`='$accid'" ;
			$ex2 = "SELECT sum(amount) as expenseamount FROM `expenses` WHERE `account_id`='$accid'" ;
			$ex3 = "SELECT sum(income_amount) as incomeamount FROM `income` WHERE `account_id`='$accid'" ;
		
		}

	}
	else{
		if($durationtype =='CurrentMonth'){  
			$sql = "SELECT * FROM `expenses` WHERE `account_id`='$accid' and month(`tr_date`)='$month' and year(`tr_date`)='$year' and pendingflag='$status'" ;
			$sql1 = "SELECT * FROM `income` WHERE `account_id`='$accid'  and month(`tr_date`)='$month'and year(`tr_date`)='$year' and pendingflag='$status'" ;
			$ex2 = "SELECT sum(amount) as expenseamount FROM `expenses` WHERE `account_id`='$accid' and month(`tr_date`)='$month' and year(`tr_date`)='$year' and pendingflag='$status'" ;
			$ex3 = "SELECT sum(income_amount) as incomeamount FROM `income` WHERE `account_id`='$accid' and month(`tr_date`)='$month' and pendingflag='$status'" ;
		}
		elseif($durationtype =='CurrentYear'){
			$sql = "SELECT * FROM `expenses` WHERE `account_id`='$accid' and year(`tr_date`)='$year' and pendingflag='$status'" ;
			$sql1 = "SELECT * FROM `income` WHERE `account_id`='$accid'  and year(`tr_date`)='$year' and pendingflag='$status'" ;
			$ex2 = "SELECT sum(amount) as expenseamount FROM `expenses` WHERE `account_id`='$accid' and year(`tr_date`)='$year' and pendingflag='$status'" ;
			$ex3 = "SELECT sum(income_amount) as incomeamount FROM `income` WHERE `account_id`='$accid'  and year(`tr_date`)='$year' and pendingflag='$status'" ;
		
		}
		elseif($durationtype =='UntillToday'){
			$sql = "SELECT * FROM `expenses` WHERE `account_id`='$accid' and pendingflag='$status' " ;
			$sql1 = "SELECT * FROM `income` WHERE `account_id`='$accid' and pendingflag='$status'" ;
			$ex2 = "SELECT sum(amount) as expenseamount FROM `expenses` WHERE `account_id`='$accid' and pendingflag='$status'" ;
			$ex3 = "SELECT sum(income_amount) as incomeamount FROM `income` WHERE `account_id`='$accid' and pendingflag='$status'" ;
		
		}
	}
	$log->event_log($sql,'d');
	$log->event_log($sql1,'d');
	$stmt1 = $user_home->runQuery($sql1);
	$stmt1->execute();
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$log->event_log($ex2,'d');
	$log->event_log($ex3,'d');
	$stex2 = $user_home->runQuery($ex2);
	$stex2->execute();
	$stex3 = $user_home->runQuery($ex3);
	$stex3->execute();
	$log->event_log($ex2,'d');
	$log->event_log($ex3,'d');
	$rowex2=$stex2->fetch(PDO::FETCH_ASSOC);
	$rowex3=$stex3->fetch(PDO::FETCH_ASSOC);
	$expensetotal=$rowex2['expenseamount'];
	$incometotal=$rowex3['incomeamount'];
	$log->event_log($expensetotal,'d');
	$log->event_log($incometotal,'d');
	$i=1;
	$curr=$user_home->get_accountdetails($accid);
	$currencyid=$curr['currcode'];
	$symbol=$user_home->getCurrency_symbol($currencyid);
	while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
		$data1[$i]=$row1;
		$i++;
	}
	$log->event_log(json_encode($data1),'d');
	$incomerecord=sizeof($data1);
		$log->event_log($incomerecord,'d');
	$x=1;
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		$data2[$x]=$row;
		$x++;
	}
	$log->event_log(json_encode($data2),'d');
	$expenserecord=sizeof($data2);
	$log->event_log($expenserecord,'d');
	$calsum=$incometotal-$expensetotal;
	if($incomerecord >=$expenserecord){
		$i=1;
		while($i <= $incomerecord ){
			$incomeamountstatus=$data1[$i]['pendingflag'];				
			$expamountstatus=$data2[$i]['pendingflag'];	
			if($incomeamountstatus == 'non-pending'){
					$incomenondue=$data1[$i]['income_amount'];
					$incomedue='0';
			}else{
					$incomedue=$data1[$i]['income_amount'];
					$incomenondue='0';
			}
			if($expamountstatus == 'non-pending'){
					$expensenondue=$data2[$i]['amount'];
					$expensedue='0';
			}else{
					$expensedue=$data2[$i]['amount'];
					$expensenondue='0';
			}			
			$result=[
					'incomedate'=>$data1[$i]['tr_date'],
					'incomedesc'=>$data1[$i]['description'],
					'incomedueamount'=>$incomedue,
					'incomenondueamount'=>$incomenondue,
					'expensedate'=>$data2[$i]['tr_date'],
					'expensedesc'=>$data2[$i]['description'],
					'expenseduenonamount'=>$expensenondue,
					'expensedueamount'=>$expensedue,
					'totalexpenseamount'=>$expensetotal,
					'totalincomeamount'=>$incometotal,
					'calculatesum'=>$calsum,
					'curr'=>$symbol
										
					];
				$res[]=$result;
				$i++;
			}
									
		}
	else{
			$i=1;
			while($i <= $expenserecord ){
			$incomeamountstatus=$data1[$i]['pendingflag'];				
			$expamountstatus=$data2[$i]['pendingflag'];	
			if($incomeamountstatus == 'non-pending'){
					$incomenondue=$data1[$i]['income_amount'];
					$incomedue='0';
			}else{
					$incomedue=$data1[$i]['income_amount'];
					$incomenondue='0';
			}
			if($expamountstatus == 'non-pending'){
					$expensenondue=$data2[$i]['amount'];
					$expensedue='0';
			}else{
					$expensedue=$data2[$i]['amount'];
					$expensenondue='0';
			}	
				$result=[
							'incomedate'=>$data1[$i]['tr_date'],
							'incomedesc'=>$data1[$i]['description'],
							'incomedueamount'=>$incomedue,
							'incomenondueamount'=>$incomenondue,
							'expensedate'=>$data2[$i]['tr_date'],
							'expensedesc'=>$data2[$i]['description'],
							'expenseduenonamount'=>$expensenondue,
							'expensedueamount'=>$expensedue,
							'totalexpenseamount'=>$expensetotal,
							'totalincomeamount'=>$incometotal,
							'calculatesum'=>$calsum,
							'curr'=>$symbol
										
						];
				$res[]=$result;
				$i++;
			}
									
		}
	echo json_encode($res);
	$log->event_log(json_encode($res),'d');
	}
	else{
$log->event_log('no accountid');
	}
	
	}
	

?>
