<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Buenos_Aires');

class ServiciosReferencias {

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}


///**********  PARA SUBIR ARCHIVOS  ***********************//////////////////////////
	function borrarDirecctorio($dir) {
		array_map('unlink', glob($dir."/*.*"));	
	
	}
	
	function borrarArchivo($id,$archivo) {
		$sql	=	"delete from images where idfoto =".$id;
		
		$res =  unlink("./../archivos/".$archivo);
		if ($res)
		{
			$this->query($sql,0);	
		}
		return $res;
	}
	
	
	function existeArchivo($id,$nombre,$type) {
		$sql		=	"select * from images where refproyecto =".$id." and imagen = '".$nombre."' and type = '".$type."'";
		$resultado  =   $this->query($sql,0);
			   
			   if(mysql_num_rows($resultado)>0){
	
				   return mysql_result($resultado,0,0);
	
			   }
	
			   return 0;	
	}
	
	function sanear_string($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
 
 
    return $string;
}

	function subirArchivo($file,$carpeta,$id) {
		
		
		
		$dir_destino = '../archivos/'.$carpeta.'/'.$id.'/';
		$imagen_subida = $dir_destino . $this->sanear_string(str_replace(' ','',basename($_FILES[$file]['name'])));
		
		$noentrar = '../imagenes/index.php';
		$nuevo_noentrar = '../archivos/'.$carpeta.'/'.$id.'/'.'index.php';
		
		if (!file_exists($dir_destino)) {
			mkdir($dir_destino, 0777);
		}
		
		 
		if(!is_writable($dir_destino)){
			
			echo "no tiene permisos";
			
		}	else	{
			if ($_FILES[$file]['tmp_name'] != '') {
				if(is_uploaded_file($_FILES[$file]['tmp_name'])){
					$this->eliminarFotoPorObjeto($id);
					/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
					echo "Mostrar contenido\n";
					echo $imagen_subida;*/
					if (move_uploaded_file($_FILES[$file]['tmp_name'], $imagen_subida)) {
						
						$archivo = $this->sanear_string($_FILES[$file]["name"]);
						$tipoarchivo = $_FILES[$file]["type"];
						
						if ($this->existeArchivo($id,$archivo,$tipoarchivo) == 0) {
							$sql	=	"insert into images(idfoto,refproyecto,imagen,type) values ('',".$id.",'".str_replace(' ','',$archivo)."','".$tipoarchivo."')";
							$this->query($sql,1);
						}
						echo "";
						
						copy($noentrar, $nuevo_noentrar);
		
					} else {
						echo "Posible ataque de carga de archivos!\n";
					}
				}else{
					echo "Posible ataque del archivo subido: ";
					echo "nombre del archivo '". $_FILES[$file]['tmp_name'] . "'.";
				}
			}
		}	
	}


	
	function TraerFotosRelacion($id) {
		$sql    =   "select 'galeria',s.idproducto,f.imagen,f.idfoto,f.type
							from dbproductos s
							
							inner
							join images f
							on	s.idproducto = f.refproyecto

							where s.idproducto = ".$id;
		$result =   $this->query($sql, 0);
		return $result;
	}
	
	
	function eliminarFoto($id)
	{
		
		$sql		=	"select concat('galeria','/',s.idproducto,'/',f.imagen) as archivo
							from dbproductos s
							
							inner
							join images f
							on	s.idproducto = f.refproyecto

							where f.idfoto =".$id;
		$resImg		=	$this->query($sql,0);
		
		if (mysql_num_rows($resImg)>0) {
			$res 		=	$this->borrarArchivo($id,mysql_result($resImg,0,0));
		} else {
			$res = true;
		}
		if ($res == false) {
			return 'Error al eliminar datos';
		} else {
			return '';
		}
	}
	
	
	function eliminarFotoPorObjeto($id)
	{
		
		$sql		=	"select concat('galeria','/',s.idproducto,'/',f.imagen) as archivo,f.idfoto
							from dbproductos s
							
							inner
							join images f
							on	s.idproducto = f.refproyecto

							where s.idproducto =".$id;
		$resImg		=	$this->query($sql,0);
		
		if (mysql_num_rows($resImg)>0) {
			$res 		=	$this->borrarArchivo(mysql_result($resImg,0,1),mysql_result($resImg,0,0));
		} else {
			$res = true;
		}
		if ($res == false) {
			return 'Error al eliminar datos';
		} else {
			return '';
		}
	}

