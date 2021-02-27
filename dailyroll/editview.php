<?php 
session_start();
require_once 'class.user.php';
$user_home = new USER();
include "menu.php" ;
$unid=$_SESSION['unique_ID'];
$id=$_SESSION['userSession'];
$usertype=$user_home->getusertype($id);

if(isset($_GET['expenses'])){
 $income=$_GET['expenses'];
}

function getDatePath(){
	//Year in YYYY format.
	$year = date("Y");
	 
	//Month in mm format, with leading zeros.
	 $month = date("m");
	 
	//Day in dd format, with leading zeros.
	 $day = date("d");
	 
	//The folder path for our file should be YYYY/MM/DD
	$directory = "$year/$month/$day/";
	return $directory;
}
if(isset($_POST['update'])){
	$expenseid=$_GET['expenses'];
	$account=$_POST['account1'];
	$date=$_POST['date'];
	$subcat=$_POST['subcat1'];
	$category=$_POST['category1'];
	$description=$_POST['description'];
	$amount=$_POST['amount'];
	$basefile = basename($_FILES["fileToUpload"]["name"]);
	if($basefile !=''){
		if(isset($_FILES["fileToUpload"])){
			  $dir = DIR_UPLOAD;
		   // $upload_path = $dir.$unid;
			$datedir=getDatePath();
			  $file_path  = DIR_UPLOAD."".$unid."/".$datedir;
		
		if(!is_dir($file_path)){
			//echo"Create our directoryeach";
			mkdir($file_path, 0777, true);
		}
	$allowedExts = array("jpg", "jpeg", "gif", "png","JPG");
	$extension = @end(explode(".", $_FILES["fileToUpload"]["name"]));	
    //Filter the file types , if you want.
    if ((($_FILES["fileToUpload"]["type"] == "image/gif")
        ||($_FILES["fileToUpload"]["type"] == "image/GIF")
	    || ($_FILES["fileToUpload"]["type"] == "image/JPEG")
	    || ($_FILES["fileToUpload"]["type"] == "image/jpeg")
	    || ($_FILES["fileToUpload"]["type"] == "image/JPG")
	    || ($_FILES["fileToUpload"]["type"] == "image/jpg")
	    || ($_FILES["fileToUpload"]["type"] == "image/JFIF")
	    || ($_FILES["fileToUpload"]["type"] == "image/jfif")
	    || ($_FILES["fileToUpload"]["type"] == "image/png")
	    || ($_FILES["fileToUpload"]["type"] == "image/TIFF")
	    || ($_FILES["fileToUpload"]["type"] == "image/tiff")
	    || ($_FILES["fileToUpload"]["type"] == "image/PNG")
	    || ($_FILES["fileToUpload"]["type"] == "image/pjpeg"))
	    && ($_FILES["fileToUpload"]["size"] < 104800000)
	    && in_array($extension, $allowedExts)) 
    {
		if($_FILES["fileToUpload"]["error"] > 0)
		{
		    echo "Return Code: " . $_FILES["fileToUpload"]["error"] . "<br>";
		}	
		else
		{	
			   $filepath = $file_path."".$basefile;
			//echo $pic;
		    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$filepath)){
		    //$pics=$output_dir.$id.".".$ext;
		    //$url=$id.".".$ext;
			 $sql="UPDATE `expenses` SET `account_id`='$account',`amount`='$amount',`file_name`='$filepath',`description`='$description',`subcat_id`='$subcat',`cat_id`='$category',`tr_date`= '$date' WHERE `id`='$expenseid'";

				$stmt = $user_home->runQuery($sql);
				$stmt->execute();
				$user_home->redirect("myexpenses.php");
				$msg = '<div class="alert alert-success alert-dismissible">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  <h4><i class="icon fa fa-check"></i> Success!</h4>
					  Expenses Updated Successfully updated.
				    </div>';
			}
		}
					    
	}	
	else
	{
		$msg = '<div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                Warning alert preview.  Please check the image fomat or Size.
              </div>';
	}
	
 }
    }
	else{
	 $sql="UPDATE `expenses` SET `account_id`='$account',`amount`='$amount',`description`='$description',`subcat_id`='$subcat',`cat_id`='$category',`tr_date`='$date' WHERE `id`='$expenseid'";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$user_home->redirect("myexpenses.php");
	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> </h4>
                Your expenses inserted successfully.
              </div>';
	}

}
	
						 
?>
<html>
<head>
</head>
<body>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content container-fluid">
	<?php echo $msg ;?>

	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			  <h4 class="modal-title">Details</h4>
		  </div>
		  <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data" >
			<?php $sql = "SELECT * FROM `expenses` WHERE `id` = '$income'";
				  $stmt3 = $user_home->runQuery($sql);
				  $stmt3->execute();
				  $result =$stmt3->fetch(PDO::FETCH_ASSOC);
				//  print_r($result);
			?>
			<div class="modal-body">
			  <div class="row">
				<label for="name" class="col-sm-3 control-label">Date</label>
				<div class="col-sm-7"> 
				  <input type="date" class="form-control" placeholder="Date" value="<?php  echo $result['tr_date'];?>" name="date"  ></input>
				</div>
			  </div>
			  </br>
			  <div class="row">
				<label for="name" class="col-sm-3 control-label">Account</label>
				 <div class="col-sm-7"> 
				  <select align="center"   name ="account1"  id="account1"  required  onChange="getcountry1(this.value)"  class="form-control">
					<?php  
					  $sql1="SELECT * FROM  groups  WHERE  `account_status`='active' and   `added_user_id`='$id'group by account_id ";
					  $stmt1 = $user_home->runQuery($sql1);
					  $stmt1->execute();
					  while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
					?>
					<option value='<?php echo $row1['account_id']?>' <?php if($row1['account_id']==$result['account_id']) echo selected?>> <?php echo $accountname=$user_home->get_account($row1['account_id']); ?></option>
					 <?php   } ?>
				  </select>
				 </div>
			  </div>
			  </br>	
			  <div class="row">
			    <label for="name" class="col-sm-3 control-label">Category</label>
				<div class="col-sm-7"> 
				<?php $accountid = $result['account_id'];
							?>
				<select align="center" name ="category1" id="state-list1"  onChange="getstate1(this.value)" class="form-control">
				<?php

				  $sql1="SELECT * FROM  category  where account_id='$accountid'";
				  $stmt1 = $user_home->runQuery($sql1);
				  $stmt1->execute();
				  while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
				?>
				<option value='<?php echo $row1['cat_id']?>' <?php if($row1['cat_id']==$result['cat_id']) echo "selected"; ?>> <?php echo $row1['cat_name']; ?></option>
				 <?php } ?>
								 </select>
								  </div>
								</div>	
								</br>	
								<div class="row">
								  <label for="name" class="col-sm-3 control-label">Sub-Category</label>
								  <div class="col-sm-7"> 
								   <select align="center" name ="subcat1" id="city-list1" class="form-control">
								      <?php  
									  $cat_id=$result['cat_id'];
										 $sql1="SELECT * FROM  sub_category WHERE cat_id='$cat_id'";
										$stmt1 = $user_home->runQuery($sql1);
										 $stmt1->execute();
										 while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){ 
										 ?>
										  <option value='<?php echo $row1['subcat_id']?>' <?php if($row1['subcat_id']==$result['subcat_id']) echo "selected"; ?>> <?php echo $row1['subcat_name']; ?></option>
										 <?php } ?>
								   </select>
								  </div>
								</div>
								</br>	
							
								<div class="row">
								  <label for="name" class="col-sm-3 control-label">Description</label>
								  <div class="col-sm-7"> 
									<input type="text" class="form-control" placeholder="Description"  value="<?php echo $result['description'] ?>" name="description" ></input>
								  </div>
								</div>
								</br>
								<div class="row">
								  <label for="name" class="col-sm-3 control-label">Amount</label>
								  <div class="col-sm-7"> 
									<input type="number"  step = "0.01" min = "0" max = "1000000000000"  class="form-control"placeholder="Amount" value="<?php echo $result['amount']?>" name="amount" ></input>
								  </div>
								</div>
								</br>
								<div class="row">
								  <label for="name" class="col-sm-3 control-label">New Attachment</label>
								  <div class="col-sm-7"> 
									<input type="file" placeholder="fileToUpload"  id="fileToUpload" name="fileToUpload"  ></input>
								  </div>
								</div>
								</br>
									 
							</div>
										
						    <div class="modal-footer">
							  <a  href="myexpenses.php"class="btn btn-default pull-left">Close</a>
							  <button type="submit" class="btn btn-primary" name = "update">Update</button>
							 
						</div>
							</form>
						  </div>
					    </div>
					 
		
          </div>
          <!-- /.box -->
	 </div>
	 <?php  include 'footer.php';?>
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