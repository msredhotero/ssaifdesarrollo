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
$valorB = 'marcos';
//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Fixture",$_SESSION['refroll_predio'],'');

$idFixture = $_POST['idfixture'];
//die(var_dump($idFixture));
$resFix = $serviciosReferencias->TraerFixturePorId($idFixture);


$equipoLocal		=	mysql_result($resFix,0,'refconectorlocal');
$equipoVisitante	=	mysql_result($resFix,0,'refconectorvisitante');

$refFecha = mysql_result($resFix,0,'reffechas');
$refJugo = mysql_result($resFix,0,'fecha');
$resultadoA = mysql_result($resFix,0,'puntoslocal');
$resultadoB = mysql_result($resFix,0,'puntosvisita');

$equipoA = mysql_result($serviciosReferencias->traerEquiposPorId($equipoLocal),0,'nombre');
$equipoB = mysql_result($serviciosReferencias->traerEquiposPorId($equipoVisitante),0,'nombre');

$resTorneo	=	$serviciosReferencias->traerTorneosPorId(mysql_result($resFix,0,'reftorneos'));
$idTorneo = (integer)mysql_result($resTorneo,0,'idtorneo');
$idCategoria	=	mysql_result($resTorneo,0,'refcategorias');
$idDivisiones	=	mysql_result($resTorneo,0,'refdivisiones');

///////////////   traigo la utima temporada  ///////////////////
$refTemporada = $serviciosReferencias->traerUltimaTemporada();

if (mysql_num_rows($refTemporada)>0) {
	$idTemporada = mysql_result($refTemporada,0,0);	
} else {
	$idTemporada = 0;
}
////////////////// fin  ////////////////////////////////////////

/////////////		traigo los minutos del partido   ////////////////
$resDefCategTemp		=	$serviciosReferencias->traerDefinicionescategoriastemporadasPorTemporadaCategoria($idTemporada, $idCategoria);

$minutos				=	mysql_result($resDefCategTemp,0,'minutospartido');
/////////////			fin				/////////////////////////////

$error = '';
$lblerror = '';


$serviciosReferencias->modificarFixturePorCancha($idFixture, $_POST['refcanchas']);

