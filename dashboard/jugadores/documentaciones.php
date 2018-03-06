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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../jugadores/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Jugadores",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


	
if (!$_POST){
	if (!isset($_GET['id'])) {
		header('Location: index.php');
	}
	$id	= $_GET['id'];

} else {
	if (!isset($_POST['id'])) {
		header('Location: index.php');
	}
	
	//die(var_dump($_FILES['avatar-1']));

	$id	= $_POST['refjugadores'];
	//die(print_r($_POST));
	
	//$refjugadores = $_POST['refjugadores']; 
	
	//elimino todo y lo vuelvo a cargar
	$serviciosReferencias->eliminarJugadoresdocumentacionPorJugador($id);
	$serviciosReferencias->eliminarJugadoresvaloreshabilitacionestransitoriasPorJuagador($id);
	//// fin del eliminar //////
	
	$observaciones = '';
	
	$resDocu = $serviciosReferencias->traerDocumentaciones();
	$cad = 'docu';
	while ($rowFS = mysql_fetch_array($resDocu)) {
		if (isset($_POST[$cad.$rowFS[0]])) {
		
			$res = $serviciosReferencias->insertarJugadoresdocumentacion($id,$rowFS[0],1,$observaciones);
		} else {
			$res = $serviciosReferencias->insertarJugadoresdocumentacion($id,$rowFS[0],0,$observaciones);
		
		}
	}
	
	$resV = '';
	$resValores = $serviciosReferencias->traerDocumentaciones();
	$cadV = 'multiselect';

	while ($rowV = mysql_fetch_array($resValores)) {
		$resV .= $cadV.$rowV[0];
		if (isset($_POST[$cadV.$rowV[0]])) {
			$resV .= $serviciosReferencias->insertarJugadoresvaloreshabilitacionestransitorias($id,$_POST[$cadV.$rowV[0]][0]);
		}
	}



	$resJugador = $serviciosReferencias->traerJugadoresPorId($id);

	$resJugadorPre = $serviciosReferencias->traerJugadoresprePorNroDocumento(mysql_result($resJugador,0,'nrodocumento'));

	//si ya existe un jugador precargado
	if (mysql_num_rows($resJugadorPre)> 0) {
		$idPre = mysql_result($resJugadorPre,0,0);
	} else {
		$idPre = 0;
	}

	$resFoto 				= $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,1,$idPre);
	$resFotoDocumento 		= $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,2,$idPre);
	$resFotoDocumentoDorso 	= $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,99,$idPre);
	
	$resTitulo 			   	= $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,4,$idPre);
	$resExpensa				= $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,6,$idPre);
	$resPartidaNacimiento	= $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,9,$idPre);

	

	$error = '';

	if ($_FILES['avatar-1']['tmp_name'] != '') {
		if (mysql_num_rows($resFoto)>0) {
			$serviciosReferencias->eliminarFotoJugadoresID(1,$id,$idPre);
		}

		$nuevoId = $serviciosReferencias->obtenerNuevoId('dbdocumentacionjugadorimagenes');
		$error = $serviciosReferencias->subirArchivoJugadoresID('avatar-1',$idPre,$nuevoId,1,$idPre,$id);

		if ($error == '') {
			//elimino la documentacion
			$serviciosReferencias->eliminarJugadoresdocumentacionPorJugadorDocumen($id, 1);

			//elimino el valor
			$serviciosReferencias->eliminarJugadoresvaloreshabilitacionestransitoriasPorJugadorDocumentacion($id, 1);

			$serviciosReferencias->insertarJugadoresdocumentacion($id,1,1,'');

			//foto
			$serviciosReferencias->insertarJugadoresvaloreshabilitacionestransitorias($id,331);
		}
	}

	$cantidadDocumento = 0;
	if ($_FILES['avatar-2']['tmp_name'] != '') {
		if (mysql_num_rows($resFotoDocumento)>0) {
			$serviciosReferencias->eliminarFotoJugadoresID(2,$id,$idPre);
		}

		$nuevoId2 = $serviciosReferencias->obtenerNuevoId('dbdocumentacionjugadorimagenes');
		$error .= $serviciosReferencias->subirArchivoJugadoresID('avatar-2',$idPre,$nuevoId2,2,$idPre,$id);

		$cantidadDocumento += 1;
		
	}

	if ($_FILES['avatar-3']['tmp_name'] != '') {
		if (mysql_num_rows($resFotoDocumentoDorso)>0) {
			$serviciosReferencias->eliminarFotoJugadoresID(99,$id,$idPre);
		}

		$cantidadDocumento += 1;

		$nuevoId3 = $serviciosReferencias->obtenerNuevoId('dbdocumentacionjugadorimagenes');
		$error .= $serviciosReferencias->subirArchivoJugadoresID('avatar-3',$idPre,$nuevoId3,99,$idPre,$id);
	}

	if ($cantidadDocumento >= 2) {
		//elimino la documentacion
		$serviciosReferencias->eliminarJugadoresdocumentacionPorJugadorDocumen($id, 2);

		//elimino el valor
		$serviciosReferencias->eliminarJugadoresvaloreshabilitacionestransitoriasPorJugadorDocumentacion($id, 2);

		$serviciosReferencias->insertarJugadoresdocumentacion($id,2,1,'');

		//foto
		$serviciosReferencias->insertarJugadoresvaloreshabilitacionestransitorias($id,333);
	}


	if ($_FILES['avatar-4']['tmp_name'] != '') {
		if (mysql_num_rows($resTitulo)>0) {
			$serviciosReferencias->eliminarFotoJugadoresID(4,$id,$idPre);
		}

		$nuevoId4 = $serviciosReferencias->obtenerNuevoId('dbdocumentacionjugadorimagenes');
		$error .= $serviciosReferencias->subirArchivoJugadoresID('avatar-4',$idPre,$nuevoId4,4,$idPre,$id);

		if ($error == '') {
			//elimino la documentacion
			$serviciosReferencias->eliminarJugadoresdocumentacionPorJugadorDocumen($id, 4);

			//elimino el valor
			$serviciosReferencias->eliminarJugadoresvaloreshabilitacionestransitoriasPorJugadorDocumentacion($id, 4);

			$serviciosReferencias->insertarJugadoresdocumentacion($id,4,1,'');

			//foto
			$serviciosReferencias->insertarJugadoresvaloreshabilitacionestransitorias($id,338);
		}
	}


	if ($_FILES['avatar-5']['tmp_name'] != '') {
		if (mysql_num_rows($resExpensa)>0) {
			$serviciosReferencias->eliminarFotoJugadoresID(6,$id,$idPre);
		}

		$nuevoId5 = $serviciosReferencias->obtenerNuevoId('dbdocumentacionjugadorimagenes');
		$error .= $serviciosReferencias->subirArchivoJugadoresID('avatar-5',$idPre,$nuevoId5,6,$idPre,$id);


		if ($error == '') {
			//elimino la documentacion
			$serviciosReferencias->eliminarJugadoresdocumentacionPorJugadorDocumen($id, 6);

			//elimino el valor
			$serviciosReferencias->eliminarJugadoresvaloreshabilitacionestransitoriasPorJugadorDocumentacion($id, 6);

			$serviciosReferencias->insertarJugadoresdocumentacion($id,6,1,'');

			//foto
			$serviciosReferencias->insertarJugadoresvaloreshabilitacionestransitorias($id,365);
		}
	}


	if ($_FILES['avatar-6']['tmp_name'] != '') {
		if (mysql_num_rows($resPartidaNacimiento)>0) {
			$serviciosReferencias->eliminarFotoJugadoresID(9,$id,$idPre);
		}

		$nuevoId6 = $serviciosReferencias->obtenerNuevoId('dbdocumentacionjugadorimagenes');
		$error .= $serviciosReferencias->subirArchivoJugadoresID('avatar-6',$idPre,$nuevoId6,9,$idPre,$id);

		if ($error == '') {
			//elimino la documentacion
			$serviciosReferencias->eliminarJugadoresdocumentacionPorJugadorDocumen($id, 9);

			//elimino el valor
			$serviciosReferencias->eliminarJugadoresvaloreshabilitacionestransitoriasPorJugadorDocumentacion($id, 9);

			$serviciosReferencias->insertarJugadoresdocumentacion($id,9,1,'');

			//foto
			$serviciosReferencias->insertarJugadoresvaloreshabilitacionestransitorias($id,368);
		}
	}
	
}

