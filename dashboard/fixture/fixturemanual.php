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


$idTorneo = $_GET['id'];

$fechainicio = date('d/m/Y');

$resTorneos = $serviciosReferencias->traerTorneosPorId($idTorneo);
$tipoTorneo = mysql_result($resTorneos,0,'reftipotorneo');

$resEquipos = $serviciosReferencias->traerEquipoPorTorneo($idTorneo);

if ((mysql_num_rows($resEquipos) % 2) == 0) {
	$cantidadFechas = ($resEquipos / 2) * $tipoTorneo;	
} else {
	$cantidadFechas = (($resEquipos / 2) + 1) * $tipoTorneo;
}

$idCategoria = mysql_result($resTorneos,0,'refcategorias');

$idTemporada = mysql_result($serviciosReferencias->traerUltimaTemporada(),0,0);

// dia que se juega los partidos
$resDias = $serviciosReferencias->traerDefinicionescategoriastemporadasPorTemporadaCategoria($idTemporada, $idCategoria);

// dia que ponen para comenzar el torneo
$fechainicio = $serviciosFunciones->formatearFechas($fechainicio);
$numeroDia = date('w', strtotime($fechainicio));

//die(var_dump($serviciosFunciones->formatearFechas($fechainicio)));


switch ($numeroDia) {
	case 0:
		$numeroDia = 7;
		break;
	case 1:
		$numeroDia = 1;
		break;
	case 2:
		$numeroDia = 2;
		break;
	case 3:
		$numeroDia = 3;
		break;
	case 4:
		$numeroDia = 4;
		break;
	case 5:
		$numeroDia = 5;
		break;
	case 6:
		$numeroDia = 6;
		break;	
}
//die(var_dump($numeroDia));

$fechaNueva = date_create($fechainicio);

if (mysql_num_rows($resDias)>0) {
	if ($numeroDia > mysql_result($resDias,0,'refdias')) {
		$nuevoNumero = 7 - $numeroDia + mysql_result($resDias,0,'refdias');
		
		date_add($fechaNueva, date_interval_create_from_date_string($nuevoNumero.' days'));
	} else {
		if ($numeroDia == mysql_result($resDias,0,'refdias')) {
			$fechaNueva = $fechaNueva;
		} else {
			$nuevoNumero = mysql_result($resDias,0,'refdias') - $numeroDia;
		
			date_add($fechaNueva, date_interval_create_from_date_string('+'.$nuevoNumero.' days'));
		}
	}
	//die(var_dump($fechaNueva));
	$hora = mysql_result($resDias,0,'hora');
} else {
	$hora = '15:30';
}


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbfixture";

$lblCambio	 	= array("refconectorlocal","goleslocal","refconectorvisitante","golesvisitantes","fecha","reffechas","refcanchas","refarbitros","refestadospartidos","reftorneos");
$lblreemplazo	= array("Equipo Local","Resultado 1","Equipo Visitante","Resultado 2","Fecha Juego","Fecha","Cancha","Arbitros","Estados Partidos","Torneo");


$cadRef			=	$serviciosFunciones->devolverSelectBox($resEquipos,array(1,2)," - ");

$resFechas		=	$serviciosReferencias->traerFechas();
$cadRef2		=	$serviciosFunciones->devolverSelectBox($resFechas,array(1),'');

$resCanchas		=	$serviciosReferencias->traerCanchas();
$cadRef3		=	'<option value="">-- seleccionar --</option>';
$cadRef3		=	$serviciosFunciones->devolverSelectBox($resCanchas,array(1),'');

$resArbitros	=	$serviciosReferencias->traerArbitros();
$cadRef4		=	'<option value="">-- seleccionar --</option>';
$cadRef4		=	$serviciosFunciones->devolverSelectBox($resArbitros,array(1),'');

$resEstadosP	=	$serviciosReferencias->traerEstadospartidos();
$cadRef5		=	'<option value="">-- seleccionar --</option>';
$cadRef5		.=	$serviciosFunciones->devolverSelectBox($resEstadosP,array(1),'');

$resTorneos		=	$serviciosReferencias->traerTorneos();
$cadRef6		=	$serviciosFunciones->devolverSelectBox($resTorneos,array(1,2),' - ');

