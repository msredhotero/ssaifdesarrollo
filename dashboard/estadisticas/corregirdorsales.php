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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../estadisticas/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Carga de Partidos",$_SESSION['refroll_predio'],$_SESSION['email_predio']);

$res		=	$serviciosReferencias->eroresDorsales();




//////////////////////////////////////////////  FIN de los opciones //////////////////////////

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
	<link rel="stylesheet" href="../../css/chosen.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>

	<style type="text/css">
		
  
		
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

<h3>Carga de Partidos</h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Dorsales Conflictivos</p>
        	
        </div>
    	<div class="cuerpoBox" style="padding-right:10px;">
    		<form class="form-inline formulario" role="form">


            <?php if ($_SESSION['idroll_predio'] == 1) { ?>
            <div class='row' style="margin-left:15px; margin-right:15px; margin-top:10px;">
            	<h2>Dorsales Distintos de Cambios que salen</h2>
                <div class="row">

                
                <div class="col-md-12">
                    <div id="proxima">
                        <table class="table table-striped">
                            <thead>
                                <th>Partido</th>
                                <th>Dorsal Conflicto</th>
                                <th>Categoria</th>
                                <th>Division</th>
                                <th>Fecha Juego</th>
                                <th>Equipo</th>
                                <th>Nuevo Dorsal</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <?php
                                    $i=0;
                                    while ($row = mysql_fetch_array($res)) {
                                        $i += 1;
                                        echo "<tr><td><a href='estadisticas.php?id=".$row[0]."' target='_blank'>".$row[0]."</a></td>";
                                        echo "<td>".$row[1]."</td>";
                                        echo "<td>".$row[2]."</td>";
                                        echo "<td>".$row[3]."</td>";
                                        echo "<td>".$row[4]."</td>";
                                        echo "<td>".$row[5]."</td>";
                                        echo "<td><input type='text' class='form-control' name='dorsalnuevo".$row[6]."' id='dorsalnuevo".$row[6]."' /></td>";
                                        echo '<td><button type="button" class="btn btn-primary guardarPartidoSimple" id="'.$row[6].'">Guardar</button></td></tr>';
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <th colspan="8" class="alert alert-danger">Total Registros: <?php echo $i; ?></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                
                
                
				
                
                
            </div>
            
            </div>
            <?php } ?>
            <div class='row' style="margin-left:15px; margin-right:15px;">
                <div class='alert'>
                	
                </div>
                <div class='alert alert2'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
			

            </form>
    	</div>
    </div>



   
</div>

<!-- Modal del guardar-->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Guardar Dorsal</h4>
        </div>
        <div class="modal-body">
          <p id="error"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

</div>

</div>






<script type="text/javascript">
$(document).ready(function(){
	

	

	$("#proxima").on("click",'.guardarPartidoSimple', function(){
		
		idBtn = $(this).attr("id");
		
		if ($('#dorsalnuevo'+$(this).attr("id")).val() != '') {
            $('#myModal').modal("show");
            $.ajax({
                data:  {idcambio: $(this).attr("id"), 
                        dorsalnuevo: $('#dorsalnuevo'+$(this).attr("id")).val(), 
                        accion: 'modificarCambioSimple'},
                url:   '../../ajax/ajax.php',
                type:  'post',
                beforeSend: function () {
                        
                },
                success:  function (response) {
                    if (response == '') {
                        $('#error').html('<span class="glyphicon glyphicon-ok"></span> Se guardo correctamente');
                        $('#'+idBtn).removeClass("btn-primary");
                        $('#'+idBtn).addClass("btn-success");
                        $('#'+idBtn).html('<span class="glyphicon glyphicon-ok"></span> Guardado');
                        
                    } else {
                        $('#error').html('Huvo un error al guardar los datos, verifique los datos ingresados '.response);
                        $('#'+idBtn).removeClass("btn-primary");
                        $('#'+idBtn).addClass("btn-danger");
                        $('#'+idBtn).html('<span class="glyphicon glyphicon-ban-circle"></span> Guardar');
                    }
                }
            });
        } else {
            alert('Ingrese un numero');
        }
		
    });									
										
	

});
</script>

<?php } ?>
</body>
</html>