$numero = count($_POST);
	$tags = array_keys($_POST);// obtiene los nombres de las varibles
	$valores = array_values($_POST);// obtiene los valores de las varibles
	$cantEncontrados = 0;
	$cantidad = 1;
	$idEquipos = 0;
	
	$cadWhere = '';
	$cantEquipos = array();
	
	$golesRealesLocal 		= 0;
	$golesRealesVisitantes	= 0;
	
	for($i=0;$i<$numero;$i++){
		
		
		/////////////////////			EQUIPO LOCAL				////////////////////////////////////////////////
		if (strpos($tags[$i],"goles") !== false) {

			$idJugador = str_replace("goles","",$tags[$i]);

			//////////////		logica GOLEADORES		///////////////////////////////////////////////////////
			$existeGoleadores = $serviciosReferencias->existeFixturePorGoleadores($idJugador, $idFixture);
			
			$golesRealesLocal += $valores[$i];
			$golesRealesVisitantes += $_POST['encontra'.$idJugador];
			
			if ($existeGoleadores == 0) {
				//inserto
				$serviciosReferencias->insertarGoleadores($idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones,$valores[$i], $_POST['encontra'.$idJugador]);
			} else {
				//modifico	
				
				$serviciosReferencias->modificarGoleadores($existeGoleadores, $idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones,$valores[$i], $_POST['encontra'.$idJugador]);
			}
			//////////////			fin logica			/////////////////////////////////////////////////////////
			
			
			//////////////		logica PENALES		///////////////////////////////////////////////////////
			$existePenales = $serviciosReferencias->existeFixturePorPenalesJugador($idJugador, $idFixture);
			
			$golesRealesLocal += $_POST['penalesconvertidos'.$idJugador];
			
			if ($existePenales == 0) {
				//inserto
				$serviciosReferencias->insertarPenalesjugadores($idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones,$_POST['penalesconvertidos'.$idJugador], $_POST['penaleserrados'.$idJugador], $_POST['penalesatajados'.$idJugador]);
			} else {
				//modifico	
				
				$serviciosReferencias->modificarPenalesjugadores($existePenales, $idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones,$_POST['penalesconvertidos'.$idJugador], $_POST['penaleserrados'.$idJugador], $_POST['penalesatajados'.$idJugador]);
			}
			//////////////			fin logica			/////////////////////////////////////////////////////////
			
			//////////////		logica MINUTOS		///////////////////////////////////////////////////////
			$existeMinutos = $serviciosReferencias->existeFixturePorMinutosJugados($idJugador, $idFixture);
			
			if ($existeMinutos == 0) {
				//inserto
				$serviciosReferencias->insertarMinutosjugados($idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones, $_POST['minutos'.$idJugador]);
			} else {
				//modifico	
				
				$serviciosReferencias->modificarMinutosjugados($existeMinutos, $idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones,$_POST['minutos'.$idJugador]);
			}
			//////////////			fin logica			/////////////////////////////////////////////////////////
			
			
			//////////////  mejor jugador //////////////
			// siempre lo borro a lo primero
			$serviciosReferencias->eliminarMejorjugadorPorJugadorFixture($idJugador, $idFixture);
			if (isset($_POST['mejorjugador'.$idJugador])) {
				
				$serviciosReferencias->insertarMejorjugador($idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones);
			}
			/////////////		FIN MEJOR JUGADOR		/////////////////////////////////////////////////////////
			
			
			
			/***********		AMARILLAS			*************************************************************/
			$existeAmarillas	=	$serviciosReferencias->existeFixturePorSanciones($idJugador,1,$idFixture);
			if ($_POST['amaLrillas'.$idJugador] > 0) {
				if ($existeAmarillas == 0) {
					//inserto
					$idsancion = $serviciosReferencias->insertarSancionesjugadores(1,$idJugador, $equipoLocal, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['amaLrillas'.$idJugador], $idCategoria, $idDivisiones, 'NULL');
					
					//*****			calculo amarillas acumuladas ********/
					$cantidadAmarillas = $serviciosReferencias->traerAmarillasAcumuladas($idTorneo, $idJugador, $refFecha);
					//die(var_dump($cantidadAmarillas.'jugador:'.$idJugador));
					$acuAmarillasA = $serviciosReferencias->sancionarPorAmarillasAcumuladas($idTorneo, $idJugador, $refFecha, $idFixture, $equipoLocal, $fecha, $idCategoria, $idDivisiones, $idsancion, $cantidadAmarillas);
					//*****				fin							*****/
					
				} else {
					//modifico	
					
					$serviciosReferencias->modificarSancionesjugadoresSinAlterarFallo($existeAmarillas,1,$idJugador, $equipoLocal, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['amaLrillas'.$idJugador], $idCategoria, $idDivisiones);
				}
			} else {
				
				//analizo si en un supuesto caso anteriormente tenia una amarilla
				if ($existeAmarillas != 0) {
					$serviciosReferencias->eliminarMovimientosancionesPorSancionJugadorAcumuadasAmarillas($existeAmarillas);
					$serviciosReferencias->eliminarSancionesfallosPorSacionJugador($existeAmarillas);
					$serviciosReferencias->eliminarSancionesjugadores($existeAmarillas);
				}
			}
			
			/***********		FIN					*************************************************************/



			/***********		ROJAS			*************************************************************/
			$existeRojas	=	$serviciosReferencias->existeFixturePorSanciones($idJugador,2,$idFixture);
			if ($_POST['roLjas'.$idJugador] > 0) {
				if ($existeRojas == 0) {
					//inserto
					$idsancion = $serviciosReferencias->insertarSancionesjugadores(2,$idJugador, $equipoLocal, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['roLjas'.$idJugador], $idCategoria, $idDivisiones, 'NULL');
					
				} else {
					//modifico	
					
					$serviciosReferencias->modificarSancionesjugadoresSinAlterarFallo($existeRojas,2,$idJugador, $equipoLocal, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['roLjas'.$idJugador], $idCategoria, $idDivisiones);
				}
			}
			/***********		FIN					*************************************************************/



			/***********		INFORMADOS			*************************************************************/
			$existeInformados	=	$serviciosReferencias->existeFixturePorSanciones($idJugador,3,$idFixture);
			
			if ($_POST['inforLmados'.$idJugador] > 0) {
				if ($existeInformados == 0) {
					//inserto
					$idsancion = $serviciosReferencias->insertarSancionesjugadores(3,$idJugador, $equipoLocal, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['inforLmados'.$idJugador], $idCategoria, $idDivisiones, 'NULL');
					
				} else {
					//modifico	
					
					$serviciosReferencias->modificarSancionesjugadoresSinAlterarFallo($existeInformados,3,$idJugador, $equipoLocal, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['inforLmados'.$idJugador], $idCategoria, $idDivisiones);
				}
			}
			/***********		FIN					*************************************************************/
		


			/***********		DOBLE AMARILLAS			*************************************************************/
			$existeDobleAmarillas	=	$serviciosReferencias->existeFixturePorSanciones($idJugador,4,$idFixture);
			if ($_POST['dobleLamarilla'.$idJugador] > 0) {
				if ($existeDobleAmarillas == 0) {
					//inserto
					$idsancion = $serviciosReferencias->insertarSancionesjugadores(4,$idJugador, $equipoLocal, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['dobleLamarilla'.$idJugador], $idCategoria, $idDivisiones, 'NULL');
					
				} else {
					//modifico	
					
					$serviciosReferencias->modificarSancionesjugadoresSinAlterarFallo($existeDobleAmarillas,4,$idJugador, $equipoLocal, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['dobleLamarilla'.$idJugador], $idCategoria, $idDivisiones);
				}
			}
			/***********		FIN					*************************************************************/



			/***********		CD TD			*************************************************************/
			$existeCDTD	=	$serviciosReferencias->existeFixturePorSanciones($idJugador,5,$idFixture);
			
			if ($_POST['cdLtd'.$idJugador] > 0) {
				if ($existeCDTD == 0) {
					//inserto
					$idsancion = $serviciosReferencias->insertarSancionesjugadores(5,$idJugador, $equipoLocal, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['cdLtd'.$idJugador], $idCategoria, $idDivisiones, 'NULL');
					
				} else {
					//modifico	
					
					$serviciosReferencias->modificarSancionesjugadoresSinAlterarFallo($existeCDTD,5,$idJugador, $equipoLocal, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['cdLtd'.$idJugador], $idCategoria, $idDivisiones);
				}
			}
			/***********		FIN					*************************************************************/

		}
		
		
		
		////********************		FIN EQUIPO LOCAL		*************************************************//////
		
		
		
		/////////////////////			EQUIPO VISITANTE				////////////////////////////////////////////////
		if (strpos($tags[$i],"gobles") !== false) {
			
			if (isset($valores[$i])) {
				
				$idJugador = str_replace("gobles","",$tags[$i]);
				
				$golesRealesLocal += $_POST['enbcontra'.$idJugador];
				$golesRealesVisitantes += $valores[$i];
				//////////////		logica GOLEADORES		///////////////////////////////////////////////////////
				$existeGoleadores = $serviciosReferencias->existeFixturePorGoleadores($idJugador, $idFixture);
				
				if ($existeGoleadores == 0) {
					//inserto
					$serviciosReferencias->insertarGoleadores($idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones,$valores[$i], $_POST['enbcontra'.$idJugador]);
				} else {
					//modifico	
					
					$serviciosReferencias->modificarGoleadores($existeGoleadores, $idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones,$valores[$i], $_POST['enbcontra'.$idJugador]);
				}
				//////////////			fin logica			/////////////////////////////////////////////////////////
				
				
				//////////////		logica PENALES		///////////////////////////////////////////////////////
				$existePenales = $serviciosReferencias->existeFixturePorPenalesJugador($idJugador, $idFixture);
				
				$golesRealesVisitantes += $_POST['penalesbconvertidos'.$idJugador];
				
				if ($existePenales == 0) {
					//inserto
					$serviciosReferencias->insertarPenalesjugadores($idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones,$_POST['penalesbconvertidos'.$idJugador], $_POST['penalesberrados'.$idJugador], $_POST['penalesbatajados'.$idJugador]);
				} else {
					//modifico	
					
					$serviciosReferencias->modificarPenalesjugadores($existePenales, $idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones,$_POST['penalesbconvertidos'.$idJugador], $_POST['penalesberrados'.$idJugador], $_POST['penalesbatajados'.$idJugador]);
				}
				//////////////			fin logica			/////////////////////////////////////////////////////////
				
				
				//////////////		logica MINUTOS		///////////////////////////////////////////////////////
				$existeMinutos = $serviciosReferencias->existeFixturePorMinutosJugados($idJugador, $idFixture);
				
				if ($existeMinutos == 0) {
					//inserto
					$serviciosReferencias->insertarMinutosjugados($idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones, $_POST['minbutos'.$idJugador]);
				} else {
					//modifico	
					
					$serviciosReferencias->modificarMinutosjugados($existeMinutos, $idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones,$_POST['minbutos'.$idJugador]);
				}
				//////////////			fin logica			/////////////////////////////////////////////////////////
				
				
				//////////////  mejor jugador //////////////
				// siempre lo borro a lo primero
				$serviciosReferencias->eliminarMejorjugadorPorJugadorFixture($idJugador, $idFixture);
				if (isset($_POST['mejorbjugador'.$idJugador])) {
					
					$serviciosReferencias->insertarMejorjugador($idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones);
				}
				
				/**************  fin 			**********************************************************************/
				
			/***********		AMARILLAS			*************************************************************/
			
			$existeAmarillas	=	$serviciosReferencias->existeFixturePorSanciones($idJugador,1,$idFixture);
			
			if ($_POST['amaVrillas'.$idJugador] > 0) {
				if ($existeAmarillas == 0) {
					//inserto
					$idsancion = $serviciosReferencias->insertarSancionesjugadores(1,$idJugador, $equipoVisitante, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['amaVrillas'.$idJugador], $idCategoria, $idDivisiones, 'NULL');
					
					//*****			calculo amarillas acumuladas ********/
					//$serviciosReferencias->ultimaFechaSancionadoPorAcumulacionAmarillas((integer)$idTorneo, $idJugador);
					$cantidadAmarillasB = $serviciosReferencias->traerAmarillasAcumuladas($idTorneo, $idJugador, $refFecha);
					//die(var_dump($cantidadAmarillasB));
					$acuAmarillasB = $serviciosReferencias->sancionarPorAmarillasAcumuladas($idTorneo, $idJugador, $refFecha, $idFixture, $equipoVisitante, $fecha, $idCategoria, $idDivisiones, $idsancion,$cantidadAmarillasB);
					//*****				fin							*****/
					
				} else {
					//modifico	
					
					$serviciosReferencias->modificarSancionesjugadoresSinAlterarFallo($existeAmarillas,1,$idJugador, $equipoVisitante, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['amaVrillas'.$idJugador], $idCategoria, $idDivisiones);
				}
			} else {
				//analizo si en un supuesto caso anteriormente tenia una amarilla
				if ($existeAmarillas != 0) {
					$serviciosReferencias->eliminarMovimientosancionesPorSancionJugadorAcumuadasAmarillas($existeAmarillas);
					$serviciosReferencias->eliminarSancionesfallosPorSacionJugador($existeAmarillas);
					$serviciosReferencias->eliminarSancionesjugadores($existeAmarillas);
				}	
			}
			/***********		FIN					*************************************************************/



			/***********		ROJAS			*************************************************************/
			$existeRojas	=	$serviciosReferencias->existeFixturePorSanciones($idJugador,2,$idFixture);
			
			if ($_POST['roVjas'.$idJugador] > 0) {
				if ($existeRojas == 0) {
					//inserto
					$idsancion = $serviciosReferencias->insertarSancionesjugadores(2,$idJugador, $equipoVisitante, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['roVjas'.$idJugador], $idCategoria, $idDivisiones, 'NULL');
					
				} else {
					//modifico	
					
					$serviciosReferencias->modificarSancionesjugadoresSinAlterarFallo($existeRojas,2,$idJugador, $equipoVisitante, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['roVjas'.$idJugador], $idCategoria, $idDivisiones);
				}
			}
			/***********		FIN					*************************************************************/



			/***********		INFORMADOS			*************************************************************/
			$existeInformados	=	$serviciosReferencias->existeFixturePorSanciones($idJugador,3,$idFixture);
			
			if ($_POST['inforVmados'.$idJugador] > 0) {
				if ($existeInformados == 0) {
					//inserto
					$idsancion = $serviciosReferencias->insertarSancionesjugadores(3,$idJugador, $equipoVisitante, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['inforVmados'.$idJugador], $idCategoria, $idDivisiones, 'NULL');
					
				} else {
					//modifico	
					
					$serviciosReferencias->modificarSancionesjugadoresSinAlterarFallo($existeInformados,3,$idJugador, $equipoVisitante, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['inforVmados'.$idJugador], $idCategoria, $idDivisiones);
				}
			}
			/***********		FIN					*************************************************************/
		


			/***********		DOBLE AMARILLAS			*************************************************************/
			$existeDobleAmarillas	=	$serviciosReferencias->existeFixturePorSanciones($idJugador,4,$idFixture);
			
			if ($_POST['dobleVamarilla'.$idJugador] > 0) {
				if ($existeDobleAmarillas == 0) {
					//inserto
					$idsancion = $serviciosReferencias->insertarSancionesjugadores(4,$idJugador, $equipoVisitante, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['dobleVamarilla'.$idJugador], $idCategoria, $idDivisiones, 'NULL');
					
				} else {
					//modifico	
					
					$serviciosReferencias->modificarSancionesjugadoresSinAlterarFallo($existeDobleAmarillas,4,$idJugador, $equipoVisitante, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['dobleVamarilla'.$idJugador], $idCategoria, $idDivisiones);
				}
			}
			/***********		FIN					*************************************************************/



			/***********		CD TD			*************************************************************/
			$existeCDTD	=	$serviciosReferencias->existeFixturePorSanciones($idJugador,5,$idFixture);
			
			if ($_POST['cdVtd'.$idJugador] > 0) {
				if ($existeCDTD == 0) {
					//inserto
					$idsancion = $serviciosReferencias->insertarSancionesjugadores(5,$idJugador, $equipoVisitante, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['cdVtd'.$idJugador], $idCategoria, $idDivisiones, 'NULL');
					
				} else {
					//modifico	
					
					$serviciosReferencias->modificarSancionesjugadoresSinAlterarFallo($existeCDTD,5,$idJugador, $equipoVisitante, $idFixture, mysql_result($resFix,0,'fecha'),$_POST['cdVtd'.$idJugador], $idCategoria, $idDivisiones);
				}
			}
			/***********		FIN					*************************************************************/

			}
		}
		
		
		
		////********************		FIN EQUIPO VISITANTE		*************************************************//////
		
	}



