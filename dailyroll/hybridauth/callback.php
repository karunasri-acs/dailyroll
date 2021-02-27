<?php
/**
 * A simple example that shows how to use multiple providers, opening provider authentication in a pop-up.
 */

 session_start();
include 'src/autoload.php';
require 'config.php';
include '../class_user.php';
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
        // Validate provider exists in the $config
        if (in_array($_GET['provider'], $hybridauth->getProviders())) {
            // Store the provider for the callback event
            $storage->set('provider', $_GET['provider']);
        } else {
            $error = $_GET['provider'];
        }
    }

    //
    // Event 2: User clicked LOGOUT link
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

        // add your custom AUTH functions (if any) here
        // ...
	 $email=$userProfile->email;
	   $name=$userProfile->displayName;
	 	 $id=$userProfile->identifier;
		$laststring = substr($id, -10);
		
		if($email ==''){
			$email=$id.'@dailyroll.org';
		
		}
		///echo $email;
		
	if($email !='' && $name !='' && $id !='' ){
		//echo"kjhgghj";
	//event_log($countrycode,basename(__FILE__));
	
	$laststring = substr($id, -10);
	  if (ctype_digit($laststring)) {
	  }else{
		  $laststring= rand(1111111111,9999999999);
	  }
	 // echo $email;
	 $email1=$user_home->encryptedstatic($email);
	 $name1=$user_home->encrypted($name);
	  $emailcheck=$user_home->isEmailExists($email1);
	// print_r($emailcheck);
 
	$phone1=$user_home->encrypted($laststring);
	
	
// print_r($emailcheck);
    if($emailcheck == 'null'){
		$uuid = uniqid('', true);
				$sql="INSERT INTO `users`( `unique_id`, `name`, `email`,`created_at`,`userStatus`,`socialloginid`,`phone`) VALUES ('$uuid','$name1','$email1',NOW(),'Y','$id','$phone1')";
				
				$stmt = $user_home->runQuery($sql);
				$stmt->execute();
				$sql1="select * from users WHERE  `email` ='$email1'";
				$stmt1 = $user_home->runQuery($sql1);
				$stmt1->execute();
				$user=$stmt1->fetch(PDO::FETCH_ASSOC);

				 $user_id=$user["unique_id"];
				 $uuid=$user["unique_id"];
				 $id=$user['user_id'];
				 $date=date('Y-m-d');
				$ex_date = date('Y-m-d', strtotime("+3 month", strtotime($date)));		
		$sql="INSERT INTO `accounts`(`user_id`, `accountname`, `date`, `accountstatus`) 
		VALUES ('$user_id','family','$date','active')";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		//echo $sql;
		$code = $user_home->lasdID();
		$expense= array(
				'Food'=>array(
					'Cafes, Restaurants, Bars',
					'Tobacco and alcohol',
					'Groceries',
					'Other Groceries'
					
					),
				'Transportation'=>array(
					'Parking',
					'Fuel',
					'Vehicle purchase, maintenance',
					'Transportation expenses'
					),
				'Household'=>array(
					'House insurance',
					'Health expenses',
					'House / tenant insurance',
					'Property taxes',
					'Magazines / newspapers / books'
					
					),
				'Utility services'=>array(
					'Natural gas',
					'Electricity',
					'Telephone, internet, TV, computer',
					'Water',
					'Other utility expenses'
					)
			
		
		);
		foreach( $expense as $value=>$sub_cat ) {
			$sql1="INSERT INTO `category`(`cat_name`, `status`, `account_id`, `cat_type`)
			   VALUES ('$value','active','$code','expenses')";
			$stmt1 = $user_home->runQuery($sql1);
			$stmt1->execute();
			//echo $sql1;
			 $hello = $user_home->lasdID();
			//$i=1;
			foreach( $sub_cat as $sub_cat_name ){
				
				$sql5="INSERT INTO `sub_category`(`cat_id`, `subcat_name`, `amount`, `status`)
				   VALUES ('$hello','$sub_cat_name','1000','active')";
				$stmt5 = $user_home->runQuery($sql5);
				$stmt5->execute();
				//echo $sql5;
				
				
				}
		 }
		$income= array("Salary","Other incoming payments");
		foreach( $income as $values ) {
			$sql6="INSERT INTO `category`(`cat_name`, `status`, `account_id`, `cat_type`)
			   VALUES ('$values','active','$code','income')";
			$stmt6 = $user_home->runQuery($sql6);
			$stmt6->execute();
		}
		 
		$sql2="INSERT INTO `groups`(`account_id`, `group_status`,`added_user_id`,`userstatus`)
		   VALUES ('$code','Y','$id','active')";
		$stmt2 = $user_home->runQuery($sql2);
		$stmt2->execute();	
		//echo $sql2;
		$sql3="INSERT INTO `subscriber`( `user_id`, `paiddate`, `expiry_date`)
		   VALUES ('$id','$date','$ex_date')";
		$stmt3 = $user_home->runQuery($sql3);
		$stmt3->execute();
		//echo $sql3;
		$sql4="INSERT INTO `profile`(`user_id`,`name`, `email`, `phone`)VALUES ('$id','$name1','$email1','$phone1')";
		$stmt4 = $user_home->runQuery($sql4);
		$stmt4->execute();
		
	}
	else{
				$sql1="select * from users WHERE  `email` ='$email1'";
				$stmt1 = $user_home->runQuery($sql1);
				$stmt1->execute();
				$user=$stmt1->fetch(PDO::FETCH_ASSOC);
				$uuid=$user['unique_id'];
	
	}
$user_home->redirect('https://dailyroll.org/member/#/sociallogin?uid='.$uuid);
	
			
	}
      

    }

} catch (Exception $e) {
    error_log( $e->getMessage());
   // echo $e->getMessage();
}
