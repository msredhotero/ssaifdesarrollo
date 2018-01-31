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
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>


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
				<div align="center"><p class="tituloF" style="color:#363636; font-size:28px;">Complete el registro comenzando con su Numero de Documento</p></div>
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

<script type="text/javascript" src="js/materialize.js"></script>
<script language="javascript" src="js/commons.js"></script>
<script>
var request_login = false;
var request_documento = false;
var id_pre = 0;
$(document).ready(function () {
	
	$('.primero').hide();
  $('#load').hide();
	
  function validaDocumento() {
		//Documento
		
    dni = $('#nrodocumento').val();
    if (dni == '') {
      alerta(MSG_CAMPO_NRO_DOCUMENTO, "error");
      setInputInvalid('#nrodocumento');
      return request_documento = false;
    }
  }



  function validaRegistro() {
    //Documento
    
    email = $('#txtEmail').val();
    if (email == '') {
      alerta(MSG_CAMPO_EMAIL_NO_VACIO, "error");
      setInputInvalid('#txtEmail');
      return request_login = false;
    } else {

      if (validarEmail(email)==false) {
        alerta(MSG_CAMPO_EMAIL_FORMATO_VALIDO, "error");
        setInputInvalid('#txtEmail');
        return request_login = false;
      }
    }


    apellido = $('#txtApellido').val();
    if (apellido == '') {
      alerta('El campo Apellido es obligatorio', "error");
      setInputInvalid('#txtApellido');
      return request_login = false;
    }

    nombre = $('#txtNombre').val();
    if (nombre == '') {
      alerta('El campo Nombre es obligatorio', "error");
      setInputInvalid('#txtNombre');
      return request_login = false;
    }


    if ($('#txtPassword').val() == '') {
      alerta('El campo Contraseña es obligatorio', "error");
      setInputInvalid('#txtPassword');
      return request_login = false;
    }

    var longitudClave = $('#txtPassword').val().length;
    if ((longitudClave < 8) || (longitudClave > 12)) {
      alerta(MSG_CAMPO_LONGITUD_CONTRASENA, "error");
      setInputInvalid('#txtPassword');
      return request_login = false;
    }

    return request_login = true;
  }

  $("#registrarse").click(function(event) {
    validaRegistro();
    if (request_login) {
      $.ajax({
          data:  {id : id_pre,
                  email:    $("#txtEmail").val(),
                  password:    $("#txtPassword").val(),
                  apellido:    $("#txtApellido").val(),
                  nombre:    $("#txtNombre").val(),
                  nrodocumento: $("#nrodocumento").val(),
                  fechanacimiento:    $("#txtFechaNacimiento").val(),
                  accion:   'registrarSocio'},
          url:   'ajax/ajax.php',
          type:  'post',
          beforeSend: function () {
            $("#load").show();
          },
          success:  function (response) {
            
            if (response != '') {
                
                alerta(response, "error");

                $("#load").hide();

            } else {
                alerta('Le enviamos un email a su correo para que active su cuenta.', "done");
                $('#registrarse').hide(200);
                $('.segundo').hide(200);
                $('.primero').hide(200);
                $("#load").hide(100);
                $('.tituloF').html('Si ya activo su cuenta ingrese al sistema')

            }
            
          }
        });
    }
  });


  $("#buscar").click(function(event) {
      request_documento = true;
      validaDocumento();

      if (request_documento)
      {
        $.ajax({
          data:  {nrodocumento:    $("#nrodocumento").val(),
                  accion:   'buscarSocio'},
          url:   'ajax/ajax.php',
          type:  'post',
          beforeSend: function () {
            $("#load").show();
          },
          success:  function (response) {
            
            if (response != '') {
                
                alerta(response, "error");

                $("#load").hide();
                id_pre = 0;

            } else {
                traerDatosSocio($("#nrodocumento").val());
            }
            
          }
        });
      }
  });


  function traerDatosSocio(nroDocumento) {
    
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: 'ajax/ajax.php', // devuelve "jugador", "equipo" y "goles" con parametros obligatorio idtorneo
      data: {nrodocumento: nroDocumento,
              accion:'traerDatosSocio'},
      beforeSend: function (XMLHttpRequest) {
        $("#load").show();
      },
      success: function(datos) {
        
        alerta(MSG_DATOS_OBLIGATORIOS, "done");

        for (var clave in datos) {
          $('#txtApellido').val(datos[clave].apellido);
          $('#txtNombre').val(datos[clave].nombres);
          $('#txtEmail').val(datos[clave].email);
          $('#txtFechaNacimiento').val(datos[clave].fechanacimiento);
          id_pre = datos[clave].id;
        }

        $('.primero').show(300);
        Materialize.showStaggeredList('.primero');
        $("#load").hide();
        Materialize.updateTextFields();

       },
        error: function() { alert("Error leyendo fichero"); }
    });
      
  }

  $('#login').click(function() {
    $(location).attr('href','index.php');
  });

  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 50,
    min: [1930,1,1],
    max: [<?php echo (date('Y')-4); ?>,12,31], // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: false // Close upon selecting a date,
  });
});
</script>
</body>

</html>