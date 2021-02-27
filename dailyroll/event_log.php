<?php
require_once 'constants/constants.php';
/*
function $log->event_log($text){
  
	$text=$uid."\t".$text;
	$file = DIR_LOGS."dailyroll".date("Y-m-d").".log";
	error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3, $file);	
  }	
*/		
if($_SERVER['REQUEST_METHOD']=='POST'){
$text=$_POST['eventdebug'];
 $log->event_log($text,'d');

}
else{

 $log->event_log("no data sent",'d');
}
?>