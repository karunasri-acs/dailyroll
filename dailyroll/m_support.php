<?php
session_start();
require_once 'class_user.php';
require_once 'constants/constants.php';
$user_home = new USER();

if(isset($_POST['button'])){
	$useremail=$_POST['email'];
	$username=$_POST['name'];
	$address = $_POST['address'];
	$date = date("Y-m-d");
	$userphone=$_POST['phone'];
	$usermessage=$_POST['message'];
	$email='nandinirouthu23@gmail.com';
	$subject="Get In Touch From $useremail";
	$message="$usermessage";
	//$file = $_POST['fileToUpload'];
	$user_home->send_mail($email,$subject,$message);
	
	$file_path = DIR_SUPPORT; 
	 $file= basename($_FILES['fileToUpload']['name']);
	
	 $file_path = $file_path .$file;
	if($file !=''){
	if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_path)){
		 $sql="INSERT INTO `feedbacks`(`email`, `address`, `date`, `description`, `status`,`document`) VALUES ('$useremail','$address','$date','$message','normal','$file')";
			$stmt = $user_home->runQuery($sql);
			$stmt->execute();
			$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
						<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Successfully your feedback is sent .
					</div>"; 
        } 
	}
	else{
		 $sql="INSERT INTO `feedbacks`(`email`, `address`, `date`, `description`, `status`) VALUES ('$useremail','$address','$date','$message','normal')";
			$stmt = $user_home->runQuery($sql);
			$stmt->execute();
			$msg = "<div class='alert alert-danger alert-dismissible' role='alert'>
						<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong> Successfully your feedback is sent .
					</div>"; 
			
	}     
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from blackrockdigital.github.io/startbootstrap-new-age/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Sep 2018 11:49:25 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DAILYROLL</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="device-mockups/device-mockups.min.css">

    <!-- Custom styles for this template -->
    <link href="css/new-age.min.css" rel="stylesheet">

  </head>
<style>
#ip2 {
    border-radius: 20px;
    border: 2px ;
    padding: 13px; 
    width: 280px;
    height: 35px;    
}

</style>
<style>
#ip3 {
    border-radius: 20px;
    border: 2px ;
    padding: 13px; 
    width: 280px;
    height: 75px;    
}

</style><style>
#ip4 {
    border-radius: 20px;
    border: 2px ;
    padding: 13px; 
    width: 280px;
    height: 95px;    
}

</style>
  <body id="page-top">
    <header class="masthead">
          <div class="col-lg-1 my-auto">
          </div>
		  <div class="col-lg-10 my-auto">
            <div class="container" >
            <h1 ></h1>
            <div class="row contact-us">
			  <div class="col-md-1">
			  </div>
              <div class="col-md-10">
                <form  action="" method="post"  enctype="multipart/form-data">
                  <?php echo $msg;?>
				  <input type="email" id="ip2" class="form-input w-100" name="email" placeholder="Email" required>
				  <br>
				  <br>
				  <input type="number" id="ip2" class="form-input w-100" name="phone" placeholder="Phone"></br></br>
				  <input type="text" id="ip2" class="form-input w-100" name="address" placeholder="Subject"></br></br>
				  <textarea class="form-input w-100" id="ip4" placeholder="Message" name="message"></textarea>
                  <br>
                  <input type="file" id="ip3" name = "fileToUpload" id="fileToUpload" ></input>
				  <br>
				  <button  class="btn btn-info" type="submit" name="button">submit</button>
                  <br>
				</form>
              </div>
			  <div class="col-md-1">
			  </div>
             
            </div>
          </div>
          </div>
    </header>

    <footer>
      <div class="container">
        <p>&copy; Your Website 2018. All Rights Reserved.</p>
        <ul class="list-inline">
          <li class="list-inline-item">
            <a href="#">Privacy</a>
          </li>
          <li class="list-inline-item">
            <a href="#">Terms</a>
          </li>
          <li class="list-inline-item">
            <a href="#">FAQ</a>
          </li>
        </ul>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>

  </body>


<!-- Mirrored from blackrockdigital.github.io/startbootstrap-new-age/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Sep 2018 11:49:29 GMT -->
</html>
