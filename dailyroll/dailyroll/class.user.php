<?php

require_once '../constants/constants.php';
require_once '../dbconfig.php';
require_once '../CryptoLib.php';

class USER
{	

	
	private $conn;
	
	public function __construct(){	
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
			 $this->encryption = new CryptoLib();
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
	
	public function signin($email,$upass){

	  try
	  {
		$sql = "SELECT * FROM `advertisers` WHERE email= '$email' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		echo $sql;
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1)
		{
		//print_r($userRow);
			$salt = $userRow['salt'];
			$encrypted_password = $userRow['encrypted_password'];
			$userStatus = $userRow['userStatus'];
			$hash1=base64_encode(sha1($upass));
			$hash = $this->checkhashSSHA($salt, $upass);
			if( $userStatus == 'Y'){
				//echo "helo";
			if ($encrypted_password == $hash){
				//echo "helloooo";
				$_SESSION['userSession'] = $userRow['id'];      
				$_SESSION['userID'] = trim($userRow['id']);
				$_SESSION['unique_ID'] = $userRow['unique_id'];
				$_SESSION['userEmail'] = $userRow['email'];
				$_SESSION['name'] = $userRow['name'];
				$_SESSION['userType'] = trim($userRow['usertype']);
				return true;
				
			}
			else
			{
				//echo "5";
			}
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
	 public function getexpensecount($accountid){
		$sql1="SELECT * FROM `category` WHERE `account_id`='$accountid' and `cat_type`='expenses'";
		
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function getincomecount($accountid){
		$sql1="SELECT * FROM `category` WHERE `account_id`='$accountid' and `cat_type`='income'";
		$stmt1 = $this->conn->prepare($sql1);
		$stmt1->execute();
		$rowcount=$stmt1->rowcount();
		
		return $rowcount;
	
	}
	public function registerAdvertiser($fname,$email,$encrypted_password,$code,$salt){
		$sql = "SELECT * FROM `advertisers` WHERE `email`= '$email'";
		$stmt = $this->runQuery($sql);
		$stmt->execute();
		//echo $sql;
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 0)
		{
			try
			{
			 $sql1="INSERT INTO `advertisers`( `unique_id`,`name`, `encrypted_password`,`email`,`salt`,`created_at`)
			 VALUES ('$code','$fname','$encrypted_password','$email','$salt',NOW())";
			$stmt1= $this->runQuery($sql1);
			$stmt1->execute();
			//echo $sql1;
			 $id = $this->lasdID();
			 
			if($id){ 
					 
					 $key = base64_encode($id);
					 $subject = "Confirm Registration";
					 $message = "
								Dear $fname,
						<br /><br />
						Thank you for starting your Dailyroll Advertiser registration. To protect your identity, we need to verify your email address.<br/>
						Please click the link below and continue your Dailyroll registration.<br/>
						<br /><br />
						<a href=".VERIFY_URL."verify.php?id=$key&code=$code>Click HERE to Activate :)</a>
						<br /><br />
						Verify your email address
						<br /><br />
						You can also copy and paste the URL into your browser.
						<br /><br />
						If you have questions regarding Dailyroll registration please contact dailyroll.org
						<br /><br />
						Thanks,";  
					//echo "hello";						
					$mail=$this->send_mail($email,$subject,$message);
					//echo "hello everyone";
					echo '<script language="javascript">';
					echo 'alert("Register successfully Please check mail to activate")';
					echo '</script>';
					
					$this->redirect('advertiser_login.php');
			}
			else{
				//echo "hima";
				echo '<script language="javascript">';
				echo 'alert("user already exists with this Email")';
				echo '</script>';
				$this->redirect('subscribe.php');
				}
					
			  return "success";
			}
			catch(PDOException $ex)
			{
				return "fail";
			}
		}else{
			return "exist";
		}
	}
	public function runQuerydrop($sql) {
		$result = $this->conn->prepare($sql);
		$result->execute();
		while($row=$result->fetch(PDO::FETCH_ASSOC)) {
			$resultset[] = $row;
		}  
		if(!empty($resultset))
			return $resultset;
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
	public function runQuery($sql){
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	public function lasdID(){
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	public function storeUser($name, $email, $password,$phone,$secret) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
		$sql="INSERT INTO users(unique_id, name, email, encrypted_password, salt,  phone, google_auth_code, created_at) 
		VALUES('$uuid','$name', '$email','$encrypted_password' ,  '$salt','$phone','$secret', NOW())";
		
        $stmt = $this->conn->prepare($sql);
         $result = $stmt->execute();
		 $uid = $this->lasdID();
		 //$_SESSION['userSession'] = $uid;   
		 //echo $sql;
        //$stmt->close();
		
        // check for successful store
        if ($result) {
		//echo "fhbhj";
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
	public function event_log($text, $level='i', $file='logs') {
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
	public function login($email,$upass,$secret){
	  try
	  {
		$sql = "SELECT * FROM `users` WHERE email= '$email'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//echo $sql;
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		$dbsecret = $userRow['google_auth_code'];
		if($dbsecret == ''){
				$sql = "UPDATE `users` SET `google_auth_code`= '$secret' WHERE email= '$email'";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
		}
		if($stmt->rowCount() == 1)
		{
			$salt = $userRow['salt'];
			$encrypted_password = $userRow['encrypted_password'];
			$hash1=base64_encode(sha1($upass));
			$hash = $this->checkhashSSHA($salt, $upass);
			//echo"password";
			if ($encrypted_password == $hash )
			{ 
		//echo "hii";
		
		    //$device = $this->redirect('device_confirmations.php');
			   		
				$_SESSION['userSession'] = $userRow['user_id'];      
				$_SESSION['userID'] = trim($userRow['user_id']);
				$_SESSION['unique_ID'] = $userRow['unique_id'];
				$_SESSION['userEmail'] = $userRow['email'];
				$_SESSION['name'] = $userRow['name'];
				$_SESSION['usertype'] = $userRow['usertype'];
				$_SESSION['google_auth_code']=$google_auth_code;
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
	 public function login1($email,$upass){
	  try
	  {
		  $email=$this->encryptedstatic($email);
		$sql = "SELECT * FROM `users` WHERE email= '$email'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		//echo $sql;
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		$dbsecret = $userRow['google_auth_code'];
		
		if($stmt->rowCount() == 1)
		{
			
			//echo"password";
			if ($userRow['unique_id']== $upass )
			{ 
		//echo "hii";
		
		    //$device = $this->redirect('device_confirmations.php');
			   		
				$_SESSION['userSession'] = $userRow['user_id'];      
				$_SESSION['userID'] = trim($userRow['user_id']);
				$_SESSION['unique_ID'] = $userRow['unique_id'];
				$_SESSION['userEmail'] = $userRow['email'];
				$_SESSION['name'] = $userRow['name'];
				$_SESSION['usertype'] = $userRow['usertype'];
				$_SESSION['google_auth_code']=$google_auth_code;
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
	 public function uidlogin($uid){
	  try
	  {
		 $sql = "SELECT * FROM `users` WHERE unique_ID= '$uid'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
	
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		
			
			$_SESSION['userSession'] = $userRow['user_id'];      
				$_SESSION['userID'] = trim($userRow['user_id']);
				$_SESSION['unique_ID'] = $userRow['unique_id'];
				$_SESSION['userEmail'] = $userRow['email'];
				$_SESSION['name'] = $userRow['name'];
				$_SESSION['usertype'] = $userRow['usertype'];
				$_SESSION['google_auth_code']=$google_auth_code;
				return $userRow ;
				
			
		
	  }
	  catch(PDOException $ex)
	  {
	   //echo $ex->getMessage();
	  }
	 }
	public function change_user($userId){
	  try
	  {
	   $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id=:userid");
	   $stmt->execute(array(":userid"=>$userId));
	   $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	   
	   if($stmt->rowCount() == 1)
	   {
		if($userRow['userstatus']=="Y")
		{
		  $_SESSION['userSession'] = $userRow['user_id'];      
		  $_SESSION['userID'] = trim($userRow['user_id']);  
		  $_SESSION['unique_ID'] = $userRow['unique_id']; 
		  $_SESSION['userEmail'] = $userRow['email'];		  
		  $_SESSION['readOnly'] = 0;
		  $_SESSION['caseID'] = 0; 
		  $_SESSION['AllDOC'] = 0;
		  $_SESSION['oId'] = 0;
		  $_SESSION['caseStatus'] = OPEN;   
		  $this->redirect("mylist.php");
		  return true;
		}
		else
		{
		 header("Location: myfamily.php?inactive");
		 exit;
		} 
	   }
	   else
	   {
		header("Location: myfamily.php?error");
		exit;
	   }  
	  }
	  catch(PDOException $ex)
	  {
	   echo $ex->getMessage();
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
	public function getUseridByUniq($id){
        $sql = "SELECT * FROM `users` WHERE `unique_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$id = $row['user_id'];
		return  $id;
    }		
	public function getThisWeek($date){
		$exdate=date('Y-m-d');
		if($date=='Sunday'){
		$ex_date = date('Y-m-d', strtotime("-7day", strtotime($exdate)));
		}
		else if($date=='Monday'){
		$ex_date = date('Y-m-d', strtotime("-1day", strtotime($exdate)));
		}
		else if($date=='Tuesday'){
		$ex_date = date('Y-m-d', strtotime("-2day", strtotime($exdate)));
		}
		elseif($date=='Wednesday'){
		$ex_date = date('Y-m-d', strtotime("-3day", strtotime($exdate)));
		}
		else if($date=='Thursday'){
		$ex_date = date('Y-m-d', strtotime("-4day", strtotime($exdate)));
		}
		else if($date=='Friday'){
		$ex_date = date('Y-m-d', strtotime("-5day", strtotime($exdate)));
		}
		else if($date='Saturday'){
		$ex_date = date('Y-m-d', strtotime("-6day", strtotime($exdate)));
		}
		return  $ex_date;
	}
	public function get_subcategory($id){
        $sql = "SELECT * FROM `sub_category` WHERE `subcat_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cat_name = $row['subcat_name'];
		return  $cat_name;
    }
	public function get_category($id){
        $sql = "SELECT * FROM `category`  WHERE `cat_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);  
		
		return  $row;
    }
	public function get_categoryname($id){
        $sql = "SELECT * FROM `category`  WHERE `cat_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);  
		$cat_name = $row['cat_name'];
		return  $row;
    }
	public function get_incomecategory($id){
        $sql = "SELECT * FROM `income_category` WHERE `cd_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cat_name = $row['cat_name'];
		return  $cat_name;
    }
	public function get_account($id){
        $sql = "SELECT * FROM `accounts` WHERE `account_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$accountname = $row['accountname'];
		return  $accountname;
    }
	public function get_groupcount($id){
        $sql = "SELECT * FROM `groups` WHERE `account_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$count=$stmt->rowCount();
		return  $count;
    }
	public function get_accountdetails($id){
        $sql = "SELECT * FROM `accounts` WHERE `account_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return  $row;
    }
	public function getCurrency_symbol($countryCode){
		$currency =array(
			"BRL" => "R$" , // OR add ₢ Brazilian Real
			"BDT" => "৳", //Bangladeshi Taka
			"CAD" => "C$" , //Canadian Dollar
			"CHF" => "Fr" , //Swiss Franc
			"CRC" => "₡", //Costa Rican Colon
			"CZK" => "Kč" , //Czech Koruna
			"DKK" => "kr" , //Danish Krone
			"EUR" => "€" , //Euro
			"GBP" => "£" , //Pound Sterling
			"HKD" => "$" , //Hong Kong Dollar
			"HUF" => "Ft" , //Hungarian Forint
			"ILS" => "₪" , //Israeli New Sheqel
			"INR" => "₹", //Indian Rupee
			"ILS" => "₪",	//Israeli New Shekel
			"JPY" => "¥" , //also use ¥ JapaneseYen
			"KZT" => "₸", //Kazakhstan Tenge
			"KRW" => "₩",	//Korean Won
			"KHR" => "៛", //Cambodia Kampuchean Riel	
			"MYR" => "RM" , //Malaysian Ringgit 
			"MXN" => "$" , //Mexican Peso
			"NOK" => "kr" , //Norwegian Krone
			"NGN" => "₦",	//Nigerian Naira
			"NZD" => "$" , //New Zealand Dollar
			"PHP" => "₱" , //Philippine Peso
			"PKR" => "₨" , //Pakistani Rupees
			"PLN" => "zł" ,//Polish Zloty
			"SEK" => "kr" , //Swedish Krona 
			"TWD" => "$" , //Taiwan New Dollar 
			"TWD" => "$" , //Taiwan New Dollar 
			"THB" => "฿" , //Thai Baht
			"TRY" => "₺", //Turkish Lira
			"USD" => "$" , //U.S. Dollar
			"VND" => "₫"	//Vietnamese Dong
			 );
			   if (array_key_exists($countryCode,$currency))
			  {
			  return $currency[$countryCode];
			  }
	}

    public function getuserdata($id){
        $sql = "SELECT * FROM `users` WHERE `user_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return  $row;
    }
	public function getnamebycap($id){
      $sql = "SELECT * FROM `users` WHERE `unique_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$name=$row['name'];
		return  $name;
    }
	public function getusertype($id){
        $sql = "SELECT * FROM `users` WHERE `user_id` = '$id'";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$usertype=$row['usertype'];
		return  $usertype;
    }
	public function storeEvent($lat,$lng,$ip){
	
	    $stmt = $this->conn->prepare("INSERT INTO `event_log`(`latittude`, `logitude`,`user_ip`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sss", $lat, $lng, $ip);
        $result = $stmt->execute();
        $stmt->close();
	
	}
	public function getshareevent($event){
	
		$sql = "SELECT * FROM `share` WHERE `event_id` = '$event'and `status`='share' ";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$count =  $stmt->rowCount();
		//$id = $row['id'];
		//echo $id;
		return  $count;
	
	}
    public function getUserByEmailAndPassword($email, $password) {
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
            $userstatus = $user['userStatus'];
			//echo"-";
           $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
				//echo"hjghj";
                // user authentication details are correct
            if ($userstatus == 'Y') {
                // user authentication details are correct
                return $user;
            }
			}
        } else {
            return NULL;
        }
    }
	 public function userDetails($uid)
     {
	$sql="SELECT email,name,google_auth_code from users  WHERE user_id = '$uid'";
        $stmt = $this->conn->prepare($sql);
		$stmt->execute();
       //$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	   $data = $stmt->fetch(PDO::FETCH_ASSOC);
          return $data;
	 }
public function isUserExisted($email,$phone) {
	   $sql="SELECT * from users  WHERE email = '$email' or `phone` ='$phone'";
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
	  $file="../json/".$accid."pie.txt";
		$myfilen = fopen($file, "w") or die("Unable to open file!");
		fwrite($myfilen, json_encode($dataPoints));
		
	    $file1="../json/".$accid."bar.txt";
		$myfilen = fopen($file1, "w") or die("Unable to open file!");
		fwrite($myfilen, json_encode($responsearray));
	  
	  
	  
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
		//echo $result;
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
		require_once('phpmailer/class.phpmailer.php');
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
		$mail->SetFrom('support@jwtechinc.com','Dailyroll');  // Email
		$mail->AddReplyTo("support@jwtechinc.com","Dailyroll");  // email
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}	
	public function send_support_mail($from,$email,$subject,$message){	
        $app=APPNAME;		
		//require_once('mailer/class.phpmailer.php');
		require_once('phpmailer/class.phpmailer.php');
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
		$mail->SetFrom($from,$from);  // Email
		$mail->AddReplyTo($from,$from);  // email
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}	
	function sendactive_mail($send,$subject,$message,$uploadfile){						
		//require_once('mailer/class.phpmailer.php');
		require_once('member/phpmailer/class.phpmailer.php');
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