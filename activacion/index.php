<?php

require '../includes/funcionesUsuarios.php';
require '../includes/funcionesReferencias.php';


$ServiciosReferencias   = new ServiciosReferencias();
$serviciosUsuario = new ServiciosUsuarios();


$token = $_GET['token'];

$codActivacion = $serviciosUsuario->traerActivacionusuariosPorTokenFechas($token);

$error = 0;
if (mysql_num_rows($codActivacion) > 0) {
    $idUsuario = mysql_result($codActivacion,0,'refusuarios');
    
    $resUsuario = $serviciosUsuario->traerUsuarioId($idUsuario);
    
    if (mysql_result($resUsuario,0,7) == 'Si') {
        $error = 2;
    } else {
    
        
        $activar = $serviciosUsuario->activarUsuario($idUsuario);

        $resUsuario = $serviciosUsuario->traerUsuarioId($idUsuario);

        $email = mysql_result($resUsuario,0,'email');

        $destinatario = $email;
        $asunto = "Cuenta Activada Correctamente";
        $cuerpo = "<h3>Gracias por registrarse en Crovan Kegs.</h3><br>
                    <p>Ya puede comenzar a comprar ingresando con su email y contraseña, visite nuestros productos <a href=''>AQUI</a></p>";

        $serviciosUsuario->modificarActivacionusuariosConcretada($token);
        //$serviciosUsuario->enviarMail($destinatario,$asunto,$cuerpo);
    }
} else {
	$error = 1;
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
<!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">-->
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
              <img src="imagenes/aif_logo.png" width="22%">
        <div align="center"><p style="color:#363636; font-size:28px;">Complete el registro comenzando con su Numero de Documento</p></div>
                <br>
            </div>
      <form role="form" class="form-horizontal">
              <div class="row segundo">
                <div class="input-field col s6">
                  <input id="nrodocumento" name="nrodocumento" type="number" class="validate">
                  <label for="nrodocumento" data-error="Error" data-success="Ok">Nro Documento</label>
                </div>
                <div class="input-field col s6">
                  <a class="waves-effect waves-light blue btn" id="buscar"><i class="material-icons left">search</i>Buscar</a>
                </div>
              </div>
              
              
              <div class="row primero">
                <div class="input-field col s12">
                  <h4>Ingrese los datos para poder generarle un usuario</h4>
                </div>

              </div>
              
              <div class="row primero">
                <div class="input-field col s6">
                  <input id="txtEmail" name="txtEmail" type="email" class="validate tooltipped" data-position="top" data-delay="50" data-tooltip="Campo Obligatorio, sera su modo de ingreso">
                  <label for="password">Email</label>
                </div>
                <div class="input-field col s6">
                  <input id="txtPassword" name="txtPassword" type="password" class="validate tooltipped"  data-position="top" data-delay="50" data-tooltip="La contraseña debe tener entre 8 y 12 caracteres">
                  <label for="password">Password</label>
                </div>
              </div>


              <div class="row primero">
                <div class="input-field col s6">
                  <input id="txtApellido" name="txtApellido" type="text" class="validate">
                  <label for="password">Apellido</label>
                </div>
                <div class="input-field col s6">
                  <input id="txtNombre" name="txtNombre" type="text" class="validate">
                  <label for="password">Nombre</label>
                </div>
              </div>

              <div class="row primero">
                <div class="input-field col s6">
                  <input id="txtFechaNacimiento" name="txtFechaNacimiento" type="text" class="datepicker">
                  <label for="password">Fecha Nacimiento</label>
                </div>
              </div>

              
              <div class="row btnAcciones">
             
              <div class="form-group">
                <div class="col-md-12">
                  <a class="waves-effect red btn" id="registrarse"><i class="material-icons left">group_add</i>Registrate</a>
                  <a class="waves-effect waves-light btn" id="login"><i class="material-icons left">assignment_ind</i>Ingresar</a>
                  
                  
                </div>
              </div>
              </div>
                <div id="load">
                  <div class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue">
                      <div class="circle-clipper left">
                        <div class="circle"></div>
                      </div><div class="gap-patch">
                        <div class="circle"></div>
                      </div><div class="circle-clipper right">
                        <div class="circle"></div>
                      </div>
                    </div>
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

</body>

</html>