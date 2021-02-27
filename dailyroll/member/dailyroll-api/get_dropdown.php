<?php
session_start();
require_once 'class.user.php';
$q = $_GET['q'];

$data_home = new User();
 if ($q == 0){ 
if(!empty($_POST["AccountID"])) {
	$sql ="SELECT * FROM `category` WHERE account_id = '" . $_POST["AccountID"] . "' and `cat_type`='expenses'  AND `status`='active'";
	$results = $data_home->runQuerydrop($sql);
?>
	<option value="">Select Category</option>
<?php
	foreach($results as $state) {
?>
	<option value="<?php echo $state["cat_id"]; ?>"><?php echo $state["cat_name"]; ?></option>
<?php
	}
}
}

if ($q == 1){ 
if(!empty($_POST["CategoryId"])) {

	$sql ="SELECT * FROM `sub_category` WHERE  cat_id = '" . $_POST["CategoryId"] . "' AND `status`='active'";

	$results = $data_home->runQuerydrop($sql);
?>	
<option value="">Select Sub-Category</option>	
<?php
	foreach($results as $subcat) {

?>

	<option value="<?php echo $subcat["subcat_id"]; ?>"><?php echo $subcat["subcat_name"]; ?></option>
<?php
	}
}
}
if ($q == 3){ 
	$memberId = $_POST['member_id'];
	$sql ="SELECT * FROM `sub_category` WHERE  subcat_id = '$memberId'";
	$stmt3 = $data_home->runQuery($sql);
	$stmt3->execute();
	$result =$stmt3->fetch(PDO::FETCH_ASSOC);
	echo json_encode($result); 
}



?>