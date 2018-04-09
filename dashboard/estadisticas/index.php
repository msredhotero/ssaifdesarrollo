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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../estadisticas/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Carga de Partidos",$_SESSION['refroll_predio'],$_SESSION['email_predio']);

$resFixture		=	$serviciosReferencias->traerFixtureTodo();
$cadFix			=	$serviciosFunciones->devolverSelectBox($resFixture,array(0,1,4,5,10),' - ');



$refCanchas		=	$serviciosReferencias->traerCanchas();

$cadCanchas	=	$serviciosFunciones->devolverSelectBox($refCanchas,array(2),'');	



$refArbitros	=	$serviciosReferencias->traerArbitros();

$cadArbitros	=	$serviciosFunciones->devolverSelectBox($refArbitros,array(1),'');	

$resTorneosActivos = $serviciosReferencias->traerTorneosActivos();
$cadRefTorneosActivos = $serviciosFunciones->devolverSelectBox($resTorneosActivos,array(1,2,3,4,5),' - ');

$resTemporadas	=	$serviciosReferencias->traerTemporadas();
$cadRefTemporadas	=	$serviciosFunciones->devolverSelectBox($resTemporadas,array(1),'');

$resCategorias	=	$serviciosReferencias->traerCategorias();
$cadRefCategorias	=	$serviciosFunciones->devolverSelectBox($resCategorias,array(1),'');

$resDivisiones	=	$serviciosReferencias->traerDivisiones();
$cadRefDivisiones	=	$serviciosFunciones->devolverSelectBox($resDivisiones,array(1),'');

$resCountries	=	$serviciosReferencias->traerCountries();
$cadRefCountries	=	$serviciosFunciones->devolverSelectBox($resCountries,array(1),'');

$resProximasFechas	= $serviciosReferencias->traerProximaFechaTodos();
if ($_SESSION['refroll_predio'] != 1) {

} else {

	
}


?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Gesti&oacute;n: AIF</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="../../css/chosen.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>

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

