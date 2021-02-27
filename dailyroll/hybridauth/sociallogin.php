<?php
/**
 * Build a simple HTML page with multiple providers.
 */
session_start();
include 'src/autoload.php';
include 'config.php';

use Hybridauth\Hybridauth;

$hybridauth = new Hybridauth($config);
$adapters = $hybridauth->getConnectedAdapters();

?>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Votersurvey</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</head>
<body>
<div style="margin-left:30%">
 <a href="<?php print $config['callback'] . "?provider=Twitter"; ?>" target="_blank" class="btn btn-info" style="margin-top:28px;font-size:25px">
		<i class="fa fa-twitter"></i> 
	</a>

 <a href="<?php print $config['callback'] . "?provider=Facebook"; ?>" target="_blank"  class="btn btn-primary" style="margin-top:28px;font-size:25px">
		<i class="fa fa-facebook"></i> 
	</a>

 <a href="<?php print $config['callback'] . "?provider=Google"; ?>" target="_blank" class="btn btn-danger" style="margin-top:28px;font-size:25px">
		<i class="fa fa-google"></i> 
	</a>

 <a href="<?php print $config['callback'] . "?provider=LinkedIn"; ?>" target="_blank" class="btn btn-primary" style="margin-top:28px;font-size:25px">
		<i class="fa fa-linkedin"></i> 
	</a>
	<div>
</body>
</html>
