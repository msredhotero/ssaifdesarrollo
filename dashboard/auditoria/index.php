<?php


session_start();


if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../error.php');
} else {


include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funciones.php');
include ('../../includes/funcionesReferencias.php');
include ('../../includes/funcionesAuditoria.php');

$serviciosUsuario = new ServiciosUsuarios();
$serviciosHTML = new ServiciosHTML();
$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();
$serviciosAuditoria 	= new ServiciosAuditoria();


//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../reportes/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Reportes",$_SESSION['refroll_predio'],$_SESSION['email_predio']);

$resEquipos = $serviciosReferencias->traerEquipos();
$cadRefE = $serviciosFunciones->devolverSelectBox($resEquipos,array(1,2,3,4),' - ');

$resTorneosActivos = $serviciosReferencias->traerTorneos();
$cadRefTorneosActivos = $serviciosFunciones->devolverSelectBox($resTorneosActivos,array(1,2,3,4,5),' - ');

$resTemporadas	=	$serviciosReferencias->traerTemporadas();
$cadRefTemporadas	=	$serviciosFunciones->devolverSelectBox($resTemporadas,array(1),'');

$resCategorias	=	$serviciosReferencias->traerCategorias();
$cadRefCategorias	=	$serviciosFunciones->devolverSelectBox($resCategorias,array(1),'');

$resDivisiones	=	$serviciosReferencias->traerDivisiones();
$cadRefDivisiones	=	$serviciosFunciones->devolverSelectBox($resDivisiones,array(1),'');

$resCountries	=	$serviciosReferencias->traerCountries();
$cadRefCountries	=	$serviciosFunciones->devolverSelectBox($resCountries,array(1),'');

$resJugadores   =   $serviciosReferencias->traerJugadores();
$cadRefJugadores    =   $serviciosFunciones->devolverSelectBox($resJugadores,array(1,2,3,4),' - ');

?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Gesti&oacute;n: AIF</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">



    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>

	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	<!--<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>-->
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/chosen.css">
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
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

    <div class="boxInfoLargo tile-stats stat-til tile-white">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Auditoria Generales</p>

        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">
        	<div class="row">
            	<div class="form-group col-md-6">
                    <label class="control-label" style="text-align:left" for="refcliente">Tipo Reporte</label>
                    <div class="input-group col-md-12">
                    	<select id="tiporeporte" class="form-control" name="tiporeporte">
                        	<option value="0">Todos</option>
									<option value="1">Solo Documentaciones</option>
									<option value="2">Solo Habilitados</option>
									<option value="3">Solo Documentaciones/Habilitados</option>
									<option value="4">Solo Doc. Valores</option>
									<option value="5">Solo Doc./Doc. Valores</option>
									<option value="6">Solo Doc. Valores/Habilitados</option>
									<option value="7">Solo Imagenes</option>
									<option value="8">Solo Imagenes/Documentaciones</option>
									<option value="9">Solo Cambio en Equipos</option>
									<option value="10">Diferencia Habilitados</option>
                    	</select>
                    </div>
                </div>


                <div class="form-group col-md-6" id="cou1">
                    <label class="control-label" style="text-align:left" for="refcliente">Countrie</label>
                    <div class="input-group col-md-12">
                    	<select id="refcountries1" class="form-control" name="refcountries1">
                        	<option value="0">-- Seleccione --</option>
							<?php echo $cadRefCountries; ?>
                    	</select>
                    </div>
                </div>

                <div class="form-group col-md-3" id="cat1">
                    <label class="control-label" style="text-align:left" for="refcliente">Categorias</label>
                    <div class="input-group col-md-12">
                    	<select id="refcategorias1" class="form-control" name="refcategorias1">
                        	<option value="0">-- Seleccione --</option>
							<?php echo $cadRefCategorias; ?>
                    	</select>
                    </div>
                </div>


                <div class="form-group col-md-3" id="div1">
                    <label class="control-label" style="text-align:left" for="refcliente">Division</label>
                    <div class="input-group col-md-12">
                    	<select id="refdivision1" class="form-control" name="refdivision1">
                        	<option value="0">-- Seleccione --</option>
							<?php echo $cadRefDivisiones; ?>
                    	</select>
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label" style="text-align:left" for="refcliente">Fechas Desde</label>
                    <div class="input-group col-md-12">
                    	<input type="text" id="reffechadesde1" class="form-control" name="reffechadesde1" value="Date">
                    </div>
                </div>


                <div class="form-group col-md-2">
                    <label class="control-label" style="text-align:left" for="refcliente">Fechas Hasta</label>
                    <div class="input-group col-md-12">
                    	<input type="text" id="reffechahasta1" class="form-control" name="reffechahasta1" value="Date">
                    </div>
                </div>


                <div class="form-group col-md-12" style="height:30px;">* Se aplicaran filtros a las busquedas</div>

                <div class="form-group col-md-6">
                    <label class="control-label" style="text-align:left" for="refcliente">Acción</label>

                    	<ul class="list-inline">
                        	<li>
                    			<button type="button" class="btn btn-success" id="rptRP" style="margin-left:0px;">Generar</button>
                            </li>

                        </ul>
                </div>

					 <div class="row">
						 <div class="form-group col-md-12 lstMovimientos">

						 </div>
					 </div><!-- fin del contenedor detalle -->


            </div>


            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert'>

                </div>
                <div id='load'>

                </div>
            </div>

            </form>
    	</div>
    </div>



	 <!-- Modal -->
	 <div class="modal fade" id="myModalAuditoria" tabindex="1" style="z-index:500000;" role="dialog" aria-labelledby="myModalLabel">
	   <div class="modal-dialog modal-lg" role="document">
	 	 <div class="modal-content">

	 		<div class="modal-header">
	 		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	 		  <h4 class="modal-title" id="myModalLabel">Detalle Auditoria</h4>
	 		</div>
	 		<div class="modal-body" id="detalleAuditoria">

	 		</div>

	 	 </div>
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

	$('#rptRP').click(function() {
		auditoriaFiltros($('#tiporeporte').val(), $('#reffechadesde1').val(), $('#reffechahasta1').val(), $('#refcountries1').val());
	});

	function auditoriaFiltros(tiporeporte, fechadesde, fechahasta, refcountries1) {
		$.ajax({
			data:  { tiporeporte: tiporeporte,
						accion: 'auditoriaFiltros',
						fechadesde: fechadesde,
						fechahasta: fechahasta,
						refcountries1: refcountries1
					},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
				$('.lstMovimientos').html('');
			},
			success:  function (response) {
				var cad = '';

				cad += '<table class="table table-striped"><thead><th>Operacion</th><th>Leyenda</th><th>Nro Doc</th><th>Apellido</th><th>Nombres</th><th>Usuario</th><th>Fecha</th><th>Equipo</th><th>Ver</th></thead><tbody>';
				for(var k in response.data) {
					cad += '<tr><td>' + response.data[k].operacion + '</td><td>' + response.data[k].leyenda + '</td><td>' + response.data[k].nrodocumento + '</td><td>' + response.data[k].apellido + '</td><td>' + response.data[k].nombres + '</td><td>' + response.data[k].usuario + '</td><td>' + response.data[k].fecha + '</td><td>' + response.data[k].idequipo + ' - ' + response.data[k].nombreequipo + '</td><td><button type="button" class="btn btn-success varDetalleAuditoria" id="' + response.data[k].id + '" style="margin-left:0px;">Ver</button></td></tr>';
					//console.log(response.data[k].fecha);
				}

				cad += '</tbody></table>';

				$('.lstMovimientos').html(cad);
			}
		});
	}


	$('.lstMovimientos').on("click",'.varDetalleAuditoria', function(){
		 id =  $(this).attr("id");

		 $.ajax({
			data:  {id: id, accion: 'traerDetalleAuditoria'},
			url:   '../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
				$('#detalleAuditoria').html('');
			},
			success:  function (response) {
					$('#detalleAuditoria').html(response);
					$('#myModalAuditoria').modal();

			}
		});
	});//fin del boton eliminar

});
</script>
<script type="text/javascript">
/*
$('.form_date').datetimepicker({
	language:  'es',
	weekStart: 1,
	todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 0,
	format: 'dd/mm/yyyy'
});
*/
</script>

<script>
  $(function() {
	  $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);

    $( "#reffechadesde1" ).datepicker();
    $( "#reffechadesde1" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#reffechahasta1" ).datepicker();
    $( "#reffechahasta1" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#reffechadesde2" ).datepicker();
    $( "#reffechadesde2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#reffechahasta2" ).datepicker();
    $( "#reffechahasta2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#fechadesde3" ).datepicker();
    $( "#fechadesde3" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#fechadesde4" ).datepicker();
    $( "#fechadesde4" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#fechadesde5" ).datepicker();
    $( "#fechadesde5" ).datepicker( "option", "dateFormat", "yy-mm-dd" );


	$( "#fechahasta1" ).datepicker();
    $( "#fechahasta1" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#fechahasta2" ).datepicker();
    $( "#fechahasta2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#fechahasta3" ).datepicker();
    $( "#fechahasta3" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#fechahasta4" ).datepicker();
    $( "#fechahasta4" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#fechahasta5" ).datepicker();
    $( "#fechahasta5" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

  });
  </script>

  <script src="../../js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }


  </script>
<?php } ?>
</body>
</html>
