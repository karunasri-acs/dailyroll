 <?php 
	 header("Access-Control-Allow-Origin: *");
	 //$request='{"firstname":"datencrypr","email":"gayatripa@gmail.com","phone":"8899007788"}';
	 
	 $request=file_get_contents('php://input');
	$data = json_decode($request);
	//$data = 
	include '../../constants/constants.php';
	require_once 'class.user.php';
	$db = new USER();
	require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 

	$params=json_decode($request, true);

	$log->event_log(json_encode($data),'d');
	$log->event_log(json_encode($params),'d');
	
    $log->event_log("begining of encrypt",'d');
	$secretyKey=ENCRYPTKEY;
	
		foreach($params as $key => $value) {
			$log->event_log($key,'d');
			$log->event_log($value,'d');
			$encyvalue=$db->encrypted($value);
			
		$datas[]=[
				$key=>$encyvalue,
				];
		}
			
		
	echo json_encode($datas);
	$log->event_log(json_encode($datas),'d');
?>