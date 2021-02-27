<?php
 header("Access-Control-Allow-Origin: *");
    include 'class.user.php';
	$db = new USER();
// Get the posted data.
   $request=file_get_contents('php://input');
	$data = json_decode($request);

	$uid=$data->userid;
	$delete=$data->id;

function event_log($text){
    $uid=$_SESSION['unique_ID'];
	$text=$uid."\t".$text;
	$file = "logs/dailyroll".date("Y-m-d").".log";
	error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3, $file);	  
}
//echo 	$uid = '5c2dcee2e21538.17188314';
	//$u_id=$db->get_email($uid);
	//$cars = [];
	$description=$data->description;
	 $amount=$data->amount;
	 $date=$data->tr_date;
	 $account=$data->account;
	 $subcategory =$data->subcategory;
	 $category=$data->category;
	 $expenseid=$data->income_id;
	 $acc_id=$data->accountid;
	//echo "sfsdn";
 if(!$data == ''){
	$q=$data->q;
	//$q =1;
    if($q == 1){
	
	 $sql="SELECT * FROM `income` a,accounts b,category c,sub_category d WHERE a.account_id=b.account_id and a.subcat_id=d.subcat_id and a.cat_id=c.cat_id and a.capture_id='$uid'";
			//echo "sfsdn";		
event_log($sql);			
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//	echo $sql;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		    $date=$row['tr_date'];
			 $accname=$row['accountname'];
			 $accid=$row['account_id'];
			 $cat_id=$row['cat_id'];
			 $subcat_id=$row['subcat_id'];
			 $catname=$row['cat_name'];
			 $subcatname=$row['subcat_name'];
			$description=$row['description'];
			$amount=$row['income_amount'];
			$income_id=$row['income_id']; 
			$currencyid=$row['currcode'];
			$symbol=$db->getCurrency_symbol($currencyid);
			
			
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
			   'capture_id'=>$uid
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);
		event_log(json_encode($output));	
	}
 else if($q == 2){
	
	$sql="DELETE FROM `income` WHERE `income_id`='$delete'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode("Data Deleted Successfully.");
	
	}
	else if($q == 3){
	
		$sql="UPDATE `income` SET `account_id`='$account',`income_amount`='$amount',`subcat_id`='$subcategory',`cat_id`='$category',`description`='$description',`tr_date`='$date' WHERE `income_id`='$expenseid'";
		event_log($sql);
		$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode("Updated  successfully.");
	
	}
	else if($q == 4){
	
		$sql="SELECT * FROM `income` WHERE account_id='$acc_id'";
			//echo "sfsdn";	
event_log($sql);			
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//	echo $sql;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		    $date=$row['tr_date'];
			 
			 $accid=$row['account_id'];
			  event_log($account_id);
			 $cat_id=$row['cat_id'];
			 event_log($cat_id);
			 $subcat_id=$row['subcat_id'];
			 event_log($subcat_id);
			 $accname=$db->get_account($accid);
			 event_log($accname);
			 $catname=$db->get_category($cat_id);
			 event_log($catname);
			 $subcatname=$db->get_subcategory($subcat_id);
			 event_log($subcatname);
			 	$accountdetails=$db->get_accountdetails($accid);
			$currencyid=$accountdetails['currcode'];
			
			$name=$db->getname($capture_id);
			
			$symbol=$db->getCurrency_symbol($currencyid);
			
			$description=$row['description'];
			$amount=$row['income_amount'];
			$income_id=$row['income_id']; 
			$captureid=$row['capture_id'];
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
			  'capture_id'=>$captureid
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);
		event_log(json_encode($output));
	
	}
 }else{
		echo json_encode('error');
	}

?>
