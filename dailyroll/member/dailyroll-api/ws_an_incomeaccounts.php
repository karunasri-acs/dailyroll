<?php
header("Access-Control-Allow-Origin: *");
include 'class.user.php';
$db = new USER();
// Get the posted data.
//$request=file_get_contents('php://input');
//$data = json_decode($request);

//echo $u_id='5c2dcee2e21538.17188314';
$u_id=$data->userid;
$accountid=$data->accountid;
//$account_id='6';
$cat_type = $data->type;
//$cat_type = 'expenses';
	

 if(!$data == ''){
	$q=$data->q;
	//$q =1;
    if($q == 1){
    
  $sql="SELECT * FROM  groups  WHERE  `account_status`='active' and `added_user_id`='$u_id' group by account_id";
	$stmt = $db->runQuery($sql);
	$stmt->execute();
	//	echo $sql;
	while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
		    $row=$db->get_accountdetails($row1['account_id']);
			$cars[]=$row;
			// Sanitize.
		}
		echo json_encode($cars);

	}
	elseif($q  == 2){
		$sql1 ="SELECT * FROM `category` WHERE account_id ='$account_id' AND `cat_type`='$cat_type'";
		$stmt1 = $db->runQuery($sql1);
		$stmt1->execute();
		echo $sql1;
		echo "<option value='all'> all </option>";
		while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
		
			$output[]=$row1;
		}
			
	echo json_encode($output);
	
		
	}
	/*elseif($q  == 3){
		$sql="SELECT * FROM `expenses` a,sub_category b WHERE a.capture_id='$uid' and a.subcat_id=b.subcat_id and a.account_id='$account_id' and permissionflag !='archive'";
		//SELECT * FROM `expenses` a,sub_category b WHERE a.capture_id='5c2dcee2e21538.17188314' and a.subcat_id=b.subcat_id and a.account_id='2' and a.permissionflag !='archive'
		$stmt = $db->runQuery($sql);
		$stmt->execute();
		//echo $sql;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 

		 $amount=$row['amount'];
		 $date=$row['tr_date'];
		 $description=$row['description'];
		 $catname=$row['subcat_name'];
		// $catname=$db->get_subcategory($sub_id);
		
		$data=[
			 'amount' => $amount,
			 'date' => $date,
			 'description' => $description,
			'catname'    => $catname
	  
			];
		
		}
		$output[]=$data;
	echo json_encode($output);
	}
/*	elseif($q  == 4){
		// Doctor reports in supervisorview
		$did=$data->did;
		
		$sql = "DELETE FROM `".DOCTOR_TABLE."` WHERE `DoctorID` = '$did'";
		$stmt = $data_home->runQuery($sql);
		$stmt->execute();
		
       echo json_encode("Successfully DELETED.");
	}
	*/
	
}else{
		echo json_encode('error');
	}

?>

