<?php 
session_start();
require_once 'class.user.php';
$user_home = new USER();

$unid=$_SESSION['unique_ID'];
$id=$_SESSION['userSession'];
$usertype=$user_home->getusertype($id);

 if(isset($_GET['income'])){
 $income=$_GET['income'];

}
	
if(isset($_POST['incomeupdate'])){
	 $expenseid=$_GET['income'];
	$date=$_POST['date'];
	$account=$_POST['account1'];
	$category=$_POST['category1'];
	$subcategory=$_POST['subcat1'];
	$description=$_POST['description'];
	$amount=$_POST['amount'];
	$status=$_POST['status'];
	$sql="UPDATE `income` SET `account_id`='$account',`income_amount`='$amount',`subcat_id`='$subcategory',`cat_id`='$category',`description`='$description',`tr_date`='$date' WHERE `income_id`='$expenseid'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> </h4>
               Income Updated successfully.
              </div>';
	
	}
if(isset($_POST['delete'])){

$sql="Delete FROM `income` WHERE `income_id`='$income'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> </h4>
                Your Income Delted successfully.
              </div>';
	

}



							 
?>
<html>
<head>
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

</head>
<body>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content container-fluid">
	<?php echo $msg ;?><?php
			 $income=$_GET['income'];
			$sql = "SELECT * FROM `income` WHERE `income_id` = '$income'";
	$stmt3 = $user_home->runQuery($sql);
	$stmt3->execute();
	//echo $sql;
	$result =$stmt3->fetch(PDO::FETCH_ASSOC);
	
			
			?>
			   <div class="modal-dialog">
						  <div class="modal-content">
						    <div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							    <span aria-hidden="true">&times;</span></button>
							  <h4 class="modal-title">Details</h4>
						    </div>
							<form class="form-horizontal" action="" method="POST"  >

						    <div class="modal-body">
								<div class="row">
								  <label for="name" class="col-sm-3 control-label">Date</label>
								  <div class="col-sm-7"> 
									<input type="date" class="form-control" placeholder="Date" value="<?php echo $result['tr_date']?>" name="date"  ></input>
								  </div>
								</div>
								</br>
								<div class="row">
								  <label for="name" class="col-sm-3 control-label">Account</label>
								  <div class="col-sm-7"> 
								    <select align="center"   name ="account1"  id="account1" onChange="getcountry1(this.value)"  class="form-control">
										 <?php  
										 $sql1="SELECT * FROM  groups  WHERE  `account_status`='active' and   `added_user_id`='$id'group by account_id ";
										$stmt1 = $user_home->runQuery($sql1);
										 $stmt1->execute();
										 while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
										 ?>
										  <option value='<?php echo $row1['account_id']?>' <?php if($row1['account_id']==$result['account_id']) echo selected?>> <?php echo $accountname=$user_home->get_account($row1['account_id']); ?></option>
										 <?php } ?>
								    </select>
								  </div>
								</div>
								</br>	
								<div class="row">
								  <label for="name" class="col-sm-3 control-label">Category</label>
								  <div class="col-sm-7"> 
								  <select align="center" name ="category1" id="state-list1"  onChange="getstate1(this.value)"   class="form-control">
								  <?php  
										 $sql1="SELECT * FROM  category";
										$stmt1 = $user_home->runQuery($sql1);
										 $stmt1->execute();
										 while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
										 ?>
										  <option value='<?php echo $row1['cd_id']?>' <?php if($row1['cat_id']==$result['cat_id']) echo selected ?>> <?php echo $row1['cat_name']; ?></option>
										 <?php } ?>
								 </select>
								  </div>
								</div>	
								</br>	
								<div class="row">
								  <label for="name" class="col-sm-3 control-label">Sub-Category</label>
								  <div class="col-sm-7"> 
								   <select align="center" name ="subcat1" id="city-list1"  class="form-control">
								      <?php  
										 $sql1="SELECT * FROM  sub_category";
										$stmt1 = $user_home->runQuery($sql1);
										 $stmt1->execute();
										 while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
										 ?>
										  <option value='<?php echo $row1['subcat_id']?>' <?php if($row1['subcat_id']==$result['subcat_id']) echo selected ?>> <?php echo $row1['subcat_name']; ?></option>
										 <?php } ?>
								   </select>
								  </div>
								</div>
								</br>	
					
								<div class="row">
								  <label for="name" class="col-sm-3 control-label">Description</label>
								  <div class="col-sm-7"> 
									<input type="text" class="form-control" placeholder="Description" value="<?php  echo $result['description']?>" name="description" ></input>
								  </div>
								</div>
								</br>
								<div class="row">
								  <label for="name" class="col-sm-3 control-label">Amount</label>
								  <div class="col-sm-7"> 
									<input type="Number" class="form-control"placeholder="Amount" value=<?php echo $result['income_amount'] ?> name="amount" ></input>
								  </div>
								</div>
								</br>
										<div class="row">
								  <label for="name" class="col-sm-3 control-label">Status</label>
								  <div class="col-sm-7"> 
								   <select align="center" name ="status" id="city-list1"  class="form-control">
								     
										  <option value='non-pending' <?php if('non-pending'==$result['pendingflag']) echo selected ?>> Non-Pending</option>
										  <option value='pending' <?php if('pending'==$result['pendingflag']) echo selected ?>> Pending</option>
										 
								   </select>
								  </div>
								</div> 
								<br>	 
							</div>
										
						    <div class="modal-footer">
							  <a href="m_expenses.php" class="btn btn-default pull-left">Close</a>
							  <button type="submit" class="btn btn-primary" name = "incomeupdate">Update</button>
							  <button type="submit" class="btn btn-Danger" name = "delete">Delete</button>
							  	</div>
							</form>
						  </div>
					    </div>

			
				
				
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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
function getcountry(val) {
	$.ajax({
	type: "POST",
	url: "get_dropdown.php?q=0",
	data:'CountryID='+val,
	success: function(data){
		$("#state-list").html(data);
	}
	});
}
function getcountry1(val) {
	$.ajax({
	type: "POST",
	url: "get_dropdown.php?q=0",
	data:'CountryID='+val,
	success: function(data){
		$("#state-list1").html(data);
	}
	});
}
function getstate(val) {
	$.ajax({
	type: "POST",
	url: "get_dropdown.php?q=1",
	data:'state='+val,
	success: function(data){
		
		$("#city-list").html(data);
	}
	});
}
function getstate1(val) {
	$.ajax({
	type: "POST",
	url: "get_dropdown.php?q=1",
	data:'state='+val,
	success: function(data){
		
		$("#city-list1").html(data);
	}
	});
}
function gethospital(val) {
	$.ajax({
	type: "POST",
	url: "get_dropdown.php?q=3",
	data:'hospitalID='+val,
	success: function(data){
		
		$("#doctors-list").html(data);
	}
	});
}
function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}

</script>
</body>
</html>