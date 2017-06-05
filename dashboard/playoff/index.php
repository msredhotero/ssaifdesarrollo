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
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"PlayOff",$_SESSION['refroll_predio'],'');


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "PlayOff";

$plural = "PlayOff";

$eliminar = "eliminarCategorias";

$insertar = "insertarCategorias";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "tbcategorias";

$lblCambio	 	= array("");
$lblreemplazo	= array("");


$cadRef 	= '';

$refdescripcion = array();
$refCampo 	=  array();
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "	<th>Categorias</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$playOff		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOff();



if ($_SESSION['refroll_predio'] != 1) {

} else {

	
}


?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title><?php echo $tituloWeb; ?></title>
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
	<link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	
    
   
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
   <style>
   	main{
  display:flex;
  flex-direction:row;
}
.round{
  display:flex;
  flex-direction:column;
  justify-content:center;
  width:200px;
  list-style:none;
  padding:0;
}
  .round .spacer{ flex-grow:1; }
  .round .spacer:first-child,
  .round .spacer:last-child{ flex-grow:.5; }

  .round .game-spacer{
    flex-grow:1;
  }



li.game{
  padding-left:20px;
  
}

  li.game.winner{
    font-weight:bold;
  }
  li.game span{
    float:right;
    margin-right:5px;
	
  }

  li.game-top{ background-color:#46953E;}

  li.game-spacer{ 
    border-right:2px solid #46953E;
    min-height:40px;
  }
  
  li.game-spacer-sin{ 
    border-right:none;
    min-height:40px;
  }

  li.game-bottom{ 
	background-color:#46953E;
  }
   
   </style>
 
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

<h3><?php echo $plural; ?></h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de <?php echo $plural; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">
       
				<h4>2013 NCAA Tournament - Midwest Bracket</h4>
                <main id="tournament">
                	<?php
					
					
						while ($row = mysql_fetch_array($playOff)) {
						
						
					?>
                	<ul class="round round-1">
                        
                        
                        <li class="game game-top "></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom winner"></li>
                
						<li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Colo St <span>84</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">Missouri <span>72</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top "></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom winner"></li>
                
                        
                        <li class="game game-top "></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom winner"></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Memphis <span>54</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">St Mary's <span>52</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top "></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom winner"></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top "></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom winner"></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top "></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom winner"></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top "></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom winner"></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top "></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom winner"></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top "></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom winner"></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner"></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom "></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner"></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom "></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner"></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom "></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner"></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom "></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner"></li>
                        <li class="game game-spacer-sin">&nbsp;</li>
                        <li class="game game-bottom "></li>
                
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-2">
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Lousville <span>79</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">NC A&T <span>48</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Colo St <span>84</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">Missouri <span>72</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top ">Oklahoma St <span>55</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom winner">Oregon <span>68</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Saint Louis <span>64</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">New Mexico St <span>44</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Memphis <span>54</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">St Mary's <span>52</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Mich St <span>65</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">Valparaiso <span>54</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Creighton <span>67</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">Cincinnati <span>63</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Duke <span>73</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">Albany <span>61</span></li>
                
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-3">
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Lousville <span>82</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">Colo St <span>56</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Oregon <span>74</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">Saint Louis <span>57</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top ">Memphis <span>48</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom winner">Mich St <span>70</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top ">Creighton <span>50</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom winner">Duke <span>66</span></li>
                
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-4">
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Lousville <span>77</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">Oregon <span>69</span></li>
                
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top ">Mich St <span>61</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom winner">Duke <span>71</span></li>
                
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-5">
                        <li class="spacer">&nbsp;</li>
                        
                        <li class="game game-top winner">Lousville <span>85</span></li>
                        <li class="game game-spacer">&nbsp;</li>
                        <li class="game game-bottom ">Duke <span>63</span></li>
                        
                        <li class="spacer">&nbsp;</li>
                    </ul>	
                    
                    <?php
						}
					?>	
                </main>
   

            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                        <button type="button" class="btn btn-primary" id="cargar" style="margin-left:0px;">Guardar</button>
                    </li>
                </ul>
                </div>
            </div>
            </form>
    	</div>
    </div>
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;"><?php echo $plural; ?> Cargados</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<?php //echo $lstCargados; ?>
    	</div>
    </div>
    
    

    
    
   
</div>


</div>
<div id="dialog2" title="Eliminar <?php echo $singular; ?>">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea eliminar el <?php echo $singular; ?>?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si elimina el <?php echo $singular; ?> se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$('#example').dataTable({
		"order": [[ 0, "asc" ]],
		"language": {
			"emptyTable":     "No hay datos cargados",
			"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
			"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
			"infoFiltered":   "(filtrados del total de _MAX_ filas)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Mostrar _MENU_ filas",
			"loadingRecords": "Cargando...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"zeroRecords":    "No se encontraron resultados",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activate to sort column ascending",
				"sortDescending": ": activate to sort column descending"
			}
		  }
	} );
	
	$('#activo').prop('checked',true);

	$("#example").on("click",'.varborrar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			$("#idEliminar").val(usersid);
			$("#dialog2").dialog("open");

			
			//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
			//$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton eliminar
	
	$("#example").on("click",'.varmodificar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar

	 $( "#dialog2" ).dialog({
		 	
			    autoOpen: false,
			 	resizable: false,
				width:600,
				height:240,
				modal: true,
				buttons: {
				    "Eliminar": function() {
	
						$.ajax({
									data:  {id: $('#idEliminar').val(), accion: '<?php echo $eliminar; ?>'},
									url:   '../../ajax/ajax.php',
									type:  'post',
									beforeSend: function () {
											
									},
									success:  function (response) {
											url = "index.php";
											$(location).attr('href',url);
											
									}
							});
						$( this ).dialog( "close" );
						$( this ).dialog( "close" );
							$('html, body').animate({
	           					scrollTop: '1000px'
	       					},
	       					1500);
				    },
				    Cancelar: function() {
						$( this ).dialog( "close" );
				    }
				}
		 
		 
	 		}); //fin del dialogo para eliminar
			

	

	
	
	//al enviar el formulario
    $('#cargar').click(function(){
		
		if (validador() == "")
        {
			//información del formulario
			var formData = new FormData($(".formulario")[0]);
			var message = "";
			//hacemos la petición ajax  
			$.ajax({
				url: '../../ajax/ajax.php',  
				type: 'POST',
				// Form data
				//datos del formulario
				data: formData,
				//necesario para subir archivos via ajax
				cache: false,
				contentType: false,
				processData: false,
				//mientras enviamos el archivo
				beforeSend: function(){
					$("#load").html('<img src="../../imagenes/load13.gif" width="50" height="50" />');       
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
                                            $(".alert").removeClass("alert-danger");
											$(".alert").removeClass("alert-info");
                                            $(".alert").addClass("alert-success");
                                            $(".alert").html('<strong>Ok!</strong> Se cargo exitosamente el <strong><?php echo $singular; ?></strong>. ');
											$(".alert").delay(3000).queue(function(){
												/*aca lo que quiero hacer 
												  después de los 2 segundos de retraso*/
												$(this).dequeue(); //continúo con el siguiente ítem en la cola
												
											});
											$("#load").html('');
											url = "index.php";
											$(location).attr('href',url);
                                            
											
                                        } else {
                                        	$(".alert").removeClass("alert-danger");
                                            $(".alert").addClass("alert-danger");
                                            $(".alert").html('<strong>Error!</strong> '+data);
                                            $("#load").html('');
                                        }
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
                    $("#load").html('');
				}
			});
		}
    });

});
</script>

<script type="text/javascript">
$('.form_date').datetimepicker({
	language:  'es',
	weekStart: 1,
	todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 0,
	format: 'dd/mm/yyyy'
});
</script>
<?php } ?>
</body>
</html>
