<?php

$informe = $_GET['informe'];

$categoria = $_GET['categoria'];
$division = $_GET['division'];
$partido = $_GET['partido'];
$fecha = $_GET['fecha'];

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Hola Mundo!</title>
    </head>
    <body>
      <div align="center">
         <h1>Partido: <?php echo utf8_encode($partido); ?></h1>
         <h2>Categoria: <?php echo utf8_encode($categoria); ?></h2>
         <h2>Division: <?php echo utf8_encode($division); ?></h2>
         <h5>Fecha: <?php echo utf8_encode($division); ?></h5>
      </div>

      <h3>Informe: <?php echo utf8_encode($informe); ?></h3>
    </body>
</html>
