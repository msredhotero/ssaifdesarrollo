<?php

include ('includes/funcionesUsuarios.php');
include ('includes/funciones.php');
include ('includes/funcionesHTML.php');
include ('includes/funcionesReferencias.php');



$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();

$sql2 = "select u.email, u.password, u.usuario, u.idusuario
         from     dbusuarios u
         inner
         join     dbarbitros a
         on       u.idusuario = a.refusuarios
         where u.refroles = 3";

$sql = "select 'msredhotero@gmail.com' as email, 'ñunko' as password, 'marcos daniel' as usuario, 1800 as idusuario";

$res = $serviciosReferencias->query($sql,0);

$asunto = "Confirmar Usuario AIFZN: ";



while ($row = mysql_fetch_array($res)) {
   $cuerpo = "<h3>Debera hacer click en el enlace en el password que le enviamos para activar su usuario</h3>
               <h4>Password: <a href='https://saupureinconsulting.com.ar/aifzncountriesdesarrollo/activararbitro.php?id=".$row['idusuario']."'>".$row['password']."</a></h4>";
   $serviciosReferencias->enviarEmail($row['email'],$asunto.$row['usuario'],$cuerpo, $referencia='');
}



?>
