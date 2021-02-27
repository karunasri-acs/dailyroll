<?php  
header("Access-Control-Allow-Origin: *");
	require_once '../../constants/constants.php';
	$file_path = DIR_UPLOAD; 
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
	$file= strtolower(basename($_FILES['fileToUpload']['name']));
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	 //echo $file= '5b3546677c0140.52919308-29-06-2018-03:16:45-AM.jpg';
	 $log->event_log($file,'d');
	if((strpos($file, '.png') !== false) || (strpos($file, '.jpg') !== false) || (strpos($file, '.tiff') !== false)|| (strpos($file, '.jpeg') !== false)|| (strpos($file, '.tif') !== false)|| (strpos($file, '.pdf') !== false)){

		$ret = explode('-', $file);
		$userid=$ret[0];
			 $datedir=getDatePath();
			 $file_path  = DIR_UPLOAD."".$userid."/".$datedir;
			 if(!is_dir($file_path)){
					//echo"Create our directoryeach";
					mkdir($file_path, 0777, true);
			}
			
		
		
		$file_path = $file_path .$file;
		
		$log->event_log($filepath,'d');
		if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_path)){
		   $res=$file_path;
		   $data['filename']=$res;
		   echo json_encode($data);
		   
		}
		else{
		   
			 $res="fail";
			echo json_encode($res);	
		}
	}
	else{
	 $res="fail";
	    echo json_encode($res);
	}

 ?>