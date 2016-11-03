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
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Pedidos",$_SESSION['refroll_predio'],'');

$idPedido	= $_POST['idpedido'];
$refestado	= $_POST['refestado'];

$numero = count($_POST);
$tags = array_keys($_POST);// obtiene los nombres de las varibles
$valores = array_values($_POST);// obtiene los valores de las varibles
$cantEncontrados = 0;

$lbl = "";
$lblRes = "";
$r1 = '';
if (($refestado == 1) || ($refestado == 2)) {
	for($i=0;$i<$numero;$i++){
		
		if (strpos($tags[$i],"cantidad") !== false) {
			$id = str_replace("cantidad","",$tags[$i]);
			//die(var_dump($valores[$i]));
			//modifico el nuevo stock
			$r1 = $serviciosReferencias->registrarEntradaPorPedidoProducto($id, $valores[$i]);
			//echo $r1."<br>";
			//die(var_dump($r1));
			//cargo la diferencia
			$r1 = $serviciosReferencias->registrarFaltantes($id, $valores[$i]);
		}
	}
	//die(var_dump($r1));
	$lbl = 'success';
	$lblRes = 'El pedido a sido registrado correctamente';
	//le pongo el estado al pedido
	$serviciosReferencias->determinarEstado($idPedido);
	
} else {
	$lbl = 'danger';
	$lblRes = 'El pedido no ha sido procesado, no se puede procesar un pedido finalizado o cancelado';
}


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Pedido";

$plural = "Pedidos";

$eliminar = "eliminarPedidos";

$insertar = "insertarPedidos";

$tituloWeb = "Gestión: Libreria";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbpedidos";

$lblCambio	 	= array();
$lblreemplazo	= array();


$cadRef 	= '';

$resProductos	=	$serviciosReferencias->traerProductos();

$refdescripcion = array();
$refCampo 	=  array();
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  patente,refmodelo,reftipovehiculo,anio/////////////////////
$cabeceras 		= "	<th>Referencia</th>
                    <th>Fecha Pedido</th>
                    <th>Fecha Entrega</th>
					<th>Total</th>
					<th>Estado</th>
                    <th>Obserbaciones</th>";

$cabecerasProductos 		= "<th>Prdoucto</th>
                    <th>Cantidad</th>
					<th>Stock</th>
					<th>Stock Min.</th>
					<th>Precio</th>";
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




//$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerProductos(),10);

$lstCargadosProductosFaltantes 	= $serviciosFunciones->camposTablaView($cabecerasProductos,$serviciosReferencias->traerProductosFaltantes(),5);

$pedidosTemporal = $serviciosReferencias->traerDetallepedidoaux();

$resResult	=	$serviciosReferencias->traerDetallepedidoPorPedido($idPedido);

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
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="../../css/chosen.css">
	<style type="text/css">
		#table-6 {
			border:2px solid #C0C0C0;
		}
		
		#table-6 thead {
		text-align: center;
		}
		#table-6 thead th {
		background: -moz-linear-gradient(top, #F0F0F0 0, #DBDBDB 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #F0F0F0), color-stop(100%, #DBDBDB));
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#F0F0F0', endColorstr='#DBDBDB', GradientType=0);
		border: 1px solid #C0C0C0;
		color: #444;
		font-size: 16px;
		font-weight: bold;
		padding: 3px 6px;
		}
		
		#table-6 tbody td .cent {
			text-align:center;	
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
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

<h3><?php echo $plural; ?> <span style="color:#006666;"><span class="glyphicon glyphicon-chevron-right"></span> Confirmar</span> <span class="glyphicon glyphicon-chevron-right"></span> Registrado</span></h3>
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Registrar <?php echo $plural; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<div class="alert alert-<?php echo $lbl; ?>">
            	<p><span class="glyphicon glyphicon-info-sign"></span> <?php echo $lblRes; ?></p>
            </div>
            
            <div class="col-md-12">
            <table class="table table-striped table-responsive" id="table-6">
                <thead>
                    <tr>
                        <th style="width:8%" class="text-center">Codigo</th>
                        <th style="width:30%" class="text-center">Producto</th>
                        <th style="width:12%" class="text-center">Cantidad</th>
                        <th style="width:15%" class="text-center">Stock</th>
                    </tr>
                </thead>
                <tbody class="detalle">
                	<?php
						$total = 0;
						$fechaentrega = '';
						$fechasolicitud= '';
						$referencia = '';
						$observaciones = '';
						$estado = '';
						if (mysql_num_rows($resResult)>0) {
							
							while ($rowT = mysql_fetch_array($resResult)) {
								$total 			+= $rowT['precio'] * $rowT['cantidad'];
								$fechaentrega 	= $rowT['fechaentrega'];
								$fechasolicitud = $rowT['fechasolicitud'];
								$referencia 	= $rowT['referencia'];
								$observaciones 	= $rowT['observacion'];
								$estado			= $rowT['estado'];
								
					?>
                    		<tr>
                    		<td><?php echo $rowT['codigo']; ?></td>
                    		<td><?php echo $rowT['nombre']; ?></td>
                            <td><?php echo $rowT['cantidad']; ?></td>
                            <td align="right"><?php echo $rowT['stock']; ?></td>
                    		</tr>
                    <?php
							}
						}
					?>
                </tbody>

            </table>
            </div>
            
            <div class="form-group col-md-3">
                <label for="fechaentrega" class="control-label" style="text-align:left">Fecha de Solicitud</label>
                <div class="input-group col-md-12">
                    <h4><?php echo $fechasolicitud; ?></h4>
                </div>
                
            </div>
            
            <div class="form-group col-md-3">
                <label for="fechaentrega" class="control-label" style="text-align:left">Fecha de Entrega</label>
                <div class="input-group col-md-12">
                    <h4><?php echo $fechaentrega; ?></h4>
                </div>
                
            </div>
            
            <div class="form-group col-md-6" style="display:block">
                <label class="control-label" for="referencia" style="text-align:left">Referencia</label>
                <div class="input-group col-md-12">
                    <h4><?php echo $referencia; ?></h4>
                </div>
            </div>
            
            <div class="form-group col-md-6" style="display:block">
                <label class="control-label" for="referencia" style="text-align:left">Estado</label>
                <div class="input-group col-md-12">
                    <h4><?php echo $estado; ?></h4>
                </div>
            </div>
            
            <div class="form-group col-md-12" style="display:block">
                <label class="control-label" for="observaciones" style="text-align:left">Observaciones</label>
                <div class="input-group col-md-12">
                    <h4><?php echo $observaciones; ?></h4>
                </div>
            </div>
                    
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-left:15px;">
                    <li>
                        <button type="button" class="btn btn-default volver" id="volver" style="margin-left:0px;">Volver</button>
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
