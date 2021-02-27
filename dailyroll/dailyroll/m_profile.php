<?php 
session_start();
require_once 'class.user.php';
require_once '../constants/constants.php';
$user_home = new USER();

$id= $_SESSION['userSession'];
 $unid=$_SESSION['unique_ID'];
  $file_path = DIR_PROFILE;
 require_once '../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
	$log->event_log("profilebegining",'d');
 if(isset($_GET['uid']) && isset($_GET['email']))
{
	 $email = $_GET['email'];
	$upass = $_GET['uid'];
	if($user_home->login($email,$upass)){
		//echo"hii";
		//$log->event_log("user loggined");
				$check = $user_home->checkForSubscribe($_SESSION['userSession']);
	$result = $check['result'];
	if($result == "FALSE"){
	$_SESSION['usertype']='expireduser';
	$log->event_log("expireduser",'d');
	$user_home->redirect('m_profile.php');
		
	}elseif($result == "TRUE"){
	$_SESSION['usertype']='validuser';
		$log->event_log("validuser",'e');
		$user_home->redirect('m_profile.php');
	} 
		  
	}
}
if(isset($_POST['add'])){
$name=$_POST['name'];
$lname=$_POST['lname'];
$email=$_POST['email'];
$address=$_POST['address'];
$country=$_POST['country'];
$phone=$_POST['phone'];
 $sql="UPDATE`users`SET `name`='$name',`email`='$email',`phone`='$phone' WHERE `user_id`='$id'";
$stmt = $user_home->runQuery($sql);
$stmt->execute();
	$basefile = basename($_FILES["fileToUpload"]["name"]);
	if($basefile !=''){
		if(isset($_FILES["fileToUpload"])){
			 $file_path = DIR_PROFILE;
		   // $upload_path = $dir.$unid;
			
		  $target_file = $file_path."". basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if (isset($_POST["add"])) {
		//echo"jhsjsadg";
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				 $msg =  "File is not an image.";
				$uploadOk = 0;
			}
		}
		if (file_exists($target_file)) {
		     unlink($target_file);
			$msg =  "Sorry, file already exists.";
			//echo $msg;
			$uploadOk = 0;
		}
		// Check if file already exists
		
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 4000000) {
			$msg  = "Sorry, your file is too large.";
			$uploadOk = 0;
			
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "PNG"  && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			$msg =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
			
		}
		if ($uploadOk == 0) {
			$msg = "<div class='alert alert-warning alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<strong> <span class='glyphicon glyphicon-exclamation-sign'></span> </strong>".$msg."</div>";
		}
		// if everything is ok, try to upload file
		else {
			  //$filepath = $file_path."".$basefile;
			  $url=$id.".".$imageFileType;
			   $filepath = $file_path."".$url;
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filepath)) {
				 $sql="
				INSERT INTO `profile`(`user_id`, `name`, `lastname`, `email`, `address`, `phone`, `country`, `photo`) 
				VALUES ('$id','$name','$lname','$email','$address','$phone','$country','$url')";
				$stmt = $user_home->runQuery($sql);
				$stmt->execute();
				$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong><h4>Profile updated Successfully</h4>
						</div>'";
			} else {
				$msg = "<div class='alert alert-warning alert-dismissible' role='alert'>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							<strong> <span class='glyphicon glyphicon-exclamation-sign'></span> </strong>hi, there was an error uploading your file
						</div>";
			}
		}
	   }
    }
	else{
	 $sql="INSERT INTO `profile`(`user_id`, `name`, `lastname`, `email`, `address`, `phone`, `country`) 
					VALUES ('$id','$name','$lname','$email','$address','$phone','$country')";
				
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> </h4>
                 Profile updated successfully.
              </div>';
	}

}
if(isset($_POST['update'])){
//echo"jsdhjsjhgsjehfeghfrhwe";
	$name=$_POST['name'];
 $lname=$_POST['lname'];
 $email=$_POST['email'];
 $address=$_POST['address'];
 $country=$_POST['country'];
 $phone=$_POST['phone'];

$sql="UPDATE`users` SET `name`='$name',`email`='$email',`phone`='$phone' WHERE `user_id`='$id'";
$stmt = $user_home->runQuery($sql);
$stmt->execute();
//echo $sql;
 $basefile = basename($_FILES["fileToUpload"]["name"]);
	if($basefile !=''){
		if(isset($_FILES["fileToUpload"])){
			  $file_path = DIR_PROFILE;
		   // $upload_path = $dir.$unid;
			
		 $upload_dir = $file_path;
		
	$target_file = $upload_dir."". basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if (isset($_POST["update"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$msg =  "File is not an image.";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		     unlink($target_file);
			$msg =  "Sorry, file already exists.";
			//echo $msg;
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 4000000) {
			$msg  = "Sorry, your file is too large.";
			$uploadOk = 0;
			//echo $msg;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "pdf" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			$msg =  "Sorry, only JPG, JPEG, PNG, PDF & GIF files are allowed.";
			$uploadOk = 0;
		}
		if ($uploadOk == 0) {
			$msg = "<div class='alert alert-warning alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					<strong> <span class='glyphicon glyphicon-exclamation-sign'></span> </strong>".$msg."</div>";
		}
		else {
		//echo"jhshhdgjhhj";
		     $url=$id.".".$imageFileType;
			 $filepath = $file_path."".$url;
			 if (file_exists($filepath))
			{
				unlink($filepath);
			}
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filepath)) {
			
				$sql="UPDATE `profile` SET `name`='name',`lastname`='$lname',`email`='$email',`address`='$address',`phone`='$phone',`country`='$country',`photo`='$url' WHERE `user_id`='$id'";

				$stmt = $user_home->runQuery($sql);
				$stmt->execute();
				$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
							<button type='button' class='close' data-dismiss='alert' style='height: 1px;' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							<strong>  </strong><h4>Profile Uploded Successfully</h4>
						</div>'";
			} else {
				$msg = "<div class='alert alert-warning alert-dismissible' role='alert'>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							<strong> <span class='glyphicon glyphicon-exclamation-sign'></span> </strong>hi, there was an error uploading your file
						</div>";
			}
		}
	   }
    }
	else{
	$sql="UPDATE `profile` SET `name`='name',`lastname`='$lname',`email`='$email',`address`='$address',`phone`='$phone',`country`='$country' WHERE `user_id`='$id'";

	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4> </h4>
                Updated successfully.
              </div>';
	}

}
if(isset($_POST['Subscribe'])){

	$user_home->redirect('paypal/index.php');
}
$sql="select * from `users` where `user_id`='$id'";

