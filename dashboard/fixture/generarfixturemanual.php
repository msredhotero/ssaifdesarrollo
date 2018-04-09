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
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Estadisticas",$_SESSION['refroll_predio'],$_SESSION['email_predio']);

//*** SEGURIDAD ****/
//include ('../../includes/funcionesSeguridad.php');
//$serviciosSeguridad = new ServiciosSeguridad();
//$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../fixture/');
//*** FIN  ****/

	$fecha = date('Y-m-d');
	
	$idTorneo = $_POST['idtorneo'];
	$cantEquipos = $_POST['cantidadEquipos'];
	$cantPartidos = $_POST['cantidadPartidos'];



	$lstEquipos = array();
	$cadModulo = 'modulo';
	$cadModuloEquipo = 'equipoModulo';

	function devolverIdEquipo($modulo, $cantEquipos) {
		for ($i=1;$i<= $cantEquipos;$i++) {
			if ($_POST['modulo'.$i] == $modulo) {
				return $_POST['equipoModulo'.$i];
			}
		}

		return 0;	
	}
	

	
	$resTorneos = $serviciosReferencias->traerTorneosPorId($idTorneo);
	$tipoTorneo = mysql_result($resTorneos,0,'reftipotorneo');
	
	$resEquipos = $serviciosReferencias->traerEquipoPorTorneo($idTorneo);
	
	
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
	
	
for ($i=1;$i<=$cantPartidos;$i++) {
    $idEquipoLocal      = devolverIdEquipo($_POST[$cadEquipoLocal.$i], $cantEquipos);
    $idEquipoVisitante  = devolverIdEquipo($_POST[$cadEquipoVisitante.$i], $cantEquipos);
    //die(var_dump($idEquipoLocal));
    $resHorario     = $_POST[$cadHorario.$i];
    $resRefFechas 	= $_POST[$cadRefFechas.$i];
	$resFechas 		= $_POST[$cadFechas.$i];
    
    if (($idEquipoLocal != 0) || ($idEquipoVisitante != 0)) {
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

