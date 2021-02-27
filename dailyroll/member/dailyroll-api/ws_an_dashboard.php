<?php
 header("Access-Control-Allow-Origin: *");
    include 'class.user.php';
	$db = new USER();
// Get the posted data.
$request=file_get_contents('php://input');
$data = json_decode($request);
	
	$uid=$data->userid;
	$accid=$data->accountid;
	//$period=$data->period;
	$category=$data->catid;
	$rptype=$data->periodtype;
	$presentdate=date("Y-m-d");
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	
	$id=$db->get_email($uid);
/*
if(!$data == ''){*/
		
		$q=$data->q;
		$log->event_log($q,'d');
		//$q='2';
	if($q == 1){
	
	//$rtype='2';
	//$rptype=$_POST['rptype'];
//	$accid='2';
	$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE `account_id`='$accid'" ;
	$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  `account_id`='$accid'";
			//echo"dbhjgfekhrjgkehtjgejktgwejjrgtjwregyjhrgtrkhkeh";
		if($rptype =='Current Month'){
			$month=date('m');
				$year=date('Y');
			$month;
			$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE MONTH(tr_date)='$month' AND year(`tr_date`)='$year' AND  `account_id`='$accid'" ;
			$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  MONTH(tr_date)='$month' AND year(`tr_date`)='$year' AND  `account_id`='$accid'" ;
			}
		elseif($rptype =='Untill Today'){
			$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE  `account_id`='$accid'" ;
			$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  `account_id`='$accid'";
			}
		elseif($rptype =='Current Year'){
			$year=date('Y');
			$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE year(tr_date)='$year' AND  `account_id`='$accid'" ;
			$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  year(tr_date)='$year' AND  `account_id`='$accid'" ;
		}

	$log->event_log($sql,'d');
	$log->event_log($sql2,'d');
	
	//echo json_encode($response); 
	//echo json_encode($amountdata); 
	$stmt=$db->runQuery($sql);
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt2=$db->runQuery($sql2);
	$stmt2->execute();
	$row2=$stmt2->fetch(PDO::FETCH_ASSOC);

	
	$expenses= $row['expenses'];
	 $percentagecheck= number_format((float)$expenses, 0, '.', '');
	 $log->event_log($percentagecheck,'d');
	$income = $row2['income'];
	 $percentagecheck1= number_format((float)$income, 0, '.', '');
	 $log->event_log($percentagecheck1,'d');
	 $x=1;
	 $label1='Expenses';
	 $label2='Income';
	 while($x < 3){
	 $log->event_log($x,'d');
	 if($x==1){
	 $label=$label1;
	 $datai=$percentagecheck;
	 }
	 if($x==2){
	 $label=$label2;
	 $datai=$percentagecheck1;
	 }
	 $cars=[
	 'value'=>$datai,
	 'label'=>$label
	 ];
	 $log->event_log($cars,'d');
	 
	 $curr[]=$cars;
	 $x++;}
	 
	
//$dataPoints = array( "x"=>$percentagecheck,"y"=>$percentagecheck1);
			
			//echo $data;
		
			
			echo json_encode($curr);
			$log->event_log(json_encode($curr),'d');
	}			
	elseif($q == 2){
		
	$sql1 = "SELECT subcat_id,SUM(amount) as expenses  FROM `expenses` WHERE `account_id`='$accid'" ;

			
		//echo"dbhjgfekhrjgkehtjgejktgwejjrgtjwregyjhrgtrkhkeh";
		if($rptype =='Current Month'){
			$month=date('m');
			$year=date('Y');
			$sql1="SELECT subcat_id,SUM(amount) as expenses FROM `expenses` WHERE  MONTH(tr_date)='$month' AND year(`tr_date`)='$year' AND  `account_id` ='$accid'";
		}
		elseif($rptype =='Untill Today'){
			$sql1="SELECT subcat_id,SUM(amount) as expenses FROM `expenses` WHERE  `account_id` ='$accid'";
		}
		elseif($rptype =='Current Year'){
			$year=date('Y');
			$sql1="SELECT subcat_id,SUM(amount) as expenses FROM `expenses` WHERE   Year(tr_date)='$year' AND  `account_id` ='$accid'";
		}

	
	$sql1=$sql1."GROUP BY `subcat_id`";
	$log->event_log($sql1,'d');
	$stmt1=$db->runQuery($sql1);
	$stmt1->execute();
	//$sql1;
	while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
	$category_name=$db->get_subcategory($row1['subcat_id']);
	$category=$category_name;
	 $amount = $row1['expenses'];

	$data=[
	'label'=>$category,
	'value'=>$amount
	
	
	];
	
	
			$output[]=$data;
		}
		echo json_encode($output);	

		}
	elseif($q == 3){
		//account count
		$sql="SELECT * FROM `groups` WHERE `account_status`='active' and`added_user_id`='$id' group by `account_id` ";
		$stmt = $db->runQuery($sql);
		$stmt->execute(); 
		$count=$stmt->rowcount();
		
		$cars[]=$count;
			// Sanitize.
		echo json_encode($cars);
		}
	elseif($q == 4){
		//expense count
	
		$sql="SELECT SUM(amount) AS Total  FROM expenses WHERE `capture_id` ='$uid'";
		$stmt = $db->runQuery($sql);
		$stmt->execute(); 
		//echo $sql;
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
			
		 $count = $row['Total'];
		 $int=(int)$count;
		 $cars[]=$int;
		// Sanitize.
		echo json_encode($cars);
		}
	elseif($q == 5){
		//income count
		 $presentdate=date("Y-m-d");
		$ex_date = date('Y-m-d', strtotime("-1month", strtotime($presentdate)));
		$sql="SELECT SUM(income_amount) AS Total  FROM income WHERE `capture_id` ='$uid' AND `tr_date` BETWEEN '" . $ex_date . "' AND  '" . $presentdate . "' ";
		$stmt = $db->runQuery($sql);
		$stmt->execute(); 
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
			//   echo $sql;
		$count= $row['Total'];
		$int=(int)$count;
		$cars[]=$int;
		// Sanitize.
		echo json_encode($cars);
		}
	elseif($q == 6){
		$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE `account_id`='$accid'" ;
	$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  `account_id`='$accid'";
			//echo"dbhjgfekhrjgkehtjgejktgwejjrgtjwregyjhrgtrkhkeh";
		if($rptype =='2'){
			$month=date('m');
			$month;
			$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE MONTH(tr_date)='$month'and year(`tr_date`)='$year'  AND  `account_id`='$accid'" ;
			$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  MONTH(tr_date)='$month' and year(`tr_date`)='$year' AND  `account_id`='$accid'" ;
			}
		elseif($rptype =='1'){
			$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE  `account_id`='$accid'" ;
			$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  `account_id`='$accid'";
			}
		elseif($rptype =='3'){
			$year=date('Y');
			$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE year(tr_date)='$year' AND  `account_id`='$accid'" ;
			$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  year(tr_date)='$year' AND  `account_id`='$accid'" ;
		}

	
	//echo json_encode($response); 
	//echo json_encode($amountdata); 
	$stmt=$db->runQuery($sql);
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt2=$db->runQuery($sql2);
	$stmt2->execute();
	$row2=$stmt2->fetch(PDO::FETCH_ASSOC);

	
	$expenses= $row['expenses'];
	 $percentagecheck= number_format((float)$expenses, 0, '.', '');
	$income = $row2['income'];
	 $percentagecheck1= number_format((float)$income, 0, '.', '');
	
//$dataPoints = array( "x"=>$percentagecheck,"y"=>$percentagecheck1);
$dataPoints = ["$percentagecheck","$percentagecheck1"];
			
			//echo $data;
		
			
			echo json_encode($dataPoints);
	}
	elseif($q == 7){
		//expense count
	
	$sql1 = "SELECT subcat_id,SUM(amount) as expenses  FROM `expenses` WHERE `account_id`='$accid'" ;

			
		//echo"dbhjgfekhrjgkehtjgejktgwejjrgtjwregyjhrgtrkhkeh";
		if($rptype =='2'){
			$month=date('m');
			$sql1="SELECT subcat_id,SUM(amount) as expenses FROM `expenses` WHERE   MONTH(tr_date)='$month' and year(`tr_date`)='$year' AND  `account_id` ='$accid'";
		}
		elseif($rptype =='1'){
			$sql1="SELECT subcat_id,SUM(amount) as expenses FROM `expenses` WHERE  `account_id` ='$accid'";
		}
		elseif($rptype =='3'){
			$year=date('Y');
			$sql1="SELECT subcat_id,SUM(amount) as expenses FROM `expenses` WHERE   MONTH(tr_date)='$year' AND  `account_id` ='$accid'";
		}

	
	$sql1=$sql1."GROUP BY `subcat_id`";
	$stmt1=$db->runQuery($sql1);
	$stmt1->execute();
	//$sql1;
	while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
	$category_name=$db->get_subcategory($row1['subcat_id']);
	$category=$category_name;
	 $amount = $row1['expenses'];

	$data=[
	'labels'=>$category,
	'amount'=>$amount,
	'hello'=>$amount,
	
	];
	
	
			$output[]=$data;
		}
		echo json_encode($output);	

		}
	
		
	
/*}else{
		echo json_encode('error');
	}*/

?>
