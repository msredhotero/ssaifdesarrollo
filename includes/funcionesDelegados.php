<?php

/**
 * @author www.intercambiosvirtuales.org
 * @copyright 2013
 */
date_default_timezone_set('America/Buenos_Aires');

class serviciosDelegados {

	function traerUltimaTemporada() {
        $sql = "select
        t.idtemporadas,
        t.temporada
        from tbtemporadas t
        order by 1 desc
        limit 1";
        $res = $this->query($sql,0);
        return $res;
    }

	function traerConectorActivosPorEquipos($refEquipos, $idtemporada) {
	    
	    $refTemporada = $this->traerUltimaTemporada();

       if (mysql_num_rows($refTemporada)>0) {
       	$idTemporada = mysql_result($refTemporada,0,0);
       } else {
       	$idTemporada = 0;
       }
	    
	if ($idtemporada == $idTemporada) {    
	$sql = "select
	    c.idconector,
	    cat.categoria,
	    equ.nombre as equipo,
	    co.nombre as countrie,
	    tip.tipojugador,
	    (case when c.esfusion = 1 then 'Si' else 'No' end) as esfusion,
	    (case when c.activo = 1 then 'Si' else 'No' end) as activo,
	    c.refjugadores,
	    c.reftipojugadores,
	    c.refequipos,
	    c.refcountries,
	    c.refcategorias,
	    concat(jug.apellido,', ',jug.nombres) as nombrecompleto,
	    jug.nrodocumento,
	    jug.fechanacimiento,
	    tip.idtipojugador,
	    year(now()) - year(jug.fechanacimiento) as edad,
	    jug.fechabaja,
	    jug.fechaalta

	from
	    dbconector c
	        inner join
	    dbjugadores jug ON jug.idjugador = c.refjugadores
	        inner join
	    tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos
	        inner join
	    dbcountries co ON co.idcountrie = jug.refcountries
	        inner join
	    tbtipojugadores tip ON tip.idtipojugador = c.reftipojugadores
	        inner join
	    dbequipos equ ON equ.idequipo = c.refequipos
	        inner join
	    tbdivisiones di ON di.iddivision = equ.refdivisiones
	        inner join
	    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
	        inner join
	    tbcategorias cat ON cat.idtcategoria = c.refcategorias
	    where equ.idequipo = ".$refEquipos." and c.reftemporadas = ".$idtemporada." and c.activo = 1
	order by concat(jug.apellido,', ',jug.nombres)";
	} else {
	    $sql = "select
	    c.idconector,
	    cat.categoria,
	    equ.nombre as equipo,
	    co.nombre as countrie,
	    tip.tipojugador,
	    (case when c.esfusion = 1 then 'Si' else 'No' end) as esfusion,
	    (case when c.activo = 1 then 'Si' else 'No' end) as activo,
	    c.refjugadores,
	    c.reftipojugadores,
	    c.refequipos,
	    c.refcountries,
	    c.refcategorias,
	    concat(jug.apellido,', ',jug.nombres) as nombrecompleto,
	    jug.nrodocumento,
	    jug.fechanacimiento,
	    tip.idtipojugador,
	    year(now()) - year(jug.fechanacimiento) as edad,
	    jug.fechabaja,
	    jug.fechaalta

	from
	    dbconector c
	        inner join
	    dbjugadores jug ON jug.idjugador = c.refjugadores
	        inner join
	    tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos
	        inner join
	    dbcountries co ON co.idcountrie = jug.refcountries
	        inner join
	    tbtipojugadores tip ON tip.idtipojugador = c.reftipojugadores
	        inner join
	    dbequipos equ ON equ.idequipo = c.refequipos
	        inner join
	    tbdivisiones di ON di.iddivision = equ.refdivisiones
	        inner join
	    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
	        inner join
	    tbcategorias cat ON cat.idtcategoria = c.refcategorias
	    where equ.idequipo = ".$refEquipos." and c.reftemporadas = ".$idtemporada."
	order by concat(jug.apellido,', ',jug.nombres)";
	}
	$res = $this->query($sql,0);
	return $res;
	}