///////////////////////  CALCULA SEGUN EL ESTADO DEL PARTIDO	////////////////////////////
$refEstadoPartido		=		$_POST['refestadospartidos'];

//calculo
$defAutomatica			= 0;

$golesLocalAuto			= 0;
$golesLocalBorra		= 0;

$golesvisitanteauto		= 0;
$golesvisitanteborra	= 0;

$puntosLocal			= 0;
$puntosVisitante		= 0;

$finalizado				= 0;

$ocultaDetallePublico	= 0;

$visibleParaArbitros	= 0;

$contabilizaLocal		= 0;
$contabilizaVisitante	= 0;

//variable para determinar si el partido va a continuar
$partidoSuspendidoCompletamente = 0;

if	($refEstadoPartido != 0) {
	

	$estadoPartido	=	$serviciosReferencias->traerEstadospartidosPorId($refEstadoPartido);
	
	$defAutomatica			= mysql_result($estadoPartido,0,'defautomatica');

	$golesLocalAuto			= mysql_result($estadoPartido,0,'goleslocalauto');
	$golesLocalBorra		= mysql_result($estadoPartido,0,'goleslocalborra');
	
	$golesvisitanteauto		= mysql_result($estadoPartido,0,'golesvisitanteauto');
	$golesvisitanteborra	= mysql_result($estadoPartido,0,'golesvisitanteborra');
	
	$puntosLocal			= mysql_result($estadoPartido,0,'puntoslocal');
	$puntosVisitante		= mysql_result($estadoPartido,0,'puntosvisitante');
	
	$finalizado				= mysql_result($estadoPartido,0,'finalizado');
	
	$ocultaDetallePublico	= mysql_result($estadoPartido,0,'ocultardetallepublico');
	
	$visibleParaArbitros	= mysql_result($estadoPartido,0,'visibleparaarbitros');
	
	$contabilizaLocal		= mysql_result($estadoPartido,0,'contabilizalocal');
	$contabilizaVisitante	= mysql_result($estadoPartido,0,'contabilizavisitante');
	
	// caso de ganado, perdido, empatado
	if (($defAutomatica == 'No') && ($finalizado == 'Si') && ($visibleParaArbitros == 'No')) {
		if (($golesRealesLocal > $golesRealesVisitantes) && (($puntosLocal == 0) || ($puntosLocal == 1))) {
			$error = "Error: El equipo local deberia ganar";	
			$lblerror = "alert-danger";
		}
		
		if (($golesRealesLocal < $golesRealesVisitantes) && (($puntosVisitante == 0) || ($puntosVisitante == 1))) {
			$error = "Error: El equipo visitante deberia ganar";
			$lblerror = "alert-danger";	
		}
		
		if (($golesRealesLocal == $golesRealesVisitantes) && ($puntosVisitante != $puntosLocal)) {
			$error = "Error: El partido deberia ser un empate";	
			$lblerror = "alert-danger";
		}
		
		
		
		if ($error == '') {
			$lblerror = "alert-success";
			$error = "Ok: Se cargo correctamente";	
			$serviciosReferencias->modificarFixturePorEstados($idFixture, $refEstadoPartido, $puntosLocal, $puntosVisitante, $golesRealesLocal, $golesRealesVisitantes, 1);
			if ($_SESSION['idroll_predio'] == 1) {
				$resEstados		= $serviciosReferencias->traerEstadospartidos();
				$cadEstados		= $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', $refEstadoPartido);
			} else {
				$resEstados		= $serviciosReferencias->traerEstadospartidosArbitros();
				$cadEstados		= $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', $refEstadoPartido);
			}
			
			/****************				MARCO LA SANCION CUMPLIDA					*********************/
			
			/****************				FIN MARCO LA SANCION CUMPLIDA					*********************/
		} else {
			$resM = $serviciosReferencias->modificarFixturePorEstados($idFixture, 'NULL', $puntosLocal, $puntosVisitante, $golesRealesLocal, $golesRealesVisitantes, 0);
			
			if ($_SESSION['idroll_predio'] == 1) {
				$resEstados		= $serviciosReferencias->traerEstadospartidos();
				$cadEstados		= $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');
			} else {
				$resEstados		= $serviciosReferencias->traerEstadospartidosArbitros();
				$cadEstados		= $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');
			}
			
		}
		
		$partidoSuspendidoCompletamente = 0;
	} else { // else del ganado, perdido, empatado
		// estados donde los partidos los define el estado como W.O. Local, Perdida de puntos a Ambos, Suspendido Finalizado
		if (($defAutomatica == 'Si') && ($finalizado == 'Si') && ($visibleParaArbitros == 'No')) {	
			if ($golesLocalBorra == 'Si') {
				//borrar los goles cargados al local
				$serviciosReferencias->modificaGoleadoresPorFixtureMasivo($idFixture, $equipoLocal);
				//verifico si los goles superan la cantidad arbitrada
				if ($golesRealesVisitantes > $golesvisitanteauto) {
					$golesvisitanteauto = $golesRealesVisitantes;
				}
			}
			
			if ($golesvisitanteborra == 'Si') {
				//borrar los goles cargados al local
				$serviciosReferencias->modificaGoleadoresPorFixtureMasivo($idFixture, $equipoVisitante);
				//verifico si los goles superan la cantidad arbitrada
				if ($golesRealesLocal > $golesLocalAuto) {
					$golesLocalAuto = $golesRealesLocal;
				}
			}
			
			$serviciosReferencias->modificarFixturePorEstados($idFixture, $refEstadoPartido, $puntosLocal, $puntosVisitante, $golesLocalAuto, $golesvisitanteauto, 1);

			
			if ($_SESSION['idroll_predio'] == 1) {
				$resEstados		= $serviciosReferencias->traerEstadospartidos();
				$cadEstados		= $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', $refEstadoPartido);
			} else {
				$resEstados		= $serviciosReferencias->traerEstadospartidosArbitros();
				$cadEstados		= $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', $refEstadoPartido);
			}
			
			$partidoSuspendidoCompletamente = 0;
		} else { // else del W.O. Local, Perdida de puntos a Ambos, Suspendido Finalizado
			
			// if para cuando un partido se suspende y no se carga nada
			if (($defAutomatica == 'No') && ($finalizado == 'No') && ($golesLocalAuto == 'No') && ($golesvisitanteauto == 'No')) {	
				$partidoSuspendidoCompletamente = 1;
			
			}
		}
	}
} else { //else de si no selecciono un estado para el partido

	
	if ($_SESSION['idroll_predio'] == 1) {
		$resEstados		= $serviciosReferencias->traerEstadospartidos();
		$cadEstados		= $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');
	} else {
		$resEstados		= $serviciosReferencias->traerEstadospartidosArbitros();
		$cadEstados		= $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');
	}
	
}



