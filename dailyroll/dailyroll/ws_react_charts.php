<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

//$month=MONTH_DATE;
require_once '../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->event_log('root file beginning ','d'); 
 if(isset($_GET['uid'])){
	 if($_GET['uid'] !=''){
	 $email = $_GET['uid'];
	 event_log($email);
	$userdetails=$user_home->uidlogin($email);
	$id = $userdetails['user_id'];
	$unid = $userdetails['unique_id'];
	$check = $user_home->checkForSubscribe($id);
	$result = $check['result'];
	if($result == "FALSE"){
		$_SESSION['usertype']='expireduser';
		event_log('expireduser');
	//$user_home->redirect('ws_react_charts.php');
		
	}elseif($result == "TRUE"){
		$_SESSION['usertype']='validuser';
		event_log('validuser');
		
	} 
		  
	$id = $userdetails['user_id'];
	$unid = $userdetails['unique_id'];
	 }
}

	$sql="SELECT * FROM `groups` WHERE `account_status`='active' and `added_user_id`='$id' group by `account_id` ORDER by `group_user_id` DESC ";
	$stmt = $user_home->runQuery($sql);
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	$accid=$row['account_id'];
	$user_home->createjson($accid);
	$details=$user_home->get_accountdetails($accid);
	$currency=$details['currcode'];
	$currsymbol=$user_home->getCurrency_symbol($currency);
	
	$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE `account_id`='$accid'" ;
	$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  `account_id`='$accid'";
	$sql1="select subcat_id,SUM(amount) as number from `expenses` where account_id ='$accid'";
	if(isset($_POST['accountname']) OR isset($_POST['rptype'])){
	$accid=$_POST['accountname'];
	
	$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE `account_id`='$accid'" ;
	$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  `account_id`='$accid'";
	$sql1="SELECT subcat_id,SUM(amount) as number FROM `expenses` WHERE `account_id` ='$accid'";
	$details=$user_home->get_accountdetails($accid);
	$currency=$details['currcode'];
	$currsymbol=$user_home->getCurrency_symbol($currency);
	
	if(isset($_POST['rptype']) AND $_POST['rptype'] != ''){
	$rptype=$_POST['rptype'];
	$presentdate=date("Y-m-d");
if($rptype =='month'){
	$month=date('m');
	$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE MONTH(tr_date)='$month' AND  `account_id`='$accid'" ;
	$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  MONTH(tr_date)='$month' AND  `account_id`='$accid'" ;
	$sql1="SELECT subcat_id,SUM(amount) as number FROM `expenses` WHERE   MONTH(tr_date)='$month' AND  `account_id` ='$accid'";
}
elseif($rptype =='today'){
	$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE  `account_id`='$accid'" ;
	$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  `account_id`='$accid'";
	$sql1="SELECT subcat_id,SUM(amount) as number FROM `expenses` WHERE  `account_id` ='$accid'";
}
elseif($rptype =='year'){
	$year=date('Y');
	$sql = "SELECT SUM(amount) as expenses  FROM `expenses` WHERE year(tr_date)='$year' AND  `account_id`='$accid'" ;
	$sql2 = "SELECT  SUM(income_amount) as income  FROM `income` WHERE  year(tr_date)='$year' AND  `account_id`='$accid'";
	$sql1="SELECT subcat_id,SUM(amount) as number FROM `expenses` WHERE   year(tr_date)='$year' AND  `account_id` ='$accid'";
}
}
$sql1=$sql1."GROUP BY `subcat_id`";
	$stmt1=$user_home->runQuery($sql1);
	$stmt1->execute();
//echo $sql1;
	while($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
	$category_name=$user_home->get_subcategory($row1['subcat_id']);
	$category=$category_name;
	$response['y'] = $row1['number'];
	$response['label'] = $category;
	$responsearray[] = $response;
	}
	$stmt2=$user_home->runQuery($sql);
	$stmt2->execute();
	$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
	$stmt1=$user_home->runQuery($sql2);
	$stmt1->execute();
	$row1=$stmt1->fetch(PDO::FETCH_ASSOC);
	$percentage = $row2['expenses'];
	$percentage1 = $row1['income'];
	$dataPoints = array( 
				  array("label"=>"Expenses", "y"=>$percentage),
				  array("label"=>"Income", "y"=>$percentage1),
					
				 );

}

