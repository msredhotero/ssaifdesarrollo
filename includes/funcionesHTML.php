<?php

date_default_timezone_set('America/Buenos_Aires');


class ServiciosHTML {

function menu3($usuario,$titulo,$rol,$empresa) {
	
	$sql = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' order by orden";
	$res = $this->query($sql,0);
	
	$cadmenu = "";
	$cadhover= "";
	
	$js = "<script src='../../js/jquery.maskedinput.min.js' type='text/javascript'></script>
		<link rel='stylesheet' href='../../css/jquery.sweet-dropdown.min.css' />
<script src='../../js/jquery.sweet-dropdown.min.js'></script>
		<script>
		$(document).ready(function(){
			$('#colapsarMenu').click(function() {
			if ($('#colapsarMenu').attr('class') == 'glyphicon glyphicon-list') {
			$('#content').css( { marginLeft : '1%' } );
			$('#navigation').hide();
			$('#colapsarMenu').removeClass('glyphicon glyphicon-list');
			$('#colapsarMenu').addClass('glyphicon glyphicon-align-justify');
			} else {
			$('#content').css( { marginLeft : '21%' } );
			$('#navigation').show();			
			$('#colapsarMenu').removeClass('glyphicon glyphicon-align-justify');
			$('#colapsarMenu').addClass('glyphicon glyphicon-list');
			}
			});
		});
		</script>";
		
	$cant = 1;
	/*
	<div class="dropdown-menu dropdown-anchor-top-left dropdown-has-anchor" id="dropdown-with-icons">
	<ul>
		<li><a href="#"><svg>...</svg> Item 1</a>></li>
		<li><a href="#"><svg>...</svg> Item 2</a></li>
		<li class="divider"></li>
		<li><a href="#"><svg>...</svg> Item 3</a></li>
	</ul>
</div>
	*/
	while ($row = mysql_fetch_array($res)) {
		if ($titulo == $row['nombre']) {
			$nombre = $row['nombre'];
			$row['url'] = "index.php";	
		}
		
		if (strpos($row['permiso'],$rol) !== false) {
			if ($row['idmenu'] == 1) {
				$cadmenu = $cadmenu.'<button data-dropdown="#dropdown-with-icons">'.$row['nombre'].'</button>';
				//$cadmenu = $cadmenu.'<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';
				//$cadhover = $cadhover.'</li>';	
			} else {
				$cadmenu = $cadmenu.'<button data-dropdown="#dropdown-with-icons">'.$row['nombre'].'</button>';
				//$cadmenu = $cadmenu.'<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';
				//$cadhover = $cadhover.'</li>';
			}
		}
		$cant+=1;
	}
	
	
	$menu = utf8_encode($cadmenu).'
		<div class="dropdown-menu dropdown-anchor-top-left dropdown-has-anchor" id="dropdown-with-icons">
			<ul>
				
			</ul>
		
		</div>
		<div style="background-color:#333; position:absolute; top:0;left:0; height:35px; width:100%; color:#FFF; padding-top:7px;" >
			
			<ul class="list-inline" style="margin-left:12px;">
				<li style="margin-left:20%;"><span class="glyphicon glyphicon-list" id="colapsarMenu" style="cursor:pointer;"> </span></li>
				<li class="navbar-right"><span class="glyphicon glyphicon-user"></span> '.$usuario.'</li>

			</ul>
		</div>
		 
		<div style="height:30px;">
		
		</div> 
	
		

		</div>'.$js;
	
	return $menu;
	
}


function menu($usuario,$titulo,$rol,$empresa) {

	require_once 'funcionesReferencias.php';

	$referencias	= new ServiciosReferencias();


	$lstNotificaciones = $referencias->traerNotificacionesPorUsuarios($empresa);

	$nuevas = $referencias->traerNotificacionesNoLeidaPorUsuarios($empresa);

	$cadNotificaciones = '';
	while ($row = mysql_fetch_array($lstNotificaciones)) {
		if ($row['leido'] == 'Si') {
			$cadNotificaciones .= '<li><div><a href="../'.$row['url'].'" class="list-group-item notifi" style="background-color:#D3D3D3;" id="'.$row[0].'">        <i class="'.$row['icono'].'"></i> '.substr($row['mensaje'],0,80).' - '.$row['autor'].'        <span class="pull-right text-muted small"><em>'.$row['fecha'].'</em>         </span>    </a></div></li>';
		} else {
			$cadNotificaciones .= '<li><div><a href="../'.$row['url'].'" class="list-group-item notifi" id="'.$row[0].'">        <i class="'.$row['icono'].'"></i> '.substr($row['mensaje'],0,80).' - '.$row['autor'].'        <span class="pull-right text-muted small"><em>'.$row['fecha'].'</em>         </span>    </a></div></li>';
		}

		
	}

	$cadNotificaciones .= '<li><div><a href="../notificaciones/" class="list-group-item notifi" id="0"><i class="glyphicon glyphicon-inbox"></i> VER TODAS LAS NOTIFICAIONES.</a></div></li>';
	
	$sqlGrupo1 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 1 order by orden";
	$resGrupo1 = $this->query($sqlGrupo1,0);
	$cad1 = '';
	while ($row = mysql_fetch_array($resGrupo1)) {
		$cad1 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo2 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 2 order by orden";
	$resGrupo2 = $this->query($sqlGrupo2,0);
	$cad2 = '';
	while ($row = mysql_fetch_array($resGrupo2)) {
		$cad2 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo3 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 3 order by orden";
	$resGrupo3 = $this->query($sqlGrupo3,0);
	$cad3 = '';
	while ($row = mysql_fetch_array($resGrupo3)) {
		$cad3 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo4 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 4 order by orden";
	$resGrupo4 = $this->query($sqlGrupo4,0);
	$cad4 = '';
	while ($row = mysql_fetch_array($resGrupo4)) {
		$cad4 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo5 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 5 order by orden";
	$resGrupo5 = $this->query($sqlGrupo5,0);
	$cad5 = '';
	while ($row = mysql_fetch_array($resGrupo5)) {
		$cad5 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo6 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 6 order by orden";
	$resGrupo6 = $this->query($sqlGrupo6,0);
	$cad6 = '';
	while ($row = mysql_fetch_array($resGrupo6)) {
		$cad6 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo7 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 7 order by orden";
	$resGrupo7 = $this->query($sqlGrupo7,0);
	$cad7 = '';
	while ($row = mysql_fetch_array($resGrupo7)) {
		$cad7 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	
	$cad = '<script src="../../js/jquery.maskedinput.min.js" type="text/javascript"></script><nav class="navbar navbar-default">
			  <div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="#">AIF</a>
				</div>
			
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav">
					<li class="active"><a href="../index.php">Dashboard <span class="sr-only">(current)</span></a></li>
					'.$cad1.'
					'.$cad2.'
					'.$cad3.'
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">TORNEO <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						'.$cad4.'
					  </ul>
					</li>
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">TRIBUNAL <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						'.$cad5.'
					  </ul>
					</li>
					'.$cad6.'
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">General <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						'.$cad7.'
					  </ul>
					</li>
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell"></span> Notificaciones <span class="label label-danger">'.$nuevas.'</span><span class="caret"></span></a>
					  <ul class="dropdown-menu dropdown-alerts notificaciones">
						
					  </ul>
					</li>
					<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$usuario.'</a></li>
					<li><a href="../../logout.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
				  </ul>
				  
				</div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
			<script type="text/javascript">';
			$cad .= "$(document).ready(function(){
				
				function notificacionLeida(id) {
					$.ajax({
						data:  {id: id, accion: 'marcarNotificacion'},
						url:   '****/ajax/ajax.php',
						type:  'post',
						beforeSend: function () {
								
						},
						success:  function (response) {
								//url = 'index.php';
								//$(location).attr('href',url);
								
						}
					});
				}

				$(document).on('click','.notifi', function(){
					usersid =  $(this).attr('id');
					notificacionLeida(usersid);
				});
				$('.notificaciones').append('".$cadNotificaciones."');
			});
			</script>";	
			
			
				
	return $cad;
}

function menuD($usuario,$titulo,$rol,$empresa) {

	require_once 'funcionesReferencias.php';

	$referencias	= new ServiciosReferencias();


	$lstNotificaciones = $referencias->traerNotificacionesPorUsuarios($empresa);

	$nuevas = $referencias->traerNotificacionesNoLeidaPorUsuarios($empresa);

	$cadNotificaciones = '';
	while ($row = mysql_fetch_array($lstNotificaciones)) {
		if ($row['leido'] == 'Si') {
			$cadNotificaciones .= '<li><div><a href="'.$row['url'].'" class="list-group-item notifi" style="background-color:#D3D3D3;" id="'.$row[0].'">        <i class="'.$row['icono'].'"></i> '.substr($row['mensaje'],0,80).' - '.$row['autor'].'        <span class="pull-right text-muted small"><em>'.$row['fecha'].'</em>         </span>    </a></div></li>';
		} else {
			$cadNotificaciones .= '<li><div><a href="'.$row['url'].'" class="list-group-item notifi" id="'.$row[0].'">        <i class="'.$row['icono'].'"></i> '.substr($row['mensaje'],0,80).' - '.$row['autor'].'        <span class="pull-right text-muted small"><em>'.$row['fecha'].'</em>         </span>    </a></div></li>';
		}

		
	}

	$cadNotificaciones .= '<li><div><a href="../notificaciones/" class="list-group-item notifi" id="0"><i class="glyphicon glyphicon-inbox"></i> VER TODAS LAS NOTIFICAIONES.</a></div></li>';
	
	
	$sqlGrupo1 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 1 order by orden";
	$resGrupo1 = $this->query($sqlGrupo1,0);
	$cad1 = '';
	while ($row = mysql_fetch_array($resGrupo1)) {
		$cad1 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo2 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 2 order by orden";
	$resGrupo2 = $this->query($sqlGrupo2,0);
	$cad2 = '';
	while ($row = mysql_fetch_array($resGrupo2)) {
		$cad2 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo3 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 3 order by orden";
	$resGrupo3 = $this->query($sqlGrupo3,0);
	$cad3 = '';
	while ($row = mysql_fetch_array($resGrupo3)) {
		$cad3 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo4 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 4 order by orden";
	$resGrupo4 = $this->query($sqlGrupo4,0);
	$cad4 = '';
	while ($row = mysql_fetch_array($resGrupo4)) {
		$cad4 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo5 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 5 order by orden";
	$resGrupo5 = $this->query($sqlGrupo5,0);
	$cad5 = '';
	while ($row = mysql_fetch_array($resGrupo5)) {
		$cad5 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo6 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 6 order by orden";
	$resGrupo6 = $this->query($sqlGrupo6,0);
	$cad6 = '';
	while ($row = mysql_fetch_array($resGrupo6)) {
		$cad6 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$sqlGrupo7 = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and grupo = 7 order by orden";
	$resGrupo7 = $this->query($sqlGrupo7,0);
	$cad7 = '';
	while ($row = mysql_fetch_array($resGrupo7)) {
		$cad7 .= '<li><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';	
	}
	
	$cad = '<form role="form"><nav class="navbar navbar-default">
			  <div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="#">AIF</a>
				</div>
			
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav">
					<li class="active"><a href="../index.php">Dashboard <span class="sr-only">(current)</span></a></li>
					'.$cad1.'
					'.$cad2.'
					'.$cad3.'
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">TORNEO <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						'.$cad4.'
					  </ul>
					</li>
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">TRIBUNAL <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						'.$cad5.'
					  </ul>
					</li>
					'.$cad6.'
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">General <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						'.$cad7.'
					  </ul>
					</li>
					
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell"></span> Notificaciones <span class="label label-danger">'.$nuevas.'</span><span class="caret"></span></a>
					  <ul class="dropdown-menu dropdown-alerts notificaciones">
						
					  </ul>
					</li>

					<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$usuario.'</a></li>
					<li><a href="../logout.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
				  </ul>
				  
				</div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
			</form>
			<script type="text/javascript">';
			$cad .= "$(document).ready(function(){
				
				function notificacionLeida(id) {
					$.ajax({
						data:  {id: id, accion: 'marcarNotificacion'},
						url:   '****/ajax/ajax.php',
						type:  'post',
						beforeSend: function () {
								
						},
						success:  function (response) {
								//url = 'index.php';
								//$(location).attr('href',url);
								
						}
					});
				}

				$(document).on('click','.notifi', function(){
					usersid =  $(this).attr('id');
					notificacionLeida(usersid);
				});
				$('.notificaciones').append('".$cadNotificaciones."');
			});
			</script>";	
	return $cad;
}

function menu2($usuario,$titulo,$rol,$empresa) {
	
	$sql = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' order by orden";
	$res = $this->query($sql,0);
	
	$cadmenu = "";
	$cadhover= "";
	
	$js = "<script src='../../js/jquery.maskedinput.min.js' type='text/javascript'></script>
		<link rel='stylesheet' href='sweet-dropdown/dist/min/jquery.sweet-dropdown.min.css' />
<script src='sweet-dropdown/dist/min/jquery.sweet-dropdown.min.js'></script>
		<script>
		$(document).ready(function(){
			$('#colapsarMenu').click(function() {
			if ($('#colapsarMenu').attr('class') == 'glyphicon glyphicon-list') {
			$('#content').css( { marginLeft : '1%' } );
			$('#navigation').hide();
			$('#colapsarMenu').removeClass('glyphicon glyphicon-list');
			$('#colapsarMenu').addClass('glyphicon glyphicon-align-justify');
			} else {
			$('#content').css( { marginLeft : '21%' } );
			$('#navigation').show();			
			$('#colapsarMenu').removeClass('glyphicon glyphicon-align-justify');
			$('#colapsarMenu').addClass('glyphicon glyphicon-list');
			}
			});
		});
		</script>";
		
	$cant = 1;
	/*
	<div class="dropdown-menu dropdown-anchor-top-left dropdown-has-anchor" id="dropdown-with-icons">
	<ul>
		<li><a href="#"><svg>...</svg> Item 1</a>></li>
		<li><a href="#"><svg>...</svg> Item 2</a></li>
		<li class="divider"></li>
		<li><a href="#"><svg>...</svg> Item 3</a></li>
	</ul>
</div>
	*/
	while ($row = mysql_fetch_array($res)) {
		if ($titulo == $row['nombre']) {
			$nombre = $row['nombre'];
			$row['url'] = "index.php";	
		}
		
		if (strpos($row['permiso'],$rol) !== false) {
			if ($row['idmenu'] == 1) {
				$cadmenu = $cadmenu.'<li class="arriba"><div class="'.$row['icono'].'"></div><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';
				$cadhover = $cadhover.' <li class="arriba">
											<div class="'.$row['icono'].'2" id="tooltip'.$cant.'"></div>
											<div class="tooltip-dash">'.$row['nombre'].'</div>
										</li>';	
			} else {
				$cadmenu = $cadmenu.'<li><div class="'.$row['icono'].'"></div><a href="'.$row['url'].'">'.$row['nombre'].'</a></li>';
				$cadhover = $cadhover.'  <li>
											<div class="'.$row['icono'].'2" id="tooltip'.$cant.'"></div>
											<div class="tooltip-con">'.$row['nombre'].'</div>
										</li>';
			}
		}
		$cant+=1;
	}
	
	
	$menu = '
		<div style="background-color:#333; position:absolute; top:0;left:0; height:35px; width:100%; color:#FFF; padding-top:7px;" >
			
			<ul class="list-inline" style="margin-left:12px;">
				<li style="margin-left:20%;"><span class="glyphicon glyphicon-list" id="colapsarMenu" style="cursor:pointer;"> </span></li>
				<li class="navbar-right"><span class="glyphicon glyphicon-user"></span> '.$usuario.'</li>

			</ul>
		</div>
		 
		<div style="height:30px;">
		
		</div> 
	
		<div id="navigation" >
				<nav class="nav">
					<ul>
						'.utf8_encode($cadmenu).'
					</ul>
				</nav>
				
				
			 </div>

		</div>'.$js;
	
	return $menu;
	
}



function validacion($tabla) {
	$sql	=	"show columns from ".$tabla;
	$res 	=	$this->query($sql,0);
	
	$formJquery = '';
	$formValidador = '';
	
	$links = '$(".ver").click(function(event){
			url = "ver.php";
			$(location).attr("href",url);
	});//fin del boton eliminar
	
	$(".varborrar").click(function(event){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			$("#idEliminar").val(usersid);
			$("#dialog2").dialog("open");
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton eliminar
	
	$(".varmodificar").click(function(event){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			url = "modificar.php?id=" + usersid;
			$(location).attr("href",url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar';
	
	if ($res == false) {
		return 'Error al traer datos';
	} else {
		
		$jquery	=	'';
		$cuerpoValidacion = '';
		
		while ($row = mysql_fetch_array($res)) {
			if (($row[3] != 'PRI') && ($row[2] == 'NO')) {
				if (strpos($row[1],"decimal") !== false) {
					//debo validar que sea un numero
					
					$jquery	=	$jquery.'
					
					$("#'.$row[0].'").click(function(event) {
						$("#'.$row[0].'").removeClass("alert-danger");
						if ($(this).val() == "") {
							$("#'.$row[0].'").attr("value","");
							$("#'.$row[0].'").attr("placeholder","Ingrese el '.ucwords($row[0]).'...");
						}
					});
				
					$("#'.$row[0].'").change(function(event) {
						$("#'.$row[0].'").removeClass("alert-danger");
						$("#'.$row[0].'").attr("placeholder","Ingrese el '.ucwords($row[0]).'");
					});
					
					';
					
					$cuerpoValidacion = $cuerpoValidacion.'
					
						if ($("#'.$row[0].'").val() == "") {
							$error = "Es obligatorio el campo '.ucwords($row[0]).'.";
							$("#'.$row[0].'").addClass("alert-danger");
							$("#'.$row[0].'").attr("placeholder",$error);
						}
					
					';
					
					
				} else {
					if ($row[0] == "refroll") {
						$label = "Rol";
						$campo = $row[0];
						
						$jquery	=	$jquery.'
					
						$("#'.$campo.'").click(function(event) {
							$("#'.$campo.'").removeClass("alert-danger");
							if ($(this).val() == "") {
								$("#'.$campo.'").attr("value","");
								$("#'.$campo.'").attr("placeholder","Ingrese el '.$label.'...");
							}
						});
					
						$("#'.$campo.'").change(function(event) {
							$("#'.$campo.'").removeClass("alert-danger");
							$("#'.$campo.'").attr("placeholder","Ingrese el '.$label.'");
						});
						
						';
						
						
						$cuerpoValidacion = $cuerpoValidacion.'
					
							if ($("#'.$campo.'").val() == "") {
								$error = "Es obligatorio el campo '.$label.'.";
								$("#'.$campo.'").addClass("alert-danger");
								$("#'.$campo.'").attr("placeholder",$error);
							}
						
						';
						
					} else {
						$label = ucwords($row[0]);
						$campo = $row[0];
						
						$jquery	=	$jquery.'
					
						$("#'.$campo.'").click(function(event) {
							$("#'.$campo.'").removeClass("alert-danger");
							if ($(this).val() == "") {
								$("#'.$campo.'").attr("value","");
								$("#'.$campo.'").attr("placeholder","Ingrese el '.$label.'...");
							}
						});
					
						$("#'.$campo.'").change(function(event) {
							$("#'.$campo.'").removeClass("alert-danger");
							$("#'.$campo.'").attr("placeholder","Ingrese el '.$label.'");
						});
						
						';
						
						
						$cuerpoValidacion = $cuerpoValidacion.'
					
							if ($("#'.$campo.'").val() == "") {
								$error = "Es obligatorio el campo '.$label.'.";
								$("#'.$campo.'").addClass("alert-danger");
								$("#'.$campo.'").attr("placeholder",$error);
							}
						
						';
					}
					
					
				}
			}
		}
		
		$formJquery = $formJquery.$jquery;
		
		$formValidador = $formValidador.'
			function validador(){

					$error = "";
					'.$cuerpoValidacion.'
					return $error;
			}
		';
		
		return $links.$formJquery.$formValidador;
	}	
}


function footer() {
	echo "<!--comienzo del footer-->
<div id='footer'>
<div id='dentroFooter'>
<div align='center'>
<table width='800'>
<tr valign='top'>
<td align='left'>
<h4>Link's de interes</h4>
<ul>
<li><a href='http://www.grandt.clarin.com/'>Gran DT</a></li>
<li><a href='http://www.ole.com.ar/'>OLE</a></li>
<li><a href='http://www.foxsportsla.com/ar/'>Fox Sport</a></li>
<li><a href='http://www.afa.org.ar/'>AFA</a></li>
</ul>
</td>
<td align='left'>
<h4>Noticias</h4>
<ul>
<li><a href='http://www.eldia.com.ar/'>El Dia</a></li>
<li><a href='http://www.clarin.com/'>Clarin</a></li>
<li><a href='http://diariohoy.net/'>Hoy</a></li>
<li><a href='http://www.lanacion.com.ar/'>La Nación</a></li>
</ul>
</td>
<td align='left'>
<h4>Recursos</h4>
<ul>
<li><a href='http://www.hotmail.com/'>Hotmail</a></li>
<li><a href='http://ar.yahoo.com/'>Yahoo</a></li>
<li><a href='http://www.google.com.ar/'>Google</a></li>

</ul>
</td>
</tr>
</table>
</div>
</div>

   <div id='yo' align='center'>
   <br />
<p>© Copyright 2013 | ComplejoShowBol - La PLata, Buenos Aires. Diseño Web: Saupurein Marcos y Saupurein Javier .Tel:(0221)15-6184415</p>
</div>
</div><!--fin del footer-->";
}

	function query($sql,$accion) {
		
		require_once 'appconfig.php';

		$appconfig	= new appconfig();
		$datos		= $appconfig->conexion();
		$hostname	= $datos['hostname'];
		$database	= $datos['database'];
		$username	= $datos['username'];
		$password	= $datos['password'];
		
/*		$hostname = "localhost";
		$database = "lacalder_diablo";
		$username = "lacalderadeldiab";
		$password = "caldera4415";
		*/
		
		$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());
		
		mysql_select_db($database);
		
		$result = mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		mysql_close($conex);
		return $result;
		
	}

}

?>