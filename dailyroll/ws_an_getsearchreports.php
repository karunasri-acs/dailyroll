<?php
 header("Access-Control-Allow-Origin: *");
    include 'class.user.php';
	$user_home = new USER();
	
	function event_log($text){
		$uid=$_SESSION['unique_ID'];
		$text=$uid."\t".$text;
		$file = "logs/dailyrollreports".date("Y-m-d").".log";
		error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3,  $file);	  
	} 
// Get the posted data.

$request=file_get_contents('php://input');
$data = json_decode($request);

	
if(!$data == ''){	
	$accid=$data->accountid;
	$mid = $data->mid;
    $rptype = $data->type;
	$uid = $data->uid;
	event_log($accid);
	event_log($mid);
	event_log($type);
	$presentdate=date("Y-m-d");
$type= $data->type;
$accid = $data->accountid;
$fromdate = $data->fromdate; 
$todate= $data->todate;
$category = $data->catid;
 $subcat = $data->subcatid;
 $mid = $data->memid; 
 if($type=='Expenses'){
	$sql = "SELECT a.tr_date,c.accountname,c.currcode,b.name,d.cat_name,e.subcat_name,a.amount,a.description  FROM `expenses` a, users b, accounts c, category d, sub_category e WHERE a.capture_id = b.unique_id  AND a.account_id =c.account_id AND a.cat_id= d.cat_id AND a.subcat_id=e.subcat_id AND a.`tr_date` BETWEEN '" . $fromdate . "' AND  '" . $todate . "' " ;
									// only account select.
									if($category =='' AND $subcat=='' AND $mid ==''  ){
									$sql=$sql." AND a.`account_id`='$accid'";
									 }
									 // select only member.
									 else if($category =='' AND $subcat=='' AND $mid !=''){
									 $added_user_id=$mid;
									 $userdata=$user_home->getuserdata($added_user_id);
									 $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'";
									 }
									 //select cat and member .
									 else if($category !='' AND $subcat=='' AND $mid !=''){
									  $added_user_id=$mid;
									   $userdata=$user_home->getuserdata($added_user_id);
									 $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND a.`cat_id`='$category' ";
									} 
									//select only cat.
									else if($category !='' AND $subcat=='' AND $mid ==''){
									  $added_user_id=$mid;
									 $sql=$sql." AND  a.`account_id`='$accid'   AND a.`cat_id`='$category' ";
									}
									// if select cat subcat member.									
									else if($category !='' AND $subcat !='' AND $mid !=''){
									  $added_user_id=$mid;
									  $userdata=$user_home->getuserdata($added_user_id);
									  $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									}
									// if select cat subcat.									
									else if($category !='' AND $subcat !='' AND $mid ==''){
									  $added_user_id=$mid;
									  $userdata=$user_home->getuserdata($added_user_id);
									  $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									}
								//	echo"hfhsgdjshgdsjfghf";
									//echo $sql;
									event_log($sql);
									$stmt = $user_home->runQuery($sql);
									$stmt->execute();
									while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
									 $des= substr($row['description'], 0, 25);
									
								 $tr_date=$row['tr_date']; 
								 $accountname=$row['accountname'];
								  $name=$row['name'];
								$cat_name=$row['cat_name'];
								  $subcat_name=$row['subcat_name'];
								 $description=$des; 
								 $currencyid=$row['currcode'];
						$symbol=$user_home->getCurrency_symbol($currencyid);
			
							$amount=$row['amount']; 
							$data=[
								 'tr_date' => $tr_date,
								 'accountname' => $accountname,
								  'name'    => $name,
								  'cat_name' => $cat_name,
								  'subcat_name' => $subcat_name,
								  'description' => $description,
								   'symbol'=>$symbol,
								  'amount' => $amount,
	  
			];
			$output[]=$data;
									 }
									
	
	}
	else{
	$sql = "SELECT * FROM `income` a, users b, accounts c, category d, sub_category e WHERE a.capture_id = b.unique_id  AND a.account_id =c.account_id AND a.cat_id= d.cat_id AND a.subcat_id=e.subcat_id  AND a.`tr_date` BETWEEN '" . $fromdate . "' AND  '" . $todate . "' " ;
									if($category =='' AND $subcat=='' AND $mid ==''  ){
									$sql=$sql." AND a.`account_id`='$accid'";
									 }
									 // select only member.
									 else if($category =='' AND $subcat=='' AND $mid !=''){
									 $added_user_id=$mid;
									 $userdata=$user_home->getuserdata($added_user_id);
									 $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'";
									 }
									 //select cat and member .
									 else if($category !='' AND $subcat=='' AND $mid !=''){
									  $added_user_id=$mid;
									   $userdata=$user_home->getuserdata($added_user_id);
									 $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND a.`cat_id`='$category' ";
									} 
									//select only cat.
									else if($category !='' AND $subcat=='' AND $mid ==''){
									  $added_user_id=$mid;
									 $sql=$sql." AND  a.`account_id`='$accid'   AND a.`cat_id`='$category' ";
									}
									// if select cat subcat member.									
									else if($category !='' AND $subcat !='' AND $mid !=''){
									  $added_user_id=$mid;
									  $userdata=$user_home->getuserdata($added_user_id);
									  $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid' AND a.`capture_id`='$capture_id'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									}
									// if select cat subcat.									
									else if($category !='' AND $subcat !='' AND $mid ==''){
									  $added_user_id=$mid;
									  $userdata=$user_home->getuserdata($added_user_id);
									  $capture_id=$userdata['unique_id'];
									 $sql=$sql." AND  a.`account_id`='$accid'  AND  a.`cat_id`='$category' and a.`subcat_id`='$subcat' ";
									}
								//	echo"hfhsgdjshgdsjfghf";
									//echo $sql;
									
									//echo $sql;
									event_log($sql);
									$stmt = $user_home->runQuery($sql);
									$stmt->execute();	
									while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
									$category_name=$user_home->get_subcategory($row['subcat_id']);
									$tr_date=$row['tr_date']; 
									$accountname=$row['accountname'];
									$name=$row['name'];
									$cat_name=$row['cat_name'];
									$subcat_name=$row['subcat_name'];
									$description=$des; 
									$amount=$row['income_amount'];
									$currencyid=$row['currcode'];
									$symbol=$user_home->getCurrency_symbol($currencyid);
									
						
								
							$data=[
								 'tr_date' => $tr_date,
								 'accountname' => $accountname,
								  'name'    => $name,
								  'cat_name' => $cat_name,
								  'subcat_name' => $subcat_name,
								  'description' => $description,
								  'symbol'=>$symbol,
								  'amount' => $amount,
	  
			];
			$output[]=$data;
									
	}
	}
	
	echo json_encode($output);

	}else{
		echo json_encode('error');
	}

?>
