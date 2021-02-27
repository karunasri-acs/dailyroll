<?php  
header("Access-Control-Allow-Origin: *");
include 'class.user.php';
	$db = new USER();
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	require_once '../../constants/constants.php';
	$file_path = DIR_PROFILE;
	
	 //echo $upload= '5c2dcee2e21538.17188314-34.jpg';
	 $upload= basename($_FILES['fileToUpload']['name']);
	$ret = explode('-', $upload);
	$userid=$ret[0];
	$image=$ret[1];
	$id=$db->get_email($userid);
	$randam= uniqid(rand());
	$conv=explode(".",$image);
	$ext=$conv['1'];
    $url=$randam.".".$ext;
	$file_path = $file_path.$url;
	$log->event_log($file_path,'d');
	if (file_exists($file_path))
			{
			$log->event_log($file_path,'d');
				unlink($file_path);
			}
		
	if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_path)){
		
		/*$displayfile1=str_replace('"','',$file_path);
		$display=str_replace('../','',$displayfile1);
		$url='http://apps.dinkhoo.com/';
		$displayfile=$url.$display;
		$res=$displayfile;
		//$log->event_log($res);
	    $data['profile']=$res;
		$photo[]=$data;
	    echo json_encode($photo);*/
	    $res=$url;
		$log->event_log($res,'d');
	    $data['filename']=$res;
	    echo json_encode($data);
	   
	}else{
	    $res="fail";
	    echo json_encode($res);
			
	}

 ?>