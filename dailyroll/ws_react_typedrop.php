<?php 


$responsearray =[];
array_unshift($responsearray,array("value"=>"0","label"=>"Expenses"));
array_unshift($responsearray,array("value"=>"1","label"=>"Income"));
echo json_encode($responsearray);


?>