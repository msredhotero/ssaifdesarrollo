<?php

$directorio = 'data';
$ficheros1  = scandir($directorio);

$cad = '';
foreach ($ficheros1 as $key => $value) {
   if (strpos($value,'.') === false) {
      $cad .= "INSERT INTO tbcarpetas
(idcarpeta,
id)
VALUES
('',".$value.');'.'<br>';
   }

}

echo $cad;

?>
