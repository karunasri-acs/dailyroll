<?php
require_once 'class.user.php';
$user = new USER();
require_once '../../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
//echo "hello";

if(isset($_GET['id']) && isset($_GET['code']))
{
	$log->event_log("begining of verification",'d');
	$id = base64_decode($_GET['id']);
	//echo $id;
	$code = $_GET['code'];	
	//echo $code;
	$statusY = "Y";
	$statusN = "N";
	
	 $sql ="SELECT user_id,userStatus FROM users WHERE user_id='$id' AND unique_id='$code' LIMIT 1";
	$stmt=$user->runQuery($sql);
	$stmt->execute();
//echo $sql;	
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount()> 0)
	{
		if($row['userStatus']==$statusN)
		{
			$sql="UPDATE users SET userStatus='$statusY' WHERE user_id='$id'";
			//echo $sql;
			$stmt = $user->runQuery($sql);
			$stmt->execute();	
			$log->event_log("user status changed",'d');
			$msg = "
		           <div class='alert alert-success'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  Your Account is Now Activated : please click here to login DailyRoll application  
			       </div>
			       ";	
		}
		else
		{
			$log->event_log("user already verified",'d');
			$msg = "
		           <div class='alert alert-error'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>sorry !</strong>  Your Account is allready Activated
			       </div>
			       ";
		}
	}
	else
	{
		$log->event_log("No user found",'d');
		$msg = "
		       <div class='alert alert-error'>
			   <button class='close' data-dismiss='alert'>&times;</button>
			   <strong>sorry !</strong>  No Account Found 
			   </div>
			   ";
	}	
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Dailyroll</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
		<?php if(isset($msg)) { echo $msg; } ?>
    </div> <!-- /container -->
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>

  </body>
</html>