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

	
if(!$data == ''){	
	$accid=$data->accountid;
	$mid = $data->mid;
    $rptype = $data->type;
	$uid = $data->uid;
	$log->event_log($accid,'d');
	$log->event_log($mid,'d');
	$log->event_log($type,'d');
	$presentdate=date("Y-m-d");
$type= $data->type;
$accid = $data->accountid;
$fromdate = $data->fromdate; 
$todate= $data->todate;
$category = $data->catid;
 $subcat = $data->subcatid;
 $mid = $data->memid; 
 $status=$data->pensttus;
 if($type=='Expenses'){
 
	if($status =='All'){
	$sql = "SELECT a.pendingflag,a.tr_date,c.accountname,c.currcode,b.name,d.cat_name,e.subcat_name,a.amount,a.description  FROM `expenses` a, users b, accounts c, category d, sub_category e WHERE a.capture_id = b.unique_id  AND a.account_id =c.account_id AND a.cat_id= d.cat_id AND a.subcat_id=e.subcat_id AND a.`tr_date` BETWEEN '" . $fromdate . "' AND  '" . $todate . "' " ;
	
	$sql1 = "SELECT  SUM(a.amount) as total  FROM `expenses` a, users b, accounts c, category d, sub_category e WHERE a.capture_id = b.unique_id  AND a.account_id =c.account_id AND a.cat_id= d.cat_id AND a.subcat_id=e.subcat_id AND a.`tr_date` BETWEEN '" . $fromdate . "' AND  '" . $todate . "' " ;
	}else{
		$sql1 = "SELECT  SUM(a.amount) as total  FROM `expenses` a, users b, accounts c, category d, sub_category e WHERE a.capture_id = b.unique_id  AND a.account_id =c.account_id AND a.cat_id= d.cat_id AND a.subcat_id=e.subcat_id AND a.`tr_date` BETWEEN '" . $fromdate . "' AND  '" . $todate . "'  and  pendingflag ='$status'  " ;
		$sql = "SELECT a.pendingflag,a.tr_date,c.accountname,c.currcode,b.name,d.cat_name,e.subcat_name,a.amount,a.description  FROM `expenses` a, users b, accounts c, category d, sub_category e WHERE a.capture_id = b.unique_id  AND a.account_id =c.account_id AND a.cat_id= d.cat_id AND a.subcat_id=e.subcat_id AND a.`tr_date` BETWEEN '" . $fromdate . "' AND  '" . $todate . "'and  pendingflag ='$status'  " ;
	
	}
									// only account select.
									if($category =='' AND $subcat=='' AND $mid ==''  ){
									$sql=$sql." AND a.`account_id`='$accid'";
									$sql1=$sql1." AND a.`account_id`='$accid'";
									 }
									 // select only member.
									 else if($category =='' AND $subcat=='' AND $mid !=''){
									 $added_user_id=$mid;
									 $userdata=$user_home->getuserdata($added_user_id);
									 $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'";
									 $sql1=$sql1." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'";
									 }
									 //select cat and member .
									 else if($category !='' AND $subcat=='' AND $mid !=''){
									  $added_user_id=$mid;
									   $userdata=$user_home->getuserdata($added_user_id);
									 $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND a.`cat_id`='$category' ";
									 $sql1=$sql1." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND a.`cat_id`='$category' ";
									} 
									//select only cat.
									else if($category !='' AND $subcat=='' AND $mid ==''){
									  $added_user_id=$mid;
									 $sql=$sql." AND  a.`account_id`='$accid'   AND a.`cat_id`='$category' ";
									 $sql1=$sql1." AND  a.`account_id`='$accid'   AND a.`cat_id`='$category' ";
									}
									// if select cat subcat member.									
									else if($category !='' AND $subcat !='' AND $mid !=''){
									  $added_user_id=$mid;
									  $userdata=$user_home->getuserdata($added_user_id);
									  $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									 $sql1=$sql1." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									}
									// if select cat subcat.									
									else if($category !='' AND $subcat !='' AND $mid ==''){
									  $added_user_id=$mid;
									  $userdata=$user_home->getuserdata($added_user_id);
									  $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									 $sql1=$sql1." AND  a.`account_id`='$accid'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									}
								//	echo"hfhsgdjshgdsjfghf";
									//echo $sql;
									$log->event_log($sql,'d');
									
									$stmt1 = $user_home->runQuery($sql1);
									$stmt1->execute();
									$ttamount= $stmt1->fetch(PDO::FETCH_ASSOC);
									$ttamount=$ttamount['total'];
									$stmt = $user_home->runQuery($sql);
									$stmt->execute();
									while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
									 $des= substr($row['description'], 0, 25);
									
								 $tr_date=$row['tr_date']; 
								 $accountname=$row['accountname'];
								  $name=$user_home->dencrypted($row['name']);
								$cat_name=$row['cat_name'];
								  $subcat_name=$row['subcat_name'];
								 $description=$des; 
								 $currencyid=$row['currcode'];
								$symbol=$user_home->getCurrency_symbol($currencyid);
								$pendingflag=$row['pendingflag'];
									$amount=$row['amount']; 
								if($pendingflag =='non-pending'){
									$nonpendingamount=$amount;
									$pendingamount='0';
								}else{
									$pendingamount=$amount;
									$nonpendingamount='0';
								}
							
							$data=[
								 'tr_date' => $tr_date,
								 'accountname' => $accountname,
								  'name'    => $name,
								  'cat_name' => $cat_name,
								  'subcat_name' => $subcat_name,
								  'description' => $description,
								   'symbol'=>$symbol,
								  'pendingamount' => $pendingamount,
								  'nonpendingamount' => $nonpendingamount,
								  'totalamount' => $ttamount
	  
			];
			$output[]=$data;
									 }
									
	
	}
	else{
	$log->event_log('hghf','d');
	if($status == 'All'){
	$sql = "SELECT * FROM `income` a, users b, accounts c, category d, sub_category e WHERE a.capture_id = b.unique_id  AND a.account_id =c.account_id AND a.cat_id= d.cat_id AND a.subcat_id=e.subcat_id  AND a.`tr_date` BETWEEN '" . $fromdate . "' AND  '" . $todate . "'   " ;
	$sql1 = "SELECT  SUM(a.income_amount) as total   FROM `income` a, users b, accounts c, category d, sub_category e WHERE a.capture_id = b.unique_id  AND a.account_id =c.account_id AND a.cat_id= d.cat_id AND a.subcat_id=e.subcat_id  AND a.`tr_date` BETWEEN '" . $fromdate . "' AND  '" . $todate . "'" ;
		}
		else{							
	$sql = "SELECT * FROM `income` a, users b, accounts c, category d, sub_category e WHERE a.capture_id = b.unique_id  AND a.account_id =c.account_id AND a.cat_id= d.cat_id AND a.subcat_id=e.subcat_id  AND a.`tr_date` BETWEEN '" . $fromdate . "' AND  '" . $todate . "'  and  pendingflag ='$status' " ;
	$sql1 = "SELECT  SUM(a.income_amount) as total   FROM `income` a, users b, accounts c, category d, sub_category e WHERE a.capture_id = b.unique_id  AND a.account_id =c.account_id AND a.cat_id= d.cat_id AND a.subcat_id=e.subcat_id  AND a.`tr_date` BETWEEN '" . $fromdate . "' AND  '" . $todate . "'  and  pendingflag ='$status' " ;
	}
									
									if($category =='' AND $subcat=='' AND $mid ==''  ){
									$sql=$sql." AND a.`account_id`='$accid'";
									$sql1=$sql1." AND a.`account_id`='$accid'";
									 }
									 // select only member.
									 else if($category =='' AND $subcat=='' AND $mid !=''){
									 $added_user_id=$mid;
									 $userdata=$user_home->getuserdata($added_user_id);
									 $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'";
									 $sql1=$sql1." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'";
									 }
									 //select cat and member .
									 else if($category !='' AND $subcat=='' AND $mid !=''){
									  $added_user_id=$mid;
									   $userdata=$user_home->getuserdata($added_user_id);
									 $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND a.`cat_id`='$category' ";
									 $sql1=$sql1." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND a.`cat_id`='$category' ";
									} 
									//select only cat.
									else if($category !='' AND $subcat=='' AND $mid ==''){
									  $added_user_id=$mid;
									 $sql=$sql." AND  a.`account_id`='$accid'   AND a.`cat_id`='$category' ";
									 $sql1=$sql1." AND  a.`account_id`='$accid'   AND a.`cat_id`='$category' ";
									}
									// if select cat subcat member.									
									else if($category !='' AND $subcat !='' AND $mid !=''){
									  $added_user_id=$mid;
									  $userdata=$user_home->getuserdata($added_user_id);
									  $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									$sql1=$sql1." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									}
									// if select cat subcat.									
									else if($category !='' AND $subcat !='' AND $mid ==''){
									  $added_user_id=$mid;
									  $userdata=$user_home->getuserdata($added_user_id);
									  $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									 $sql1=$sql1." AND  a.`account_id`='$accid'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									}
								//	echo"hfhsgdjshgdsjfghf";
									//echo $sql;
									
									//echo $sql;
									$log->event_log($sql,'d');
									$log->event_log($sql1,'d');
									$stmt1 = $user_home->runQuery($sql1);
									$stmt1->execute();
									$ttamount= $stmt1->fetch(PDO::FETCH_ASSOC);
									$ttamount=$ttamount['total'];
									$stmt = $user_home->runQuery($sql);
									$stmt->execute();	
									while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
									//$category_name=$user_home->get_subcategory($row['subcat_id']);
									$tr_date=$row['tr_date']; 
									$accountname=$row['accountname'];
									$name=$user_home->dencrypted($row['name']);
									$cat_name=$row['cat_name'];
									$subcat_name=$row['subcat_name'];
									$description=$row['description']; 
									$amount=$row['income_amount'];
									$currencyid=$row['currcode'];
									$log->event_log($currencyid,'d');
									$symbol=$user_home->getCurrency_symbol($currencyid);
									$log->event_log($symbol,'d');
						$pendingflag=$row['pendingflag'];
							if($pendingflag =='non-pending'){
									$nonpendingamount=$amount;
									$pendingamount='0';
								}else{
									$pendingamount=$amount;
									$nonpendingamount='0';
								}
								
							$data=[
								 'tr_date' => $tr_date,
								 'accountname' => $accountname,
								  'name'    => $name,
								  'cat_name' => $cat_name,
								  'subcat_name' => $subcat_name,
								  'description' => $description,
								  'symbol'=>$symbol,
								   'pendingamount' => $pendingamount,
								  'nonpendingamount' => $nonpendingamount,
								  'totalamount' => $ttamount,
	  
			];
			$output[]=$data;
									
	}
	}
	
	echo json_encode($output);

	}else{
		echo json_encode('error');
	}

?>
