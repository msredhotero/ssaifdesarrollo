<?php

include ('includes/funcionesUsuarios.php');
include ('includes/funciones.php');
include ('includes/funcionesHTML.php');
include ('includes/funcionesReferencias.php');



$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();

$sql = "SELECT
    (case when u.idusuario = 1504 then 'brownjavier@hotmail.com'
		 when u.idusuario = 1503 then 'javierbrown@aif.org.ar'
         when u.idusuario = 1408 then 'msredhotero@msn.com'
         else u.email end) as email,
    u.password, u.usuario, u.idusuario
FROM
    dbusuarios u
        INNER JOIN
    dbarbitros a ON u.idusuario = a.refusuarios
WHERE
    u.refroles = 3 and u.idusuario in (1504,1503,1408)";

$sql2 = "select 'msredhotero@yahoo.com.ar' as email, 'ñunko' as password, 'marcos daniel' as usuario, 1800 as idusuario";

$res = $serviciosReferencias->query($sql,0);

$asunto = "AIFZN - Usuario para la carga de partidos: ";



while ($row = mysql_fetch_array($res)) {
   $cuerpo = "<h3>Ya puede acceder al sistema de carga de partidos nuevo de la AIFZN</h3>
               <h4>Password: ".utf8_decode($row['password'])."</h4>
               <h4>Acceda desde <a href='https://saupureinconsulting.com.ar/aifzncountries/index.html'>Aqui</a></h4>";
   $serviciosReferencias->enviarEmail($row['email'],$asunto.utf8_decode($row['usuario']),$cuerpo, $referencia='');
}



?>