/* fin archivos */




/* PARA Clientes */

function insertarClientes($nombrecompleto,$cuil,$dni,$direccion,$telefono,$email,$observaciones) { 
$sql = "insert into dbclientes(idcliente,nombrecompleto,cuil,dni,direccion,telefono,email,observaciones) 
values ('','".utf8_decode($nombrecompleto)."','".utf8_decode($cuil)."','".utf8_decode($dni)."','".utf8_decode($direccion)."','".utf8_decode($telefono)."','".utf8_decode($email)."','".utf8_decode($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarClientes($id,$nombrecompleto,$cuil,$dni,$direccion,$telefono,$email,$observaciones) { 
$sql = "update dbclientes 
set 
nombrecompleto = '".utf8_decode($nombrecompleto)."',cuil = '".utf8_decode($cuil)."',dni = '".utf8_decode($dni)."',direccion = '".utf8_decode($direccion)."',telefono = '".utf8_decode($telefono)."',email = '".utf8_decode($email)."',observaciones = '".utf8_decode($observaciones)."' 
where idcliente =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarClientes($id) { 
$sql = "delete from dbclientes where idcliente =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerClientes() { 
$sql = "select 
c.idcliente,
c.nombrecompleto,
c.cuil,
c.dni,
c.direccion,
c.telefono,
c.email,
c.observaciones
from dbclientes c 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerClientesPorId($id) { 
$sql = "select idcliente,nombrecompleto,cuil,dni,direccion,telefono,email,observaciones from dbclientes where idcliente =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbclientes*/

/* PARA Empleados */

function insertarEmpleados($nombre,$apellido,$sexo,$fechanac,$direccion,$telefono,$celular,$email,$dni,$fechaing,$sueldo,$estado) { 
$sql = "insert into dbempleados(idempleado,nombre,apellido,sexo,fechanac,direccion,telefono,celular,email,dni,fechaing,sueldo,estado) 
values ('','".utf8_decode($nombre)."','".utf8_decode($apellido)."','".utf8_decode($sexo)."','".utf8_decode($fechanac)."','".utf8_decode($direccion)."','".utf8_decode($telefono)."','".utf8_decode($celular)."','".utf8_decode($email)."','".utf8_decode($dni)."','".utf8_decode($fechaing)."',".$sueldo.",'".utf8_decode($estado)."')";
$res = $this->query($sql,1); 
return $res; 
} 


function modificarEmpleados($id,$nombre,$apellido,$sexo,$fechanac,$direccion,$telefono,$celular,$email,$dni,$fechaing,$sueldo,$estado) { 
$sql = "update dbempleados 
set 
nombre = '".utf8_decode($nombre)."',apellido = '".utf8_decode($apellido)."',sexo = '".utf8_decode($sexo)."',fechanac = '".utf8_decode($fechanac)."',direccion = '".utf8_decode($direccion)."',telefono = '".utf8_decode($telefono)."',celular = '".utf8_decode($celular)."',email = '".utf8_decode($email)."',dni = '".utf8_decode($dni)."',fechaing = '".utf8_decode($fechaing)."',sueldo = ".$sueldo.",estado = '".utf8_decode($estado)."' 
where idempleado =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarEmpleados($id) { 
$sql = "delete from dbempleados where idempleado =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEmpleados() { 
$sql = "select 
e.idempleado,
e.nombre,
e.apellido,
e.dni,
e.sexo,
e.fechanac,
e.direccion,
e.telefono,
e.celular,
e.email,
e.fechaing,
e.sueldo,
e.estado
from dbempleados e 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEmpleadosPorId($id) { 
$sql = "select idempleado,nombre,apellido,sexo,fechanac,direccion,telefono,celular,email,dni,fechaing,sueldo,estado from dbempleados where idempleado =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbempleados*/


/* PARA Productos */

function zerofill($valor, $longitud){
 $res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
 return $res;
}

function generarCodigo() {
	$sql = "select idproducto from dbproductos order by idproducto desc limit 1";
	$res = $this->query($sql,0);
	if (mysql_num_rows($res)>0) {
		$c = $this->zerofill(mysql_result($res,0,0)+1,6);
		return "PRO".$c;
	}
	return "PRO000001";
}

function existeCodigo($codigo) {
	$sql = "select idproducto from dbproductos where codigo ='".$codigo."'";
	$res = $this->query($sql,0);
	if (mysql_num_rows($res)>0) {
		return 1;
	}
	return 0;
}

function insertarProductos($codigo,$codigobarra,$nombre,$descripcion,$stock,$stockmin,$preciocosto,$precioventa,$utilidad,$estado,$imagen,$refcategorias,$tipoimagen,$unidades) { 
$sql = "insert into dbproductos(idproducto,codigo,codigobarra,nombre,descripcion,stock,stockmin,preciocosto,precioventa,utilidad,estado,imagen,refcategorias,tipoimagen,unidades) 
values ('','".utf8_decode($codigo)."','".utf8_decode($codigobarra)."','".utf8_decode($nombre)."','".utf8_decode($descripcion)."',".($stock=='' ? 0 : $stock).",".($stockmin == '' ? 0 : $stockmin).",".($preciocosto == '' ?  0 : $preciocosto).",".($precioventa == '' ? 0 : $precioventa).",".$utilidad.",'".utf8_decode($estado)."','".utf8_decode($imagen)."',".$refcategorias.",'".utf8_decode($tipoimagen)."',".($unidades=='' ? 1 : $unidades).")";
$res = $this->query($sql,1); 
return $res; 
} 


function modificarProductos($id,$codigo,$codigobarra,$nombre,$descripcion,$stock,$stockmin,$preciocosto,$precioventa,$utilidad,$estado,$imagen,$refcategorias,$tipoimagen,$unidades) { 
$sql = "update dbproductos 
set 
codigo = '".utf8_decode($codigo)."',codigobarra = '".utf8_decode($codigobarra)."',nombre = '".utf8_decode($nombre)."',descripcion = '".utf8_decode($descripcion)."',stock = ".$stock.",stockmin = ".$stockmin.",preciocosto = ".$preciocosto.",precioventa = ".$precioventa.",utilidad = ".$utilidad.",estado = '".utf8_decode($estado)."',imagen = '".utf8_decode($imagen)."',refcategorias = ".$refcategorias.",tipoimagen = '".utf8_decode($tipoimagen)."', unidades = ".($unidades=='' ? 1 : $unidades)."
where idproducto =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarProductos($id) { 
$this->eliminarFotoPorObjeto($id);
$sql = "delete from dbproductos where idproducto =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerProductos() { 
$sql = "select 
p.idproducto,
p.codigo,
p.codigobarra,
p.nombre,
p.descripcion,
p.stock,
p.stockmin,
p.precioventa,

p.imagen,
cat.descripcion,
p.unidades,
p.refcategorias,
p.estado,
p.utilidad,
p.preciocosto,
p.tipoimagen
from dbproductos p 
inner join tbcategorias cat ON cat.idcategoria = p.refcategorias 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerProductosFaltantes() { 
$sql = "select 
p.idproducto,
p.nombre,
(p.stockmin - p.stock) + p.stockmin as cantidad,
p.stock,
p.stockmin,
p.preciocosto,

p.precioventa,
p.imagen,
cat.descripcion,
p.unidades,
p.refcategorias,
p.estado,
p.utilidad,

p.codigo,
p.codigobarra,
p.descripcion,
p.tipoimagen
from dbproductos p 
inner join tbcategorias cat ON cat.idcategoria = p.refcategorias 
where p.stockmin >= p.stock
order by nombre"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerProductosPorId($id) { 
$sql = "select idproducto,codigo,codigobarra,nombre,descripcion,stock,stockmin,preciocosto,precioventa,utilidad,estado,imagen,refcategorias,tipoimagen from dbproductos where idproducto =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbproductos*/


/* PARA Proveedores */

function insertarProveedores($nombre,$cuit,$dni,$direccion,$telefono,$celular,$email,$observacionces) { 
$sql = "insert into dbproveedores(idproveedor,nombre,cuit,dni,direccion,telefono,celular,email,observacionces) 
values ('','".utf8_decode($nombre)."','".utf8_decode($cuit)."','".utf8_decode($dni)."','".utf8_decode($direccion)."','".utf8_decode($telefono)."','".utf8_decode($celular)."','".utf8_decode($email)."','".utf8_decode($observacionces)."')";
$res = $this->query($sql,1); 
return $res; 
} 


function modificarProveedores($id,$nombre,$cuit,$dni,$direccion,$telefono,$celular,$email,$observacionces) { 
$sql = "update dbproveedores 
set 
nombre = '".utf8_decode($nombre)."',cuit = '".utf8_decode($cuit)."',dni = '".utf8_decode($dni)."',direccion = '".utf8_decode($direccion)."',telefono = '".utf8_decode($telefono)."',celular = '".utf8_decode($celular)."',email = '".utf8_decode($email)."',observacionces = '".utf8_decode($observacionces)."' 
where idproveedor =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarProveedores($id) { 
$sql = "delete from dbproveedores where idproveedor =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerProveedores() { 
$sql = "select 
p.idproveedor,
p.nombre,
p.cuit,
p.dni,
p.direccion,
p.telefono,
p.celular,
p.email,
p.observacionces
from dbproveedores p 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerProveedoresPorId($id) { 
$sql = "select idproveedor,nombre,cuit,dni,direccion,telefono,celular,email,observacionces from dbproveedores where idproveedor =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbproveedores*/



/* PARA Detallepedidoaux */

function insertarDetallepedidoaux($refproductos,$cantidad,$precio,$total) {
$sql = "insert into dbdetallepedidoaux(iddetallepedidoaux,refproductos,cantidad,precio,total)
values ('',".$refproductos.",".$cantidad.",".$precio.",".$total.")";
$res = $this->query($sql,1);
return $res;
}


function modificarDetallepedidoaux($id,$refproductos,$cantidad,$precio,$total) {
$sql = "update dbdetallepedidoaux
set
refproductos = ".$refproductos.",cantidad = ".$cantidad.",precio = ".$precio.",total = ".$total."
where iddetallepedidoaux =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarDetallepedidoaux($id) {
$sql = "delete from dbdetallepedidoaux where iddetallepedidoaux =".$id;
$res = $this->query($sql,0);
return $res;
}

function vaciarDetallepedidoaux() {
$sql = "delete from dbdetallepedidoaux ";
$res = $this->query($sql,0);
return $res;
}


function traerDetallepedidoaux() {
$sql = "select
d.iddetallepedidoaux,
d.refproductos,
p.nombre,
d.cantidad,
p.stock,
p.preciocosto as precio,
d.total
from dbdetallepedidoaux d
inner
join	dbproductos p
on		p.idproducto = d.refproductos
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerDetallepedidoauxPorId($id) {
$sql = "select iddetallepedidoaux,refproductos,cantidad,precio,total from dbdetallepedidoaux where iddetallepedidoaux =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbdetallepedidoaux*/


/* PARA Pedidos */

function insertarPedidos($fechasolicitud,$fechaentrega,$total,$refestados,$referencia,$observacion) {
$sql = "insert into dbpedidos(idpedido,fechasolicitud,fechaentrega,total,refestados,referencia,observacion)
values ('','".utf8_decode($fechasolicitud)."','".utf8_decode($fechaentrega)."',".$total.",".$refestados.",'".utf8_decode($referencia)."','".utf8_decode($observacion)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarPedidos($id,$fechasolicitud,$fechaentrega,$total,$refestados,$referencia,$observacion) {
$sql = "update dbpedidos
set
fechasolicitud = '".utf8_decode($fechasolicitud)."',fechaentrega = '".utf8_decode($fechaentrega)."',total = ".$total.",refestados = ".$refestados.",referencia = '".utf8_decode($referencia)."',observacion = '".utf8_decode($observacion)."'
where idpedido =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarPedidos($id) {

$sqlDel = "delete from dbdetallepedido where refpedidos =".$id;	
$this->query($sqlDel,0);

$sql = "delete from dbpedidos where idpedido =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerPedidos() {
$sql = "select
p.idpedido,
p.referencia,
p.fechasolicitud,
p.fechaentrega,
p.total,
est.estado,
p.observacion,
p.refestados
from dbpedidos p
inner join tbestados est ON est.idestado = p.refestados
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerPedidosPorId($id) {
$sql = "select idpedido,fechasolicitud,fechaentrega,total,refestados,referencia,observacion from dbpedidos where idpedido =".$id;
$res = $this->query($sql,0);
return $res;
}

function finalizarPedido($id) {
	$sql = "update dbpedidos set refestados = 3 where idpedido =".$id;
	$res = $this->query($sql,0);
	return $res;	
}

/* Fin */
/* /* Fin de la Tabla: dbpedidos*/

/* PARA Detallepedido */

function insertarDetallepedidoDesdeTemporal($idpedido) {
	$sql	=	"INSERT INTO dbdetallepedido (iddetallepedido,refpedidos,refproductos,cantidad,precio,total,falto)
				  SELECT '', ".$idpedido.", d.refproductos, d.cantidad, p.preciocosto, d.cantidad * p.preciocosto, 0
				  FROM dbdetallepedidoaux  d
					inner
					join	dbproductos p
					on		p.idproducto = d.refproductos;";	
				  
	$res = $this->query($sql,1);
	
	$sqlUp = "update dbpedidos
				set total = (SELECT sum(d.cantidad * p.preciocosto)
				  FROM dbdetallepedidoaux d
					inner
					join	dbproductos p
					on		p.idproducto = d.refproductos)
			  where idpedido = ".$idpedido;
	$res2 = $this->query($sqlUp,0);		  
	
	return $res;			  
}

function insertarDetallepedido($refpedidos,$refproductos,$cantidad,$precio,$total,$falto) {
$sql = "insert into dbdetallepedido(iddetallepedido,refpedidos,refproductos,cantidad,precio,total,falto)
values ('',".$refpedidos.",".$refproductos.",".$cantidad.",".$precio.",".$total.",".$falto.")";
$res = $this->query($sql,1);
return $res;
}


function modificarDetallepedido($id,$refpedidos,$refproductos,$cantidad,$precio,$total,$falto) {
$sql = "update dbdetallepedido
set
refpedidos = ".$refpedidos.",refproductos = ".$refproductos.",cantidad = ".$cantidad.",precio = ".$precio.",total = ".$total.",falto = ".$falto."
where iddetallepedido =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarDetallepedido($id) {
$sql = "delete from dbdetallepedido where iddetallepedido =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerDetallepedido() {
$sql = "select
d.iddetallepedido,
pro.nombre,
d.cantidad,
d.precio,
d.total,
d.falto,
d.refpedidos,
d.refproductos,
from dbdetallepedido d
inner join dbpedidos ped ON ped.idpedido = d.refpedidos
inner join tbestados es ON es.idestado = ped.refestados
inner join dbproductos pro ON pro.idproducto = d.refproductos
inner join tbcategorias ca ON ca.idcategoria = pro.refcategorias
order by 1";
$res = $this->query($sql,0);
return $res;
}

function traerDetallepedidoPorPedido($idPedido) {
$sql = "select
d.iddetallepedido,
pro.nombre,
d.cantidad,
d.precio,
d.total,
d.falto,
d.refpedidos,
d.refproductos,
pro.stock,
ped.fechasolicitud,
ped.fechaentrega,
ped.referencia,
pro.codigo,
es.estado,
es.idestado,
ped.observacion
from dbdetallepedido d
inner join dbpedidos ped ON ped.idpedido = d.refpedidos
inner join tbestados es ON es.idestado = ped.refestados
inner join dbproductos pro ON pro.idproducto = d.refproductos
inner join tbcategorias ca ON ca.idcategoria = pro.refcategorias
where	ped.idpedido = ".$idPedido."
order by 1";
$res = $this->query($sql,0);
return $res;
}

function registrarEntradaPorPedidoProducto($iddetallepedido, $cantidad) {
	$sql = "update dbproductos 
				set stock = (stock + ".$cantidad.")
				where idproducto = (select d.refproductos
						from dbdetallepedido d
						inner join dbpedidos ped ON ped.idpedido = d.refpedidos
						where	d.iddetallepedido = ".$iddetallepedido.");";	
	$res = $this->query($sql,0);
	return $sql;
}

function registrarFaltantes($iddetallepedido, $cantidad) {
	$sql = "update dbdetallepedido
				set falto = (cantidad - ".$cantidad.")
						where	iddetallepedido = ".$iddetallepedido;	
	$res = $this->query($sql,0);
	return $res;	
}

function determinarEstado($idpedido) {
	$sql = 'SELECT sum(falto) FROM dbdetallepedido where refpedidos ='.$idpedido;
	$res = $this->query($sql,0);
	if (mysql_result($res,0,0)== 0) {
		$sqlUpdate = "update dbpedidos
						set refestados = 3
						where	idpedido = ".$idpedido;	
	
	} else {
		$sqlUpdate = "update dbpedidos
						set refestados = 4
						where	idpedido = ".$idpedido;	
	}
	$resUp = $this->query($sqlUpdate,0);
}


function traerDetallepedidoPorId($id) {
$sql = "select iddetallepedido,refpedidos,refproductos,cantidad,precio,total,falto from dbdetallepedido where iddetallepedido =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbdetallepedido*/

/* PARA Usuarios */

function insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto) { 
$sql = "insert into dbusuarios(idusuario,usuario,password,refroles,email,nombrecompleto) 
values ('','".utf8_decode($usuario)."','".utf8_decode($password)."',".$refroles.",'".utf8_decode($email)."','".utf8_decode($nombrecompleto)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarUsuarios($id,$usuario,$password,$refroles,$email,$nombrecompleto) { 
$sql = "update dbusuarios 
set 
usuario = '".utf8_decode($usuario)."',password = '".utf8_decode($password)."',refroles = ".$refroles.",email = '".utf8_decode($email)."',nombrecompleto = '".utf8_decode($nombrecompleto)."' 
where idusuario =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarUsuarios($id) { 
$sql = "delete from dbusuarios where idusuario =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerUsuarios() { 
$sql = "select 
u.idusuario,
u.usuario,
u.password,
u.refroles,
u.email,
u.nombrecompleto
from dbusuarios u 
inner join tbroles rol ON rol.idrol = u.refroles 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerUsuariosPorId($id) { 
$sql = "select idusuario,usuario,password,refroles,email,nombrecompleto from dbusuarios where idusuario =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbusuarios*/


/* PARA Categorias */

function insertarCategorias($descripcion) { 
$sql = "insert into tbcategorias(idcategoria,descripcion) 
values ('','".utf8_decode($descripcion)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarCategorias($id,$descripcion) { 
$sql = "update tbcategorias 
set 
descripcion = '".utf8_decode($descripcion)."' 
where idcategoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarCategorias($id) { 
$sql = "delete from tbcategorias where idcategoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerCategorias() { 
$sql = "select 
c.idcategoria,
c.descripcion
from tbcategorias c 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerCategoriasPorId($id) { 
$sql = "select idcategoria,descripcion from tbcategorias where idcategoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbcategorias*/


/* PARA Estados */

function insertarEstados($estado,$icono) { 
$sql = "insert into tbestados(idestado,estado,icono) 
values ('','".utf8_decode($estado)."','".utf8_decode($icono)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarEstados($id,$estado,$icono) { 
$sql = "update tbestados 
set 
estado = '".utf8_decode($estado)."',icono = '".utf8_decode($icono)."' 
where idestado =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarEstados($id) { 
$sql = "delete from tbestados where idestado =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEstados() { 
$sql = "select 
e.idestado,
e.estado,
e.icono
from tbestados e 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEstadosPorId($id) { 
$sql = "select idestado,estado,icono from tbestados where idestado =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbestados*/



/* PARA Tipopago */

function insertarTipopago($descripcion) { 
$sql = "insert into tbtipopago(idtipopago,descripcion) 
values ('','".utf8_decode($descripcion)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarTipopago($id,$descripcion) { 
$sql = "update tbtipopago 
set 
descripcion = '".utf8_decode($descripcion)."' 
where idtipopago =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarTipopago($id) { 
$sql = "delete from tbtipopago where idtipopago =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipopago() { 
$sql = "select 
t.idtipopago,
t.descripcion
from tbtipopago t 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipopagoPorId($id) { 
$sql = "select idtipopago,descripcion from tbtipopago where idtipopago =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbtipopago*/

function estadosFingidos() {
$sql = "SELECT 'Activo' as estado
union all
select 'Inactivo' as estado";
	$res = $this->query($sql,0); 
return $res; 
}


/* PARA Predio_menu */

function insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso) {
$sql = "insert into predio_menu(idmenu,url,icono,nombre,Orden,hover,permiso)
values ('','".utf8_decode($url)."','".utf8_decode($icono)."','".utf8_decode($nombre)."',".$Orden.",'".utf8_decode($hover)."','".utf8_decode($permiso)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso) {
$sql = "update predio_menu
set
url = '".utf8_decode($url)."',icono = '".utf8_decode($icono)."',nombre = '".utf8_decode($nombre)."',Orden = ".$Orden.",hover = '".utf8_decode($hover)."',permiso = '".utf8_decode($permiso)."'
where idmenu =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarPredio_menu($id) {
$sql = "delete from predio_menu where idmenu =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerPredio_menu() {
$sql = "select
p.idmenu,
p.url,
p.icono,
p.nombre,
p.Orden,
p.hover,
p.permiso
from predio_menu p
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerPredio_menuPorId($id) {
$sql = "select idmenu,url,icono,nombre,Orden,hover,permiso from predio_menu where idmenu =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: predio_menu*/



/* PARA Roles */

function insertarRoles($descripcion,$activo) {
$sql = "insert into tbroles(idrol,descripcion,activo)
values ('','".utf8_decode($descripcion)."',".$activo.")";
$res = $this->query($sql,1);
return $res;
}


function modificarRoles($id,$descripcion,$activo) {
$sql = "update tbroles
set
descripcion = '".utf8_decode($descripcion)."',activo = ".$activo."
where idrol =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarRoles($id) {
$sql = "delete from tbroles where idrol =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerRoles() {
$sql = "select
r.idrol,
r.descripcion,
r.activo
from tbroles r
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerRolesPorId($id) {
$sql = "select idrol,descripcion,activo from tbroles where idrol =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbroles*/



function query($sql,$accion) {
		
		
		
		require_once 'appconfig.php';

		$appconfig	= new appconfig();
		$datos		= $appconfig->conexion();	
		$hostname	= $datos['hostname'];
		$database	= $datos['database'];
		$username	= $datos['username'];
		$password	= $datos['password'];
		
		$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());
		
		mysql_select_db($database);
		
		        $error = 0;
		mysql_query("BEGIN");
		$result=mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysql_query("ROLLBACK");
			return false;
		}
		 else{
			mysql_query("COMMIT");
			return $result;
		}
		
	}

}

?>