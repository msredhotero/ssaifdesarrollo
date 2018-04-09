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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../fallos/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Fallos",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


$id		=	$_GET['id'];

$resResultado	=	$serviciosReferencias->traerSancionesjugadoresPorId($id);
$resDetalles	=	$serviciosReferencias->traerSancionesjugadoresPorIdDetalles($id);

$resFixture		=	$serviciosReferencias->traerFixturePorId(mysql_result($resResultado,0,'reffixture'));

$resSanciones	=	$serviciosReferencias->traerMovimientosancionesIdSancionPorSancionJugador(mysql_result($resResultado,0,'refjugadores'));
$resFS		=	$serviciosReferencias->traerMovimientosancionesPorSancionJugador(mysql_result($resResultado,0,'refjugadores'));
/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Fallo";

$plural = "Fallos";

$eliminar = "eliminarMovimientosanciones";

$insertar = "modificarMovimientosanciones";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbmovimientosanciones";

$cabeceras 		= "	<th bgcolor='#E0ECF8'>Fecha</th>
					<th bgcolor='#E0ECF8'>Cumplida</th>
					<th bgcolor='#E0ECF8'>Finalizo</th>
					<th bgcolor='#E0ECF8'>Tipo Fallo</th>";
//////////////////////////////////////////////  FIN de los opciones //////////////////////////



$fallo	= '';
$cadFechasS = '';
while ($rowS = mysql_fetch_array($resSanciones)) {
	
	$resResultado	=	$serviciosReferencias->traerSancionesjugadoresPorId($rowS['idsancionjugador']);
	
	$resDetalles	=	$serviciosReferencias->traerSancionesjugadoresPorIdDetalles($rowS['idsancionjugador']);

	$resFechas = $serviciosReferencias->traerFechasFixturePorTorneo($rowS['idtorneo']);
	
	$resFS = $serviciosReferencias->traerMovimientosancionesPorSancion($rowS['idsancionjugador']);
	
	$cadFechasS .= '<ul class="list-group">
              <li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-user"></span> Jugador</li>
              <li class="list-group-item list-group-item-default">Nombre Completo:'.mysql_result($resDetalles,0,'jugador').'</li>
              <li class="list-group-item list-group-item-default">Nro Documento:'.mysql_result($resDetalles,0,'nrodocumento').'</li>
              <li class="list-group-item list-group-item-default">Fecha de la sación:'.mysql_result($resDetalles,0,'fecha').'</li>
              <li class="list-group-item list-group-item-default">Sanción:'.mysql_result($resDetalles,0,'tiposancion').'</li>
			  <li class="list-group-item list-group-item-default">Categoria:'.mysql_result($resDetalles,0,'categoria').'</li>
			  <li class="list-group-item list-group-item-default">División:'.mysql_result($resDetalles,0,'division').'</li>
			  <li class="list-group-item list-group-item-default">Fechas:'.mysql_result($resDetalles,0,'cantidadfechas').'</li>
			  <li class="list-group-item list-group-item-default">Obs.:'.mysql_result($resDetalles,0,'observaciones').'</li>
			  <li class="list-group-item list-group-item-default"><a href="../estadisticas/estadisticas.php?id='.mysql_result($resDetalles,0,'reffixture').'">Ir a la Estadistica</a></li>
              
            </ul><hr>';
			
			
	while ($subrow = mysql_fetch_array($resFS)) {
			$arrayFS[] = $subrow;
	}
	
	
	
	$cadFechasS .= '<ul class="list-inline">';
	while ($rowFS = mysql_fetch_array($resFechas)) {
		$check = '';
		$cumplida = '';
		$valorCumplida = 0;
		$orden = 1;
		$lblCumplida = '';
		if (mysql_num_rows($resFS)>0) {
			foreach ($arrayFS as $item) {
				if (stripslashes($item['reffechas']) == $rowFS[0]) {
					$check = 'checked';	
					if ($item['cumplidas'] == 'Si') {
						$cumplida = 'disabled';
						$lblCumplida = '(Cumplida)';
						$valorCumplida = 1;
						$orden = $item['orden'];
					}
				}
				
			}
		}
		
		$cadFechasS = $cadFechasS."<li>".'<input '.$cumplida.' id="'.$rowS['idsancionjugador'].'fecha'.$rowFS[0].'" '.$check.' class="form-control" type="checkbox" style="width:50px;" name="'.$rowS['idsancionjugador'].'fecha'.$rowFS[0].'fecha'.$valorCumplida.'fecha'.$orden.'"><p>'.$rowFS[1].$lblCumplida.'</p>'."</li>";

	
	}
	
	
	
	$cadFechasS = $cadFechasS.'</ul><button type="button" class="btn btn-warning cumplidas" id="'.$rowS['idsancionjugador'].'" style="margin-left:0px;">Modificar Cumplimientos</button><br><hr>';
	
	unset($arrayFS);		
			
}
//$resFechas = $serviciosReferencias->traerFechasFixturePorTorneo(mysql_result($resFixture,0,'reftorneos'));




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
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de <?php echo $plural; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
            <form name="form" id="form" method="post" action="guardarfechas.php">
            <?php
				echo $cadFechasS;
			?>
				<input type="submit" class="btn btn-primary" name="btnCargar" id="btnCargar" value="Guardar"/>
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
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
	$('#example').dataTable({
		"order": [[ 0, "asc" ]],
		"language": {
			"emptyTable":     "No hay datos cargados",
			"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
			"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
			"infoFiltered":   "(filtrados del total de _MAX_ filas)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Mostrar _MENU_ filas",
			"loadingRecords": "Cargando...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"zeroRecords":    "No se encontraron resultados",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activate to sort column ascending",
				"sortDescending": ": activate to sort column descending"
			}
		  }
	} );
	
	$(document).on('click', '.panel-heading span.clickable', function(e){
		var $this = $(this);
		if(!$this.hasClass('panel-collapsed')) {
			$this.parents('.panel').find('.panel-body').slideUp();
			$this.addClass('panel-collapsed');
			$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		} else {
			$this.parents('.panel').find('.panel-body').slideDown();
			$this.removeClass('panel-collapsed');
			$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		}
	});
	
	$("#example").on("click",'.varmodificar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar
	
	$('.cumplidas').click(function(){
		usersid =  $(this).attr("id");
		if (!isNaN(usersid)) {
			
			url = "modificarfechascumplidas.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});

		
	$("#fechadesde").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
	$("#fechahasta").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
	
	//al enviar el formulario
    $('#cargar').click(function(){

		//información del formulario
		var formData = new FormData($(".formulario")[0]);
		var message = "";
		//hacemos la petición ajax  
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
										$(".alert").html('<strong>Ok!</strong> Se cargo exitosamente el <strong><?php echo $singular; ?></strong>. ');
										$(".alert").delay(3000).queue(function(){
											/*aca lo que quiero hacer 
											  después de los 2 segundos de retraso*/
											$(this).dequeue(); //continúo con el siguiente ítem en la cola
											
										});
										$("#load").html('');
										url = "index.php";
										$(location).attr('href',url);
										
										
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
		
    });

});
</script>


<?php } ?>
</body>
</html>
