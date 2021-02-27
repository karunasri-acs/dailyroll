

<?php 
if(isset($_GET['uid'])){
$unid=$_GET['uid'];


}
session_start();
require_once 'class.user.php';
$user_home = new USER();
$_SESSION['unique_ID']=$unid;
$id=$user_home->get_email($unid);

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
if(isset($_POST['add'])){

$i=1;
$entriescount=$_POST['entriescount'];
if($entriescount > 0 ){
while($i < $entriescount){
$account=$_POST['accounts'];
$date=$_POST['date'.$i];
$cat=$_POST['cat'.$i];
$subcat=$_POST['subcat'.$i];
$desc=$_POST['desc'.$i];
$amount=$_POST['amount'.$i];
$status=$_POST['status'.$i];
if($date !='' && $cat !='' &&$subcat !=''&& $amount !=''){

try{
    $sql="INSERT INTO `income`( `capture_id`, `account_id`, `income_amount`, `subcat_id`,`cat_id`,`description`,`tr_date`,`pendingflag`)  
									VALUES ('$unid','$account','$amount','$subcat','$cat','$desc','$date','$status')";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	
	$msg = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Income Added Successfully 
              </div>';
}
			  catch(PDOException $ex)
					{
						//echo $ex->getMessage();
					}

}
else{
$msg = '<div class="success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               
			Please Select All data.
			   </div>';
}



$i++;
}

}else{

	$msg = "<div class='error'>
				Please enter data to add Income
			</div>";
}
}
							 
?>
<html lang="en" >

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body {
	max-width: 1050px;
    font-family: Arial;
}

#frmContact1 {
	border: #49615d 4px solid;
    background: white;
	padding: 10px;


}

#frmContact1 div {
	margin-bottom: 20px;
}

#frmContact1 div label {
	margin: 5px 0px 0px 5px;    
	color: #49615d;
}

.demoInputBox {
	padding: 10px;
	border: #a5d2ca 1px solid;
	border-radius: 2px;
	background-color: white;
	width: 90%;
    margin-top:5px;
}
.form-control {
	padding: 7px;
	border: #a5d2ca 1px solid;
	border-radius: 4px;
	background-color: white;
	width: 90%;
    margin-top:5px;
}
.error {
	background-color: #FF6600;
    padding: 8px 10px;
    color: #FFFFFF;
    border-radius: 4px;
    font-size: 0.9em;
}

.success {
	background-color: #c3c791;
	padding: 8px 10px;
	color: #FFFFFF;
	border-radius: 4px;
    font-size: 0.9em;
}

.info {
	font-size: .8em;
	color: #FF6600;
	letter-spacing: 2px;
	padding-left: 5px;
}

.btnAction {
	background-color: #82a9a2;
    padding: 10px 40px;
    color: #FFF;
    border: #739690 1px solid;
	border-radius: 4px;
	cursor: -webkit-grab; cursor: grab;
}