//////*************************			CALCULO POR ACUMULADION DE AMARILLAS	*********************************************/////



//////*************************			FIN calculo de amarillas	*********************************************/////

///////////////////////				FIN							////////////////////////////	
	
/////////////////////// Opciones de la pagina  ////////////////////

$lblTitulosingular	= "Estadistica";
$lblTituloplural	= "Estadisticas";
$lblEliminarObs		= "Si elimina la Estadistica se eliminara todo el contenido de este";
$accionEliminar		= "eliminarEstadisticas";

/////////////////////// Fin de las opciones /////////////////////



/////////////////////// Opciones para la creacion del view  /////////////////////
$cabeceras 		= "<th>Nombre</th>
				<th>DNI</th>
				<th>Equipo</th>
				<th>Fecha</th>
				<th>Goles</th>";

$cabeceras2 		= "<th>Nombre</th>
				<th>DNI</th>
				<th>Equipo</th>
				<th>Fecha</th>
				<th>Amarillas</th>";
//////////////////////////////////////////////  FIN de los opciones //////////////////////////



$resJugadoresA = $serviciosReferencias->traerConectorActivosPorEquiposCategorias($equipoLocal, $idCategoria);
$resJugadoresB = $serviciosReferencias->traerConectorActivosPorEquiposCategorias($equipoVisitante, $idCategoria);

$resFixDetalle	= $serviciosReferencias->traerFixtureDetallePorId($idFixture);

