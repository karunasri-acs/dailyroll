<?php
//echo "fsdgfhfgjghfgkjjkghffhfsdesagdseteryrtury";
session_start();
require_once 'class.user.php';
require_once '../constants/constants.php';
//require_once (".htacess");
$user_home = new USER();
require_once '../class.logger.php';
$log = new LOGGER(basename(__FILE__),__DIR__);
//$log->$log->event_log('root file beginning ','d'); 
$id = $_SESSION['userSession'];
$captureid = $_SESSION['unique_ID'];
//$month=MONTH_DATE;
$usertype=$_SESSION['usertype'];
	
  
if(isset($_GET['uid'])){
	 $email = $_GET['uid'];
	 $log->event_log($email,'d');

	if($user_home->uidlogin($email)){
		//echo"hii";
		//$log->event_log("user loggined");
				$check = $user_home->checkForSubscribe($_SESSION['userSession']);
	$result = $check['result'];
	if($result == "FALSE"){
	$_SESSION['usertype']='expireduser';
	$log->event_log('expireduser','d');
	$user_home->redirect('accounttree.php');
		
	}elseif($result == "TRUE"){
	$_SESSION['usertype']='validuser';
		$log->event_log('validuser','d');
		$user_home->redirect('accounttree.php');
		exit;
		$log->event_log('after redirect','d');
	} 
		  
	}
}

?>

<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
ul, #myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}


.caret {
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.caret-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */'
  transform: rotate(90deg);  
}

.nested {
  display: none;
}

.nested {
  display: none;
}

.active {
  display: block;
}
.date {
      float:right;
      }  
</style>

</head>
<body>



