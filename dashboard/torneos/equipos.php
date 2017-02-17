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
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Torneos",$_SESSION['refroll_predio'],'');

$id = $_GET['id'];

if (isset($_GET['fechainicio'])) {
	$fechainicio = $_GET['fechainicio'];
} else {
	$fechainicio = date('d/m/Y');
}

$resResultado = $serviciosReferencias->traerTorneosPorId($id);

$resFixture	= $serviciosReferencias->traerFixtureTodoPorTorneo($id);
/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Torneo";

$plural = "Torneos";

$eliminar = "eliminarTorneos";

$insertar = "insertarTorneos";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbtorneos";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resEquipos = $serviciosReferencias->traerEquipoPorTorneo($id);

$idCategoria = mysql_result($resResultado,0,'refcategorias');

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
		
			date_add($fechaNueva, date_interval_create_from_date_string('-'.$nuevoNumero.' days'));
		}
	}
	//die(var_dump($numeroDia));
} else {
	$fechaNueva = $fechainicio;	
}

$hora = mysql_result($resDias,0,'hora');

if ($_SESSION['refroll_predio'] != 1) {

} else {

	
}

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

<h3><?php echo $plural; ?></h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Seleccionar equipos</p>
        	
        </div>
    	<div class="cuerpoBox">
        <?php
			if (mysql_num_rows($resFixture)>0) {
		?>
        	<h4>Ya existe un fixture creado</h4>
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                	<li>
                        <button type="button" class="btn btn-primary varver" id="<?php echo $id; ?>" style="margin-left:0px;">Ver Fixture</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver" id="volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
        	
            <?php
			} else {
				
			?>
            
            
            <form class="form-inline formulario" role="form" method="post" action="../fixture/generarfixture.php">
        	<div class="row">
            
			<div class="col-md-12">
            	<div class="col-md-6" style="margin-bottom:10px;">
                    <label class="control-label">Fecha de Inicio</label>
                    <div class="input-group col-md-12">
                        <input type="text" name="fechainicio" id="fechainicio" class="form-control" value="<?php echo $fechaNueva->format('d/m/Y'); ?>"/>
                        <script type="text/javascript">
                        $(document).ready(function(){
                            
                            $("#fechainicio").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
                        });
                        </script>
                    </div>
                </div>
                

				<table class="table table-bordered table-responsive table-striped">
                <thead>
                	<th style="text-align:center">Seleccionar</th>
                    <th>Equipo</th>
                    <th>Activo</th>
                    
                </thead>
                <tbody>
				<?php
					$cantidad = 0;
					while ($row = mysql_fetch_array($resEquipos)) {
						$cantidad += 1;
				?>
                	<?php 
						if ($row[2] =='Si') {
					?>
                	<tr>
                	<td align="center">
                    
                    <input class="form-control tildar" checked type="checkbox" name="equipo<?php echo $row[0]; ?>" id="equipo<?php echo $row[0]; ?>"/>
                    
                    </td>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    </tr>
                    <?php
						}
					?>
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
                        <button type="submit" class="btn btn-primary" id="cargar" style="margin-left:0px;">Guardar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver" id="volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            <input type="hidden" id="fechainicio" name="fechainicio" value="<?php echo $fechaNueva->format('Y-m-d'); ?>"/>
            <input type="hidden" id="idtorneo" name="idtorneo" value="<?php echo $id; ?>"/>
            <input type="hidden" id="hora" name="hora" value="<?php echo $hora; ?>"/>
            </form>
            <?php
			}
			?>
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
	
	
	$('.varver').click(function(event){	
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {

			url = "../fixture/ver.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton eliminar
	
	$('.volver').click(function(event){
		 
		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar


			
	

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
