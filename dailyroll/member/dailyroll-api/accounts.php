<?php
session_start();
require_once 'class.user.php';
require_once '../../constants/constants.php';
//require_once (".htacess");
$user_home = new USER();
$id = $_SESSION['userSession'];
$captureid = $_SESSION['unique_ID'];
//$month=MONTH_DATE;
$usertype=$user_home->getusertype($id);
if(isset($_POST['delete'])){
	  $file=$_POST['deleteiteam'];
	  $sql1="UPDATE `accounts` SET `accountstatus`='inactive' WHERE `account_id`='$file'";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	 // echo $sql1;
	  $sql2="UPDATE `groups` SET `account_status`='inactive' WHERE `account_id`='$file'";	
	  $stmt2 = $user_home->runQuery($sql2);
	  $stmt2->execute();
	 // echo $sql2;
	  
	//event_log("files are deleted");
	 
	 $msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Account is In-Activate.
				</div>"; 	
	 
	
	}
if(isset($_POST['unarchive'])){
	  $file=$_POST['deleteiteam'];
	  $sql1="UPDATE `accounts` SET `accountstatus`='active' WHERE `account_id`='$file'";	
	  $stmt1 = $user_home->runQuery($sql1);
	  $stmt1->execute();
	 // echo $sql1;
	  $sql2="UPDATE `groups` SET `account_status`='active' WHERE `account_id`='$file'";	
	  $stmt2 = $user_home->runQuery($sql2);
	  $stmt2->execute();
	 // echo $sql2;
	  
	//event_log("files are deleted");
	 
	 $msg = "<div class='alert alert-success alert-dismissible' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<strong> <span class='glyphicon glyphicon-ok-sign'></span> </strong>  Account is Activate.
				</div>"; 	
	 
	
	}