else{
	$file="../json/".$accid."pie.txt";
	$myfile = fopen($file, "r") or die("Unable to open file!");
	$countrydata= fread($myfile,filesize($file));
	$dataPoints = json_decode(file_get_contents($file), true);
					
					
	$file="../json/".$accid."bar.txt";
	$myfile = fopen($file, "r") or die("Unable to open file!");
	$countrydata= fread($myfile,filesize($file));
	$responsearray = json_decode(file_get_contents($file), true);
	
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
	  
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>	 

<script>

 window.onload = function() {
var chart1 = new CanvasJS.Chart("chartContainer1", {
	theme: "light2",
	animationEnabled: true,
	title: {
		
			},
	data: [{
	legendText: "{label}",
		type: "pie",
		indexLabel: "{y}",
		yValueFormatString: "<?php echo $currsymbol;?>#,##0.00\"\"",
		indexLabelPlacement: "inside",
		indexLabelFontColor: "#36454F",
		indexLabelFontSize: 18,
			showInLegend: true,
		legendText: "{label}",
	
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});

var chart2= new CanvasJS.Chart("chartbarContainer2", {
      width:320,
      data: [
      {
	  yValueFormatString: "<?php echo $currsymbol;?>#,##0.00\"\"",
        dataPoints: <?php echo json_encode($responsearray, JSON_NUMERIC_CHECK); ?>
      }
      ]

      
    });
chart1.render();
   chart2.render();
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
						<?php if($_SESSION['usertype']=='validuser'){ ?>
				<div class="col-md-12">
				  <?php echo $msg;?>
					<div class="box box-warning box-solid">
						<div class="box-header with-border">
						  <h3 class="box-title">reports</h3>
							<div class="box-tools pull-right">
							</div>
						</div>
						<div class="box-body">
						  <form class="form-horizontal"  method = "POST" action ="">
						    <div class="modal-body">
							  <div class="messages" ></div>
								<div class="form-group">
								  <label for="inputEmail3" class="col-sm-2 control-label">Account</label>
									<div class="col-sm-10">
									  <select align="center" name ="accountname" id ="accountid" required onchange="this.form.submit()"  class="form-control"  >
									  
										<?php
											$sql="SELECT * FROM `groups` WHERE `account_status`='active' and `added_user_id`='$id' and group_status='Y' and userstatus='active'  group by `account_id` order by group_user_id desc ";
											$stmt = $user_home->runQuery($sql);
											$stmt->execute();
											while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
											$course = $user_home->get_accountdetails($row['account_id']);
											$accountname = $course['accountname'];
										?>
										
											<option value=  <?php echo $row['account_id'];?>  <?php if($_POST['accountname'] == $row['account_id']) echo selected?> > <?php  echo$accountname ?>  </option>
										<?php } ?>		
								 	  </select>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Selcet Period</label>
									  <div class="col-sm-10">
											<Select class="form-control" required  id="rptype" onchange="this.form.submit()"  name="rptype">
											<option value = 'today'  <?php if($_POST['rptype'] == 'today') echo selected?>>Untill Today</option>
											<option value = 'month' <?php if($_POST['rptype'] == 'month') echo selected?>>Current Month</option>
											<option value = 'year' <?php if($_POST['rptype'] == 'year') echo selected?>>Current Year</option>
										</select>					 
									  </div>
								</div>				  
							  </div>
						 </form>
					    </div>
					</div>
					<section class="col-lg-12 connectedSortable">
						<div class="box-body chart-responsive">
							<div id="chartContainer1"  style="height:300px"></div>
						</div>
					</section>
					</br></br>
					<section class="col-lg-12 connectedSortable">
					<div class="box-body chart-responsive">
							<div id="chartbarContainer2"  style="height:300px" ></div>
						</div>
					</section>
				</div>
			<?php } else if(($_SESSION['usertype']=='expireduser') and ($_GET['uid'] !='') ) {?>
		<p align="center" style="font:25px; color :blue"> Your Subscription is Expired Please Renewal</P>
		
		<?php } else{?>
			<p align="center" style="font:25px; color :blue"> Your Data Missing</P>
			
	<?php	} ?>
			</div>
		  </section>
		</div>
	  <div class="control-sidebar-bg"></div>
	</div>
	
</body>
</html>

