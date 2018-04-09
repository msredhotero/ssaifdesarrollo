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
include ('../../includes/generadorfixturefijo.php');

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
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Estadisticas",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


$serviciosFunciones->modificarTodasLetra();


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbfixture";

$lblCambio	 	= array("refconectorlocal","goleslocal","refconectorvisitante","golesvisitantes","fecha","reffechas","refcanchas","refarbitros","refestadospartidos","reftorneos");
$lblreemplazo	= array("Equipo Local","Resultado 1","Equipo Visitante","Resultado 2","Fecha Juego","Fecha","Cancha","Arbitros","Estados Partidos","Torneo");

$resConectorL	=	$serviciosReferencias->traerEquipos();
$cadRef			=	$serviciosFunciones->devolverSelectBox($resConectorL,array(1,2)," - ");

$resFechas		=	$serviciosReferencias->traerFechas();
$cadRef2		=	$serviciosFunciones->devolverSelectBox($resFechas,array(1),'');

$resCanchas		=	$serviciosReferencias->traerCanchas();
$cadRef3		=	$serviciosFunciones->devolverSelectBox($resCanchas,array(1),'');

$resArbitros	=	$serviciosReferencias->traerArbitros();
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


$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerFixtureTodo(),13);

$fixtureGenerardo = $Generar->Generar360($_GET['idtorneo'],$_GET['idzona']);

