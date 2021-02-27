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

	$uid=$data->userid;
	$delete=$data->id;


//echo 	$uid = '5c2dcee2e21538.17188314';
	//$u_id=$db->get_email($uid);
	//$cars = [];
		$log->event_log(json_encode($data),'d');
	$description=$data->description;
	 $amount=$data->amount;
	 $date=$data->tr_date;
	 $account=$data->account;
	 $subcategory =$data->subcategory;
	 $category=$data->category;
	 $expenseid=$data->income_id;
	 $acc_id=$data->accountid;
	 $status=$data->penstatus;
	 $selectyear=$data->selectyear;
	//echo "sfsdn";
 if(!$data == ''){
	$q=$data->q;
	//$q =1;
	$log->event_log($q,'d');
    if($q == 1){
	$penstatus=$data->penstatus;
	if($penstatus !='Both'){
 $sql="SELECT * FROM `income` WHERE  account_id='$acc_id' and  pendingflag ='$penstatus' and Year(tr_date)='$selectyear' ";
	}else{
		$sql="SELECT * FROM `income` WHERE  account_id='$acc_id'  and Year(tr_date)='$selectyear' ";

	}

		//echo "sfsdn";		
$log->event_log($sql,'d');			
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//	echo $sql;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		
			
		    $date=$row['tr_date'];
			 $accid=$row['account_id'];
			 $accname=$db->get_account($accid);
			 $penstatus=$row['pendingflag'];
			
			 $cat_id=$row['cat_id'];
			 $subcat_id=$row['subcat_id'];
			 $catname=$db->get_category($cat_id);
			 $subcatname=$db->get_subcategory($subcat_id);
			 $description=$row['description'];
			 $amount=$row['income_amount'];
			 $income_id=$row['income_id']; 
			 $currencyid=$row['currcode'];
			 $freeze=$row['freeze'];
			$row2=$db->get_accountdetails($row['account_id']);
			 $currencyid=$row2['currcode'];
			 $file_name=$row['file_name'];
			$result = substr($file_name, 0, 3);
			if($uid==$row2['user_id']){
			$adminstatus ='admin';
			}else{
			$adminstatus ='user';
			}
			$symbol=$db->getCurrency_symbol($currencyid);
			 $catdeat=$db->get_subcategoryDetails($subcat_id);
			$setamount=$catdeat['amount'];
			if($setamount == $amount){
				$pendingamount='0';
			
			}else{
				$pendingamount= $setamount-$amount;
			}
			if($result=='aaa' || $result =='' ){
			$file='nofile';
			
			
			}
			else{
			
			$file=$file_name;
			}
			
			$data=[
			 'income_id' => $income_id,
			 'accoun'=>$accid,
			 'tr_date' => $date,
			 'accountname' => $accname,
			 'cat_name' => $catname,
			 'cat_id' => $cat_id,
			 'subcat_id' => $subcat_id,
			 'subcat_name' => $subcatname,
			 'description'    => $description,
			 'income_amount' => $amount,
			 'symbol'=>$symbol,
			 'capture_id'=>$uid,
			 'adminstatus'=>$adminstatus,
			 'pendingstatus'=>$penstatus,
			 'pendingamount'=>$pendingamount,
			 'feezestatus'=>$freeze,
			 'file'=>$file
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);
		$log->event_log(json_encode($output),'d');	
	}
 else if($q == 2){
	
	$sql="DELETE FROM `income` WHERE `income_id`='$delete'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode("Data Deleted Successfully.");
	
	}
	else if($q == 3){
	
	$catdeat=$db->get_subcategoryDetails($subcategory);
	$setamount=$catdeat['amount'];
	
	$log->event_log('amount'.$amount,'d');
	$log->event_log('setamount'.$setamount,'d');
	$log->event_log('status'.$status,'d');
	if($setamount >= $amount){
		$sql="UPDATE `income` SET `account_id`='$account',`income_amount`='$amount',`subcat_id`='$subcategory',`cat_id`='$category',`description`='$description',`tr_date`='$date', pendingflag ='$status' WHERE `income_id`='$expenseid'";
		$log->event_log($sql,'d');
		$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode("Updated successfully.");
	}else{
		
		echo json_encode("Entered Amount is higher than saved Amount");
	
		
	}
	
	}
	else if($q == 4){
	
		//$sql="SELECT * FROM `income` WHERE account_id='$acc_id'";
		if($status !=''){
			$sql="SELECT * FROM `income` WHERE account_id='$acc_id' and  pendingflag ='$status' ORDER BY income_id DESC";
				
			}
			elseif($status !='undefined'){
			$sql="SELECT * FROM `income` WHERE account_id='$acc_id'  ORDER BY income_id DESC";	
			}
			else{
			$sql="SELECT * FROM `income` WHERE account_id='$acc_id' ORDER BY income_id DESC";
				
			}
			//echo "sfsdn";	
		//$log->event_log($sql);			
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//	echo $sql;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		    $date=$row['tr_date'];
			$accid=$row['account_id'];
			$penstatus=$row['pendingflag'];
			$log->event_log($account_id,'d');
			$cat_id=$row['cat_id'];
			$freeze=$row['freeze'];
			$log->event_log($cat_id,'d');
			$subcat_id=$row['subcat_id'];
			$log->event_log($subcat_id,'d');
			$accname=$db->get_account($accid);
			$log->event_log($accname,'d');
			$catname=$db->get_category($cat_id);
			$log->event_log($catname,'d');
			$subcatname=$db->get_subcategory($subcat_id);
			$log->event_log($subcatname,'d');
			$accountdetails=$db->get_accountdetails($accid);
			$currencyid=$accountdetails['currcode'];
			$name=$db->getname($capture_id);
			$symbol=$db->getCurrency_symbol($currencyid);
			$description=$row['description'];
			$amount=$row['income_amount'];
			$income_id=$row['income_id']; 
			$captureid=$row['capture_id'];
			if($uid==$accountdetails['user_id']){
				$adminstatus ='admin';
			}else{
				$adminstatus ='user';
			}
			 $catdeat=$db->get_subcategoryDetails($subcat_id);
			$setamount=$catdeat['amount'];
			if($setamount == $amount){
				$pendingamount='0';
			
			}else{
				$pendingamount= $setamount-$amount;
			}
			
			$data=[
			 'income_id' => $income_id,
			 'accoun'=>$accid,
			 'tr_date' => $date,
			 'accountname' => $accname,
			 'cat_name' => $catname,
			 'cat_id' => $cat_id,
			 'subcat_id' => $subcat_id,
			 'subcat_name' => $subcatname,
			 'description'    => $description,
			 'income_amount' => $amount,
			 'symbol'=>$symbol,
			 'capture_id'=>$captureid,
			 'adminstatus'=>$adminstatus,
			 	 'pendingstatus'=>$penstatus,
				  'pendingamount'=>$pendingamount,
			 'feezestatus'=>$freeze
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);
		$log->event_log(json_encode($output),'d');
	
	}
	else if($q == 5){
	
		//$sql="SELECT * FROM `income` WHERE account_id='$acc_id'";
		if($acc_id !=''){
			$sql="SELECT * FROM `income` WHERE account_id='$acc_id' and  pendingflag ='$status' ORDER BY income_id DESC";
				
			}
				elseif($acc_id !='undefined'){
			$sql="SELECT * FROM `income` WHERE account_id='$acc_id'  ORDER BY income_id DESC";	
			}
			else{
			$sql="SELECT * FROM `income` WHERE account_id='$acc_id' ORDER BY income_id DESC";
				
			}
			//echo "sfsdn";	
		$log->event_log($sql,'d');			
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//	echo $sql;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		    $date=$row['tr_date'];
			$accid=$row['account_id'];
			$penstatus=$row['pendingflag'];
			$log->event_log($account_id,'d');
			$cat_id=$row['cat_id'];
			$freeze=$row['freeze'];
			$log->event_log($cat_id,'d');
			$subcat_id=$row['subcat_id'];
			$log->event_log($subcat_id,'d');
			$accname=$db->get_account($accid);
			$log->event_log($accname,'d');
			$catname=$db->get_category($cat_id);
			$log->event_log($catname,'d');
			$subcatname=$db->get_subcategory($subcat_id);
			$log->event_log($subcatname,'d');
			$accountdetails=$db->get_accountdetails($accid);
			$currencyid=$accountdetails['currcode'];
			$name=$db->getname($capture_id);
			$symbol=$db->getCurrency_symbol($currencyid);
			$description=$row['description'];
			$amount=$row['income_amount'];
			$income_id=$row['income_id']; 
			$captureid=$row['capture_id'];
			if($uid==$accountdetails['user_id']){
				$adminstatus ='admin';
			}else{
				$adminstatus ='user';
			}
			$data=[
			 'income_id' => $income_id,
			 'accoun'=>$accid,
			 'tr_date' => $date,
			 'accountname' => $accname,
			 'cat_name' => $catname,
			 'cat_id' => $cat_id,
			 'subcat_id' => $subcat_id,
			 'subcat_name' => $subcatname,
			 'description'    => $description,
			 'income_amount' => $amount,
			 'symbol'=>$symbol,
			 'capture_id'=>$captureid,
			 'adminstatus'=>$adminstatus,
			 	 'pendingstatus'=>$penstatus,
			 'feezestatus'=>$freeze
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);
		$log->event_log(json_encode($output),'d');
	
	}
	else if($q == 6){
	$catdeat=$db->get_subcategoryDetails($subcategory);
	$setamount=$catdeat['amount'];
	
	$log->event_log('status'.$status,'d');
		$sql="UPDATE `income` SET `account_id`='$account',`income_amount`='$amount',`subcat_id`='$subcategory',`cat_id`='$category',`description`='$description',`tr_date`='$date', pendingflag ='$status' WHERE `income_id`='$expenseid'";
		$log->event_log($sql,'d');
		$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode("Updated  successfully.");
	
	}
	else if($q == 7){
	
	$catdeat=$db->get_subcategoryDetails($subcategory);
	$setamount=$catdeat['amount'];
	$filepath=$data->filepath;
	
	$log->event_log('amount'.$amount,'d');
	$log->event_log('setamount'.$setamount,'d');
	$log->event_log('status'.$status,'d');
	if($setamount >= $amount){
		$sql="UPDATE `income` SET `account_id`='$account',`income_amount`='$amount',`subcat_id`='$subcategory',`cat_id`='$category',`description`='$description',`file_name`='$filepath',`tr_date`='$date', pendingflag ='$status' WHERE `income_id`='$expenseid'";
		$log->event_log($sql,'d');
		$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode("Updated successfully.");
	}else{
		
		echo json_encode("Entered Amount is higher than saved Amount");
	
		
	}
	
	}
	else if($q  == 8){
			
			$expid=$data->expid;
		$sql1="SELECT `file_name`  FROM `income` WHERE `income_id`='$expid' ";
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		//echo $sql1;
		$log->event_log($sql1,'d');
		$row = $stmt1->fetch(PDO::FETCH_ASSOC); 
		$photo=$row['file_name'];
		$log->event_log($photo,'d');
		$displayfile1=str_replace('"','',$photo);
		$display=str_replace('../','',$displayfile1);
		$log->event_log($display,'d');
		$displays=str_replace('uploads/content','/content',$display);
		$log->event_log($displays,'d');
		$url=DISPLAY_DIR;
		$path=$url.$displays;
			$log->event_log($path);
		$res[]=$displayfile;
		 $data=['displayfile' =>$path];
        $cars[] =$data;
		echo json_encode($cars);
		//$log->event_log(json_encode($cars));
	
	}
	else if($q == 9){
	
	$catdeat=$db->get_subcategoryDetails($subcategory);
	$setamount=$catdeat['amount'];
	$filepath=$data->filepath;
	
	$log->event_log('amount'.$amount,'d');
	$log->event_log('setamount'.$setamount,'d');
	$log->event_log('status'.$status,'d');
	
		$sql="UPDATE `income` SET `account_id`='$account',`income_amount`='$amount',`subcat_id`='$subcategory',`cat_id`='$category',`description`='$description',`file_name`='$filepath',`tr_date`='$date', pendingflag ='$status' WHERE `income_id`='$expenseid'";
		$log->event_log($sql,'d');
		$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode("Updated successfully.");
	
	
	}
	
 }else{
		echo json_encode('error');
	}

?>
