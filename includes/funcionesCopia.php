<?php

/**
 * @author www.intercambiosvirtuales.org
 * @copyright 2013
 */
date_default_timezone_set('America/Buenos_Aires');

class ServiciosCopia {
	
	/* PARA Cabeceracopia */

function generarCopia() {
	$sql = "select max(copia) from dbcabeceracopia";
	$res = $this->query($sql,0); 

	if (mysql_num_rows($res)>0) {
		return (mysql_result($res, 0,0) + 1);
	}
	return 1;
}

function insertarCabeceracopia($copia,$reftemporadas) { 
$sql = "insert into dbcabeceracopia(idcabeceracopia,copia,reftemporadas) 
values ('',".$copia.",".$reftemporadas.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarCabeceracopia($id,$copia,$reftemporadas) { 
$sql = "update dbcabeceracopia 
set 
copia = ".$copia.",reftemporadas = ".$reftemporadas." 
where idcabeceracopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarCabeceracopia($id) { 
$sql = "delete from dbcabeceracopia where idcabeceracopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerCabeceracopia() { 
$sql = "select 
c.idcabeceracopia,
c.copia,
c.reftemporadas,
tem.temporada
from dbcabeceracopia c 
inner join tbtemporadas tem ON tem.idtemporadas = c.reftemporadas 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerCabeceracopiaPorId($id) { 
$sql = "select idcabeceracopia,copia,reftemporadas from dbcabeceracopia where idcabeceracopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbcabeceracopia*/


/* PARA Jugadoresdocumentacion_copia */

function insertarJugadoresdocumentacion_copia($refjugadores,$refdocumentaciones,$valor,$observaciones,$refjugadoresdocumentacion,$refcabeceracopia) { 
$sql = "insert into dbjugadoresdocumentacion_copia(idjugadordocumentacioncopia,refjugadores,refdocumentaciones,valor,observaciones,refjugadoresdocumentacion,refcabeceracopia) 
values ('',".$refjugadores.",".$refdocumentaciones.",".$valor.",'".utf8_decode($observaciones)."',".$refjugadoresdocumentacion.",".$refcabeceracopia.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function insertarJugadoresdocumentacion_origen($refcabeceracopia) { 

	$sql = "insert into dbjugadoresdocumentacion_copia(idjugadordocumentacioncopia,refjugadores,refdocumentaciones,valor,observaciones,refjugadoresdocumentacion,refcabeceracopia) 
	select 
		'',refjugadores,refdocumentaciones,valor,observaciones,idjugadordocumentacion, ".$refcabeceracopia."
	from dbjugadoresdocumentacion"; 

	$res = $this->query($sql,0); 
	return $res; 
} 



function modificarJugadoresdocumentacion_copia($id,$refjugadores,$refdocumentaciones,$valor,$observaciones,$refjugadoresdocumentacion,$refcabeceracopia) { 
$sql = "update dbjugadoresdocumentacion_copia 
set 
refjugadores = ".$refjugadores.",refdocumentaciones = ".$refdocumentaciones.",valor = ".$valor.",observaciones = '".utf8_decode($observaciones)."',refjugadoresdocumentacion = ".$refjugadoresdocumentacion.",refcabeceracopia = ".$refcabeceracopia." 
where idjugadordocumentacioncopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadoresdocumentacion_copia($id) { 
$sql = "delete from dbjugadoresdocumentacion_copia where idjugadordocumentacioncopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadoresdocumentacion_todo() { 
$sql = "delete from dbjugadoresdocumentacion"; 
$res = $this->query($sql,0); 
return $res; 
} 


function insertarJugadoresdocumentacion_regreso($refcabeceracopia) { 

$sql = "insert into dbjugadoresdocumentacion(idjugadordocumentacion,refjugadores,refdocumentaciones,valor,observaciones) 
select 
	refjugadoresdocumentacion,refjugadores,refdocumentaciones,valor,observaciones 
from dbjugadoresdocumentacion_copia 
where refcabeceracopia = ".$refcabeceracopia; 
$res = $this->query($sql,0); 
return $res;

} 



function traerJugadoresdocumentacion_copia() { 
$sql = "select 
j.idjugadordocumentacioncopia,
j.refjugadores,
j.refdocumentaciones,
j.valor,
j.observaciones,
j.refjugadoresdocumentacion,
j.refcabeceracopia
from dbjugadoresdocumentacion_copia j 
inner join dbcabeceracopia cab ON cab.idcabeceracopia = j.refcabeceracopia 
inner join tbtemporadas te ON te.idtemporadas = cab.reftemporadas 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresdocumentacion_copiaPorId($id) { 
$sql = "select idjugadordocumentacioncopia,refjugadores,refdocumentaciones,valor,observaciones,refjugadoresdocumentacion,refcabeceracopia from dbjugadoresdocumentacion_copia where idjugadordocumentacioncopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbjugadoresdocumentacion_copia*/



/* PARA Jugadoresmotivoshabilitacionestransitorias_copia */

function insertarJugadoresmotivoshabilitacionestransitorias_copia($reftemporadas,$refjugadores,$refdocumentaciones,$refmotivoshabilitacionestransitorias,$refequipos,$refcategorias,$fechalimite,$observaciones,$refdbjugadormotivohabilitaciontransitoria,$refcabeceracopia) { 
$sql = "insert into dbjugadoresmotivoshabilitacionestransitorias_copia(iddbjugadormotivohabilitaciontransitoriacopia,reftemporadas,refjugadores,refdocumentaciones,refmotivoshabilitacionestransitorias,refequipos,refcategorias,fechalimite,observaciones,refdbjugadormotivohabilitaciontransitoria,refcabeceracopia) 
values ('',".$reftemporadas.",".$refjugadores.",".$refdocumentaciones.",".$refmotivoshabilitacionestransitorias.",".$refequipos.",".$refcategorias.",'".utf8_decode($fechalimite)."','".utf8_decode($observaciones)."',".$refdbjugadormotivohabilitaciontransitoria.",".$refcabeceracopia.")"; 
$res = $this->query($sql,1); 
return $res; 
} 



function insertarJugadoresmotivoshabilitacionestransitorias_origen($refcabeceracopia) { 
	$sql = "insert into dbjugadoresmotivoshabilitacionestransitorias_copia(iddbjugadormotivohabilitaciontransitoriacopia,reftemporadas,refjugadores,refdocumentaciones,refmotivoshabilitacionestransitorias,refequipos,refcategorias,fechalimite,observaciones,refdbjugadormotivohabilitaciontransitoria,refcabeceracopia) 
	select 
		'',reftemporadas,refjugadores,refdocumentaciones,refmotivoshabilitacionestransitorias,refequipos,refcategorias,fechalimite,observaciones,iddbjugadormotivohabilitaciontransitoria, ".$refcabeceracopia." 
	from dbjugadoresmotivoshabilitacionestransitorias"; 
	
	$res = $this->query($sql,0); 
	return $res; 
} 


function modificarJugadoresmotivoshabilitacionestransitorias_copia($id,$reftemporadas,$refjugadores,$refdocumentaciones,$refmotivoshabilitacionestransitorias,$refequipos,$refcategorias,$fechalimite,$observaciones,$refdbjugadormotivohabilitaciontransitoria,$refcabeceracopia) { 
$sql = "update dbjugadoresmotivoshabilitacionestransitorias_copia 
set 
reftemporadas = ".$reftemporadas.",refjugadores = ".$refjugadores.",refdocumentaciones = ".$refdocumentaciones.",refmotivoshabilitacionestransitorias = ".$refmotivoshabilitacionestransitorias.",refequipos = ".$refequipos.",refcategorias = ".$refcategorias.",fechalimite = '".utf8_decode($fechalimite)."',observaciones = '".utf8_decode($observaciones)."',refdbjugadormotivohabilitaciontransitoria = ".$refdbjugadormotivohabilitaciontransitoria.",refcabeceracopia = ".$refcabeceracopia." 
where iddbjugadormotivohabilitaciontransitoriacopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadoresmotivoshabilitacionestransitorias_copia($id) { 
$sql = "delete from dbjugadoresmotivoshabilitacionestransitorias_copia where iddbjugadormotivohabilitaciontransitoriacopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadoresmotivoshabilitacionestransitorias_todo() { 
$sql = "delete from dbjugadoresmotivoshabilitacionestransitorias"; 
$res = $this->query($sql,0); 
return $res; 
} 


function insertarJugadoresmotivoshabilitacionestransitorias_regreso($refcabeceracopia) { 
$sql = "insert into dbjugadoresmotivoshabilitacionestransitorias(iddbjugadormotivohabilitaciontransitoria,reftemporadas,refjugadores,refdocumentaciones,refmotivoshabilitacionestransitorias,refequipos,refcategorias,fechalimite,observaciones) 
select 
	refdbjugadormotivohabilitaciontransitoria,reftemporadas,refjugadores,refdocumentaciones,refmotivoshabilitacionestransitorias,refequipos,refcategorias,fechalimite,observaciones 
from dbjugadoresmotivoshabilitacionestransitorias_copia 
where refcabeceracopia =".$refcabeceracopia; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresmotivoshabilitacionestransitorias_copia() { 
$sql = "select 
j.iddbjugadormotivohabilitaciontransitoriacopia,
j.reftemporadas,
j.refjugadores,
j.refdocumentaciones,
j.refmotivoshabilitacionestransitorias,
j.refequipos,
j.refcategorias,
j.fechalimite,
j.observaciones,
j.refdbjugadormotivohabilitaciontransitoria,
j.refcabeceracopia
from dbjugadoresmotivoshabilitacionestransitorias_copia j 
inner join dbcabeceracopia cab ON cab.idcabeceracopia = j.refcabeceracopia 
inner join tbtemporadas te ON te.idtemporadas = cab.reftemporadas 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresmotivoshabilitacionestransitorias_copiaPorId($id) { 
$sql = "select iddbjugadormotivohabilitaciontransitoriacopia,reftemporadas,refjugadores,refdocumentaciones,refmotivoshabilitacionestransitorias,refequipos,refcategorias,fechalimite,observaciones,refdbjugadormotivohabilitaciontransitoria,refcabeceracopia from dbjugadoresmotivoshabilitacionestransitorias_copia where iddbjugadormotivohabilitaciontransitoriacopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbjugadoresmotivoshabilitacionestransitorias_copia*/




function insertarJugadoresvaloreshabilitacionestransitorias_copia($refjugadores,$refvaloreshabilitacionestransitorias,$refdbjugadorvalorhabilitaciontransitoria,$refcabeceracopia) { 
$sql = "insert into dbjugadoresvaloreshabilitacionestransitorias_copia(iddbjugadorvalorhabilitaciontransitoriacopia,refjugadores,refvaloreshabilitacionestransitorias,refdbjugadorvalorhabilitaciontransitoria,refcabeceracopia) 
values ('',".$refjugadores.",".$refvaloreshabilitacionestransitorias.",".$refdbjugadorvalorhabilitaciontransitoria.",".$refcabeceracopia.")"; 
$res = $this->query($sql,1); 
return $res; 
} 



function insertarJugadoresvaloreshabilitacionestransitorias_origen($refcabeceracopia) { 
	$sql = "insert into dbjugadoresvaloreshabilitacionestransitorias_copia(iddbjugadorvalorhabilitaciontransitoriacopia,refjugadores,refvaloreshabilitacionestransitorias,refdbjugadorvalorhabilitaciontransitoria,refcabeceracopia) 
	select 
		'',refjugadores,refvaloreshabilitacionestransitorias,iddbjugadorvalorhabilitaciontransitoria, ".$refcabeceracopia." 
	from dbjugadoresvaloreshabilitacionestransitorias"; 
	
	$res = $this->query($sql,0); 
	return $res; 
} 


function modificarJugadoresvaloreshabilitacionestransitorias_copia($id,$refjugadores,$refvaloreshabilitacionestransitorias,$refdbjugadorvalorhabilitaciontransitoria,$refcabeceracopia) { 
$sql = "update dbjugadoresvaloreshabilitacionestransitorias_copia 
set 
refjugadores = ".$refjugadores.",refvaloreshabilitacionestransitorias = ".$refvaloreshabilitacionestransitorias.",refdbjugadorvalorhabilitaciontransitoria = ".$refdbjugadorvalorhabilitaciontransitoria.",refcabeceracopia = ".$refcabeceracopia." 
where iddbjugadorvalorhabilitaciontransitoriacopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadoresvaloreshabilitacionestransitorias_copia($id) { 
$sql = "delete from dbjugadoresvaloreshabilitacionestransitorias_copia where iddbjugadorvalorhabilitaciontransitoriacopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadoresvaloreshabilitacionestransitorias_todo() { 
	$sql = "delete from dbjugadoresvaloreshabilitacionestransitorias"; 
	
	$res = $this->query($sql,0); 
	return $res; 
} 


function insertarJugadoresvaloreshabilitacionestransitorias_regreso($refcabeceracopia) { 
	$sql = "insert into dbjugadoresvaloreshabilitacionestransitorias(iddbjugadorvalorhabilitaciontransitoria,refjugadores,refvaloreshabilitacionestransitorias) 
	select 
		refdbjugadorvalorhabilitaciontransitoria, refjugadores,refvaloreshabilitacionestransitorias 
	from dbjugadoresvaloreshabilitacionestransitorias_copia 
	where refcabeceracopia =".$refcabeceracopia; 
	
	$res = $this->query($sql,0); 
	return $sql; 
} 


function traerJugadoresvaloreshabilitacionestransitorias_copia() { 
$sql = "select 
j.iddbjugadorvalorhabilitaciontransitoriacopia,
j.refjugadores,
j.refvaloreshabilitacionestransitorias,
j.refdbjugadorvalorhabilitaciontransitoria,
j.refcabeceracopia
from dbjugadoresvaloreshabilitacionestransitorias_copia j 
inner join dbcabeceracopia cab ON cab.idcabeceracopia = j.refcabeceracopia 
inner join tbtemporadas te ON te.idtemporadas = cab.reftemporadas 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresvaloreshabilitacionestransitorias_copiaPorId($id) { 
$sql = "select iddbjugadorvalorhabilitaciontransitoriacopia,refjugadores,refvaloreshabilitacionestransitorias,refdbjugadorvalorhabilitaciontransitoria,refcabeceracopia from dbjugadoresvaloreshabilitacionestransitorias_copia where iddbjugadorvalorhabilitaciontransitoriacopia =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbjugadoresvaloreshabilitacionestransitorias_copia*/
	
	
	
	function query($sql,$accion) {
		
		require_once 'appconfig.php';

		$appconfig	= new appconfig();
		$datos		= $appconfig->conexion();
		$hostname	= $datos['hostname'];
		$database	= $datos['database'];
		$username	= $datos['username'];
		$password	= $datos['password'];
		
		
		$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());
		
		mysql_select_db($database);
		mysql_query("SET NAMES 'utf8'");
		        $error = 0;
		mysql_query("BEGIN");
		$result=mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysql_query("ROLLBACK");
			return false;
		}
		 else{
			mysql_query("COMMIT");
			return $result;
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	}

?>