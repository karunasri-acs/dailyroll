<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();

 $eventlog = EVENTLOG;
	function event_log($text){
		if(EVENTLOG == Y){
			$text=$uid."\t".$text;
			$file = "logs"."/".APP_NAME.date("Y-m-d").".log";
	//$file = "logs/dailyroll".date("Y-m-d").".log";
			error_log(date("[Y-m-d H:i:s]")."\t[INFO][".basename(__FILE__)."]\t".$text."\r\n", 3, $file);
		}		
	}

if (isset($_POST['user_id'])) {
	event_log("begining of get subcatgeory");
	$user_id = $_POST['user_id'];
	$id=$user_home->getUseridByUniq($user_id);
    $sql="SELECT d.subcat_id,d.cat_id,d.subcat_name,d.amount FROM  groups a , accounts b, category c ,sub_category d  WHERE  c.cat_id=d.cat_id and  d.status='active' and a.account_id = b.account_id  and a.account_id=c.account_id and b.account_id=c.account_id and c.status='active' and a.`account_status`='active'  and a.`added_user_id`='$id'";
    $stmt = $user_home->runQuery($sql);
    $stmt->execute();
   while($row2 = $stmt->fetch(PDO::FETCH_ASSOC)){
		
		 $response=[
		 'subcat_id' => $row2['subcat_id'],
		'cat_id' => $row2['cat_id'],
		 'subcat_name' => $row2['subcat_name'],
		'amount' => $row2['amount']
		
		 ];
		  $responsearray[] = $response;
	}
       
    
	echo json_encode($responsearray);
	event_log(json_encode($responsearray));
	event_log("End of get subcategory");
 }
else {
	$response["error"] = TRUE;
    $response["error_msg"] = "Required Parameters are missing";
	echo json_encode($response);
	event_log("Required Pa missing");      
  }


?>

