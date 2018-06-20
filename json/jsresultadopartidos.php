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
$nuevoMarcosFechaDestacada = $serviciosReferencias->traerUltimaFechaDestacada();

$fecha = mysql_result($ultimaFecha,0,0);
$nuevaDesde = strtotime ( '-2 day' , strtotime ( $fecha ) ) ;
$nuevaHasta = strtotime ( '+2 day' , strtotime ( $fecha ) ) ;

$nuevaDesde = mysql_result($nuevoMarcosFechaDestacada,0,0);
$nuevaHasta = mysql_result($nuevoMarcosFechaDestacada,0,1);

$datos = $serviciosReferencias->traerFixtureSumarizadoTodoPorTorneoDesdeHastaWhere($idTemporada,$nuevaDesde, $nuevaHasta);

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

	while ($row = mysql_fetch_array($datos)) {
			  
		array_push($ar,array('ganadoslocal'=>$row['ganadoslocal'], 'ganadosvisitante'=>$row['ganadosvisitante'],'empatados'=>$row['empatados'],'goles'=>$row['goles'],'amarillas'=>$row['amarillas'],'rojas'=>($row['rojas'] == '' ? 0 :$row['rojas'])));
		
		
	}

//die(var_dump($ar));
echo $token.'('.json_encode($ar).');';
?>