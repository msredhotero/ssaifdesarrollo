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
include ('../../includes/funcionesDelegados.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$serviciosDelegados 	= new serviciosDelegados();

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../estadisticas/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Estadisticas",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Division";

$plural = "Divisiones";

$eliminar = "eliminarDivisiones";

$insertar = "insertarDivisiones";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////

$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbcabeceraconfirmacion";

$lblCambio	 	= array("");
$lblreemplazo	= array("");


$cadRef 	= '';

$refdescripcion = array();
$refCampo 	=  array();
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "	<th>Temporada</th>
					<th>Countrie</th>
					<th>Estado</th>
					<th>Fecha Crea.</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////




//$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

//$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosDelegados->traerCabeceraconfirmacionGrid(),4);

$resEstados = $serviciosReferencias->traerEstados();
$cadRef 	= $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');

$resTemporadas = $serviciosReferencias->traerUltimaTemporada();

if (mysql_num_rows($resTemporadas)>0) {
    $ultimaTemporada = mysql_result($resTemporadas,0,0);
} else {
    $ultimaTemporada = 0;
}

$resDatos = $serviciosReferencias->suspendidosTotal();

$resDatosFirst = $serviciosReferencias->traerJugadoresVariosEquipos($ultimaTemporada);

$arJugadoresLst = '';


if ($_SESSION['refroll_predio'] != 1) {

} else {

	
}


?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title><?php echo $tituloWeb; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	
    
   
   <link href="../../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../../js/jquery.mousewheel.js"></script>
      <script src="../../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
      });
    </script>
    
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Cabeceras Cargadas</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<table class="table table-striped table-responsive" id="example">
				<thead>
					<tr>
						<th>Partido</th>
						<th>Countrie</th>
						<th>Nro.Doc.</th>
						<th>Apellido y Nombre</th>
						<th>Fecha Nac.</th>
						<th>Equipo</th>
						<th>Categoria</th>
						<th>Division</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody id="resultados">
					<?php 


						while ($row = mysql_fetch_array($resDatosFirst)) {

							if (strpos($arJugadoresLst,$row['idjugador']) === false) {
								$arJugadoresLst .= $row['idjugador'].',';
							}

							$where = '';
    						$where .= ' tor.reftemporadas = '.$ultimaTemporada." and ";
    						$where .= " fix.fecha >= '".$desde."' and fix.fecha <= '".$hasta."' and ";

							$where .= ' tor.refcategorias = '.$row['idtcategoria']." and ";
							$where .= ' tor.refdivisiones = '.$row['iddivision']." and ";
							$where .= ' ( fix.refconectorlocal = '.$row['refequipos']." or fix.refconectorvisitante = ".$row['refequipos'].") and ";

							$idJugador = $row['idjugador'];

							$resSuspendido = $serviciosReferencias->SuspendidosTotalPorJugador($idJugador);

							$resProximasFechas	= $serviciosReferencias->traerProximaFechaFiltros(substr($where,0,strlen($where)-4));

                            /*if ($row[nrodocumento] == '28705528') {
                                echo $where.'<br>';
                            }*/
                            
                            //if (mysql_num_rows($resSuspendido) > 0) {
							if ((mysql_num_rows($resSuspendido) > 0) && (mysql_num_rows($resProximasFechas) > 0)) {
					?>
					<tr>
						<td><?php while ($rowR = mysql_fetch_array($resProximasFechas)) { 
							$idfixture = $rowR['idfixture'];
							$resHabilitado = $serviciosReferencias->devolverSuspendidoshabilitadosPorFixtureJugador($idfixture,$idJugador);
							echo $rowR['equipoLocal'].''.$rowR['equipoVisitante'].' Fecha: '.$rowR['fechajuego']; 
						} ?></td>
						<td><?php echo $row['country']; ?></td>
						<td><?php echo $row['nrodocumento']; ?></td>
						<td><?php echo $row['apyn']; ?></td>
						<td><?php echo $row['fechanacimiento']; ?></td>
						<td><?php echo $row['equipo']; ?></td>
						<td><?php echo $row['categoria']; ?></td>
						<td><?php echo $row['division']; ?></td>

						<td>
						<?php if ($resHabilitado == 0) { ?>
							<button type="button" class="btn btn-danger btnHabilitar" data-fixture="<?php echo $idfixture; ?>" data-jugador="<?php echo $idJugador; ?>" id="<?php echo $row['idtcategoria']; ?>" style="margin-left:0px;">SUSPENDIDO</button>
						<?php } else { ?>
							<button type="button" class="btn btn-success btnSuspender" data-fixture="<?php echo $idfixture; ?>" data-jugador="<?php echo $idJugador; ?>" id="<?php echo $row['idtcategoria']; ?>" style="margin-left:0px;">HABILITADO</button>
						<?php } ?>
						</td>
					</tr>

					<?php 
							}
						}
					?>

					<?php 


						while ($row = mysql_fetch_array($resDatos)) {

						if (strpos($arJugadoresLst,$row['idjugador']) === false) {

							$where = '';
    						$where .= ' tor.reftemporadas = '.$ultimaTemporada." and ";
    						$where .= " fix.fecha >= '".$desde."' and fix.fecha <= '".$hasta."' and ";

							$where .= ' tor.refcategorias = '.$row['refcategorias']." and ";
							$where .= ' tor.refdivisiones = '.$row['iddivision']." and ";
							$where .= ' ( fix.refconectorlocal = '.$row['refequipos']." or fix.refconectorvisitante = ".$row['refequipos'].") and ";

							$idJugador = $row['idjugador'];

							$resSuspendido = $serviciosReferencias->SuspendidosTotalPorJugador($idJugador);

							$resProximasFechas	= $serviciosReferencias->traerProximaFechaFiltros(substr($where,0,strlen($where)-4));

                            /*if ($row[nrodocumento] == '28705528') {
                                echo $where.'<br>';
                            }*/
                            
                            //if (mysql_num_rows($resSuspendido) > 0) {
							if ((mysql_num_rows($resSuspendido) > 0) && (mysql_num_rows($resProximasFechas) > 0)) {
					?>
					<tr>
						<td><?php while ($rowR = mysql_fetch_array($resProximasFechas)) { 
							$idfixture = $rowR['idfixture'];
							$resHabilitado = $serviciosReferencias->devolverSuspendidoshabilitadosPorFixtureJugador($idfixture,$idJugador);
							echo $rowR['equipoLocal'].''.$rowR['equipoVisitante'].' Fecha: '.$rowR['fechajuego']; 
						} ?></td>
						<td><?php echo $row['country']; ?></td>
						<td><?php echo $row['nrodocumento']; ?></td>
						<td><?php echo $row['apyn']; ?></td>
						<td><?php echo $row['fechanacimiento']; ?></td>
						<td><?php echo $row['equipo']; ?></td>
						<td><?php echo $row['categoria']; ?></td>
						<td><?php echo $row['division']; ?></td>

						<td>
						<?php if ($resHabilitado == 0) { ?>
							<button type="button" class="btn btn-danger btnHabilitar" data-fixture="<?php echo $idfixture; ?>" data-jugador="<?php echo $idJugador; ?>" id="<?php echo $row['idtcategoria']; ?>" style="margin-left:0px;">SUSPENDIDO</button>
						<?php } else { ?>
							<button type="button" class="btn btn-success btnSuspender" data-fixture="<?php echo $idfixture; ?>" data-jugador="<?php echo $idJugador; ?>" id="<?php echo $row['idtcategoria']; ?>" style="margin-left:0px;">HABILITADO</button>
						<?php } ?>
						</td>
					</tr>

					<?php 
							}
						}
					}
					?>
				</tbody>
			</table>

    	</div>
    </div>
    
    

    
    
   
