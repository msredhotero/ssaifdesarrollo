<?php

require 'includes/funcionesUsuarios.php';
include ('includes/funciones.php');

$serviciosUsuarios = new ServiciosUsuarios();
$servicios = new Servicios();


?>
<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Acceso Restringido: Sistema Gestor de Torneos AIF</title>



<link rel="stylesheet" type="text/css" href="css/estilo.css"/>

<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

<link rel="stylesheet" href="css/jquery-ui.css">

<script src="js/jquery-ui.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

<link rel="stylesheet" href="css/materialize.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        
        
            
            
        
        function validador(){

                $error = "";

                if ($("#email").val() == "") {
                    $error = "Es obligatorio el campo E-Mail.";

                    $("#error").addClass("alert alert-danger");
                    $("#error").attr('placeholder',$error);
                }
                
                if ($("#pass").val() == "") {
                    $error = "Es obligatorio el campo Password.";

                    $("#pass").addClass("alert alert-danger");
                    $("#pass").attr('placeholder',$error);
                }
                

                
                
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                
                if( !emailReg.test( $("#email").val() ) ) {
                    $error = "El E-Mail ingresado es inválido.";

                    $("#error").addClass("alert alert-danger");
                    $("#error").text($error);
                  }

                return $error;
        }
        
        $('body').keyup(function(e) {
            if(e.keyCode == 13) {
                $("#login").click();
            }
        });
        
        
        $("#login").click(function(event) {
            
                if (validador() == "")
                {
                        $.ajax({
                        data:  {email:		$("#email").val(),
                                pass:		$("#pass").val(),
                                idempresa:	$('#idempresa').val(),
                                accion:		'login'},
                        url:   'ajax/ajax.php',
                        type:  'post',
                        beforeSend: function () {
                                $("#load").html('<img src="imagenes/load13.gif" width="50" height="50" />');
                        },
                        success:  function (response) {
                                
                                if (response != '') {
                                    
                                    $("#error").removeClass("alert alert-danger");

                                    $("#error").addClass("alert alert-danger");
                                    $("#error").html('<strong>Error!</strong> '+response);
                                    $("#load").html('');

                                } else {
                                    url = "dashboard/";
                                    $(location).attr('href',url);
                                }
                                
                        }
                });
                }
        });
        
		$('#registrarse').click(function() {
			$(location).attr('href','registrarse.php');
		});
    });/* fin del document ready */

</script>


        
        
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

            <div align="center">
            	<img src="imagenes/aif_logo.png" width="22%">
				<div align="center"><p style="color:#363636; font-size:28px;">Acceso al panel de control</p></div>
                <br>
            </div>
			<form role="form" class="form-horizontal">
              
              <div class="row">
                <div class="input-field col s12">
                  <input id="email" name="email" type="email" class="validate">
                  <label for="password">Email</label>
                </div>
              </div>
      
              
              <div class="row">
                <div class="input-field col s12">
                  <input id="pass" name="pass" type="password" class="validate">
                  <label for="password">Password</label>
                </div>
              </div>
              
              <div class="row">
              <div class="form-group">
              	<label for="olvido" class="control-label" style="color:#363636">¿Has olvidado tu contraseña?. <a href="recuperarpassword.php">Recuperar.</a></label>
              </div>
             
              <div class="form-group">
                <div class="col-md-12">
                  <a class="waves-effect waves-light btn" id="login"><i class="material-icons left">cloud</i>Ingresar</a>
                  <a class="waves-effect red btn" id="registrarse"><i class="material-icons left">group_add</i>Registrate</a>
                  
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

<script type="text/javascript" src="js/materialize.min.js"></script>

</body>

</html>