$refdescripcion = array(0 => $cadRef,1=>$cadRef,2=>$cadRef2,3=>$cadRef3,4=>$cadRef4,5=>$cadRef5,6=>$cadRef6);
$refCampo	 	= array("refconectorlocal","refconectorvisitante","reffechas","refcanchas","refarbitros","refestadospartidos","reftorneos"); 
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  /////////////////////
$cabeceras 		= "	<th>Equipo Local</th>
				<th>Resultado Local</th>
				<th>Resultado Visitante</th>
				<th>Equipo Visitante</th>
				<th>Categoria</th>
				<th>Arbitros</th>
				<th>Juez 1</th>
				<th>Juez 2</th>
				<th>Cancha</th>
				<th>Fecha Juego</th>
				<th>Fecha</th>
				<th>Hora</th>
				<th>Estado</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$fechainicio = $fechaNueva->format('Y-m-d');

?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Gestión: AIF</title>
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
    <link rel="stylesheet" href="../../css/bootstrap-timepicker.css">
    <script src="../../js/bootstrap-timepicker.min.js"></script>
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
    
    <script>

  $(function() {

 //Array para dar formato en español

  $.datepicker.regional['es'] =
  {
  closeText: 'Cerrar',
  prevText: 'Previo',
  nextText: 'Próximo',

  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
  'Jul','Ago','Sep','Oct','Nov','Dic'],
  monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
  dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
  dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
  dateFormat: 'dd/mm/yy', firstDay: 0,
  initStatus: 'Selecciona la fecha', isRTL: false};

 $.datepicker.setDefaults($.datepicker.regional['es']);
 //miDate: fecha de comienzo D=días | M=mes | Y=año
 //maxDate: fecha tope D=días | M=mes | Y=año
    $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+2M +10D" });
	$( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+3M +10D" });
	$( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+4M +10D" });
	$( "#datepicker4" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+5M +10D" });
	$( "#datepicker5" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+6M +10D" });
	$( "#datepicker6" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+7M +10D" });
	$( "#datepicker7" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+8M +10D" });
	$( "#datepicker8" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+9M +10D" });
	$( "#datepicker9" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+10M +10D" });
	$( "#datepicker10" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+11M +10D" });
	$( "#datepicker11" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+12M +10D" });
	$( "#datepicker12" ).datepicker({dateFormat: 'yy-mm-dd', minDate: "", maxDate: "+13M +10D" });
	$( "#datepicker13" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+14M +10D" });
	$( "#datepicker14" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+15M +10D" });
	$( "#datepicker15" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+16M +10D" });
	$( "#datepicker16" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+17M +10D" });
	$( "#datepicker17" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+18M +10D" });
	$( "#datepicker18" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+19M +10D" });
	$( "#datepicker19" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+20M +10D" });
	$( "#datepicker20" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+21M +10D" });
	$( "#datepicker21" ).datepicker({dateFormat: 'yy-mm-dd', minDate: "", maxDate: "+22M +10D" });
	$( "#datepicker22" ).datepicker({dateFormat: 'yy-mm-dd', minDate: "", maxDate: "+23M +10D" });
	$( "#datepicker23" ).datepicker({dateFormat: 'yy-mm-dd', minDate: "", maxDate: "+24M +10D" });
	$( "#datepicker24" ).datepicker({dateFormat: 'yy-mm-dd', minDate: "", maxDate: "+25M +10D" });
	$( "#datepicker25" ).datepicker({dateFormat: 'yy-mm-dd', minDate: "", maxDate: "+26M +10D" });
	$( "#datepicker26" ).datepicker({dateFormat: 'yy-mm-dd', minDate: "", maxDate: "+27M +10D" });
	$( "#datepicker27" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+28M +10D" });
	$( "#datepicker28" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+29M +10D" });
	$( "#datepicker29" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+30M +10D" });
	$( "#datepicker30" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+31M +10D" });
	$( "#datepicker31" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: "", maxDate: "+32M +10D" });
  });
  </script>
</head>

<body>

 
<?php echo $resMenu; ?>

<div id="content">


    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Fixture Manual</p>
        	
        </div>
    	<div class="cuerpoBox">
            <form class="form-inline formulario" role="form" method="POST" action="generarfixturemanual.php">
            	<div class="row" style="margin-left:25px; margin-right:25px;">
                	<p>Tipo de Torneo: <?php echo mysql_result($serviciosReferencias->traerTipotorneoPorId($tipoTorneo),0,1);?></p>
                
                </div>
                    <div class="row" style="margin-left:25px; margin-right:25px;">
                        <?php for ($i=1;$i<= $cantidadFechas;$i++) { ?>
                        <div class="form-group col-md-3">
                        <label class="control-label" style="text-align:left" for="lbl">Equipo Local</label>
                            <div class="input-group col-md-12">
                                <select type="text" id="refconectorlocal<?php echo $i; ?>" name="refconectorlocal<?php echo $i; ?>" class="form-control"/>
                                    <option value="0">-- Seleccionar --</option>
                                    <?php echo $cadRef; ?>
                            
                                </select>
                            </div>
                        </div>




                        <div class="form-group col-md-2">
                        <label class="control-label" style="text-align:left" for="lbl">Hora</label>
                            <div class="input-group col-md-12">
                                <input type="text" id="horario<?php echo $i; ?>" name="horario<?php echo $i; ?>" class="form-control hora" value="<?php echo $hora; ?>"/>
                            </div>
                        </div>





                        <div class="form-group col-md-2">
                        <label class="control-label" style="text-align:left" for="lbl">Fecha Juego</label>
                            <div class="input-group col-md-12">
                                <input type="text" class="form-control" id="datepicker<?php echo $i; ?>" name="datepicker<?php echo $i; ?>" value="<?php echo $fechainicio; ?>" />
                            </div>
                        </div>




                        <div class="form-group col-md-3">
                        <label class="control-label" style="text-align:left" for="lbl">Equipo Visitante</label>
                            <div class="input-group col-md-12">
                                <select type="text" id="refconectorvisitante<?php echo $i; ?>" name="refconectorvisitante<?php echo $i; ?>" class="form-control" required/>
                                    <option value="0">-- Seleccionar --</option>
                                    <?php echo $cadRef; ?>
                            
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-2">
                            <label class="control-label" style="text-align:left" for="lbl">Fecha</label>
                            <div class="input-group col-md-12">
                                <select class="form-control" id="reffechas<?php echo $i; ?>" name="reffechas<?php echo $i; ?>">
                                    <?php echo $cadRef2; ?>
                                </select>
                            </div>
                        </div>
                        
                        <?php
							//$fechainicio = strtotime ( '+7 day' , strtotime ( $fechainicio ) ) ;
							//$fechainicio = date ( 'Y-m-d' , $fechainicio );
						?>
                    <?php } ?>
                    </div>
                
            <div class="row" style="margin-left:25px; margin-right:25px;">
                <div class="alert"> </div>
                <div id="load"> </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                        <button type="submit" class="btn btn-primary" id="cargar" style="margin-left:0px;">Guardar</button>
                    </li>
                    
                </ul>
                </div>
            </div>

            <input type="hidden" name="idtorneo" id="idtorneo" value="<?php echo $idTorneo; ?>"/>
            </form>
    	</div>
    </div>

    
   
</div>


</div>
<div id="dialog2" title="Eliminar Fixture">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea eliminar el fixture?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si elimina el fixture se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>



<script type="text/javascript">
$(document).ready(function(){
    $('.varborrar').click(function(event){
            usersid =  $(this).attr("id");
            if (!isNaN(usersid)) {
                  $("#idEliminar").val(usersid);
                  $("#dialog2").dialog("open");


                  //url = "../clienteseleccionado/index.php?idcliente=" + usersid;
                  //$(location).attr('href',url);
            } else {
                  alert("Error, vuelva a realizar la acción.");	
            }
  });//fin del boton eliminar
  
  $(".hora").mask("99:99",{placeholder:"hh:mm"});
  
  $( "#dialog2" ).dialog({
		 	
			    autoOpen: false,
			 	resizable: false,
				width:600,
				height:240,
				modal: true,
				buttons: {
				    "Eliminar": function() {
	
						$.ajax({
									data:  {id: $('#idEliminar').val(), accion: 'eliminarFixture'},
									url:   '../../ajax/ajax.php',
									type:  'post',
									beforeSend: function () {
											
									},
									success:  function (response) {
											url = "fixturemanual.php";
											$(location).attr('href',url);
											
									}
							});
						$( this ).dialog( "close" );
						$( this ).dialog( "close" );
							$('html, body').animate({
	           					scrollTop: '1000px'
	       					},
	       					1500);
				    },
				    Cancelar: function() {
						$( this ).dialog( "close" );
				    }
				}
		 
		 
	 		}); //fin del dialogo para eliminar

});
</script>
<script type="text/javascript">
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
</script>


<?php } ?>
</body>
</html>


