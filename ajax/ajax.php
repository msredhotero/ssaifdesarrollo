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


/* PARA Tipocontactos */

case 'insertarContactos':
insertarContactos($serviciosReferencias);
break;
case 'modificarContactos':
modificarContactos($serviciosReferencias);
break;
case 'eliminarContactos':
eliminarContactos($serviciosReferencias);
break;
case 'insertarCountries':
insertarCountries($serviciosReferencias);
break;
case 'modificarCountries':
modificarCountries($serviciosReferencias);
break;
case 'eliminarCountries':
eliminarCountries($serviciosReferencias);
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
case 'insertarPredio_menu':
insertarPredio_menu($serviciosReferencias);
break;
case 'modificarPredio_menu':
modificarPredio_menu($serviciosReferencias);
break;
case 'eliminarPredio_menu':
eliminarPredio_menu($serviciosReferencias);
break;
case 'insertarCanchas':
insertarCanchas($serviciosReferencias);
break;
case 'modificarCanchas':
modificarCanchas($serviciosReferencias);
break;
case 'eliminarCanchas':
eliminarCanchas($serviciosReferencias);
break;
case 'insertarPosiciontributaria':
insertarPosiciontributaria($serviciosReferencias);
break;
case 'modificarPosiciontributaria':
modificarPosiciontributaria($serviciosReferencias);
break;
case 'eliminarPosiciontributaria':
eliminarPosiciontributaria($serviciosReferencias);
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
case 'insertarTipocontactos':
insertarTipocontactos($serviciosReferencias);
break;
case 'modificarTipocontactos':
modificarTipocontactos($serviciosReferencias);
break;
case 'eliminarTipocontactos':
eliminarTipocontactos($serviciosReferencias);
break;

/* Fin */

}

/* Fin */
/*

/* PARA Tipocontactos */

function insertarContactos($serviciosReferencias) {
$reftipocontactos = $_POST['reftipocontactos'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$localidad = $_POST['localidad'];
$cp = $_POST['cp'];
$telefono = $_POST['telefono'];
$celular = $_POST['celular'];
$fax = $_POST['fax'];
$email = $_POST['email'];
$observaciones = $_POST['observaciones'];
if (isset($_POST['publico'])) {
$publico = 1;
} else {
$publico = 0;
}
$res = $serviciosReferencias->insertarContactos($reftipocontactos,$nombre,$direccion,$localidad,$cp,$telefono,$celular,$fax,$email,$observaciones,$publico);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos'.$res;
}
}
function modificarContactos($serviciosReferencias) {
$id = $_POST['id'];
$reftipocontactos = $_POST['reftipocontactos'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$localidad = $_POST['localidad'];
$cp = $_POST['cp'];
$telefono = $_POST['telefono'];
$celular = $_POST['celular'];
$fax = $_POST['fax'];
$email = $_POST['email'];
$observaciones = $_POST['observaciones'];
if (isset($_POST['publico'])) {
$publico = 1;
} else {
$publico = 0;
}
$res = $serviciosReferencias->modificarContactos($id,$reftipocontactos,$nombre,$direccion,$localidad,$cp,$telefono,$celular,$fax,$email,$observaciones,$publico);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarContactos($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarContactos($id);
echo $res;
}
function insertarCountries($serviciosReferencias) {
$nombre = $_POST['nombre'];
$cuit = $_POST['cuit'];
$fechaalta = $_POST['fechaalta'];
$fechabaja = $_POST['fechabaja'];
$refposiciontributaria = $_POST['refposiciontributaria'];
$refcontactos = $_POST['refcontactos'];
$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$referencia = $_POST['referencia'];
$res = $serviciosReferencias->insertarCountries($nombre,$cuit,$fechaalta,$fechabaja,$refposiciontributaria,$refcontactos,$latitud,$longitud,$activo,$referencia);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarCountries($serviciosReferencias) {
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$cuit = $_POST['cuit'];
$fechaalta = $_POST['fechaalta'];
$fechabaja = $_POST['fechabaja'];
$refposiciontributaria = $_POST['refposiciontributaria'];
$refcontactos = $_POST['refcontactos'];
$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$referencia = $_POST['referencia'];
$res = $serviciosReferencias->modificarCountries($id,$nombre,$cuit,$fechaalta,$fechabaja,$refposiciontributaria,$refcontactos,$latitud,$longitud,$activo,$referencia);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarCountries($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarCountries($id);
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
function insertarPredio_menu($serviciosReferencias) {
$url = $_POST['url'];
$icono = $_POST['icono'];
$nombre = $_POST['nombre'];
$Orden = $_POST['Orden'];
$hover = $_POST['hover'];
$permiso = $_POST['permiso'];
if (isset($_POST['administracion'])) {
$administracion = 1;
} else {
$administracion = 0;
}
if (isset($_POST['torneo'])) {
$torneo = 1;
} else {
$torneo = 0;
}
if (isset($_POST['reportes'])) {
$reportes = 1;
} else {
$reportes = 0;
}
$res = $serviciosReferencias->insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso,$administracion,$torneo,$reportes);
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
if (isset($_POST['administracion'])) {
$administracion = 1;
} else {
$administracion = 0;
}
if (isset($_POST['torneo'])) {
$torneo = 1;
} else {
$torneo = 0;
}
if (isset($_POST['reportes'])) {
$reportes = 1;
} else {
$reportes = 0;
}
$res = $serviciosReferencias->modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso,$administracion,$torneo,$reportes);
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
function insertarCanchas($serviciosReferencias) {
$refcountries = $_POST['refcountries'];
$nombre = $_POST['nombre'];
$res = $serviciosReferencias->insertarCanchas($refcountries,$nombre);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarCanchas($serviciosReferencias) {
$id = $_POST['id'];
$refcountries = $_POST['refcountries'];
$nombre = $_POST['nombre'];
$res = $serviciosReferencias->modificarCanchas($id,$refcountries,$nombre);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarCanchas($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarCanchas($id);
echo $res;
}
function insertarPosiciontributaria($serviciosReferencias) {
$posiciontributaria = $_POST['posiciontributaria'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$res = $serviciosReferencias->insertarPosiciontributaria($posiciontributaria,$activo);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarPosiciontributaria($serviciosReferencias) {
$id = $_POST['id'];
$posiciontributaria = $_POST['posiciontributaria'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$res = $serviciosReferencias->modificarPosiciontributaria($id,$posiciontributaria,$activo);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarPosiciontributaria($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarPosiciontributaria($id);
echo $res;
}
function insertarRoles($serviciosReferencias) {
$descripcion = $_POST['descripcion'];
if (isset($_POST['activo'])) {
$activo = 1;
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
$activo = 1;
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
function insertarTipocontactos($serviciosReferencias) {
$tipocontacto = $_POST['tipocontacto'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$res = $serviciosReferencias->insertarTipocontactos($tipocontacto,$activo);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarTipocontactos($serviciosReferencias) {
$id = $_POST['id'];
$tipocontacto = $_POST['tipocontacto'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$res = $serviciosReferencias->modificarTipocontactos($id,$tipocontacto,$activo);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarTipocontactos($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarTipocontactos($id);
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