	function traerConectorActivosPorEquiposEdades($refEquipos, $idtemporada) {
	    $refTemporada = $this->traerUltimaTemporada();

       if (mysql_num_rows($refTemporada)>0) {
       	$idTemporada = mysql_result($refTemporada,0,0);
       } else {
       	$idTemporada = 0;
       }
       
	if ($idtemporada == $idTemporada) {
    	$sql = "select
    	    min(year(now()) - year(jug.fechanacimiento)) as edadMinima,
    	    max(year(now()) - year(jug.fechanacimiento)) as edadMaxima,
    	    count(*) as cantidadJugadores,
    	    round((max(year(now()) - year(jug.fechanacimiento)) + min(year(now()) - year(jug.fechanacimiento)))/2,2) as edadPromedio
    	from
    	    dbconector c
    	        inner join
    	    dbjugadores jug ON jug.idjugador = c.refjugadores
    	        inner join
    	    tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos
    	        inner join
    	    dbcountries co ON co.idcountrie = jug.refcountries
    	        inner join
    	    tbtipojugadores tip ON tip.idtipojugador = c.reftipojugadores
    	        inner join
    	    dbequipos equ ON equ.idequipo = c.refequipos
    	        inner join
    	    tbdivisiones di ON di.iddivision = equ.refdivisiones
    	        left join
    	    dbcontactos con ON con.idcontacto = equ.refcontactos
    	        inner join
    	    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
    	        inner join
    	    tbcategorias cat ON cat.idtcategoria = c.refcategorias
    	    where equ.idequipo = ".$refEquipos." and c.reftemporadas = ".$idtemporada." and c.activo = 1";
	} else {
	    $sql = "select
    	    min(year(now()) - year(jug.fechanacimiento)) as edadMinima,
    	    max(year(now()) - year(jug.fechanacimiento)) as edadMaxima,
    	    count(*) as cantidadJugadores,
    	    round((max(year(now()) - year(jug.fechanacimiento)) + min(year(now()) - year(jug.fechanacimiento)))/2,2) as edadPromedio
    	from
    	    dbconector c
    	        inner join
    	    dbjugadores jug ON jug.idjugador = c.refjugadores
    	        inner join
    	    tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos
    	        inner join
    	    dbcountries co ON co.idcountrie = jug.refcountries
    	        inner join
    	    tbtipojugadores tip ON tip.idtipojugador = c.reftipojugadores
    	        inner join
    	    dbequipos equ ON equ.idequipo = c.refequipos
    	        inner join
    	    tbdivisiones di ON di.iddivision = equ.refdivisiones
    	        left join
    	    dbcontactos con ON con.idcontacto = equ.refcontactos
    	        inner join
    	    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
    	        inner join
    	    tbcategorias cat ON cat.idtcategoria = c.refcategorias
    	    where equ.idequipo = ".$refEquipos." and c.reftemporadas = ".$idtemporada."";
	}
	$res = $this->query($sql,0);
	return $res;
	}

	/* migraciones */

