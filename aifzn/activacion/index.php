<?php

require '../includes/funcionesUsuarios.php';
require '../includes/funcionesReferencias.php';


$ServiciosReferencias   = new ServiciosReferencias();
$serviciosUsuario = new ServiciosUsuarios();

if (!isset($_GET['token']))
{
    header('Location: ../index.php');
} else {
$token = $_GET['token'];

$codActivacion = $serviciosUsuario->traerActivacionusuariosPorTokenFechas($token);

$error = 0;
if (mysql_num_rows($codActivacion) > 0) {
    $idUsuario = mysql_result($codActivacion,0,'refusuarios');
    
    $resUsuario = $serviciosUsuario->traerUsuarioId($idUsuario);
    
    if (mysql_result($resUsuario,0,6) == 'Si') {
        $error = 2;
    } else {
    
        
        $activar = $serviciosUsuario->activarUsuario($idUsuario);

        $resUsuario = $serviciosUsuario->traerUsuarioId($idUsuario);

        $email = mysql_result($resUsuario,0,'email');
        $nombrecompleto = mysql_result($resUsuario,0,'nombrecompleto');
        $nrodocumento = mysql_result($resUsuario,0,'nrodocumento');

        $JugadorPre = $ServiciosReferencias->traerJugadoresprePorNroDocumento($nrodocumento);

        $destinatario = $email;
        $asunto = "El Usuario ".$nombrecompleto." se Activo Correctamente";
        $cuerpo .= "<h3>Gracias por registrarse en AIFZN.</h3><br>";
        

        $cuerpo .= "<h4>Ya puede comenzar a cargar sus datos personales <a href='http://www.saupureinconsulting.com.ar/aifzn/'>AQUI</a></h4>";


        $emailReferente = $serviciosUsuario->traerReferente($nrodocumento);
        $serviciosUsuario->modificarActivacionusuariosConcretada($token);
        $serviciosUsuario->enviarEmailConReferente($destinatario,$asunto,$cuerpo , $emailReferente);
    }
} else {
	$error = 1;
    
    $resVencido = $serviciosUsuario->traerActivacionusuariosPorToken($token);
    
    $idUsuario = mysql_result($resVencido,0,'refusuarios');
    
    $resUsuario = $serviciosUsuario->traerUsuarioId($idUsuario);
    
    $email = mysql_result($resUsuario,0,'email');
    
    $token = $this->GUID();
	$cuerpo = '';

	$fecha = date_create(date('Y').'-'.date('m').'-'.date('d'));
	date_add($fecha, date_interval_create_from_date_string('2 days'));
	$fechaprogramada =  date_format($fecha, 'Y-m-d');

	$cuerpo .= '<p>Antes que nada por favor no responda este mail ya que no recibirá respuesta.</p>';
	$cuerpo .= '<p>Recibimos su solicitud de alta como socio/jugador en la Asociación Intercountry de Fútbol Zona Norte. Para verificar(activar) tu casilla de correo por favor ingresá al siguiente link: <a href="saupureinconsulting.com.ar/activacion/index.php?token='.$token.'">AQUI</a>.</p>';
	$cuerpo .= '<p>Este link estara vigente hasta la fecha '.$fechaprogramada.', pasada esta fecha deberá solicitar mas tiempo para activar su cuenta.</p>';
	$cuerpo .= '<p>Una vez hecho esto, el personal administrativo se pondrá en contacto mediante esta misma via para notificarle si su estado de alta se encuentra aprobado, de no ser así se detallará la causa.</p>';

	$cuerpo .= '<p>Atte.</p>';
	$cuerpo .= '<p>AIFZN</p>';
    
    $this->insertarActivacionusuarios($idUsuario,$token,'','');
    $this->enviarEmail($email,'Alta de Usuario',$cuerpo);
}

 
 
?>
<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Acceso Restringido: Sistema Gestor de Torneos AIF</title>



<link rel="stylesheet" type="text/css" href="../css/estilo.css"/>

<script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>

<link rel="stylesheet" href="../css/jquery-ui.css">

<script src="../js/jquery-ui.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">

<link rel="stylesheet" href="../css/materialize.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<!-- Latest compiled and minified JavaScript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</head>



<body>
<div class="content">

<!--<div class="row" style="margin-top:10px; font-family:Verdana, Geneva, sans-serif;" align="center">
    <img src="imagenes/logo.png" width="300" height="273">
   
</div>-->


<div class="logueo row" align="center">
<br>
<br>
<br>
<div class="col-md-2"></div>
<div class="col-md-8">
  <section style="padding-top:10px; padding-top:60px;padding:25px;
background-color: #ffffff; border:1px solid #101010; box-shadow: 2px 2px 3px #333;-webkit-box-shadow: 2px 2px 3px #333;-moz-box-shadow: 2px 2px 3px #333;">
      <div id="error" style="text-align:left; color:#666;">
            
            </div>

            <div align="center" class="segundo">
              <img src="../imagenes/aif_logo.png" width="22%">
               <?php 
                    switch ($error) {

                        case 0:
                            echo '<div align="center"><p style="color:#363636; font-size:28px;">Se registro correctamente en el sistema.</p></div>';
                            break;
                        case 1: 
                            echo '<div align="center"><p style="color:#363636; font-size:28px;">Vencio su registro al sistema, debera generar otro.</p></div>';
                            break;
                        case 2: 
                            echo '<div align="center"><p style="color:#363636; font-size:28px;">El usuario ya fue activado.</p></div>';
                            break;

                    }
                ?>
                
                
                <br>
            </div>
      <form role="form" class="form-horizontal">

              
              <div class="row btnAcciones">
             
              <div class="form-group">
                <div class="col-md-12">
                  <a class="waves-effect waves-light btn" id="login"><i class="material-icons left">assignment_ind</i>Ingresar</a>
                  
                  
                </div>
              </div>
              </div>
                <div id="load">

                </div>

            </form>

     </section>
</div>
<div class="col-md-2"></div>
     <br>
     <br>
     <br>
     </div>
</div><!-- fin del content -->

<script type="text/javascript" src="../js/materialize.js"></script>
<script language="javascript" src="../js/commons.js"></script>
<script>
var request_login = false;
var request_documento = false;
var id_pre = 0;
$(document).ready(function () {

  $('#login').click(function() {
    $(location).attr('href','../index.php');
  });

});
</script>
</body>

</html>
<?php
}
?>