$refCanchas		=	$serviciosReferencias->traerCanchas();
if (mysql_result($resFixDetalle,0,'refcanchas') == '') {
	$cadCanchas	=	$serviciosFunciones->devolverSelectBox($refCanchas,array(1),'');	
} else {
	$cadCanchas	=	$serviciosFunciones->devolverSelectBoxActivo($refCanchas,array(1),'',mysql_result($resFixDetalle,0,'refcanchas'));
}

if ($_SESSION['idroll_predio'] != 1) {

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
    <link rel="stylesheet" href="../../css/chosen.css">
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>

    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../js/jquery.number.min.js"></script>
    
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
    
    <script type="text/javascript">
			
			$(function(){
				// Set up the number formatting.
				/*
				$('#goles3').number( true, 2 );
				$('#goles3').number( true, 2 );*/
				$('.golesEB').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.golescontraEB').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.golesEA').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.golescontraEA').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.amarillas').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.rojas').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.informados').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.dobleamarilla').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.cdtd').each(function(intIndex){
					$(this).number( true, 0 );
				});
				

				
				
				$('.golesEA').change(function(e) {
					var acumulado = 0;
					$('.golesEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					
					$('.resultadoA').html(acumulado);
				});
				
				
				$('.golescontraEB').change(function(e) {
					var acumulado = 0;
					$('.golesEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoA').html(acumulado);
				});
				
				
				$('.penalesconvertidosEA').change(function(e) {
					var acumulado = 0;
					$('.golesEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					
					$('.resultadoA').html(acumulado);
				});
				
				
				
				
				
				$('.golesEB').change(function(e) {
					var acumulado = 0;
					$('.golesEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoB').html(acumulado);
				});
				
				
				$('.golescontraEA').change(function(e) {
					var acumulado = 0;
					$('.golesEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoB').html(acumulado);
				});
				
				$('.penalesconvertidosEB').change(function(e) {
					var acumulado = 0;
					$('.golesEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoB').html(acumulado);
				});
				
				$('.minutos').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > <?php echo $minutos; ?>) {
							$(this).val(<?php echo $minutos; ?>);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.minutosEB').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > <?php echo $minutos; ?>) {
							$(this).val(<?php echo $minutos; ?>);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.amarillas').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 2) {
							$(this).val(2);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.rojas').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.informados').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.dobleamarilla').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.cdtd').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.penalesconvertidos').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.penalesatajados').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.penaleserrados').each(function(intIndex){
					$(this).number( true, 0 );
				});

			});
		</script>
    

</head>

<body>

 
<?php echo $resMenu; ?>