	function migrarJugadores($id) {
		$resEquipo = $this->traerEquiposdelegadosPorId($id);

		// primero determino si es un equipo nuevo
		if ((mysql_result($resEquipo,0,'activo') == 'Si') && (mysql_result($resEquipo,0,'nuevo') == 'Si')) {
			// inserto todos los conectores sin los jugadores nuevos
			$resInsertarConectores = $this->insertarConectorMasivo(mysql_result($resEquipo,0,'idequipo'), mysql_result($resEquipo,0,'reftemporadas'));

			// traigo todos los jugadores nuevos del plantel y los inserto en jugadores
			$resJugadoresNuevos = $this->traerJugadoresPreConectores(mysql_result($resEquipo,0,'idequipo'), mysql_result($resEquipo,0,'reftemporadas'));
			while ($row = mysql_fetch_array($resJugadoresNuevos)) {
				if ($this->existeJugador($row['nrodocumento']) == 0) {
					$resIJ = $this->insertarJugadorDocumentacionValores($row['refjugadorespre']);
					
					$resConector = $this->insertarConectorPorJugadorPre($row['refjugadorespre'], $resIJ, mysql_result($resEquipo,0,'reftemporadas'));
				} else {
					$resConector = $this->insertarConectorPorJugadorPre($row['refjugadorespre'], $resIJ, mysql_result($resEquipo,0,'reftemporadas'));
				}

			}

			return '';
		}

		// si el equipo se mantiene
		if ((mysql_result($resEquipo,0,'activo') == 'Si') && (mysql_result($resEquipo,0,'nuevo') == 'No')) {
			// doy de baja a los jugadores para este equipo
			$resBaja = $this->eliminarTodosLosJugadores(mysql_result($resEquipo,0,'idequipo'));

			// inserto todos los conectores sin los jugadores nuevos
			$resInsertarConectores = $this->insertarConectorMasivo(mysql_result($resEquipo,0,'idequipo'), mysql_result($resEquipo,0,'reftemporadas'));

			// traigo todos los jugadores nuevos del plantel y los inserto en jugadores

			$resJugadoresNuevos = $this->traerJugadoresPreConectores(mysql_result($resEquipo,0,'idequipo'), mysql_result($resEquipo,0,'reftemporadas'));
			while ($row = mysql_fetch_array($resJugadoresNuevos)) {
				if ($this->existeJugador($row['nrodocumento']) == 0) {
					$resIJ = $this->insertarJugadorDocumentacionValores($row['refjugadorespre']);
					$resConector = $this->insertarConectorPorJugadorPre($row['refjugadorespre'], $resIJ, mysql_result($resEquipo,0,'reftemporadas'));
				}

			}
			return '';

		}

	}

	function existeJugador($nroDocumento) {
	    $sql = "select idjugador from dbjugadores where nrodocumento = ".$nroDocumento;
	    $res = $this->query($sql,0);

	    if (mysql_num_rows($res)>0) {
	        return 1;
	    }
	    return 0;
	}

	function insertarJugadorDocumentacionValores($id) {

		$sql = "INSERT INTO dbjugadores
					(idjugador,
					reftipodocumentos,
					nrodocumento,
					apellido,
					nombres,
					email,
					fechanacimiento,
					fechaalta,
					refcountries,
					observaciones)
					select
					'',
					reftipodocumentos,
					nrodocumento,
					apellido,
					nombres,
					email,
					fechanacimiento,
					fechaalta,
					refcountries,
					observaciones
					from		dbjugadorespre
					where		idjugadorpre = ".$id;


		$res = $this->query($sql,1);

		$this->modificarDocumentacionjugadorimagenesIDjugador($id, $res);

		//inserto la documentacion

		//inserto la foto y el documento
		$this->insertarJugadoresdocumentacion($res,1,0,'');
		$this->insertarJugadoresdocumentacion($res,2,0,'');

		//ficha
		$this->insertarJugadoresdocumentacion($res,3,0,'');

		//escritura
		$this->insertarJugadoresdocumentacion($res,4,0,'');

		//examen medico
		$this->insertarJugadoresdocumentacion($res,5,0,'');

		//expensa
		$this->insertarJugadoresdocumentacion($res,6,0,'');

		//inhabilita country
		$this->insertarJugadoresdocumentacion($res,7,0,'');

		//partida nacimiento
		$this->insertarJugadoresdocumentacion($res,9,0,'');


		//inserto los valores de la documentacion

		//foto
		$this->insertarJugadoresvaloreshabilitacionestransitorias($res,330);

		//documento
		$this->insertarJugadoresvaloreshabilitacionestransitorias($res,332);

		//ficha
		$this->insertarJugadoresvaloreshabilitacionestransitorias($res,334);

		//escritura
		$this->insertarJugadoresvaloreshabilitacionestransitorias($res,339);


		//examen medico
		$this->insertarJugadoresvaloreshabilitacionestransitorias($res,361);

		//expensa
		$this->insertarJugadoresvaloreshabilitacionestransitorias($res,364);


		//inhabilita country
		$this->insertarJugadoresvaloreshabilitacionestransitorias($res,366);

		//partida nacimiento
		$this->insertarJugadoresvaloreshabilitacionestransitorias($res,369);

		return $res;
	}

	function insertarJugadoresdocumentacion($refjugadores,$refdocumentaciones,$valor,$observaciones) {
		$sql = "insert into dbjugadoresdocumentacion(idjugadordocumentacion,refjugadores,refdocumentaciones,valor,observaciones)
		values ('',".$refjugadores.",".$refdocumentaciones.",".$valor.",'".$observaciones."')";

		$res = $this->query($sql,1);
		return $res;
	}


