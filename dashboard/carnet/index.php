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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../carnet/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Carnet",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Carnet";

$plural = "Carnet";

$eliminar = "eliminarTorneos";

$insertar = "insertarTorneos";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbtorneos";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resEquipos = $serviciosReferencias->traerJugadoresParaCarnet();




//die(var_dump($numeroDia));

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

<h3>Generacion de Fixture</h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Seleccionar equipos</p>
        	
        </div>
    	<div class="cuerpoBox">

            
            
            <form class="form-inline formulario" role="form" method="post" action="../../reportes/rptCarnet.php" target="_blank">
        	<div class="row">
            
			<div class="col-md-12">
            	<div class="col-md-12" style="margin-bottom:10px;">
                    <h3>Elegir los Juagdores para generarles el carnet</h3>

                </div>
                
                <input type="buttom" class="btn btn-default tildarvisibles" value="Tildar Visibles">

				<table class="table table-bordered table-responsive table-striped">
                <thead>
                	<th style="text-align:center">Seleccionar</th>
                    <th>Categoria</th>
                    <th>Equipo</th>
                    <th>Club</th>
                    <th>Apellido y Nombre</th>
                    <th>Nro.Doc.</th>
                    <th>Fec. Nac.</th>
                    <th>Fecha Alta</th>
                    
                </thead>
                <tbody>
				<?php
					$cantidad = 0;
					while ($row = mysql_fetch_array($resEquipos)) {
						$cantidad += 1;
				?>

                	<tr>
                    	<td align="center">
                        
                            <input class="form-control tildar" type="checkbox" name="equipo<?php echo $row[0]; ?>" id="equipo<?php echo $row[0]; ?>"/>
                        
                        </td>
                        <td><?php echo $row['categoria']; ?></td>
                        <td><?php echo $row['equipo']; ?></td>
                        <td><?php echo $row['countrie']; ?></td>
                        <td><?php echo $row['nombrecompleto']; ?></td>
                        <td><?php echo $row['nrodocumento']; ?></td>
                        <td><?php echo $row['fechanacimiento']; ?></td>
                        <td><?php echo $row['fechaalta']; ?></td>
                    </tr>

                <?php
					}
				?>
                </tbody>
                </table>
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
                        <button type="submit" class="btn btn-primary" id="cargar" style="margin-left:0px;">Generar Carnet</button>
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


    
	
	


    $('.tildarvisibles').click(function() {
        $('.tildar').each(function(intIndex){
            $(this).prop( 'checked', true );
        });
    });

		
	

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
