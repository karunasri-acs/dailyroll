<?php 
session_start();
require_once 'class.user.php';
require_once '../constants/constants.php';
//require_once 'data.user.php';
$user_home = new USER();
//$data_home = new DATA();
$id = $_SESSION['userSession'];

if (isset($_GET['id'])&& (isset($_GET['account']))){
	try {
		$docID = $_GET['id'];
		$account = $_GET['account'];
		//$Notifications = "applications";
		 $sql = "SELECT * FROM `expenses` WHERE `id` = '$docID'";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 $filepath=$row['file_name'];
		 $displayfile1=str_replace('"','',$filepath);
		 $display=str_replace('../uploads/content/dailyroll','',$displayfile1);
		$displayfile=DISPLAY_DIR.$display;
	}
	catch(PDOException $ex)
	{
		echo $ex->getMessage();
	}
} else if (isset($_GET['document_name'])){
	$displayfile = base64_decode($_GET['document_name']);
}
		$imageFileType = pathinfo($displayfile,PATHINFO_EXTENSION);
		$imageFileType;
?>
<!DOCTYPE html>
<html class="no-js">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript">
function goBack() {
    window.location.hash = window.location.lasthash[window.location.lasthash.length-1];
    window.location.lasthash.pop();
}
</script> 
<script src="js/lightbox.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/lightbox.min.css"> 				
</head>
<body>

   <div class="row">
   
	 <a href="m_alllist.php?id=<?php echo base64_encode($account);?>" ><i class="fa fa-window-close"  style="font-size: 30px; float: right ;" aria-hidden="true"></i></a> </br></br>
	<img width="100%" height="auto"  src="<?php echo $displayfile;?> " style="padding-left: 10px;"  alt="User Image"/>
	<!--a  href="<?php echo $displayfile;?>"  data-lightbox="example-set" data-title="Image Title" class="btttn fa fa-eye" style="font-size:px;" ></a-->
  </div>
  
</body>
</html>