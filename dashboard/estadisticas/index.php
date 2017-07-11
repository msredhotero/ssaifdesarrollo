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
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Estadisticas",$_SESSION['refroll_predio'],'');

$resFixture		=	$serviciosReferencias->traerFixtureTodo();
$cadFix			=	$serviciosFunciones->devolverSelectBox($resFixture,array(0,1,4,5,10),' - ');



$refCanchas		=	$serviciosReferencias->traerCanchas();

$cadCanchas	=	$serviciosFunciones->devolverSelectBox($refCanchas,array(1),'');	



$refArbitros	=	$serviciosReferencias->traerArbitros();

$cadArbitros	=	$serviciosFunciones->devolverSelectBox($refArbitros,array(1),'');	



$resProximasFechas	= $serviciosReferencias->traerProximaFechaTodos();
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

<h3>Fixture</h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Buscar Partido</p>
        	
        </div>
    	<div class="cuerpoBox" style="padding-right:10px;">
    		<form class="form-inline formulario" role="form">
        	<div class="row">
				<div class="col-md-6">
                    <label class="control-label">Ingrese el Numero de Partido</label>
                    <div class="input-group">
                        <input class="form-control" type="text" name="buscar" id="buscar"/>
                        <button type="button" class="btn btn-success" id="busqueda">Buscar</button>
                    </div>
                </div>

				<div class="col-md-6">
                    <label class="control-label">Ingrese el Numero de Partido</label>
                    <div class="input-group">
                        <select class="form-control" id="fixture" name="fixture">
                        	<?php echo $cadFix; ?>	
                        </select>
                        <button type="button" class="btn btn-success" id="ir">Ir</button>
                    </div>
                </div>
            </div>
            
            <div class='row' style="margin-left:15px; margin-right:15px; margin-top:10px;">
            	<h2>Proximas Fechas</h2>
            <?php
				$categorias = '';
				$cadCabecera = '';
				$primero = 0;
				while ($row = mysql_fetch_array($resProximasFechas)) {
					if ($categorias != $row['categoria']) {
						if ($primero != 0) {
							$cadCabecera .= '</tbody></table></div></div></div>';
						}
						$cadCabecera .= '<div class="col-md-12"><div class="panel panel-primary">
										<div class="panel-heading">'.$row['categoria'].' - '.$row['fecha'].'</div>
										<div class="panel-body">
										<table class="table table-striped" style="padding:2px;">
										<thead>
											<tr>
												<th>Local</th>
												<th>Visitante</th>
												<th>Fecha</th>
												<th>Hora</th>
												<th>Division</th>
												<th>Arbitro</th>
												<th></th>
												<th>Accion</th>

											</tr>
										</thead>
										<tbody>';
										
						$primero = 1;
						$categorias = $row['categoria'];			
					}
					
					$dateH = new DateTime($row['fechajuego']);
					
					$cadCabecera .= "<tr>
										<td>".$row['equipoLocal']."</td>
										<td>".$row['equipoVisitante']."</td>
										<td>".$dateH->format('d-m-Y')."</td>
										<td>".$row['hora']."</td>
										<td>".$row['division']."</td>
										<td><select data-placeholder='selecione el Arbitro...' id='refarbitros' name='refarbitros' class='chosen-select' tabindex='2' style='width:210px;'>
            								<option value='".$row['idarbitro']."'>".$row['arbitro']."</option>
											".$cadArbitros."
                                            </select></td>
										<td><a href='estadisticas.php?id=".$row['idfixture']."'>Ver</a></td>
										<td><button type='button' class='btn btn-primary cargaparticular' id='".$row['idfixture']."'>Guardar</button></td>
									</tr>";

				}
				
				$cadCabecera .= '</tbody></table></div></div></div>';
				
				echo $cadCabecera;
			?>
            </div>
            
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

});
</script>
<?php } ?>
</body>
</html>