$stmt = $user_home->runQuery($sql);
$stmt->execute();
// echo $sql;			
$row1= $stmt->fetch(PDO::FETCH_ASSOC);

		    
?>
<?php  ?>
<html>
<head>
<meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>DailyRoll</title>
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
   <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
   <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
   <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
   <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
   <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<!-- Latest minified bootstrap js -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/core.js"></script>
	  <script type="text/javascript">
			function locattime(dt){
				var now = new Date(dt.replace(/-/g, '/'));
				//return now.toString();
				return now.toLocaleString();
			}	
		</script>
		<script type="text/javascript">
			function openImage(src){
		//	alert(src);
				//document.write("<iframe src="+src+"/>");
				//window.open("<img src="+src+"/>");
				alert(src);
				}	
		</script>
		<style>
.bttn {
    background-color: white	;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

/* Darker background on mouse-over */
.bttn:hover {
    background-color: white;
}
</style>

</head>
	<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

	  <header class="main-header">
	  </header>
  <div class="content-wrapper">
 

    <section class="content container-fluid">
				<?php  $sql1="select * from `profile` a ,subscriber  b where a.`user_id`=b.user_id and a.`user_id`='$id'";
$stmt1 = $user_home->runQuery($sql1);
$stmt1->execute();
// echo $sql;			
$row= $stmt1->fetch(PDO::FETCH_ASSOC);
$count=$stmt1->rowcount();
$log->event_log($row['photo'],'d');
?>
	<div class="col-md-3">
              <div class="widget-user-image">
                <img   class="profile-user-img img-responsive img-circle" SRC="data:image/jpeg;base64,<?php echo base64_encode(file_get_contents(DIR_PROFILE.$row['photo']));?> " alt="user avatar" width="50px" height="50px"/>
               </div>
  </div>
	<div class="col-md-8">
		<div class="active">
                <form  method="post" action = "" class="form-horizontal"  enctype="multipart/form-data">
	
				<?php  echo $msg;?>
			
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name </label>
                    <div class="col-sm-9">
                     <input class="form-control" type="text"  name="name"value="<?php echo $row1['name'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Last name </label>
                    <div class="col-sm-9">
                      <input class="form-control" type="text"  name="lname"value="<?php echo $row['lastname'];?>">
                    </div>
                  </div>
				 
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Email </label>
                    <div class="col-sm-9">
                      <input class="form-control" name="email" type="email" value="<?php echo $row1['email'];?>">
                         </div>
					</div>
				  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label"> Address </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="address" value="<?php echo $row['address'];?>" placeholder="Street">
                    </div>
                 </div>
				  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label"> Profile Pic </label>
                    <div class="col-sm-9">
                      <input class="form-control" type="file"  name = "fileToUpload" >
                     </div>
                 </div>
				 
				 <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Country </label>
                    <div class="col-sm-9">
                       <input class="form-control" type="text"  name="country" value="<?php echo $row['country'];?>">
                    </div>
                 </div>
				 
				 <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Phone</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="text"  name="phone" value="<?php echo $row['phone'];?>">
                           </div>
                 </div> 
				 <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label"> Expiry Date</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="date"  name="expirydate" disabled value="<?php echo $row['expiry_date'];?>">
                           </div>
                 </div>
				 	<?php if($count==0){ ?>
                       <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                 <input type="submit"  name="add" class="btn btn-primary" value="Save Changes">
                            </div> 
						</div>
						
						<?php }else{?>
						 <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                 <input type="submit"  name="update" class="btn btn-primary" value="Save ">
								 <?php  $date2=date('Y-m-d');	
										$paytime=7;
										$date1=$row['expiry_date'];
										$diff = abs(strtotime($date2) - strtotime($date1));
										$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
										if($days < $paytime  ) {
								 ?>
								 <input type="submit"  name="Subscribe" class="btn btn-danger" value="Subcribe ">
								   <?php }?>
                          
                            </div> 
							<?php }?>
							</br>
							
				</form>
        </div>
              
    </div>
    </section>
  
  </div>

  <!--Data Tables js-->
  	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<script src="bower_components/fastclick/lib/fastclick.js"></script>
	<script src="dist/js/adminlte.min.js"></script>
	<script src="dist/js/demo.js"></script>
</body>
</html>