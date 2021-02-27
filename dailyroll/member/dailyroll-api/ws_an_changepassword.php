<?php
session_start();
require_once 'class.user.php';
require_once '../../constants/constants.php';
$user_home = new USER();


if(isset($_GET['id'])){
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	}
	if(isset($_POST['button']))
		{
		$pass = $_POST['pass'];
		$cpass = $_POST['confirm-pass'];
		$id=$_POST['userid'];
		$sql="SELECT * FROM `users` WHERE user_id='$id'";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount() == 1)
		{
			
			
			if($cpass!==$pass)
			{
				$msg = "<div class='error'>
						
						<strong>Sorry!</strong>  Password Doesn't match. 
						</div>";
			}
			else
			{
			    $hash = $user_home->hashSSHA($pass);
		        $encrypted_password = $hash["encrypted"]; // encrypted password
		        $salt = $hash["salt"]; // salt
                $sql="UPDATE `users` SET `encrypted_password`='$encrypted_password',`salt`='$salt' WHERE user_id=$id";
				$stmt = $user_home->runQuery($sql);
				$stmt->execute();
				//echo"sad";
				$msg = "<div class='success'>
						Password Changed.
						</div>";
			
			}
			
	}
	else
	{
		$msg = "<div class='error'>
				
				No Account Found, Try again
				</div>";
				
	}
	
	
}

?>
<html lang="en" >

<head>
 <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.row{
 text-align: center;

}
#frmContact1 {

	
    background: white;
	padding: 10px;
   text-align: center;
}

#frmContact1 div {
	margin-bottom: 20px;
	text-align: center;
}

#frmContact1 div label {
	margin: 5px 0px 0px 5px;    
	color: #49615d;
	
}
.top{
margin-top:50px;
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

	width:100%;
}

.success {
	background-color:green;
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
<div class="top">
<div class="row">



  <span  class="row"><img src="dr20.png" height="auto" width="70px"  alt="" > <img src="dly21.png" height="auto" width="180px"  alt=""></span>
     


<h2 >Change Password</h2>

    <form  action="" method="post">
	
        <div id="mail-status"></div>
        
          <div class="contact-row column-right">
           
        <div>
          <?php echo $msg;?>  
        </div> 
<br>		
		<div>
            <input type="password" name="pass"  placeholder ="Enter Password" id="content" class="demoInputBox"
             required/>
        </div> 
		<br>
		<div>
            <input type="password" name="confirm-pass"  placeholder ="Enter Re-Enter Password" id="content" class="demoInputBox"
             required/> 
			 <input type="hidden" name="userid"  placeholder ="Enter Re-Enter Password" id="content" value="<?php echo $id; ?>" class="demoInputBox"
             />
        </div>
		<div>
	</div>
        <div>
		<br>
            <input type="submit" name="button" value="submit" class="btnAction" />
        </div>
    </form>
	</div>

  </div> 
  </div>  
</body>
</html>
