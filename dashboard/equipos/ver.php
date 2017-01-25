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

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Equipos",$_SESSION['refroll_predio'],'');


$id = $_GET['id'];

$resResultado = $serviciosReferencias->traerEquiposPorId($id);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Equipo";

$plural = "Equipos";

$eliminar = "eliminarEquipos";

$modificar = "modificarEquipos";

$idTabla = "idequipo";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbequipos";

$lblCambio	 	= array("refcountries","refcontactos","refcategorias","refdivisiones","fechaalta","fachebaja");
$lblreemplazo	= array("Countrie","Contacto","Categoria","Division","Fecha Alta","Fecha Baja");


$resCountries 	= $serviciosReferencias->traerCountriesPorId(mysql_result($resResultado,0,'refcountries'));
$cadRef 	= $serviciosFunciones->devolverSelectBoxActivo($resCountries,array(1),'', mysql_result($resResultado,0,'refcountries'));

$resContactos 	= $serviciosReferencias->traerContactosPorId(mysql_result($resResultado,0,'refcontactos'));
$cadRef2 	= $serviciosFunciones->devolverSelectBoxActivo($resContactos,array(2),'', mysql_result($resResultado,0,'refcontactos'));

$resCategorias 	= $serviciosReferencias->traerCategoriasPorId(mysql_result($resResultado,0,'refcategorias'));
$cadRef3 	= $serviciosFunciones->devolverSelectBoxActivo($resCategorias,array(1),'', mysql_result($resResultado,0,'refcategorias'));

$resDivisiones 	= $serviciosReferencias->traerDivisionesPorId(mysql_result($resResultado,0,'refdivisiones'));
$cadRef4 	= $serviciosFunciones->devolverSelectBoxActivo($resDivisiones,array(1),'', mysql_result($resResultado,0,'refdivisiones'));

$refdescripcion = array(0 => $cadRef,1 => $cadRef2,2 => $cadRef3,3 => $cadRef4);
$refCampo 	=  array("refcountries","refcontactos","refcategorias","refdivisiones");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$resJugadoresEquipos = $serviciosReferencias->traerConectorActivosPorEquipos($id);


$formulario 	= $serviciosFunciones->camposTablaVer($id, $idTabla,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);


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
	<style type="text/css">
		
  
		
	</style>
    
   
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
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzxyoH5wuPmahQIZLUBjPfDuu_cUHUBQY"
  type="text/javascript"></script>
    <style type="text/css">
		#map
		{
			width: 100%;
			height: 600px;
			border: 1px solid #d0d0d0;
		}
  		
		th {
  color:#D5DDE5;;
  background:#1b1e24;
  border-bottom:4px solid #9ea7af;
  border-right: 1px solid #343a45;
  font-size:17px;
  font-weight: 100;
  padding:18px;
  text-align:left;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  vertical-align:middle;
  font-family: "Roboto", helvetica, arial, sans-serif;
}

th:first-child {
  border-top-left-radius:3px;
}
 
th:last-child {
  border-top-right-radius:3px;
  border-right:none;
}

tr {
  border-top: 1px solid #C1C3D1;
  border-bottom-: 1px solid #C1C3D1;
  color:#666B85;
  font-size:16px;
  font-weight:normal;
  text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
}
		
	</style>
   
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

<h3><?php echo $plural; ?></h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Ver <?php echo $singular; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">
        	
			<div class="row">
			<?php echo $formulario; ?>
            </div>
            
            
            <div class="row" id="contMapa2" style="margin-left:25px; margin-right:25px;">

                <div class="col-md-12">
                	<div class="form-group col-md-12">
                        <label class="control-label" style="text-align:left; font-size:1.2em; text-decoration:underline; margin-bottom:4px;" for="fechas">Lista de Jugadores</label>
                        <div class="input-group col-md-12">
                            <table class="table table-bordered table-responsive table-striped">
                            <thead>
                            	<tr>
                                	<th>Nombre Completo</th>
                                    <th>Nro Documento</th>
                                    <th>Tipo Jugador</th>
                                    <th>Countrie</th>
                                    <th>Edad</th>
                                    <th style="text-align:center">Ver</th>
                                    <th style="text-align:center">Modificar</th>
                                    <th style="text-align:center">Baja</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php 
								while ($rowC = mysql_fetch_array($resJugadoresEquipos)) {
							
							?>
                            	<tr>
                            	<td><?php echo $rowC['nombrecompleto']; ?></td>
                                <td><?php echo $rowC['nrodocumento']; ?></td>
                                <td><?php echo $rowC['tipojugador']; ?></td>
                                <td><?php echo $rowC['countrie']; ?></td>
                                <td><?php echo $rowC['edad']; ?></td>
                                <td align="center"><img src="../../imagenes/verIco.png" style="cursor:pointer;" id="<?php echo $rowC['refjugadores']; ?>" data-toggle="modal" data-target="#myModal" class="varVerDetalle"></td>
								<td align="center"><img src="../../imagenes/editarIco.png" style="cursor:pointer;" id="<?php echo $rowC['refjugadores']; ?>" class="varModificarJugador"></td>
                                <td align="center"><img src="../../imagenes/eliminarIco.png" style="cursor:pointer;" id="<?php echo $rowC['idconector']; ?>" class="varEliminarJugador"></td>
                                </tr>
                            <?php
								}
							?>
                            </tbody>
                            <tfoot>
                            	<td colspan="6">Total Jugadores:</td>
                                <td>0</td>
                            </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                        <button type="button" class="btn btn-warning modificar" id="<?php echo $id; ?>" style="margin-left:0px;">Modificar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            </form>
    	</div>
    </div>
    
    
   
</div>


</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="1" style="z-index:500000;" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle de Venta</h4>
      </div>
      <div class="modal-body detalleJugador">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){

	$('.volver').click(function(event){
		 
		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar
	
	function traerDatosJugador(id) {
		$.ajax({
			data:  {id: idCliente, 
					accion: 'traerDatosJugador'},
			url:   '../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {

			},
			success:  function (response) {

				$('#detalleJugador').html(response);
	
			}
		});	
	}
	
	
	$(document).on('click', '.varVerDetalle', function(e){
		  traerDatosJugador($(this).attr("id"));
	});//fin del boton modificar
	
	$(document).on('click', '.varModificarJugador', function(e){
		url = "../jugadores/modificar.php?id="+$(this).attr("id");
		$(location).attr('href',url);
	});//fin del boton modificar

	$('.modificar').click(function(event){
		 
		usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar
	
	

});
</script>


<?php } ?>
</body>
</html>
