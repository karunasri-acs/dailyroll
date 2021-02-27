<?php
header("Access-Control-Allow-Origin: *");
include 'class.user.php';
$db = new USER();
function event_log($text){
		$uid=$_SESSION['unique_ID'];
		$text=$uid."\t".$text;
		$file = "logs/dailyrollexpenses".date("Y-m-d").".log";
		error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3,  $file);	  
	}
// Get the posted data.
$request=file_get_contents('php://input');
$data = json_decode($request);

//echo $u_id='5c33c2262050b0.40319083';
//echo $acc_id='24';
$u_id=$data->userid;
$expid=$data->expid;
$acc_id=$data->accountid;

/*
 if(!$data == ''){*/
	$q=$data->q;
//echo	$q =4;
    if($q == 1){
	$accountid=$data->accountid;
	event_log($accountid);
      //get Admin Cases	
	  if($accountid ==''){
		$sql="SELECT a.capture_id,a.tr_date,a.account_id,a.cat_id,a.subcat_id,b.accountname,c.cat_name,d.subcat_name,a.description,a.amount,a.id,a.file_name,b.currcode FROM `expenses` a,accounts b,category c,sub_category d WHERE a.account_id=b.account_id and a.capture_id='$u_id' and a.cat_id=c.cat_id and a.subcat_id=d.subcat_id ORDER BY a.id DESC";
		}
		else if($accountid !=''){
			$sql="SELECT a.capture_id,a.tr_date,a.account_id,a.cat_id,a.subcat_id,b.accountname,c.cat_name,d.subcat_name,a.description,a.amount,a.id,a.file_name,b.currcode FROM `expenses` a,accounts b,category c,sub_category d WHERE a.account_id=b.account_id and a.cat_id=c.cat_id and a.subcat_id=d.subcat_id and a.account_id='$accountid' ORDER BY a.id DESC";
	
		
		}
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		event_log($sql);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$date=$row['tr_date'];
			 $account_id=$row['account_id'];
			 $cat_id=$row['cat_id'];
			 $subcat_id=$row['subcat_id'];
			 $accname=$row['accountname'];
			 $catname=$row['cat_name'];
			 $subcatname=$row['subcat_name'];
			$des= substr($row['description'], 0, 25);
			$capture_id=$row['capture_id'];
			$currencyid=$row['currcode'];
			
			$name=$db->getname($capture_id);
			
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
			  'name'=>$name
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);
		event_log(json_encode($output));
}
elseif($q  == 2){
		$delete=$data->id;
	event_log($delete);
	//echo $delete ='58';
	
    $sql="DELETE FROM `expenses` WHERE `id`='$delete' ";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	event_log($sql);
	 echo json_encode("Data deleted successfully.");
	
		
	}
	elseif($q  == 3){
		$sql1="SELECT `file_name`  FROM `expenses` WHERE `id`='$expid' ";
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		//echo $sql1;
		event_log($sql1);
		$row = $stmt1->fetch(PDO::FETCH_ASSOC); 
		$photo=$row['file_name'];
		$displayfile1=str_replace('"','',$photo);
		$display=str_replace('../','',$displayfile1);
		$url='http://uploads.dinkhoo.com/';
		$path=$url.$display;
		$res[]=$displayfile;
		 $data=['displayfile' =>$path];
        $cars[] =$data;
		echo json_encode($cars);
		
	
	}
	elseif($q  == 4){
		$sql="SELECT * FROM `expenses` WHERE account_id='$acc_id' and cat_id!='0' and   subcat_id!='0' ORDER BY id DESC";
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//echo $sql;
		event_log($sql);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$date=$row['tr_date'];
			$capture_id=$row['capture_id'];
			 $account_id=$row['account_id'];
			 event_log($account_id);
			 $cat_id=$row['cat_id'];
			 event_log($cat_id);
			 $subcat_id=$row['subcat_id'];
			 event_log($subcat_id);
			 $accname=$db->get_account($account_id);
			 event_log($accname);
			 $catname=$db->get_category($cat_id);
			 event_log($catname);
			 $subcatname=$db->get_subcategory($subcat_id);
			 event_log($subcatname);
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
	  'name'=>$name
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);
		event_log(json_encode($output));
	
	}
	/*elseif($q  == 5){
		$sql1="SELECT `file_name`  FROM `expenses` WHERE `id`='$expid' ";
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		//echo $sql1;
		event_log($sql1);
		$row = $stmt1->fetch(PDO::FETCH_ASSOC); 
		$photo=$row['file_name'];
		$displayfile1=str_replace('"','',$photo);
		$display=str_replace('../','',$displayfile1);
		$url='http://apps.dinkhoo.com/';
		$path=$url.$display;
		$res[]=$displayfile;
		 $data=['displayfile' =>$path];
        $cars[] =$data;
		echo json_encode($cars);
		
	
	}
	*/
/*}else{
		echo json_encode('error');
	}
*/
?>

