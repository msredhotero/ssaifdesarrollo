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
	if (date('Y') == 2019) {
        $idTemporada = 8;
    } else {
        $idTemporada = mysql_result($resTraerTemporadas,0,0);
    }
}	else {
	$idTemporada = 0;
}

$ultimaFecha = $serviciosReferencias->traerUltimoDiaJugado();
$nuevoMarcosFechaDestacada = $serviciosReferencias->traerUltimaFechaDestacada();

$fecha = mysql_result($ultimaFecha,0,0);
$nuevaDesde = strtotime ( '-2 day' , strtotime ( $fecha ) ) ;
$nuevaHasta = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;

$nuevaDesde = mysql_result($nuevoMarcosFechaDestacada,0,0);
$nuevaHasta = mysql_result($nuevoMarcosFechaDestacada,0,1);

$datos = $serviciosReferencias->traerPartidoDestacadoPorFechas($idTemporada,$nuevaDesde, $nuevaHasta);

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

	while ($row = mysql_fetch_array($datos)) {
			  
		array_push($ar,array('goleslocal'=>$row['goleslocal'], 'golesvisitantes'=>$row['golesvisitantes'],'equipolocal'=>$row['equipolocal'],'equipovisitante'=>$row['equipovisitante'],'categoria'=>$row['categoria'],'division'=>$row['division']));
		
		
	}

//die(var_dump($ar));
echo $token.'('.json_encode($ar).');';
?>