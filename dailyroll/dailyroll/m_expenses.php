<?php
session_start();
require_once 'class.user.php';
require_once '../constants/constants.php';
//require_once (".htacess");
$user_home = new USER();
require_once '../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d');
$id = $_SESSION['userSession'];
$unid = $_SESSION['unique_ID'];
//$month=MONTH_DATE; 
	$log->event_log($unid,'d');
 if(isset($_POST['uid']) && isset($_POST['email']))
{
	$email = $_POST['email'];
	 $log->event_log($email,'d');
	$upass = $_POST['uid'];
	$log->event_log($upass,'d');
	if($user_home->login1($email,$upass)){
		//echo"hii";
		$log->event_log("user loggined",'d');
				$check = $user_home->checkForSubscribe($_SESSION['userSession']);
	$result = $check['result'];
	if($result == "FALSE"){
	$_SESSION['usertype']='expireduser';
	$log->event_log('expired','d');
	$user_home->redirect('m_expenses.php');
		
	}elseif($result == "TRUE"){
	$_SESSION['usertype']='validuser';
	$log->event_log('validuser','d');
		$user_home->redirect('m_expenses.php');
		exit;
		$log->event_log('gj','d');
	} 
		  
	}
}
	
	 if(isset($_GET['uid']) && isset($_GET['email']))
{
	$email = $_GET['email'];
	 $log->event_log($email,'d');
	$upass = $_GET['uid'];
	$log->event_log($upass,'d');
	if($user_home->login1($email,$upass)){
		//echo"hii";
		$log->event_log("user loggined",'d');
				$check = $user_home->checkForSubscribe($_SESSION['userSession']);
	$result = $check['result'];
	if($result == "FALSE"){
	$_SESSION['usertype']='expireduser';
	$log->event_log('expired','d');
	$user_home->redirect('m_expenses.php');
		
	}elseif($result == "TRUE"){
	$_SESSION['usertype']='validuser';
	$log->event_log('validuser','d');
		$user_home->redirect('m_expenses.php');
		exit;
		$log->event_log('gj','d');
	} 
		  
	}
}
	
	
	if(isset($_POST['delete'])){
	  $file=$_POST['files'];
	  foreach ($file as $fid){
	  $sql1="DELETE FROM `expenses` WHERE `id`='$fid' ";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	//$log->event_log("files are deleted");
	 }
	$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Expenses is Deleted Successfully .
				</div>"; 	
	 
	
	}
	if(isset($_POST['deleteincome'])){
	  $file=$_POST['files'];
	  foreach ($file as $fid){
	  $sql1="DELETE FROM `income` WHERE `id`='$fid' ";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	//$log->event_log("files are deleted");
	 }
	$msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Expenses is Deleted Successfully .
				</div>"; 	
	 
	
	}

