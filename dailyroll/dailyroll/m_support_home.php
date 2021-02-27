<?php
session_start();
require_once '../class_user.php';
require_once '../constants/constants.php';
$user_home = new USER();

 if( isset($_GET['email']))
{
	//$email2 = "karuna@gmail.com";
	$useremail = $_GET['email'];
}

//$email2 = "karuna@gmail.com";
function getDatePath(){
	//Year in YYYY format.
	$year = date("Y-m-d");
	 
	//Month in mm format, with leading zeros.
	 
	//The folder path for our file should be YYYY/MM/DD
	$directory = "$year/";
	return $directory;
}

if(isset($_POST['button'])){
$useremail=$_POST['email'];
	//$username=$_POST['name'];
	$feedback = $_POST['feedback'];
	$date = date("Y-m-d");
	$message=$_POST['message'];
	
	$subject=$_POST['subject'];
	//$message="$usermessage";
	//$file = $_POST['fileToUpload'];
	//$user_home->send_mail($email,$subject,$message);

	$file= basename($_FILES['fileToUpload']['name']);
	 $datedir=getDatePath();
	 $file_path  = DIR_SUPPORT."".$datedir;
	$target_file = $file_path."". basename($_FILES["fileToUpload"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$lastid = uniqid(rand());
	$url=$lastid.".".$imageFileType;	

	$filepath = $file_path;
		if(!is_dir($filepath)){
		//echo"Create our directoryeach";
		mkdir($filepath, 0777, true);
    }
	$filepath=$filepath = $file_path."".$url;	
	if($file !=''){
		
		
	if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $filepath)){
	 $sql="INSERT INTO `feedback`(`email`, `subject`, `date`, `description`,`requesttype`, `status`,`document`,`dbtype`) VALUES ('$useremail','$subject','$date','$message','$feedback','new','$filepath','prod')";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		
		$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Successfully your feedback is sent.
				</div>"; 
	} 
   }	
   else{
	    $sql="INSERT INTO `feedback`(`email`, `subject`,  `date`, `description`, `requesttype`,`status`,`dbtype`) VALUES ('$useremail','$subject','$date','$message','$feedback','new','prod')";
			$stmt = $user_home->runQuery($sql);
			$stmt->execute();
			
			$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Successfully  sent.
				</div>"; 
	}     
	
}


?>
<html lang="en" >

<head>
 <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
	max-width: 550px;
    font-family: Arial;
}

#frmContact1 {
	border-top: #a2d0c8 2px solid;
    background: #b1e2da;
	padding: 10px;
}

#frmContact1 div {
	margin-bottom: 20px;
}

#frmContact1 div label {
	margin: 5px 0px 0px 5px;    
	color: #49615d;
}

.demoInputBox {
	padding: 10px;
	border: #a5d2ca 1px solid;
	border-radius: 4px;
	background-color: #FFF;
	width: 100%;
    margin-top:5px;
}

.error {
	background-color: #FF6600;
    padding: 8px 10px;
    color: #FFFFFF;
    border-radius: 4px;
    font-size: 0.9em;
}

.success {
	background-color: #c3c791;
	padding: 8px 10px;
	color: #FFFFFF;
	border-radius: 4px;
    font-size: 0.9em;
}

.info {
	font-size: .8em;
	color: #FF6600;
	letter-spacing: 2px;
	padding-left: 5px;
}

.btnAction {
	background-color: #82a9a2;
    padding: 10px 40px;
    color: #FFF;
    border: #739690 1px solid;
	border-radius: 4px;
}

.btnAction:focus {
	outline:none;
}
.column-right
{
    margin-right: 6px;
}
.contact-row
{
    display: inline-block;
    width: 32%;
}
@media all and (max-width: 550px) {
    .contact-row {
        display: block;
        width: 100%;
    }
}
</style>
  
</head>
<body>
<?php echo $msg;?>
    <form id="frmContact1" action="" method="post" enctype="multipart/form-data">
        <div id="mail-status"></div>
        
          <div class="contact-row column-right">
            <label>Feedback Type</label> <span id="userEmail-info" class="info"></span><br />
           <select   id="feedback" class="demoInputBox" name="feedback"  >
					  <option value="request"> Request </option>
					  <option value="suggestions"> Suggestions</option>
					</select>
        </div>
		<div class="contact-row column-center">
                 <label>Email</label> <span id="userEmail-info" class="info"></span><br />
            <input type="text" name="email"  id="email"
                class="demoInputBox" value="<?php echo $useremail;?>" disabled>
        </div>
        <div class="contact-row">
            <label>Subject</label> <span id="subject-info" class="info"></span><br />
            <input type="text" name="subject" id="subject"
                class="demoInputBox" required>
        </div>
        <div>
            <label>Message</label> <span id="content-info" class="info" ></span><br />
            <textarea name="message" id="content" class="demoInputBox"
                rows="3" required></textarea>
        </div>
		<div>
		<input placeholder="" type="file"  name="fileToUpload" required>
		</div>
        <div>
            <input type="submit" name="button" value="Send" class="btnAction" />
        </div>
    </form>
    
</body>
</html>
