<?php
/**
 * A simple example that shows how to use multiple providers, opening provider authentication in a pop-up.
 */
 session_start();
include 'src/autoload.php';
require 'config.php';
include '../class.user.php';
$user_home= new USER ();
use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;
use Hybridauth\Storage\Session;

try {

    $hybridauth = new Hybridauth($config);
    $storage = new Session();
    $error = false;

    //
    // Event 1: User clicked SIGN-IN link
    //
    if (isset($_GET['provider'])) {
		echo $_GET['provider'];
        // Validate provider exists in the $config
        if (in_array($_GET['provider'], $hybridauth->getProviders())) {
			//echo "kjhg";
            // Store the provider for the callback event
            $storage->set('provider', $_GET['provider']);
			
			
        } else {
            $error = $_GET['provider'];
        }
    }

    //
   
    //
    // Handle invalid provider errors
    //
   

    //
    // Event 3: Provider returns via CALLBACK
    //
    if ($provider = $storage->get('provider')) {

        $hybridauth->authenticate($provider);
        $storage->set('provider', null);

        // Retrieve the provider record
        $adapter = $hybridauth->getAdapter($provider);
        $userProfile = $adapter->getUserProfile();
        $accessToken = $adapter->getAccessToken();
		 $email=$userProfile->email;
		$name=$userProfile->displayName;
		$id=$userProfile->identifier;
		$laststring = substr($id, -10);
		$countrycode=$_SESSION['countrycodess'];
		if($email ==''){
			$email=$id.'@votersurvey.net';
		
		}
		///echo $email;
		
	if($email !='' && $name !='' && $id !='' && $countrycode !=''){
	//event_log($countrycode,basename(__FILE__));
	
	$laststring = substr($id, -10);
	  if (ctype_digit($laststring)) {
	  }else{
		  $laststring= rand(1111111111,9999999999);
	  }
	 // echo $email;
	  $emailcheck=$user_home->isEmailExists($email);
	 // print_r($emailcheck);
 $phonecode=$user_home->getphonecode($countrycode);
	$phonenumber=$phonecode.$laststring;
	$md5phone=md5($phonenumber);
	$generalphone=base64_encode($phonenumber);
	$statename=$_SESSION['statename'];
	$countryname=$_SESSION['countryname'];
// print_r($emailcheck);
    if($emailcheck == 'null'){
		//echo "kjhgfdssdfghjk";
		if(in_array($countrycode, $countries)){
			event_log("5 countries :".$countrycode,basename(__FILE__));
			include '../migration.user.php';
			$mig_home= new MIGRATION ();
			event_log('migration class',basename(__FILE__));
			$user=$mig_home->socialregister($email,$name,$md5phone,$generalphone,$countrycode,$statename,$countryname);
			$uuid=$user['uniqId'];
			
		}
		else{
			
			 $uuid = uniqid('', true);
				$sql="INSERT INTO `users`(`uniqId`, `phone`,`email`,`fullName`,`userdata`,`createDate`,`generalphone`,`userStatus`,`state`,`country`) VALUES ('$uuid','$md5phone','$email','$name','publisher',NOW(),'$generalphone','Y','$statename','$countryname')";
				event_log($sql,basename(__FILE__));
				$stmt = $user_home->runQuery($sql);
				$stmt->execute();
				//echo $sql;
				
		}
	}
	else{
				$sql1="select * from users WHERE  `email` ='$email'";
				$stmt1 = $user_home->runQuery($sql1);
				$stmt1->execute();
				$user=$stmt1->fetch(PDO::FETCH_ASSOC);
				$uuid=$user['uniqId'];
	
	}
$user_home->redirect('https://votersurvey.net/member/#/sociallogin?uid='.$uuid);
	
			
	}
	
       

    }







} catch (Exception $e) {
    error_log( $e->getMessage());
    echo $e->getMessage();
}
