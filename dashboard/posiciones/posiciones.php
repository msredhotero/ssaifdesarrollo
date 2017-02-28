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

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Posiciones",$_SESSION['refroll_predio'],'');

$idTorneo		=	$_GET['id'];

$resPosiciones		=	$serviciosReferencias->Posiciones($idTorneo);


if ($_SESSION['refroll_predio'] != 1) {

} else {

	
}


?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Gesti&oacute;n: AIF</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>

	<style type="text/css">
			th {
			  color:#D5DDE5;;
			  background:#1b1e24;
			  border-bottom:4px solid #9ea7af;
			  border-right: 1px solid #343a45;
			  font-size:17px;
			  font-weight: 100;
			  padding:18px;
			  text-align:left;
			  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
			  vertical-align:middle;
			  font-family: "Roboto", helvetica, arial, sans-serif;
			}
			
			th:first-child {
			  border-top-left-radius:3px;
			}
			 
			th:last-child {
			  border-top-right-radius:3px;
			  border-right:none;
			}
			
			tr {
			  border-top: 1px solid #C1C3D1;
			  border-bottom-: 1px solid #C1C3D1;
			  color:#666B85;
			  font-size:16px;
			  font-weight:normal;
			  text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
			}
  
		
	</style>
    
   
   <link href="../../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../../js/jquery.mousewheel.js"></script>
      <script src="../../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
      });
    </script>
    

</head>

<body>

 
<?php echo $resMenu; ?>

<div id="content">

<h3>Estadisticas</h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Tabla de Posiciones</p>
        	
        </div>
    	<div class="cuerpoBox" style="padding-right:10px;">
    		<form class="form-inline formulario" role="form">
        	<div class="row">
				<div class="col-md-12">
                    <table class="table table-bordered table-responsive">
                    	<thead>
                        	<th>Posicion</th>
                            <th>Equipos</th>
                            <th>PJ</th>
                            <th>PG</th>
                            <th>PP</th>
                            <th>PE</th>
                            <th>Goles</th>
                            <th>Puntos</th>
                        </thead>
                        <tbody>
                        	<?php
								$cant = 1;
								while ($row = mysql_fetch_array($resPosiciones)) {
							?>
                            <tr>
                            	<td><?php echo $cant; ?></td>
                                <td><?php echo $row['equipo']; ?></td>
                                <td><?php echo $row['pj']; ?></td>
                                <td><?php echo $row['pg']; ?></td>
                                <td><?php echo $row['pp']; ?></td>
                                <td><?php echo $row['pe']; ?></td>
                                <td><?php echo $row['goles']; ?></td>
                                <td><?php echo $row['puntos']; ?></td>
                            </tr>
                            <?php
								$cant += 1;
								}
							?>
                        </tbody>
                    </table>
                </div>

				
            </div>
            
            <div class='row' style="margin-left:15px; margin-right:15px;">
                <div class='alert'>
                	
                </div>
                <div class='alert alert2'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
			
			<div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                        <button type="button" class="btn btn-default" id="volver" style="margin-left:0px;">volver</button>
                    </li>
                   <!-- <li>
                        <button type="button" class="btn btn-success" id="chequearF" style="margin-left:0px;">Chequear Fixture</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-success" id="conductaF" style="margin-left:0px;">Cargar Conducta al Fixture</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-primary" id="fixtureM" style="margin-left:0px;">Fixture Manual</button>
                    </li>-->

                </ul>
                </div>
            </div>
            </form>
    	</div>
    </div>



   
</div>


</div>






<script type="text/javascript">
$(document).ready(function(){
	
	$('#busqueda').click(function(e) {
        $.ajax({
			data:  {id: $('#buscar').val(), accion: 'buscarPartido'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
				if (response > 0) {
					url = "estadisticas.php?id="+response;
					$(location).attr('href',url);
				} else {
					$(".alert").removeClass("alert-danger");
					$(".alert").addClass("alert-danger");
					$(".alert").html('<strong>Error!</strong> No se encontro el partido');
					$("#load").html('');
				}
			}
		});
    });
	
	$('#ir').click(function() {
		url = "estadisticas.php?id="+ $('#fixture').val();
		$(location).attr('href',url);
	});
	
	$('#volver').click( function() {
		url = "../fixture/index.php";
		$(location).attr('href',url);
	});

});
</script>
<?php } ?>
</body>
</html>
