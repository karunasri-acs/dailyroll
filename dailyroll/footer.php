<?php
require_once 'constants/constants.php';
				$projectname = PROJECTNAME;
				$url = 'https://support.jwtechinc.com/ws_an_footer.php?pn='.$projectname;
				$data = file_get_contents($url);
				$jsondata =json_decode($data, true);;
				//print_r($jsondata);
				$version=$jsondata[0]['version'];
				$year=$jsondata[0]['present'];
				$year1=$jsondata[0]['futureyear'];
?>

			<footer id="footer-4" class="p-top-50 footer division">
				<div class="container">

						<p><a href="index.php"></a>Copyright&copy;(<?php echo $year."-".$year1 ?> ) DAILYROLL, All Rights Reserved &nbsp <a href="privacy.html" class="foo-1-link">Privacy Policy</a>
							&nbsp <a href="termsandconditions.html" class="foo-1-link">Terms of Service</a>
							&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <a  >Version :<?php echo $version?> </a>
							
							<br>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
							This product is owned by <a href="https://jwtechinc.com">Jayson & Williams Technologies, INC </a> 
						</p>
					
				</div>	   <!-- End container -->										
			</footer>