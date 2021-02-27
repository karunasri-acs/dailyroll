<?php
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();
if($_SERVER['REQUEST_METHOD']=='POST'){
 	$sql="select * from `config`";
	$stmt=$user_home->runQuery($sql);
	$stmt->execute();

	$row1 = $stmt->fetch(PDO::FETCH_ASSOC);
//print_r($row1);
        $response["id"] = $row1["id"];
        $response["debug"] = $row1["debug"];
	echo json_encode($response);

}

else{

echo"error";

}
?>
