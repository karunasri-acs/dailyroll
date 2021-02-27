<?php  
header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, POST'); 

	$request=file_get_contents('php://input');
	$data = json_decode($request);
		if($data != null){
	require_once '../../constants/constants.php';
	require_once 'class.user.php';
	$user_home = new USER();
	$file_path = DIR_UPLOAD; 
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	//$uid=$_SESSION['unique_ID'];
	
		$log->event_log('multiexpenses','d');
	function getDatePath(){
	//Year in YYYY format.
	$year = date("Y");
	 
	//Month in mm format, with leading zeros.
	 $month = date("m");
	 
	//Day in dd format, with leading zeros.
	 $day = date("d");
	 
	//The folder path for our file should be YYYY/MM/DD
	$directory = "$year/$month/$day/";
	return $directory;
    }
	
	$account=$data->accountid;
	$date=$data->tdate;
	$amount=$data->amount;
	$description=$data->desc;
	$category=$data->category;
	$subcategory=$data->subcat;
	$unid=$data->uid;
	$file= basename($_FILES['fileToUpload']['filename']);
	 
	if($file==''){
	 $sql="INSERT INTO `expenses`(`capture_id`, `account_id`,`amount`,`description`, `cat_id`,`subcat_id`,`tr_date`) 
		                 VALUES ('$unid','$account','$amount','$description','$category','$subcategory','$date')";
	//$log->event_log($sql);
	$stmt=$user_home->runQuery($sql);
	$result = $stmt->execute();
	echo json_encode('successfully Inserted');
	}
	 //echo $file= '5b3546677c0140.52919308-29-06-2018-03:16:45-AM.jpg';
	if((strpos($file, '.png') !== false) || (strpos($file, '.jpg') !== false)){

	$ret = explode('-', $file);
	$userid=$ret[0];
		 $datedir=getDatePath();
		
		  $file_path  = DIR_UPLOAD."".$userid."/".$datedir;
		
		if(!is_dir($file_path)){
			//echo"Create our directoryeach";
			mkdir($file_path, 0777, true);
		}
		
	}else{
		$file_path=DIR_UPLOAD;
	}
 	
	$file_path = $file_path .$file;
	$imageFileType = strtolower(pathinfo($file_path,PATHINFO_EXTENSION));
	$filename=$unid."-".$file;
	$file_path = $file_path .$filename;
	echo $file_path;
	//json_encode($file_path);
	if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_path)){
	
		$sql="INSERT INTO `expenses`(`capture_id`, `account_id`,`amount`, `file_name`, `description`, `cat_id`,`subcat_id`,`tr_date`) 
		                 VALUES ('$unid','$account','$amount','$file_path','$description','$category','$subcategory','$date')";
	//$log->event_log($sql);
		$stmt=$user_home->runQuery($sql);
		$result = $stmt->execute();
	
	

	   echo json_encode('successfully Inserted');
	   
	}
	else{
	    $res="fail";
	    echo json_encode($res);
			
	}
	}
else{
		echo json_encode("No data.");
	}
	
 ?>