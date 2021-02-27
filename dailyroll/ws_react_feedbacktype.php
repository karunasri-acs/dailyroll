<?php 


$responsearray =[];
array_unshift($responsearray,array("value"=>"2","label"=>"Suggestion"));
array_unshift($responsearray,array("value"=>"1","label"=>"Request"));

echo json_encode($responsearray);


?>