	function insertarJugadoresvaloreshabilitacionestransitorias($refjugadores,$refvaloreshabilitacionestransitorias) {
		$sql = "insert into dbjugadoresvaloreshabilitacionestransitorias(iddbjugadorvalorhabilitaciontransitoria,refjugadores,refvaloreshabilitacionestransitorias)
		values ('',".$refjugadores.",".$refvaloreshabilitacionestransitorias.")";

		$res = $this->query($sql,1);
		return $sql;
	}


	function modificarDocumentacionjugadorimagenesIDjugador($refjugadorespre,$idjugador) {
		$sql = "update dbdocumentacionjugadorimagenes
		set
		idjugador = ".$idjugador."
		where refjugadorespre =".$refjugadorespre;

		$res = $this->query($sql,0);
		return $res;
	}

	function insertarConectorMasivo($id, $idtemporada) {
		$sql = "INSERT INTO dbconector
						(idconector,
						refjugadores,
						reftipojugadores,
						refequipos,
						refcountries,
						refcategorias,
						esfusion,
						activo,
						reftemporadas)
					SELECT '',
					    refjugadores,
					    reftipojugadores,
					    refequipos,
					    refcountries,
					    refcategorias,
					    esfusion,
					    activo,
						 ".$idtemporada."
					FROM dbconectordelegados where reftemporadas = ".$idtemporada." and refequipos = ".$id." and refjugadorespre = 0";

		$res = $this->query($sql,0);
		return $res;
	}

	function insertarConectorPorJugadorPre($id, $idjugador, $idtemporada) {
		$sql = "INSERT INTO dbconector
						(idconector,
						refjugadores,
						reftipojugadores,
						refequipos,
						refcountries,
						refcategorias,
						esfusion,
						activo,
						reftemporadas)
					SELECT '',
					    ".$idjugador.",
					    reftipojugadores,
					    refequipos,
					    refcountries,
					    refcategorias,
					    esfusion,
					    activo,
						 ".$idtemporada."
					FROM dbconectordelegados where reftemporadas = ".$idtemporada." and refjugadorespre = ".$id;

		$res = $this->query($sql,1);
		return $res;
	}