.btnAction:focus {
	outline:none;
}
.column-right
{
    margin-right: 12px;
}
.contact-row
{
    display: inline-block;
    width: 32%;
}
@media all and (max-width: 550px) {
    .contact-row {
        display: block;
        width: 100%;
    }
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
 <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
</head>
<body>
<?php echo $msg;?>
<div class="container">
<div class="row">
    <form action="" method="post" >
        <div id="mail-status"></div>
        
        <div class="contact-row column-right">
            <label>Account</label> <span id="userEmail-info" class="info"></span><br />
       	<select align="center" name ="accountid" id ="accountid"  onchange="this.form.submit()"   class="demoInputBox"  >
		
									<?php
							
										$sql="SELECT * FROM `groups` WHERE `account_status`='active' and `added_user_id`='$id' and userstatus='active' and group_status='Y' and `usertype` ='writeonly'  group by `account_id` ";
										$stmt = $user_home->runQuery($sql);
										$stmt->execute();
										echo "<option value='' >Select Account</option>";
										while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
										$course = $user_home->get_accountdetails($row['account_id']);
										$accountname = $course['accountname'];
									?>
									
									<option value=  <?php echo $row['account_id'];?>  <?php if($_POST['accountid'] == $row['account_id']) echo selected?> > <?php  echo$accountname ?>  </option>
									<?php } ?>		
								  </select>
        </div>
		<div class="contact-row column-center">
            <label>Date</label> <span id="userEmail-info" class="info"></span><br />
            <input type="date" name="date"   onchange="this.form.submit()" id="email"
                class="demoInputBox" value="<?php echo $_POST['date']?>" >
        </div>
        <div class="contact-row">
            <label>Entries</label> <span id="subject-info" class="info"></span><br />
           <input type="number" name="entries" placeholder="Enter No Of Entries" onchange="this.form.submit()"  class="demoInputBox" value="<?php echo $_POST['entries']?>" >
								
        </div>
    
      
    </form>
	  <?php if($_POST['entries'] !=''){ ?>	
			<form action="" method="POST" enctype="multipart/form-data"   >
				  <table  id="examples" >
						<thead>
						<tr>
							
							<th>Date  </th>
							<th>Category</th>
							<th>Sub-Category</th>
							<th>Description</th>
							<th>Amount</th>
							<th>Status</th>
							
						 </tr>
						</thead>
						
						 <?php 
							$i = 1;
							$date=$_POST['date'];
							$account=$_POST['accountid'];
							$entries=$_POST['entries'];
							$finalentries=$entries+1;
							$sql="SELECT * FROM `accounts` WHERE `account_id`='$account'";
							$stmt = $user_home->runQuery($sql);
							$stmt->execute();
							$row = $stmt->fetch(PDO::FETCH_ASSOC);
							$accountname=$row['accountname'];
							while($i<$finalentries){
							
							
							?>
						<tr>
							
								<td> <input type="date"  name="date<?php echo $i?>"  class="form-control"    placeholder="Marks Obtained"  value="<?php echo $date?>" ></td>
								<td>
									<select class="form-control"    onChange="getsubcat<?php echo $i?>(this.value)"  name ="cat<?php echo $i; ?>">
										<option value = ''>Please Select Category</option>
										 <?php 

											 $sql1="SELECT * FROM `category` WHERE account_id = '$account'   and `cat_type`='income'  AND `status`='active'";
											$results = $user_home->runQuerydrop($sql1);
											foreach($results as $row) {
										  ?>
										   <option value='<?php echo $row['cat_id']?>'> <?php echo $row["cat_name"]; ?></option>
										 <?php } ?>	
									</select>
								</td>
								<td>  
									<select align="center"  class="form-control"  name ="subcat<?php echo $i; ?>" onChange="getamount<?php echo $i; ?>(this.value)" id="subcat-list<?php echo $i; ?>"   class="form-control">
									<option value="">Select Sub-Category</option>
								   
									 </select>
								</td>
							 
								<td><input type="text"  class="form-control"   name="desc<?php echo $i?>"  placeholder="Enter Description"  ></td>
								<td><input type="Number"  class="form-control" id="amountdata<?php echo $i ?>" name="amount<?php echo $i?>"  placeholder="Enter Amount"  ></td>
								 <td>  
									<select align="center" name ="status<?php echo $i; ?>"      class="form-control"  >
										<option value=  "non-pending" > Non-Pending </option>
										<option value= "pending" >Pending </option>
									</select>
								</td>
								</tr>
						<script >
		jQuery.support.cors = true;
		function getsubcat<?php echo $i ?>(val) {
	
			$.ajax({
			cache: false,	
			type: "POST",
			url: "get_dropdown.php?q=1",
			//cache: false,
			 dataType : 'text',
			data:'CategoryId='+val,
		
			success: function(data){
			
				$("#subcat-list<?php echo $i ?>").html(data);
			}
			});
		}
		function getamount<?php echo $i ?>(val) {
		
							$.ajax({
								cache: false,
								type: "POST",
								url: "get_dropdown.php?q=3",
								data: {member_id : val},
								dataType: 'json',
								success:function(response) {
								
									$("#amountdata<?php echo $i ?>").val(response.amount);
								}
							});
						}
	</script>

						<?php $i++;}?>
						
						  
					   
					  </table>
					   <div class="row" style="margin-left:200px;margin-right:200px">
				<div class="col-lg-4 text-center">
				<input type="hidden" name="entriescount" value="<?php echo $finalentries;?>">
				<input type="hidden" name="accounts" value="<?php echo $account;?>">
				  <button type="submit" name = "add" class="btnAction"  >Add Income</button>
				</div>
				<div class="col-lg-6 text-center"></div>
			  </div>	 
					
					</form>		 
		 <?php }?>
    
</body>

</html>
