<?php
//echo "fsdgfhfgjghfgkjjkghffhfsdesagdseteryrtury";
session_start();
require_once 'class.user.php';
require_once '../constants/constants.php';
//require_once (".htacess");
$user_home = new USER();
require_once 'class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
$id = $_SESSION['userSession'];
$captureid = $_SESSION['unique_ID'];
//$month=MONTH_DATE;
$usertype=$_SESSION['usertype'];

  
if(isset($_POST['uid'])){
	 $email = $_POST['uid'];
	 $log->event_log($email,'d');

	if($user_home->uidlogin($email)){
		//echo"hii";
		//$log->event_log("user loggined");
				$check = $user_home->checkForSubscribe($_SESSION['userSession']);
	$result = $check['result'];
	if($result == "FALSE"){
	$_SESSION['usertype']='expireduser';
	$log->event_log('expireduser','d');
	$user_home->redirect('ws_react_accounts.php');
		
	}elseif($result == "TRUE"){
	$_SESSION['usertype']='validuser';
		$log->event_log('validuser','d');
		$user_home->redirect('ws_react_accounts.php');
		exit;
		$log->event_log('after redirect','d');
	} 
		  
	}
}
if(isset($_POST['accountinactive'])){
	  $file=$_POST['deleteiteam'];
	  $sql1="UPDATE `accounts` SET `accountstatus`='inactive' WHERE `account_id`='$file'";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	 // echo $sql1;
	  $sql2="UPDATE `groups` SET `account_status`='inactive' WHERE `account_id`='$file'";	
	  $stmt2 = $user_home->runQuery($sql2);
	  $stmt2->execute();
	 // echo $sql2;
	  
	//$log->event_log("files are deleted");
	 
	 $msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Account In-Activated successfully.
				</div>"; 	
	 
	
	}
	if(isset($_POST['accountinactive'])){
	  $file=$_POST['deleteiteam'];
	  $currency=$_POST['currency'];
	  $account=$_POST['account'];
	  $sql1="UPDATE `accounts` SET `currcode`='$currency',`accountname`='$account' WHERE `account_id`='$file'";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	 // echo $sql1;
	
	//$log->event_log("files are deleted");
	 
	 $msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Account Updated successfully.
				</div>"; 	
	 
	
	}
if(isset($_POST['activateaccount'])){
	  $file=$_POST['accid'];
	  $sql1="UPDATE `accounts` SET `accountstatus`='active' WHERE `account_id`='$file'";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	 // echo $sql1;
	  $sql2="UPDATE `groups` SET `account_status`='active' WHERE `account_id`='$file'";	
	  $stmt2 = $user_home->runQuery($sql2);
	  $stmt2->execute();
	 // echo $sql2;
	  
	//$log->event_log("files are deleted");
	 
	 $msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Account Activated successfully.
				</div>"; 	
	 
	
	}
if(isset($_POST['catadd'])){
$account=$_POST['account'];
$category=$_POST['category'];

$category = preg_replace('/[^A-Za-z0-9\- ]/', '', $category);
$type=$_POST['type'];
$date=date('Y-m-d');
 $sql="INSERT INTO `category`(`cat_name`, `status`, `account_id`, `cat_type`) VALUES ('$category','active','$account','$type')";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();


	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> </h4>
         Category Added successfully.
              </div>';
	

}
if(isset($_POST['accountadd'])){
$currency=$_POST['currency'];
$account=$_POST['account'];
$date=date('Y-m-d');
 $sql="INSERT INTO `accounts`(`user_id`, `currcode`,`accountname`, `date`, `accountstatus`) VALUES ('$captureid','$currency','$account','$date','active')";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$code = $user_home->lasdID();
	$sql1="INSERT INTO `groups`(`account_id`, `group_status`, `added_user_id`,`userstatus`)
		   VALUES ('$code','Y','$id','active')";
	$stmt1 = $user_home->runQuery($sql1);
	$stmt1->execute();
	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> </h4>
          Account Added successfully.
              </div>';
	

}
if(isset($_POST['inactivecat'])){
	 $file=$_POST['deleteiteam'];
	 $sql1="UPDATE `category` SET `status`='inactive' WHERE `cat_id`='$file'";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Category  In-Activated Successfully.
				</div>"; 	
	 
	
	}