if ((mysql_num_rows($resZonasEquipos) % 2)==0) {
	$cantFechas = mysql_num_rows($resZonasEquipos)-1;
} else {
	$cantFechas = mysql_num_rows($resZonasEquipos);
}
//die(var_dump($cantFechas));
?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Gesti&oacute;n: Tres Sesenta F&uacute;tbol</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<!--<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">-->
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<!--<link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../../css/bootstrap-timepicker.css">-->
    <script src="../../js/bootstrap-timepicker.min.js"></script>
	<style type="text/css">
		* {
		  margin:0;
		  padding:0;
		}
		

		
		#content {
			margin-left:21%;
		}

		#header {
    background-image: -webkit-gradient(
	linear,
	left top,
	left bottom,
	color-stop(0, #454A4E),
	color-stop(1, #464F52)
);
background-image: -o-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: -moz-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: -webkit-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: -ms-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: linear-gradient(to bottom, #454A4E 0%, #464F52 100%);
	background-color:#454A4E;
	height:100px;
	margin:0;
	padding-left:100px;
}

.content {
    height: 100%;
    margin: 20px auto;
    padding: 16px;
    width: 1050px;
}

#navigation {
			height:100%;
			background-color: #f05537;
			padding-top:15px;
			overflow-y: auto;
			position: fixed;
			top: 0;
			width: 20%;
			z-index: 9999;
			overflow: hidden;
			
		}
		
		#navigation #mobile-header {
			text-align:center;
			color: #7A0000;
			font-size:2.0em;
			font-family:Bebas;	
		}
		
		#navigation #mobile-header p {
			color: #fff;
			font-size:1em;
			font-family:  "Courier New", Courier, monospace;
		}
		
		.nav {
			margin-top:-15px;
			/*border-bottom:1px solid #FFD2D2;*/
		}
		.nav ul {
			list-style:none;
		}
		.nav ul li {
			padding-top:15px;
			padding:8px 8px;
			height:44px;
			width:100%;
		}
		
		.nav ul li a {
			color:#FFF;
			font-family:Bebas;
			font-size:1.4em;
			text-decoration:none;
			width:100%;
		}
		
		.nav ul li:hover {
			background: #105c1f; /* Old browsers */
			text-indent:15px;
			-webkit-transition:all 1s ease;
		    -moz-transition:all 1s ease;
		    -o-transition:all 1s ease;
		    transition:all 1s ease;
			text-shadow:1px 1px 1px #006;
		}
		
		.nav .arriba {
			border-top:none;
		}
		.abajo {
			padding-top:-8px;
		}
		
		#infoMenu {
			margin-top:15px;
			padding:8px 2px 1px 10px;
			/*background-color:#7A0000;*/
			background-color: #248dc1; /* Old browsers */

			border-bottom:1px solid #d60000;
			border-top:1px solid #b20000;
		}
		
		#infoMenu p {	
			color: #000;
			font-family: "Coolvetica Rg";
			font-size:16px;
		}
		
		#infoDescrMenu {
			padding:8px;
		}
		
		#infoDescrMenu p {
			color:#FFF;
		}
		
		.icodashboard {
			background:url(../../imagenes/iconmenu/dashboard.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:9px;
			margin-top:-4px;
		}
		
		.icousuarios {
			background:url(../../imagenes/iconmenu/usuarios.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icochart {
			background:url(../../imagenes/iconmenu/chart.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icopagos {
			background:url(../../imagenes/iconmenu/pagos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icosedes {
			background:url(../../imagenes/iconmenu/sedes.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icocanchas {
			background:url(../../imagenes/iconmenu/canchas.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icogoleadores {
			background:url(../../imagenes/iconmenu/gym15.png) no-repeat;
			background-position: center center;
			width:25px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icosuspendidos {
			background:url(../../imagenes/iconmenu/lightning38.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		.icojugadores {
			background:url(../../imagenes/iconmenu/user82.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		.icoamonestados {
			background:url(../../imagenes/iconmenu/user84.png) no-repeat;
			background-position: center center;
			width:25px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		.icoequipos {
			background:url(../../imagenes/iconmenu/users6.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		.icozonasequipos {
			background:url(../../imagenes/iconmenu/users7.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		.icotorneos {
			background:url(../../imagenes/iconmenu/verification5.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icozonas {
			background:url(../../imagenes/iconmenu/conceptos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icofixture {
			background:url(../../imagenes/iconmenu/novedades.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icoplayoff {
			background:url(../../imagenes/iconmenu/playoff.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icofairplay {
			background:url(../../imagenes/iconmenu/exportar.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		/*
		gym15.png
		lightning38.png
		user82.png
		user84.png
		users6.png
		users7.png
		verification5.png
		*/
		.icoalquileres {
			background:url(../../imagenes/iconmenu/alquiler.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icoinmubles {
			background:url(../../imagenes/iconmenu/inmueble.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icoturnos {
			background:url(../../imagenes/iconmenu/turnos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icoventas {
			background:url(../../imagenes/iconmenu/compras.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icoproductos {
			background:url(../../imagenes/iconmenu/barras.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icoreportes {
			background:url(../../imagenes/iconmenu/reportes.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icocontratos {
			background:url(../../imagenes/iconmenu/contratos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}
		
		.icosalir {
			background:url(../../imagenes/iconmenu/salir.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
		}










		.letraChica {
			font-size:12px;
		}
		
  
		
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

 //Array para dar formato en espa�ol

  $.datepicker.regional['es'] =
  {
  closeText: 'Cerrar',
  prevText: 'Previo',
  nextText: 'Pr�ximo',

  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
  'Jul','Ago','Sep','Oct','Nov','Dic'],
  monthStatus: 'Ver otro mes', yearStatus: 'Ver otro a�o',
  dayNames: ['Domingo','Lunes','Martes','Mi�rcoles','Jueves','Viernes','S�bado'],
  dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','S�b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
  dateFormat: 'dd/mm/yy', firstDay: 0,
  initStatus: 'Selecciona la fecha', isRTL: false};

 $.datepicker.setDefaults($.datepicker.regional['es']);
 //miDate: fecha de comienzo D=d�as | M=mes | Y=a�o
 //maxDate: fecha tope D=d�as | M=mes | Y=a�o
    $( "#datepicker1" ).datepicker({ minDate: "", maxDate: "+2M +10D" });
	$( "#datepicker2" ).datepicker({ minDate: "", maxDate: "+3M +10D" });
	$( "#datepicker3" ).datepicker({ minDate: "", maxDate: "+4M +10D" });
	$( "#datepicker4" ).datepicker({ minDate: "", maxDate: "+5M +10D" });
	$( "#datepicker5" ).datepicker({ minDate: "", maxDate: "+6M +10D" });
	$( "#datepicker6" ).datepicker({ minDate: "", maxDate: "+7M +10D" });
	$( "#datepicker7" ).datepicker({ minDate: "", maxDate: "+8M +10D" });
	$( "#datepicker8" ).datepicker({ minDate: "", maxDate: "+9M +10D" });
	$( "#datepicker9" ).datepicker({ minDate: "", maxDate: "+10M +10D" });
	$( "#datepicker10" ).datepicker({ minDate: "", maxDate: "+11M +10D" });
	$( "#datepicker11" ).datepicker({ minDate: "", maxDate: "+12M +10D" });
	$( "#datepicker12" ).datepicker({ minDate: "", maxDate: "+13M +10D" });
	$( "#datepicker13" ).datepicker({ minDate: "", maxDate: "+14M +10D" });
	$( "#datepicker14" ).datepicker({ minDate: "", maxDate: "+15M +10D" });
	$( "#datepicker15" ).datepicker({ minDate: "", maxDate: "+16M +10D" });
	$( "#datepicker16" ).datepicker({ minDate: "", maxDate: "+17M +10D" });
	$( "#datepicker17" ).datepicker({ minDate: "", maxDate: "+18M +10D" });
	$( "#datepicker18" ).datepicker({ minDate: "", maxDate: "+19M +10D" });
	$( "#datepicker19" ).datepicker({ minDate: "", maxDate: "+20M +10D" });
	$( "#datepicker20" ).datepicker({ minDate: "", maxDate: "+21M +10D" });
  });
  </script>

</head>

<body>

 
<?php echo $resMenu; ?>

<div id="content">

<h3>Estadisticas</h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de la Estadisticas</p>
        	
        </div>
    	<div class="cuerpoBox">
    		<form class="form-inline formulario" role="form" method="post" action="generarfixture.php">
            <div class="row" style="margin-left:5px; margin-right:5px; min-width:800px;">
            	<div class="form-group col-md-12">
                	<label class="control-label">Seleccione el orden </label>

                    <bt>
                    <hr>
                </div>
 				<div class="col-md-6">
                	<p>Equipo</p>
                </div>
                <div class="col-md-6">
                	<p>Letra</p>
                </div>
                
				<?php
					$cant = 1;
					$resLetras = $serviciosFunciones->traerLetras();
					$cadL = '';
					while ($rowL = mysql_fetch_array($resLetras)) {
						$cadL .= '<option value="'.$rowL[0].'">'.$rowL[1].'</option>';	
					}
					while ($row = mysql_fetch_array($resZonasEquipos2)) {
				?>
				<div class="col-md-6">
                	<select id="refequipo" name="refequipo" class="form-control">                	
					<?php
                        echo '<option value="'.$row['idtorneoge'].'">'.$row[1].' - '.$row[2]."</option>";
                    ?>
                    </select>
                </div>
                <div class="col-md-6">
					<select id="letra<?php echo $row['idtorneoge']; ?>" class="form-control" name="letra<?php echo $row['idtorneoge']; ?>">                	
					<?php
                        echo $cadL;
                    ?>
                    </select>
                </div>
                
                
                <?php
					$cant += 1;
					}
					echo '<input type="hidden" id="idtorneo" name="idtorneo" value="'.$_GET['idtorneo'].'" />';
					echo '<input type="hidden" id="idzona" name="idzona" value="'.$_GET['idzona'].'" />';
				?>
            </div>
            
            <div class="row" style="margin-left:25px; margin-right:25px;">
                <div class="alert"> </div>
                <div id="load"> </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                    	
                        <button type="submit" class="btn btn-primary" id="cargar" style="margin-left:0px;">Generar</button>
                        
                        <button type="button" class="btn btn-default" id="volver" style="margin-left:0px;">Volver</button>
                    </li>

                </ul>
                </div>
            </div>
            </form>
    	</div>
    </div>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Fixture Cargados</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<?php echo $lstCargados; ?>
    	</div>
    </div>
    
   
</div>


</div>
<div id="dialog2" title="Eliminar Fixture">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            �Esta seguro que desea eliminar el fixture?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si elimina el fixture se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>

<!--<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>-->



<script type="text/javascript">
$(document).ready(function(){
	$('#timepicker2').timepicker({
		minuteStep: 15,
		showSeconds: false,
		showMeridian: false,
		defaultTime: false
		});
	 <?php 
		echo $serviciosHTML->validacion($tabla);
	
	?>
	
	$('#chequearF').click( function() {
		url = "chequear.php";
		$(location).attr('href',url);
	});
	
	$('#volver').click( function() {
		url = "index.php";
		$(location).attr('href',url);
	});
	
	$('#conductaF').click( function() {
		url = "conductafixture.php";
		$(location).attr('href',url);
	});
	
	 $('.varborrar').click(function(event){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			$("#idEliminar").val(usersid);
			$("#dialog2").dialog("open");

			
			//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
			//$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acci�n.");	
		  }
	});//fin del boton eliminar

	$("#example").on("click",'.varmodificar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acci�n.");	
		  }
	});//fin del boton modificar

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
											url = "index.php";
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
	
	
	//al enviar el formulario
    $('#cargar2').click(function(){
		
		if (validador() == "")
        {
			//informaci�n del formulario
			var formData = new FormData($(".formulario")[0]);
			var message = "";
			//hacemos la petici�n ajax  
			$.ajax({
				url: '../../ajax/ajax.php',  
				type: 'POST',
				// Form data
				//datos del formulario
				data: formData,
				//necesario para subir archivos via ajax
				cache: false,
				contentType: false,
				processData: false,
				//mientras enviamos el archivo
				beforeSend: function(){
					$("#load").html('<img src="../../imagenes/load13.gif" width="50" height="50" />');       
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
                                            $(".alert").removeClass("alert-danger");
											$(".alert").removeClass("alert-info");
                                            $(".alert").addClass("alert-success");
                                            $(".alert").html('<strong>Ok!</strong> Se cargo exitosamente el <strong>Fixture</strong>. ');
											$(".alert").delay(3000).queue(function(){
												/*aca lo que quiero hacer 
												  despu�s de los 2 segundos de retraso*/
												$(this).dequeue(); //contin�o con el siguiente �tem en la cola
												
											});
											$("#load").html('');
											//url = "index.php";
											var a = $('#reftorneoge_a option:selected').html();
											var b = $('#reftorneoge_b option:selected').html();
											a = a.split(' - ');
											b = b.split(' - ');
											
											$('#resultados').prepend('<tr><td>' + a[1] + '</td><td></td><td></td><td>' + 
																		+ b[1] + '</td><td>' + 
																		a[0] + '</td><td>' + 
																		$('#fechajuego option:selected').html() + '</td><td>' + 
																		$('#reffecha option:selected').html() + '</td><td>' + 
																		$('#hora option:selected').html() + '</td><td style="color:#f00;">Nuevo</td></tr>').fadeIn(300);
											
											//$(location).attr('href',url);
                                            
											
                                        } else {
                                        	$(".alert").removeClass("alert-danger");
                                            $(".alert").addClass("alert-danger");
                                            $(".alert").html('<strong>Error!</strong> '+data);
                                            $("#load").html('');
                                        }
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
                    $("#load").html('');
				}
			});
		}
    });
	

});
</script>



<?php } ?>
</body>
</html>
