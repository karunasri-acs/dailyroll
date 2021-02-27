<?php
session_start();
header("Access-Control-Allow-Origin: *");
include 'class.user.php';
include '../../constants/constants.php';
$db = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
// Get the posted data.
$request=file_get_contents('php://input');
$data = json_decode($request);

//echo $u_id='5c33c2262050b0.40319083';
//echo $acc_id='24';
$u_id=$data->userid;
$expid=$data->expid;
$acc_id=$data->accountid;
$status=$data->penstatus;
$selectyear=$data->selectyear;

	$log->event_log(json_encode($data),'d');
/*
 if(!$data == ''){*/
	$q=$data->q;

    if($q == 1){
	$accountid=$data->accountid;
	$log->event_log($accountid,'d');
      //get Admin Cases	
	  if($accountid ==''){
		$sql="SELECT a.pendingflag,a.freeze,a.capture_id,a.tr_date,a.account_id,a.cat_id,a.subcat_id,b.accountname,c.cat_name,d.subcat_name,a.description,a.amount,a.id,a.file_name,b.currcode FROM `expenses` a,accounts b,category c,sub_category d WHERE a.account_id=b.account_id and a.capture_id='$u_id' and a.cat_id=c.cat_id and a.subcat_id=d.subcat_id and  pendingflag ='non-pending' ORDER BY a.id DESC";
		}
		else if($accountid !=''){
			$sql="SELECT a.pendingflag,a.freeze,a.capture_id,a.tr_date,a.account_id,a.cat_id,a.subcat_id,b.accountname,c.cat_name,d.subcat_name,a.description,a.amount,a.id,a.file_name,b.currcode FROM `expenses` a,accounts b,category c,sub_category d WHERE a.account_id=b.account_id and a.cat_id=c.cat_id and a.subcat_id=d.subcat_id and a.account_id='$accountid'  and  pendingflag ='non-pending' ORDER BY a.id DESC";
	
		
		}
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		$log->event_log($sql,'d');
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$date=$row['tr_date'];
			$penstatus=$row['pendingflag'];
			 $account_id=$row['account_id'];
			 $cat_id=$row['cat_id'];
			 $subcat_id=$row['subcat_id'];
			 $accname=$row['accountname'];
			 $catname=$row['cat_name'];
			 $subcatname=$row['subcat_name'];
			$des= substr($row['description'], 0, 25);
			$capture_id=$row['capture_id'];
			$currencyid=$row['currcode'];
			$status=$row['freeze'];
			$name=$db->getname($capture_id);
			$namedata=$db->dencrypted($name);
			$row2=$db->get_accountdetails($row['account_id']);
			$symbol=$db->getCurrency_symbol($currencyid);
			// $des= $row['description'];
		$file_name=$row['file_name'];
			$result = substr($file_name, 0, 3);
			if($result=='aaa'){
			$file='nofile';
			
			
			}
			else{
			
			$file=$file_name;
			}
			if($u_id==$row2['user_id']){
			$adminstatus ='admin';
			}else{
			$adminstatus ='user';
			}
			$amount=$row['amount'];
			$expense_id=$row['id']; 
			 $catdeat=$db->get_subcategoryDetails($subcat_id);
			$setamount=$catdeat['amount'];
			if($setamount == $amount){
				$pendingamount='0';
			
			}else{
				$pendingamount= $setamount-$amount;
			}
			$data=[
			 'accountid' => $account_id,
			 'subcatid' => $subcat_id,
			 'catid' => $cat_id,
			 'expense_id' => $expense_id,
			 'date' => $date,
			 'accname' => $accname,
			 'catname' => $catname,
			 'file' => $file,
			 'subcatname' => $subcatname,
			 'description'    => $des,
			 'amount' => $amount,
			 'capture_id'=>$capture_id,
			 'symbol'=>$symbol,
			 'name'=>$namedata,
			 'accountstatus'=>$status,
			 'adminstatus'=>$adminstatus,
			 'pendingstatus'=>$penstatus,
			 'pendingamount'=>$pendingamount,
			 'accountadmin'=>$row2['user_id']
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);
		//$log->event_log(json_encode($output));
}
elseif($q  == 2){
		$delete=$data->id;
	$log->event_log($delete,'d');
	//echo $delete ='58';
	
    $sql="DELETE FROM `expenses` WHERE `id`='$delete' ";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$log->event_log($sql,'d');
	 echo json_encode("Data deleted successfully.");
	
		
	}
	elseif($q  == 3){
		$sql1="SELECT `file_name`  FROM `expenses` WHERE `id`='$expid' ";
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
			$log->event_log($path,'d');
		$res[]=$displayfile;
		 $data=['displayfile' =>$path];
        $cars[] =$data;
		echo json_encode($cars);
		//$log->event_log(json_encode($cars));
	
	}
	elseif($q  == 4){
	/*if($status !=''){
	$sql="SELECT * FROM `expenses` WHERE account_id='$acc_id' and cat_id!='0' and   subcat_id!='0' and  pendingflag ='$status' ORDER BY id DESC";
		
	}
	elseif($status !='undefined'){
	$sql="SELECT * FROM `expenses` WHERE account_id='$acc_id' and cat_id!='0' and   subcat_id!='0'  ORDER BY id DESC";	
	}
	else{
	$sql="SELECT * FROM `expenses` WHERE account_id='$acc_id' and cat_id!='0' and   subcat_id!='0' ORDER BY id DESC";
		
	}*/
	$pendingflag=$data->penstatus;
	if($pendingflag !='Both'){
		$sql="SELECT * FROM `expenses` WHERE account_id='$acc_id' and cat_id!='0' and   subcat_id!='0' and  year(`tr_date`)='$selectyear' and pendingflag='$pendingflag'  ORDER BY id DESC";
	}else{
		$sql="SELECT * FROM `expenses` WHERE account_id='$acc_id' and cat_id!='0' and   subcat_id!='0' and  year(`tr_date`)='$selectyear'  ORDER BY id DESC";
	}
		$log->event_log($sql,'d');
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//echo $sql;
		$log->event_log($sql,'d');
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$status=$row['freeze'];
			$date=$row['tr_date'];
			$penstatus=$row['pendingflag'];
			$capture_id=$row['capture_id'];
			 $account_id=$row['account_id'];
			 //$log->event_log($account_id);
			 $cat_id=$row['cat_id'];
			 //$log->event_log($cat_id);
			 $subcat_id=$row['subcat_id'];
			 //$log->event_log($subcat_id);
			 $accname=$db->get_account($account_id);
			 //$log->event_log($accname);
			 $catname=$db->get_category($cat_id);
			 //$log->event_log($catname);
			 $subcatname=$db->get_subcategory($subcat_id);
			// $log->event_log($subcatname);
			 $des= substr($row['description'], 0, 25);
			$name=$db->getname($capture_id);
			$namedata=$db->dencrypted($name);
			$accountdetails=$db->get_accountdetails($account_id);
			$currencyid=$accountdetails['currcode'];
			$log->event_log($accountdetails['user_id'],'d');
			$name=$db->getname($capture_id);
			
			$symbol=$db->getCurrency_symbol($currencyid);
			// $des= $row['description'];
			// $des= $row['description'];
		$file_name=$row['file_name'];
			$result = substr($file_name, 0, 3);
			if($u_id==$accountdetails['user_id']){
			$adminstatus ='admin';
			}else{
			$adminstatus ='user';
			}
			if($result=='aaa'){
			$file='nofile';
			
			
			}
			else{
			
			$file=$file_name;
			}
			$amount=$row['amount'];
			$expense_id=$row['id']; 
			$catdeat=$db->get_subcategoryDetails($subcat_id);
			$setamount=$catdeat['amount'];
			if($setamount == $amount){
				$pendingamount='0';
			
			}else{
				$pendingamount= $setamount-$amount;
			}
			$data=[
			 'accountid' => $account_id,
			 'subcatid' => $subcat_id,
			 'catid' => $cat_id,
			 'expense_id' => $expense_id,
			 'date' => $date,
			 'accname' => $accname,
			 'catname' => $catname,
			 'file' => $file,
			  'subcatname' => $subcatname,
			  'description'    => $des,
			  'amount' => $amount,
				'capture_id'=>$capture_id,
				'symbol'=>$symbol,
				'name'=>$namedata,
				'accountstatus'=>$status,
			 'adminstatus'=>$adminstatus,
			 'pendingstatus'=>$penstatus,
			  'pendingamount'=>$pendingamount,
			 'accountadmin'=>$accountdetails['user_id']
	  
				
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);
		//$log->event_log(json_encode($output));
	
	}
	
	elseif($q  == 5){
		$sql1="SELECT *  FROM `accounts` WHERE `account_id`='$acc_id' ";
		$log->event_log($sql1,'d');
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		$row = $stmt1->fetch(PDO::FETCH_ASSOC); 
		$vardate=date('Y-m-d');
		$log->event_log($row['freezedate'],'d');
		$cars[]=[
		'mindate'=>$row['freezedate'],
		'maxdate'=>$vardate
		];
		echo json_encode($cars);
		$log->event_log(json_encode($cars),'d');
	
	}
	elseif($q  == 6){
	$name=$data->name;
	$email=$data->email;
	$message=$data->message;
	$idate=date('Y-m-d');
		$sql1="INSERT INTO `feedback`( `email`, `date`, `description`) VALUES ('$email','$idate','$message')";
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		
		echo json_encode('Your Question Added Your team will contact you. Thank you');
		//$log->event_log(json_encode($));
	
	}
	elseif($q  == 7){
	if($acc_id !=''){
	
	$sql="SELECT * FROM `expenses` WHERE account_id='$acc_id' and cat_id!='0' and   subcat_id!='0'  and  pendingflag ='$status' ORDER BY id DESC";
		
	}
	elseif($acc_id !='undefined'){
	$sql="SELECT * FROM `expenses` WHERE account_id='$acc_id' and cat_id!='0' and   subcat_id!='0'  and  pendingflag ='$status' ORDER BY id DESC";
		
	}
	else{
	$sql="SELECT * FROM `expenses` WHERE  capture_id='$u_id'  and  pendingflag ='$status' ORDER BY id DESC";
		
	}
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//echo $sql;
		$log->event_log($sql,'d');
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$status=$row['freeze'];
			$date=$row['tr_date'];
			$penstatus=$row['pendingflag'];
			$capture_id=$row['capture_id'];
			 $account_id=$row['account_id'];
			// $log->event_log($account_id);
			 $cat_id=$row['cat_id'];
			// $log->event_log($cat_id);
			 $subcat_id=$row['subcat_id'];
			 //$log->event_log($subcat_id);
			 $accname=$db->get_account($account_id);
			 //$log->event_log($accname);
			 $catname=$db->get_category($cat_id);
			 //$log->event_log($catname);
			 $subcatname=$db->get_subcategory($subcat_id);
			 //$log->event_log($subcatname);
			 $des= substr($row['description'], 0, 25);
			$name=$db->getname($capture_id);
			$accountdetails=$db->get_accountdetails($account_id);
			$currencyid=$accountdetails['currcode'];
			
			$name=$db->getname($capture_id);
			
			$symbol=$db->getCurrency_symbol($currencyid);
			// $des= $row['description'];
			// $des= $row['description'];
		$file_name=$row['file_name'];
			$result = substr($file_name, 0, 3);
			if($u_id==$accountdetails['user_id']){
			$adminstatus ='admin';
			}else{
			$adminstatus ='user';
			}
			if($result=='aaa'){
			$file='nofile';
			
			
			}
			else{
			
			$file=$file_name;
			}
			$amount=$row['amount'];
			$expense_id=$row['id']; 
			
			$data=[
			 'accountid' => $account_id,
			 'subcatid' => $subcat_id,
			 'catid' => $cat_id,
			 'expense_id' => $expense_id,
			 'date' => $date,
			 'accname' => $accname,
			 'catname' => $catname,
			 'file' => $file,
			  'subcatname' => $subcatname,
			  'description'    => $des,
			  'amount' => $amount,
				'capture_id'=>$capture_id,
				'symbol'=>$symbol,
				'name'=>$name,
				'accountstatus'=>$status,
			 'adminstatus'=>$adminstatus,
			 'pendingstatus'=>$penstatus,
			 'accountadmin'=>$accountdetails['user_id']
	  
				
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);
		//$log->event_log(json_encode($output));
	
	}
	
/*}else{
		echo json_encode('error');
	}
*/
?>

