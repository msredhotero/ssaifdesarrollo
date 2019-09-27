<?php
include ('includes/funcionesReferencias.php');
$serviciosReferencias		= new ServiciosReferencias();

$tabla = 'tbcategorias';
$operacion = 'I';
$id = 10;
$usuario = 'marcos';

$res = $serviciosReferencias->insertAuditoria($tabla, $operacion,$id,$usuario);

echo $res;
?>
