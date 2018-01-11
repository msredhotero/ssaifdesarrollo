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
        
    });/* fin del document ready */

</script>


<style type="text/css">
	.toast{cursor:default;background-color:#f5f5f5;font-size:11.25pt;font-weight:normal;color:#202020;box-shadow:0 0 1px 1px rgba(0,0,0,0.5);padding:0px}
	.toast .row{width:100%}
	.toast .row .col{word-break:normal;word-wrap:normal}
	.toast .row .col.s4{width:20%;min-height:100px;position:absolute;bottom:0px;top:0px}
	.toast .row .col.s8{width:80%;min-height:100px;padding:10px;vertical-align:middle;margin-left:20%}
	.toast .row{margin:0px}
	.toast .material-icons,.toast .dataTables_filter label:after,.dataTables_filter .toast label:after,.toast .breadcrumb:before{color:#fafafa;font-size:18pt;vertical-align:middle;margin-top:37px}
	#toast-container{top:auto !important;left:auto !important;right:70px;bottom:10px;width:400px;padding:2px}
	#toast-container .toast .row .s8 i{position:absolute;float:right;top:0px;right:0px;margin:4px;cursor:pointer;color:rgba(0,0,0,0.5);will-change:color;transition:color 0.3s ease;-webkit-transition:color 0.3s}
	#toast-container .toast .row .s8 i:hover{color:#202020;will-change:color;transition:color 0.3s ease;-webkit-transition:color 0.3s}
	.chip{cursor:default;font-size:11.25pt;height:26px;line-height:26px;padding:0 6px;border-radius:6px;margin-bottom:0px;margin-right:4px;margin-left:4px;min-width:30px;text-align:center}

</style>    
        
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
				<div align="center"><p style="color:#363636; font-size:28px;">Complete el registro comenzando con su Numero de Documento</p></div>
                <br>
            </div>
			<form role="form" class="form-horizontal">
              <div class="row">
                <div class="input-field col s6">
                  <input id="nrodocumento" name="nrodocumento" type="number" class="validate">
                  <label for="nrodocumento" data-error="Error" data-success="Ok">Nro Documento</label>
                </div>
                <div class="input-field col s6">
                	<a class="waves-effect waves-light blue btn" id="buscar"><i class="material-icons left">search</i>Buscar</a>
                </div>
              </div>
              
              
              <div class="row primero">
                <div class="input-field col s6">
                  <h4>Ingrese los datos para poder generarle un usuario</h4>
                </div>

              </div>
              
              <div class="row primero">
                <div class="input-field col s6">
                  <input id="email" name="email" type="email" class="validate">
                  <label for="password">Email</label>
                </div>
                <div class="input-field col s6">
                  <input id="pass" name="pass" type="password" class="validate">
                  <label for="password">Password</label>
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
<script language="javascript" src="js/commons.js"></script>
<script>
var request_login = false;
$(document).ready(function () {
	
	$('.primero').hide();
	
	function validaDocumento() {
		//Documento
		
		dni = $('#nrodocumento').val();
		if (dni == '') {
			alerta(MSG_CAMPO_NRO_DOCUMENTO, "error");
			setInputInvalid('#nrodocumento');
			return request_login = false;
		}
	}
	
	$('#buscar').click(function(e) {
        validaDocumento();
    });
});
</script>
</body>

</html>