$resResultado = $serviciosReferencias->traerJugadoresPorId($id);

$resResultadoPre = $serviciosReferencias->traerJugadoresprePorNroDocumento(mysql_result($resResultado,0,'nrodocumento'));



$resJugadores = $serviciosReferencias->traerJugadoresdocumentacionPorJugador($id);


//si ya existe un jugador precargado
	if (mysql_num_rows($resResultadoPre)> 0) {
		$idPre = mysql_result($resResultadoPre,0,0);
		$idJugadorPre = mysql_result($resResultadoPre,0,0);
	} else {
		$idPre = 0;
	}
/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Documentación del jugador";

$plural = "Documentaciones del jugador";

$eliminar = "eliminarJugadoresdocumentacion";

$insertar = "insertarJugadoresdocumentacion";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbjugadoresdocumentacion";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resDocumentaciones2	=	$serviciosReferencias->traerDocumentaciones();
$resDocumentaciones	=	$serviciosReferencias->traerDocumentaciones();
$cadRef4	=	$serviciosFunciones->devolverSelectBox($resDocumentaciones,array(1),'');

$existeDocumentacionCargada = 1;

if (mysql_num_rows($resJugadores)<1) {
	$existeDocumentacionCargada = 0;
}

//foto
$resFoto = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,1,$idPre);
//foto documento frente
$resFotoDocumento = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,2,$idPre);
//foto documento dorsal
$resFotoDocumentoDorso = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,99,$idPre);
//titulo
$resTitulo = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,4,$idPre);
//expensa
$resExpensa = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,6,$idPre);
//partida nacimiento
$resPartidaNacimiento = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacionID($id,9,$idPre);



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

    <link rel="stylesheet" href="../../css/fileinput/fileinput.css"/>

	<script src="../../js/fileinput/plugins/sortable.min.js"></script>
	<!-- purify plugin for safe rendering HTML content in preview -->
	<script src="../../js/fileinput/plugins/purify.min.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<!--<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
     Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	
    
   <style>
   	.clickable{
    cursor: pointer;   
	}
	
	.panel-heading span {
		margin-top: -20px;
		font-size: 15px;
	}

	.kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
	    margin: 0;
	    padding: 0;
	    border: none;
	    box-shadow: none;
	    text-align: center;
	}
	.kv-avatar {
	    display: inline-block;
	}
	.kv-avatar .file-input {
	    display: table-cell;
	    width: 213px;
	}
	.kv-reqd {
	    color: red;
	    font-family: monospace;
	    font-weight: normal;
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
    
    <link rel="stylesheet" href="../../css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="../../js/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="../../css/chosen.css">
    <script type="text/javascript">
		$(document).ready(function() {
			$('#example-post').multiselect({
				includeSelectAllOption: true,
				enableFiltering: true
			});
		});
	</script>
 	
    
    <style>
   	.dropdown-menu {
  max-height: 500px;
  overflow-y: auto;
  overflow-x: hidden;
  z-index:999999999999;
 }
	
	
   </style>
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">
	
		<div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">
                
            <div class="col-xs-3 bs-wizard-step complete">
              <div class="text-center bs-wizard-stepnum">Paso 1</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="modificar.php?id=<?php echo $id; ?>" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Carga del jugador (Nro Documento Unico).</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step active"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Paso 2</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Carga de la Documentación presentada.</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step disabled"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Paso 3</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Asignar al Jugador a un Equipo.</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step disabled"><!-- active -->
              <div class="text-center bs-wizard-stepnum">Paso 4</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center"> Carga de las Habilitaciones Transitorias (Deportivas y Documentaciones)</div>
            </div>
            

        </div>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de <?php echo $plural; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<ul class="list-group">
              <li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-user"></span> Jugador</li>
              <li class="list-group-item list-group-item-default">Nombre Completo: <?php echo mysql_result($resResultado,0,'apellido').', '.mysql_result($resResultado,0,'nombres'); ?></li>
              <li class="list-group-item list-group-item-default">Nro Documento: <?php echo mysql_result($resResultado,0,'nrodocumento'); ?></li>
              <li class="list-group-item list-group-item-default">Fecha de Nacimiento: <?php echo mysql_result($resResultado,0,'fechanacimiento'); ?></li>
              <li class="list-group-item list-group-item-default">Countrie: <?php echo mysql_result($serviciosReferencias->traerCountriesPorId(mysql_result($resResultado,0,'refcountries')),0,'nombre'); ?></li>
            </ul>
            
        	<form class="form-inline formulario" id="formulario" role="form" method="post" action="documentaciones.php" enctype="multipart/form-data">
        	<div class="row">
				<?php
				//***************  defino si entro a modificar o a cargar   ***********************///////////
				if (mysql_num_rows($resJugadores)<1) {
					while ($row = mysql_fetch_array($resDocumentaciones2)) {
						$resValores		=	$serviciosReferencias->traerValoreshabilitacionestransitoriasPorDocumentacion($row[0]);
						$habiltacionTranst = $serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorAdministrativaDocumentacion( $id,$row[0]);
						$habilita = '';

						if (mysql_num_rows($habiltacionTranst)>0) {
							$habilita = '*';
						}
						
				?>
					<?php
                        if ($row[2] == 'Si') { 
                    
                        $cadA = '<span class="glyphicon glyphicon-check"></span>';
                     } else { 
                        $cadA = '<span class="glyphicon glyphicon-remove"></span>';
                     } ?>
                    <div class="col-md-4" style="margin-bottom:7px;">
                        
                            
                            <?php
							if (mysql_num_rows($resValores)>0) {
							?>
                            	<div class="input-group">
                            	<span class="input-group-addon">
                                <input type="checkbox" aria-label="..." id="docu<?php echo $row[0]; ?>" name="docu[]">
                                <span style="color:#F00"><?php echo $habilita; ?></span>
                                </span>
                                <input type="text" class="form-control" aria-label="..." value="<?php echo $row[1]; ?>">
                                <span class="input-group-addon">
                                    <?php echo $cadA; ?>
                                </span>
								</div><!-- /input-group -->
                                <script type="text/javascript">
									$(document).ready(function() {
										$('#example-templates-button<?php echo $row[0]; ?>').multiselect({
											buttonContainer: '<div></div>',
											buttonClass: '',
											templates: {
												button: '<span class="multiselect<?php echo $row[0]; ?> dropdown-toggle" data-toggle="dropdown">(Valores)</span>'
											}
										});
										
										
									});
								</script>
								<style type="text/css">
									span.multiselect<?php echo $row[0]; ?> {
										padding: 2px 6px;
										font-weight: bold;
										cursor: pointer;
										z-index:99999999999999999999999;
									}
								</style>
                                <div class="FixedHeightContainer<?php echo $row[0]; ?>">
								<select id="example-templates-button<?php echo $row[0]; ?>" name="multiselect<?php echo $row[0]; ?>[]" required>
									<?php
										while ($rowV = mysql_fetch_array($resValores)) {
											if ($rowV['pordefecto'] == 1) {
												$chequeado = 'selected="selected"';	
											} else {
												$chequeado = '';	
											}
									?>
                                    <option value="<?php echo $rowV[0]; ?>" <?php echo $chequeado; ?>><?php echo $rowV[2]; ?> - Habilita: <?php echo $rowV[3]; ?></option>

                                    <?php
										}
									?>
								</select>
                                </div>
                            <?php
							} else {
							?>
                            <div class="input-group">
                            <span class="input-group-addon">
                            <input type="checkbox" aria-label="..." id="docu<?php echo $row[0]; ?>" name="docu<?php echo $row[0]; ?>">
                            </span>
                            <input type="text" class="form-control" aria-label="..." value="<?php echo $row[1]; ?>">
                            <span class="input-group-addon">
                            	<?php echo $cadA; ?>
                            </span>
                            </div><!-- /input-group -->
                            <?php
							} 
							?>
                        
                    </div><!-- /.col-lg-6 -->
                <?php
					}
				} else {
					while ($row = mysql_fetch_array($resJugadores)) {
						$resValores		=	$serviciosReferencias->traerValoreshabilitacionestransitoriasPorDocumentacionJugadorActivas($row[0],$id);
						
						$habiltacionTranst = $serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorAdministrativaDocumentacion( $id,$row['refdocumentaciones']);
						
				?>
                	<?php
						if ($row[3] == 'Si') { 
							$check = 'checked';
						} else {
							$check = '';
						}
						
                        if ($row[2] == 'Si') { 
                    
							$cadA = '<span class="glyphicon glyphicon-check"></span>';
						 } else { 
							$cadA = '<span class="glyphicon glyphicon-remove"></span>';
						 } ?>
                    <div class="col-md-4" style="margin-bottom:7px;">
                        
                            
                            <?php
							if (mysql_num_rows($resValores)>0) {
							?>
                            	<div class="input-group">
                            	<span class="input-group-addon">
                                <input type="checkbox" <?php echo $check; ?> aria-label="..." id="docu<?php echo $row[0]; ?>" name="docu<?php echo $row[0]; ?>">
                                </span>
                                <input type="text" class="form-control" aria-label="..." value="<?php echo $row[1]; ?>">
                                <?php 
									if (mysql_num_rows($habiltacionTranst)>0) {
								?>
                                <span class="input-group-addon" style="color:#F00;">
                                <?php } else { ?>
                                <span class="input-group-addon">
                                <?php } ?>
                                    <?php echo $cadA; ?>
                                </span>
								</div><!-- /input-group -->
                                <script type="text/javascript">
									$(document).ready(function() {
										$('#example-templates-button<?php echo $row[0]; ?>').multiselect({
											buttonContainer: '<div></div>',
											buttonClass: '',
											templates: {
												button: '<span class="multiselect<?php echo $row[0]; ?> dropdown-toggle" data-toggle="dropdown">(Valores)</span>'
											}
										});
										
										
									});
								</script>
								<style type="text/css">
									span.multiselect<?php echo $row[0]; ?> {
										padding: 2px 6px;
										font-weight: bold;
										cursor: pointer;
										z-index:99999999999999999999999;
									}
								</style>
                                <div class="FixedHeightContainer<?php echo $row[0]; ?>">
								<select id="example-templates-button<?php echo $row[0]; ?>" name="multiselect<?php echo $row[0]; ?>[]" required>
									<?php
										while ($rowV = mysql_fetch_array($resValores)) {
											if ($rowV[4] > 0) {
												$chequeado = 'selected="selected"';	
											} else {
												$chequeado = '';	
											}
									?>
                                    <option value="<?php echo $rowV[0]; ?>" <?php echo $chequeado; ?>><?php echo $rowV[2]; ?> - Habilita: <?php echo $rowV[3]; ?></option>

                                    <?php
										}
									?>
								</select>
                                </div>
                            <?php
							} else {
							?>
                            <div class="input-group">
                            <span class="input-group-addon">
                            <input type="checkbox" <?php echo $check; ?> aria-label="..." id="docu<?php echo $row[0]; ?>" name="docu<?php echo $row[0]; ?>">
                            </span>
                            <input type="text" class="form-control" aria-label="..." value="<?php echo $row[1]; ?>">
                            <span class="input-group-addon">
                            	<?php echo $cadA; ?>
                            </span>
                            </div><!-- /input-group -->
                            <?php
							} 
							?>
                        
                    </div><!-- /.col-lg-6 -->
                
                
                <?php
					}
				} 
				?>
            </div>
            <hr>
            
            
            <div class="row">
				<div class="col-sm-4 text-center">
					<h4>Foto (jpg, png)</h4>
		            <div class="kv-avatar">
		                <div class="file-loading">
		                    <input id="avatar-1" name="avatar-1" type="file" required>
		                </div>
		            </div>
		            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 6000 KB</small></div>
		            <p>Rotar la imagen <button type="button" class="btn btn-default" id="rotarIzquierda" style="margin-left:0px;">Izquierda</button></p>

		        </div>

		        <div class="col-sm-4 text-center">
					<h4>Foto del Documento del frente</h4>
		            <div class="kv-avatar">
		                <div class="file-loading">
		                    <input id="avatar-2" name="avatar-2" type="file" required>
		                </div>
		            </div>
		            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 6000 KB</small></div>

		        </div>


		        <div class="col-sm-4 text-center">
					<h4>Foto del Documento del dorso</h4>
		            <div class="kv-avatar">
		                <div class="file-loading">
		                    <input id="avatar-3" name="avatar-3" type="file" required>
		                </div>
		            </div>
		            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 6000 KB</small></div>
		        </div>

            </div>


            <div class="row">
				<div class="col-sm-4 text-center">
					<h4>Escritura (pdf)</h4>
		            <div class="kv-avatar">
		                <div class="file-loading">
		                    <input id="avatar-4" name="avatar-4" type="file" required>
		                </div>
		            </div>
		            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 30000 KB</small></div>
		        </div>

		        <div class="col-sm-4 text-center">
					<h4>Expensas (imagen o pdf)</h4>
		            <div class="kv-avatar">
		                <div class="file-loading">
		                    <input id="avatar-5" name="avatar-5" type="file" required>
		                </div>
		            </div>
		            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 30000 KB</small></div>

		        </div>


		        <div class="col-sm-4 text-center">
					<h4>Partida de Nacimiento (pdf)</h4>
		            <div class="kv-avatar">
		                <div class="file-loading">
		                    <input id="avatar-6" name="avatar-6" type="file" required>
		                </div>
		            </div>
		            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 30000 KB</small></div>

		        </div>

            </div>
            
            
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
                    <?php if ($existeDocumentacionCargada == 1) { ?>
                    <li>
                        <button type="button" class="btn btn-success" id="equipos" style="margin-left:0px;">Continuar</button>
                    </li>
                    <?php } ?>
                    <li>
                        <button type="button" class="btn btn-default" id="fichablanco" style="margin-left:0px;">Generar Ficha en Blanco</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            <input type="hidden" id="accion" name="accion" value="<?php echo $insertar; ?>"/>
            <input type="hidden" id="refjugadores" name="refjugadores" value="<?php echo $id; ?>"/>
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
            </form>
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
<script type="text/javascript" src="../../js/fileinput/fileinput.js"></script>

<script type="text/javascript">
$(document).ready(function(){

    $('#fichablanco').click(function() {
		window.open("../../reportes/rptAltaSocioBlanco.php?id=<?php echo $id; ?>" ,'_blank');
	});
	<?php
		if (mysql_num_rows($resFoto)>0) {
		$urlImg = "./../../data/".mysql_result($resFoto,0,0)."/".mysql_result($resFoto,0,'imagen');
		$direc = "./../../data/".mysql_result($resFoto,0,0);
	?>
	function rotarImagenIzquierda() {
		
		$.ajax({
			data:  {imagen: '<?php echo $urlImg; ?>', 
					rotar: 90,
					directorio: '<?php echo $direc; ?>',
					accion: 'rotarImagen'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
					url = "modificar.php?id=<?php echo $id; ?>";
					$(location).attr('href',url);
					
			}
		});
	}


	function rotarImagenDerecha() {
		
		$.ajax({
			data:  {imagen: '<?php echo $urlImg; ?>', 
					rotar: 270,
					directorio: '<?php echo $direc; ?>',
					accion: 'rotarImagen'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
					url = "modificar.php?id=<?php echo $id; ?>";
					$(location).attr('href',url);
					
			}
		});
	}

	$('#rotarIzquierda').click(function() {
		rotarImagenIzquierda();
	});
	<?php
	}
	?>


	function eliminarFoto(documentacion, jugador) {
		$.ajax({
			data:  {documentacion: documentacion, 
					jugador: jugador,
					accion: 'eliminarFotoJugadoresID'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
					alert(response);
					url = "modificar.php?id=<?php echo $id; ?>";
					$(location).attr('href',url);
					
			}
		});
	}

	var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
			    'onclick="alert(\'Call your custom code here.\')">' +
			    '<i class="glyphicon glyphicon-tag"></i>' +
			    '</button>'; 

			<?php
				if (mysql_num_rows($resFoto)>0) {
				$urlImg = "../../data/".mysql_result($resFoto,0,0)."/".mysql_result($resFoto,0,'imagen');
			?>
			$("#avatar-1").fileinput({
			    overwriteInitial: false,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' class='kv-preview-data file-preview-image' alt='Foto Perfil' title='Foto Perfil'>"
			    ],
			    initialPreviewAsData: false, // allows you to set a raw markup
    			initialPreviewFileType: 'image',
			    initialPreviewConfig: [
				    {caption: "<?php echo mysql_result($resFoto,0,'imagen'); ?>", size: 827000, width: "120px", url: '<?php echo "../../data/".mysql_result($resFoto,0,0); ?>', key: 1}
				],
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(1,<?php echo mysql_result($resResultado, 0,0); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-1").fileinput({
			    overwriteInitial: true,
			    autoOrientImage: true,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/jugador.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});
	    	<?php	
	    	}
	    	?>

	    	<?php
				if (mysql_num_rows($resFotoDocumento)>0) {
				$urlImg = "../../data/".mysql_result($resFotoDocumento,0,0)."/".mysql_result($resFotoDocumento,0,'imagen');
			?>
			$("#avatar-2").fileinput({
			    overwriteInitial: false,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' class='kv-preview-data file-preview-image' alt='Foto Documento Frente' title='Foto Documento Frente'>"
			    ],
			    initialPreviewAsData: false, // allows you to set a raw markup
    			initialPreviewFileType: 'image',
			    initialPreviewConfig: [
				    {caption: "<?php echo mysql_result($resFotoDocumento,0,'imagen'); ?>", size: 827000, width: "120px", url: '<?php echo "../../data/".mysql_result($resFotoDocumento,0,0); ?>', key: 1}
				],
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(2,<?php echo mysql_result($resResultado, 0,0); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-2").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});

	    	<?php	
	    	}
	    	?>





	    	<?php
				if (mysql_num_rows($resFotoDocumentoDorso)>0) {
				$urlImg = "../../data/".mysql_result($resFotoDocumentoDorso,0,0)."/".mysql_result($resFotoDocumentoDorso,0,'imagen');
			?>
			$("#avatar-3").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='kv-preview-data file-preview-image' alt='Foto Documento Dorso' title='Foto Documento Dorso'>",
			    ],
			    initialPreviewAsData: false, // allows you to set a raw markup
    			initialPreviewFileType: 'image',
			    initialPreviewConfig: [
				    {caption: "<?php echo mysql_result($resFotoDocumentoDorso,0,'imagen'); ?>", size: 827000, width: "120px", url: '<?php echo "../../data/".mysql_result($resFotoDocumentoDorso,0,0); ?>', key: 1}
				],
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(99,<?php echo mysql_result($resResultado, 0,0); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-3").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});

	    	<?php	
	    	}
	    	?>





	    	<?php
				if (mysql_num_rows($resTitulo)>0) {
				$urlImg = "../../data/".mysql_result($resTitulo,0,0)."/".mysql_result($resTitulo,0,'imagen');
			?>
			$("#avatar-4").fileinput({
			    overwriteInitial: false,
			    maxFileSize: 10000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-5',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf"],
			    initialPreview: [
			    	'../../data/<?php echo mysql_result($resTitulo,0,0); ?>/<?php echo mysql_result($resTitulo,0,'imagen'); ?>'
			    ],
				initialPreviewFileType: 'image',
			    initialPreviewAsData: true, // allows you to set a raw markup
			    initialPreviewConfig: [
				    {type: "pdf", size: 8000, caption: "PDF Sample", filename: "<?php echo mysql_result($resTitulo,0,'imagen'); ?>",  key: 1}
				],
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    },
			    preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
			    previewFileIconSettings: { // configure your icon file extensions
			        'doc': '<i class="fa fa-file-word-o text-primary"></i>',
			        'xls': '<i class="fa fa-file-excel-o text-success"></i>',
			        'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
			        'pdf': '<img src="../../imagenes/pdf.png">',
			        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
			        'htm': '<i class="fa fa-file-code-o text-info"></i>',
			        'txt': '<i class="fa fa-file-text-o text-info"></i>',
			        'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
			        'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
			        // note for these file types below no extension determination logic 
			        // has been configured (the keys itself will be used as extensions)
			        'jpg': '<img src="../../imagenes/sin_img.jpg">', 
			        'gif': '<i class="fa fa-file-photo-o text-muted"></i>', 
			        'png': '<img src="../../imagenes/sin_img.jpg">'    
			    },
			    previewFileExtSettings: { // configure the logic for determining icon file extensions
			        'doc': function(ext) {
			            return ext.match(/(doc|docx)$/i);
			        },
			        'xls': function(ext) {
			            return ext.match(/(xls|xlsx)$/i);
			        },
			        'ppt': function(ext) {
			            return ext.match(/(ppt|pptx)$/i);
			        },
			        'zip': function(ext) {
			            return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
			        },
			        'htm': function(ext) {
			            return ext.match(/(htm|html)$/i);
			        },
			        'txt': function(ext) {
			            return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
			        },
			        'mov': function(ext) {
			            return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
			        },
			        'mp3': function(ext) {
			            return ext.match(/(mp3|wav)$/i);
			        }
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(4,<?php echo mysql_result($resResultado, 0,0); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-4").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 30000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf"]
			});

	    	<?php	
	    	}
	    	?>



	    	<?php
				if (mysql_num_rows($resExpensa)>0) {
				$urlImg = "../../data/".mysql_result($resExpensa,0,0)."/".mysql_result($resExpensa,0,'imagen');
			?>
			$("#avatar-5").fileinput({
			    overwriteInitial: false,
			    maxFileSize: 10000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-5',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf","jpg", "png", "gif"],
			    <?php 
			    if (mysql_result($resExpensa,0,'type') == 'application/pdf') {
			    ?>
			    initialPreview: [
			    	'../../data/<?php echo mysql_result($resExpensa,0,0); ?>/<?php echo mysql_result($resExpensa,0,'imagen'); ?>'
			    ],

			    <?php
				} else {
				?>
				initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='kv-preview-data file-preview-image' alt='Desert' title='Desert'>",
			    ],
				<?php
				}
				?>
				initialPreviewFileType: 'image',
			    initialPreviewAsData: true, // allows you to set a raw markup
    			<?php 
			    if (mysql_result($resExpensa,0,'type') == 'application/pdf') {
			    ?>
			    initialPreviewConfig: [
				    {type: "pdf", size: 8000, caption: "PDF Sample", filename: "<?php echo mysql_result($resExpensa,0,'imagen'); ?>",  key: 1}
				],
			    <?php
				} else {
				?>
			    initialPreviewConfig: [
				    {caption: "<?php echo mysql_result($resExpensa,0,'imagen'); ?>", size: 827000, width: "120px", url: '<?php echo "../../data/".mysql_result($resExpensa,0,0); ?>', key: 1}
				],
				<?php
				}
				?>
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    },
			    preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
			    previewFileIconSettings: { // configure your icon file extensions
			        'doc': '<i class="fa fa-file-word-o text-primary"></i>',
			        'xls': '<i class="fa fa-file-excel-o text-success"></i>',
			        'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
			        'pdf': '<img src="../../imagenes/pdf.png">',
			        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
			        'htm': '<i class="fa fa-file-code-o text-info"></i>',
			        'txt': '<i class="fa fa-file-text-o text-info"></i>',
			        'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
			        'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
			        // note for these file types below no extension determination logic 
			        // has been configured (the keys itself will be used as extensions)
			        'jpg': '<img src="../../imagenes/sin_img.jpg">', 
			        'gif': '<i class="fa fa-file-photo-o text-muted"></i>', 
			        'png': '<img src="../../imagenes/sin_img.jpg">'    
			    },
			    previewFileExtSettings: { // configure the logic for determining icon file extensions
			        'doc': function(ext) {
			            return ext.match(/(doc|docx)$/i);
			        },
			        'xls': function(ext) {
			            return ext.match(/(xls|xlsx)$/i);
			        },
			        'ppt': function(ext) {
			            return ext.match(/(ppt|pptx)$/i);
			        },
			        'zip': function(ext) {
			            return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
			        },
			        'htm': function(ext) {
			            return ext.match(/(htm|html)$/i);
			        },
			        'txt': function(ext) {
			            return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
			        },
			        'mov': function(ext) {
			            return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
			        },
			        'mp3': function(ext) {
			            return ext.match(/(mp3|wav)$/i);
			        }
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(6,<?php echo mysql_result($resResultado, 0,0); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-5").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 10000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-5',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf","jpg", "png", "gif"]
			});

	    	<?php	
	    	}
	    	?>




	    	<?php
				if (mysql_num_rows($resPartidaNacimiento)>0) {
				$urlImg = "../../data/".mysql_result($resPartidaNacimiento,0,0)."/".mysql_result($resPartidaNacimiento,0,'imagen');
			?>
			$("#avatar-6").fileinput({
			    overwriteInitial: false,
			    maxFileSize: 10000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-5',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf","jpg", "png", "gif"],
			    <?php 
			    if (mysql_result($resPartidaNacimiento,0,'type') == 'application/pdf') {
			    ?>
			    initialPreview: [
			    	'../../data/<?php echo mysql_result($resPartidaNacimiento,0,0); ?>/<?php echo mysql_result($resPartidaNacimiento,0,'imagen'); ?>'
			    ],

			    <?php
				} else {
				?>
				initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='kv-preview-data file-preview-image' alt='Desert' title='Desert'>",
			    ],
				<?php
				}
				?>
				initialPreviewFileType: 'image',
			    initialPreviewAsData: true, // allows you to set a raw markup
    			<?php 
			    if (mysql_result($resPartidaNacimiento,0,'type') == 'application/pdf') {
			    ?>
			    initialPreviewConfig: [
				    {type: "pdf", size: 8000, caption: "PDF Sample", filename: "<?php echo mysql_result($resPartidaNacimiento,0,'imagen'); ?>",  key: 1}
				],
			    <?php
				} else {
				?>
			    initialPreviewConfig: [
				    {caption: "<?php echo mysql_result($resPartidaNacimiento,0,'imagen'); ?>", size: 827000, width: "120px", url: '<?php echo "../../data/".mysql_result($resPartidaNacimiento,0,0); ?>', key: 1}
				],
				<?php
				}
				?>
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    },
			    preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
			    previewFileIconSettings: { // configure your icon file extensions
			        'doc': '<i class="fa fa-file-word-o text-primary"></i>',
			        'xls': '<i class="fa fa-file-excel-o text-success"></i>',
			        'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
			        'pdf': '<img src="../../imagenes/pdf.png">',
			        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
			        'htm': '<i class="fa fa-file-code-o text-info"></i>',
			        'txt': '<i class="fa fa-file-text-o text-info"></i>',
			        'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
			        'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
			        // note for these file types below no extension determination logic 
			        // has been configured (the keys itself will be used as extensions)
			        'jpg': '<img src="../../imagenes/sin_img.jpg">', 
			        'gif': '<i class="fa fa-file-photo-o text-muted"></i>', 
			        'png': '<img src="../../imagenes/sin_img.jpg">'    
			    },
			    previewFileExtSettings: { // configure the logic for determining icon file extensions
			        'doc': function(ext) {
			            return ext.match(/(doc|docx)$/i);
			        },
			        'xls': function(ext) {
			            return ext.match(/(xls|xlsx)$/i);
			        },
			        'ppt': function(ext) {
			            return ext.match(/(ppt|pptx)$/i);
			        },
			        'zip': function(ext) {
			            return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
			        },
			        'htm': function(ext) {
			            return ext.match(/(htm|html)$/i);
			        },
			        'txt': function(ext) {
			            return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
			        },
			        'mov': function(ext) {
			            return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
			        },
			        'mp3': function(ext) {
			            return ext.match(/(mp3|wav)$/i);
			        }
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(9,<?php echo mysql_result($resResultado, 0,0); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-6").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 10000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-6',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf","jpg", "png"]
			});

	    	<?php	
	    	}
	    	?>

	
	$('.volver').click(function(event){
		 
		url = "modificar.php?id="+<?php echo $id; ?>;
		$(location).attr('href',url);
	});//fin del boton modificar
	
	$(document).on('click', '.panel-heading span.clickable', function(e){
		var $this = $(this);
		if(!$this.hasClass('panel-collapsed')) {
			$this.parents('.panel').find('.panel-body').slideUp();
			$this.addClass('panel-collapsed');
			$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		} else {
			$this.parents('.panel').find('.panel-body').slideDown();
			$this.removeClass('panel-collapsed');
			$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		}
	});

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
	
	$('#equipos').click(function(event){
		 
		url = "equipos.php?id="+<?php echo $id; ?>;
		$(location).attr('href',url);
	});//fin del boton equipos
	
	function traerEquiposPorCountries(id, contenedor) {
		$.ajax({
			data:  {id: id, accion: 'traerEquiposPorCountries'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
			
			},
			success:  function (response) {
				$(contenedor).html(response);
			}
		});		
	}
	
	traerEquiposPorCountries($('#refcountries').val(), '#equiposRefequipos');
	
	$('#refcountries').change(function() {
		if  ($('#equiposRefFusion').prop('checked') == false) {
			traerEquiposPorCountries($(this).val(), '#equiposRefequipos');
		}
	});
	
	
	$('#equiposRefcountries').change(function() {
		if  ($('#equiposRefFusion').prop('checked') == true) {
			traerEquiposPorCountries($(this).val(), '#equiposRefequipos');
		}
	});
	
	$('#equiposRefFusion').click(function() {
		$('#equiposRefequipos').html('');
	});
	
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
			
	
	
	$('#cargar').click(function(){
		$('#formulario').submit();		
	});
	//al enviar el formulario
    $('#cargar3').click(function(){
		
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
											//url = "documentaciones.php?id="+<?php echo $id; ?>;
											//$(location).attr('href',url);
                                            
											
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
	
	var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	
	$('#primero').addClass('collapse');

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
<script src="../../js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    
	
	
  </script>
<?php } ?>
</body>
</html>
