<?PHP

include ('includes/funcionesUsuarios.php');
include ('includes/funcionesHTML.php');
include ('includes/funciones.php');
include ('includes/funcionesReferencias.php');

$serviciosUsuario = new ServiciosUsuarios();
$serviciosHTML = new ServiciosHTML();
$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

$res = $serviciosReferencias->deteterminaHabilitado(12161);

foreach ($res as $key => $value) {
   echo $value['habilita'];
}

?>
