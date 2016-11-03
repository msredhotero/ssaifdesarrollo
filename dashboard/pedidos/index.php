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

$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerPedidos(),95);

$lstCargadosProductosFaltantes 	= $serviciosReferencias->traerProductosFaltantes();

$lstProductos =	$serviciosFunciones->camposTablaView($cabecerasProductos,$serviciosReferencias->traerProductos(),5);

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
		text-align: left;
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
	
    <div class="boxInfoLargo" style="margin-bottom:-15px;">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Productos Cargados <span class="glyphicon glyphicon-minus abrir2" style="cursor:pointer; float:right; padding-right:12px;">(Cerrar)</span></p>
        	
        </div>
    	<div class="cuerpoBox filt2">
        	<?php echo $lstProductos; ?>
    	</div>
    </div>
    
    <div class="boxInfoLargo" style="margin-bottom:-15px;">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Productos Faltantes <span class="glyphicon glyphicon-minus abrir" style="cursor:pointer; float:right; padding-right:12px;">(Cerrar)</span></p>
        	
        </div>
    	<div class="cuerpoBox filt">
        	<div class="col-md-12">
            <table class="table table-striped" id="table-6">
                <thead>
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Sub-Total</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="detallefaltante">
                	<?php
						$total = 0;
						if (mysql_num_rows($lstCargadosProductosFaltantes)>0) {
							while ($rowT = mysql_fetch_array($lstCargadosProductosFaltantes)) {
								$total += $rowT['preciocosto'] * $rowT['cantidad'];
					?>
                    		<tr>
                    		<td align="center"><?php echo $rowT['idproducto']; ?></td>
                    		<td><?php echo $rowT['nombre']; ?></td>
                            <td align="center"><?php echo $rowT['cantidad']; ?></td>
                            <td align="right"><?php echo $rowT['preciocosto']; ?></td>
                            <td align="right"><?php echo $rowT['preciocosto'] * $rowT['cantidad']; ?></td>
                    		<td class="text-center"><button type="button" class="btn btn-success agregarfila" id="<?php echo $rowT['idproducto']; ?>" style="margin-left:0px;"><span class="glyphicon glyphicon-plus"></span> Agregar</button></td>
                    		</tr>
                    <?php
							}
						}
					?>
                </tbody>
                <tfoot>
                    <tr style="background-color:#CCC; font-weight:bold; font-size:18px;">
                        <td colspan="5" align="right">
                            Total $
                        </td>
                        <td>
                            <input type="text" readonly name="totalfaltante" id="totalfaltante" value="<?php echo $total; ?>" style="border:none; background-color:#CCC;"/>
                        </td>
                    </tr>
                </tfoot>
            </table>
            </div>
    	</div>
    </div>
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de <?php echo $plural; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form" method="post" action="confirmar.php">
        	<div class="row">
            	<div class="form-group col-md-1" style="display:block">
                	<label class="control-label" for="codigobarra" style="text-align:left">Cantidad</label>
                    <div class="input-group col-md-12">
	                    <input id="cantidadbuscar" class="form-control" name="cantidadbuscar" placeholder="Cantidad..." required type="number" value="1">
                    </div>
                </div>
                
				<div class="form-group col-md-8" style="display:block">
                	<label class="control-label" for="producto" style="text-align:left">Lista de Productos</label>
                	<div class="input-group col-md-12">
                		<select data-placeholder="selecione el producto..." id="refproductobuscar" name="refproductobuscar" class="chosen-select" tabindex="2" style="z-index:9999999; width:100%;">
            				<option value=""></option>
                            <?php 
								while ($row = mysql_fetch_array($resProductos)) {
							?>
                            	<option value="<?php echo $row[0]; ?>"><?php echo "Prod: ".$row['nombre']." - Stock: ".$row['stock']." - Stock Min.: ".$row['stockmin']." - Precio: $".number_format($row['preciocosto'],2,',','.'); ?></option>
                            <?php
								}
							?>
                        </select>
                	</div>
                </div>
                
                <div class="form-group col-md-3" style="display:block">
                	<label class="control-label text-right" for="producto" style="text-align:right"></label>
                    <div class="input-group col-md-12 text-right">
	                    <ul class="list-inline">
                        <li>
                        	<button type="button" class="btn btn-success" id="agregar" style="margin-left:0px;"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
                        </li>
                        <li>
                        	<button type="button" class="btn btn-info" id="ver" style="margin-left:0px;"><span class="glyphicon glyphicon-search"></span> Ver</button>
                        </li>
                    </div>
                </div>
                
            </div>

            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
            
            <div class="col-md-12">
            <table class="table table-striped" id="table-6">
                <thead>
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Sub-Total</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="detalle">
                	<?php
						$total = 0;
						if (mysql_num_rows($pedidosTemporal)>0) {
							while ($rowT = mysql_fetch_array($pedidosTemporal)) {
								$total += $rowT['precio'] * $rowT['cantidad'];
					?>
                    		<tr>
                    		<td align="center"><?php echo $rowT['refproductos']; ?></td>
                    		<td><?php echo $rowT['nombre']; ?></td>
                            <td align="center"><?php echo $rowT['cantidad']; ?></td>
                            <td align="right"><?php echo $rowT['precio']; ?></td>
                            <td align="right"><?php echo $rowT['precio'] * $rowT['cantidad']; ?></td>
                    		<td class="text-center"><button type="button" class="btn btn-danger eliminarfila" id="<?php echo $rowT['iddetallepedidoaux']; ?>" style="margin-left:0px;">Eliminar</button></td>
                    		</tr>
                    <?php
							}
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
            
                    
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-left:15px;">
                    <li>
                        <button type="submit" class="btn btn-primary" id="cargar" style="margin-left:0px;">Confirmar</button>
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
            <input type="hidden" name="prodNombre" id="prodNombre" value="" />
            <input type="hidden" name="prodPrecio" id="prodPrecio" value="" />
            
            </form>
    	</div>
    </div>
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;"><?php echo $plural; ?> Cargados</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<?php echo $lstCargados; ?>
    	</div>
    </div>
    
    

    
    
   
</div>


</div>
<div id="dialog2" title="Eliminar <?php echo $singular; ?>">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea eliminar el <?php echo $singular; ?>?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si elimina el <?php echo $singular; ?> se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle del Pedido</h4>
      </div>
      <div class="modal-body detallePedido">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Finalizar Pedido</h4>
      </div>
      <div class="modal-body">
        	<p>¿Desea finalizar el pedido?</p>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary finalizar" data-dismiss="modal" id="finalizar">Finalizar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
	
	$('.abrir').click(function() {
		
		if ($('.abrir').text() == '(Abrir)') {
			$('.filt').show( "slow" );
			$('.abrir').text('(Cerrar)');
			$('.abrir').removeClass('glyphicon glyphicon-plus');
			$('.abrir').addClass('glyphicon glyphicon-minus');
		} else {
			$('.filt').slideToggle( "slow" );
			$('.abrir').text('(Abrir)');
			$('.abrir').addClass('glyphicon glyphicon-plus');
			$('.abrir').removeClass('glyphicon glyphicon-minus');

		}
	});
	
	$('.abrir').click();
	
	$('.abrir').click(function() {
		$('.filt').show();
	});
	
	
	$('.abrir2').click(function() {
		
		if ($('.abrir2').text() == '(Abrir)') {
			$('.filt2').show( "slow" );
			$('.abrir2').text('(Cerrar)');
			$('.abrir2').removeClass('glyphicon glyphicon-plus');
			$('.abrir2').addClass('glyphicon glyphicon-minus');
		} else {
			$('.filt2').slideToggle( "slow" );
			$('.abrir2').text('(Abrir)');
			$('.abrir2').addClass('glyphicon glyphicon-plus');
			$('.abrir2').removeClass('glyphicon glyphicon-minus');

		}
	});
	
	$('.abrir2').click();
	
	$('.abrir2').click(function() {
		$('.filt2').show();
	});
	
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
	

	$("#example").on("click",'.varborrar', function(){
		  usersid =  $(this).attr("id");
		  
		  if (!isNaN(usersid)) {
			$("#idEliminar").val(usersid);
			$("#dialog2").dialog("open");

		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton eliminar
	
	$("#example").on("click",'.varmodificar', function(){
		  usersid =  $(this).attr("id");
		  
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar
	
	$("#example").on("click",'.varpagar', function(){
		  usersid =  $(this).attr("id");
		  
		  if (!isNaN(usersid)) {
			
			url = "entrada.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
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
									data:  {id: $('#idEliminar').val(), accion: '<?php echo $eliminar; ?>'},
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
			
	<?php 
		echo $serviciosHTML->validacion($tabla);
	
	?>
	
	function insertarDetalleAux(idProducto, cantidad, precio, total, json) {
		var id = 0;
		$.ajax({
				data:  {refproductos: idProducto, 
						cantidad: cantidad, 
						precio: precio, 
						total: total, 
						accion: 'insertarDetallepedidoaux'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
					setTimeout(function() {
						$("#aviso").fadeOut(1500);
					},3000);	
					
					$('#prodNombre').val(json[0].nombre);
					$('#prodPrecio').val(json[0].preciocosto);
					
					$('.detalle').prepend('<tr><td align="center">'+idProducto+'</td><td>'+json[0].nombre+'</td><td align="center">'+cantidad+'</td><td align="right">'+json[0].preciocosto+'</td><td align="right">'+monto.toFixed(2)+'</td><td class="text-center"><button type="button" class="btn btn-danger eliminarfila" id="'+response+'" style="margin-left:0px;">Eliminar</button></td></tr>');
					
					$('#cantidadbuscar').val(1);
							
					$("#aviso").show();
							
					$('#total').val(SumarTabla());
				}
		});
		
		return id;
	}
	
	function eliminarDetalleAux(idProducto) {
		$.ajax({
				data:  {id: idProducto, 
						accion: 'eliminarDetallepedidoaux'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
					$('#total').val(SumarTabla());	
				}
		});
	}
	
	$("#example").on("click",'.varfinalizar', function(){
		  
		  $('.finalizar').attr('id',$(this).attr("id"));
	});
	
	$('#finalizar').click(function(e) {
        $.ajax({
				data:  {id: $('.finalizar').attr("id"), 
						accion: 'finalizarPedido'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
					url = "index.php";
					$(location).attr('href',url);	
				}
		});
    });
	
	$("#example").on("click",'.varpagos', function(){
		  
		  $.ajax({
				data:  {id: $(this).attr("id"), 
						accion: 'traerDetallepedidoPorPedido'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
					$('.detallePedido').html(response);	
				}
		});
	});
	
	$('#finalizar').click(function(e) {
        
    });
	
	

	function getProducto(idProd, cantidad) {
		$.ajax({
					data:  {idproducto: idProd,
							accion: 'traerProductoPorCodigo'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
						$('#agregar').hide();
						$('#agregarfila').hide();	
					},
					success:  function (response) {
						if(response){
							//idproducto,codigo,nombre,descripcion,stock,stockmin,preciocosto,precioventa,utilidad,estado,imagen,idcategoria,tipoimagen,nroserie,codigobarra
							json = $.parseJSON(response);
							
							monto = parseFloat(json[0].preciocosto) * parseInt(cantidad);
							var idRetornado = insertarDetalleAux(idProd, cantidad, json[0].preciocosto, monto, json);
							
						} else {
							//var producto = ['', 0];
							$('#prodNombre').val('');
							$('#prodPrecio').val(0);
						}
						
						$('#agregar').show();
						$('#agregarfila').show();
					}
			});	
	}
	
	
	$('#agregar').click(function(e) {
		
		getProducto($('#refproductobuscar').chosen().val(), $('#cantidadbuscar').val());
		
    });
	
	$('.agregarfila').click(function(e) {
		id =  $(this).attr("id");
		//getProducto(id);
		var cantidad = 1;
		$('.detallefaltante tr').each(function(){
			
			if ($(this).find('td').eq(0).text() == id) {
				cantidad = $(this).find('td').eq(2).text();	
			}
			//suma += parseFloat($(this).find('td').eq(4).text()||0,10); //numero de la celda 3
		});
		
		getProducto(id, cantidad);
		
	});
	
	
	function SumarTabla() {
		var suma = 0;
		$('.detalle tr').each(function(){
			
			suma += parseFloat($(this).find('td').eq(4).text()||0,10); //numero de la celda 3
		})
		return suma.toFixed(2);

	  }
	  
	//elimina una fila
	  $(document).on("click",".eliminarfila",function(){
		var padre = $(this).parents().get(1);

		$(padre).remove();
		
		id =  $(this).attr("id");
		
		eliminarDetalleAux(id);
		
		
	  });
	  
	//al enviar el formulario
    $('#cargar44').click(function(){
		
		if (validador() == "")
        {
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
		}
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
