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
	
	
	function existeArchivo($id,$nombre,$type,$idtabla) {
		$sql		=	"select * from images where reftabla = ".$idtabla." and refproyecto =".$id." and imagen = '".$nombre."' and type = '".$type."'";
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
	
	
	function find_filesize($file)
	{
		if(substr(PHP_OS, 0, 3) == "WIN")
		{
			exec('for %I in ("'.$file.'") do @echo %~zI', $output);
			$return = $output[0];
		}
		else
		{
			$return = filesize($file);
		}
		return $return;
	}
	
	function subirArchivo($file,$carpeta,$id,$idtabla) {
		
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
					$this->eliminarFotoPorObjeto($id,$carpeta);
					
					if ($this->find_filesize($imagen_subida) < 1900000) {
						/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
						echo "Mostrar contenido\n";
						echo $imagen_subida;*/
						if (move_uploaded_file($_FILES[$file]['tmp_name'], $imagen_subida)) {
							
							$archivo = $this->sanear_string($_FILES[$file]["name"]);
							$tipoarchivo = $_FILES[$file]["type"];
							
							if ($this->existeArchivo($id,$archivo,$tipoarchivo,$idtabla) == 0) {
								$sql	=	"insert into images(idfoto,refproyecto,reftabla,imagen,type) values ('',".$id.",".$idtabla.",'".str_replace(' ','',$archivo)."','".$tipoarchivo."')";
								$this->query($sql,1);
							}
							echo "";
							
							copy($noentrar, $nuevo_noentrar);
			
						} else {
							echo "Posible ataque de carga de archivos!\n";
						}
					} else {
						echo "El archivo supera los limites de carga.";
					}
				}else{
					echo "Posible ataque del archivo subido: ";
					echo "nombre del archivo '". $_FILES[$file]['tmp_name'] . "'.";
				}
			}
		}	
	}


	
	function TraerFotosRelacion($id, $carpeta) {
		$sql    =   "select '".$carpeta."',s.idcountrie,f.imagen,f.idfoto,f.type
							from dbcountries s
							
							inner
							join images f
							on	s.idcountrie = f.refproyecto

							where s.idcountrie = ".$id;
		$result =   $this->query($sql, 0);
		return $result;
	}
	
	
	function eliminarFoto($id, $carpeta)
	{
		
		$sql		=	"select concat('".$carpeta."','/',s.idcountrie,'/',f.imagen) as archivo
							from dbcountries s
							
							inner
							join images f
							on	s.idcountrie = f.refproyecto

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
	
	
	function eliminarFotoPorObjeto($id, $carpeta)
	{
		
		$sql		=	"select concat('".$carpeta."','/',s.idcountrie,'/',f.imagen) as archivo,f.idfoto
							from dbcountries s
							
							inner
							join images f
							on	s.idcountrie = f.refproyecto

							where s.idcountrie =".$id;
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

function traerCountriesPorContactos($id) {
$sql = "select
c.idcontacto,
co.nombre as countrie,
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
inner join dbcountriecontactos cc on cc.refcontactos = c.idcontacto
inner join dbcountries co on co.idcountrie = cc.refcountries
where c.idcontacto = ".$id."
order by 1";
$res = $this->query($sql,0);
return $res;	
}

function traerCountriesNoAsignadosPorContactos($id) {
$sql = "select
co.idcountrie,
co.nombre as countrie
from dbcountries co
where co.idcountrie not in (select cc.refcountries from dbcountriecontactos cc where cc.refcontactos = ".$id.")
group by co.idcountrie,
co.nombre
order by 2";
$res = $this->query($sql,0);
return $res;	
}

/* Fin */
/* /* Fin de la Tabla: dbcontactos*/


/* PARA Countries */

function insertarCountries($nombre,$cuit,$fechaalta,$fechabaja,$refposiciontributaria,$latitud,$longitud,$activo,$referencia) {
$sql = "insert into dbcountries(idcountrie,nombre,cuit,fechaalta,fechabaja,refposiciontributaria,latitud,longitud,activo,referencia)
values ('','".utf8_decode($nombre)."','".utf8_decode($cuit)."',".($fechaalta == '' ? 'NULL' : "'".$fechaalta."'").",".($fechabaja == '' ? 'NULL' : "'".$fechabaja."'").",".$refposiciontributaria.",'".utf8_decode($latitud)."','".utf8_decode($longitud)."',".$activo.",'".utf8_decode($referencia)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarCountries($id,$nombre,$cuit,$fechaalta,$fechabaja,$refposiciontributaria,$latitud,$longitud,$activo,$referencia) {
$sql = "update dbcountries
set
nombre = '".utf8_decode($nombre)."',cuit = '".utf8_decode($cuit)."',fechaalta = ".($fechaalta == '' ? 'NULL' : "'".$fechaalta."'").",fechabaja = ".($fechabaja == '' ? 'NULL' : "'".$fechabaja."'").",refposiciontributaria = ".$refposiciontributaria.",latitud = '".utf8_decode($latitud)."',longitud = '".utf8_decode($longitud)."',activo = ".$activo.",referencia = '".utf8_decode($referencia)."'
where idcountrie =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCountries($id) {
$sql = "delete from dbcountries where idcountrie =".$id;
$res = $this->query($sql,0);
return $res;
} 


function traerCountries() {
$sql = "select
c.idcountrie,
c.nombre,
c.cuit,
DATE_FORMAT(fechaalta, '%d/%m/%Y') as fechaalta,
DATE_FORMAT(fechabaja, '%d/%m/%Y') as fechabaja,
pos.posiciontributaria,
(case when c.activo = 1 then 'Si' else 'No' end) as activo,
c.referencia,
c.latitud,
c.longitud,
c.refposiciontributaria
from dbcountries c
inner join tbposiciontributaria pos ON pos.idposiciontributaria = c.refposiciontributaria
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerCountriesPorId($id) {
$sql = "select idcountrie,nombre,cuit,fechaalta,
    fechabaja,refposiciontributaria,latitud,longitud,activo,referencia from dbcountries where idcountrie =".$id;
$res = $this->query($sql,0);
return $res;
}

function traerContactosAsignadosPorCountrie($id) {
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
inner join dbcountriecontactos cc on cc.refcontactos = c.idcontacto
inner join dbcountries co on co.idcountrie = cc.refcountries
where co.idcountrie = ".$id."
order by 1";
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
coalesce(cou.nombre,'Libre') as countrie,
c.nombre,
c.refcountries
from tbcanchas c
left join dbcountries cou ON cou.idcountrie = c.refcountries
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
inner join tbcanchas can ON can.idcancha = c.refcanchas
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


/* PARA Countriecontactos */

function insertarCountriecontactos($refcountries,$refcontactos) {
$sql = "insert into dbcountriecontactos(idcountriecontacto,refcountries,refcontactos)
values ('',".$refcountries.",".$refcontactos.")";
$res = $this->query($sql,1);
return $res;
}


function modificarCountriecontactos($id,$refcountries,$refcontactos) {
$sql = "update dbcountriecontactos
set
refcountries = ".$refcountries.",refcontactos = ".$refcontactos."
where idcountriecontacto =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCountriecontactos($id) {
$sql = "delete from dbcountriecontactos where idcountriecontacto =".$id;
$res = $this->query($sql,0);
return $res;
}

function eliminarCountriecontactosPorCountrie($id) {
$sql = "delete from dbcountriecontactos where refcountries =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCountriecontactos() {
$sql = "select
c.idcountriecontacto,
concat(ti.tipocontacto,' - ',con.nombre) as contacto,
cou.nombre as countrie,
c.refcountries,
c.refcontactos
from dbcountriecontactos c
inner join dbcountries cou ON cou.idcountrie = c.refcountries
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria
inner join dbcontactos con ON con.idcontacto = c.refcontactos
inner join tbtipocontactos ti ON ti.idtipocontacto = con.reftipocontactos
order by 2";
$res = $this->query($sql,0);
return $res;
}


function traerCountriecontactosPorId($id) {
$sql = "select idcountriecontacto,refcountries,refcontactos from dbcountriecontactos where idcountriecontacto =".$id;
$res = $this->query($sql,0);
return $res;
}

function traerCountriecontactosPorCountries($idCountrie) {
	$sql = "select
			c.idcountriecontacto,
			concat(ti.tipocontacto,' - ',con.nombre) as contacto,
			cou.nombre as countrie,
			c.refcountries,
			c.refcontactos
		from dbcountriecontactos c
		inner join dbcountries cou ON cou.idcountrie = c.refcountries
		inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria
		inner join dbcontactos con ON con.idcontacto = c.refcontactos
		inner join tbtipocontactos ti ON ti.idtipocontacto = con.reftipocontactos
		where cou.idcountrie = ".$idCountrie."
		order by 2";
	$res = $this->query($sql,0);
	return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbcountriecontactos*/



/* PARA Canchasuspenciones */
/*'".($vigenciahasta == '' ? 'NULL' : 'NULL')."'*/
function insertarCanchasuspenciones($refcanchas,$vigenciadesde,$vigenciahasta,$usuacrea,$fechacrea,$usuamodi,$fechamodi) {
$sql = "insert into dbcanchasuspenciones(idcanchasuspencion,refcanchas,vigenciadesde,vigenciahasta,usuacrea,fechacrea,usuamodi,fechamodi)
values ('',".$refcanchas.",'".utf8_decode($vigenciadesde)."',".($vigenciahasta == '' ? 'NULL' : "'".$vigenciahasta."'").",'".utf8_decode($usuacrea)."','".utf8_decode($fechacrea)."','".utf8_decode($usuamodi)."','NULL')";
$res = $this->query($sql,1);
return $res;
}


function modificarCanchasuspenciones($id,$refcanchas,$vigenciadesde,$vigenciahasta,$usuacrea,$fechacrea,$usuamodi,$fechamodi) {
$sql = "update dbcanchasuspenciones
set
refcanchas = ".$refcanchas.",vigenciadesde = '".utf8_decode($vigenciadesde)."',vigenciahasta = '".utf8_decode($vigenciahasta)."',usuacrea = '".utf8_decode($usuacrea)."',fechacrea = '".utf8_decode($fechacrea)."',usuamodi = '".utf8_decode($usuamodi)."',fechamodi = '".utf8_decode($fechamodi)."'
where idcanchasuspencion =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCanchasuspenciones($id) {
$sql = "delete from dbcanchasuspenciones where idcanchasuspencion =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCanchasuspenciones() {
$sql = "select
c.idcanchasuspencion,
coalesce(co.nombre,'Libre') as countrie,
can.nombre as cancha,
c.vigenciadesde,
c.vigenciahasta,
c.usuacrea,
c.fechacrea,
c.usuamodi,
c.fechamodi,
c.refcanchas
from dbcanchasuspenciones c
inner join tbcanchas can ON can.idcancha = c.refcanchas
left join dbcountries co ON co.idcountrie = can.refcountries
order by 1";
$res = $this->query($sql,0);
return $res;
}

function traerCanchasuspencionesPorCancha($idCancha) {
$sql = "select
c.idcanchasuspencion,
coalesce(co.nombre,'Libre') as countrie,
can.nombre as cancha,
c.vigenciadesde,
c.vigenciahasta,
c.usuacrea,
c.fechacrea,
c.usuamodi,
c.fechamodi,
c.refcanchas
from dbcanchasuspenciones c
inner join tbcanchas can ON can.idcancha = c.refcanchas
left join dbcountries co ON co.idcountrie = can.refcountries
where can.idcancha = ".$idCancha."
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerCanchasuspencionesPorId($id) {
$sql = "select idcanchasuspencion,refcanchas,vigenciadesde,vigenciahasta,usuacrea,fechacrea,usuamodi,fechamodi from dbcanchasuspenciones where idcanchasuspencion =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbcanchasuspenciones*/




/* PARA Jugadores */

function insertarJugadores($reftipodocumentos,$nrodocumento,$apellido,$nombres,$email,$fechanacimiento,$fechaalta,$fechabaja,$refcountries,$observaciones) { 
$sql = "insert into dbjugadores(idjugador,reftipodocumentos,nrodocumento,apellido,nombres,email,fechanacimiento,fechaalta,fechabaja,refcountries,observaciones) 
values ('',".$reftipodocumentos.",".$nrodocumento.",'".utf8_decode($apellido)."','".utf8_decode($nombres)."','".utf8_decode($email)."','".utf8_decode($fechanacimiento)."','".utf8_decode($fechaalta)."','".utf8_decode($fechabaja)."',".$refcountries.",'".utf8_decode($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarJugadores($id,$reftipodocumentos,$nrodocumento,$apellido,$nombres,$email,$fechanacimiento,$fechaalta,$fechabaja,$refcountries,$observaciones) { 
$sql = "update dbjugadores 
set 
reftipodocumentos = ".$reftipodocumentos.",nrodocumento = ".$nrodocumento.",apellido = '".utf8_decode($apellido)."',nombres = '".utf8_decode($nombres)."',email = '".utf8_decode($email)."',fechanacimiento = '".utf8_decode($fechanacimiento)."',fechaalta = '".utf8_decode($fechaalta)."',fechabaja = '".utf8_decode($fechabaja)."',refcountries = ".$refcountries.",observaciones = '".utf8_decode($observaciones)."' 
where idjugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadores($id) { 
$sql = "delete from dbjugadores where idjugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadores() { 
$sql = "select 
j.idjugador,
j.reftipodocumentos,
j.nrodocumento,
j.apellido,
j.nombres,
j.email,
j.fechanacimiento,
j.fechaalta,
j.fechabaja,
j.refcountries,
j.observaciones
from dbjugadores j 
inner join tbtipodocumentos tip ON tip.idtipodocumento = j.reftipodocumentos 
inner join dbcountries cou ON cou.idcountrie = j.refcountries 
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresPorId($id) { 
$sql = "select idjugador,reftipodocumentos,nrodocumento,apellido,nombres,email,fechanacimiento,fechaalta,fechabaja,refcountries,observaciones from dbjugadores where idjugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbjugadores*/


/* PARA Jugadoresdocumentacion */

function insertarJugadoresdocumentacion($refjugadores,$refdocumentaciones,$valor,$habilita,$observaciones) { 
$sql = "insert into dbjugadoresdocumentacion(idjugadordocumentacion,refjugadores,refdocumentaciones,valor,habilita,observaciones) 
values ('',".$refjugadores.",".$refdocumentaciones.",".$valor.",".$habilita.",'".utf8_decode($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarJugadoresdocumentacion($id,$refjugadores,$refdocumentaciones,$valor,$habilita,$observaciones) { 
$sql = "update dbjugadoresdocumentacion 
set 
refjugadores = ".$refjugadores.",refdocumentaciones = ".$refdocumentaciones.",valor = ".$valor.",habilita = ".$habilita.",observaciones = '".utf8_decode($observaciones)."' 
where idjugadordocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadoresdocumentacion($id) { 
$sql = "delete from dbjugadoresdocumentacion where idjugadordocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresdocumentacion() { 
$sql = "select 
j.idjugadordocumentacion,
j.refjugadores,
j.refdocumentaciones,
j.valor,
j.habilita,
j.observaciones
from dbjugadoresdocumentacion j 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join tbdocumentaciones doc ON doc.iddocumentacion = j.refdocumentaciones 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresdocumentacionPorId($id) { 
$sql = "select idjugadordocumentacion,refjugadores,refdocumentaciones,valor,habilita,observaciones from dbjugadoresdocumentacion where idjugadordocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbjugadoresdocumentacion*/


/* PARA Documentaciones */

function insertarDocumentaciones($descripcion,$obligatoria,$observaciones) { 
$sql = "insert into tbdocumentaciones(iddocumentacion,descripcion,obligatoria,observaciones) 
values ('','".utf8_decode($descripcion)."',".$obligatoria.",'".utf8_decode($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarDocumentaciones($id,$descripcion,$obligatoria,$observaciones) { 
$sql = "update tbdocumentaciones 
set 
descripcion = '".utf8_decode($descripcion)."',obligatoria = ".$obligatoria.",observaciones = '".utf8_decode($observaciones)."' 
where iddocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarDocumentaciones($id) { 
$sql = "delete from tbdocumentaciones where iddocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDocumentaciones() { 
$sql = "select 
d.iddocumentacion,
d.descripcion,
(case when d.obligatoria = 1 then 'Si' else 'No' end) as obligatoria,
d.observaciones
from tbdocumentaciones d 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDocumentacionesPorId($id) { 
$sql = "select iddocumentacion,descripcion,obligatoria,observaciones from tbdocumentaciones where iddocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbdocumentaciones*/


/* PARA Motivoshabilitacionestransitorias */

function insertarMotivoshabilitacionestransitorias($inhabilita,$descripcion) { 
$sql = "insert into tbmotivoshabilitacionestransitorias(idmotivoshabilitacionestransitoria,inhabilita,descripcion) 
values ('',".$inhabilita.",'".utf8_decode($descripcion)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarMotivoshabilitacionestransitorias($id,$inhabilita,$descripcion) { 
$sql = "update tbmotivoshabilitacionestransitorias 
set 
inhabilita = ".$inhabilita.",descripcion = '".utf8_decode($descripcion)."' 
where idmotivoshabilitacionestransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarMotivoshabilitacionestransitorias($id) { 
$sql = "delete from tbmotivoshabilitacionestransitorias where idmotivoshabilitacionestransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMotivoshabilitacionestransitorias() { 
$sql = "select 
m.idmotivoshabilitacionestransitoria,
(case when m.inhabilita = 1 then 'Si' else 'No' end) as inhabilita,
m.descripcion
from tbmotivoshabilitacionestransitorias m 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMotivoshabilitacionestransitoriasDeportivas($id) { 
$sql = "select 
m.idmotivoshabilitacionestransitoria,
(case when m.inhabilita = 1 then 'Si' else 'No' end) as inhabilita,
m.descripcion
from tbmotivoshabilitacionestransitorias m 
where m.descripcion like '".$id."'
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMotivoshabilitacionestransitoriasDocumentaciones($id) { 
$sql = "select 
m.idmotivoshabilitacionestransitoria,
(case when m.inhabilita = 1 then 'Si' else 'No' end) as inhabilita,
m.descripcion
from tbmotivoshabilitacionestransitorias m 
where m.descripcion not like '".$id."'
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMotivoshabilitacionestransitoriasPorId($id) { 
$sql = "select idmotivoshabilitacionestransitoria,inhabilita,descripcion from tbmotivoshabilitacionestransitorias where idmotivoshabilitacionestransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbmotivoshabilitacionestransitorias*/

/* PARA Tipodocumentos */

function insertarTipodocumentos($tipodocumento) { 
$sql = "insert into tbtipodocumentos(idtipodocumento,tipodocumento) 
values ('','".utf8_decode($tipodocumento)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarTipodocumentos($id,$tipodocumento) { 
$sql = "update tbtipodocumentos 
set 
tipodocumento = '".utf8_decode($tipodocumento)."' 
where idtipodocumento =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarTipodocumentos($id) { 
$sql = "delete from tbtipodocumentos where idtipodocumento =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipodocumentos() { 
$sql = "select 
t.idtipodocumento,
t.tipodocumento
from tbtipodocumentos t 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipodocumentosPorId($id) { 
$sql = "select idtipodocumento,tipodocumento from tbtipodocumentos where idtipodocumento =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbtipodocumentos*/


/* PARA Tipojugadores */

function insertarTipojugadores($tipojugador,$abreviatura) { 
$sql = "insert into tbtipojugadores(idtipojugador,tipojugador,abreviatura) 
values ('','".utf8_decode($tipojugador)."','".utf8_decode($abreviatura)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarTipojugadores($id,$tipojugador,$abreviatura) { 
$sql = "update tbtipojugadores 
set 
tipojugador = '".utf8_decode($tipojugador)."',abreviatura = '".utf8_decode($abreviatura)."' 
where idtipojugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarTipojugadores($id) { 
$sql = "delete from tbtipojugadores where idtipojugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipojugadores() { 
$sql = "select 
t.idtipojugador,
t.tipojugador,
t.abreviatura
from tbtipojugadores t 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipojugadoresPorId($id) { 
$sql = "select idtipojugador,tipojugador,abreviatura from tbtipojugadores where idtipojugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbtipojugadores*/



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