<?php

$informe = $_GET['informe'];

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Hola Mundo!</title>
    </head>
    <body>
        <h3>Informe: <?php echo utf8_encode($informe); ?></h3>
    </body>
</html>