<div id="content">

    <div class="boxInfoLargoEstadisticas">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Cargar Estadisticas</p>
        	
        </div>
    	<div class="cuerpoBox" style="padding-right:10px;">
    		<form class="form-inline formulario" id="target" role="form" method="post" action="cargarestadisticas.php">
            
            <div class="row">
                <div class="col-md-3">
                	<p>Descripci�n: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'descripcion').$valorB; ?></span></p>
                </div>

                <div class="col-md-3">
                	<p>Tipo Torneo: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'tipotorneo'); ?></span></p>
                </div>
                <div class="col-md-3">
                	<p>Temporadas: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'temporada'); ?></span></p>
                </div>

                <div class="col-md-3">
                	<p>Categorias: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'categoria'); ?></span></p>
                </div>

                <div class="col-md-3">
                	<p>Divisiones: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'division'); ?></span></p>
                </div>

                <div class="col-md-3">
                	<p>Resp.Def. Tipo Jugadores <?php if (mysql_result($resFixDetalle,0,'respetadefiniciontipojugadores') == 'Si') { 
								?>
										<span style="color:#3C0;" class="glyphicon glyphicon-ok"></span>
								<?php
										} else {
								?>
										<span style="color:#F00;" class="glyphicon glyphicon-remove"></span>
								<?php		
										}
								?>
					
					</p>
                </div>
                <div class="col-md-3">
                	<p>Resp.Def. Habilitaciones Trans.<?php if (mysql_result($resFixDetalle,0,'respetadefinicionhabilitacionestransitorias') == 'Si') { 
								?>
										<span style="color:#3C0;" class="glyphicon glyphicon-ok"></span>
								<?php
										} else {
								?>
										<span style="color:#F00;" class="glyphicon glyphicon-remove"></span>
								<?php		
										}
								?></p>
                </div>
                <div class="col-md-3">
                	<p>Resp.Def. Sanciones Acumuladas<?php if (mysql_result($resFixDetalle,0,'respetadefinicionsancionesacumuladas') == 'Si') { 
								?>
										<span style="color:#3C0;" class="glyphicon glyphicon-ok"></span>
								<?php
										} else {
								?>
										<span style="color:#F00;" class="glyphicon glyphicon-remove"></span>
								<?php		
										}
								?></p>
                </div>
                <div class="col-md-3">
                	<p>Acumula Goleadores<?php if (mysql_result($resFixDetalle,0,'acumulagoleadores') == 'Si') { 
								?>
										<span style="color:#3C0;" class="glyphicon glyphicon-ok"></span>
								<?php
										} else {
								?>
										<span style="color:#F00;" class="glyphicon glyphicon-remove"></span>
								<?php		
										}
								?></p>
                </div>
                <div class="col-md-3">
                	<p>Acumula Tabla Conformada<?php if (mysql_result($resFixDetalle,0,'acumulatablaconformada') == 'Si') { 
								?>
										<span style="color:#3C0;" class="glyphicon glyphicon-ok"></span>
								<?php
										} else {
								?>
										<span style="color:#F00;" class="glyphicon glyphicon-remove"></span>
								<?php		
										}
								?></p>
                </div>
				<div class="col-md-3">
                	<p>Arbitro: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'arbitro'); ?></span></p>
                </div>
                <div class="col-md-3">
                	<p>Cancha: <select data-placeholder="selecione la cancha..." id="refcanchas" name="refcanchas" class="chosen-select" tabindex="2" style="width:190px;">
            								<option value=""></option>
											<?php echo $cadCanchas; ?>
                                            </select></p>
                </div>
                
                <div class="col-md-6">
                	<p style="font-size:2.2em">Resultado Local: <span class="resultadoA"><?php echo (mysql_result($resFixDetalle,0,'goleslocal') == '' ? 0 : mysql_result($resFixDetalle,0,'goleslocal')); ?></span></p>
                </div>
                <div class="col-md-6">
                	<p style="font-size:2.2em">Resultado Visitante: <span class="resultadoB"><?php echo (mysql_result($resFixDetalle,0,'golesvisitantes') == '' ? 0 : mysql_result($resFixDetalle,0,'golesvisitantes')); ?></span></p>
                </div>
                	
                </div>
            
            <div class="row">

                <div style="margin-left:5px;padding-left:10px; border-left:12px solid #0C0; border-bottom:1px solid #eee;border-top:1px solid #CCC; margin-right:5px;">
                <h4 style="color: #fff; background-color:#333; padding:6px;margin-left:-10px; margin-top:0;"><span class="glyphicon glyphicon-signal"></span> Datos Estad�sticos</h4>
                
                <!--		detalles del partido			---->
                
                <!--		detalles fin			---->
                
                
                
                
                <table class="table table-striped table-bordered table-responsive" id="example">
                	<caption style="font-size:1.5em; font-style:italic;">Equipo Local: <?php echo $equipoA; ?></caption>
                    <thead>
                    	<tr>
                        	<th>Jugador</th>
                            <th>DNI</th>
                            <th style="text-align:center">GA</th>
                            <th style="text-align:center">GC</th>
                            <th style="text-align:center">MIN</th>
                            <th style="text-align:center">PC</th>
                            <th style="text-align:center">PA</th>
                            <th style="text-align:center">PE</th>
                            <th style="text-align:center">MJ</th>
                            <th style="text-align:center">A</th>
                            <th style="text-align:center">E</th>
                            <th style="text-align:center">I</th>
                            <th style="text-align:center">A+A</th>
                            <th style="text-align:center">CDTD</th>
                            
                            <?php

							if ($_SESSION['idroll_predio'] == 1) {

							?>
                            <th style="text-align:center">Fallo</th>
                            <th style="text-align:center">Ver</th>
                            <?php
							}
							?>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
							
							while ($row = mysql_fetch_array($resJugadoresA)) {
								$estadisticas	= $serviciosReferencias->traerEstadisticaPorFixtureJugadorCategoriaDivision($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones);
								
								$sancionAmarilla		=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 1);
								
								$sancionRoja			=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 2);
								
								$sancionInformados		=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 3);
								
								$sancionDobleAmarilla	=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 4);
								
								$sancionCDTD			=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 5);
								
								$suspendidoDias				=	$serviciosReferencias->suspendidoPorDias($row['refjugadores']);
								
								$suspendidoCategorias		=	$serviciosReferencias->hayMovimientos($row['refjugadores'],$idFixture);
								$suspendidoCategoriasAA		=	$serviciosReferencias->hayMovimientosAmarillasAcumuladas($row['refjugadores'],$idFixture, $idCategoria);
								
								$falloA					=	$serviciosReferencias->traerSancionesjugadoresPorJugadorFixtureConValor($row['refjugadores'],$idFixture);
								

						if (($suspendidoDias == 0) && ($suspendidoCategorias == 0) && ($suspendidoCategoriasAA == 0)) {		
						?>
                        <tr class="<?php echo $row[0]; ?>">

                        	<th>
								<?php echo $row['nombrecompleto']; ?>
                            </th>
                            <th>
								<?php echo $row['nrodocumento']; ?>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm golesEA" name="goles<?php echo $row['refjugadores']; ?>" id="goles<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'goles'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm golescontraEA" name="encontra<?php echo $row['refjugadores']; ?>" id="encontra<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'encontra'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm minutos" name="minutos<?php echo $row['refjugadores']; ?>" id="minutos<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php if (mysql_result($estadisticas,0,'minutosjugados')==-1) { echo $minutos; } else { echo mysql_result($estadisticas,0,'minutosjugados'); } ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesconvertidosEA" name="penalesconvertidos<?php echo $row['refjugadores']; ?>" id="penalesconvertidos<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'penalconvertido'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesatajados" name="penalesatajados<?php echo $row['refjugadores']; ?>" id="penalesatajados<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'penalatajado'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penaleserrados" name="penaleserrados<?php echo $row['refjugadores']; ?>" id="penaleserrados<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'penalerrado'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="checkbox" class="form-control input-sm mejor" id="mejorjugador<?php echo $row['refjugadores']; ?>" name="mejorjugador<?php echo $row['refjugadores']; ?>" <?php if (mysql_result($estadisticas,0,'mejorjugador')== 'Si') { echo 'checked'; } ?> style="width:30px;"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm amarillas" name="amaLrillas<?php echo $row['refjugadores']; ?>" id="amaLrillas<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionAmarilla; ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm rojas" name="roLjas<?php echo $row['refjugadores']; ?>" id="roLjas<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionRoja; ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm informados" name="inforLmados<?php echo $row['refjugadores']; ?>" id="inforLmados<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionInformados; ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm dobleamarilla" name="dobleLamarilla<?php echo $row['refjugadores']; ?>" id="dobleLamarilla<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionDobleAmarilla; ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm cdtd" name="cdLtd<?php echo $row['refjugadores']; ?>" id="cdLtd<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionCDTD; ?>"/>
                                </div>
                            </th>
                            
                        
                        
                        <?php

							if ($_SESSION['idroll_predio'] == 1) {
								if ($falloA > 0) {
									$resFallo = $serviciosReferencias->traerSancionesJugadoresConFallosPorSancion($falloA);
									
									$fallo	= '';

									$amarillas		=	mysql_result($resFallo,0,'amarillas');
									$cantidadfechas	=	mysql_result($resFallo,0,'cantidadfechas');
									$fechadesde		=	mysql_result($resFallo,0,'fechadesde');
									$fechahasta		=	mysql_result($resFallo,0,'fechahasta');
									$pendiente		=	mysql_result($resFallo,0,'pendientesfallo');
									$observaciones	=	mysql_result($resFallo,0,'observaciones');
									
									if ($amarillas > 0) {
										$fallo = 'Doble Amarilla';
									} else {
										if ($fechadesde != '00/00/0000') {
											$fallo = 'Dias: desde '.$fechadesde.' hasta '.$fechahasta;
										} else {
											if ($pendiente == 'Si') {
												$fallo = 'Pendiente';
											} else {
												$fallo = 'Cantidad de Fechas:'.$cantidadfechas;	
											}
										}
									}
							?>
                            <th style="text-align:center"><?php echo $fallo; ?></th>
                            <th style="text-align:center"><a href="../sancionesfechascumplidas/index.php?id=<?php echo $falloA; ?>">Ver</a></th>
                            <?php
								} else {
									
							?>	
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            <?php	
								}
							}
							?>
                            
                        </tr>
                        <?php
							/* else del suspendidos */	
							} else {
								
								// si entro aca esta suspendido el jugador//
								
								
								
								// cargo que la fecha no la cumplio
								if ($partidoSuspendidoCompletamente == 0) {
									$serviciosReferencias->insertarSancionesfechascumplidas($idFixture,$row['refjugadores'],1,'');
								} else {
									$serviciosReferencias->insertarSancionesfechascumplidas($idFixture,$row['refjugadores'],0,'');
								}
								
						?>
                        <tr class="<?php echo $row[0]; ?>">

                        	<th style="background-color:#F00;">
								<?php echo $row['nombrecompleto']; ?>
                            </th>
                            <th style="background-color:#F00;">
								<?php echo $row['nrodocumento']; ?>
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            
                             <?php

							if ($_SESSION['idroll_predio'] == 1) {
								if ($falloA > 0) {
									$resFallo = $serviciosReferencias->traerSancionesJugadoresConFallosPorSancion($falloA);
									
									$fallo	= '';

									$amarillas		=	mysql_result($resFallo,0,'amarillas');
									$cantidadfechas	=	mysql_result($resFallo,0,'cantidadfechas');
									$fechadesde		=	mysql_result($resFallo,0,'fechadesde');
									$fechahasta		=	mysql_result($resFallo,0,'fechahasta');
									$pendiente		=	mysql_result($resFallo,0,'pendientesfallo');
									$observaciones	=	mysql_result($resFallo,0,'observaciones');
									
									if ($amarillas > 0) {
										$fallo = 'Doble Amarilla';
									} else {
										if ($fechadesde != '00/00/0000') {
											$fallo = 'Dias: desde '.$fechadesde.' hasta '.$fechahasta;
										} else {
											if ($pendiente == 'Si') {
												$fallo = 'Pendiente';
											} else {
												$fallo = 'Cantidad de Fechas:'.$cantidadfechas;	
											}
										}
									}
							?>
                            <th style="text-align:center"><?php echo $fallo; ?></th>
                            <th style="text-align:center"><a href="../fallos/modificarfechas.php?id=<?php echo $falloA; ?>">Ver</a></th>
                            <input type="hidden" id="sancionJugadores<?php echo $row['refjugadores']; ?>" name="sancionJugadores<?php echo $row['refjugadores']; ?>" value="1"/>
                            <?php
								} else {
									
							?>	
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            <?php	
								}
							}
							?>
                        </tr>
                        <?php
								}
								$goles = 0;
							}
						?>
                    </tbody>
                </table>
                </div>
  
                
                
                <hr>
                
                <div style="margin-left:5px;padding-left:10px;border-left:12px solid #C00; border-bottom:1px solid #eee; border-top:1px solid #CCC;margin-right:5px;">
                <h4 style="color: #fff; background-color:#333; padding:6px;margin-left:-10px; margin-top:0;"><span class="glyphicon glyphicon-signal"></span> Datos Estad�sticos</h4>
                <table class="table table-striped table-bordered table-responsive" id="example2">
                	<caption style="font-size:1.5em; font-style:italic;">Equipo Visitante: <?php echo $equipoB; ?></caption>
                    <thead>
                    	<tr>

                        	<th>Jugador</th>
                            <th>DNI</th>
                            <th style="text-align:center">GA</th>
                            <th style="text-align:center">GC</th>
                            <th style="text-align:center">MIN</th>
                            <th style="text-align:center">PC</th>
                            <th style="text-align:center">PA</th>
                            <th style="text-align:center">PE</th>
                            <th style="text-align:center">MJ</th>
                            <th style="text-align:center">A</th>
                            <th style="text-align:center">E</th>
                            <th style="text-align:center">I</th>
                            <th style="text-align:center">A+A</th>
                            <th style="text-align:center">CDTD</th>
                            
                            <?php

							if ($_SESSION['idroll_predio'] == 1) {

							?>
                            <th style="text-align:center">Fallo</th>
                            <th style="text-align:center">Ver</th>
                            <?php
							}
							?>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
							
							while ($rowB = mysql_fetch_array($resJugadoresB)) {
								$estadisticasB = $serviciosReferencias->traerEstadisticaPorFixtureJugadorCategoriaDivisionVisitante($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones);
								
								$sancionAmarilla		=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 1);
								
								$sancionRoja			=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 2);
								
								$sancionInformados		=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 3);
								
								$sancionDobleAmarilla	=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 4);
								
								$sancionCDTD			=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 5);
								
								$suspendidoDiasB			=	$serviciosReferencias->suspendidoPorDias($rowB['refjugadores']);
								
								$suspendidoCategoriasB		=	$serviciosReferencias->hayMovimientos($rowB['refjugadores'],$idFixture);
								$suspendidoCategoriasAAB	=	$serviciosReferencias->hayMovimientosAmarillasAcumuladas($rowB['refjugadores'],$idFixture, $idCategoria);
								
								$falloB					=	$serviciosReferencias->traerSancionesjugadoresPorJugadorFixtureConValor($rowB['refjugadores'],$idFixture);

						if (($suspendidoDiasB == 0) && ($suspendidoCategoriasB == 0) && ($suspendidoCategoriasAAB == 0)) {	
						?>
                        <tr class="<?php echo $rowB[0]; ?>">

                        	<th>
								<?php echo $rowB['nombrecompleto']; ?>
                            </th>
                            <th>
								<?php echo $rowB['nrodocumento']; ?>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm golesEB" name="gobles<?php echo $rowB['refjugadores']; ?>" id="gobles<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'goles'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm golescontraEB" name="enbcontra<?php echo $rowB['refjugadores']; ?>" id="enbcontra<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'encontra'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm minutosEB" name="minbutos<?php echo $rowB['refjugadores']; ?>" id="minbutos<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php if (mysql_result($estadisticasB,0,'minutosjugados')==-1) { echo $minutos; } else { echo mysql_result($estadisticasB,0,'minutosjugados'); } ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesconvertidosEB" name="penalesbconvertidos<?php echo $rowB['refjugadores']; ?>" id="penalesbconvertidos<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'penalconvertido'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesatajados" name="penalesbatajados<?php echo $rowB['refjugadores']; ?>" id="penalesbatajados<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'penalatajado'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penaleserrados" name="penalesberrados<?php echo $rowB['refjugadores']; ?>" id="penalesberrados<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'penalerrado'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="checkbox" class="form-control input-sm mejor" id="mejorbjugador<?php echo $rowB['refjugadores']; ?>" name="mejorbjugador<?php echo $rowB['refjugadores']; ?>" <?php if (mysql_result($estadisticasB,0,'mejorjugador')== 'Si') { echo 'checked'; } ?> style="width:30px;"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm amarillas" name="amaVrillas<?php echo $rowB['refjugadores']; ?>" id="amaVrillas<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionAmarilla; ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm rojas" name="roVjas<?php echo $rowB['refjugadores']; ?>" id="roVjas<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionRoja; ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm informados" name="inforVmados<?php echo $rowB['refjugadores']; ?>" id="inforVmados<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionInformados; ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm dobleamarilla" name="dobleVamarilla<?php echo $rowB['refjugadores']; ?>" id="dobleVamarilla<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionDobleAmarilla; ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm cdtd" name="cdVtd<?php echo $rowB['refjugadores']; ?>" id="cdVtd<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionCDTD; ?>"/>
                                </div>
                            </th>
                        
                        
                        
                        <?php

							if ($_SESSION['idroll_predio'] == 1) {
								if ($falloB > 0) {
									$resFallo = $serviciosReferencias->traerSancionesJugadoresConFallosPorSancion($falloB);
									
									$fallo	= '';

									$amarillas		=	mysql_result($resFallo,0,'amarillas');
									$cantidadfechas	=	mysql_result($resFallo,0,'cantidadfechas');
									$fechadesde		=	mysql_result($resFallo,0,'fechadesde');
									$fechahasta		=	mysql_result($resFallo,0,'fechahasta');
									$pendiente		=	mysql_result($resFallo,0,'pendientesfallo');
									$observaciones	=	mysql_result($resFallo,0,'observaciones');
									
									if ($amarillas > 0) {
										$fallo = 'Doble Amarilla';
									} else {
										if ($fechadesde != '00/00/0000') {
											$fallo = 'Dias: desde '.$fechadesde.' hasta '.$fechahasta;
										} else {
											if ($pendiente == 'Si') {
												$fallo = 'Pendiente';
											} else {
												$fallo = 'Cantidad de Fechas:'.$cantidadfechas;	
											}
										}
									}
							?>
                            <th style="text-align:center"><?php echo $fallo; ?></th>
                            <th style="text-align:center"><a href="../fallos/modificarfechas.php?id=<?php echo $falloB; ?>">Ver</a></th>
                            <input type="hidden" id="sancionBJugadores<?php echo $rowB['refjugadores']; ?>" name="sancionBJugadores<?php echo $rowB['refjugadores']; ?>" value="1"/>
                            <?php
								} else {
									
							?>	
                                    <th style="text-align:center"></th>
                                    <th style="text-align:center"></th>
                            <?php	
								}
							}
							?>
                        </tr>
                        <?php
							/* else del suspendidos */	
							} else {
								
								
								// cargo que la fecha no la cumplio
								if ($partidoSuspendidoCompletamente == 0) {
									$serviciosReferencias->insertarSancionesfechascumplidas($idFixture,$rowB['refjugadores'],1,'');
								} else {
									$serviciosReferencias->insertarSancionesfechascumplidas($idFixture,$rowB['refjugadores'],0,'');
								}
						?>
                        <tr class="<?php echo $rowB[0]; ?>">

                        	<th style="background-color:#F00;">
								<?php echo $rowB['nombrecompleto']; ?>
                            </th>
                            <th style="background-color:#F00;">
								<?php echo $rowB['nrodocumento']; ?>
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            
                            <?php

							if ($_SESSION['idroll_predio'] == 1) {
								if ($falloB > 0) {
									$resFallo = $serviciosReferencias->traerSancionesJugadoresConFallosPorSancion($falloB);
									
									$fallo	= '';

									$amarillas		=	mysql_result($resFallo,0,'amarillas');
									$cantidadfechas	=	mysql_result($resFallo,0,'cantidadfechas');
									$fechadesde		=	mysql_result($resFallo,0,'fechadesde');
									$fechahasta		=	mysql_result($resFallo,0,'fechahasta');
									$pendiente		=	mysql_result($resFallo,0,'pendientesfallo');
									$observaciones	=	mysql_result($resFallo,0,'observaciones');
									
									if ($amarillas > 0) {
										$fallo = 'Doble Amarilla';
									} else {
										if ($fechadesde != '00/00/0000') {
											$fallo = 'Dias: desde '.$fechadesde.' hasta '.$fechahasta;
										} else {
											if ($pendiente == 'Si') {
												$fallo = 'Pendiente';
											} else {
												$fallo = 'Cantidad de Fechas:'.$cantidadfechas;	
											}
										}
									}
							?>
                            <th style="text-align:center"><?php echo $fallo; ?></th>
                            <th style="text-align:center"><a href="../fallos/modificarfechas.php?id=<?php echo $falloB; ?>">Ver</a></th>
                            <?php
								} else {
									
							?>	
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            <?php	
								}
							}
							?>
                        </tr>
                        <?php
								}
							}
						?>
                    </tbody>
                </table>
				</div>
                
                
            
            
            
            
            
            <div class='row' style="margin-left:15px; margin-right:15px;">
                <div class='alert'>
                
                </div>
                <div class='alert <?php echo $lblerror; ?>'>
                	<p><?php echo $error; ?></p>
                </div>
                <div id='load'>
                
                </div>
            </div>
            
            <div class='row' style="margin-left:15px; margin-right:15px;">
            	<div class="form-group col-md-4" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Estado Partido</label>
                    <div class="input-group col-md-12">
                        <select class="form-control" id="refestadospartidos" name="refestadospartidos">
                        	<option value="0">-- Seleccionar --</option>
                            <?php echo $cadEstados; ?>
                        </select>    
                    </div>
                </div>
            </div>
			
            
            <div class="row" style="margin-left:15px; margin-right:15px;">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">

                    <li>
                        <button type="button" class="btn btn-primary" id="cargamasiva">Guardar Masivo</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            <input type="hidden" id="accion" name="accion" value="insertarEstadisticaMasiva" />
            <input type="hidden" id="idfixture" name="idfixture" value="<?php echo $idFixture; ?>" />
            </form>
    	</div>
    </div>

   