</div>


</div>



<div class="modal fade" id="myModal3" tabindex="1" style="z-index:500000;" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form class="form-inline formulario" role="form">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modificar Estado</h4>
			</div>
			<div class="modal-body">
				<label class="label-control">Seleccione el Estado</label>
			    <select class="form-control" id="refestados" name="refestados">
			    	<?php echo $cadRef; ?>
			    </select>
			    <input type="hidden" name="idcabecera" id="idcabecera" value="0">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal" id="btnModificarEstado">Modificar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

			</div>
			</form>
		</div>
	</div>
</div>



<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){





	function habilitar_suspender(idfixture,idjugador,tipo) {
		$.ajax({
			data:  {idfixture: idfixture, 
					idjugador: idjugador,
					tipo: tipo,
					accion: 'habilitar_suspender'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
				if (response.error == false) {
					location.reload();
				} else {
					alert('Se genero un error al modificar los datos, intente nuevamente');
				}
				
			}
		});
	}

	$("#resultados").on("click",'.btnSuspender', function(){

		idjugador = $(this).attr("data-jugador");
		idfixture = $(this).attr("data-fixture");

		habilitar_suspender(idfixture,idjugador,0);
	});

	$("#resultados").on("click",'.btnHabilitar', function(){

		idjugador = $(this).attr("data-jugador");
		idfixture = $(this).attr("data-fixture");

		habilitar_suspender(idfixture,idjugador,1);
	});
	
	

});
</script>

<?php } ?>
</body>
</html>
