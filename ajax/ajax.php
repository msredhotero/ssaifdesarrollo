<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();


$accion = $_POST['accion'];


switch ($accion) {
    case 'login':
        enviarMail($serviciosUsuarios);
        break;
	case 'entrar':
		entrar($serviciosUsuarios);
		break;
	case 'insertarUsuario':
        insertarUsuario($serviciosUsuarios);
        break;
	case 'modificarUsuario':
        modificarUsuario($serviciosUsuarios);
        break;
	case 'registrar':
		registrar($serviciosUsuarios);
        break;



case 'insertarClientes': 
insertarClientes($serviciosReferencias); 
break; 
case 'modificarClientes': 
modificarClientes($serviciosReferencias); 
break; 
case 'eliminarClientes': 
eliminarClientes($serviciosReferencias); 
break; 
case 'insertarCompras': 
insertarCompras($serviciosReferencias); 
break; 
case 'modificarCompras': 
modificarCompras($serviciosReferencias); 
break; 
case 'eliminarCompras': 
eliminarCompras($serviciosReferencias); 
break; 
case 'insertarEmpleados': 
insertarEmpleados($serviciosReferencias); 
break; 
case 'modificarEmpleados': 
modificarEmpleados($serviciosReferencias); 
break; 
case 'eliminarEmpleados': 
eliminarEmpleados($serviciosReferencias); 
break; 
case 'insertarProductos': 
insertarProductos($serviciosReferencias); 
break; 
case 'modificarProductos': 
modificarProductos($serviciosReferencias); 
break; 
case 'eliminarProductos': 
eliminarProductos($serviciosReferencias); 
break;
 
case 'eliminarFoto':
	eliminarFoto($serviciosReferencias);
	break;
case 'traerProductoPorCodigo':
	traerProductoPorCodigo($serviciosReferencias);
	break;
		
case 'insertarProveedores': 
insertarProveedores($serviciosReferencias); 
break; 
case 'modificarProveedores': 
modificarProveedores($serviciosReferencias); 
break; 
case 'eliminarProveedores': 
eliminarProveedores($serviciosReferencias); 
break; 
case 'insertarUsuarios': 
insertarUsuarios($serviciosReferencias); 
break; 
case 'modificarUsuarios': 
modificarUsuarios($serviciosReferencias); 
break; 
case 'eliminarUsuarios': 
eliminarUsuarios($serviciosReferencias); 
break; 
case 'insertarDetallecompra': 
insertarDetallecompra($serviciosReferencias); 
break; 
case 'modificarDetallecompra': 
modificarDetallecompra($serviciosReferencias); 
break; 
case 'eliminarDetallecompra': 
eliminarDetallecompra($serviciosReferencias); 
break; 
case 'insertarDetallepedido': 
insertarDetallepedido($serviciosReferencias); 
break; 
case 'modificarDetallepedido': 
modificarDetallepedido($serviciosReferencias); 
break; 
case 'eliminarDetallepedido': 
eliminarDetallepedido($serviciosReferencias); 
break; 

case 'traerDetallepedidoPorPedido':
	traerDetallepedidoPorPedido($serviciosReferencias);
	break;

case 'insertarDetallepedidoaux':
insertarDetallepedidoaux($serviciosReferencias);
break;
case 'modificarDetallepedidoaux':
modificarDetallepedidoaux($serviciosReferencias);
break;
case 'eliminarDetallepedidoaux':
eliminarDetallepedidoaux($serviciosReferencias);
break; 

case 'insertarDetalleventa': 
insertarDetalleventa($serviciosReferencias); 
break; 
case 'modificarDetalleventa': 
modificarDetalleventa($serviciosReferencias); 
break; 
case 'eliminarDetalleventa': 
eliminarDetalleventa($serviciosReferencias); 
break; 
case 'insertarPedidos':
insertarPedidos($serviciosReferencias);
break;
case 'modificarPedidos':
modificarPedidos($serviciosReferencias);
break;
case 'eliminarPedidos':
eliminarPedidos($serviciosReferencias);
break;

case 'finalizarPedido':
	finalizarPedido($serviciosReferencias);
	break;
 
case 'insertarPredio_menu': 
insertarPredio_menu($serviciosReferencias); 
break; 
case 'modificarPredio_menu': 
modificarPredio_menu($serviciosReferencias); 
break; 
case 'eliminarPredio_menu': 
eliminarPredio_menu($serviciosReferencias); 
break; 
case 'insertarCategorias': 
insertarCategorias($serviciosReferencias); 
break; 
case 'modificarCategorias': 
modificarCategorias($serviciosReferencias); 
break; 
case 'eliminarCategorias': 
eliminarCategorias($serviciosReferencias); 
break; 
case 'insertarEstados': 
insertarEstados($serviciosReferencias); 
break; 
case 'modificarEstados': 
modificarEstados($serviciosReferencias); 
break; 
case 'eliminarEstados': 
eliminarEstados($serviciosReferencias); 
break; 
case 'insertarRoles': 
insertarRoles($serviciosReferencias); 
break; 
case 'modificarRoles': 
modificarRoles($serviciosReferencias); 
break; 
case 'eliminarRoles': 
eliminarRoles($serviciosReferencias); 
break; 
case 'insertarTipopago': 
insertarTipopago($serviciosReferencias); 
break; 
case 'modificarTipopago': 
modificarTipopago($serviciosReferencias); 
break; 
case 'eliminarTipopago': 
eliminarTipopago($serviciosReferencias); 
break; 
case 'insertarVenta': 
insertarVenta($serviciosReferencias); 
break; 
case 'modificarVenta': 
modificarVenta($serviciosReferencias); 
break; 
case 'eliminarVenta': 
eliminarVenta($serviciosReferencias); 
break; 

}

