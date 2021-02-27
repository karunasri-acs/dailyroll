<?php
header("Access-Control-Allow-Origin: *");
include 'class.user.php';
$db = new USER();
// Get the posted data.
$request=file_get_contents('php://input');
$data = json_decode($request);
//$u_id='5c2dcee2e21538.17188314';
$u_id=$data->uid;
$account_id=$data->accountid;
//$account_id='2';
$category=$data->catname;
$type=$data->type;
$uid=$db->get_email($u_id);

/*
 if(!$data == ''){*/
	$q=$data->q;
	//$q =5;
    if($q == 1){
      //get Admin Cases		
		 $sql="SELECT * FROM `category` a, accounts b WHERE a.`account_id`=b.account_id and b.user_id='$u_id'";
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//echo $sql;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		//print_r($row);
			$accname=$row['accountname']; 
			$account_id=$row['account_id']; 
			$catname=$row['cat_name'];
			$cat_type=$row['cat_type'];
			$cat_id=$row['cat_id'];
			$status=$row['status'];
			
			$data=[
			 'account_id' => $account_id,
			 'cat_id' => $cat_id,
			 'accname' => $accname,
			 'catname' => $catname,
			  'cat_type' => $cat_type,
			  'status' => $status
	  
			];
			$output[]=$data;
		}
		echo json_encode($output);

	}
	elseif($q  == 2){
		$sql="SELECT * FROM `category`";
						
		$stmt = $db->runQuery($sql);
		$stmt->execute();
			//echo $sql;
		while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$cars["catid"]=$row1['cd_id'];
			//$accountname=$row1['cat_name'];
			$cars["catname"]=$row1['cat_name'];
			$cars["status"]=$row1['status'];
			$data[]=$cars;
			// Sanitize.
		}
		echo json_encode($data);	
	}
	elseif($q  == 3){
		 $sql="SELECT a.subcat_id,a.subcat_name,a.status,a.amount,b.cat_id,b.cat_type,b.cat_name,c.accountname FROM `sub_category` a, `category` b , accounts c WHERE  b.cat_id=a.cat_id and b.account_id=c.account_id and  c.user_id='$u_id'";
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//echo $sql;
		while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		$account=$row1['accountname'];
		$category=$row1['cat_name'];
		$categorytype=$row1['cat_type'];
		
		$categoryid=$row1['cat_id'];
		$subcategory=$row1['subcat_name'];
		$sub_cat_id=$row1['subcat_id'];		 
		$amount=$row1['amount'];		 
		$status=$row1['status'];
		$data=[
			 'accountname' => $account,
			 'cat_name' => $category,
			 'cat_id' => $categoryid,
			 'cat_type' => $categorytype,
			 'subcat_name'    => $subcategory,
			'subcat_id'    => $sub_cat_id,
			'amount'    => $amount,
			'status'    => $status,
	  
			];
		$output[]=$data;
		}
		
	echo json_encode($output);
	}
	elseif($q  == 4){
$category = preg_replace('/[^A-Za-z0-9\-]/', '', $category);
if($type=='Expenses'){
$type='expenses';
}
else if($type=='income'){
$type='income';
}
$date=date('Y-m-d');
 $sql="INSERT INTO `category`(`cat_name`, `status`, `account_id`, `cat_type`) VALUES ('$category','active','$account_id','$type')";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
echo json_encode("Successfully added.");
	}
	else if($q  == 5){
	$sql1="SELECT * FROM `category` a, accounts b WHERE a.`account_id`=b.account_id and b.user_id='$u_id'";
	$stmt = $db->runQuery($sql1);
	$stmt->execute();
	while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
	
		$cat_name=$row1['cat_name'];
		$cat_id=$row1['cat_id'];
		$cat_type=$row1['cat_type'];		 
	

		$data=[
			
			 'cat_type' => $cat_type,
			 'cat_id'    => $cat_id,
			'cat_name'    => $cat_name,
			
	  
			];
		$output[]=$data;
	}
    echo json_encode($output);
	}
	else if($q  == 6){
	$catid=$data->catid;
	$subcatname=$data->subcatname;
	$subcatdefaultamount=$data->subcatdefaultamount;
	
$subcategory = preg_replace('/[^A-Za-z0-9\-]/', '', $subcatname);
	$sql="INSERT INTO `sub_category`( `cat_id`, `subcat_name`, `amount`,`status`)  VALUES ('$catid','$subcategory','$subcatdefaultamount','active')";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode('Sub-Category added successfully');
	}
	else if($q  == 7){
	$catid=$data->catid;
		 $sql="UPDATE `category` SET `status`='inactive' WHERE `cat_id`='$catid'";	
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode('Category In-Activated successfully');
	}
	else if($q  == 8){
	$catid=$data->catid;
	 $sql="UPDATE `category` SET `status`='active' WHERE `cat_id`='$catid'";	
	 $stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode('Category Activated successfully');
	}
	else if($q  == 9){
	$catid=$data->catid;
		 $sql="UPDATE `sub_category` SET `status`='inactive' WHERE `subcat_id`='$catid'";	
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode('Sub-Category In-Activated successfully');
	}
	else if($q  == 10){
	$catid=$data->catid;
	 $sql="UPDATE `sub_category` SET `status`='active' WHERE `subcat_id`='$catid'";	
	 $stmt = $db->runQuery($sql);
	$stmt->execute();
	echo json_encode('Sub-Category Activated successfully');
	}
    else if($q  == 11){
	$catid=$data->catid;
	$subcat_id=$data->subcat_id;
	$amount=$data->amount;
	$subcatname=$data->subcatname;
	$sql="UPDATE `sub_category` SET cat_id ='$catid',`subcat_name`='$subcatname',`amount`='$amount' WHERE  `subcat_id` ='$subcat_id'";
	 $stmt = $db->runQuery($sql);
	$stmt->execute();
		echo json_encode('Sub-Category Updated successfully');
	}
	else if($q  == 12){
	 
	$category=$data->categoryname;
	$account=$data->accountid;
	$type=$data->cattype;
	$catid=$data->cat_id;
	$sql="UPDATE `category` SET `cat_name`='$category',`account_id`='$account',`cat_type`='$type' WHERE `cat_id`='$catid'";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
			echo json_encode('Category Updated successfully');
	}
    
/*	

}else{
		echo json_encode('error');
	}
*/	

?>

