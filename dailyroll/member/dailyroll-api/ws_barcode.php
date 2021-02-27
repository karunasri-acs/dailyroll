<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<?php 
	require_once 'class.user.php';
$user_home = new USER();
//google  code verfication code
//start
require_once 'googleLib/GoogleAuthenticator.php';
$ga = new GoogleAuthenticator();
	if(isset($_GET['email'])){
	$email=$_GET['email'];
	}
	$sql="SELECT * FROM `users` WHERE `email`='$email'";
		$stmt = $user_home->runQuery($sql);
		$stmt->execute();
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		$secret=$userRow['google_auth_code'];			
		$qrCodeUrl = $ga->getQRCodeGoogleUrl($email, $secret,'DailyRoll App');
	
	?>
	
	<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
										</div>
								<div class="modal-body">
								<link rel="stylesheet" type="text/css" href="googleLib/style.css" charset="utf-8" />
								
								<div id='device'>
								</br>
									
									  
									 <div id="musicinfo" align="center">
									 <p>Scan barcode to get code.</p>
										<div id="img">
											<img src='<?php echo $qrCodeUrl; ?>' />
										</div>
									</div>
								
								</div>
								<div style="text-align:center">
									
								</div>

							</div>
						   </div>
						</div>