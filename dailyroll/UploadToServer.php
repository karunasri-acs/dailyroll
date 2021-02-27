<?php  
require_once 'constants/constants.php';
$file_path = DIR_VEDIOS; 
require_once 'class.logger.php';
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
$file= basename($_FILES['uploaded_file']['name']);
 //echo $file= '5b3546677c0140.52919308-29-06-2018-03:16:45-AM.jpg';

if((strpos($file, '.png') !== false) || (strpos($file, '.jpg') !== false)){

$ret = explode('-', $file);
$userid=$ret[0];
	 $datedir=getDatePath();
	
	  $file_path  = DIR_VEDIOS."".$userid."/".$datedir;
	
	if(!is_dir($file_path)){
		//echo"Create our directoryeach";
		mkdir($file_path, 0777, true);
    }
	
}else{
	$file_path=DIR_VEDIOS;
}	
	$file_path = $file_path .$file;
	json_encode($file_path);
	if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)){
	   $res=$file_path;
	   echo json_encode($res);
	    $log->event_log(json_encode($res),'d');
      
	}else{
	    $res="fail";
	    echo json_encode($res);
		 $log->event_log(json_encode($res),'d');
		
	}

 ?>