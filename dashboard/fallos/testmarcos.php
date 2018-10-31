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



$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Fallos",$_SESSION['refroll_predio'],$_SESSION['email_predio']);



$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////




if ($_SESSION['refroll_predio'] != 1) {

} else {

	
}

$resTorneosActivos = $serviciosReferencias->traerTorneos();
$cadRefTorneosActivos = $serviciosFunciones->devolverSelectBox($resTorneosActivos,array(1,2,3,4,5),' - ');

$resJugadores   =   $serviciosReferencias->traerJugadores();
$cadRefJugadores    =   $serviciosFunciones->devolverSelectBox($resJugadores,array(1,2,3,4),' - ');

$resFechas  =   $serviciosReferencias->traerFechas();
$cadRefFechas   =   $serviciosFunciones->devolverSelectBox($resFechas,array(1),'');

$resTipoTorneo  =   $serviciosReferencias->traerTipotorneo();
$cadRefTipoTorneo   =   $serviciosFunciones->devolverSelectBox($resTipoTorneo,array(1),'');


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
        	<p style="color: #fff; font-size:18px; height:16px;">Test</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<div class="form-group col-md-6">
                <label class="control-label" style="text-align:left" for="refcliente">Torneo</label>
                <div class="input-group col-md-12">
                    <select id="idtorneo" class="form-control" name="idtorneo">
                        <?php echo $cadRefTorneosActivos; ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label" style="text-align:left" for="refcliente">Jugador</label>
                <div class="input-group col-md-12">
                    <input type="text" id="idjugador" class="form-control" name="idjugador">
                       
                </div>
            </div>

            <div class="form-group col-md-3">
                <label class="control-label" style="text-align:left" for="refcliente">Fecha</label>
                <div class="input-group col-md-12">
                    <select id="reffecha" class="form-control" name="reffecha">
                        <?php echo $cadRefFechas; ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-3">
                <label class="control-label" style="text-align:left" for="refcliente">Tipo Torneo</label>
                <div class="input-group col-md-12">
                    <select id="idtipotorneo" class="form-control" name="idtipotorneo">
                        <option value="1">Ida</option>
                        <option value="2">Ida/Vuelta</option>
                    </select>
                </div>
            </div>


            <div class="form-group col-md-12">
                <h3 id="valor"></h3>
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
                        <button type="button" class="btn btn-primary" id="ver" style="margin-left:0px;">Ver Amarillas Stock</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-warning" id="ultimafecha" style="margin-left:0px;">Ultima Fecha Por Amarillas</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-danger" id="remanente" style="margin-left:0px;">Remanente</button>
                    </li>
                </ul>
                </div>
            </div>
            </form>
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
	

    $('#ver').click(function() {
        $.ajax({
            data:  {idtorneo: $('#idtorneo').val(), 
                    idjugador: $('#idjugador').val(), 
                    reffecha: $('#reffecha').val(),
                    idtipotorneo: $('#idtipotorneo').val(),
                    accion: 'traerAmarillasAcumuladas'},
            url:   '../../ajax/ajax.php',
            type:  'post',
            beforeSend: function () {
                $('#valor').html('');    
            },
            success:  function (response) {
                    $('#valor').html('Amarillas: ' + response);
                    
            }
        });
    });

    $('#ultimafecha').click(function() {
        $.ajax({
            data:  {idtorneo: $('#idtorneo').val(), 
                    idjugador: $('#idjugador').val(), 
                    idtipotorneo: $('#idtipotorneo').val(),
                    accion: 'ultimaFechaSancionadoPorAcumulacionAmarillas'},
            url:   '../../ajax/ajax.php',
            type:  'post',
            beforeSend: function () {
                $('#valor').html('');    
            },
            success:  function (response) {
                    $('#valor').html('Fecha: ' + response);
                    
            }
        });
    });


    $('#remanente').click(function() {
        $.ajax({
            data:  {idtorneo: $('#idtorneo').val(), 
                    idjugador: $('#idjugador').val(), 
                    idtipotorneo: $('#idtipotorneo').val(),
                    accion: 'ultimaFechaSancionadoPorAcumulacionAmarillasFallada'},
            url:   '../../ajax/ajax.php',
            type:  'post',
            beforeSend: function () {
                $('#valor').html('');    
            },
            success:  function (response) {
                    $('#valor').html('Remanente: ' + response);
                    
            }
        });
    });


});
</script>


<?php } ?>
</body>
</html>
