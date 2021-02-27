<?php

require_once 'dbconfig.php';
require_once 'CryptoLib.php';

class USER
{	

	private $conn;
	private $encryption;
	
	public function __construct(){	
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
		 $this->encryption = new CryptoLib();
    }
	public function runQuery($sql){
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	public function lasdID(){
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	public function getkeys(){
		$sql="select * from config";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$rowcount=$stmt->rowCount();
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	
		
	}
	public function encrypted($string) {
		$datas=$this->getkeys();
		$keys=$datas['sk'];
		$cipher  = $this->encryption->encryptPlainTextWithRandomIV($string, $keys);
		return $cipher;
    }
	
	public function dencrypted($string) {
		$datas=$this->getkeys();
		$keys=$datas['sk'];
		$plainText = $this->encryption->decryptCipherTextWithRandomIV($string,$keys);
		return $plainText;
    }	
	
	public function encryptedstatic($string) {
		$string = strtolower($string);
		$datas=$this->getkeys();
		$ciphering = "AES-128-CTR"; 
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
		$encryption_iv = $datas['sk']; 
		$encryption_key = $datas['sec']; 
		$encryption = openssl_encrypt($string, $ciphering, $encryption_key, $options, $encryption_iv); 
		return 	$encryption ;
    }
	
	public function dencryptedstatic($string) {
		$datas=$this->getkeys();
		$ciphering = "AES-128-CTR"; 
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
		$decryption_iv = $datas['sk'];
	    $decryption_key = $datas['sec']; 
		$decryption=openssl_decrypt ($string, $ciphering, $decryption_key, $options, $decryption_iv); 
		return $decryption;		
			
    }
	
	public function isEmailExists($email) {	
		// Email and phone# without country code
	     $sql="SELECT * from `users` WHERE email='$email'";
		
        $stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$rowcount=$stmt->rowCount();
		if($rowcount < 1){
			$row='null';
		}else{
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
	
		
		}
			return $row;
	}
	
	public function createjson($accid){
      
	  $sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE `account_id`='$accid'" ;
	$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  `account_id`='$accid'";
	$sql1="select subcat_id,SUM(amount) as number from `expenses` where account_id ='$accid'";
	$sql1=$sql1."GROUP BY `subcat_id`";
	$stmt1=$this->conn->prepare($sql1);
	$stmt1->execute();

	while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
		$category_name=$this->get_subcategory($row1['subcat_id']);
		$category=$category_name;
		$response['y'] = $row1['number'];
		$response['label'] = $category;
		$responsearray[] = $response;
	}
	$stmt2=$this->conn->prepare($sql);
	$stmt2->execute();
	$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
	$stmt1=$this->conn->prepare($sql2);
	$stmt1->execute();
	$row1=$stmt1->fetch(PDO::FETCH_ASSOC);
	$percentage = $row2['expenses'];
	$percentage1 = $row1['income'];
	$dataPoints = array( 
				  array("label"=>"Expenses", "y"=>$percentage),
				  array("label"=>"Income", "y"=>$percentage1),
					
				 );
	  $file="json/".$accid."pie.txt";
		$myfilen = fopen($file, "w") or die("Unable to open file!");
		fwrite($myfilen, json_encode($dataPoints));
		
	    $file1="json/".$accid."bar.txt";
		$myfilen = fopen($file1, "w") or die("Unable to open file!");
		fwrite($myfilen, json_encode($responsearray));
	  
	  
	  
    }
	public function get_subcategory($id){
        $sql = "SELECT * FROM `sub_category` WHERE `subcat_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cat_name = $row['subcat_name'];
		return  $cat_name;
    }
	public function get_accountdetails($id){
        $sql = "SELECT * FROM `accounts` WHERE `account_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return  $row;
    }
	public function add_activity($user_id,$activity){
	  try
	  {
	   $sql = "INSERT INTO `activities`(`user_ID`,`activity`) VALUES ('$user_id','$activity')";
	   $stmt = $this->conn->prepare($sql);
	   $stmt->execute();
	  }
	  catch(PDOException $ex)
	  {
	   echo $ex->getMessage();
	  }
	 }
	public function storeUser($name, $email, $password,$phone) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
		$sql="INSERT INTO users(unique_id, name, email, encrypted_password, salt,  phone, created_at) 
		VALUES('$uuid','$name', '$email','$encrypted_password' ,  '$salt','$phone',  NOW())";
		
        $stmt = $this->conn->prepare($sql);
         $result = $stmt->execute();
		 //echo $sql;
        //$stmt->close();
		
        // check for successful store
        if ($result) {
		
			$sql1="SELECT * FROM users WHERE email = '$email'";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute();
			
			//echo $sql1;
            $user = $stmt1->fetch(PDO::FETCH_ASSOC);
            return $user;
        } else {
            return false;
        }
    }
	# logging
	/*
	
	[2017-03-20 3:35:43] [INFO] [file.php] Here we are
	[2017-03-20 3:35:43] [ERROR] [file.php] Not good
	[2017-03-20 3:35:43] [DEBUG] [file.php] Regex empty

	mylog ('hallo') -> INFO
	mylog ('fail', 'e') -> ERROR
	mylog ('next', 'd') -> DEBUG
	mylog ('next', 'd', 'debug.log') -> DEBUG file debug.log
	*/
	public function getaccountid($name){
        $sql = "SELECT * FROM `accounts` WHERE `accountname` = '$name'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$account_id = $row['account_id'];
		return  $account_id;
    }
	public function getcategoryid($name){
        $sql = "SELECT * FROM `category` WHERE `cat_name` = '$name'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$account_id = $row['cat_id'];
		return  $account_id;
    }
	public function getincomecategoryid($name){
        $sql = "SELECT * FROM `income_category` WHERE `cat_name` = '$name'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$account_id = $row['cat_id'];
		return  $account_id;
    }
	public function getEventlog(){
		return "elite".date("[Y-m-d]")."log";
    }
	public function subscriber($text, $level='i', $file='logs') {
		switch (strtolower($level)) {
			case 'e':
			case 'error':
				$level='ERROR';
				break;
			case 'i':
			case 'info':
				$level='INFO';
				break;
			case 'd':
			case 'debug':
				$level='DEBUG';
				break;
			default:
				$level='INFO';
		}
		error_log(date("[Y-m-d H:i:s]")."\t[".$level."]\t[".basename(__FILE__)."]\t".$text."\r\n", 3, $file);
    }
	public function login($email,$upass){
	 try
	 {
		$sql = "SELECT * FROM `users` WHERE email= '$email'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//echo $sql;
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1)
		{
			$salt = $userRow['salt'];
			$encrypted_password = $userRow['encrypted_password'];
			$hash1=base64_encode(sha1($upass));
			$hash = $this->checkhashSSHA($salt, $upass);
			if ($encrypted_password == $hash)
			{ 
		//echo "hii";
				$_SESSION['userSession'] = $userRow['id'];      
				$_SESSION['userID'] = trim($userRow['id']);
				$_SESSION['unique_ID'] = $userRow['unique_id'];
				$_SESSION['userEmail'] = $userRow['email'];
				$_SESSION['name'] = $userRow['name'];
				$_SESSION['timestamp'] = time();
				return true;
			}
			else
			{
				
			}
		}
		else
		{
			
		}  
	  }
	  catch(PDOException $ex)
	  {
	   //echo $ex->getMessage();
	  }
	 }
	public function get_email($id){
        $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$email = $row['email'];
		return  $email;
    }
		public function get_account($id){
        $sql = "SELECT * FROM `accounts` WHERE `account_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$accountname = $row['accountname'];
		return  $accountname;
    }
	public function getUseridByUniq($id){
        $sql = "SELECT * FROM `users` WHERE `unique_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$id = $row['user_id'];
		return  $id;
    }
    public function get_id($email){
        $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$id = $row['id'];
		//echo $id;
		return  $id;
    }
	public function storeEvent($lat,$lng,$ip){
	
	    $stmt = $this->conn->prepare("INSERT INTO `event_log`(`latittude`, `logitude`,`user_ip`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sss", $lat, $lng, $ip);
        $result = $stmt->execute();
        $stmt->close();
	
	}
    public function getUserByEmailAndPassword($email, $password) {
		//$orginal=$this->dencrypted($email);
		//$email=$this->encryptedstatic($orginal);
        $sql="SELECT * FROM users WHERE email = '$email'";
	 
        $stmt = $this->conn->prepare($sql);
		$stmt->execute();
		
	 //echo $sql;
		 if ($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
			//print_r($user);
           // $stmt->close();

            // verifying user password
             $salt = $user['salt'];
             $encrypted_password = $user['encrypted_password'];
            $userstatus = $user['userstatus'];
			//echo"-";
           $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
				//echo"hjghj";
                // user authentication details are correct
				if ($userstatus == 'Y') {
					// user authentication details are correct
				//echo"hffhgdfgd";
					return $user;
				} else {
					return "NOTACTIVE";
				}
			}
        } else {
            return NULL;
        }
    }
    public function isUserExisted($email,$phone) {
	    $sql="SELECT * from users  WHERE email = '$email' or  `phone` ='$phone'";
        $stmt = $this->conn->prepare($sql);

       
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
		//echo"is usser";
            return true;
        } else {
            // user not existed
            //$stmt->close();
            return false;
        }
    }
    public function checkForSubscribe($userid) {
		$date = date("Y-m-d");
		$sql = "SELECT * from `subscriber` WHERE `user_id` = '$userid'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//echo $sql;
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			$exdate=$userRow['expiry_date'];
        if($exdate >= $date){
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			$result['result'] = "TRUE"; 
			$result['data'] = $userRow; 
		}
		else{
		$sql1="UPDATE `users` SET `usertype`='expireduser' WHERE user_id='$userid'";
		$stmt1= $this->conn->prepare($sql1);
		$stmt1->execute();
		$result['result'] = "FALSE";
        }
		return $result;
		
    }
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
	public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
	public function is_logged_in(){
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	public function redirect($url){
		$link = "<script>window.location.replace('$url');</script>";
		echo $link ;
	}
	public function openinwindow($url){
		$link = "<script>window.open('$url'); </script>";
		echo $link ;
	}
	public function alertmessage($msg){
		$link = "<script>alert('$msg'); </script>";
		echo $link ;
	}
	public function redirectwithjava($url){
		$link = "<script>window.location.replace('$url');</script>";
		echo $link ;
	}
	public function logout(){
		session_destroy();
		$_SESSION['userSession'] = false;
	}
	public function send_mail($email,$subject,$message){						
		//require_once('mailer/class.phpmailer.php');
		require_once('member/dailyroll-api/PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		//$mail->SMTPSecure = "ssl";                 
		//$mail->Host       = "smtp.gmail.com";      
		//$mail->Port       = 465;  
		//$mail->SetLanguage("en", 'includes/phpMailer/language/');		
		$mail->AddAddress($email);
		//$mail->Username="ManoharPV@gmail.com";  // User User Email
		//$mail->Password="xxxxxx";            // Password
		$mail->SetFrom('support@jwtechinc.com','DailyRoll');  // Email
		$mail->AddReplyTo("support@jwtechinc.com","DailyRoll");  // email
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}	
	function sendactive_mail($send,$subject,$message,$uploadfile){						
		//require_once('mailer/class.phpmailer.php');
		require_once('dailyroll-api/phpmailer/class.phpmailer.php');
		if (array_key_exists('userfile', $_FILES)) {
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		//$mail->SMTPSecure = "ssl";                 
		//$mail->Host       = "smtp.gmail.com";      
		//$mail->Port       = 465;  
		//$mail->SetLanguage("en", 'includes/phpMailer/language/');		
		$mail->AddAddress(trim($send));
		$mail->AddBCC(trim($send));
		//$mail->Username="ManoharPV@gmail.com";  // User User Email
		//$mail->Password="xxxxxx";            // Password
		$mail->SetFrom('support@jwtechinc.com','Medicall');  // Email
		$mail->AddReplyTo("support@jwtechinc.com","Information");  // email
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
			  for ($ct = 0; $ct < count($_FILES['userfile']['tmp_name']); $ct++) {
        $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['userfile']['name'][$ct]));
        $filename = $_FILES['userfile']['name'][$ct];
        if (move_uploaded_file($_FILES['userfile']['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
        } else {
            $msg .= 'Failed to move file to ' . $uploadfile;
        }
		
    }
		$mail->Send();
		$mail->ClearAddresses();
		$mail->ClearBCCs();
		}

	}
	}
	?>