/* Fin */
/*

/* PARA Venta */

function insertarClientes($serviciosReferencias) { 
$nombrecompleto = $_POST['nombrecompleto']; 
$cuil = $_POST['cuil']; 
$dni = $_POST['dni']; 
$direccion = $_POST['direccion']; 
$telefono = $_POST['telefono']; 
$email = $_POST['email']; 
$observaciones = $_POST['observaciones']; 
$res = $serviciosReferencias->insertarClientes($nombrecompleto,$cuil,$dni,$direccion,$telefono,$email,$observaciones); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarClientes($serviciosReferencias) { 
$id = $_POST['id']; 
$nombrecompleto = $_POST['nombrecompleto']; 
$cuil = $_POST['cuil']; 
$dni = $_POST['dni']; 
$direccion = $_POST['direccion']; 
$telefono = $_POST['telefono']; 
$email = $_POST['email']; 
$observaciones = $_POST['observaciones']; 
$res = $serviciosReferencias->modificarClientes($id,$nombrecompleto,$cuil,$dni,$direccion,$telefono,$email,$observaciones); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarClientes($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarClientes($id); 
echo $res; 
} 
function insertarCompras($serviciosReferencias) { 
$reftipopago = $_POST['reftipopago']; 
$refproveedores = $_POST['refproveedores']; 
$refempleados = $_POST['refempleados']; 
$numero = $_POST['numero']; 
$fecha = $_POST['fecha']; 
$subtotal = $_POST['subtotal']; 
$iva = $_POST['iva']; 
$total = $_POST['total']; 
$estado = $_POST['estado']; 
$res = $serviciosReferencias->insertarCompras($reftipopago,$refproveedores,$refempleados,$numero,$fecha,$subtotal,$iva,$total,$estado); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarCompras($serviciosReferencias) { 
$id = $_POST['id']; 
$reftipopago = $_POST['reftipopago']; 
$refproveedores = $_POST['refproveedores']; 
$refempleados = $_POST['refempleados']; 
$numero = $_POST['numero']; 
$fecha = $_POST['fecha']; 
$subtotal = $_POST['subtotal']; 
$iva = $_POST['iva']; 
$total = $_POST['total']; 
$estado = $_POST['estado']; 
$res = $serviciosReferencias->modificarCompras($id,$reftipopago,$refproveedores,$refempleados,$numero,$fecha,$subtotal,$iva,$total,$estado); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarCompras($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarCompras($id); 
echo $res; 
} 
function insertarEmpleados($serviciosReferencias) { 
$nombre = $_POST['nombre']; 
$apellido = $_POST['apellido']; 
$sexo = $_POST['sexo']; 
$fechanac = $_POST['fechanac']; 
$direccion = $_POST['direccion']; 
$telefono = $_POST['telefono']; 
$celular = $_POST['celular']; 
$email = $_POST['email']; 
$dni = $_POST['dni']; 
$fechaing = $_POST['fechaing']; 
$sueldo = $_POST['sueldo']; 
$estado = $_POST['estado']; 
$res = $serviciosReferencias->insertarEmpleados($nombre,$apellido,$sexo,$fechanac,$direccion,$telefono,$celular,$email,$dni,$fechaing,$sueldo,$estado); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarEmpleados($serviciosReferencias) { 
$id = $_POST['id']; 
$nombre = $_POST['nombre']; 
$apellido = $_POST['apellido']; 
$sexo = $_POST['sexo']; 
$fechanac = $_POST['fechanac']; 
$direccion = $_POST['direccion']; 
$telefono = $_POST['telefono']; 
$celular = $_POST['celular']; 
$email = $_POST['email']; 
$dni = $_POST['dni']; 
$fechaing = $_POST['fechaing']; 
$sueldo = $_POST['sueldo']; 
$estado = $_POST['estado']; 
$res = $serviciosReferencias->modificarEmpleados($id,$nombre,$apellido,$sexo,$fechanac,$direccion,$telefono,$celular,$email,$dni,$fechaing,$sueldo,$estado); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarEmpleados($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarEmpleados($id); 
echo $res; 
} 



function traerProductoPorCodigo($servicios) {
	$codigo		= $_POST['idproducto'];
	
	$res = $servicios->traerProductosPorId($codigo);
	
	echo json_encode(toArray($res));
}


function insertarProductos($serviciosReferencias) { 
$codigo = $_POST['codigo']; 
$codigobarra = $_POST['codigobarra']; 
$nombre = $_POST['nombre']; 
$descripcion = $_POST['descripcion']; 
$stock = $_POST['stock']; 
$stockmin = $_POST['stockmin']; 
$preciocosto = $_POST['preciocosto']; 
$precioventa = $_POST['precioventa']; 
$utilidad = $precioventa - $preciocosto; 
$estado = $_POST['estado']; 
$imagen = ''; 
$refcategorias = $_POST['refcategorias']; 
$tipoimagen = ''; 
$unidades = $_POST['unidades']; 
	
	$existeCodigo = $serviciosReferencias->existeCodigo($codigo);
	
	if ($existeCodigo == 1) {
		$codigo = $serviciosReferencias->generarCodigo();	
	}
	
	$res = $serviciosReferencias->insertarProductos($codigo,$codigobarra,$nombre,$descripcion,$stock,$stockmin,$preciocosto,$precioventa,$utilidad,$estado,$imagen,$refcategorias,$tipoimagen,$unidades); 
	
	if ((integer)$res > 0) { 
		$imagenes = array("imagen" => 'imagen');
	
		foreach ($imagenes as $valor) {
			$serviciosReferencias->subirArchivo($valor,'galeria',$res);
		}
		echo ''; 
	} else { 
		echo 'Huvo un error al insertar datos';	
	} 
} 
function modificarProductos($serviciosReferencias) { 
$id = $_POST['id']; 
$codigo = $_POST['codigo']; 
$codigobarra = $_POST['codigobarra']; 
$nombre = $_POST['nombre']; 
$descripcion = $_POST['descripcion']; 
$stock = $_POST['stock']; 
$stockmin = $_POST['stockmin']; 
$preciocosto = $_POST['preciocosto']; 
$precioventa = $_POST['precioventa']; 
$utilidad = $precioventa - $preciocosto; 
$estado = $_POST['estado']; 
$imagen = ''; 
$refcategorias = $_POST['refcategorias']; 
$tipoimagen = ''; 
$unidades = $_POST['unidades'];
	
	$res = $serviciosReferencias->modificarProductos($id,$codigo,$codigobarra,$nombre,$descripcion,$stock,$stockmin,$preciocosto,$precioventa,$utilidad,$estado,$imagen,$refcategorias,$tipoimagen,$unidades); 
	
	if ($res == true) { 
		$imagenes = array("imagen" => 'imagen');
	
		foreach ($imagenes as $valor) {
			$serviciosReferencias->subirArchivo($valor,'galeria',$id);
		}
		echo ''; 
	} else { 
		echo 'Huvo un error al modificar datos'; 
	} 
} 
function eliminarProductos($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarProductos($id); 
echo $res; 
} 

function eliminarFoto($serviciosReferencias) {
	$id			=	$_POST['id'];
	echo $serviciosReferencias->eliminarFoto($id);
}


function insertarProveedores($serviciosReferencias) { 
$nombre = $_POST['nombre']; 
$cuit = $_POST['cuit']; 
$dni = $_POST['dni']; 
$direccion = $_POST['direccion']; 
$telefono = $_POST['telefono']; 
$celular = $_POST['celular']; 
$email = $_POST['email']; 
$observacionces = $_POST['observacionces']; 
$res = $serviciosReferencias->insertarProveedores($nombre,$cuit,$dni,$direccion,$telefono,$celular,$email,$observacionces); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarProveedores($serviciosReferencias) { 
$id = $_POST['id']; 
$nombre = $_POST['nombre']; 
$cuit = $_POST['cuit']; 
$dni = $_POST['dni']; 
$direccion = $_POST['direccion']; 
$telefono = $_POST['telefono']; 
$celular = $_POST['celular']; 
$email = $_POST['email']; 
$observacionces = $_POST['observacionces']; 
$res = $serviciosReferencias->modificarProveedores($id,$nombre,$cuit,$dni,$direccion,$telefono,$celular,$email,$observacionces); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarProveedores($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarProveedores($id); 
echo $res; 
} 
function insertarUsuarios($serviciosReferencias) { 
$usuario = $_POST['usuario']; 
$password = $_POST['password']; 
$refroles = $_POST['refroles']; 
$email = $_POST['email']; 
$nombrecompleto = $_POST['nombrecompleto']; 
$res = $serviciosReferencias->insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarUsuarios($serviciosReferencias) { 
$id = $_POST['id']; 
$usuario = $_POST['usuario']; 
$password = $_POST['password']; 
$refroles = $_POST['refroles']; 
$email = $_POST['email']; 
$nombrecompleto = $_POST['nombrecompleto']; 
$res = $serviciosReferencias->modificarUsuarios($id,$usuario,$password,$refroles,$email,$nombrecompleto); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarUsuarios($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarUsuarios($id); 
echo $res; 
} 
function insertarDetallecompra($serviciosReferencias) { 
$idcompra = $_POST['idcompra']; 
$idproducto = $_POST['idproducto']; 
$cantidad = $_POST['cantidad']; 
$precio = $_POST['precio']; 
$total = $_POST['total']; 
$res = $serviciosReferencias->insertarDetallecompra($idcompra,$idproducto,$cantidad,$precio,$total); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarDetallecompra($serviciosReferencias) { 
$id = $_POST['id']; 
$idcompra = $_POST['idcompra']; 
$idproducto = $_POST['idproducto']; 
$cantidad = $_POST['cantidad']; 
$precio = $_POST['precio']; 
$total = $_POST['total']; 
$res = $serviciosReferencias->modificarDetallecompra($id,$idcompra,$idproducto,$cantidad,$precio,$total); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarDetallecompra($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarDetallecompra($id); 
echo $res; 
} 
function insertarDetallepedido($serviciosReferencias) { 
$idpedido = $_POST['idpedido']; 
$idproducto = $_POST['idproducto']; 
$cantidad = $_POST['cantidad']; 
$precio = $_POST['precio']; 
$total = $_POST['total']; 
$res = $serviciosReferencias->insertarDetallepedido($idpedido,$idproducto,$cantidad,$precio,$total); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarDetallepedido($serviciosReferencias) { 
$id = $_POST['id']; 
$idpedido = $_POST['idpedido']; 
$idproducto = $_POST['idproducto']; 
$cantidad = $_POST['cantidad']; 
$precio = $_POST['precio']; 
$total = $_POST['total']; 
$res = $serviciosReferencias->modificarDetallepedido($id,$idpedido,$idproducto,$cantidad,$precio,$total); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarDetallepedido($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarDetallepedido($id); 
echo $res; 
} 


function traerDetallepedidoPorPedido($serviciosReferencias) {
	$id		=	$_POST['id'];
	
	$res	= $serviciosReferencias->traerDetallepedidoPorPedido($id);
	$cadRows='';
	$total = 0;
	
	while ($row = mysql_fetch_array($res)) {
		$total += $row['total'];
			$cadsubRows = '';
			$cadRows = $cadRows.'
			
					<tr class="'.$row[0].'">
                        	';
			
			
			for ($i=1;$i<=4;$i++) {
				
				$cadsubRows = $cadsubRows.'<td><div style="height:20px;overflow:auto;">'.$row[$i].'</div></td>';	
			}
			
			$cadRows = $cadRows.'
								'.$cadsubRows.'</tr>';
			
	}
			
	
	$cad	= '';
	$cad = $cad.'
			<table class="table table-striped table-responsive">
            	<thead>
                	<tr>
                        <th>Producto</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Sub-Total</th>
                    </tr>
                </thead>
                <tbody>

                	'.($cadRows).'
                </tbody>
				<tfoot>
					<tr>
						<td align="right" style="font-size:14px; font-weight: bold;" colspan="4">Total: <span style="color:red;">$'.number_format($total,2,',','.').'</span></td>
					</tr>
				</tfoot>
            </table>
			<div style="margin-bottom:85px; margin-right:60px;"></div>
		
		';	
	echo $cad;
}


function insertarDetallepedidoaux($serviciosReferencias) {
$refproductos = $_POST['refproductos'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];
$total = $_POST['total'];
$res = $serviciosReferencias->insertarDetallepedidoaux($refproductos,$cantidad,$precio,$total);
if ((integer)$res > 0) {
echo $res;
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarDetallepedidoaux($serviciosReferencias) {
$id = $_POST['id'];
$refproductos = $_POST['refproductos'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];
$total = $_POST['total'];
$res = $serviciosReferencias->modificarDetallepedidoaux($id,$refproductos,$cantidad,$precio,$total);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarDetallepedidoaux($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarDetallepedidoaux($id);
echo $res;
} 


function insertarDetalleventa($serviciosReferencias) { 
$idventa = $_POST['idventa']; 
$idproducto = $_POST['idproducto']; 
$cantidad = $_POST['cantidad']; 
$costo = $_POST['costo']; 
$precio = $_POST['precio']; 
$total = $_POST['total']; 
$res = $serviciosReferencias->insertarDetalleventa($idventa,$idproducto,$cantidad,$costo,$precio,$total); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarDetalleventa($serviciosReferencias) { 
$id = $_POST['id']; 
$idventa = $_POST['idventa']; 
$idproducto = $_POST['idproducto']; 
$cantidad = $_POST['cantidad']; 
$costo = $_POST['costo']; 
$precio = $_POST['precio']; 
$total = $_POST['total']; 
$res = $serviciosReferencias->modificarDetalleventa($id,$idventa,$idproducto,$cantidad,$costo,$precio,$total); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarDetalleventa($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarDetalleventa($id); 
echo $res; 
} 

function finalizarPedido($serviciosReferencias) {
	$id = $_POST['id'];
	$res = $serviciosReferencias->finalizarPedido($id);
	echo $res;	
}

function insertarPedidos($serviciosReferencias) {
	
	$fechasolicitud = date('Y-m-d');
	$fechaentrega = $_POST['fechaentrega'];
	
	$refestados = 1;
	$referencia = $_POST['referencia'];
	$observacion = $_POST['observaciones'];

	$res = $serviciosReferencias->insertarPedidos($fechasolicitud,$fechaentrega,0,$refestados,$referencia,$observacion);

	if ((integer)$res > 0) {
		$serviciosReferencias->insertarDetallepedidoDesdeTemporal($res);
		$serviciosReferencias->vaciarDetallepedidoaux();
		echo '';
	} else {
		echo 'Huvo un error al insertar datos';
	}
}
function modificarPedidos($serviciosReferencias) {
$id = $_POST['id'];
$fechasolicitud = $_POST['fechasolicitud'];
$fechaentrega = $_POST['fechaentrega'];
$total = $_POST['total'];
$refestados = $_POST['refestados'];
$referencia = $_POST['referencia'];
$observacion = $_POST['observacion'];
$res = $serviciosReferencias->modificarPedidos($id,$fechasolicitud,$fechaentrega,$total,$refestados,$referencia,$observacion);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarPedidos($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarPedidos($id);
echo $res;
} 
function insertarPredio_menu($serviciosReferencias) { 
$url = $_POST['url']; 
$icono = $_POST['icono']; 
$nombre = $_POST['nombre']; 
$Orden = $_POST['Orden']; 
$hover = $_POST['hover']; 
$permiso = $_POST['permiso']; 
$res = $serviciosReferencias->insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarPredio_menu($serviciosReferencias) { 
$id = $_POST['id']; 
$url = $_POST['url']; 
$icono = $_POST['icono']; 
$nombre = $_POST['nombre']; 
$Orden = $_POST['Orden']; 
$hover = $_POST['hover']; 
$permiso = $_POST['permiso']; 
$res = $serviciosReferencias->modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarPredio_menu($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarPredio_menu($id); 
echo $res; 
} 
function insertarCategorias($serviciosReferencias) { 
$descripcion = $_POST['descripcion']; 
$res = $serviciosReferencias->insertarCategorias($descripcion); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarCategorias($serviciosReferencias) { 
$id = $_POST['id']; 
$descripcion = $_POST['descripcion']; 
$res = $serviciosReferencias->modificarCategorias($id,$descripcion); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarCategorias($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarCategorias($id); 
echo $res; 
} 
function insertarEstados($serviciosReferencias) { 
$estado = $_POST['estado']; 
$icono = $_POST['icono']; 
$res = $serviciosReferencias->insertarEstados($estado,$icono); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarEstados($serviciosReferencias) { 
$id = $_POST['id']; 
$estado = $_POST['estado']; 
$icono = $_POST['icono']; 
$res = $serviciosReferencias->modificarEstados($id,$estado,$icono); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarEstados($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarEstados($id); 
echo $res; 
} 
function insertarRoles($serviciosReferencias) { 
$descripcion = $_POST['descripcion']; 
if (isset($_POST['activo'])) { 
$activo	= 1; 
} else { 
$activo = 0; 
} 
$res = $serviciosReferencias->insertarRoles($descripcion,$activo); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarRoles($serviciosReferencias) { 
$id = $_POST['id']; 
$descripcion = $_POST['descripcion']; 
if (isset($_POST['activo'])) { 
$activo	= 1; 
} else { 
$activo = 0; 
} 
$res = $serviciosReferencias->modificarRoles($id,$descripcion,$activo); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarRoles($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarRoles($id); 
echo $res; 
} 
function insertarTipopago($serviciosReferencias) { 
$descripcion = $_POST['descripcion']; 
$res = $serviciosReferencias->insertarTipopago($descripcion); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarTipopago($serviciosReferencias) { 
$id = $_POST['id']; 
$descripcion = $_POST['descripcion']; 
$res = $serviciosReferencias->modificarTipopago($id,$descripcion); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarTipopago($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarTipopago($id); 
echo $res; 
} 
function insertarVenta($serviciosReferencias) { 
$idtipodocumento = $_POST['idtipodocumento']; 
$idusuario = $_POST['idusuario']; 
$idempleado = $_POST['idempleado']; 
$serie = $_POST['serie']; 
$numero = $_POST['numero']; 
$fecha = $_POST['fecha']; 
$totalventa = $_POST['totalventa']; 
$igv = $_POST['igv']; 
$totalpagar = $_POST['totalpagar']; 
$estado = $_POST['estado']; 
$res = $serviciosReferencias->insertarVenta($idtipodocumento,$idusuario,$idempleado,$serie,$numero,$fecha,$totalventa,$igv,$totalpagar,$estado); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	
} 
} 
function modificarVenta($serviciosReferencias) { 
$id = $_POST['id']; 
$idtipodocumento = $_POST['idtipodocumento']; 
$idusuario = $_POST['idusuario']; 
$idempleado = $_POST['idempleado']; 
$serie = $_POST['serie']; 
$numero = $_POST['numero']; 
$fecha = $_POST['fecha']; 
$totalventa = $_POST['totalventa']; 
$igv = $_POST['igv']; 
$totalpagar = $_POST['totalpagar']; 
$estado = $_POST['estado']; 
$res = $serviciosReferencias->modificarVenta($id,$idtipodocumento,$idusuario,$idempleado,$serie,$numero,$fecha,$totalventa,$igv,$totalpagar,$estado); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarVenta($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarVenta($id); 
echo $res; 
} 

/* Fin */

////////////////////////// FIN DE TRAER DATOS ////////////////////////////////////////////////////////////

//////////////////////////  BASICO  /////////////////////////////////////////////////////////////////////////

function toArray($query)
{
    $res = array();
    while ($row = @mysql_fetch_array($query)) {
        $res[] = $row;
    }
    return $res;
}


function entrar($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	echo $serviciosUsuarios->loginUsuario($email,$pass);
}


function registrar($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroll'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';	
	} else {
		echo $res;	
	}
}


function insertarUsuario($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';	
	} else {
		echo $res;	
	}
}


function modificarUsuario($serviciosUsuarios) {
	$id					=	$_POST['id'];
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	echo $serviciosUsuarios->modificarUsuario($id,$usuario,$password,$refroll,$email,$nombre);
}


function enviarMail($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	//$idempresa  =	$_POST['idempresa'];
	
	echo $serviciosUsuarios->login($email,$pass);
}


function devolverImagen($nroInput) {
	
	if( $_FILES['archivo'.$nroInput]['name'] != null && $_FILES['archivo'.$nroInput]['size'] > 0 ){
	// Nivel de errores
	  error_reporting(E_ALL);
	  $altura = 100;
	  // Constantes
	  # Altura de el thumbnail en píxeles
	  //define("ALTURA", 100);
	  # Nombre del archivo temporal del thumbnail
	  //define("NAMETHUMB", "/tmp/thumbtemp"); //Esto en servidores Linux, en Windows podría ser:
	  //define("NAMETHUMB", "c:/windows/temp/thumbtemp"); //y te olvidas de los problemas de permisos
	  $NAMETHUMB = "c:/windows/temp/thumbtemp";
	  # Servidor de base de datos
	  //define("DBHOST", "localhost");
	  # nombre de la base de datos
	  //define("DBNAME", "portalinmobiliario");
	  # Usuario de base de datos
	  //define("DBUSER", "root");
	  # Password de base de datos
	  //define("DBPASSWORD", "");
	  // Mime types permitidos
	  $mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
	  // Variables de la foto
	  $name = $_FILES["archivo".$nroInput]["name"];
	  $type = $_FILES["archivo".$nroInput]["type"];
	  $tmp_name = $_FILES["archivo".$nroInput]["tmp_name"];
	  $size = $_FILES["archivo".$nroInput]["size"];
	  // Verificamos si el archivo es una imagen válida
	  if(!in_array($type, $mimetypes))
		die("El archivo que subiste no es una imagen válida");
	  // Creando el thumbnail
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  $img = imagecreatefromjpeg($tmp_name);
		  break;
		case $mimetypes[2]:
		  $img = imagecreatefromgif($tmp_name);
		  break;
		case $mimetypes[3]:
		  $img = imagecreatefrompng($tmp_name);
		  break;
	  }
	  
	  $datos = getimagesize($tmp_name);
	  
	  $ratio = ($datos[1]/$altura);
	  $ancho = round($datos[0]/$ratio);
	  $thumb = imagecreatetruecolor($ancho, $altura);
	  imagecopyresized($thumb, $img, 0, 0, 0, 0, $ancho, $altura, $datos[0], $datos[1]);
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  imagejpeg($thumb, $NAMETHUMB);
			  break;
		case $mimetypes[2]:
		  imagegif($thumb, $NAMETHUMB);
		  break;
		case $mimetypes[3]:
		  imagepng($thumb, $NAMETHUMB);
		  break;
	  }
	  // Extrae los contenidos de las fotos
	  # contenido de la foto original
	  $fp = fopen($tmp_name, "rb");
	  $tfoto = fread($fp, filesize($tmp_name));
	  $tfoto = addslashes($tfoto);
	  fclose($fp);
	  # contenido del thumbnail
	  $fp = fopen($NAMETHUMB, "rb");
	  $tthumb = fread($fp, filesize($NAMETHUMB));
	  $tthumb = addslashes($tthumb);
	  fclose($fp);
	  // Borra archivos temporales si es que existen
	  //@unlink($tmp_name);
	  //@unlink(NAMETHUMB);
	} else {
		$tfoto = '';
		$type = '';
	}
	$tfoto = utf8_decode($tfoto);
	return array('tfoto' => $tfoto, 'type' => $type);	
}


?>