<h3>Carga de Partidos</h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Buscar Partido</p>
        	
        </div>
    	<div class="cuerpoBox" style="padding-right:10px;">
    		<form class="form-inline formulario" role="form">
        	<div class="row">
            	<?php if ($_SESSION['idroll_predio'] != 1) { ?>
                <div class="alert alert-warning" style="margin:10px 20px;">
                	<p><span class="glyphicon glyphicon-info-sign"></span> Si es redireccionado cuando busca el numero del partido es porque ya fue finalizada la carga por la AIF</p>
                </div>
                <br>
                <?php } ?>
				<div class="col-md-6">
                    <label class="control-label">Ingrese el Numero de Partido</label>
                    <div class="input-group">
                        <input class="form-control" type="text" name="buscar" id="buscar"/>
                        <button type="button" class="btn btn-success" id="busqueda">Buscar</button>
                    </div>
                </div>
				<?php if ($_SESSION['idroll_predio'] == 1) { ?>
				<div class="col-md-6">
                    <label class="control-label">Ingrese el Numero de Partido</label>
                    <div class="input-group">
                        <select class="form-control" id="fixture" name="fixture">
                        	<?php echo $cadFix; ?>	
                        </select>
                        <button type="button" class="btn btn-success" id="ir">Ir</button>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php if ($_SESSION['idroll_predio'] == 1) { ?>
            <div class='row' style="margin-left:15px; margin-right:15px; margin-top:10px;">
            	<h2>Proximas Fechas</h2>
                <div class="row">

                
                <div class="form-group col-md-6">
                    <label class="control-label" style="text-align:left" for="refcliente">Temporada</label>
                    <div class="input-group col-md-12">
                    	<select id="reftemporada1" class="form-control" name="reftemporada1">
                        	<option value="0">-- Seleccione --</option>
							<?php echo $cadRefTemporadas; ?>
                    	</select>
                    </div>
                </div>
                
                
                
                
                <div class="form-group col-md-6">
                    <label class="control-label" style="text-align:left" for="refcliente">Countrie</label>
                    <div class="input-group col-md-12">
                    	<select id="refcountries1" class="form-control" name="refcountries1">
                        	<option value="0">-- Seleccione --</option>
							<?php echo $cadRefCountries; ?>
                    	</select>
                    </div>
                </div>
                
                <div class="form-group col-md-3">
                    <label class="control-label" style="text-align:left" for="refcliente">Categorias</label>
                    <div class="input-group col-md-12">
                    	<select id="refcategorias1" class="form-control" name="refcategorias1">
                        	<option value="0">-- Seleccione --</option>
							<?php echo $cadRefCategorias; ?>
                    	</select>
                    </div>
                </div>
                
                
                <div class="form-group col-md-3">
                    <label class="control-label" style="text-align:left" for="refcliente">Division</label>
                    <div class="input-group col-md-12">
                    	<select id="refdivision1" class="form-control" name="refdivision1">
                        	<option value="0">-- Seleccione --</option>
							<?php echo $cadRefDivisiones; ?>
                    	</select>
                    </div>
                </div>
            	<div class="form-group col-md-6">
                    <label class="control-label" style="text-align:left" for="refcliente">Torneos</label>
                    <div class="input-group col-md-12">
                    	<select id="reftorneo3" class="form-control" name="reftorneo3">
                        	<option value="0">-- Seleccione --</option>
							<?php echo $cadRefTorneosActivos; ?>
                    	</select>
                    </div>
                </div>
                
                <div class="form-group col-md-2">
                    <label class="control-label" style="text-align:left" for="refcliente">Fechas</label>
                    <div class="input-group col-md-12">
                    	<select id="reffechas3" class="form-control" name="reffechas3">
							<option value="0">-- Seleccione --</option>
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
                
                
                <div class="form-group col-md-6">
                    <label class="control-label" style="text-align:left" for="refcliente">Acción</label>

                    	<ul class="list-inline">
                        	<li>
                    			<button type="button" class="btn btn-primary" id="filtros" style="margin-left:0px;">Buscar</button>
                            </li>

                        </ul>

                </div>
                
				<div id="proxima">
                
                </div>
            </div>
            
            </div>
            <?php } ?>
            <div class='row' style="margin-left:15px; margin-right:15px;">
                <div class='alert'>
                	
                </div>
                <div class='alert alert2'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
			

            </form>
    	</div>
    </div>



   
</div>

<!-- Modal del guardar-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Guardar Partido</h4>
        </div>
        <div class="modal-body">
          <p id="error"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

</div>

</div>






<script type="text/javascript">
$(document).ready(function(){
	

	

	$("#proxima").on("click",'.guardarPartidoSimple', function(){
		
		idBtn = $(this).attr("id");
		var esresaltado = 0;
		if ($('#esresaltado'+$(this).attr("id")).prop('checked')) {
			esresaltado = 1;	
		}
		
		var esdestacado = 0;
		if ($('#esdestacado'+$(this).attr("id")).prop('checked')) {
			esdestacado = 1;	
		}
		
		$('#myModal').modal("show");
        $.ajax({
			data:  {idfixture: $(this).attr("id"), 
					fecha: $('#fecha'+$(this).attr("id")).val(), 
					hora: $('#hora'+$(this).attr("id")).val(), 
					cancha: $('#refcanchas'+$(this).attr("id")).val(), 
					esresaltado: esresaltado, 
					esdestacado: esdestacado, 
					accion: 'guardarPartidoSimple'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
				if (response == '') {
					$('#error').html('<span class="glyphicon glyphicon-ok"></span> Se guardo correctamente');
					$('#'+idBtn).removeClass("btn-primary");
					$('#'+idBtn).addClass("btn-success");
					$('#'+idBtn).html('<span class="glyphicon glyphicon-ok"></span> Guardado');
					
				} else {
					$('#error').html('Huvo un error al guardar los datos, verifique los datos ingresados '.response);
					$('#'+idBtn).removeClass("btn-primary");
					$('#'+idBtn).addClass("btn-danger");
					$('#'+idBtn).html('<span class="glyphicon glyphicon-ban-circle"></span> Guardar');
				}
			}
		});
    });									
										
	$('#busqueda').click(function(e) {
		
        $.ajax({
			data:  {id: $('#buscar').val(), accion: 'buscarPartido'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
				if (response > 0) {
					url = "estadisticas.php?id="+response;
					$(location).attr('href',url);
				} else {
					$(".alert").removeClass("alert-danger");
					$(".alert").addClass("alert-danger");
					$(".alert").html('<strong>Error!</strong> No se encontro el partido');
					$("#load").html('');
				}
			}
		});
    });
	
	$('#filtros').click(function(e) {
		
        $.ajax({
			data:  {reftemporada1: $('#reftemporada1').val(), 
					refcountries1: $('#refcountries1').val(), 
					refcategorias1: $('#refcategorias1').val(), 
					refdivision1: $('#refdivision1').val(), 
					reftorneo3: $('#reftorneo3').val(), 
					reffechas3: $('#reffechas3').val(), 
					reffechadesde1: $('#reffechadesde1').val(), 
					reffechahasta1: $('#reffechahasta1').val(), 
					accion: 'filtrosGenerales'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
				$('#proxima').html(response);
				
				$(".hora").each(function(intIndex) {
					$(this).mask("99:99",{placeholder:"hh:mm"});
				});
				
				$(".fecha").each(function(intIndex) {
					$(this).mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
				});
			}
		});
    });
	
	$('#ir').click(function() {
		url = "estadisticas.php?id="+ $('#fixture').val();
		$(location).attr('href',url);
	});
	
	function traerFechasPorTorneos(idTorneo, contenedor) {
		$.ajax({
				data:  {idTorneo: idTorneo,
						accion: 'traerFechasPorTorneos'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {

                    if (response != '') {
						$('#'+contenedor).html(response);
                    } else {

                        
                        $('#'+contenedor).html('<option value="1">Fecha 1</option> \
                                    <option value="2">Fecha 2</option> \
                                    <option value="3">Fecha 3</option> \
                                    <option value="4">Fecha 4</option> \
                                    <option value="5">Fecha 5</option> \
                                    <option value="6">Fecha 6</option> \
                                    <option value="7">Fecha 7</option> \
                                    <option value="8">Fecha 8</option> \
                                    <option value="9">Fecha 9</option> \
                                    <option value="10">Fecha 10</option> \
                                    <option value="11">Fecha 11</option> \
                                    <option value="12">Fecha 12</option> \
                                    <option value="13">Fecha 13</option> \
                                    <option value="14">Fecha 14</option> \
                                    <option value="15">Fecha 15</option> \
                                    <option value="16">Fecha 16</option> \
                                    <option value="17">Fecha 17</option> \
                                    <option value="18">Fecha 18</option> \
                                    <option value="19">Fecha 19</option> \
                                    <option value="20">Fecha 20</option> \
                                    <option value="21">Fecha 21</option> \
                                    <option value="22">Fecha 22</option> \
                                    <option value="23">Fecha 23</option> \
                                    <option value="24">Fecha 24</option> \
                                    <option value="25">Fecha 25</option> \
                                    <option value="26">Fecha 26</option> \
                                    <option value="27">Fecha 27</option> \
                                    <option value="28">Fecha 28</option> \
                                    <option value="29">Fecha 29</option> \
                                    <option value="30">Fecha 30</option>');
                        
                    } 
                }
		});
	}
	
	$('#reftorneo1').change(function(e) {
		traerFechasPorTorneos($(this).val(),'reffechas1');	
	});
	
	$('#reftorneo3').change(function(e) {
		traerFechasPorTorneos($(this).val(),'reffechas3');	
	});
	
	traerFechasPorTorneos($('#reftorneo1').val(),'reffechas1');

});
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
