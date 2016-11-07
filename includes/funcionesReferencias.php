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





/* PARA Contactos */

function insertarContactos($reftipocontactos,$nombre,$direccion,$localidad,$cp,$telefono,$celular,$fax,$email,$observaciones,$publico) {
$sql = "insert into dbcontactos(idcontacto,reftipocontactos,nombre,direccion,localidad,cp,telefono,celular,fax,email,observaciones,publico)
values ('',".$reftipocontactos.",'".utf8_decode($nombre)."','".utf8_decode($direccion)."','".utf8_decode($localidad)."','".utf8_decode($cp)."','".utf8_decode($telefono)."','".utf8_decode($celular)."','".utf8_decode($fax)."','".utf8_decode($email)."','".utf8_decode($observaciones)."',".$publico.")";
$res = $this->query($sql,1);
return $res;
}


function modificarContactos($id,$reftipocontactos,$nombre,$direccion,$localidad,$cp,$telefono,$celular,$fax,$email,$observaciones,$publico) {
$sql = "update dbcontactos
set
reftipocontactos = ".$reftipocontactos.",nombre = '".utf8_decode($nombre)."',direccion = '".utf8_decode($direccion)."',localidad = '".utf8_decode($localidad)."',cp = '".utf8_decode($cp)."',telefono = '".utf8_decode($telefono)."',celular = '".utf8_decode($celular)."',fax = '".utf8_decode($fax)."',email = '".utf8_decode($email)."',observaciones = '".utf8_decode($observaciones)."',publico = ".$publico."
where idcontacto =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarContactos($id) {
$sql = "delete from dbcontactos where idcontacto =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerContactos() {
$sql = "select
c.idcontacto,
tip.tipocontacto,
c.nombre,
c.direccion,
c.localidad,
c.cp,
c.telefono,
c.celular,
c.fax,
c.email,
c.publico,
c.observaciones,
c.reftipocontactos
from dbcontactos c
inner join tbtipocontactos tip ON tip.idtipocontacto = c.reftipocontactos
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerContactosPorId($id) {
$sql = "select idcontacto,reftipocontactos,nombre,direccion,localidad,cp,telefono,celular,fax,email,observaciones,publico from dbcontactos where idcontacto =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbcontactos*/


/* PARA Countries */

function insertarCountries($nombre,$cuit,$fechaalta,$fechabaja,$refposiciontributaria,$refcontactos,$latitud,$longitud,$activo,$referencia) {
$sql = "insert into dbcountries(idcountrie,nombre,cuit,fechaalta,fechabaja,refposiciontributaria,refcontactos,latitud,longitud,activo,referencia)
values ('','".utf8_decode($nombre)."','".utf8_decode($cuit)."','".utf8_decode($fechaalta)."','".utf8_decode($fechabaja)."',".$refposiciontributaria.",".$refcontactos.",'".utf8_decode($latitud)."','".utf8_decode($longitud)."',".$activo.",'".utf8_decode($referencia)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarCountries($id,$nombre,$cuit,$fechaalta,$fechabaja,$refposiciontributaria,$refcontactos,$latitud,$longitud,$activo,$referencia) {
$sql = "update dbcountries
set
nombre = '".utf8_decode($nombre)."',cuit = '".utf8_decode($cuit)."',fechaalta = '".utf8_decode($fechaalta)."',fechabaja = '".utf8_decode($fechabaja)."',refposiciontributaria = ".$refposiciontributaria.",refcontactos = ".$refcontactos.",latitud = '".utf8_decode($latitud)."',longitud = '".utf8_decode($longitud)."',activo = ".$activo.",referencia = '".utf8_decode($referencia)."'
where idcountrie =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCountries($id) {
$sql = "update dbcountries set activo = 0, fechabaja = '".date('Y-m-d')."' where idcountrie =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCountries() {
$sql = "select
c.idcountrie,
c.nombre,
c.cuit,
c.fechaalta,
c.fechabaja,
pos.posiciontributaria,
con.nombre as contacto,
c.latitud,
c.longitud,
(case when c.activo = 1 then 'Si' else 'No' end) as activo,
c.referencia,
c.refposiciontributaria,
c.refcontactos
from dbcountries c
inner join tbposiciontributaria pos ON pos.idposiciontributaria = c.refposiciontributaria
inner join dbcontactos con ON con.idcontacto = c.refcontactos
inner join tbtipocontactos ti ON ti.idtipocontacto = con.reftipocontactos
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerCountriesPorId($id) {
$sql = "select idcountrie,nombre,cuit,fechaalta,fechabaja,refposiciontributaria,refcontactos,latitud,longitud,activo,referencia from dbcountries where idcountrie =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbcountries*/


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


/* PARA Predio_menu */

function insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso,$administracion,$torneo,$reportes) {
$sql = "insert into predio_menu(idmenu,url,icono,nombre,Orden,hover,permiso,administracion,torneo,reportes)
values ('','".utf8_decode($url)."','".utf8_decode($icono)."','".utf8_decode($nombre)."',".$Orden.",'".utf8_decode($hover)."','".utf8_decode($permiso)."',".$administracion.",".$torneo.",".$reportes.")";
$res = $this->query($sql,1);
return $res;
}


function modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso,$administracion,$torneo,$reportes) {
$sql = "update predio_menu
set
url = '".utf8_decode($url)."',icono = '".utf8_decode($icono)."',nombre = '".utf8_decode($nombre)."',Orden = ".$Orden.",hover = '".utf8_decode($hover)."',permiso = '".utf8_decode($permiso)."',administracion = ".$administracion.",torneo = ".$torneo.",reportes = ".$reportes."
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
p.permiso,
p.administracion,
p.torneo,
p.reportes
from predio_menu p
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerPredio_menuPorId($id) {
$sql = "select idmenu,url,icono,nombre,Orden,hover,permiso,administracion,torneo,reportes from predio_menu where idmenu =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: predio_menu*/


/* PARA Canchas */

function insertarCanchas($refcountries,$nombre) {
$sql = "insert into tbcanchas(idcancha,refcountries,nombre)
values ('',".$refcountries.",'".utf8_decode($nombre)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarCanchas($id,$refcountries,$nombre) {
$sql = "update tbcanchas
set
refcountries = ".$refcountries.",nombre = '".utf8_decode($nombre)."'
where idcancha =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCanchas($id) {
$sql = "delete from tbcanchas where idcancha =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCanchas() {
$sql = "select
c.idcancha,
cou.nombre as countrie,
c.nombre,
c.refcountries
from tbcanchas c
inner join dbcountries cou ON cou.idcountrie = c.refcountries
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria
inner join dbcontactos co ON co.idcontacto = cou.refcontactos
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerCanchasPorId($id) {
$sql = "select idcancha,refcountries,nombre from tbcanchas where idcancha =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbcanchas*/


/* PARA Posiciontributaria */

function insertarPosiciontributaria($posiciontributaria,$activo) {
$sql = "insert into tbposiciontributaria(idposiciontributaria,posiciontributaria,activo)
values ('','".utf8_decode($posiciontributaria)."',".$activo.")";
$res = $this->query($sql,1);
return $res;
}


function modificarPosiciontributaria($id,$posiciontributaria,$activo) {
$sql = "update tbposiciontributaria
set
posiciontributaria = '".utf8_decode($posiciontributaria)."',activo = ".$activo."
where idposiciontributaria =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarPosiciontributaria($id) {
$sql = "update tbposiciontributaria set activo = 0 where idposiciontributaria =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerPosiciontributaria() {
$sql = "select
p.idposiciontributaria,
p.posiciontributaria,
(case when p.activo = 1 then 'Si' else 'No' end) as activo
from tbposiciontributaria p
where activo = 1
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerPosiciontributariaPorId($id) {
$sql = "select idposiciontributaria,posiciontributaria,activo from tbposiciontributaria where idposiciontributaria =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbposiciontributaria*/


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


/* PARA Tipocontactos */

function insertarTipocontactos($tipocontacto,$activo) {
$sql = "insert into tbtipocontactos(idtipocontacto,tipocontacto,activo)
values ('','".utf8_decode($tipocontacto)."',".$activo.")";
$res = $this->query($sql,1);
return $res;
}


function modificarTipocontactos($id,$tipocontacto,$activo) {
$sql = "update tbtipocontactos
set
tipocontacto = '".utf8_decode($tipocontacto)."',activo = ".$activo."
where idtipocontacto =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarTipocontactos($id) {
$sql = "update tbtipocontactos set activo = 0 where idtipocontacto =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerTipocontactos() {
$sql = "select
t.idtipocontacto,
t.tipocontacto,
(case when t.activo = 1 then 'Si' else 'No' end) as activo
from tbtipocontactos t
where activo = 1
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerTipocontactosPorId($id) {
$sql = "select idtipocontacto,tipocontacto,activo from tbtipocontactos where idtipocontacto =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbtipocontactos*/


/* PARA Arbitros */

function insertarArbitros($nombrecompleto,$telefonoparticular,$telefonoceleluar,$telefonolaboral,$telefonofamiliar,$email) {
$sql = "insert into dbarbitros(idarbitro,nombrecompleto,telefonoparticular,telefonoceleluar,telefonolaboral,telefonofamiliar,email)
values ('','".utf8_decode($nombrecompleto)."','".utf8_decode($telefonoparticular)."','".utf8_decode($telefonoceleluar)."','".utf8_decode($telefonolaboral)."','".utf8_decode($telefonofamiliar)."','".utf8_decode($email)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarArbitros($id,$nombrecompleto,$telefonoparticular,$telefonoceleluar,$telefonolaboral,$telefonofamiliar,$email) {
$sql = "update dbarbitros
set
nombrecompleto = '".utf8_decode($nombrecompleto)."',telefonoparticular = '".utf8_decode($telefonoparticular)."',telefonoceleluar = '".utf8_decode($telefonoceleluar)."',telefonolaboral = '".utf8_decode($telefonolaboral)."',telefonofamiliar = '".utf8_decode($telefonofamiliar)."',email = '".utf8_decode($email)."'
where idarbitro =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarArbitros($id) {
$sql = "delete from dbarbitros where idarbitro =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerArbitros() {
$sql = "select
a.idarbitro,
a.nombrecompleto,
a.telefonoparticular,
a.telefonoceleluar,
a.telefonolaboral,
a.telefonofamiliar,
a.email
from dbarbitros a
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerArbitrosPorId($id) {
$sql = "select idarbitro,nombrecompleto,telefonoparticular,telefonoceleluar,telefonolaboral,telefonofamiliar,email from dbarbitros where idarbitro =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbarbitros*/


/* PARA Countriecanchas */

function insertarCountriecanchas($refcountries,$refcanchas) {
$sql = "insert into dbcountriecanchas(idcountriecancha,refcountries,refcanchas)
values ('',".$refcountries.",".$refcanchas.")";
$res = $this->query($sql,1);
return $res;
}


function modificarCountriecanchas($id,$refcountries,$refcanchas) {
$sql = "update dbcountriecanchas
set
refcountries = ".$refcountries.",refcanchas = ".$refcanchas."
where idcountriecancha =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCountriecanchas($id) {
$sql = "delete from dbcountriecanchas where idcountriecancha =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCountriecanchas() {
$sql = "select
c.idcountriecancha,
c.refcountries,
c.refcanchas
from dbcountriecanchas c
inner join dbcountries cou ON cou.idcountrie = c.refcountries
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria
inner join dbcontactos co ON co.idcontacto = cou.refcontactos
inner join tbcanchas can ON can.idcancha = c.refcanchas
inner join dbcountries co ON co.idcountrie = can.refcountries
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerCountriecanchasPorId($id) {
$sql = "select idcountriecancha,refcountries,refcanchas from dbcountriecanchas where idcountriecancha =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbcountriecanchas*/


/* PARA Categorias */

function insertarCategorias($categoria) {
$sql = "insert into tbcategorias(idtcategoria,categoria)
values ('','".utf8_decode($categoria)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarCategorias($id,$categoria) {
$sql = "update tbcategorias
set
categoria = '".utf8_decode($categoria)."'
where idtcategoria =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCategorias($id) {
$sql = "delete from tbcategorias where idtcategoria =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCategorias() {
$sql = "select
c.idtcategoria,
c.categoria
from tbcategorias c
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerCategoriasPorId($id) {
$sql = "select idtcategoria,categoria from tbcategorias where idtcategoria =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbcategorias*/

/* PARA Divisiones */

function insertarDivisiones($division) {
$sql = "insert into tbdivisiones(iddivision,division)
values ('','".utf8_decode($division)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarDivisiones($id,$division) {
$sql = "update tbdivisiones
set
division = '".utf8_decode($division)."'
where iddivision =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarDivisiones($id) {
$sql = "delete from tbdivisiones where iddivision =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerDivisiones() {
$sql = "select
d.iddivision,
d.division
from tbdivisiones d
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerDivisionesPorId($id) {
$sql = "select iddivision,division from tbdivisiones where iddivision =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbdivisiones*/


/* PARA Temporadas */

function insertarTemporadas($temporada) {
$sql = "insert into tbtemporadas(idtemporadas,temporada)
values ('',".$temporada.")";
$res = $this->query($sql,1);
return $res;
}


function modificarTemporadas($id,$temporada) {
$sql = "update tbtemporadas
set
temporada = ".$temporada."
where idtemporadas =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarTemporadas($id) {
$sql = "delete from tbtemporadas where idtemporadas =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerTemporadas() {
$sql = "select
t.idtemporadas,
t.temporada
from tbtemporadas t
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerTemporadasPorId($id) {
$sql = "select idtemporadas,temporada from tbtemporadas where idtemporadas =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbtemporadas*/


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