	function traerJugadoresPreConectores($id, $idtemporada) {
		$sql = "SELECT c.idconector,
					    c.refjugadores,
					    c.reftipojugadores,
					    c.refequipos,
					    c.refcountries,
					    c.refcategorias,
					    c.esfusion,
					    c.activo,
						 c.refjugadorespre,
						 j.nrodocumento
					FROM dbconectordelegados c
					inner join dbjugadorespre j on j.idjugadorpre = c.refjugadorespre
					where c.reftemporadas = ".$idtemporada." and c.refequipos = ".$id." and c.refjugadorespre > 0 
					order by c.refjugadorespre";

		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarTodosLosJugadores($id) {
		$sql = "update dbconector set activo = 0 where refequipos =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function migrarEquipo($id) {

		$resEquipo = $this->traerEquiposdelegadosPorId($id);

		$existeEquipo = $this->traerEquiposPorId(mysql_result($resEquipo,0,'idequipo'));

		if (mysql_result($resEquipo,0,'refestados') == 7) {

			//determino si es nuevo
			if ((mysql_result($resEquipo,0,'activo') == 'Si') && (mysql_result($resEquipo,0,'nuevo') == 'Si')) {
				//verifico que no exista
				if (mysql_num_rows($existeEquipo) > 0) {
					return 'El equipo ya fue dado de alta';
				} else {
					// inserto en dbequipos al equipo
					$resInsertar = $this->insertarEquipos($id);

					return '';
				}
			}

			//determino si lo doy de baja
			if ((mysql_result($resEquipo,0,'activo') == 'No') && (mysql_result($resEquipo,0,'nuevo') == 'No')) {

				$resBaja = $this->darBajaEquipo(mysql_result($resEquipo,0,'idequipo'));
				return '';
			}

			return '';
		} else {
			return 'No puede ser migrado';
		}

	}

	function darBajaEquipo($id) {
		$sql = "update dbequipos set fachebaja = now(), activo = 0 where idequipo = ".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function insertarEquipos($id) {
		$sql = "INSERT INTO dbequipos
						(idequipo,
						refcountries,
						nombre,
						refcategorias,
						refdivisiones,
						refcontactos,
						fechaalta,
						fachebaja,
						activo)
					select
						idequipo,
						refcountries,
						nombre,
						refcategorias,
						refdivisiones,
						0,
						now(),
						'0000-00-00',
						activo
					from dbequiposdelegados where idequipodelegado =".$id;

		$res = $this->query($sql,1);
		return $res;
	}

	function traerEquiposPorId($id) {
		$sql = "select idequipo,refcountries,nombre,refcategorias,refdivisiones,refcontactos,fechaalta,fachebaja,(case when activo = 1 then 'Si' else 'No' end) as activo from dbequipos where idequipo =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	/* fin */

/* PARA Cabeceraconfirmacion */

	function traerTareasGeneralPorCountrieId($idcountrie, $id1) {
		$sql = "SELECT idtarea,
						cc.nombre as countrie,
						tarea,
						est.estado,
						usuariocrea,
						fechacrea,
						usuariomodi,
						fechamodi,
						url,
						id1,
						id2,
						id3,
						refestados,
						refcountries,
						est.color,
						est.idestadotarea
					FROM dbtareas t
					inner join dbcountries cc ON cc.idcountrie = t.refcountries
					inner join tbestadostareas est ON est.idestadotarea = t.refestados
					where cc.idcountrie = ".$idcountrie." and t.id1 = ".$id1;

		$res = $this->query($sql,0);
		return $res;
	}

	function cambiarEstadoTareas($idtarea=0, $refestado, $idpadre=0, $tablaMadre='') {
		if ($idpadre != 0) {
			switch ($tablaMadre) {
				case 'dbfusionequipos':
					$sql = "update dbtareas set refestados = ".$refestado." where id1 = ".$idpadre;
				break;

				default:
				# code...
				break;
			}
		} else {
		$sql = "update dbtareas set refestados = ".$refestado." where idtarea = ".$idtarea;
		}

		$res = $this->query($sql,0);
		return $res;
	}

function devolverIdEstado($tabla,$id, $idlbl) {
	$sql = "select refestados
			from ".$tabla."
			where ".$idlbl." = ".$id;

	$res = $this->existeDevuelveId($sql);
	return $res;
}

function existeCabeceraConfirmacion($reftemporadas,$refcountries) {
	$sql = "select idcabeceraconfirmacion
			from dbcabeceraconfirmacion
			where reftemporadas = ".$reftemporadas." and refcountries = ".$refcountries;

	$res = $this->existeDevuelveId($sql);
	return $res;
}

function insertarCabeceraconfirmacion($reftemporadas,$refcountries,$refestados,$usuacrea,$usuamodi) {
	$sql = "insert into dbcabeceraconfirmacion(idcabeceraconfirmacion,reftemporadas,refcountries,refestados,fechacrea,fechamodi,usuacrea,usuamodi)
	values ('',".$reftemporadas.",".$refcountries.",".$refestados.",'".date('Y-m-d')."','".date('Y-m-d')."','".utf8_decode($usuacrea)."','".utf8_decode($usuamodi)."')";
	$res = $this->query($sql,1);
	return $res;
}


function modificarCabeceraconfirmacion($id,$reftemporadas,$refcountries,$refestados,$usuacrea,$usuamodi) {
	$sql = "update dbcabeceraconfirmacion
	set
	reftemporadas = ".$reftemporadas.",refcountries = ".$refcountries.",refestados = ".$refestados.",fechamodi = '".date('Y-m-d')."',usuacrea = '".utf8_decode($usuacrea)."',usuamodi = '".utf8_decode($usuamodi)."'
	where idcabeceraconfirmacion =".$id;
	$res = $this->query($sql,0);
	return $res;
}

function modificarCabeceraconfirmacionEstado($id,$refestados) {
	$sql = "update dbcabeceraconfirmacion
	set
	refestados = ".$refestados."
	where idcabeceraconfirmacion =".$id;
	$res = $this->query($sql,0);
	return $res;
}


function eliminarCabeceraconfirmacion($id) {
	$sql = "delete from dbcabeceraconfirmacion where idcabeceraconfirmacion =".$id;
	$res = $this->query($sql,0);
	return $res;
}


function traerCabeceraconfirmacion() {
	$sql = "select
	c.idcabeceraconfirmacion,
	c.reftemporadas,
	c.refcountries,
	c.refestados,
	c.fechacrea,
	c.fechamodi,
	c.usuacrea,
	c.usuamodi
	from dbcabeceraconfirmacion c
	order by 1";
	$res = $this->query($sql,0);
	return $res;
}

function traerCabeceraconfirmacionPorClubTemporada($refcountries, $reftemporadas) {
	$sql = "select
	c.idcabeceraconfirmacion,
	c.reftemporadas,
	c.refcountries,
	c.refestados,
	c.fechacrea,
	c.fechamodi,
	c.usuacrea,
	c.usuamodi
	from dbcabeceraconfirmacion c
	where c.reftemporadas = ".$reftemporadas." and c.refcountries = ".$refcountries."
	order by 1";
	$res = $this->query($sql,0);
	return $res;
}

	function traerEquiposdelegadosPorId($id) {
		$sql = "select idequipodelegado,idequipo,reftemporadas,refusuarios,refcountries,nombre,refcategorias,refdivisiones,fechabaja,
		(case when activo = 1 then 'Si' else 'No' end) as activo,
		refestados,
		(case when nuevo = 1 then 'Si' else 'No' end) as nuevo
		from dbequiposdelegados where idequipodelegado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


function traerCabeceraconfirmacionGrid() {
	$sql = "select
	c.idcabeceraconfirmacion,
	t.temporada,
	co.nombre as countrie,
	est.estado,
	c.fechacrea,
	c.reftemporadas,
	c.refcountries,
	c.refestados,
	c.fechamodi,
	c.usuacrea,
	c.usuamodi
	from dbcabeceraconfirmacion c
	inner join tbtemporadas t on t.idtemporadas = c.reftemporadas
	inner join dbcountries co on co.idcountrie = c.refcountries
	inner join tbestados est on est.idestado = c.refestados
	order by t.temporada desc, co.nombre";
	$res = $this->query($sql,0);
	return $res;
}


function traerCabeceraconfirmacionPorId($id) {
	$sql = "SELECT
				cc.idcabeceraconfirmacion,
				cc.reftemporadas,
				cc.refcountries,
				cc.refestados,
				cc.fechacrea,
				cc.fechamodi,
				cc.usuacrea,
				cc.usuamodi,
				est.estado
			FROM
				dbcabeceraconfirmacion cc
			INNER JOIN
				tbestados est ON est.idestado = cc.refestados
			WHERE
				idcabeceraconfirmacion =".$id;
	$res = $this->query($sql,0);
	return $res;
}



	function traerEquiposdelegadosPorCountrieFinalizado($id, $idtemporada) {
		$sql = "SELECT
					e.idequipo,
					cou.nombre AS countrie,
					e.nombre,
					cat.categoria,
					di.division,
					e.fechabaja,
					(CASE
						WHEN e.activo = 1 THEN 'Si'
						ELSE 'No'
					END) AS activo,
					est.estado,
					cat.orden,
					e.refdivisiones,
					(CASE
						WHEN est.idestado = 1 THEN 'label-info'
						WHEN est.idestado = 2 THEN 'label-warning'
						WHEN est.idestado = 3 THEN 'label-success'
						WHEN est.idestado = 4 THEN 'label-danger'
					END) AS label,
					est.idestado as refestados,
                    (case when coalesce(max(fe.refcountries),0) = 0 then 'No' else 'Si' end) as esfusion,
                    e.idequipodelegado,
                    (select
					(case when coalesce(min(fe.refestados),1) = 3 then 3 else 0 end) as idestado
					from dbfusionequipos fe
					inner join dbequiposdelegados ed on ed.idequipodelegado = fe.refequiposdelegados
					where fe.refequiposdelegados = e.idequipodelegado and ed.refcountries = ".$id.") as fusion,
					(CASE
						WHEN e.nuevo = 1 THEN 'Si'
						ELSE 'No'
					END) AS nuevo
				FROM
					dbequiposdelegados e
						INNER JOIN
					dbcountries cou ON cou.idcountrie = e.refcountries
						INNER JOIN
					tbcategorias cat ON cat.idtcategoria = e.refcategorias
						INNER JOIN
					tbdivisiones di ON di.iddivision = e.refdivisiones
						INNER JOIN
					tbestados est ON est.idestado = e.refestados
						left JOIN
					dbfusionequipos fe ON fe.refequiposdelegados = e.idequipodelegado
				WHERE
					cou.idcountrie = ".$id."
			AND e.reftemporadas = ".$idtemporada."
            group by e.idequipo,
					cou.nombre,
					e.nombre,
					cat.categoria,
					di.division,
					e.fechabaja,
					e.activo,
					est.estado,
					cat.orden,
					e.refdivisiones,
					est.idestado,
					est.idestado
			order by cat.idtcategoria,di.iddivision";

		$res = $this->query($sql,0);

		return $res;
	}

	function modificarEstadoEquiposDelegados($id,$refestados) {
		$sql = "update dbequiposdelegados
		set
		refestados = ".$refestados."
		where idequipodelegado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function modificarEstadoFusion($id,$refestados) {
		$sql = "update dbfusionequipos
		set
		refestados = ".$refestados."
		where idfusionequipo =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerFusionesPorEquipo($idequiposdelegados) {

		$sql = "select
					fe.idfusionequipo,
					cpf.nombre as countriesfusion,
					cat.categoria,
					di.division,
					ed.nombre,
					est.estado,
					(case when fe.viejo = 1 then 'Mantiene' else 'Nuevo' end) as viejo,
					est.idestado,
					cp.nombre as countries

				from dbfusionequipos fe
				inner join dbequiposdelegados ed on ed.idequipodelegado = fe.refequiposdelegados
				inner join dbcountries cp on cp.idcountrie = ed.refcountries
				inner join dbcountries cpf on cpf.idcountrie = fe.refcountries
				inner join tbcategorias cat on cat.idtcategoria = ed.refcategorias
				inner join tbdivisiones di on di.iddivision = ed.refdivisiones
				inner join tbestados est on est.idestado = fe.refestados
				where ed.idequipodelegado = ".$idequiposdelegados;

		$res = $this->query($sql,0);
		return $res;

	}

	function traerFusionesequiposPorId($id) {
		$sql = "select idfusionequipo,refequiposdelegados,refcountries,refestados,observacion,viejo
					from dbfusionequipos where idfusionequipo = ".$id;
		$res = $this->query($sql,0);
		return $res;
	}
/*
UPDATE tableA a
INNER JOIN tableB b ON a.name_a = b.name_b
SET validation_check = if(start_dts > end_dts, 'VALID', '')
-- where clause can go here
*/
	function aprobarMasivoEquiposDelagados($idcabecera, $idestado) {
		$sql = "update dbequiposdelegados ed
					inner join dbcabeceraconfirmacion cc on cc.reftemporadas = ed.reftemporadas and cc.refcountries = ed.refcountries
				set ed.refestados = ".$idestado."
				where cc.idcabeceraconfirmacion = ".$idcabecera;
		$res = $this->query($sql,0);
		return $res;
	}


	function verificarAprobadoCompletoFase1($idcabecera) {
		$resCabecera = $this->traerCabeceraconfirmacionPorId($idcabecera);

		$idestado1 = mysql_result($resCabecera,0,'refestados');
		$idcountrie= mysql_result($resCabecera,0,'refcountries');

		$cad = '';

		$sql = "select
					ed.refestados, count(*)
					from		dbequiposdelegados ed
					inner join dbcabeceraconfirmacion cab on cab.reftemporadas = ed.reftemporadas and cab.refcountries = ed.refcountries
					where		cab.idcabeceraconfirmacion = ".$idcabecera."
					group by refestados";

		$resEquipos = $this->query($sql,0);



		if (mysql_num_rows($resEquipos) > 0) {
			$cad .= 'Acepto Equipos<br>';
			$idestado2 = mysql_result($resEquipos,0,'refestados');
			$total = mysql_result($resEquipos,0,1);
		} else {
			$idestado2 = 0;
			$cad .= 'No Acepto Equipos<br>';
		}

		if ($idestado2 > 0) {
			if ((1 == mysql_num_rows($resEquipos)) && ($idestado1 == 3) && ($idestado2 == 3)) {
				$cad .= 'Cumple con todo<br>';
				// envio un email
				$encargado	=	$this->traerEncargadoPorCountries($idcountrie);
				$asunto		=	'Todos los Equipos Fueron Aceptados';
				$cuerpo		=	'Puede continuar con la carga de la Lista de Buena Fe';

				if ($encargado['email1'] != '') {
					$this->enviarEmail($encargado['email1'],$asunto,$cuerpo, $referencia='');
				}
				if ($encargado['email2'] != '') {
					$this->enviarEmail($encargado['email2'],$asunto,$cuerpo, $referencia='');
				}
				if ($encargado['email3'] != '') {
					$this->enviarEmail($encargado['email3'],$asunto,$cuerpo, $referencia='');
				}
				if ($encargado['email4'] != '') {
					$this->enviarEmail($encargado['email4'],$asunto,$cuerpo, $referencia='');
				}

			} else {
				$cad .= 'No Cumple con todo<br>'.$total.'<br>'.mysql_num_rows($resEquipos);
			}
		}

		return $cad;

	}

	function traerEncargadoPorCountries($idcountrie) {
		$sql = "select email, idusuario from dbusuarios where refcountries = ".$idcountrie;
		$resUsuario = $this->query($sql,0);

		$email = mysql_result($resUsuario,0,0);
		$idusuario = mysql_result($resUsuario,0,1);

		$sqlDelegados = "select email1,email2,email3,email4 from dbdelegados where refusuarios = ".$idusuario;
		$resDelegado = $this->query($sqlDelegados,0);

		$email1 = '';
		$email2 = '';
		$email3 = '';
		$email4 = '';

		if (mysql_num_rows($resDelegado) > 0) {
			// empiezo a enviar emails a los que esten agregados
			if (mysql_result($resDelegado,0,'email1') != '') {
				$email1 = mysql_result($resDelegado,0,'email1');
			}
			if (mysql_result($resDelegado,0,'email2') != '') {
				$email2 = mysql_result($resDelegado,0,'email2');
			}
			if (mysql_result($resDelegado,0,'email3') != '') {
				$email3 = mysql_result($resDelegado,0,'email3');
			}
			if (mysql_result($resDelegado,0,'email4') != '') {
				$email4 = mysql_result($resDelegado,0,'email4');
			}
		}

		$arEncargado = array('idusuario'=> $idusuario, 'email' => $email,'email1' => $email1,'email2' => $email2,'email3' => $email3,'email4' => $email4);

		return $arEncargado;

	}


	function enviarEmail($destinatario,$asunto,$cuerpo, $referencia='') {

	    if ($referencia == '') {
	        $referencia = 'aif@intercountryfutbol.com.ar';
	    }
	    # Defina el número de e-mails que desea enviar por periodo. Si es 0, el proceso por lotes
	    # se deshabilita y los mensajes son enviados tan rápido como sea posible.
	    define("MAILQUEUE_BATCH_SIZE",0);

	    //para el envío en formato HTML
	    //$headers = "MIME-Version: 1.0\r\n";

	    // Cabecera que especifica que es un HMTL
	    $headers  = 'MIME-Version: 1.0' . "\r\n";
	    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	    //dirección del remitente
	    $headers .= utf8_decode("From: ASOCIACIÓN INTERCOUNTRY DE FÚTBOL ZONA NORTE <aif@intercountryfutbol.com.ar>\r\n");

	    //ruta del mensaje desde origen a destino
	    $headers .= "Return-path: ".$destinatario."\r\n";

	    //direcciones que recibirán copia oculta
	    $headers .= "Bcc: ".$referencia."\r\n";

	    mail($destinatario,$asunto,$cuerpo,$headers);
	}

	/* Fin */
	/* /* Fin de la Tabla: dbcabeceraconfirmacion*/



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
