<?php
session_start();
require_once 'class.user.php';
require_once '../constants/constants.php';
//require_once (".htacess");
$user_home = new USER();
$id = $_SESSION['userSession'];
$captureid = $_SESSION['unique_ID'];
//$month=MONTH_DATE;
if(isset($_GET['id']))
{
$account=base64_decode($_GET['id']);
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
				  <a href="m_accounts.php" ><i class="fa fa-arrow-left" aria-hadded_user_ididden="true" style="font-size:25px;color:   #0C14B7;" ></i></a>
				</br>
				  <div class="col-md-9">
					<div class="nav-tabs-custom">
					  <ul class="nav nav-tabs">
						<li  class="active"><a href="#timeline" data-toggle="tab">Expenses</a></li>
						<li><a href="#activity" data-toggle="tab">Income</a></li>
					  </ul>
					  <div class="tab-content">
					    <div class=" active tab-pane" id="timeline">
							<div class="box box-info">
							  <div class="box-body">
								<table id="example4" class="table table-bordered">
								  <thead>
									<tr>
									  <th>S.No</th>
									  <th>Date  </th>
									  <th>Name</th>
									  <th>Category</th>
									  <th>Sub-Category</th>
									  <th>Description</th>
									  <th>Amount</th>
									</tr>  
								  </thead>
								  <tbody>
									 <?php 
										$i = 1;
									    $sql="SELECT * FROM `expenses` WHERE `account_id`='$account' ORDER BY `id` DESC";
										$stmt = $user_home->runQuery($sql);
										$stmt->execute();
										while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
										$catname=$user_home->get_category($row['cat_id']);
										$des= substr($row['description'], 0, 10);
										$originalDate = $row['tr_date'];
										$newDate = date("d-m-Y", strtotime($originalDate));
										 $capid=$row['capture_id'];
										$name=$user_home->getnamebycap($capid);
									?>
									<tr>
									  <td><?php echo $i;  ?></td>
									   <td><?php echo $newDate; ?></td>
									  <td><?php echo  $user_home->dencrypted($name); ?></td>
									 <td><?php echo  $catname['cat_name'] ?></td>
									  <td><?php echo $subcatname=$user_home->get_subcategory($row['subcat_id']); ?></td>
									  <td><?php echo $des; ?></td>
									  <td><?php 	$filename=$row['file_name'];
												if((strpos($filename, '.') !== false)) {  ?> 
												 <a  href="display3.php?id=<?php echo $row['id']; ?>&account=<?php echo $account;?>" title="View Image"><?php echo "$ " . $row['amount']; ?></a>
												 <?php } else { echo "$ " . $row['amount'];}?>
												 
									  </td>
									</tr>
									<?php $i++; }  ?>
								  </tbody>
								</table>
							  </div>
							</div>
						</div>
						<div class="tab-pane" id="activity">
							<div class="box box-warning">
							  <div class="box-body">
								<form class="form-horizontal"  method = "POST" action ="">
									<table id="example3" class="table table-bordered">
								  <thead>
									<tr>
									  <th>S.No</th>
									  <th>Date</th>
					                  <th>Account</th>
									  <th>Category</th>
									  <th>Sub-Category</th>
									  <th>Description</th>
									  <th>Income Amount</th>
									</tr>  
								  </thead>
								  <tbody>
									 <?php 
									 
										$i = 1;
									    $sql = "SELECT * FROM `income` WHERE `account_id` = '$account' ORDER BY `income_id` DESC" ;
										$stmt = $user_home->runQuery($sql);
										$stmt->execute();
										while($row1= $stmt->fetch(PDO::FETCH_ASSOC)){
										$catname=$user_home->get_category($row1['cat_id']);
										$des= substr($row1['description'], 0, 10);
									?>
									<tr>
									  <td ><?php echo $i; ?></td>
									  <td ><?php echo $row1['tr_date']; ?></td>
									  <td ><?php echo $accname=$user_home->get_account($row1['account_id']); ?></td>
									  <td ><?php echo $catname['cat_name']  ?></td>
									  <td ><?php echo $catname=$user_home->get_subcategory( $row1['subcat_id']); ?></td>
									  <td ><?php echo $des; ?></td>
									  <td ><?php echo $row1['income_amount']; ?></td>
									</tr>
									<?php $i++; }  ?>
								  </tbody>
								</table>
							  </form>
							  </div>
							</div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
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