if(isset($_POST['update'])){
	$expenseid=$_POST['expenseid'];
	$date=$_POST['date'];
	$category=$_POST['category'];
	$description=$_POST['description'];
	$amount=$_POST['amount'];
	 $sql="UPDATE `expenses` SET `amount`='$amount',`description`='$description',`category`='$category',`date`='$date' WHERE `id`='$expenseid'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> </h4>
                Your expenses inserted successfully.
              </div>';
	

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

	  <header class="main-header">
	  </header>
	  <div class="content-wrapper">
		<section class="content">
		
			<div class="row">
			<div class="box box-warning box-solid">
					
				    <div class="box-body">
					<form class="form-horizontal" action="" method="POST" >
					  <div class="modal-body">
						<div class="messages" ></div>
						<div class="row">
							<div class="col-md-4">
								   <div class="form-group">
									<label for="name" class="col-sm-3 control-label">Account</label>
								<div class="col-sm-9"> 
								<select align="center" name ="accountid" id ="accountid"     class="form-control"  >
									<option>Select Account</option>
									<?php
										$sql="SELECT * FROM `groups` WHERE `account_status`='active' and `added_user_id`='$id' group by `account_id` ";
										$stmt = $user_home->runQuery($sql);
										$stmt->execute();
										while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
										$course = $user_home->get_accountdetails($row['account_id']);
										$accountname = $course['accountname'];
									?>
									<option value=  <?php echo $row['account_id'];?>  <?php if($_POST['accountid'] == $row['account_id']) echo selected?> <?php if($_SESSION['accountds'] == $row['account_id']) echo selected?> > <?php  echo$accountname ?>  </option>
									<?php } ?>		
								  </select>
								</div>
							   </div>
							</div>
							<?php
						    if(isset($_POST['search'])){
							$check=$_POST['check'];
							if($check == 'Yes' ){
							$checkstatus="checked";
							}elseif($check == 'No' ){
							$checkstatus="unchecked";
							
							}
							}
						    ?>					
							<div class="col-md-4">
							  <div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
								  <div class="checkbox">
									<label>
									<input type="checkbox" name="check"  <?php echo (isset($_POST['check'])?"value='No'":"value='Yes'")?> 
									<?php echo $checkstatus ?>  /> 
									<span>Include All Transcations</span>
									</label>
									 <button type="submit" name = "search" class="btn btn-primary">Search</button>
						
						
								  </div>
							    </div>
							  </div>
							</div>
							
						</div>
					 </div>
					</form> 
				  </div>
				</div>
		
			<?php if($_SESSION['usertype']=='validuser'){ ?>
			   <div class="col-md-9">
			   <?php echo $msg;?>
			   <div class="nav-tabs-custom">
					  <ul class="nav nav-tabs">
						<li  class="active"><a href="#timeline" data-toggle="tab">Expenses</a></li>
						<li><a href="#activity" data-toggle="tab">Income</a></li>
					  </ul>
					  <div class="tab-content">
					    <div class=" active tab-pane" id="timeline">
						
						</br></br>
							<div class="box box-info">
							  <div class="box-body">
							    <form class="form-horizontal"  method = "POST" action ="">
							
							
									
								<table id="example4" class="table table-bordered">
								  <thead>
									<tr>
									  <th>Accounts</th>
									</tr>
								  </thead>
								  <tbody>
									<?php
										$i=1;
										if(isset($_POST['search'])){
										$accid=$_POST['accountid'];
										$_SESSION['accountds']=$accid;
										$check=$_POST['check'];
										$_SESSION['checkboxs']=$check;
										if($check == 'Yes' ){
										$sql="SELECT * FROM `expenses` WHERE `account_id`='$accid' ";
										}
										else{
										$sql="SELECT * FROM `expenses` WHERE `account_id`='$accid' and `capture_id`='$unid' ";
										}
										}
										else{
										$sql="SELECT * FROM `expenses` WHERE `capture_id`='$unid'";
										
										}
										$sql=$sql."ORDER BY `id` DESC";
											//echo $sql;
										$log->event_log($sql,'d');
										$stmt = $user_home->runQuery($sql);
										$stmt->execute();
										while($row= $stmt->fetch(PDO::FETCH_ASSOC)){
											// print_r($row);
											//echo $row['freeze'];
											//$log->event_log(json_encode($row));
											$catname=$user_home->get_subcategory($row['subcat_id']);
											$accname=$user_home->get_account($row['account_id']);
											$originalDate = $row['tr_date'];
											$newDate = date("d-m-Y", strtotime($originalDate));
											$row2=$user_home->get_accountdetails($row['account_id']);
										//	print_r($row2);
											 $symbol=$row2['currcode'];
											$ss=$user_home->getCurrency_symbol($symbol);
											$accountadmin=$row2['user_id'];
											?>
										<tr>
											 <td>
											 	<?php echo $user_home->dencrypted($accname);?>,<?php echo $newDate ; ?>
												,<?php echo $row['description']; ?>, <?php echo $ss.' '.$row['amount']; ?> 
												  <?php  if(($row['capture_id'] == $unid or $accountadmin == $unid) and ($row['freeze'] !='freeze') ){ ?>
											  <a  href="mobileedit.php?expenses=<?php echo $row['id']; ?>"><i class="fa fa-edit (alias)"  aria-hidden="true" style="font-size:15px;color:   #0C14B7;"></i></a>
											  <?php } ?>	
											  <?php  if(($accountadmin==$unid)  and  ($row['freeze'] == 'freeze') ){ ?>
											  <a  href="mobileedit.php?expenses=<?php echo $row['id']; ?>"><i class="fa fa-edit (alias)"  aria-hidden="true" style="font-size:15px;color:   #0C14B7;"></i></a>
											  <?php } ?>
													 <?php
												$filename=$row['file_name'];
												if((strpos($filename, '.png') !== false) || (strpos($filename, '.jpg') !== false)) { ?>
												
												 <a  href="display.php?id=<?php echo $row['id']; ?>"><i class="fa  fa-eye" aria-hidden="true" style="font-size:15px;color:   #0C14B7;"></i></a>
												 
												<?php }  ?>
											</td>
										</tr>
										<?php $i++; }
										?>
								  </tbody>
								</table>
							  	</form>
							  </div>
							</div>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="activity">
						
						</br></br>
							<div class="box box-warning">
							  <div class="box-body">
								 <form class="form-horizontal"  method = "POST" action ="">
								<table id="example3" class="table table-bordered">
										 <thead>
									<tr>
									  <th>Accounts</th>
									</tr>
								  </thead>
										
								  <tbody>
									<?php
										$i=1;
										if(isset($_POST['search'])){
											$accid=$_POST['accountid'];
											$check=$_POST['check'];
											if($check == 'No' ){
											$sql="SELECT * FROM `income` WHERE `account_id`='$accid' ";
											}
											else{
											$sql="SELECT * FROM `income` WHERE `account_id`='$accid' and `capture_id`='$unid' ";
											}
											}
											else{
											$sql="SELECT * FROM `income` WHERE `capture_id`='$unid'";
											
											}
											$sql=$sql."ORDER BY `income_id` DESC";
											$log->event_log($sql,'d');
											//echo $sql;
											$stmt = $user_home->runQuery($sql);
											$stmt->execute();
											 while($row= $stmt->fetch(PDO::FETCH_ASSOC)){
											// print_r($row);
											//$row['freeze'];
											$log->event_log(json_encode($row),'d');
											 $catname=$user_home->get_subcategory($row['subcat_id']);
											 $accname=$user_home->get_account($row['account_id']);
											 $row2=$user_home->get_accountdetails($row['account_id']);
											$symbol=$row2['currcode'];
											 $ss=$user_home->getCurrency_symbol($symbol);
											$accountadmin=$row2['user_id'];
											
											?>
										<tr>
											 <td>
											  	<?php echo $user_home->dencrypted($accname);?>,<?php echo $row['tr_date']; ?>
												,<?php echo $row['description']; ?>, <?php echo$ss.' '. $row['income_amount']; ?> 
												  <?php  if(($row['capture_id']==$unid or $accountadmin==$unid) and ($row['freeze'] !='freeze')){ ?>
											  <a  href="mobileincomeedit.php?income=<?php echo $row['income_id']; ?>"><i class="fa fa-edit (alias)"  aria-hidden="true" style="font-size:15px;color:   #0C14B7;"></i></a>
											  <?php } ?>												 
											  <?php  if(($accountadmin == $unid) and ($row['freeze'] =='freeze')){ ?>
											  <a  href="mobileincomeedit.php?income=<?php echo $row['income_id']; ?>"><i class="fa fa-edit (alias)"  aria-hidden="true" style="font-size:15px;color:   #0C14B7;"></i></a>
											  <?php } ?>
													
											</td>
										</tr>
										<?php $i++; }
										?>
								  </tbody>
									</table>
								
							  </div>
							</div>
						</div>
					</form>

						</div>
					<!-- /.tab-content -->
					
				</div>
			  <!-- /.row -->
            
		</section>
		<!-- /.content -->
		<?php } else if($_SESSION['usertype']=='expireduser') {?>
		<p align="center" style="font:25px; color :blue"> Your Subscription is Expired Please Renewal</P>
		
		<?php } ?>
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
	<script src="dist/js/demo.js"></script>
	<script>
	  $(function () {
	
		$('#example1').DataTable({
	  "ordering": false
		});
		
	  });
	</script>
	<script>
	  $(function () {
	
		$('#example2').DataTable({
	  "ordering": false
		});
		
	  });
	</script>
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
