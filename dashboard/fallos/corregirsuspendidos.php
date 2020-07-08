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


$datos      =   $serviciosReferencias->suspendidosTotal();
/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Fallo";

$plural = "Fallos";

$eliminar = "eliminarSancionesfallos";

$insertar = "insertarFalloPorFecha";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbsancionesfallos";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$resTemporadas = $serviciosReferencias->traerUltimaTemporada();

if (mysql_num_rows($resTemporadas)>0) {
   $ultimaTemporada = mysql_result($resTemporadas,0,0);
} else {
   $ultimaTemporada = 0;
}


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
      <script src="../../js/jquery.number.min.js"></script>
      <script type="text/javascript">

		$(function(){

			$('#cantidadfechas').each(function(intIndex){
				$(this).number( true, 0 );
				$(this).change( function() {
					if ($(this).val() > 100) {
						$(this).val(2);
					}
					if ($(this).val() < 1) {
						$(this).val(1);
					}
				});
			});


		});
		</script>
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

<h3>CORREGIR SUSPENDIDOS</h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Modificar suspendidos a sus categorias y equipos nuevos</p>

        </div>
    	<div class="cuerpoBox">


        	<form class="form-inline formulario" role="form">
        	   <table class="table table-striped table-responsive" id="example">
                    <thead>
                        <tr>
                            <th>Countrie</th>
                            <th>Nro.Doc.</th>
                            <th>Apellido y Nombre</th>
                            <th>Torneo</th>
                            <th>Equipo</th>
                            <th>Categoria</th>
                            <th>Equipo Cambio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>        
                    <tbody>
                <?php
                    $existe = 0;
                    $cad = '';
                    while ($row = mysql_fetch_array($datos)) {
                        $resJugadorSusp = $serviciosReferencias->SuspendidosTotalPorJugador($row['idjugador']);
                        $resConectorJugador = $serviciosReferencias->traerConectorActivosPorTemporada($row['idjugador'],$ultimaTemporada,$row['refequipos'],$row['refcategorias']);

                        if (mysql_num_rows($resConectorJugador)<=0) {
                            $resJugador = $serviciosReferencias->traerConectorActivosSoloTemporada($row['idjugador'],$ultimaTemporada);

                            $cad = '';
                            if (mysql_num_rows($resJugador)>0) {
                                $cad = $serviciosFunciones->devolverSelectBox($resJugador,array(9,1,2),' - ');
                            } else {
                                $cad = '<option value="0">-- Sin Equipo --</option>';
                            }
                            

                ?>
                        <tr>
                            <th><?php echo $row[0]; ?></th>
                            <th><?php echo $row[1]; ?></th>
                            <th><?php echo $row[2]; ?></th>
                            <th><?php echo $row[3]; ?></th>
                            <th><?php echo $row[5]; ?></th>
                            <th><?php echo $row[9]; ?></th>
                            <th><select name="refconector" id="refconector<?php echo $row['idsancionjugador']; ?>"><?php echo $cad; ?></select></th>
                            <th><?php if ($cad != '<option value="0">-- Sin Equipo --</option>') { ?><button type="button" class="btn btn-primary btnCorregir" id="<?php echo $row['idsancionjugador']; ?>" data-idsancion="<?php echo $row['idsancionjugador']; ?>" style="margin-left:0px;">Corregir</button><?php } ?></th>
                        </tr>
                <?php
                        }
                    }
                ?>
                    </tbody>
               </table>
            


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
                        <button type="button" class="btn btn-primary" id="cargar" style="margin-left:0px;">Guardar</button>
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



	$("#example").on("click",'.btnCorregir', function(){

        idsancionjugador =  $(this).attr("id");
        refconector = $('#refconector'+idsancionjugador).val();

        if (!isNaN(idsancionjugador)) {

            $.ajax({
                data:  {idsancionjugador: idsancionjugador,
                        refconector: refconector,
                        accion: 'corregirSuspendidos'},
                url:   '../../ajax/ajax.php',
                type:  'post',
                beforeSend: function () {

                },
                success:  function (response) {
                    if (response == '') {
                        location.reload();

                    } else {
                        $('#error').html('Hubo un error al guardar los datos, verifique los datos ingresados ');
                        
                    }
                }
            });
        }
    });

	

});
</script>


<?php } ?>
</body>
</html>
