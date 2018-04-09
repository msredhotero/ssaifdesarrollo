<?php




include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosReferencias 	= new ServiciosReferencias();

$token = $_GET['callback'];

$resTraerTemporadas = $serviciosReferencias->traerUltimaTemporada();

if (mysql_num_rows($resTraerTemporadas)>0) {
	$idTemporada = mysql_result($resTraerTemporadas,0,0);
}	else {
	$idTemporada = 0;
}

$ultimaFecha = $serviciosReferencias->traerUltimoDiaJugado();

$fecha = mysql_result($ultimaFecha,0,0);
$nuevaDesde = strtotime ( '-2 day' , strtotime ( $fecha ) ) ;
$nuevaHasta = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;

$nuevaDesde = date ( 'Y-m-d' , $nuevaDesde );
$nuevaHasta = date ( 'Y-m-d' , $nuevaHasta );

$datos = $serviciosReferencias->traerGoleadoresPorFecha($idTemporada,$nuevaDesde, $nuevaHasta);

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

	while ($row = mysql_fetch_array($datos)) {
			  
		array_push($ar,array('goles'=>$row['goles'], 'encontra'=>$row['encontra'],'apellido'=>$row['apellido'],'nombres'=>$row['nombres'],'equipolocal'=>$row['equipolocal'],'equipovisitante'=>$row['equipovisitante'],'categoria'=>$row['categoria'],'division'=>$row['division']));
		
		
	}

//die(var_dump($ar));
echo $token.'('.json_encode($ar).');';
?>