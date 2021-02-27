<?php  
header("Access-Control-Allow-Origin: *");
	require_once '../../constants/constants.php';
	$file_path = DIR_SUPPORT; 
	$uid=$_SESSION['unique_ID'];
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
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
	$date=$data->expdate;
	$file= basename($_FILES['fileToUpload']['name']);
	$log->event_log($file,'d');
	// echo $file= '5b3546677c0140.52919308-29-06-2018-03:16:45-AM.jpg';
	if((strpos($file, '.png') !== false) || (strpos($file, '.jpg') !== false)){

	$ret = explode('-', $file);
	$userid=$ret[0];
	$log->event_log($userid,'d');
		 $datedir=getDatePath();
		
		  $file_path  = DIR_SUPPORT."".$userid."/".$datedir;
		
		if(!is_dir($file_path)){
			//echo"Create our directoryeach";
			mkdir($file_path, 0777, true);
		}
		
	}else{
		$file_path=DIR_SUPPORT;
	}
 	
	$file_path = $file_path.$file;
	$log->event_log($file_path,'d');
	//json_encode($file_path);
	if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_path)){
	  // echo"move our image directoryeach";
	   $res=$file_path;
	   $log->event_log($res,'d');
	   $data['filename']=$res;
	   $log->event_log($data,'d');
	   echo json_encode($data);
	   
	}else{
	    $res="fail";
	    echo json_encode($res);
			
	}

 ?>