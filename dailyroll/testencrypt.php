<?php
session_start();

require_once 'class_user.php';

$encryption = new USER();

#176

$string     = 'tR9bLXSlk8T7D3OIgVsYvdD1Ldwi1v4+k7s6jRrU3Vo=';

echo '<br>';echo '<br>';echo '<br>';

$cipher = $encryption->encryptedstatic($string );
echo 'encryptedstatic: ' . $cipher ;	
echo '<br>';

//$plainText = $encryption->decryptCipherTextWithRandomIV($cipher, $secretyKey);
//echo 'decryptedString: ' . $plainText ;	
echo '<br>';
$plainText = $encryption->dencrypted($string);
echo 'dencryptedstatic: ' . $plainText ;	


/*
echo '<br>';echo '<br>';echo '<br>';

$cipher = $encryption->encrypt($string, $secretyKey, md5($string) );
echo 'encrypt: ' . $cipher ;	
echo '<br>';

//$plainText = $encryption->decryptCipherTextWithRandomIV($cipher, $secretyKey);
//echo 'decryptedString: ' . $plainText ;	
echo '<br>';
$plainText = $encryption->decrypt($cipher, $secretyKey, md5($string));
echo 'decrypt: ' . $plainText ;	
*/

?>