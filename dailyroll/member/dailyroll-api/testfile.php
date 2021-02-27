
<?php
require 'testcryptfile.php';

$nonceValue = 'nonce_value';// use nonce that generated while using OAuth.

$readableString = 'asdf-ghjk-qwer-tyui';
//$encryptedString = 'eyJjaXBoZXJ0ZXh0IjoiNkRuSzRueVR5aERIQTVCdkF6SU9Mc0E0S1llUW5tZndvS0hIbERRMlE1VT0iLCJpdiI6IjNlNGU0YjFlNTBjNGRmODc2ZWExZTg3NjY3MDc4ZjBkIiwic2FsdCI6IjY0OWUxZDQ0NGNiZDc1YjBhODk2NmY2YTRjZTNjYzUzMmIyYTA4ZDQzZjlmYTQzNDRiOGU2MDFmNWIxODlkNzFjZGE3ZDc1YzU1YTBjMzNhMmM1ZWRlMjc5MTMxZTM5ZjNhYjgzY2JjNGQ5ZjIwYmY5YWE3YjdjN2MwNmVlMTZmNjJmYWEzMWU1MjFiMWZjNWFmZDcxMmRlNDQ3MWEyOTg3MDM0MzliODk0N2E0NGViOTMyMWFlMzI0ZWM2Zjg1ZjkwYmQzYzRmNjk5YzdmN2ViMTVhOGE0ZWExYjU1OGJmNWFiYjg5MzFjMjA5YTkzMWEwY2Q1NWM1NTgxMTRkNTY5NTIzZTk5OWMwZDA4Y2FiYmY4MzAzMTA0MzJkNzE2NmJlMDZlYzk3NjQzNzY1MzQ2NDI4YTM0ODM3MWUyOWRkNDU2ZTVmOGQ0NDgxZGVmZjY4M2FlOGYwOTJjODk3NjdhMzRhN2I0MWNlM2VlMDVlOWQ2ZDg4ZDI5MzVmZGM5MDUxY2VlZDhiYjllZDM5MzNjNjg2ODczZGNiOTJhZWI2MzBkMjNjODNhMjIyNTRjZDkxMDg4OTc4OWQ1MTI1MTc2MjQ2ZGYwOTQyODE5MTZlMmY4Y2RjYTU2MDEwMzEzZTM2NmE2ZDMyOTA4OGM3NzI5MWY3NDE3ODRiNTdmNTc1IiwiaXRlcmF0aW9ucyI6OTk5fQ==';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php 
        echo 'readable string: ' . $readableString . '<br>';
        $Encryption = new Encryption();
        $encrypted = $Encryption->encrypt($readableString, $nonceValue);
        echo 'encrypted: ' . $encrypted . '<br>';
        
        echo "\n\n\n";
        echo '<hr>';
        echo "\n\n\n";
        
        $decrypted = $Encryption->decrypt($encrypted, $nonceValue);
        echo 'decrypted: ' . $decrypted . '<br>';
        $decrypted = $Encryption->decrypt($encryptedString, $nonceValue);
        echo 'decrypted from old encrypted string: <strong>' . $decrypted . '</strong><br>';
        ?>
	</body>
</html>