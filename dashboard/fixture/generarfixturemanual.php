<?php
session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../../error.php');
} else {


include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../fixture/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Estadisticas",$_SESSION['refroll_predio'],'');

//*** SEGURIDAD ****/
//include ('../../includes/funcionesSeguridad.php');
//$serviciosSeguridad = new ServiciosSeguridad();
//$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../fixture/');
//*** FIN  ****/

	$fecha = date('Y-m-d');
	
	$idTorneo = $_POST['idtorneo'];
	
	$resTorneos = $serviciosReferencias->traerTorneosPorId($idTorneo);
	$tipoTorneo = mysql_result($resTorneos,0,'reftipotorneo');
	
	$resEquipos = $serviciosReferencias->traerEquipoPorTorneo($idTorneo);
	
	if ((mysql_num_rows($resEquipos) % 2) == 0) {
		$cantidadFechas = ($resEquipos / 2) * $tipoTorneo;	
	} else {
		$cantidadFechas = (($resEquipos / 2) + 1) * $tipoTorneo;
	}
	
	$cadEquipoLocal = 'refconectorlocal';
	$cadEquipoVisitante = 'refconectorvisitante';
	
	$cadHorario = 'horario';
	$cadRefFechas = 'reffechas';
	$cadFechas = 'datepicker';
	
	$calificacioncancha	= 'NULL';
	$puntoslocal		= 'NULL';
	$puntosvisita		= 'NULL';
	$goleslocal			= 'NULL';
	$golesvisitantes	= 'NULL';
	$observaciones		= '';
	$publicar			= 0;
	
	$refestadospartidos = 'NULL';
	
	$refarbitros		= 'NULL';
	
	
for ($i=1;$i<=$cantidadFechas;$i++) {
    $idEquipoLocal      = $_POST[$cadEquipoLocal.$i];
    $idEquipoVisitante  = $_POST[$cadEquipoVisitante.$i];
    
    $resHorario     = $_POST[$cadHorario.$i];
    $resRefFechas 	= $_POST[$cadRefFechas.$i];
	$resFechas 		= $_POST[$cadFechas.$i];
    
    if (($idEquipoLocal != 0) && ($idEquipoVisitante != 0)) {
        if ($idEquipoLocal != $idEquipoVisitante) {
            $serviciosReferencias->insertarFixture($idTorneo,$resRefFechas,$idEquipoLocal,$idEquipoVisitante,$refarbitros,'','','NULL',$resFechas,$resHorario,$refestadospartidos,$calificacioncancha,$puntoslocal,$puntosvisita,$goleslocal,$golesvisitantes,'',0);

        }
    }
    
    $cadEquipoLocal = 'refconectorlocal';
	$cadEquipoVisitante = 'refconectorvisitante';
	
	$cadHorario = 'horario';
	$cadRefFechas = 'reffechas';
	$cadFechas = 'datepicker';
}

header('Location: index.php');

}
?>

