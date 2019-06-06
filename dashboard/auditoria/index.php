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

$serviciosUsuario = new ServiciosUsuarios();
$serviciosHTML = new ServiciosHTML();
$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

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


                <div class="form-group col-md-12" style="height:220px;">* Se aplicaran filtros a las busquedas</div>



                <div class="form-group col-md-6">
                    <label class="control-label" style="text-align:left" for="refcliente">Acción</label>

                    	<ul class="list-inline">
                        	<li>
                    			<button type="button" class="btn btn-success" id="rptRP" style="margin-left:0px;">Generar</button>
                            </li>

                        </ul>
                </div>


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







</div>


</div>

<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>
<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){


	$("#valorfechaalta").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
	$("#valorfechanacimiento").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});

	$("#valorfechaalta2").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
	$("#valorfechanacimiento2").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});

	$('#cjrefcountries').change(function(e) {

		$.ajax({
				data:  {id: $('#cjrefcountries').val(),
						accion: 'traerEquiposPorCountries'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
					$('#cjrefequipos').html('');
				},
				success:  function (response) {

                    if (response != '') {
						$('#cjrefequipos').prepend('<option value="">-- Seleccionar --</option>');
						$('#cjrefequipos').append(response);

                    } else {

                        $('#cjrefequipos').html('<option value="">-- Seleccionar --</option>');

                    }
                }
		});
    });

	function traerFechasPorTorneos(idTorneo, contenedor) {
		$.ajax({
				data:  {idTorneo: idTorneo,
						accion: 'traerFechasPorTorneos'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
					$('#'+contenedor).html('');
				},
				success:  function (response) {

                    if (response != '') {
						$('#'+contenedor).prepend('<option value="">-- Seleccionar --</option>');
						$('#'+contenedor).append(response);

                    } else {


                        $('#'+contenedor).html('<option value="">-- Seleccionar --</option> \
                                    <option value="1">Fecha 1</option> \
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

	$('#ffa1').hide();
	$('#ffn1').hide();
	$('#fed1').hide();
	$('#fmj1').hide();
	$('#fmn1').hide();

	$('#rptJugadoresPorClub').click(function(e) {
		if ($('#refcountries1').val() != 0) {
        	url = "../jugadoresclub/index.php?id=" + $('#refcountries1').val();
			$(location).attr('href',url);
		} else {
			alert('Debe seleccionar un country!!.');
		}
    });


	$('#tiporeporte').change(function() {
		switch(parseInt($('#tiporeporte').val())) {
			case 1:
				$('#cou1').hide();
				$('#jug1').hide();
				$('#baj1').hide();
				$('#cat1').show();
				$('#div1').show();
				$('#tor1').show();
				$('#tem1').show();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
				$('#ffa1').hide();
				$('#ffn1').hide();
				$('#fed1').hide();
				$('#fmj1').hide();
				$('#fmn1').hide();
				break;
			case 2:
				$('#cou1').show();
				$('#jug1').hide();
				$('#baj1').show();
				$('#cat1').hide();
				$('#div1').hide();
				$('#tor1').hide();
				$('#tem1').show();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
				$('#ffa1').hide();
				$('#ffn1').hide();
				$('#fed1').hide();
				$('#fmj1').hide();
				$('#fmn1').hide();
				break;
			case 10:
				$('#cou1').show();
				$('#jug1').hide();
				$('#baj1').show();
				$('#cat1').hide();
				$('#div1').hide();
				$('#tor1').hide();
				$('#tem1').show();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
				$('#ffa1').hide();
				$('#ffn1').hide();
				$('#fed1').hide();
				$('#fmj1').hide();
				$('#fmn1').hide();
				break;
			case 3:
				$('#cou1').hide();
				$('#jug1').hide();
				$('#baj1').hide();
				$('#cat1').hide();
				$('#div1').hide();
				$('#tor1').hide();
				$('#tem1').show();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
				$('#ffa1').hide();
				$('#ffn1').hide();
				$('#fed1').hide();
				$('#fmj1').hide();
				$('#fmn1').hide();
				break;
			case 4:
				$('#cou1').hide();
				$('#jug1').hide();
				$('#baj1').hide();
				$('#cat1').hide();
				$('#div1').hide();
				$('#tor1').hide();
				$('#tem1').show();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
				$('#ffa1').hide();
				$('#ffn1').hide();
				$('#fed1').hide();
				$('#fmj1').hide();
				$('#fmn1').hide();
				break;
			case 5:
				$('#cou1').hide();
				$('#jug1').hide();
				$('#baj1').hide();
				$('#cat1').hide();
				$('#div1').hide();
				$('#tor1').hide();
				$('#tem1').show();
                $('#fpa1').show();
                $('#fam1').show();
                $('#fra1').show();
				$('#ffa1').hide();
				$('#ffn1').hide();
				$('#fed1').hide();
				$('#fmj1').hide();
				$('#fmn1').hide();
				break;
			case 6:
				$('#cou1').hide();
				$('#jug1').hide();
				$('#baj1').hide();
				$('#cat1').hide();
				$('#div1').hide();
				$('#tor1').hide();
				$('#tem1').hide();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
				$('#ffa1').hide();
				$('#ffn1').hide();
				$('#fed1').hide();
				$('#fmj1').hide();
				$('#fmn1').hide();
				break;
			case 7:
				$('#cou1').hide();
				$('#jug1').hide();
				$('#baj1').hide();
				$('#cat1').show();
				$('#div1').show();
				$('#tor1').show();
				$('#tem1').show();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
				$('#ffa1').hide();
				$('#ffn1').hide();
				$('#fed1').hide();
				$('#fmj1').hide();
				$('#fmn1').hide();
				break;
			case 8:
				$('#cou1').hide();
				$('#jug1').hide();
				$('#baj1').hide();
				$('#cat1').hide();
				$('#div1').hide();
				$('#tor1').hide();
				$('#tem1').hide();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
				$('#ffa1').hide();
				$('#ffn1').hide();
				$('#fed1').hide();
				$('#fmj1').hide();
				$('#fmn1').hide();
				break;
			case 9:
				$('#cou1').hide();
				$('#jug1').show();
				$('#baj1').hide();
				$('#cat1').show();
				$('#div1').show();
				$('#tor1').show();
				$('#tem1').show();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
				$('#ffa1').hide();
				$('#ffn1').hide();
				$('#fed1').hide();
				$('#fmj1').hide();
				$('#fmn1').hide();
				break;
			case 11:
				$('#cou1').hide();
				$('#jug1').hide();
				$('#baj1').hide();
				$('#cat1').show();
				$('#div1').show();
				$('#tor1').hide();
				$('#tem1').show();
                $('#fpa1').show();
                $('#fam1').show();
                $('#fra1').show();
				$('#ffa1').show();
				$('#ffn1').show();
				$('#fed1').show();
				$('#fmj1').show();
				$('#fmn1').show();
				break;
            case 12:
                $('#cou1').hide();
                $('#jug1').hide();
                $('#baj1').hide();
                $('#cat1').hide();
                $('#div1').hide();
                $('#tor1').hide();
                $('#tem1').show();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
                $('#ffa1').hide();
                $('#ffn1').hide();
                $('#fed1').hide();
                $('#fmj1').hide();
                $('#fmn1').hide();
                break;
            case 13:
                $('#cou1').hide();
                $('#jug1').hide();
                $('#baj1').hide();
                $('#cat1').show();
                $('#div1').show();
                $('#tor1').hide();
                $('#tem1').show();
                $('#fpa1').hide();
                $('#fam1').hide();
                $('#fra1').hide();
                $('#ffa1').hide();
                $('#ffn1').hide();
                $('#fed1').hide();
                $('#fmj1').hide();
                $('#fmn1').hide();
                break;
				 case 14:
	 				$('#cou1').hide();
	 				$('#jug1').hide();
	 				$('#baj1').hide();
	 				$('#cat1').hide();
	 				$('#div1').hide();
	 				$('#tor1').hide();
	 				$('#tem1').show();
	                 $('#fpa1').hide();
	                 $('#fam1').hide();
	                 $('#fra1').hide();
	 				$('#ffa1').hide();
	 				$('#ffn1').hide();
	 				$('#fed1').hide();
	 				$('#fmj1').hide();
	 				$('#fmn1').hide();
	 				break;
			default:
				alert('Debe elegir una opcion');
		}
	});

	$('#reftorneo1').change(function(e) {
		traerFechasPorTorneos($(this).val(),'reffechas1');
	});

	$('#reftorneo3').change(function(e) {
		traerFechasPorTorneos($(this).val(),'reffechas3');
	});

	traerFechasPorTorneos($('#reftorneo1').val(),'reffechas1');


	$("#rptRP").click(function(event) {
		var e = parseInt($('#tiporeporte').val());

		switch(e) {
			case 1:
				window.open("../../reportes/rptResultadoPartido.php?reftemporada1=" + $("#reftemporada1").val() + "&reftorneo3="+ $("#reftorneo3").val() + "&reffechas3="+ $("#reffechas3").val() + "&refcategorias1="+ $("#refcategorias1").val() + "&refdivision1="+ $("#refdivision1").val() + "&reffechadesde1=" + $('#reffechadesde1').val() + "&reffechahasta1="+ $('#reffechahasta1').val() ,'_blank');
				break;
			case 2:
				window.open("../../reportes/rptJugadoresPorCountries.php?refcountries1=" + $("#refcountries1").val() + "&bajas1=" + $("#baja").prop('checked') ,'_blank');

				break;
			case 10:

                window.open("../../reportes/rptJugadoresPorCountriesExcel.php?refcountries1=" + $("#refcountries1").val() + "&bajas1=" + $("#baja").prop('checked') ,'_blank');
				break;
			case 3:
				window.open("../../reportes/rptJugadoresVariosEquipos.php?reftemporada1=" + $("#reftemporada1").val() ,'_blank');
				break;
			case 4:
				window.open("../../reportes/rptPromedioCanchas.php?reftemporada1=" + $("#reftemporada1").val() ,'_blank');
				break;
            case 5:
                window.open("../../reportes/rptEstadisticaArbitros.php?reftemporada1=" + $("#reftemporada1").val() + '&filtropartidos=' + $('#filtropartidos').val() + '&filtropartidosvalor=' + $('#valorpartido').val() + '&filtropartidosvalor2=' + $('#valorpartido2').val() + '&filtroamarillas=' + $('#filtroamarillas').val() + '&filtroamarillasvalor=' + $('#valoramarillas').val() + '&filtroamarillasvalor2=' + $('#valoramarillas2').val() + '&filtrorojas=' + $('#filtrorojas').val() + '&filtrorojasvalor=' + $('#valorrojas').val() + '&filtrorojasvalor2=' + $('#valorrojas2').val(),'_blank');
                break;
            case 6:
                window.open("../../reportes/rptSuspendidosExcel.php" ,'_blank');
                break;
			case 7:
                window.open("../../reportes/rptProximaFecha.php?reffechadesde1=" + $('#reffechadesde1').val() + "&reffechahasta1="+ $('#reffechahasta1').val() ,'_blank');
                break;
			case 8:
				window.open("../../reportes/rptActaTribunalDisciplina.php" ,'_blank');
                break;
            case 9:
                window.open("../../reportes/rptHistoricoJugadorIncidencias.php?reftemporada1=" + $("#reftemporada1").val() + "&reftorneo3="+ $("#reftorneo3").val() + "&idjugador="+ $("#idjugador").val() + "&refcategorias1="+ $("#refcategorias1").val() + "&refdivision1="+ $("#refdivision1").val() ,'_blank');
                break;
			case 11:
                window.open("../../reportes/rptEstadisticaJugadorPorCategoria.php?reftemporada1=" + $("#reftemporada1").val() + "&refcategorias1="+ $("#refcategorias1").val() + "&refdivision1="+ $("#refdivision1").val() + '&filtropartidos=' + $('#filtropartidos').val() + '&filtropartidosvalor=' + $('#valorpartido').val() + '&filtropartidosvalor2=' + $('#valorpartido2').val() + '&filtroamarillas=' + $('#filtroamarillas').val() + '&filtroamarillasvalor=' + $('#valoramarillas').val() + '&filtroamarillasvalor2=' + $('#valoramarillas2').val() + '&filtrorojas=' + $('#filtrorojas').val() + '&filtrorojasvalor=' + $('#valorrojas').val() + '&filtrorojasvalor2=' + $('#valorrojas2').val() + '&filtrofechaalta=' + $('#filtrofechaalta').val() + '&filtrofechaaltavalor=' + $('#valorfechaalta').val() + '&filtrofechaaltavalor2=' + $('#valorfechaalta2').val() + '&filtrofechanacimiento=' + $('#filtrofechanacimiento').val() + '&filtrofechanacimientovalor=' + $('#valorfechanacimiento').val() + '&filtrofechanacimientovalor2=' + $('#valorfechanacimiento2').val() + '&filtroedad=' + $('#filtroedad').val() + '&filtroedadvalor=' + $('#valoredad').val() + '&filtroedadvalor2=' + $('#valoredad2').val() + '&filtromejorjugador=' + $('#filtromejorjugador').val() + '&filtromejorjugadorvalor=' + $('#valormejorjugador').val()  + '&filtromejorjugadorvalor2=' + $('#valormejorjugador2').val()+ '&filtrominutos=' + $('#filtrominutos').val() + '&filtrominutosvalor=' + $('#valorminutos').val() + '&filtrominutosvalor2=' + $('#valorminutos2').val(),'_blank');
                break;
            case 12:
                window.open("../../reportes/rptHabilitacionesTransitoriasExcel.php?reftemporada1=" + $("#reftemporada1").val() ,'_blank');
                break;
            case 13:
                window.open("../../reportes/rptJugadoresPorPartidos.php?reftemporada1=" + $("#reftemporada1").val() + "&refcategorias1="+ $("#refcategorias1").val() + "&refdivision1="+ $("#refdivision1").val() ,'_blank');
                break;
				case 14:
					window.open("../../reportes/rptJugadoresVariosEquiposExcel.php?reftemporada1=" + $("#reftemporada1").val() ,'_blank');
					break;

			default:
				alert('Debe elegir una opcion');
		}


    });


	$("#rptCJ").click(function(event) {

		if (($("#cjrefcountries").val() != 0) && ($("#cjrefcountries").val() != null)) {
        	window.open("../../reportes/rptCondicionJugador.php?id=" + $("#cjrefequipos").val() + "&reftemporada=" + $("#cjreftemporada").val() + "&bajaequipos=" + $("#bajaequipos").prop('checked') + "&refcountries=" + $('#cjrefcountries').val() ,'_blank');
		} else {
			alert('Debe elegir un equipo');
		}

    });

	$("#rptPP").click(function(event) {
        if ($("#reftorneo1").val() == 0) {
            window.open("../../reportes/rptPlanillaTodas.php?reffechas=" + $("#reffechas1").val() + "&desde=" + $('#reffechadesde2').val() + "&hasta=" + $('#reffechahasta2').val() ,'_blank');
        } else {
            window.open("../../reportes/rptPlanilla.php?idtorneo=" + $("#reftorneo1").val() + "&reffechas=" + $("#reffechas1").val() ,'_blank');
        }


    });


	$("#rptsc").click(function(event) {
        window.open("../../reportes/rptSaldosClientes.php?idEmp=" + $("#refempresa2").val() + "&fechadesde=" + $("#fechadesde2").val()+ "&fechahasta=" + $("#fechahasta2").val(),'_blank');

    });

	$("#rptscc").click(function(event) {
        window.open("../../reportes/rptSaldosPorClientes.php?idEmp=" + $("#refempresa4").val() + "&idClie=" + $("#refcliente1").val() + "&fechadesde=" + $("#fechadesde3").val()+ "&fechahasta=" + $("#fechahasta3").val(),'_blank');

    });

	$('#rptcc').click(function(e) {
        window.open("../../reportes/rptSaldosEmpresa.php?fechadesde=" + $("#fechadesde4").val()+ "&fechahasta=" + $("#fechahasta4").val(),'_blank');
    });

	$("#rpt5").click(function(event) {
        window.open("../../reportes/rptSaldosClientesEmpresas.php?idClie=" + $("#refcliente5").val() + "&fechadesde=" + $("#fechadesde5").val()+ "&fechahasta=" + $("#fechahasta5").val(),'_blank');

    });


	$("#rpt6").click(function(event) {
        window.open("../../reportes/rptSociosEmpresas.php",'_blank');

    });

	$("#rpt7").click(function(event) {
        window.open("../../reportes/rptSocios.php",'_blank');

    });





	$("#rptgfExcel").click(function(event) {
        window.open("../../reportes/rptFacturacionGeneralExcel.php?id=" + $("#refempresa1").val() + "&fechadesde=" + $("#fechadesde1").val()+ "&fechahasta=" + $("#fechahasta1").val(),'_blank');

    });

	$("#rptscExcel").click(function(event) {
        window.open("../../reportes/rptSaldosClientesExcel.php?idEmp=" + $("#refempresa2").val() + "&fechadesde=" + $("#fechadesde2").val()+ "&fechahasta=" + $("#fechahasta2").val(),'_blank');

    });

	$("#rptsccExcel").click(function(event) {
        window.open("../../reportes/rptSaldosPorClientesExcel.php?idEmp=" + $("#refempresa4").val() + "&idClie=" + $("#refcliente1").val() + "&fechadesde=" + $("#fechadesde3").val()+ "&fechahasta=" + $("#fechahasta3").val(),'_blank');

    });

	$('#rptccExcel').click(function(e) {
        window.open("../../reportes/rptSaldosEmpresaExcel.php?fechadesde=" + $("#fechadesde4").val()+ "&fechahasta=" + $("#fechahasta4").val(),'_blank');
    });

	$("#rpt5Excel").click(function(event) {
        window.open("../../reportes/rptSaldosClientesEmpresasExcel.php?idClie=" + $("#refcliente5").val() + "&fechadesde=" + $("#fechadesde5").val()+ "&fechahasta=" + $("#fechahasta5").val(),'_blank');

    });

	$("#rpt6Excel").click(function(event) {
        window.open("../../reportes/rptSociosEmpresasExcel.php",'_blank');

    });

	$("#rpt7Excel").click(function(event) {
        window.open("../../reportes/rptSociosExcel.php",'_blank');

    });

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
