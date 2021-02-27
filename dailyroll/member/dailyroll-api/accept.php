<?php
require_once 'class.user.php';
$user = new USER();

if(empty($_GET['id']))
{
	$user->redirect('index.php');
}

if(isset($_GET['id'])  && isset($_GET['code']))
{
	$id = base64_decode($_GET['id']);
	//echo $id;
	$code = $_GET['code'];	
	//echo $code;
	$statusY = "Y";
	$statusN = "N";
	
	$sql ="SELECT * FROM groups WHERE `added_user_id` ='$id' and `group_user_id` ='$code' LIMIT 1";
	//echo $sql;
	$stmt=$user->runQuery($sql);
	$stmt->execute();	
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount() > 0)
	{
		if($row['group_status']==$statusN)
		{
		
			$sql="UPDATE groups SET group_status='$statusY' WHERE  `group_user_id` ='$code' AND `added_user_id` ='$id'";
			//echo $sql;
			$stmt = $user->runQuery($sql);
			$stmt->execute();	
			
			$msg = "
		           <div class='alert alert-success'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  Congrats Your are the member of  a new group
			       </div>
			       ";	
		}
		else
		{
			$msg = "
		           <div class='alert alert-error'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>sorry !</strong>  Your Account is allready Activated : <a href='index.php'>Login here</a>
			       </div>
			       ";
		}
	}
	else
	{
		$msg = "
		       <div class='alert alert-error'>
			   <button class='close' data-dismiss='alert'>&times;</button>
			   <strong>sorry !</strong>  No Account Found : <a href='signup.php'>Please here</a>
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
	<link rel="icon" href="img/dr20.png" type="image/icon type">
    <title>DailyRoll</title>

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