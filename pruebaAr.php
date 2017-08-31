<?php

$array = array(5, "45", "78", "17", "5");
var_export ($array);
$indice = array_search(5,$array,false);
echo "El número 5 está en el indice: " . $indice;
 
//Con valor strict a TRUE
$array = array(45, 75, 17, 555,5);
var_export ($array);
$indice = array_search(5,$array,true);
echo "El número 5 está en el indice: " . $indice;

if ($indice == '') {
	echo 'no existe';	
} else {
	echo 'si existe';	
}


?>