if(isset($_POST['accountadd'])){
$account=$_POST['account'];
$date=date('Y-m-d');
 $sql="INSERT INTO `accounts`(`user_id`, `accountname`, `date`, `accountstatus`) VALUES ('$captureid','$account','$date','active')";
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

?>
<!DOCTYPE html>
<html>
<?php include"menu.php";?>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
		  <header class="main-header"></header>
			<div class="content-wrapper">
			 <section class="content-header">
      <h1>
        Accounts
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Accounts</li>
      </ol>
    </section>
			  <section class="content">
				<div class="row">
				  <div class="col-md-9">
					<?php echo $msg;?>
					<div class="nav-tabs-custom">
					  <ul class="nav nav-tabs">
						<li  class="active"><a href="#timeline" data-toggle="tab">Accounts</a></li>
						<li><a href="#activity" data-toggle="tab">Archived Accounts</a></li>
					  </ul>
					  <div class="tab-content">
					    <div class=" active tab-pane" id="timeline">
							<?php if($usertype == 'validuser'){?>
						<button class="btn btn-info" style="float: right;padding-right: 7px;" data-toggle="modal" data-target="#feedback" id="addMemberModalBtn"><span class="glyphicon glyphicon-plus-sign"></span>Add Account</button>
						</br></br>
						<?php } ?>
							<div class="box box-info">
							  <div class="box-body">
								<table id="example4" class="table table-bordered">
								  <thead>
									<tr>
									  <th>S.No</th>
									  <th>Account Name</th>
									  <th>Created Date</th>
									  	<?php if($usertype == 'validuser'){?>
									  <th>Operations</th>
									  <?php } ?>
									</tr>  
								  </thead>
								  <tbody>
									 <?php 
										$i = 1;
									    $sql="SELECT * FROM  groups  WHERE  `added_user_id`='$id' group by account_id";
										$stmt = $user_home->runQuery($sql);
										$stmt->execute();
										while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
										$row=$user_home->get_accountdetails($row1['account_id']);
									?>
									<tr>
									   <td><?php echo $i;  ?></td>
									   <td><?php echo $row['accountname']; ?></td>
									   <td><?php echo $row['date']; ?></td>
									   	<?php if($usertype == 'validuser'){?>
									   <td><a href="groupdetails.php?id=<?php echo base64_encode($row1['account_id']);?>" title="View Details"> <i class="fa fa-eye" aria-hidden="true" style="font-size:15px;color:   #0C14B7;"></i></a>&nbsp;&nbsp;&nbsp
									   <?php if($row['user_id']== $captureid ){ ?>
									   <?php if($row['accountstatus']=='active'){?>
									   <a href=""  data-toggle="modal" data-target="#modalactive1<?php echo $row['account_id']; ?>"title="In-Active"> <i class="fa  fa-check" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
									   <?php }  else { ?>
										<a href=""  data-toggle="modal" data-target="#modalinactive2<?php echo $row['account_id']; ?>" title="Active"> <i class="fa  fa-ban" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
																				   
									   <?php } ?>	
									    <a href="alllist.php?id=<?php echo base64_encode($row1['account_id']);?>" title="Transactions"> <i class="fa  fa-exchange" aria-hadded_user_ididden="true" style="font-size:18px;color:   #0C14B7;" ></i></a> 
														   
									   <?php } ?>
									   </td>
									   <?php } ?>
									  <div class="modal fade" id="modalactive1<?php echo $row['account_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												  <span aria-hidden="true">&times;</span></button>
													 <h4 class="modal-title">In-Activate</h4>
											</div>
											<form action="" method="POST">
											<div class="modal-body">
												<p>Are You Relly Want In-Activate this Account</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<input class = "btn btn-primary" name = "delete" type="submit" value="In-Activate">
												<input name = "deleteiteam" type="hidden" value="<?php echo $row['account_id']; ?>">
											</div>
											</form>
										  </div>
										</div>
									  </div>
									  <div class="modal fade" id="modal-delay<?php echo $row['account_id']; ?>">
										<div class="modal-dialog">
										  <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span></button>
											  <h4 class="modal-title">Account Details</h4>
											</div>
											<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" >
											  <div class="modal-body">
												<div class="row">
												  <label for="name" class="col-sm-2 control-label">Account Name</label>
												  <div class="col-sm-9"> 
													<input type="text" class="form-control"placeholder="account" name="account"  value="<?php echo $row['accountname']; ?>" ></input>
												  </div>
												</div>
												</br>
											  </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary" name = "update">Update</button>
												<input type="hidden" class="btn btn-primary" name = "accountid" value="<?php echo $row['account_id'];?>"/>
											  </div>
											</form>
										  </div>
										</div>
									  </div>
									  <div class="modal fade" id="modalinactive2<?php echo $row['account_id']; ?>">
											<div class="modal-dialog">
											  <div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span></button>
														 <h4 class="modal-title">Activate</h4>
												</div>
												<form action="" method="POST">
												<div class="modal-body">
													<p>Are You Relly Want Activate this Account</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
													<input class = "btn btn-primary" name = "unarchive" type="submit" value="Activate">
													<input name = "deleteiteam" type="hidden" value="<?php echo $row['account_id']; ?>">
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
								<h4>Add Account</h4>
								  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span></button>
								</div>
								<form class="form-horizontal" action="" method="POST" >
								  <div class="modal-body">
								      <div class="modal-body">
										<div class="row">
										  <label for="name" class="col-sm-2 control-label">Account Name</label>
											<div class="col-sm-9"> 
											  <input type="text" class="form-control"placeholder="Account Name" name="account"   ></input>
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
						<div class="tab-pane" id="activity">
							<div class="box box-warning">
							  <div class="box-body">
								<form class="form-horizontal"  method = "POST" action ="">
									<table id="example3" class="table table-bordered">
										<thead>
										  <tr>
											<th>S.No</th>
											<th>Account Name</th>
											<th>Created Date</th>
											<th>Operations</th>
										   </tr>  
										</thead>
										<tbody>
										 <?php 
											$i = 1;
										   $sql="SELECT * FROM `accounts` WHERE `user_id`='$captureid' AND `accountstatus`!='active'";
											$stmt = $user_home->runQuery($sql);
											$stmt->execute();
											//echo $sql;
											while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
											$row=$user_home->get_accountdetails($row1['account_id']);
										?>
										<tr>
										   <td><?php echo $i;  ?></td>
										   <td><?php echo $row['accountname']; ?></td>
										   <td><?php echo $row['date']; ?></td>
										   <td><a href="groupdetails.php?id=<?php echo base64_encode($row1['account_id']);?>" title="View Details"> <i class="fa fa-eye" aria-hidden="true" style="font-size:15px;color:   #0C14B7;"></i></a>&nbsp;&nbsp;&nbsp
										   <a href=""  data-toggle="modal" data-target="#modalunshare2" title="UnArchive"> <i class="fa  fa-archive" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
											</td>
										  <div class="modal fade" id="modalunshare2">
											<div class="modal-dialog">
											  <div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span></button>
														 <h4 class="modal-title">UnArchive</h4>
												</div>
												<form action="" method="POST">
												<div class="modal-body">
													<p>Are You Relly Want UnArchive this Account</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
													<input class = "btn btn-primary" name = "unarchive" type="submit" value="Archive">
													<input name = "deleteiteam" type="hidden" value="<?php echo $row['account_id']; ?>">
												</div>
												</form>
											  </div>
											</div>
										  </div>
										 </tr>
										<?php $i++; }  ?>
										</tbody>
									</table>
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
			<?php include "footer.php"; ?>
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
	 
		});
		
	  });
	</script>
	<script>
	  $(function () {
	
		$('#example4').DataTable({
	 
		});
		
	  });
	</script>
	<script>
	  $(function () {
		
		$('#example5').DataTable({
	
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
