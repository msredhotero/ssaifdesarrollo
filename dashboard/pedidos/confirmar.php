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
		padding: 3px 10px;
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

<h3><?php echo $plural; ?> <span style="color:#006666;"><span class="glyphicon glyphicon-chevron-right"></span> Confirmar</span></h3>
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Confirmar <?php echo $plural; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<div class="alert alert-info">
            	<p><span class="glyphicon glyphicon-info-sign"></span> Recuerde cargar la fecha de entrega y una referencia</p>
            </div>
        	<form class="form-inline formulario" role="form">

            
            <div class="col-md-12">
            <table class="table table-striped" id="table-6">
                <thead>
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Nuevo Stock</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Sub-Total</th>
                    </tr>
                </thead>
                <tbody class="detalle">
                	<?php
						$total = 0;
						
						$existe = 0;
						if (mysql_num_rows($pedidosTemporal)>0) {
							$existe = 1;
							while ($rowT = mysql_fetch_array($pedidosTemporal)) {
								$total += $rowT['precio'] * $rowT['cantidad'];
					?>
                    		<tr>
                    		<td><?php echo $rowT['refproductos']; ?></td>
                    		<td><?php echo $rowT['nombre']; ?></td>
                            <td align="center"><?php echo $rowT['cantidad']; ?></td>
                            <td align="right"><?php echo $rowT['stock']; ?> <span class="text-success">+ <?php echo $rowT['cantidad']; ?></span> = <?php echo $rowT['stock']+$rowT['cantidad']; ?></td>
                            <td align="right"><?php echo $rowT['precio']; ?></td>
                            <td align="right"><?php echo $rowT['precio'] * $rowT['cantidad']; ?></td>
                    		</tr>
                    <?php
							}
						} else {
					?>
                    		<tr>
                            	<td colspan="6">No hay productos cargados para realizar el pedido.</td>
                            </tr>
                    <?php
						}
					?>
                </tbody>
                <tfoot>
                    <tr style="background-color:#CCC; font-weight:bold; font-size:18px;">
                        <td colspan="5" align="right">
                            Total $
                        </td>
                        <td>
                            <input type="text" readonly name="total" id="total" value="<?php echo $total; ?>" style="border:none; background-color:#CCC;"/>
                        </td>
                    </tr>
                </tfoot>
            </table>
            </div>
            
            <div class="form-group col-md-6">
                <label for="fechaentrega" class="control-label" style="text-align:left">Fecha de Entrega</label>
                <div class="input-group date form_date col-md-6" data-date="" data-date-format="dd MM yyyy" data-link-field="fechaentrega" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="50" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                <input type="hidden" name="fechaentrega" id="fechaentrega" value="" />
            </div>
            
            <div class="form-group col-md-6" style="display:block">
                <label class="control-label" for="referencia" style="text-align:left">Referencia</label>
                <div class="input-group col-md-12">
                    <input id="referencia" class="form-control" name="referencia" placeholder="Referencia..." required type="text"/>
                </div>
            </div>
            
            <div class="form-group col-md-6" style="display:block">
                <label class="control-label" for="observaciones" style="text-align:left">Observaciones</label>
                <div class="input-group col-md-12">
                    <input id="observaciones" class="form-control" name="observaciones" placeholder="Observaciones..." required type="text" />
                </div>
            </div>
                    
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-left:15px;">
                	<?php if ($existe == 1) { ?>
                    <li>
                        <button type="button" class="btn btn-primary" id="cargar" style="margin-left:0px;">Cargar</button>
                    </li>
                    <?php } ?>
                    <li>
                        <button type="button" class="btn btn-default volver" id="volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            
            <div class="row" id="aviso" style="display:none;">
            	<div class="col-md-12">
                	<div class='alert alert-info'>
                		<p>Se guardo temporalmente el pedido para una posterior modificación</p>
                	</div>
                </div>
            </div>
            <input type="hidden" name="accion" id="accion" value="insertarPedidos" />
            
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
	
	
	$('.volver').click(function(event){
		 
		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar
	


	

	
	  
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
										$('.detalle').hide(100);
										$('#total').val(0);
										//url = "confirmar.php";
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