</div>


</div>



<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.13/api/fnFilterClear.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	$('#colapsarMenu').click();
	
	/*var table = $('#example dataTables_filter input');*/
	
	var table = $('#example').dataTable({
		"lengthMenu": [[30, 60 -1], [30, 60, "All"]],
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
	
	
	var table2 = $('#example2').dataTable({
		"lengthMenu": [[30, 60 -1], [30, 60, "All"]],
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
	
	$('.volver').click(function(e) {
        url = "estadisticas.php?id="+<?php echo $idFixture; ?>;
		$(location).attr('href',url);
    });
	
	$('#cargamasiva').click(function(e) {
		table.fnFilter('Win');
      	table.fnFilter('Trident', 0);
 
      	// Remove all filtering
      	table.fnFilterClear(); 
		
		table2.fnFilter('Win');
      	table2.fnFilter('Trident', 0);
 
      	// Remove all filtering
      	table2.fnFilterClear();  
		
		$( "#target" ).submit();
       
    });
	
	

	
	//al enviar el formulario
    $('#cargar').click(function(){

			//informaci�n del formulario
		var formData = new FormData($(".formulario")[0]);
		var message = "";
		//hacemos la petici�n ajax  
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
					$(".alert").html('<strong>Ok!</strong> Se cargo exitosamente las <strong>Estadisticas</strong>. ');
					$(".alert").delay(3000).queue(function(){
						/*aca lo que quiero hacer 
						  despu�s de los 2 segundos de retraso*/
						$(this).dequeue(); //contin�o con el siguiente �tem en la cola
						
					});
					$("#load").html('');
					url = "estadisticas.php?id="+<?php echo $idFixture; ?>;
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
		
    });

});
</script>

<script src="../../js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
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
	
	
  </script>
<?php } ?>
</body>
</html>