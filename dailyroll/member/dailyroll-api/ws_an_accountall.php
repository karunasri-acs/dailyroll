<?php

header("Access-Control-Allow-Origin: *");

include 'class.user.php';
$user_home = new USER();
// Get the posted data.
$request=file_get_contents('php://input');
$data = json_decode($request);

//$uid="5c33c2262050b0.40319083";



//$account_id='2';
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
  
$account_id=$data->accountid;
$log->event_log($account_id,'d');
 /*
if(!$data == ''){*/
	$q=$data->q;
//	$q =6;
	$log->event_log($q,'d');
    if($q == 1){
        //get Admin Cases		
 $sql="SELECT * FROM `expenses` WHERE `account_id`='$account_id' ORDER BY `id` DESC";
 $log->event_log($sql,'d');
										$stmt = $user_home->runQuery($sql);
										$stmt->execute();
										while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
										$catname=$user_home->get_category($row['cat_id']);
										$des= $row['description'];
										$originalDate = $row['tr_date'];
										$newDate = date("d-m-Y", strtotime($originalDate));
										$accname=$user_home->get_account($row['account_id']);
										 $subcatname=$user_home->get_subcategory($row['subcat_id']);
										 $amount= $row['amount'];
			
		$cars[]=[
		
		'date'=>$newDate,
		'accountname'=>$accname,
		'categoryname'=> $catname,
		'subcatname'=> $subcatname,
		'des'=>$des,
		'amount'=>$amount
		];
		}
		echo json_encode($cars);
	}
	elseif($q  == 2){
	 $sql="SELECT * FROM `income` WHERE `account_id`='$account_id' ORDER BY `income_id` DESC";
 $log->event_log($sql,'d');
										$stmt = $user_home->runQuery($sql);
										$stmt->execute();
										while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
										$catname=$user_home->get_category($row['cat_id']);
										$des= $row['description'];
										$originalDate = $row['tr_date'];
										$newDate = date("d-m-Y", strtotime($originalDate));
										$accname=$user_home->get_account($row['account_id']);
										 $subcatname=$user_home->get_subcategory($row['subcat_id']);
										 $amount= $row['income_amount'];
			
		$cars[]=[
		
		'date'=>$newDate,
		'accountname'=>$accname,
		'categoryname'=> $catname,
		'subcatname'=> $subcatname,
		'des'=>$des,
		'amount'=>$amount
		];
		}
		echo json_encode($cars);	
	}
	
	
/*}
else{
		echo json_encode('error');
	}*/

?>


