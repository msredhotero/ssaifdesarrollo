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

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../carnet/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Carnet",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Carnet";

$plural = "Carnet";

$eliminar = "eliminarTorneos";

$insertar = "insertarTorneos";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbtorneos";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resEquipos = $serviciosReferencias->traerJugadoresParaCarnet();



$numero = count($_POST);
    $tags = array_keys($_POST);// obtiene los nombres de las varibles
    $valores = array_values($_POST);// obtiene los valores de las varibles
    $cantEncontrados = 0;
    $cantidad = 1;
    $idEquipos = 0;
    
    $cadWhere = '';
    $cantEquipos = array();
    
    for($i=0;$i<$numero;$i++){
        
        if (strpos($tags[$i],"equipo") !== false) {
            
            if (isset($valores[$i])) {
                
                $idEquipos = str_replace("equipo","",$tags[$i]);
                
                $cadWhere .= $idEquipos.","."<br>";
                array_push($cantEquipos,$cantidad);
                $cantidad += 1;
            }
        }
    }
die(print_r($cadWhere));

?>

<?php } ?>