if(isset($_POST['activecat'])){
	 $file=$_POST['deleteiteam'];
	 $sql1="UPDATE `category` SET `status`='active' WHERE `cat_id`='$file'";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Category Activated Succesfully.
				</div>"; 	
	 
	
	}	

if(isset($_POST['activate'])){
	  $file=$_POST['deleteiteam'];
	  $sql1="UPDATE `sub_category` SET `status`='active' WHERE `subcat_id`='$file'";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Sub-Category is Activated Successfully.
				</div>"; 	
	 
	
	}
if(isset($_POST['inactive'])){
	  $file=$_POST['deleteiteam'];
	  $sql1="UPDATE `sub_category` SET `status`='inactive' WHERE `subcat_id`='$file'";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Sub-Category is In-Activated Successfully.
				</div>"; 	
	 
	
	}
if(isset($_POST['updatecat'])){
$account=$_POST['account'];
$category=$_POST['category'];
$type=$_POST['type'];
$catid=$_POST['catid'];
 $sql="UPDATE `category` SET `cat_name`='$category',`account_id`='$account',`cat_type`='$type' WHERE `cat_id`='$catid'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();


	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> </h4>
         Category Update successfully.
              </div>';
	

}
if(isset($_POST['addsubcategory'])){
$cat=$_POST['cat'];
$subcategory=$_POST['subcatname'];
$amount=$_POST['amount'];
$subcategory = preg_replace('/[^A-Za-z0-9\-]/', '', $subcategory);
	$sql="INSERT INTO `sub_category`( `cat_id`, `subcat_name`, `amount`,`status`)  VALUES ('$cat','$subcategory','$amount','active')";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();


	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Sub-Category Added successfully.
              </div>';
	

}
if(isset($_POST['addcontact'])){
$contactname=$_POST['conname'];
$contactemail=$_POST['conemail'];
$contactphone=$_POST['conphone'];
$contactaddress=$_POST['accountid'];
$accountid=$_POST['accountid'];
$adddate=date('Y-m-d');
$sql1="INSERT INTO `contact`(`id`, `name`, `email`, `address`, `phone`, `type`, `adddate`) VALUES ('$accountid','$contactname','$contactemail','$contactaddress','$contactphone','business','$adddate')";
$stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Sub-Category is Activated Successfully.
				</div>"; 	
	 
}
if(isset($_POST['addcatcontact'])){
$contactname=$_POST['conname'];
$contactemail=$_POST['conemail'];
$contactphone=$_POST['conphone'];
$contactaddress=$_POST['accountid'];
$accountid=$_POST['accountid'];
$adddate=date('Y-m-d');
$sql1="INSERT INTO `contact`(`id`, `name`, `email`, `address`, `phone`, `type`, `adddate`) VALUES ('$accountid','$contactname','$contactemail','$contactaddress','$contactphone','business','$adddate')";
$stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Sub-Category is Activated Successfully.
				</div>"; 	
	 
}
?>
<!DOCTYPE html>
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
		  <header class="main-header"></header>
			<div class="content-wrapper">
			  <section class="content">
				<div class="row">
				  <div class="col-md-9">
				 	<?php echo $msg;?>
					<div class="nav-tabs-custom">
					  <ul class="nav nav-tabs">
						<li  class="active"><a href="#timeline" data-toggle="tab">Bussiness</a></li>
						<li><a href="#activity" data-toggle="tab">Account</a></li>
					  </ul>
					  <div class="tab-content">
					    <div class=" active tab-pane" id="timeline">
						
							<?php if($usertype == 'validuser'){?>
						<button class="btn btn-info" style="float: right;padding-right: 7px;" data-toggle="modal" data-target="#feedback" id="addMemberModalBtn"><span class="glyphicon glyphicon-plus-sign"></span>Add Bussiness</button>
						</br></br>
						<?php } ?>
							<div class="box box-info">
							  <div class="box-body">
								<table id="example4" class="table table-bordered">
								  <thead>
									<tr>
									  <th>s.no</th>
									  <th>Bussiness Name</th>
									  <th>Created Date</th>
									  
									  <th>Operations</th>
									 
									</tr>  
								  </thead>
								  <tbody>
									 <?php 
										$i = 1;
									    $sql="SELECT * FROM  groups  WHERE  `added_user_id`='$id' group by account_id";
										$log->event_log($sql,'d');
										$stmt = $user_home->runQuery($sql);
										$stmt->execute();
										while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){
										$accountid=	$row1['account_id'];									
										$row=$user_home->get_accountdetails($row1['account_id']);
										//$date=$row['date'];
										$originalDate = $row['date'];
										$newDate = date("Y-m-d", strtotime($originalDate));
									?>
									<tr>
									   <td><?php echo $i;  ?></td>
									   <td><?php echo $row['accountname']; ?></td>
									   <td><?php echo $newDate ?></td>
									    <td> <?php if($row['user_id']== $captureid){ ?>
										<?php  if($row1['account_status']=='active'){?>
										<a href=""  data-toggle="modal" data-target="#modalaccedit<?php echo $row['account_id']; ?>" title="Edit"> <i class="fa  fa-edit" aria-hidden="true" style="font-size:15px;color:   green;"></i></a>
										
										<a href=""  data-toggle="modal" data-target="#modaladdcont<?php echo $row['account_id']; ?>" title="Edit"> <i class="fa  fa-phone" aria-hidden="true" style="font-size:15px;color:   green;"></i></a>
										
										
										
									    <a href=""  data-toggle="modal" data-target="#modalaccinactive<?php echo $row['account_id']; ?>" title="In-Active"> <i class="fa  fa-check" aria-hidden="true" style="font-size:15px;color:   red;"></i></a>
									    <a href=""  data-toggle="modal" data-target="#modalacccatadd<?php echo $row['account_id']; ?>"> <i class="glyphicon glyphicon-plus-sign" aria-hidden="true" style="font-size:15px;color:   blue;"></i></a>
									   <?php } else { ?>
									     <a href=""  data-toggle="modal" data-target="#modalaccactive<?php echo $row['account_id']; ?>" title="Active"> <i class="fa  fa-ban" aria-hidden="true" style="font-size:15px;color:   red;"></i></a>
										
									   <?php } ?>
									   <?php } ?>
									   <a href="m_alllist.php?id=<?php echo base64_encode($row1['account_id']);?>" title="Transactions"> <i class="fa  fa-exchange" aria-hadded_user_ididden="true" style="font-size:18px;color:   #0C14B7;" ></i></a> 
					
									   </td>
									 <div class="modal fade" id="modalacccatadd<?php echo $row['account_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">Add Account</h4>
											</div>
											<form action="" method="POST">
											<div class="modal-body">
												<div class="row">
										 <label for="name" class="col-sm-2 control-label">Type</label>
											<div class="col-sm-9"> 
												<select align="center" name ="type"  class="form-control">
												<option value=''> Select Account Type</option>
													<option value='expenses'  <?php if($row['cat_type']=="expenses")echo selected?>> <?php echo expenses; ?></option>
													<option value='income'  <?php if($row['cat_type']=="income")echo selected?>> <?php echo income; ?></option>
												</select>
											</div>
										</div>
										<br>
										<div class="row">
											<label for="name" class="col-sm-2 col-sm-2 control-label">Account</label>
												<div class="col-sm-9"> 
													<input type="text" class="form-control" placeholder="Enter Account Name"   name="category" value="<?php echo $row['cat_name']; ?>" ></input>	
												</div>
										</div>											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<input class = "btn btn-primary" name = "catadd" type="submit" value="Add">
												<input name = "account" type="hidden" value="<?php echo $row['account_id']; ?>">
											</div>
											</form>
										  </div>
										</div>
									  </div>
									  <div class="modal fade" id="modalaccinactive<?php echo $row['account_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">In-Active</h4>
											</div>
											<form action="" method="POST">
											<div class="modal-body">
												<p>Are You Relly Want In-Active this Bussiness</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<input class = "btn btn-primary" name = "accountinactive" type="submit" value="In-Active">
												<input name = "deleteiteam" type="hidden" value="<?php echo $row['account_id']; ?>">
											</div>
											</form>
										  </div>
										</div>
									  </div>  
									  <div class="modal fade" id="modalaccedit<?php echo $row['account_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">In-Active</h4>
											</div>
											<form action="" method="POST">
											<div class="modal-body">
											<div class="row">
										  <label for="name" class="col-sm-2 control-label">BussinessName</label>
											<div class="col-sm-9"> 
											  <input type="text" class="form-control"placeholder="Account Name" name="account"  value="<?php echo  $row['accountname'] ?>"  ></input>
											</div>
										</div>	
										</br>
										<div class="row">
										  <label for="name" class="col-sm-2 control-label">BussinessName</label>
											<div class="col-sm-9"> 
												<select align="center" name ="currency" id ="currency"     class="form-control"  >
													<option value='BRL' <?php if('BRL' == $row['currcode'])echo selected  ?>>Brazilian Real</option>
													<option value='BDT'  <?php if( 'BDT' ==$row['currcode'])echo selected ?>>Bangladeshi Taka</option>
													<option value='CAD' <?php if('CAD' == $row['currcode'])echo selected  ?>>Canadian Dollar</option>
													<option value='CHF' <?php if('CHF' == $row['currcode'])echo selected  ?>>Swiss Franc</option>
													<option value='CRC' <?php if('CRC' == $row['currcode'])echo selected  ?>>Costa Rican Colon</option>
													<option value='CZK' <?php if('CZK' == $row['currcode'])echo selected  ?>>Czech Koruna</option>
													<option value='DKK' <?php if('DKK' == $row['currcode'])echo selected  ?> >Danish Krone</option>
													<option value='EUR'<?php if('EUR' == $row['currcode'])echo selected  ?>>Euro</option>
													<option value='HKD'<?php if('HKD' == $row['currcode'])echo selected  ?>>Hong Kong Dollar</option>
													<option value='HUF'<?php if('HUF' == $row['currcode'])echo selected  ?>>Hungarian Forint</option>
													<option value='ILS'<?php if('ILS' == $row['currcode'])echo selected  ?>>Israeli New Sheqel</option>
													<option value='INR' <?php if('INR' == $row['currcode'])echo selected  ?>>Indian Rupee</option>
													<option value='ILS' <?php if('ILS' == $row['currcode'])echo selected  ?>>Israeli New Shekel</option>
													<option value='JPY' <?php if('JPY' == $row['currcode'])echo selected  ?>>JapaneseYen</option>
													<option value='KZT'<?php if('KZT' == $row['currcode'])echo selected  ?>>Kazakhstan Tenge</option>
													<option value='KRW'<?php if('KRW' == $row['currcode'])echo selected  ?>>Korean Won</option>
													<option value='KHR'<?php if('KHR' == $row['currcode'])echo selected  ?>>Cambodia Kampuchean Riel</option>
													<option value='MYR'<?php if('MYR' == $row['currcode'])echo selected  ?>>Malaysian Ringgit</option>
													<option value='MXN'<?php if('MXN' == $row['currcode'])echo selected  ?>>Mexican Peso</option>
													<option value='NOK'<?php if('NOK' == $row['currcode'])echo selected  ?>>Norwegian Krone</option>
													<option value='NGN'<?php if('NGN' == $row['currcode'])echo selected  ?>>Nigerian Naira</option>
													<option value='NZD'<?php if('NZD' == $row['currcode'])echo selected  ?>>New Zealand Dollar</option>
													<option value='PHP'<?php if('PHP' == $row['currcode'])echo selected  ?>>Philippine Peso</option>
													<option value='PKR'<?php if('PKR' == $row['currcode'])echo selected  ?>>Pakistani Rupees</option>
													<option value='PLN'<?php if('PLN' == $row['currcode'])echo selected  ?>>Polish Zloty</option>
													<option value='SEK'<?php if('SEK' == $row['currcode'])echo selected  ?>>Swedish Krona</option>
													<option value='TWD'<?php if('TWD' == $row['currcode'])echo selected  ?>>Taiwan New Dollar</option>
													<option value='THB'<?php if('THB' == $row['currcode'])echo selected  ?>>Thai Baht</option>
													<option value='TRY'<?php if('TRY' == $row['currcode'])echo selected  ?>>Turkish Lira</option>
													<option value='USD'<?php if('USD' == $row['currcode'])echo selected  ?>>U.S. Dollar</option>
													<option value='VND'<?php if('VND' == $row['currcode'])echo selected  ?>>Vietnamese Dong</option>
											</select>
										
											</div>
										</div>	
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<input class = "btn btn-primary" name = "Update" type="submit" value="Update">
												<input name = "deleteiteam" type="hidden" value="<?php echo $row['account_id']; ?>">
											</div>
											</form>
										  </div>
										</div>
									  </div> 
									  <div class="modal fade" id="modaladdcont<?php echo $row['account_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">Add Contact</h4>
											</div>
											<form action="" method="POST">
											 <div class="modal-body">
											<div class="row">
											  <label for="name" class="col-sm-2 control-label">Name</label>
											  <div class="col-sm-9" > 
												<input type="text" class="form-control"    required name="conname" placeholder="Name">
											  </div>
											</div>
											<br>
										<div class="row">
										  <label for="name" class="col-sm-2 control-label">Email</label>
										  <div class="col-sm-9"  > 
											<input type="email" class="form-control"     required name="conemail" placeholder="Email">
										  </div>
										</div>
										<br>
									<div class="row">
									  <label for="name" class="col-sm-2 control-label">Phone</label>
									  <div class="col-sm-9" > 
										<input type="Number" class="form-control"     required name="conphone" placeholder="Phone">
									  </div>
									</div>
									<br>
									<div class="row">
									  <label for="name" class="col-sm-2 control-label">Address</label>
									  <div class="col-sm-9" > 
										<input type="text" class="form-control"    required name="conaddress" placeholder="Address">
									  </div>
									</div>
									<br>
									
          
								</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<input class = "btn btn-primary" name = "addcontact" type="submit" value="Add">
												<input name = "accountid" type="hidden" value="<?php echo $row['account_id']; ?>">
											</div>
											</form>
										  </div>
										</div>
									  </div>  
									  
									  <div class="modal fade" id="modalaccactive<?php echo $row['account_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">Active</h4>
											</div>
											<form action="" method="POST">
											<div class="modal-body">
												<p>Are You Relly Want  To Activate this Bussiness</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<input class = "btn btn-primary" name = "activateaccount" type="submit" value="Active">
												<input name = "accid" type="hidden" value="<?php echo $row['account_id']; ?>">
											</div>
											</form>
										  </div>
										</div>
									  </div>
									</tr>
									<?php $i++; }  ?>
								  </tbody>
								</table>
							  </div>
							</div>
						</div>
						<div class="modal fade" id="feedback">
							<div class="modal-dialog">
							  <div class="modal-content">
								<div class="modal-header">
								<h4>Add Bussiness</h4>
								  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span></button>
								</div>
								<form class="form-horizontal" action="" method="POST" >
								  <div class="modal-body">
								      <div class="modal-body">
										<div class="row">
										  <label for="name" class="col-sm-2 control-label">BussinessName</label>
											<div class="col-sm-9"> 
											  <input type="text" class="form-control"placeholder="Account Name" name="account"  required  ></input>
											</div>
										</div>
										</br>
										<div class="row">
										  <label for="name" class="col-sm-2 control-label">Currency Type</label>
											<div class="col-sm-9"> 
												<select align="center" name ="currency" id ="currency"  required    class="form-control"  >
													<option value='BRL'>Brazilian Real</option>
													<option value='BDT'>Bangladeshi Taka</option>
													<option value='CAD'>Canadian Dollar</option>
													<option value='CHF'>Swiss Franc</option>
													<option value='CRC'>Costa Rican Colon</option>
													<option value='CZK'>Czech Koruna</option>
													<option value='DKK'>Danish Krone</option>
													<option value='EUR'>Euro</option>
													<option value='HKD'>Hong Kong Dollar</option>
													<option value='HUF'>Hungarian Forint</option>
													<option value='ILS'>Israeli New Sheqel</option>
													<option value='INR'>Indian Rupee</option>
													<option value='ILS'>Israeli New Shekel</option>
													<option value='JPY'>JapaneseYen</option>
													<option value='KZT'>Kazakhstan Tenge</option>
													<option value='KRW'>Korean Won</option>
													<option value='KHR'>Cambodia Kampuchean Riel</option>
													<option value='MYR'>Malaysian Ringgit</option>
													<option value='MXN'>Mexican Peso</option>
													<option value='NOK'>Norwegian Krone</option>
													<option value='NGN'>Nigerian Naira</option>
													<option value='NZD'>New Zealand Dollar</option>
													<option value='PHP'>Philippine Peso</option>
													<option value='PKR'>Pakistani Rupees</option>
													<option value='PLN'>Polish Zloty</option>
													<option value='SEK'>Swedish Krona</option>
													<option value='TWD'>Taiwan New Dollar</option>
													<option value='THB'>Thai Baht</option>
													<option value='TRY'>Turkish Lira</option>
													<option value='USD'>U.S. Dollar</option>
													<option value='VND'>Vietnamese Dong</option>
													
												</select>
											</div>
										</div>
										</br>
									   </div>
									   <div class="modal-footer">
										<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary" name = "accountadd">Add</button>
									  </div>
								  </div>
								</form>
							  </div>
							</div>
						</div>
						<!-- /.tab-pane -->
						
					
						<div class="tab-pane" id="activity" >
							<div class="box box-warning">
							  <div class="box-body">
								<form class="form-horizontal"  method = "POST" action ="">
								<div class="col-md-12 col-xs-12 col-sm-12">
									<table id="example3" class="table table-bordered">
								  <thead>
									<tr>
									  <th>Bussiness Name</th>
									  <th>Account</th> 
									  <th>Type</th>
									  <th>Operations</th>
									</tr>  
								  </thead>
								  <tbody>
									 <?php 
									 
										$i = 1;
									    $sql="SELECT * FROM `category` a, accounts b WHERE a.`account_id`=b.account_id and b.user_id='$captureid'";
										$stmt = $user_home->runQuery($sql);
										$stmt->execute();
										while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
										//$row=$user_home->get_accountrow($row1['account_id']);
									?>
									<tr>
									 
									   <td><?php echo $row['accountname']; ?></td>
									   <td><?php echo $row['cat_name']; ?></td> 
									   <td><?php echo $row['cat_type']; ?></td>
									   	
									   <td>
									  <a href=""  data-toggle="modal" data-target="#modaledit<?php echo $row['cat_id']; ?>" title="Edit"> <i class="fa  fa-edit" aria-hidden="true" style="font-size:15px;color:   green;"></i></a>
									  <a href=""  data-toggle="modal" data-target="#modaladdcatcont<?php echo $row['cat_id']; ?>" title="Edit"> <i class="fa  fa-phone" aria-hidden="true" style="font-size:15px;color:   green;"></i></a>
										
									  <?php if($row['status']=='active'){ ?>
									  
										<a href=""  data-toggle="modal" data-target="#modalinactive<?php echo $row['cat_id']; ?>" title="Inactive"> <i class="fa  fa-check" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
										<a href=""  data-toggle="modal" data-target="#modaladd<?php echo $row['cat_id']; ?>"title="Add Sub-Category"> <i class="glyphicon glyphicon-plus-sign"aria-hidden="true" style="font-size:15px;"></i></a>
									  									 
									 <?php } else{ ?>
									   
									    <a href=""  data-toggle="modal" data-target="#modalactive<?php echo $row['cat_id']; ?>" title="Inactive"> <i class="fa  fa-ban" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
									  
									   <?php }?>
									  
									   </td>
									  <div class="modal fade" id="modaladdcatcont<?php echo $row['cat_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">Add Contact</h4>
											</div>
											<form action="" method="POST">
											 <div class="modal-body">
											<div class="row">
											  <label for="name" class="col-sm-2 control-label">Name</label>
											  <div class="col-sm-9" > 
												<input type="text" class="form-control"    required name="conname" placeholder="Name">
											  </div>
											</div>
											<br>
										<div class="row">
										  <label for="name" class="col-sm-2 control-label">Email</label>
										  <div class="col-sm-9"  > 
											<input type="email" class="form-control"     required name="conemail" placeholder="Email">
										  </div>
										</div>
										<br>
									<div class="row">
									  <label for="name" class="col-sm-2 control-label">Phone</label>
									  <div class="col-sm-9" > 
										<input type="Number" class="form-control"     required name="conphone" placeholder="Phone">
									  </div>
									</div>
									<br>
									<div class="row">
									  <label for="name" class="col-sm-2 control-label">Address</label>
									  <div class="col-sm-9" > 
										<input type="text" class="form-control"    required name="conaddress" placeholder="Address">
									  </div>
									</div>
									<br>
									
          
								</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<input class = "btn btn-primary" name = "addcatcontact" type="submit" value="Add">
												<input name = "accountid" type="hidden" value="<?php echo $row['cat_id']; ?>">
											</div>
											</form>
										  </div>
										</div>
									  </div> 
									  <div class="modal fade" id="modalinactive<?php echo $row['cat_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">In-Active</h4>
											</div>
											<form action="" method="POST">
											<div class="modal-body">
												<p>Are You Relly Want In-Active this Account</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<input class = "btn btn-primary" name = "inactivecat" type="submit" value="In-Active">
												<input name = "deleteiteam" type="hidden" value="<?php echo $row['cat_id']; ?>">
											</div>
											</form>
										  </div>
										</div>
									  </div> 
									  <div class="modal fade" id="modalactive<?php echo $row['cat_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">Active</h4>
											</div>
											<form action="" method="POST">
											<div class="modal-body">
												<p>Are You Relly Want Activate this Account</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<input class = "btn btn-primary" name = "activecat" type="submit" value="Active">
												<input name = "deleteiteam" type="hidden" value="<?php echo $row['cat_id']; ?>">
											</div>
											</form>
										  </div>
										</div>
									  </div>
									   <div class="modal fade" id="modaledit<?php echo $row['cat_id']?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">Edit</h4>
											</div>
											<form action="" method="POST">
											<div class="modal-body">
										<div class="row">
										 <label for="name" class="col-sm-2 control-label">Bussiness</label>
											<div class="col-sm-9"> 
												<select align="center" name ="account"  class="form-control">
													 <?php  
													 $sql1="SELECT * FROM `accounts` WHERE `user_id`='$captureid' ";
													$stmt1 = $user_home->runQuery($sql1);
													 $stmt1->execute();
													  echo "<option value=''>Select Account</option>";
													 while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
													 ?>
													  <option value='<?php echo $row1['account_id']?>' <?php if($row1['account_id']==$row['account_id'])echo selected?>> <?php echo $row1['accountname']; ?></option>
													 <?php } ?>
												</select>
											</div>
										</div>
										<br>
										<div class="row">
										 <label for="name" class="col-sm-2 control-label">Type</label>
											<div class="col-sm-9"> 
												<select align="center" name ="type"  class="form-control">
												<option value=''> Select Account Type</option>
													<option value='expenses'  <?php if($row['cat_type']=="expenses")echo selected?>> <?php echo expenses; ?></option>
													<option value='income'  <?php if($row['cat_type']=="income")echo selected?>> <?php echo income; ?></option>
												</select>
											</div>
										</div>
										<br>
										<div class="row">
											<label for="name" class="col-sm-2 col-sm-2 control-label">Account</label>
												<div class="col-sm-9"> 
													<input type="text" class="form-control" placeholder="Enter Account Name"   name="category" value="<?php echo $row['cat_name']; ?>" ></input>	
												</div>
										</div>
									   </div>
											   <div class="modal-footer">
											   	<input type="hidden" class="form-control" placeholder="Enter Account Name"   name="catid" value="<?php echo $row['cat_id']; ?>" ></input>
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary" name = "updatecat">Update</button>
											  </div>
											 
											</form>
										  </div>
										</div>
									  </div>
										<div class="modal fade" id="modaladd<?php echo $row['cat_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">Add Sub-Account</h4>
											</div>
											<form action="" method="POST">
											  <div class="modal-body">
											  <div class="row">
											<label for="name" class="col-sm-4 control-label">Sub-Account</label>
												<div class="col-sm-7"> 
											<input type="text" class="form-control" placeholder="Enter Sub-Account Name"  required  name="subcatname"  ></input>	
												</div>
										</div>
										<br>
										<div class="row">
											<label for="name" class="col-sm-4 control-label">Amount</label>
												<div class="col-sm-7"> 
													<input type="text" class="form-control" placeholder="Enter Default Amount" required  name="amount" ></input>	
												</div>
										</div>
										</div>
											<br>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<input class = "btn btn-primary" name = "addsubcategory" type="submit" value="Add">
												<input name = "cat" type="hidden" value="<?php echo $row['cat_id']; ?>">
											</div>
											</form>
										  </div>
										</div>
									  </div>
									  
									</tr>
									<?php $i++; }  ?>
								  </tbody>
								</table>
								</div>
							  </form>
							  </div>
							</div>
						</div>
					  </div>
					<!-- /.tab-content -->
					</div>
				  <!-- /.nav-tabs-custom -->
				  </div>
				</div>
			  <!-- /.row -->
              </section>
			</div>
			<div class="control-sidebar-bg"></div>
		</div>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<script src="bower_components/fastclick/lib/fastclick.js"></script>
	<script src="dist/js/adminlte.min.js"></script>
	<script>
	  $(function () {
	
		$('#example3').DataTable({
	  "ordering": false
		});
		
	  });
	</script>
	<script>
	  $(function () {
	
		$('#example4').DataTable({
	  "ordering": false
		});
		
	  });
	</script>
	<script>
	  $(function () {
		
		$('#example5').DataTable({
	  "ordering": false
		});
		
	  });
	</script>
	<script>
	  $(function () {
		
		$('#example11').DataTable({
	  "ordering": false
		});
		
	  });
	</script>
	<script>
	   //Date picker
		$('#datepicker').datepicker({
		  autoclose: true
		})
	</script>
	<script>
	   //Date picker
		$('#datepicker1').datepicker({
		  autoclose: true
		})
	</script>
</body>
</html>
