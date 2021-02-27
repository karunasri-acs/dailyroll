<?php
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST'); 
	//session_start();
	require_once 'class.user.php';
	$user_home = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	$request=file_get_contents('php://input');
	$data = json_decode($request);

	if($data != null){
	$account=$data->account;
	$date=$data->date1;
	$amount=$data->amount;
	$description=$data->description;
	$category=$data->category;
	$subcategory=$data->subcategory;
	$expenseid=$data->id;
	$file =$data->filename;
	$pendingstatus=$data->pendingstatus;
	
	//echo "hehd";
	$date2= date('Y-m-d', strtotime($date1));
	$sql1="select * from expenses WHERE `id`='$expenseid'";
    $log->event_log($sql1,'d');
	$stmt1=$user_home->runQuery($sql1);
	 $stmt1->execute();
	$fetcdat=$stmt1->fetch(PDO::FETCH_ASSOC);
	$log->event_log(json_encode($fetcdat),'d');
	$deletedfile=$fetcdat['file_name'];
	$log->event_log($deletedfile,'d');
	$word='aaa';
	if(strpos($mystring, $word) !== false){
    $permission='notgoahead';
	} else{
		  $permission='goahead';
	}
	$log->event_log($permission,'d');
	if($permission =='goahead'){
	$log->event_log($deletedfile,'d');
	$rdeletedfile = str_replace('../', '', $deletedfile);
	$log->event_log($rdeletedfile,'d');
	$unlinkpath='../../../../'.$rdeletedfile;
	$log->event_log($unlinkpath,'d');
	 if (file_exists($unlinkpath)) {
		unlink($unlinkpath);
		$log->event_log('image is deleted','d');

	}
	else{
		$log->event_log('No file in desired path','d');
	}
	}
	/*$unid='5ba89b3a753e89.85393788';
	$account = "7";
	$date = "2018-1-9";
	$category = "8";
	$description = "hello";
	$amount = "337";*/
	
		
    $sql="UPDATE `expenses` SET `account_id`='$account',`amount`='$amount',`file_name`='$file',`description`='$description',`subcat_id`='$subcategory',`cat_id`='$category',`tr_date`= '$date', pendingflag='$pendingstatus' WHERE `id`='$expenseid'";
	 $log->event_log($sql,'d');
	$stmt=$user_home->runQuery($sql);
	$result = $stmt->execute();
	 echo json_encode('data updated success.');
	 
	}
?>