<ul >
	<?php 
		$sql="SELECT * FROM  groups  WHERE  `added_user_id`='$id' group by account_id";
		$log->event_log($sql,'d');
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		while($row1 = $stmt->fetch(PDO::FETCH_ASSOC)){ 
			$acid=$row1['account_id'];
			$row=$user_home->get_accountdetails($row1['account_id']);
			$excount=$user_home->getexpensecount($row1['account_id']);
			$incount=$user_home->getincomecount($row1['account_id']);
		
	?>

	  <li ><span class="caret"><?php echo $row['accountname']; ?>
		  <span class="w3-badge w3-blue"><?php echo $excount?></span>
		  <span class="date">
				<a href=""  data-toggle="modal" data-target="#info" title="Contact Info"> <i class="fa  fa-info-circle"aria-hidden="true" style="font-size:15px;color :green"></i></a>
				<a href=""  data-toggle="modal" data-target="#contact"  title="Add Contact"> <i class="fa fa-phone"aria-hidden="true" style="font-size:15px;"></i></a>
				<a href=""  data-toggle="modal" data-target="#edit"  title="Edit"> <i class="fa  fa-edit"aria-hidden="true" style="font-size:15px;color :green"></i></a>
				<a href=""  data-toggle="modal" data-target="#modalinactive"  title="Inactive"> <i class="fa  fa-check" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
				<a href=""  data-toggle="modal" data-target="#modalactive" (click)="editMember(node)" title="Active"> <i class="fa  fa-ban" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
		   </span>
		</span>
		<ul class="nested">
			<?php if($excount > 0){ ?>
				<li> <span class="caret">Expenses</span>
				    <ul class="nested">
						<?php 
							$sql2="SELECT * FROM `category` WHERE `account_id`='$acid' and `cat_type`='expenses'";
							$stmt2 = $user_home->runQuery($sql2);
							$stmt2->execute();
							$rowcount=$stmt2->rowcount();
							while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
							$caid=$row2['cat_id'];
						?>
							<li> 
							
							
												<span class="caret" ><?php echo  $row2['cat_name']; ?></span>
												
												<span class="date" >
													<a href=""  data-toggle="modal" data-target="#modal-default"  title="Add Contact"> <i class="fa fa-phone"aria-hidden="true" style="font-size:15px;"></i></a>
													<a href=""  data-toggle="modal" data-target="#edit"  title="Edit"> <i class="fa  fa-edit"aria-hidden="true" style="font-size:15px;color :green"></i></a>
													<a href=""  data-toggle="modal" data-target="#modalinactive"  title="Inactive"> <i class="fa  fa-check" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
													<a href=""  data-toggle="modal" data-target="#modalactive" (click)="editMember(node)" title="Active"> <i class="fa  fa-ban" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
											   </span>
										    
								<ul class="nested">
									<?php 
										$sql3="SELECT * FROM `sub_category` WHERE `cat_id`='$caid'";
										$stmt3 = $user_home->runQuery($sql3);
										$stmt3->execute();
										//$rowcount=$stmt2->rowcount();
										while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){ 
									?>
										<li>
										  <ul>
											<li>
												<span ><?php echo  $row3['subcat_name']; ?></span>
												<span ><?php echo  $row3['amount']; ?></span>
												<span class="date" >
													<a href=""  data-toggle="modal" data-target="#info" title="Contact Info"> <i class="fa  fa-info-circle"aria-hidden="true" style="font-size:15px;color :green"></i></a>
													<a href=""  data-toggle="modal" data-target="#contact"  title="Add Contact"> <i class="fa fa-phone"aria-hidden="true" style="font-size:15px;"></i></a>
													<a href=""  data-toggle="modal" data-target="#edit"  title="Edit"> <i class="fa  fa-edit"aria-hidden="true" style="font-size:15px;color :green"></i></a>
													<a href=""  data-toggle="modal" data-target="#modalinactive"  title="Inactive"> <i class="fa  fa-check" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
													<a href=""  data-toggle="modal" data-target="#modalactive" (click)="editMember(node)" title="Active"> <i class="fa  fa-ban" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
											   </span>
										    </li>
										  </ul>
										</li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
				    </ul>
				</li>
			<?php } else{  ?>
			    <li> Expenses</li>
			<?php  }  ?>
			<?php if($incount >0){ ?>
				<li> <span class="caret">Income</span>
					  <ul class="nested">
						<?php 
							$sql2="SELECT * FROM `category` WHERE `account_id`='$acid' and `cat_type`='income'";
							$stmt2 = $user_home->runQuery($sql2);
							$stmt2->execute();
							$rowcount=$stmt2->rowcount();
							while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
							$caid=$row2['cat_id'];
						?>
							<li> 
							
							
												<span class="caret" ><?php echo  $row2['cat_name']; ?></span>
												
												<span class="date" >
													<a href=""  href="viewcontact.php?uid=<?php echo $row2['ct_id']?>"title="Contact Info"> <i class="fa  fa-info-circle"aria-hidden="true" style="font-size:15px;color :green"></i></a>
													<a href=""  data-toggle="modal" data-target="#contact"  title="Add Contact"> <i class="fa fa-phone"aria-hidden="true" style="font-size:15px;"></i></a>
													<a href=""  data-toggle="modal" data-target="#edit"  title="Edit"> <i class="fa  fa-edit"aria-hidden="true" style="font-size:15px;color :green"></i></a>
													<a href=""  data-toggle="modal" data-target="#modalinactive"  title="Inactive"> <i class="fa  fa-check" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
													<a href=""  data-toggle="modal" data-target="#modalactive" (click)="editMember(node)" title="Active"> <i class="fa  fa-ban" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
											   </span>
										    
								<ul class="nested">
									<?php 
										$sql3="SELECT * FROM `sub_category` WHERE `cat_id`='$caid'";
										$stmt3 = $user_home->runQuery($sql3);
										$stmt3->execute();
										//$rowcount=$stmt2->rowcount();
										while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){ 
									?>
										<li>
										  <ul>
											<li>
												<span ><?php echo  $row3['subcat_name']; ?></span>
												<span ><?php echo  $row3['amount']; ?></span>
												<span class="date" >
													<a href=""  data-toggle="modal" data-target="#info" title="Contact Info"> <i class="fa  fa-info-circle"aria-hidden="true" style="font-size:15px;color :green"></i></a>
													<a href=""  data-toggle="modal" data-target="#contact"  title="Add Contact"> <i class="fa fa-phone"aria-hidden="true" style="font-size:15px;"></i></a>
													<a href=""  data-toggle="modal" data-target="#edit"  title="Edit"> <i class="fa  fa-edit"aria-hidden="true" style="font-size:15px;color :green"></i></a>
													<a href=""  data-toggle="modal" data-target="#modalinactive"  title="Inactive"> <i class="fa  fa-check" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
													<a href=""  data-toggle="modal" data-target="#modalactive" (click)="editMember(node)" title="Active"> <i class="fa  fa-ban" aria-hidden="true" style="font-size:15px;color:   #D11027;"></i></a>
											   </span>
										    </li>
										  </ul>
										</li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
				    </ul>
				
				</li>
			  
			<?php } else{  ?>
			   <li> Income</li>
			<?php  } ?>
			  
		</ul>
	  </li>
	

   <?php }?>
</ul>

  <script>
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}
</script>

</html>
