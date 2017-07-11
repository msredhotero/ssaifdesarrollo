<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Buenos_Aires');

class ServiciosReferencias {


function calcularPuntoBonusViejo($refTorneo, $idEquipo) {
	$resPuntosBonus = $this->traerPuntobonusPorId(1);
	
	$cantidadFechas = (integer)mysql_result($resPuntosBonus,0,'cantidadfechas');
	
	$puntosextra	= (integer)mysql_result($resPuntosBonus,0,'puntosextra');
	
	
	//determinar ultima fecha jugado del torneo	
	$ultimaFecha	=	$this->traerUltimaFechaFixturePorTorneoEquipo($refTorneo, $idEquipo);
	
	$mod			= floor($ultimaFecha / $cantidadFechas );
	
	//return $mod;
	$puntos = 0;
	
	if (($mod > 0) and ($ultimaFecha >= $cantidadFechas)) {
		$puntos = 0;
		for ($i =1; $i <= $mod; $i++) {
			$calculo = "SELECT 
					(case when coalesce(SUM(sj.cantidad),0) > 0 then 0 else 1 end) AS amarillas 
				FROM
					dbfixture fix
						left join
					dbsancionesjugadores sj
					 ON sj.reffixture = fix.idfixture and (fix.refconectorlocal = ".$idEquipo." or fix.refconectorvisitante = ".$idEquipo.") and sj.refequipos = ".$idEquipo." and sj.reftiposanciones <> 1
						left JOIN
				tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
				where fix.reftorneos = ".$refTorneo." and fix.reffechas >= ".($cantidadFechas * ($i - 1))." and fix.reffechas <= ".($cantidadFechas * ($i));
			
			$resCalculo = $this->existeDevuelveId($calculo);
			if ($resCalculo > 0) {	
				$puntos += $puntosextra;	
			}
				
		}
		
		return $puntos;
				
	}
	
	return $puntos;	
	
	
}



function calcularPuntoBonus($refTorneo, $idEquipo) {
	$resPuntosBonus = $this->traerPuntobonusPorId(1);
	
	$cantidadFechas = (integer)mysql_result($resPuntosBonus,0,'cantidadfechas');
	
	$puntosextra	= (integer)mysql_result($resPuntosBonus,0,'puntosextra');
	
	
	//determinar ultima fecha jugado del torneo	
	$ultimaFecha	=	$this->traerUltimaFechaFixturePorTorneoEquipo($refTorneo, $idEquipo);
	

	
	//return $mod;
	
	
	if ($ultimaFecha >= 4) {
		

		$calculo = "SELECT 
				sum(coalesce(sj.cantidad,0)) AS amarillas , fix.reffechas
			FROM
				dbfixture fix
					left join
				dbsancionesjugadores sj
				 ON sj.reffixture = fix.idfixture and (fix.refconectorlocal = ".$idEquipo." or fix.refconectorvisitante = ".$idEquipo.") and sj.refequipos = ".$idEquipo." and sj.reftiposanciones <> 1
					left JOIN
			tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
			where fix.reftorneos = ".$refTorneo." and fix.reffechas <= ".$ultimaFecha." group by fix.reffechas order by fix.fecha";
		
		
		//return $calculo;
		$resCalcular = $this->query($calculo,0);
		$puntos = 0;
		$contador = 0;
		while ($rowC = mysql_fetch_array($resCalcular)) {
			if ($rowC['amarillas'] == 0) {
				$contador = $contador + 1;
			} else {
				$contador = 0;
			}
			
			if ($contador == 4) {
				$puntos = $puntos + 1;
				$contador = 0;
			}
		}
				
	}
	
	return $puntos;	
	
	
}


function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

function Posiciones($refTorneo) {
	$sql = "select

p.equipo,
sum(p.puntos) as puntos,
sum(p.goles) as goles,
sum(p.golescontra) as golescontra,
sum(p.pj) as pj,
sum(p.pg) as pg,
sum(p.pp) as pp,
sum(p.pe) as pe,
sum(p.amarillas) as amarillas,
sum(p.rojas) as rojas,
p.idequipo


from (
select
el.nombre as equipo,
f.puntoslocal as puntos,
ca.categoria,
arb.nombrecompleto as arbitro,
f.goleslocal as goles,
f.golesvisitantes as golescontra,
can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y') as fechajuego,
f.hora,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
count(el.idequipo) as pj,
sum(case when f.puntoslocal = 3 then 1 else 0 end) as pg,
sum(case when f.puntoslocal = 0 then 1 else 0 end) as pp,
sum(case when f.puntoslocal = 1 then 1 else 0 end) as pe,
sum(coalesce(fixa.amarillas,0)) as amarillas,
sum(coalesce(fixr.rojas,0)) as rojas,
el.idequipo    
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos

left join(SELECT 
			SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
		FROM
			dbsancionesjugadores sj
				INNER JOIN
			dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorlocal = sj.refequipos
				INNER JOIN
		tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
		where ts.amonestacion = 1 and (sj.refsancionesfallos is null or sj.refsancionesfallos = 0)
		GROUP BY fix.idfixture, sj.refequipos) fixa
on		fixa.idfixture = f.idfixture and fixa.refequipos = el.idequipo

left join(SELECT 
			SUM(sj.cantidad) AS rojas, fix.idfixture, sj.refequipos
		FROM
			dbsancionesjugadores sj
				INNER JOIN
			dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorlocal = sj.refequipos
				INNER JOIN
		tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
		where ts.expulsion = 1
		GROUP BY fix.idfixture, sj.refequipos) fixr
on		fixr.idfixture = f.idfixture and fixr.refequipos = el.idequipo

where tor.idtorneo = ".$refTorneo."
group by el.nombre,
            f.puntoslocal,
            ca.categoria,
            arb.nombrecompleto,
            f.goleslocal,
			f.golesvisitantes,
            can.nombre,
            fec.fecha,
            f.fecha,
            f.hora,
            f.calificacioncancha,
            f.juez1,
            f.juez2,
            f.observaciones,
            f.publicar,
			el.idequipo 

union all

select

ev.nombre as equipo,
f.puntosvisita as puntos,
ca.categoria,
arb.nombrecompleto as arbitro,
f.golesvisitantes as goles,
f.goleslocal as golescontra,
can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y') as fechajuego,
f.hora,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
count(ev.idequipo) as pj,
sum(case when f.puntosvisita = 3 then 1 else 0 end) as pg,
sum(case when f.puntosvisita = 0 then 1 else 0 end) as pp,
sum(case when f.puntosvisita = 1 then 1 else 0 end) as pe,
sum(coalesce(fixa.amarillas,0)) as amarillas,
sum(coalesce(fixr.rojas,0)) as rojas,
ev.idequipo    
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos

left join(SELECT 
			SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
		FROM
			dbsancionesjugadores sj
				INNER JOIN
			dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorvisitante = sj.refequipos
				INNER JOIN
		tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
		where ts.amonestacion = 1 and (sj.refsancionesfallos is null or sj.refsancionesfallos = 0)
		GROUP BY fix.idfixture, sj.refequipos) fixa
on		fixa.idfixture = f.idfixture and fixa.refequipos = ev.idequipo

left join(SELECT 
			SUM(sj.cantidad) AS rojas, fix.idfixture, sj.refequipos
		FROM
			dbsancionesjugadores sj
				INNER JOIN
			dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorvisitante = sj.refequipos
				INNER JOIN
		tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
		where ts.expulsion = 1
		GROUP BY fix.idfixture, sj.refequipos) fixr
on		fixr.idfixture = f.idfixture and fixr.refequipos = ev.idequipo

where tor.idtorneo = ".$refTorneo."
group by ev.nombre,
            f.puntosvisita,
            ca.categoria,
            arb.nombrecompleto,
            f.golesvisitantes,
			f.goleslocal,
            can.nombre,
            fec.fecha,
            f.fecha,
            f.hora,
            f.calificacioncancha,
            f.juez1,
            f.juez2,
            f.observaciones,
            f.publicar,
			ev.idequipo
) p
group by p.equipo, p.idequipo
order by sum(p.puntos) desc, sum(p.rojas) asc, sum(p.amarillas) asc

";	
	$res = $this->query($sql,0);
	
	$arPosiciones = array();
	
	$puntosBonus = 0;
	
	$resPuntosBonus	=	$this->traerTorneopuntobonusPorTorneo($refTorneo);
	
	
	while ($row = mysql_fetch_array($res)) {
		$puntosBonus = 0;
		if (mysql_num_rows($resPuntosBonus)>0) {
			$puntosBonus = $this->calcularPuntoBonus($refTorneo, $row['idequipo']);	
		}
		$arPosiciones[] = array('equipo'=> $row['equipo'],
							  'puntos'=> (integer)$row['puntos'] + (integer)$puntosBonus,
							  'goles'=> $row['goles'],
							  'golescontra'=> $row['golescontra'],
							  'pj'=> $row['pj'],
							  'pg'=> $row['pg'],
							  'pp'=> $row['pp'],
							  'pe'=> $row['pe'],
							  'amarillas'=> $row['amarillas'],
							  'rojas'=> $row['rojas'],
							  'puntobonus'=> (integer)$puntosBonus,
							  'idequipo'=> $row['idequipo']);
							  
		$puntosBonus = 0;					  
	}

	$sorted = $this->array_orderby($arPosiciones, 'puntos', SORT_DESC, 'rojas', SORT_ASC, 'amarillas', SORT_ASC);

	return $sorted;

}


function PosicionesSinPuntosBonus($refTorneo) {
	$sql = "select

p.equipo,
sum(p.puntos) as puntos,
sum(p.goles) as goles,
sum(p.golescontra) as golescontra,
sum(p.pj) as pj,
sum(p.pg) as pg,
sum(p.pp) as pp,
sum(p.pe) as pe,
sum(p.amarillas) as amarillas,
sum(p.rojas) as rojas,
p.idequipo


from (
select
el.nombre as equipo,
f.puntoslocal as puntos,
ca.categoria,
arb.nombrecompleto as arbitro,
f.goleslocal as goles,
f.golesvisitantes as golescontra,
can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y') as fechajuego,
f.hora,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
count(el.idequipo) as pj,
sum(case when f.puntoslocal = 3 then 1 else 0 end) as pg,
sum(case when f.puntoslocal = 0 then 1 else 0 end) as pp,
sum(case when f.puntoslocal = 1 then 1 else 0 end) as pe,
sum(coalesce(fixa.amarillas,0)) as amarillas,
sum(coalesce(fixr.rojas,0)) as rojas,
el.idequipo    
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos

left join(SELECT 
			SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
		FROM
			dbsancionesjugadores sj
				INNER JOIN
			dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorlocal = sj.refequipos
				INNER JOIN
		tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
		where ts.amonestacion = 1 and (sj.refsancionesfallos is null or sj.refsancionesfallos = 0)
		GROUP BY fix.idfixture, sj.refequipos) fixa
on		fixa.idfixture = f.idfixture and fixa.refequipos = el.idequipo

left join(SELECT 
			SUM(sj.cantidad) AS rojas, fix.idfixture, sj.refequipos
		FROM
			dbsancionesjugadores sj
				INNER JOIN
			dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorlocal = sj.refequipos
				INNER JOIN
		tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
		where ts.expulsion = 1
		GROUP BY fix.idfixture, sj.refequipos) fixr
on		fixr.idfixture = f.idfixture and fixr.refequipos = el.idequipo

where tor.idtorneo = ".$refTorneo."
group by el.nombre,
            f.puntoslocal,
            ca.categoria,
            arb.nombrecompleto,
            f.goleslocal,
			f.golesvisitantes,
            can.nombre,
            fec.fecha,
            f.fecha,
            f.hora,
            f.calificacioncancha,
            f.juez1,
            f.juez2,
            f.observaciones,
            f.publicar,
			el.idequipo 

union all

select

ev.nombre as equipo,
f.puntosvisita as puntos,
ca.categoria,
arb.nombrecompleto as arbitro,
f.golesvisitantes as goles,
f.goleslocal as golescontra,
can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y') as fechajuego,
f.hora,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
count(ev.idequipo) as pj,
sum(case when f.puntosvisita = 3 then 1 else 0 end) as pg,
sum(case when f.puntosvisita = 0 then 1 else 0 end) as pp,
sum(case when f.puntosvisita = 1 then 1 else 0 end) as pe,
sum(coalesce(fixa.amarillas,0)) as amarillas,
sum(coalesce(fixr.rojas,0)) as rojas,
ev.idequipo    
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos

left join(SELECT 
			SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
		FROM
			dbsancionesjugadores sj
				INNER JOIN
			dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorvisitante = sj.refequipos
				INNER JOIN
		tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
		where ts.amonestacion = 1 and (sj.refsancionesfallos is null or sj.refsancionesfallos = 0)
		GROUP BY fix.idfixture, sj.refequipos) fixa
on		fixa.idfixture = f.idfixture and fixa.refequipos = ev.idequipo

left join(SELECT 
			SUM(sj.cantidad) AS rojas, fix.idfixture, sj.refequipos
		FROM
			dbsancionesjugadores sj
				INNER JOIN
			dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorvisitante = sj.refequipos
				INNER JOIN
		tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
		where ts.expulsion = 1
		GROUP BY fix.idfixture, sj.refequipos) fixr
on		fixr.idfixture = f.idfixture and fixr.refequipos = ev.idequipo

where tor.idtorneo = ".$refTorneo."
group by ev.nombre,
            f.puntosvisita,
            ca.categoria,
            arb.nombrecompleto,
            f.golesvisitantes,
			f.goleslocal,
            can.nombre,
            fec.fecha,
            f.fecha,
            f.hora,
            f.calificacioncancha,
            f.juez1,
            f.juez2,
            f.observaciones,
            f.publicar,
			ev.idequipo
) p
group by p.equipo, p.idequipo
order by sum(p.puntos) desc, sum(p.rojas) asc, sum(p.amarillas) asc

";	
	$res = $this->query($sql,0);

	return $res;

}



function PosicionesConformada($idTemporada, $idCategoria, $idDivision) {
	
	$sql = "select idtorneo from dbtorneos where reftemporadas =".$idTemporada." and refcategorias = ".$idCategoria." and refdivisiones = ".$idDivision." and acumulatablaconformada = 1";
	
	$resConformada = $this->query($sql,0);
	
	$lstPosiciones = array();
	
	$lstPosicionesFinal = array();
	
	while ($rowT = mysql_fetch_array($resConformada)) {
	
		$arPosiciones = $this->Posiciones($rowT['idtorneo']);
		
		foreach ($arPosiciones as $valorT) {
			
			$lstPosiciones[] = array('equipo'=> $valorT['equipo'],
								  'puntos'=> (integer)$valorT['puntos'],
								  'goles'=> $valorT['goles'],
								  'golescontra'=> $valorT['golescontra'],
								  'pj'=> $valorT['pj'],
								  'pg'=> $valorT['pg'],
								  'pp'=> $valorT['pp'],
								  'pe'=> $valorT['pe'],
								  'amarillas'=> $valorT['amarillas'],
								  'rojas'=> $valorT['rojas'],
								  'puntobonus'=> (integer)$valorT['puntobonus'],
							  	  'idequipo'=> $valorT['idequipo']);
													  
		}

	
	}
	
	$sorted = $this->array_orderby($lstPosiciones, 'idequipo', SORT_ASC);
	
	$cambio = 0;
	$primero = 0;
	
	$equipo		= '';
	$puntos 	= 0;
	$goles		= 0;
	$pj			= 0;
	$pg			= 0;
	$pp			= 0;
	$pe			= 0;
	$amarillas	= 0;
	$rojas		= 0;
	$puntobonus = 0;

	foreach ($sorted as $tblFinal) {
		if ($cambio != $tblFinal['idequipo']) {
			if ($primero != 0) {
				$lstPosicionesFinal[] = array('equipo'=> $equipo,
								  'puntos'=> $puntos,
								  'goles'=> $goles,
								  'golescontra'=> $valorT['golescontra'],
								  'pj'=> $pj,
								  'pg'=> $pg,
								  'pp'=> $pp,
								  'pe'=> $pe,
								  'amarillas'=> $amarillas,
								  'rojas'=> $rojas,
								  'puntobonus'=> $puntobonus);
			}
			
			$cambio = $tblFinal['idequipo'];
			
			$equipo		= '';
			$puntos 	= 0;
			$goles		= 0;
			$pj			= 0;
			$pg			= 0;
			$pp			= 0;
			$pe			= 0;
			$amarillas	= 0;
			$rojas		= 0;
			$puntobonus = 0;
		}
		
		$equipo 	= $tblFinal['equipo'];
		$puntos	    += (integer)$tblFinal['puntos'];
		$goles	    += (integer)$tblFinal['goles'];
		$golescontra+= (integer)$tblFinal['golescontra'];
		$pj	   		+= (integer)$tblFinal['pj'];
		$pg	   		+= (integer)$tblFinal['pg'];
		$pp	   		+= (integer)$tblFinal['pp'];
		$pe	   		+= (integer)$tblFinal['pe'];
		$amarillas	+= (integer)$tblFinal['amarillas'];
		$rojas	    += (integer)$tblFinal['rojas'];
		$puntobonus	+= (integer)$tblFinal['puntobonus'];
		
		$primero = 1;
		 
	}
	
	
	$sorted = $this->array_orderby($lstPosicionesFinal, 'puntos', SORT_DESC, 'rojas', SORT_ASC, 'amarillas', SORT_ASC);

	return $sorted;

}



function Goleadores($idTorneo) {
	$sql = "select
			t.equipo, t.apyn, t.nrodocumento, sum(t.goles) as goles
			from (
				select
				 el.nombre as equipo, concat(j.apellido, ', ', j.nombres) as apyn, j.nrodocumento, sum(g.goles) as goles
				from		dbgoleadores g
				inner
				join		dbfixture fix
				on			g.reffixture = fix.idfixture
				inner
				join		dbtorneos t
				on			t.idtorneo = fix.reftorneos
				inner 
				join 		dbequipos el 
				ON 			el.idequipo = fix.refconectorlocal and g.refequipos = fix.refconectorlocal
				/*
				inner
				join		dbconector co
				on			co.refequipos = f.refconectorlocal and co.refcategorias = t.refcategorias and co.refjugadores = g.refjugadores
				*/
				inner
				join		dbjugadores j
				on			j.idjugador = g.refjugadores
				where		t.idtorneo = ".$idTorneo." and g.goles > 0
				group by el.nombre , j.apellido, j.nombres, j.nrodocumento
				
				union all
				
				
				select
				 el.nombre as equipo, concat(j.apellido, ', ', j.nombres) as apyn, j.nrodocumento, sum(g.goles) as goles
				from		dbgoleadores g
				inner
				join		dbfixture fix
				on			g.reffixture = fix.idfixture
				inner
				join		dbtorneos t
				on			t.idtorneo = fix.reftorneos
				inner 
				join 		dbequipos el 
				ON 			el.idequipo = fix.refconectorvisitante and g.refequipos = fix.refconectorvisitante
				/*
				inner
				join		dbconector co
				on			co.refequipos = f.refconectorlocal and co.refcategorias = t.refcategorias and co.refjugadores = g.refjugadores
				*/
				inner
				join		dbjugadores j
				on			j.idjugador = g.refjugadores
				where		t.idtorneo = ".$idTorneo." and g.goles > 0
				group by el.nombre , j.apellido, j.nombres, j.nrodocumento
				
				UNION ALL 
				SELECT 
					el.nombre AS equipo,
						CONCAT(j.apellido, ', ', j.nombres) AS apyn,
						j.nrodocumento,
						SUM(g.penalconvertido) AS goles
				FROM
					dbpenalesjugadores g
				INNER JOIN dbfixture fix ON g.reffixture = fix.idfixture
				INNER JOIN dbtorneos t ON t.idtorneo = fix.reftorneos
				INNER JOIN dbequipos el ON el.idequipo = fix.refconectorvisitante
					AND g.refequipos = fix.refconectorvisitante
				INNER JOIN dbjugadores j ON j.idjugador = g.refjugadores
				WHERE
					t.idtorneo = ".$idTorneo."
						AND g.penalconvertido > 0
				GROUP BY el.nombre , j.apellido , j.nombres , j.nrodocumento
				
				
				UNION ALL 
				SELECT 
					el.nombre AS equipo,
						CONCAT(j.apellido, ', ', j.nombres) AS apyn,
						j.nrodocumento,
						SUM(g.penalconvertido) AS goles
				FROM
					dbpenalesjugadores g
				INNER JOIN dbfixture fix ON g.reffixture = fix.idfixture
				INNER JOIN dbtorneos t ON t.idtorneo = fix.reftorneos
				INNER JOIN dbequipos el ON el.idequipo = fix.refconectorlocal
					AND g.refequipos = fix.refconectorlocal
				INNER JOIN dbjugadores j ON j.idjugador = g.refjugadores
				WHERE
					t.idtorneo = ".$idTorneo."
						AND g.penalconvertido > 0
				GROUP BY el.nombre , j.apellido , j.nombres , j.nrodocumento
			) t
				group by t.equipo, t.apyn, t.nrodocumento
				order by sum(t.goles) desc, t.apyn";	
				
	$res = $this->query($sql,0);
	return $res;
}


function GoleadoresConformada($idTemporada, $idCategoria, $idDivision) {
	
	$sql = "select
			t.equipo, t.apyn, t.nrodocumento, sum(t.goles) as goles
			from (
				select
				 el.nombre as equipo, concat(j.apellido, ', ', j.nombres) as apyn, j.nrodocumento, sum(g.goles) as goles
				from		dbgoleadores g
				inner
				join		dbfixture fix
				on			g.reffixture = fix.idfixture
				inner
				join		dbtorneos t
				on			t.idtorneo = fix.reftorneos
				inner 
				join 		dbequipos el 
				ON 			el.idequipo = fix.refconectorlocal and g.refequipos = fix.refconectorlocal
				/*
				inner
				join		dbconector co
				on			co.refequipos = f.refconectorlocal and co.refcategorias = t.refcategorias and co.refjugadores = g.refjugadores
				*/
				inner
				join		dbjugadores j
				on			j.idjugador = g.refjugadores
				where		t.reftemporadas =".$idTemporada." and t.refcategorias = ".$idCategoria." and t.refdivisiones = ".$idDivision." and t.acumulagoleadores = 1 and g.goles > 0
				group by el.nombre , j.apellido, j.nombres, j.nrodocumento
				
				union all
				
				
				select
				 el.nombre as equipo, concat(j.apellido, ', ', j.nombres) as apyn, j.nrodocumento, sum(g.goles) as goles
				from		dbgoleadores g
				inner
				join		dbfixture fix
				on			g.reffixture = fix.idfixture
				inner
				join		dbtorneos t
				on			t.idtorneo = fix.reftorneos
				inner 
				join 		dbequipos el 
				ON 			el.idequipo = fix.refconectorvisitante and g.refequipos = fix.refconectorvisitante
				/*
				inner
				join		dbconector co
				on			co.refequipos = f.refconectorlocal and co.refcategorias = t.refcategorias and co.refjugadores = g.refjugadores
				*/
				inner
				join		dbjugadores j
				on			j.idjugador = g.refjugadores
				where		t.reftemporadas =".$idTemporada." and t.refcategorias = ".$idCategoria." and t.refdivisiones = ".$idDivision." and t.acumulagoleadores = 1 and g.goles > 0
				group by el.nombre , j.apellido, j.nombres, j.nrodocumento
				
				UNION ALL 
				SELECT 
					el.nombre AS equipo,
						CONCAT(j.apellido, ', ', j.nombres) AS apyn,
						j.nrodocumento,
						SUM(g.penalconvertido) AS goles
				FROM
					dbpenalesjugadores g
				INNER JOIN dbfixture fix ON g.reffixture = fix.idfixture
				INNER JOIN dbtorneos t ON t.idtorneo = fix.reftorneos
				INNER JOIN dbequipos el ON el.idequipo = fix.refconectorvisitante
					AND g.refequipos = fix.refconectorvisitante
				INNER JOIN dbjugadores j ON j.idjugador = g.refjugadores
				WHERE
					t.reftemporadas =".$idTemporada." and t.refcategorias = ".$idCategoria." and t.refdivisiones = ".$idDivision." and t.acumulagoleadores = 1 AND g.penalconvertido > 0
				GROUP BY el.nombre , j.apellido , j.nombres , j.nrodocumento
				
				
				UNION ALL 
				SELECT 
					el.nombre AS equipo,
						CONCAT(j.apellido, ', ', j.nombres) AS apyn,
						j.nrodocumento,
						SUM(g.penalconvertido) AS goles
				FROM
					dbpenalesjugadores g
				INNER JOIN dbfixture fix ON g.reffixture = fix.idfixture
				INNER JOIN dbtorneos t ON t.idtorneo = fix.reftorneos
				INNER JOIN dbequipos el ON el.idequipo = fix.refconectorlocal
					AND g.refequipos = fix.refconectorlocal
				INNER JOIN dbjugadores j ON j.idjugador = g.refjugadores
				WHERE
					t.reftemporadas =".$idTemporada." and t.refcategorias = ".$idCategoria." and t.refdivisiones = ".$idDivision." and t.acumulagoleadores = 1 AND g.penalconvertido > 0
				GROUP BY el.nombre , j.apellido , j.nombres , j.nrodocumento
			) t
				group by t.equipo, t.apyn, t.nrodocumento
				order by sum(t.goles) desc, t.apyn";	
				
	$res = $this->query($sql,0);
	return $res;
}



function suspendidosTotal() {

	$sql = "select
				r.nombre,
			    r.nrodocumento,
			    r.apyn,
			    r.torneos,
			    r.idfixture,
			    r.equipos,
			    r.fecha,
			    r.cantidadfechas,
			    r.dias,
			    r.cumplidas,
				r.fechascumplidas,
			    r.categoria
			from (
			SELECT 
			    cc.nombre,
			    j.nrodocumento,
			    CONCAT(j.apellido, ', ', j.nombres) AS apyn,
			    CONCAT(tt.temporada,
			            ' ',
			            ca.categoria,
			            ' ',
			            di.division,
			            ' ',
			            t.descripcion) AS torneos,
			    fix.idfixture,        
			    CONCAT('(', e.idequipo, ') ', e.nombre) AS equipos,
			    sj.fecha,
			    sf.cantidadfechas,
			    coalesce((case when cantidadfechas < 1 then -1 * datediff(sf.fechadesde, sf.fechahasta) end),0) as dias,
			    coalesce((case when cantidadfechas > 0 then spp.cumplidas
					  when year(sf.fechadesde) > 1950 then -1 * datediff(sf.fechadesde, now())
			        end),0) cumplidas,
				sf.fechascumplidas,
			    ca.categoria
			FROM
			    dbsancionesfallos sf
			        INNER JOIN
			    dbsancionesjugadores sj ON sf.refsancionesjugadores = sj.idsancionjugador
			        INNER JOIN
			    dbequipos e ON e.idequipo = sj.refequipos
			        INNER JOIN
			    dbfixture fix ON fix.idfixture = sj.reffixture
			        INNER JOIN
			    dbjugadores j ON j.idjugador = sj.refjugadores
			        INNER JOIN
			    dbcountries cc ON cc.idcountrie = j.refcountries
			        INNER JOIN
			    dbtorneos t ON t.idtorneo = fix.reftorneos
			        INNER JOIN
			    tbtemporadas tt ON t.reftemporadas = tt.idtemporadas
			        INNER JOIN
			    tbcategorias ca ON ca.idtcategoria = t.refcategorias
			        INNER JOIN
			    tbdivisiones di ON di.iddivision = t.refdivisiones
					left join
				(select count(ss.reffixture) as cumplidas, ss.refjugadores, ss.refsancionesfallos, tt.refcategorias 
						from dbsancionesfechascumplidas ss
							inner join dbfixture ff ON ff.idfixture = ss.reffixture
			                inner join dbtorneos tt ON tt.idtorneo = ff.reftorneos
						group by ss.refjugadores, ss.refsancionesfallos, tt.refcategorias) spp 
				ON sj.refjugadores = spp.refjugadores and spp.refsancionesfallos = sf.idsancionfallo and spp.refcategorias = sj.refcategorias
			            
			WHERE
			    sf.cantidadfechas <> sf.fechascumplidas
			        OR (sf.fechahasta >= NOW()
			        AND sf.fechadesde <> '1900-01-01')

			union all
			        
			SELECT 
			    cc.nombre,
			    j.nrodocumento,
			    CONCAT(j.apellido, ', ', j.nombres) AS apyn,
			    CONCAT(tt.temporada,
			            ' ',
			            ca.categoria,
			            ' ',
			            di.division,
			            ' ',
			            t.descripcion) AS torneos,
			    fix.idfixture,        
			    CONCAT('(', e.idequipo, ') ', e.nombre) AS equipos,
			    sj.fecha,
			    sf.cantidadfechas,
			    0 as dias,
			    sf.fechascumplidas cumplidas,
				sf.fechascumplidas,
			    ca.categoria
			FROM
			    dbsancionesfallosacumuladas sf
			        INNER JOIN
			    dbsancionesjugadores sj ON sf.refsancionesjugadores = sj.idsancionjugador
			        INNER JOIN
			    dbequipos e ON e.idequipo = sj.refequipos
			        INNER JOIN
			    dbfixture fix ON fix.idfixture = sj.reffixture
			        INNER JOIN
			    dbjugadores j ON j.idjugador = sj.refjugadores
			        INNER JOIN
			    dbcountries cc ON cc.idcountrie = j.refcountries
			        INNER JOIN
			    dbtorneos t ON t.idtorneo = fix.reftorneos
			        INNER JOIN
			    tbtemporadas tt ON t.reftemporadas = tt.idtemporadas
			        INNER JOIN
			    tbcategorias ca ON ca.idtcategoria = t.refcategorias
			        INNER JOIN
			    tbdivisiones di ON di.iddivision = t.refdivisiones
			            
			WHERE
			    sf.cantidadfechas <> sf.fechascumplidas  
			    ) r
			order by r.apyn

			";

	$res = $this->query($sql,0);
	return $res;
}


function traerProximaFechaTodos() {
	
	$resTemporadas = $this->traerUltimaTemporada();	

	if (mysql_num_rows($resTemporadas)>0) {
		$ultimaTemporada = mysql_result($resTemporadas,0,0);	
	} else {
		$ultimaTemporada = 0;	
	}

	$sql = "select

			fix.idfixture,
			cat.categoria,
			di.division,
			tor.descripcion as torneo,
			(select el.nombre from dbequipos el where el.idequipo = fix.refconectorlocal) as equipoLocal,
			(select el.nombre from dbequipos el where el.idequipo = fix.refconectorlocal) as equipoVisitante,
			cc.nombre,
			dia.dia,
			dct.hora,
			cc.nombre as cancha,
			f.fecha,
			fix.fecha as fechajuego,
			f.idfecha,
			coalesce(arr.idarbitro,0) as idarbitro,
			coalesce(arr.nombrecompleto,'') as arbitro
		from dbfixture fix 
		inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
		inner join tbcategorias cat ON cat.idtcategoria = tor.refcategorias
		inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
		inner join tbfechas fe ON fe.idfecha = fix.reffechas 
		left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
		inner join dbequipos equ ON equ.idequipo = fix.refconectorlocal
		left join tbcanchas cc ON cc.idcancha = fix.refcanchas
		inner join dbdefinicionescategoriastemporadas dct ON dct.refcategorias = tor.refcategorias and dct.reftemporadas = tor.reftemporadas
		inner join tbdias dia ON dia.iddia = dct.refdias
		left join dbarbitros arr ON arr.idarbitro = fix.refarbitros
		inner join tbfechas f ON f.idfecha = fix.reffechas
		
		inner join (select
		
				cat.idtcategoria,
				di.iddivision,
				tor.idtorneo,
				min(f.idfecha) as idfecha
				from dbfixture fix 
				inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
				inner join tbcategorias cat ON cat.idtcategoria = tor.refcategorias
				inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
				inner join tbfechas fe ON fe.idfecha = fix.reffechas 
				left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
				inner join dbequipos equ ON equ.idequipo = fix.refconectorlocal
				left join tbcanchas cc ON cc.idcancha = fix.refcanchas
				inner join dbdefinicionescategoriastemporadas dct ON dct.refcategorias = tor.refcategorias and dct.reftemporadas = tor.reftemporadas
				inner join tbdias dia ON dia.iddia = dct.refdias
				inner join tbfechas f ON f.idfecha = fix.reffechas
				where fix.refestadospartidos is null and tor.reftipotorneo in (1,2) and tor.reftemporadas = ".$ultimaTemporada."
				group by cat.idtcategoria, di.iddivision, tor.idtorneo) sig 
				ON sig.idtcategoria = tor.refcategorias
					and sig.iddivision = tor.refdivisiones
					and sig.idtorneo = tor.idtorneo
					and sig.idfecha = fix.reffechas
		
		where fix.refestadospartidos is null and tor.reftipotorneo in (1,2) and tor.reftemporadas = ".$ultimaTemporada."
		order by tor.refcategorias, tor.refdivisiones, f.idfecha
		";	
		
	
	$res = $this->query($sql,0);
	return $res;
}


function traerProximaFechaDesdeHasta() {
	
	$resTemporadas = $this->traerUltimaTemporada();	

	if (mysql_num_rows($resTemporadas)>0) {
		$ultimaTemporada = mysql_result($resTemporadas,0,0);	
	} else {
		$ultimaTemporada = 0;	
	}

	$sql = "select

			min(fix.fecha) as fechajuegodesde,
			max(fix.fecha) as fechajuegohasta
		from dbfixture fix 
		inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
		inner join tbcategorias cat ON cat.idtcategoria = tor.refcategorias
		inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
		inner join tbfechas fe ON fe.idfecha = fix.reffechas 
		left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
		inner join dbequipos equ ON equ.idequipo = fix.refconectorlocal
		left join tbcanchas cc ON cc.idcancha = fix.refcanchas
		inner join dbdefinicionescategoriastemporadas dct ON dct.refcategorias = tor.refcategorias and dct.reftemporadas = tor.reftemporadas
		inner join tbdias dia ON dia.iddia = dct.refdias
		inner join tbfechas f ON f.idfecha = fix.reffechas
		
		inner join (select
		
				cat.idtcategoria,
				di.iddivision,
				tor.idtorneo,
				min(f.idfecha) as idfecha
				from dbfixture fix 
				inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
				inner join tbcategorias cat ON cat.idtcategoria = tor.refcategorias
				inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
				inner join tbfechas fe ON fe.idfecha = fix.reffechas 
				left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
				inner join dbequipos equ ON equ.idequipo = fix.refconectorlocal
				left join tbcanchas cc ON cc.idcancha = fix.refcanchas
				inner join dbdefinicionescategoriastemporadas dct ON dct.refcategorias = tor.refcategorias and dct.reftemporadas = tor.reftemporadas
				inner join tbdias dia ON dia.iddia = dct.refdias
				inner join tbfechas f ON f.idfecha = fix.reffechas
				where fix.refestadospartidos is null and tor.reftipotorneo in (1,2) and tor.reftemporadas = ".$ultimaTemporada."
				group by cat.idtcategoria, di.iddivision, tor.idtorneo) sig 
				ON sig.idtcategoria = tor.refcategorias
					and sig.iddivision = tor.refdivisiones
					and sig.idtorneo = tor.idtorneo
					and sig.idfecha = fix.reffechas
		
		where fix.refestadospartidos is null and tor.reftipotorneo in (1,2) and tor.reftemporadas = ".$ultimaTemporada."
		order by tor.refcategorias, tor.refdivisiones, f.idfecha";	
		
	
	$res = $this->query($sql,0);
	return $res;
}


function traerPlanillas($idTorneo, $refFechas) {
	$sql	=	"";
	
	$res = $this->traerFixtureTodoPorTorneoFecha($idTorneo, $refFechas);
	return $res;	
}

function traerFechasPorTorneoJugadas($idTorneo) {
	$sql	=	"select * from		
				 dbfixture f 
				 inner join		tbestadospartidos es on es.idestadopartido = f.refestadospartidos
				 where reftorneos = ".$idTorneo."
				 	   and defautomatica = 0
					   and goleslocalauto = 0
					   and golesvisitanteauto = 0
					   and puntoslocal = 0
					   and puntosvisitante = 0
					   and finalizado = 0
				 order by reffechas";	
	$res = $this->query($sql,0);
	return $res;
}

//esta funcion me devuelve la fecha en la cual fue fallada la suspencion, no donde fue cumplida.
function ultimaFechaSancionadoPorAcumulacionAmarillasFallada($idTorneo, $idJugador, $idTipoTorneo) {
	$sql	=	"select
					max(ms.amarillas) as amarillas
				from		dbsancionesjugadores sj
				inner
				join		dbsancionesfallos sf
				on			sj.refsancionesfallos = sf.idsancionfallo
				inner
				join		dbfixture fix
				on			fix.idfixture = sj.reffixture
				inner
                join		dbsancionesfallosacumuladas ms
                on			ms.refsancionesjugadores = sj.idsancionjugador
                inner
                join		dbsancionesfechascumplidas sc
                on			sc.refsancionesfallosacumuladas = ms.idsancionfalloacumuladas
                inner
				join		dbfixture fixc
				on			fixc.idfixture = sc.reffixture
				inner
				join		dbtorneos tor
				on			tor.idtorneo = fix.reftorneos and tor.reftipotorneo = ".$idTipoTorneo."
				where		ms.generadaporacumulacion = 1 
							and ms.fechascumplidas = 1
							and sj.refjugadores = ".$idJugador."
							and fix.reftorneos = ".(integer)$idTorneo." ";
								
	return $this->existeDevuelveId($sql);
}

// esta funcion me devuelve donde fue sancionado por ultima vez
function ultimaFechaSancionadoPorAcumulacionAmarillas($idTorneo, $idJugador, $idTipoTorneo) {
	$sql	=	"select
					max(fixc.reffechas) as reffechas
				from		dbsancionesjugadores sj
				inner
				join		dbfixture fix
				on			fix.idfixture = sj.reffixture
				inner
                join		dbsancionesfallosacumuladas ms
                on			ms.refsancionesjugadores = sj.idsancionjugador
                inner
                join		dbsancionesfechascumplidas sc
                on			sc.refsancionesfallosacumuladas = ms.idsancionfalloacumuladas
                inner
				join		dbfixture fixc
				on			fixc.idfixture = sc.reffixture
				inner
				join		dbtorneos tor
				on			tor.idtorneo = fix.reftorneos and tor.reftipotorneo = ".$idTipoTorneo."
				where		ms.generadaporacumulacion = 1 
							and ms.fechascumplidas = 1
							and sj.refjugadores = ".$idJugador."
							and fix.reftorneos = ".(integer)$idTorneo." ";
								
	return $this->existeDevuelveId($sql);
}

function ultimaFechaSancionadoPorCantidadFechas($idJugador) {
	$sql	=	"select
					max(ms.reffechas) as reffechas
				from		dbsancionesjugadores sj
				inner
				join		dbsancionesfallos sf
				on			sj.refsancionesfallos = sf.idsancionfallo
				inner
				join		dbfixture fix
				on			fix.idfixture = sj.reffixture
				inner
				join		dbtorneos t
				on			t.idtorneo = fix.reftorneos
				inner
                join		dbmovimientosanciones ms
                on			ms.refsancionesjugadores = sj.idsancionjugador
				where		sf.generadaporacumulacion = 0 
							and ms.fechascumplidas = 0
							and t.activo = 1
							and sj.refjugadores = ".$idJugador;
								
	return $this->existeDevuelveId($sql);
}

//calculo para acumulacion de amarillas
function traerAmarillasAcumuladas($idTorneo, $idJugador, $refFecha, $idTipoTorneo) {
	$ultimaFecha = $this->ultimaFechaSancionadoPorAcumulacionAmarillas($idTorneo, $idJugador, $idTipoTorneo);

	if ($ultimaFecha == 0) {
		$reffechaDesde = 0;	
		$restoAmarillas = 0;
	} else {
		$reffechaDesde = $ultimaFecha;
		
		//calculo para vaeriguar si sobra una amarilla de la ultima sancion
		$restoAmarillas = (integer)$this->ultimaFechaSancionadoPorAcumulacionAmarillasFallada($idTorneo, $idJugador, $idTipoTorneo) - 1;
	}
	
	$sql = "select
				sum(coalesce((cantidad),0)) + ".$restoAmarillas." as cantidad
			from (
				select
					1 as cantidad
				from		dbsancionesjugadores sj
				inner
				join		dbfixture fix
				on			fix.idfixture = sj.reffixture and fix.reffechas > ".$reffechaDesde." and sj.refjugadores = ".$idJugador."
				inner
				join		tbtiposanciones ts
				on			ts.idtiposancion = sj.reftiposanciones
				inner
				join		dbtorneos t
				on			t.idtorneo = ".$idTorneo." and sj.refcategorias = t.refcategorias and t.idtorneo = fix.reftorneos and t.reftipotorneo = ".$idTipoTorneo."
				where		ts.amonestacion = 1
							and sj.cantidad > 0
							
				union all
			
				select
					2 as cantidad
				from		dbsancionesjugadores sj
				inner
				join		dbsancionesfallos sf
				on			sj.refsancionesfallos = sf.idsancionfallo and sj.refjugadores = ".$idJugador."
				inner
				join		dbfixture fix
				on			fix.idfixture = sj.reffixture and fix.reffechas > ".$reffechaDesde."
				inner
				join		dbtorneos t
				on			t.idtorneo = ".$idTorneo." and sj.refcategorias = t.refcategorias and t.idtorneo = fix.reftorneos and t.reftipotorneo = ".$idTipoTorneo."
				where		sj.reftiposanciones = 4 or sf.amarillas = 2
							
				) t";	
	
	$res = $this->query($sql,0);
	
	if (mysql_num_rows($res)>0) {
		return mysql_result($res,0,0);	
	}
	return 0;
}

function sancionarPorAmarillasAcumuladas($idTorneo, $idJugador, $refFecha,$idFixture, $refequipos, $fecha,$refcategorias,$refdivisiones, $refSancionJugadores,$cantidadAmarillas) {

	//$cantidadAmarillas	=	$this->traerAmarillasAcumuladas($idTorneo, $idJugador, $refFecha);
	//$fechaNueva = (integer)$refFecha + 1;
	if ($cantidadAmarillas >=  5) {
		//determino si la fecha a sancionar ya fue sancionada
		$existe = $this->traerSancionesfallosacumuladasPorIdSancionJugador($refSancionJugadores);
		if (mysql_num_rows($existe)<1) {
			$fallo = $this->insertarSancionesfallosacumuladas($refSancionJugadores,1,'0000-00-00','0000-00-00',1,0,0,0,1,utf8_decode('Acumulación de la 5 amarilla'));
		}
		
		//determino si la fecha a sancionar ya fue sancionada
		//$exiteFechas = $this->existeMovimientoEnFechaPorCantidadFecha($refFecha+1, $idJugador);
		
		//busco la ultima fecha en caso de ser correcto
		//if (mysql_num_rows($exiteFechas)>0) {
		//	$reffechaNueva = $this->ultimaFechaSancionadoPorCantidadFechas($idJugador);
		//	if ($reffechaNueva >0) {
		//		$fechaNueva = $reffechaNueva + 1;
		//	}
		//}
		//inserto el movimiento con el orden 2, el orden 1 es para las expulsiones
		//$this->insertarMovimientosanciones($refSancionJugadores, $fechaNueva, $idFixture,0,0,2);

		//$this->modificarSancionesjugadoresFalladas($refSancionJugadores, $fallo);
		return 1;	
	}
	return 0;
}



function traerAmarillasAcumuladasPorTorneos($idTorneo) {
	
	$sql = "select
				sum(cantidad) as cantidad
			from (
				select
					1 as cantidad
				from		dbsancionesjugadores sj
				inner
				join		dbfixture fix
				on			fix.idfixture = sj.reffixture
				inner
				join		tbtiposanciones ts
				on			ts.idtiposancion = sj.reftiposanciones
				where		sj.refjugadores = ".$idJugador."
							and fix.reftorneos = ".$idTorneo."
							and ts.amonestacion = 1
							and sj.cantidad > 0
							
				union all
			
				select
					2 as cantidad
				from		dbsancionesjugadores sj
				inner
				join		dbsancionesfallos sf
				on			sj.refsancionesfallos = sf.idsancionfallo
				inner
				join		dbfixture fix
				on			fix.idfixture = sj.reffixture
				where		sj.refjugadores = ".$idJugador."
							and fix.reftorneos = ".$idTorneo."
							and sj.reftiposanciones = 4 and sf.amarillas <> 2
							
				union all
			
				select
					2 as cantidad
				from		dbsancionesjugadores sj
				inner
				join		dbsancionesfallos sf
				on			sj.refsancionesfallos = sf.idsancionfallo
				inner
				join		dbfixture fix
				on			fix.idfixture = sj.reffixture
				where		sj.refjugadores = ".$idJugador."
							and fix.reftorneos = ".$idTorneo."
							and sf.amarillas = 2
				) t";	
	$res = $this->query($sql,0);
	
	if (mysql_num_rows($res)>0) {
		return mysql_result($res,0,0);	
	}
	return 0;
}



function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}


function existe($sql) {

	$res = $this->query($sql,0);
	
	if (mysql_num_rows($res)>0) {
		return 1;	
	}
	return 0;
}

function existeDevuelveId($sql) {

	$res = $this->query($sql,0);
	
	if (mysql_num_rows($res)>0) {
		return mysql_result($res,0,0);	
	}
	return 0;
}


///**********  PARA SUBIR ARCHIVOS  ***********************//////////////////////////
	function borrarDirecctorio($dir) {
		array_map('unlink', glob($dir."/*.*"));	
	
	}
	
	function borrarArchivo($id,$archivo) {
		$sql	=	"delete from images where idfoto =".$id;
		
		$res =  unlink("./../archivos/".$archivo);
		if ($res)
		{
			$this->query($sql,0);	
		}
		return $res;
	}
	
	
	function existeArchivo($id,$nombre,$type,$idtabla) {
		$sql		=	"select * from images where reftabla = ".$idtabla." and refproyecto =".$id." and imagen = '".$nombre."' and type = '".$type."'";
		$resultado  =   $this->query($sql,0);
			   
			   if(mysql_num_rows($resultado)>0){
	
				   return mysql_result($resultado,0,0);
	
			   }
	
			   return 0;	
	}
	
	function sanear_string($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
 
 
    return $string;
}
	
	
	function find_filesize($file)
	{
		if(substr(PHP_OS, 0, 3) == "WIN")
		{
			exec('for %I in ("'.$file.'") do @echo %~zI', $output);
			$return = $output[0];
		}
		else
		{
			$return = filesize($file);
		}
		return $return;
	}
	
	function subirArchivo($file,$carpeta,$id,$idtabla) {
		
		$dir_destino = '../archivos/'.$carpeta.'/'.$id.'/';
		$imagen_subida = $dir_destino . $this->sanear_string(str_replace(' ','',basename($_FILES[$file]['name'])));
		
		$noentrar = '../imagenes/index.php';
		$nuevo_noentrar = '../archivos/'.$carpeta.'/'.$id.'/'.'index.php';
		
		if (!file_exists($dir_destino)) {
			mkdir($dir_destino, 0777);
		}
		
		 
		if(!is_writable($dir_destino)){
			
			echo "no tiene permisos";
			
		}	else	{
			if ($_FILES[$file]['tmp_name'] != '') {
				if(is_uploaded_file($_FILES[$file]['tmp_name'])){
					$this->eliminarFotoPorObjeto($id,$carpeta);
					
					if ($this->find_filesize($imagen_subida) < 1900000) {
						/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
						echo "Mostrar contenido\n";
						echo $imagen_subida;*/
						if (move_uploaded_file($_FILES[$file]['tmp_name'], $imagen_subida)) {
							
							$archivo = $this->sanear_string($_FILES[$file]["name"]);
							$tipoarchivo = $_FILES[$file]["type"];
							
							if ($this->existeArchivo($id,$archivo,$tipoarchivo,$idtabla) == 0) {
								$sql	=	"insert into images(idfoto,refproyecto,reftabla,imagen,type) values ('',".$id.",".$idtabla.",'".str_replace(' ','',$archivo)."','".$tipoarchivo."')";
								$this->query($sql,1);
							}
							echo "";
							
							copy($noentrar, $nuevo_noentrar);
			
						} else {
							echo "Posible ataque de carga de archivos!\n";
						}
					} else {
						echo "El archivo supera los limites de carga.";
					}
				}else{
					echo "Posible ataque del archivo subido: ";
					echo "nombre del archivo '". $_FILES[$file]['tmp_name'] . "'.";
				}
			}
		}	
	}


	
	function TraerFotosRelacion($id, $carpeta) {
		$sql    =   "select '".$carpeta."',s.idcountrie,f.imagen,f.idfoto,f.type
							from dbcountries s
							
							inner
							join images f
							on	s.idcountrie = f.refproyecto

							where s.idcountrie = ".$id;
		$result =   $this->query($sql, 0);
		return $result;
	}
	
	
	function eliminarFoto($id, $carpeta)
	{
		
		$sql		=	"select concat('".$carpeta."','/',s.idcountrie,'/',f.imagen) as archivo
							from dbcountries s
							
							inner
							join images f
							on	s.idcountrie = f.refproyecto

							where f.idfoto =".$id;
		$resImg		=	$this->query($sql,0);
		
		if (mysql_num_rows($resImg)>0) {
			$res 		=	$this->borrarArchivo($id,mysql_result($resImg,0,0));
		} else {
			$res = true;
		}
		if ($res == false) {
			return 'Error al eliminar datos';
		} else {
			return '';
		}
	}
	
	
	function eliminarFotoPorObjeto($id, $carpeta)
	{
		
		$sql		=	"select concat('".$carpeta."','/',s.idcountrie,'/',f.imagen) as archivo,f.idfoto
							from dbcountries s
							
							inner
							join images f
							on	s.idcountrie = f.refproyecto

							where s.idcountrie =".$id;
		$resImg		=	$this->query($sql,0);
		
		if (mysql_num_rows($resImg)>0) {
			$res 		=	$this->borrarArchivo(mysql_result($resImg,0,1),mysql_result($resImg,0,0));
		} else {
			$res = true;
		}
		if ($res == false) {
			return 'Error al eliminar datos';
		} else {
			return '';
		}
	}

/* fin archivos */





/* PARA Contactos */

function insertarContactos($reftipocontactos,$nombre,$direccion,$localidad,$cp,$telefono,$celular,$fax,$email,$observaciones,$publico) {
$sql = "insert into dbcontactos(idcontacto,reftipocontactos,nombre,direccion,localidad,cp,telefono,celular,fax,email,observaciones,publico)
values ('',".$reftipocontactos.",'".($nombre)."','".($direccion)."','".($localidad)."','".($cp)."','".($telefono)."','".($celular)."','".($fax)."','".($email)."','".($observaciones)."',".$publico.")";
$res = $this->query($sql,1);
return $res;
}


function modificarContactos($id,$reftipocontactos,$nombre,$direccion,$localidad,$cp,$telefono,$celular,$fax,$email,$observaciones,$publico) {
$sql = "update dbcontactos
set
reftipocontactos = ".$reftipocontactos.",nombre = '".($nombre)."',direccion = '".($direccion)."',localidad = '".($localidad)."',cp = '".($cp)."',telefono = '".($telefono)."',celular = '".($celular)."',fax = '".($fax)."',email = '".($email)."',observaciones = '".($observaciones)."',publico = ".$publico."
where idcontacto =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarContactos($id) {
$sql = "delete from dbcontactos where idcontacto =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerContactos() {
$sql = "select
c.idcontacto,
tip.tipocontacto,
c.nombre,
c.direccion,
c.localidad,
c.cp,
c.telefono,
c.celular,
c.fax,
c.email,
c.publico,
co.nombre as countrie,
c.observaciones,
c.reftipocontactos
from dbcontactos c
inner join tbtipocontactos tip ON tip.idtipocontacto = c.reftipocontactos
inner join dbcountriecontactos cc ON cc.refcontactos = c.idcontacto
inner join dbcountries co ON cc.refcountries = co.idcountrie
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerContactosPorId($id) {
$sql = "select idcontacto,reftipocontactos,nombre,direccion,localidad,cp,telefono,celular,fax,email,observaciones,publico from dbcontactos where idcontacto =".$id;
$res = $this->query($sql,0);
return $res;
}

function traerCountriesPorContactos($id) {
$sql = "select
c.idcontacto,
co.nombre as countrie,
tip.tipocontacto,
c.nombre,
c.direccion,
c.localidad,
c.cp,
c.telefono,
c.celular,
c.fax,
c.email,
c.publico,
c.observaciones,
c.reftipocontactos
from dbcontactos c
inner join tbtipocontactos tip ON tip.idtipocontacto = c.reftipocontactos
inner join dbcountriecontactos cc on cc.refcontactos = c.idcontacto
inner join dbcountries co on co.idcountrie = cc.refcountries
where c.idcontacto = ".$id."
order by 1";
$res = $this->query($sql,0);
return $res;	
}

function traerCountriesNoAsignadosPorContactos($id) {
$sql = "select
co.idcountrie,
co.nombre as countrie
from dbcountries co
where co.idcountrie not in (select cc.refcountries from dbcountriecontactos cc where cc.refcontactos = ".$id.")
group by co.idcountrie,
co.nombre
order by 2";
$res = $this->query($sql,0);
return $res;	
}

/* Fin */
/* /* Fin de la Tabla: dbcontactos*/


/* PARA Countries */

function existeCountrie($cuit) {
	$sql = "select idcountrie from dbcountries where cuit = '".$cuit."'";	
	$res = $this->query($sql,0);
	
	if (mysql_num_rows($res)>0) {
		return 1;	
	}
	return 0;
}

function existeCountriePorId($cuit, $id) {
	$sql = "select idcountrie from dbcountries where cuit = '".$cuit."' and idcountrie <> ".$id;	
	$res = $this->query($sql,0);
	
	if (mysql_num_rows($res)>0) {
		return 1;	
	}
	return 0;
}


function insertarCountries($nombre,$cuit,$fechaalta,$fechabaja,$refposiciontributaria,$latitud,$longitud,$activo,$referencia,$imagen,$direccion,$telefonoadministrativo,$telefonocampo,$email,$localidad,$codigopostal) { 
$sql = "insert into dbcountries(idcountrie,nombre,cuit,fechaalta,fechabaja,refposiciontributaria,latitud,longitud,activo,referencia,imagen,direccion,telefonoadministrativo,telefonocampo,email,localidad,codigopostal) 
values ('','".($nombre)."','".($cuit)."',".($fechaalta == '' ? 'NULL' : "'".$fechaalta."'").",".($fechabaja == '' ? 'NULL' : "'".$fechabaja."'").",".$refposiciontributaria.",'".($latitud)."','".($longitud)."',".$activo.",'".($referencia)."','".($imagen)."','".($direccion)."','".($telefonoadministrativo)."','".($telefonocampo)."','".($email)."','".($localidad)."','".($codigopostal)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarCountries($id,$nombre,$cuit,$fechaalta,$fechabaja,$refposiciontributaria,$latitud,$longitud,$activo,$referencia,$imagen,$direccion,$telefonoadministrativo,$telefonocampo,$email,$localidad,$codigopostal) { 
$sql = "update dbcountries 
set 
nombre = '".($nombre)."',cuit = '".($cuit)."',fechaalta = ".($fechaalta == '' ? 'NULL' : "'".$fechaalta."'").",fechabaja = ".($fechabaja == '' ? 'NULL' : "'".$fechabaja."'").",refposiciontributaria = ".$refposiciontributaria.",latitud = '".($latitud)."',longitud = '".($longitud)."',activo = ".$activo.",referencia = '".($referencia)."',imagen = '".($imagen)."',direccion = '".($direccion)."',telefonoadministrativo = '".($telefonoadministrativo)."',telefonocampo = '".($telefonocampo)."',email = '".utf8_decode($email)."',localidad = '".utf8_decode($localidad)."',codigopostal = '".utf8_decode($codigopostal)."'  
where idcountrie =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarCountries($id) {
$sql = "delete from dbcountries where idcountrie =".$id;
$res = $this->query($sql,0);
return $res;
} 


function traerCountries() {
$sql = "select
c.idcountrie,
c.nombre,
c.cuit,
DATE_FORMAT(fechaalta, '%d/%m/%Y') as fechaalta,
DATE_FORMAT(fechabaja, '%d/%m/%Y') as fechabaja,
pos.posiciontributaria,
(case when c.activo = 1 then 'Si' else 'No' end) as activo,
c.referencia,
c.latitud,
c.longitud,
c.refposiciontributaria,
c.direccion,
c.telefonoadministrativo,
c.telefonocampo,
c.email,
c.localidad,
c.codigopostal
from dbcountries c
inner join tbposiciontributaria pos ON pos.idposiciontributaria = c.refposiciontributaria
order by c.nombre";
$res = $this->query($sql,0);
return $res;
}


function traerCountriesPorId($id) {
$sql = "select idcountrie,nombre,cuit,fechaalta,
    fechabaja,refposiciontributaria,latitud,longitud,activo,referencia,direccion,telefonoadministrativo,telefonocampo,email,localidad,codigopostal from dbcountries where idcountrie =".$id;
$res = $this->query($sql,0);
return $res;
}

function traerContactosAsignadosPorCountrie($id) {
$sql = "select
c.idcontacto,
tip.tipocontacto,
c.nombre,
c.direccion,
c.localidad,
c.cp,
c.telefono,
c.celular,
c.fax,
c.email,
c.publico,
c.observaciones,
c.reftipocontactos
from dbcontactos c
inner join tbtipocontactos tip ON tip.idtipocontacto = c.reftipocontactos
inner join dbcountriecontactos cc on cc.refcontactos = c.idcontacto
inner join dbcountries co on co.idcountrie = cc.refcountries
where co.idcountrie = ".$id."
order by 1";
$res = $this->query($sql,0);
return $res;	
}

/* Fin */
/* /* Fin de la Tabla: dbcountries*/


/* PARA Usuarios */

function insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto) {
$sql = "insert into dbusuarios(idusuario,usuario,password,refroles,email,nombrecompleto)
values ('','".($usuario)."','".($password)."',".$refroles.",'".($email)."','".($nombrecompleto)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarUsuarios($id,$usuario,$password,$refroles,$email,$nombrecompleto) {
$sql = "update dbusuarios
set
usuario = '".($usuario)."',password = '".($password)."',refroles = ".$refroles.",email = '".($email)."',nombrecompleto = '".($nombrecompleto)."'
where idusuario =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarUsuarios($id) {
$sql = "delete from dbusuarios where idusuario =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerUsuarios() {
$sql = "select
u.idusuario,
u.usuario,
u.password,
u.refroles,
u.email,
u.nombrecompleto
from dbusuarios u
inner join tbroles rol ON rol.idrol = u.refroles
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerUsuariosPorId($id) {
$sql = "select idusuario,usuario,password,refroles,email,nombrecompleto from dbusuarios where idusuario =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbusuarios*/


/* PARA Predio_menu */

function insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso,$administracion,$torneo,$reportes) {
$sql = "insert into predio_menu(idmenu,url,icono,nombre,Orden,hover,permiso,administracion,torneo,reportes)
values ('','".($url)."','".($icono)."','".($nombre)."',".$Orden.",'".($hover)."','".($permiso)."',".$administracion.",".$torneo.",".$reportes.")";
$res = $this->query($sql,1);
return $res;
}


function modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso,$administracion,$torneo,$reportes) {
$sql = "update predio_menu
set
url = '".($url)."',icono = '".($icono)."',nombre = '".($nombre)."',Orden = ".$Orden.",hover = '".($hover)."',permiso = '".($permiso)."',administracion = ".$administracion.",torneo = ".$torneo.",reportes = ".$reportes."
where idmenu =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarPredio_menu($id) {
$sql = "delete from predio_menu where idmenu =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerPredio_menu() {
$sql = "select
p.idmenu,
p.url,
p.icono,
p.nombre,
p.Orden,
p.hover,
p.permiso,
p.administracion,
p.torneo,
p.reportes
from predio_menu p
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerPredio_menuPorId($id) {
$sql = "select idmenu,url,icono,nombre,Orden,hover,permiso,administracion,torneo,reportes from predio_menu where idmenu =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: predio_menu*/


/* PARA Canchas */

function insertarCanchas($refcountries,$nombre) {
$sql = "insert into tbcanchas(idcancha,refcountries,nombre)
values ('',".$refcountries.",'".($nombre)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarCanchas($id,$refcountries,$nombre) {
$sql = "update tbcanchas
set
refcountries = ".$refcountries.",nombre = '".($nombre)."'
where idcancha =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCanchas($id) {
$sql = "delete from tbcanchas where idcancha =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCanchas() {
$sql = "select
c.idcancha,
coalesce(cou.nombre,'Libre') as countrie,
c.nombre,
c.refcountries
from tbcanchas c
left join dbcountries cou ON cou.idcountrie = c.refcountries
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerCanchasPorId($id) {
$sql = "select idcancha,refcountries,nombre from tbcanchas where idcancha =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbcanchas*/


/* PARA Posiciontributaria */

function insertarPosiciontributaria($posiciontributaria,$activo) {
$sql = "insert into tbposiciontributaria(idposiciontributaria,posiciontributaria,activo)
values ('','".($posiciontributaria)."',".$activo.")";
$res = $this->query($sql,1);
return $res;
}


function modificarPosiciontributaria($id,$posiciontributaria,$activo) {
$sql = "update tbposiciontributaria
set
posiciontributaria = '".($posiciontributaria)."',activo = ".$activo."
where idposiciontributaria =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarPosiciontributaria($id) {
$sql = "update tbposiciontributaria set activo = 0 where idposiciontributaria =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerPosiciontributaria() {
$sql = "select
p.idposiciontributaria,
p.posiciontributaria,
(case when p.activo = 1 then 'Si' else 'No' end) as activo
from tbposiciontributaria p
where activo = 1
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerPosiciontributariaPorId($id) {
$sql = "select idposiciontributaria,posiciontributaria,activo from tbposiciontributaria where idposiciontributaria =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbposiciontributaria*/


/* PARA Roles */

function insertarRoles($descripcion,$activo) {
$sql = "insert into tbroles(idrol,descripcion,activo)
values ('','".($descripcion)."',".$activo.")";
$res = $this->query($sql,1);
return $res;
}


function modificarRoles($id,$descripcion,$activo) {
$sql = "update tbroles
set
descripcion = '".($descripcion)."',activo = ".$activo."
where idrol =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarRoles($id) {
$sql = "delete from tbroles where idrol =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerRoles() {
$sql = "select
r.idrol,
r.descripcion,
r.activo
from tbroles r
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerRolesPorId($id) {
$sql = "select idrol,descripcion,activo from tbroles where idrol =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbroles*/


/* PARA Tipocontactos */

function insertarTipocontactos($tipocontacto,$activo) {
$sql = "insert into tbtipocontactos(idtipocontacto,tipocontacto,activo)
values ('','".($tipocontacto)."',".$activo.")";
$res = $this->query($sql,1);
return $res;
}


function modificarTipocontactos($id,$tipocontacto,$activo) {
$sql = "update tbtipocontactos
set
tipocontacto = '".($tipocontacto)."',activo = ".$activo."
where idtipocontacto =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarTipocontactos($id) {
$sql = "update tbtipocontactos set activo = 0 where idtipocontacto =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerTipocontactos() {
$sql = "select
t.idtipocontacto,
t.tipocontacto,
(case when t.activo = 1 then 'Si' else 'No' end) as activo
from tbtipocontactos t
where activo = 1
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerTipocontactosPorId($id) {
$sql = "select idtipocontacto,tipocontacto,activo from tbtipocontactos where idtipocontacto =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbtipocontactos*/


/* PARA Arbitros */

function insertarArbitros($nombrecompleto,$telefonoparticular,$telefonoceleluar,$telefonolaboral,$telefonofamiliar,$email) {
$sql = "insert into dbarbitros(idarbitro,nombrecompleto,telefonoparticular,telefonoceleluar,telefonolaboral,telefonofamiliar,email)
values ('','".($nombrecompleto)."','".($telefonoparticular)."','".($telefonoceleluar)."','".($telefonolaboral)."','".($telefonofamiliar)."','".($email)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarArbitros($id,$nombrecompleto,$telefonoparticular,$telefonoceleluar,$telefonolaboral,$telefonofamiliar,$email) {
$sql = "update dbarbitros
set
nombrecompleto = '".($nombrecompleto)."',telefonoparticular = '".($telefonoparticular)."',telefonoceleluar = '".($telefonoceleluar)."',telefonolaboral = '".($telefonolaboral)."',telefonofamiliar = '".($telefonofamiliar)."',email = '".($email)."'
where idarbitro =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarArbitros($id) {
$sql = "delete from dbarbitros where idarbitro =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerArbitros() {
$sql = "select
a.idarbitro,
a.nombrecompleto,
a.telefonoparticular,
a.telefonoceleluar,
a.telefonolaboral,
a.telefonofamiliar,
a.email
from dbarbitros a
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerArbitrosPorId($id) {
$sql = "select idarbitro,nombrecompleto,telefonoparticular,telefonoceleluar,telefonolaboral,telefonofamiliar,email from dbarbitros where idarbitro =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbarbitros*/


/* PARA Countriecanchas */

function insertarCountriecanchas($refcountries,$refcanchas) {
$sql = "insert into dbcountriecanchas(idcountriecancha,refcountries,refcanchas)
values ('',".$refcountries.",".$refcanchas.")";
$res = $this->query($sql,1);
return $res;
}


function modificarCountriecanchas($id,$refcountries,$refcanchas) {
$sql = "update dbcountriecanchas
set
refcountries = ".$refcountries.",refcanchas = ".$refcanchas."
where idcountriecancha =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCountriecanchas($id) {
$sql = "delete from dbcountriecanchas where idcountriecancha =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCountriecanchas() {
$sql = "select
c.idcountriecancha,
c.refcountries,
c.refcanchas
from dbcountriecanchas c
inner join dbcountries cou ON cou.idcountrie = c.refcountries
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria
inner join tbcanchas can ON can.idcancha = c.refcanchas
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerCountriecanchasPorId($id) {
$sql = "select idcountriecancha,refcountries,refcanchas from dbcountriecanchas where idcountriecancha =".$id;
$res = $this->query($sql,0);
return $res;
} 

/* Fin */
/* /* Fin de la Tabla: dbcountriecanchas*/


/* PARA Categorias */

function insertarCategorias($categoria) {
$sql = "insert into tbcategorias(idtcategoria,categoria)
values ('','".($categoria)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarCategorias($id,$categoria) {
$sql = "update tbcategorias
set
categoria = '".($categoria)."'
where idtcategoria =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCategorias($id) {
$sql = "delete from tbcategorias where idtcategoria =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCategorias() {
$sql = "select
c.idtcategoria,
c.categoria
from tbcategorias c
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerCategoriasPorId($id) {
$sql = "select idtcategoria,categoria from tbcategorias where idtcategoria =".$id;
$res = $this->query($sql,0);
return $res;
}

function traerCategoriasPorEquipos($idEquipos) {
$sql = "select 
			c.idtcategoria,c.categoria 
		from tbcategorias c
		inner
		join	dbequipos e
		on		e.refcategorias = c.idtcategoria
		where idequipo =".$idEquipos;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbcategorias*/

/* PARA Divisiones */

function insertarDivisiones($division) {
$sql = "insert into tbdivisiones(iddivision,division)
values ('','".($division)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarDivisiones($id,$division) {
$sql = "update tbdivisiones
set
division = '".($division)."'
where iddivision =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarDivisiones($id) {
$sql = "delete from tbdivisiones where iddivision =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerDivisiones() {
$sql = "select
d.iddivision,
d.division
from tbdivisiones d
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerDivisionesPorId($id) {
$sql = "select iddivision,division from tbdivisiones where iddivision =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbdivisiones*/


/* PARA Temporadas */

function insertarTemporadas($temporada) {
$sql = "insert into tbtemporadas(idtemporadas,temporada)
values ('',".$temporada.")";
$res = $this->query($sql,1);
return $res;
}


function modificarTemporadas($id,$temporada) {
$sql = "update tbtemporadas
set
temporada = ".$temporada."
where idtemporadas =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarTemporadas($id) {
$sql = "delete from tbtemporadas where idtemporadas =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerTemporadas() {
$sql = "select
t.idtemporadas,
t.temporada
from tbtemporadas t
order by 1";
$res = $this->query($sql,0);
return $res;
}

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


function traerTemporadasPorId($id) {
$sql = "select idtemporadas,temporada from tbtemporadas where idtemporadas =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbtemporadas*/


/* PARA Countriecontactos */

function insertarCountriecontactos($refcountries,$refcontactos) {
$sql = "insert into dbcountriecontactos(idcountriecontacto,refcountries,refcontactos)
values ('',".$refcountries.",".$refcontactos.")";
$res = $this->query($sql,1);
return $res;
}


function modificarCountriecontactos($id,$refcountries,$refcontactos) {
$sql = "update dbcountriecontactos
set
refcountries = ".$refcountries.",refcontactos = ".$refcontactos."
where idcountriecontacto =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCountriecontactos($id) {
$sql = "delete from dbcountriecontactos where idcountriecontacto =".$id;
$res = $this->query($sql,0);
return $res;
}

function eliminarCountriecontactosPorCountrie($id) {
$sql = "delete from dbcountriecontactos where refcountries =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCountriecontactos() {
$sql = "select
c.idcountriecontacto,
concat(ti.tipocontacto,' - ',con.nombre) as contacto,
cou.nombre as countrie,
c.refcountries,
c.refcontactos
from dbcountriecontactos c
inner join dbcountries cou ON cou.idcountrie = c.refcountries
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria
inner join dbcontactos con ON con.idcontacto = c.refcontactos
inner join tbtipocontactos ti ON ti.idtipocontacto = con.reftipocontactos
order by 2";
$res = $this->query($sql,0);
return $res;
}


function traerCountriecontactosPorId($id) {
$sql = "select idcountriecontacto,refcountries,refcontactos from dbcountriecontactos where idcountriecontacto =".$id;
$res = $this->query($sql,0);
return $res;
}

function traerCountriecontactosPorCountries($idCountrie) {
	$sql = "select
			c.idcountriecontacto,
			concat(ti.tipocontacto,' - ',con.nombre) as contacto,
			cou.nombre as countrie,
			c.refcountries,
			c.refcontactos,
			con.telefono,
			con.email
		from dbcountriecontactos c
		inner join dbcountries cou ON cou.idcountrie = c.refcountries
		inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria
		inner join dbcontactos con ON con.idcontacto = c.refcontactos
		inner join tbtipocontactos ti ON ti.idtipocontacto = con.reftipocontactos
		where cou.idcountrie = ".$idCountrie."
		order by 2";
	$res = $this->query($sql,0);
	return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbcountriecontactos*/



/* PARA Canchasuspenciones */
/*'".($vigenciahasta == '' ? 'NULL' : 'NULL')."'*/
function insertarCanchasuspenciones($refcanchas,$vigenciadesde,$vigenciahasta,$usuacrea,$fechacrea,$usuamodi,$fechamodi) {
$sql = "insert into dbcanchasuspenciones(idcanchasuspencion,refcanchas,vigenciadesde,vigenciahasta,usuacrea,fechacrea,usuamodi,fechamodi)
values ('',".$refcanchas.",'".($vigenciadesde)."',".($vigenciahasta == '' ? 'NULL' : "'".$vigenciahasta."'").",'".($usuacrea)."','".($fechacrea)."','".($usuamodi)."','NULL')";
$res = $this->query($sql,1);
return $res;
}


function modificarCanchasuspenciones($id,$refcanchas,$vigenciadesde,$vigenciahasta,$usuacrea,$fechacrea,$usuamodi,$fechamodi) {
$sql = "update dbcanchasuspenciones
set
refcanchas = ".$refcanchas.",vigenciadesde = '".($vigenciadesde)."',vigenciahasta = '".($vigenciahasta)."',usuacrea = '".($usuacrea)."',fechacrea = '".($fechacrea)."',usuamodi = '".($usuamodi)."',fechamodi = '".($fechamodi)."'
where idcanchasuspencion =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarCanchasuspenciones($id) {
$sql = "delete from dbcanchasuspenciones where idcanchasuspencion =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerCanchasuspenciones() {
$sql = "select
c.idcanchasuspencion,
coalesce(co.nombre,'Libre') as countrie,
can.nombre as cancha,
c.vigenciadesde,
c.vigenciahasta,
c.usuacrea,
c.fechacrea,
c.usuamodi,
c.fechamodi,
c.refcanchas
from dbcanchasuspenciones c
inner join tbcanchas can ON can.idcancha = c.refcanchas
left join dbcountries co ON co.idcountrie = can.refcountries
order by 1";
$res = $this->query($sql,0);
return $res;
}

function traerCanchasuspencionesPorCancha($idCancha) {
$sql = "select
c.idcanchasuspencion,
coalesce(co.nombre,'Libre') as countrie,
can.nombre as cancha,
c.vigenciadesde,
c.vigenciahasta,
c.usuacrea,
c.fechacrea,
c.usuamodi,
c.fechamodi,
c.refcanchas
from dbcanchasuspenciones c
inner join tbcanchas can ON can.idcancha = c.refcanchas
left join dbcountries co ON co.idcountrie = can.refcountries
where can.idcancha = ".$idCancha."
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerCanchasuspencionesPorId($id) {
$sql = "select idcanchasuspencion,refcanchas,vigenciadesde,vigenciahasta,usuacrea,fechacrea,usuamodi,fechamodi from dbcanchasuspenciones where idcanchasuspencion =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbcanchasuspenciones*/




/* PARA Jugadores */

function buscarJugadores($tipobusqueda,$busqueda) {
		switch ($tipobusqueda) {
			case '1':
				$sql = "select 
							j.idjugador,
							tip.tipodocumento,
							j.nrodocumento,
							j.apellido,
							j.nombres,
							j.email,
							j.fechanacimiento,
							j.fechaalta,
							j.fechabaja,
							cou.nombre as countrie,
							j.observaciones,
							j.reftipodocumentos,
							j.refcountries
							from dbjugadores j 
							inner join tbtipodocumentos tip ON tip.idtipodocumento = j.reftipodocumentos 
							inner join dbcountries cou ON cou.idcountrie = j.refcountries 
							inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
				where cou.nombre like '%".$busqueda."%'
				order by cou.nombre,j.apellido,j.nombres limit 200";
				break;
			case '2':
				$sql = "select 
							j.idjugador,
							tip.tipodocumento,
							j.nrodocumento,
							j.apellido,
							j.nombres,
							j.email,
							j.fechanacimiento,
							j.fechaalta,
							j.fechabaja,
							cou.nombre as countrie,
							j.observaciones,
							j.reftipodocumentos,
							j.refcountries
							from dbjugadores j 
							inner join tbtipodocumentos tip ON tip.idtipodocumento = j.reftipodocumentos 
							inner join dbcountries cou ON cou.idcountrie = j.refcountries 
							inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
				where concat(j.apellido, ', ',j.nombres) like '%".$busqueda."%'
				order by cou.nombre,j.apellido,j.nombres";
				break;
			case '3':
				$sql = "select 
							j.idjugador,
							tip.tipodocumento,
							j.nrodocumento,
							j.apellido,
							j.nombres,
							j.email,
							j.fechanacimiento,
							j.fechaalta,
							j.fechabaja,
							cou.nombre as countrie,
							j.observaciones,
							j.reftipodocumentos,
							j.refcountries
							from dbjugadores j 
							inner join tbtipodocumentos tip ON tip.idtipodocumento = j.reftipodocumentos 
							inner join dbcountries cou ON cou.idcountrie = j.refcountries 
							inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
				where j.nrodocumento like '%".$busqueda."%'
				order by cou.nombre,j.apellido,j.nombres";
				break;

		
		}
		return $this->query($sql,0);
	}

function existeJugador($nroDocumento) {
	$sql = "select idjugador from dbjugadores where nrodocumento = ".$nroDocumento;
	$res = $this->query($sql,0);
	
	if (mysql_num_rows($res)>0) {
		return 1;	
	}
	return 0;
}

function existeJugadorConIdJugador($nroDocumento, $idJugador) {
	$sql = "select idjugador from dbjugadores where nrodocumento = ".$nroDocumento." and idjugador <>".$idJugador;
	$res = $this->query($sql,0);
	
	if (mysql_num_rows($res)>0) {
		return 1;	
	}
	return 0;
}
	
function insertarJugadores($reftipodocumentos,$nrodocumento,$apellido,$nombres,$email,$fechanacimiento,$fechaalta,$fechabaja,$refcountries,$observaciones) { 
$sql = "insert into dbjugadores(idjugador,reftipodocumentos,nrodocumento,apellido,nombres,email,fechanacimiento,fechaalta,fechabaja,refcountries,observaciones) 
values ('',".$reftipodocumentos.",".$nrodocumento.",'".($apellido)."','".($nombres)."','".($email)."','".($fechanacimiento)."','".($fechaalta)."','".($fechabaja)."',".$refcountries.",'".($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarJugadores($id,$reftipodocumentos,$nrodocumento,$apellido,$nombres,$email,$fechanacimiento,$fechaalta,$fechabaja,$refcountries,$observaciones) { 
$sql = "update dbjugadores 
set 
reftipodocumentos = ".$reftipodocumentos.",nrodocumento = ".$nrodocumento.",apellido = '".($apellido)."',nombres = '".($nombres)."',email = '".($email)."',fechanacimiento = '".($fechanacimiento)."',fechaalta = '".($fechaalta)."',fechabaja = '".($fechabaja)."',refcountries = ".$refcountries.",observaciones = '".($observaciones)."' 
where idjugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadores($id) { 
$sql = "delete from dbjugadores where idjugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadores() { 
$sql = "select 
j.idjugador,
tip.tipodocumento,
j.nrodocumento,
j.apellido,
j.nombres,
j.email,
j.fechanacimiento,
j.fechaalta,
j.fechabaja,
cou.nombre as countrie,
j.observaciones,
j.reftipodocumentos,
j.refcountries
from dbjugadores j 
inner join tbtipodocumentos tip ON tip.idtipodocumento = j.reftipodocumentos 
inner join dbcountries cou ON cou.idcountrie = j.refcountries 
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresPorId($id) { 
$sql = "select idjugador,reftipodocumentos,nrodocumento,apellido,nombres,email,fechanacimiento,fechaalta,fechabaja,refcountries,observaciones from dbjugadores where idjugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 



function traerJugadoresPorEquipos($idEquipo) { 
$sql = "select 
j.idjugador,
tip.tipodocumento,
j.nrodocumento,
j.apellido,
j.nombres,
j.email,
j.fechanacimiento,
j.fechaalta,
j.fechabaja,
cou.nombre as countrie,
j.observaciones,
j.reftipodocumentos,
j.refcountries
from dbjugadores j 
inner join tbtipodocumentos tip ON tip.idtipodocumento = j.reftipodocumentos 
inner join dbcountries cou ON cou.idcountrie = j.refcountries 
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
where 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresPorCountrie($idCountrie) { 
$sql = "select 
j.idjugador,
tip.tipodocumento,
j.nrodocumento,
j.apellido,
j.nombres,
j.email,
j.fechanacimiento,
j.fechaalta,
j.fechabaja,
cou.nombre as countrie,
j.observaciones,
j.reftipodocumentos,
j.refcountries
from dbjugadores j 
inner join tbtipodocumentos tip ON tip.idtipodocumento = j.reftipodocumentos 
inner join dbcountries cou ON cou.idcountrie = j.refcountries 
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
where j.refcountries = ".$idCountrie."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbjugadores*/


/* PARA Jugadoresdocumentacion */

function existeDocumentacion($refjugadores,$refdocumentaciones) {
	$sql = "select idjugadordocumentacion from dbjugadoresdocumentacion where refjugadores = ".$refjugadores." and refdocumentaciones = ".$refdocumentaciones;
	$res = $this->query($sql,0);
	if (mysql_num_rows($res)>0) {
		return 1;	
	}
	return 0;
}

function insertarJugadoresdocumentacion($refjugadores,$refdocumentaciones,$valor,$observaciones) { 
$sql = "insert into dbjugadoresdocumentacion(idjugadordocumentacion,refjugadores,refdocumentaciones,valor,observaciones) 
values ('',".$refjugadores.",".$refdocumentaciones.",".$valor.",'".($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarJugadoresdocumentacion($id,$refjugadores,$refdocumentaciones,$valor,$observaciones) { 
$sql = "update dbjugadoresdocumentacion 
set 
refjugadores = ".$refjugadores.",refdocumentaciones = ".$refdocumentaciones.",valor = ".$valor.",observaciones = '".($observaciones)."' 
where idjugadordocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadoresdocumentacion($id) { 
$sql = "delete from dbjugadoresdocumentacion where idjugadordocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

function eliminarJugadoresdocumentacionPorJugador($idJuagador) { 
$sql = "delete from dbjugadoresdocumentacion where refjugadores =".$idJuagador; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresdocumentacion() { 
$sql = "select 
j.idjugadordocumentacion,
j.refjugadores,
j.refdocumentaciones,
j.valor,
j.observaciones
from dbjugadoresdocumentacion j 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join tbdocumentaciones doc ON doc.iddocumentacion = j.refdocumentaciones 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresdocumentacionPorId($id) { 
$sql = "select idjugadordocumentacion,refjugadores,refdocumentaciones,valor,observaciones from dbjugadoresdocumentacion where idjugadordocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

function traerJugadoresdocumentacionPorJugador($idJugador) { 
$sql = "select j.refdocumentaciones,
doc.descripcion,
(case when doc.obligatoria = 1 then 'Si' else 'No' end) as obligatoria,
(case when j.valor = 1 then 'Si' else 'No' end) as valor,
j.refjugadores,
j.idjugadordocumentacion,
j.observaciones
from dbjugadoresdocumentacion j 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join tbdocumentaciones doc ON doc.iddocumentacion = j.refdocumentaciones 
where j.refjugadores =".$idJugador; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresdocumentacionPorJugadorValores($idJugador) { 
$sql = "select
			r.refdocumentaciones,
			r.descripcion,
			r.obligatoria,
			(case when r.valor = 1 then 'Si' else 'No' end) as valor,
			(case when coalesce(r.contravalor,0) = 1 then 'Si' else 'No' end) as contravalor,
			r.refjugadores,
			r.idjugadordocumentacion,
			r.observaciones,
            coalesce(r.contravalordesc,'') as contravalordesc
			from
			(
			SELECT 
				j.refdocumentaciones,
				doc.descripcion,
				(CASE
					WHEN doc.obligatoria = 1 THEN 'Si'
					ELSE 'No'
				END) AS obligatoria,
				j.valor,
				(SELECT 
						v.habilita
					FROM
						tbvaloreshabilitacionestransitorias v
					inner join dbjugadoresvaloreshabilitacionestransitorias vh
					on v.idvalorhabilitaciontransitoria = vh.refvaloreshabilitacionestransitorias
					WHERE
						refdocumentaciones = doc.iddocumentacion and vh.refjugadores = jug.idjugador) AS contravalor,
				(SELECT 
						v.descripcion
					FROM
						tbvaloreshabilitacionestransitorias v
					inner join dbjugadoresvaloreshabilitacionestransitorias vh
					on v.idvalorhabilitaciontransitoria = vh.refvaloreshabilitacionestransitorias
					WHERE
						refdocumentaciones = doc.iddocumentacion and vh.refjugadores = jug.idjugador) AS contravalordesc,
				j.refjugadores,
				j.idjugadordocumentacion,
				j.observaciones
			FROM
				dbjugadoresdocumentacion j
					INNER JOIN
				dbjugadores jug ON jug.idjugador = j.refjugadores
					INNER JOIN
				tbdocumentaciones doc ON doc.iddocumentacion = j.refdocumentaciones
			WHERE
				j.refjugadores = ".$idJugador."
				) as r"; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbjugadoresdocumentacion*/


/* PARA Documentaciones */

function insertarDocumentaciones($descripcion,$obligatoria,$observaciones) { 
$sql = "insert into tbdocumentaciones(iddocumentacion,descripcion,obligatoria,observaciones) 
values ('','".($descripcion)."',".$obligatoria.",'".($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarDocumentaciones($id,$descripcion,$obligatoria,$observaciones) { 
$sql = "update tbdocumentaciones 
set 
descripcion = '".($descripcion)."',obligatoria = ".$obligatoria.",observaciones = '".($observaciones)."' 
where iddocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarDocumentaciones($id) { 
$sql = "delete from tbdocumentaciones where iddocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDocumentaciones() { 
$sql = "select 
d.iddocumentacion,
d.descripcion,
(case when d.obligatoria = 1 then 'Si' else 'No' end) as obligatoria,
d.observaciones
from tbdocumentaciones d 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDocumentacionesPorId($id) { 
$sql = "select iddocumentacion,descripcion, (case when obligatoria = 1 then 'Si' else 'No' end) as obligatoria,observaciones from tbdocumentaciones where iddocumentacion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbdocumentaciones*/


/* PARA Motivoshabilitacionestransitorias */


function insertarMotivoshabilitacionestransitorias($inhabilita,$descripcion,$refdocumentaciones) {
$sql = "insert into tbmotivoshabilitacionestransitorias(idmotivoshabilitacionestransitoria,inhabilita,descripcion,refdocumentaciones)
values ('',".$inhabilita.",'".($descripcion)."',".$refdocumentaciones.")";
$res = $this->query($sql,1);
return $res;
}


function modificarMotivoshabilitacionestransitorias($id,$inhabilita,$descripcion,$refdocumentaciones) {
$sql = "update tbmotivoshabilitacionestransitorias
set
inhabilita = ".$inhabilita.",descripcion = '".($descripcion)."',refdocumentaciones = ".$refdocumentaciones."
where idmotivoshabilitacionestransitoria =".$id;
$res = $this->query($sql,0);
return $res;
}



function eliminarMotivoshabilitacionestransitorias($id) { 
$sql = "delete from tbmotivoshabilitacionestransitorias where idmotivoshabilitacionestransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMotivoshabilitacionestransitorias() { 
$sql = "select 
m.idmotivoshabilitacionestransitoria,
(case when m.inhabilita = 1 then 'Si' else 'No' end) as inhabilita,
m.descripcion,
doc.descripcion as documentacion,
m.refdocumentaciones
from tbmotivoshabilitacionestransitorias m 
inner join tbdocumentaciones doc ON doc.iddocumentacion = m.refdocumentaciones 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMotivoshabilitacionestransitoriasDeportivas($id) { 
$sql = "select 
m.idmotivoshabilitacionestransitoria,
(case when m.inhabilita = 1 then 'Si' else 'No' end) as inhabilita,
m.descripcion,
m.refdocumentaciones
from tbmotivoshabilitacionestransitorias m 
where m.descripcion like '".$id."'
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMotivoshabilitacionestransitoriasDocumentaciones($id) { 
$sql = "select 
m.idmotivoshabilitacionestransitoria,
(case when m.inhabilita = 1 then 'Si' else 'No' end) as inhabilita,
m.descripcion
from tbmotivoshabilitacionestransitorias m 
where m.descripcion not like '".$id."'
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion($idDocumentacion) { 
$sql = "select 
m.idmotivoshabilitacionestransitoria,
(case when m.inhabilita = 1 then 'Si' else 'No' end) as inhabilita,
m.descripcion
from tbmotivoshabilitacionestransitorias m 
where m.refdocumentaciones = ".$idDocumentacion." 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMotivoshabilitacionestransitoriasPorId($id) { 
$sql = "select idmotivoshabilitacionestransitoria,inhabilita,descripcion,refdocumentaciones from tbmotivoshabilitacionestransitorias where idmotivoshabilitacionestransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbmotivoshabilitacionestransitorias*/

/* PARA Tipodocumentos */

function insertarTipodocumentos($tipodocumento) { 
$sql = "insert into tbtipodocumentos(idtipodocumento,tipodocumento) 
values ('','".($tipodocumento)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarTipodocumentos($id,$tipodocumento) { 
$sql = "update tbtipodocumentos 
set 
tipodocumento = '".($tipodocumento)."' 
where idtipodocumento =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarTipodocumentos($id) { 
$sql = "delete from tbtipodocumentos where idtipodocumento =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipodocumentos() { 
$sql = "select 
t.idtipodocumento,
t.tipodocumento
from tbtipodocumentos t 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipodocumentosPorId($id) { 
$sql = "select idtipodocumento,tipodocumento from tbtipodocumentos where idtipodocumento =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbtipodocumentos*/


/* PARA Tipojugadores */

function insertarTipojugadores($tipojugador,$abreviatura) { 
$sql = "insert into tbtipojugadores(idtipojugador,tipojugador,abreviatura) 
values ('','".($tipojugador)."','".($abreviatura)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarTipojugadores($id,$tipojugador,$abreviatura) { 
$sql = "update tbtipojugadores 
set 
tipojugador = '".($tipojugador)."',abreviatura = '".($abreviatura)."' 
where idtipojugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarTipojugadores($id) { 
$sql = "delete from tbtipojugadores where idtipojugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipojugadores() { 
$sql = "select 
t.idtipojugador,
t.tipojugador,
t.abreviatura
from tbtipojugadores t 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipojugadoresPorId($id) { 
$sql = "select idtipojugador,tipojugador,abreviatura from tbtipojugadores where idtipojugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbtipojugadores*/

//////////  Funciones para la etapa 2  //////////////////

//////// TABLAS ////////////////////////////////////////////
/*
dbjugadoresmotivoshabilitacionestransitorias
dbjugadoresvaloreshabilitacionestransitorias
tbvaloreshabilitacionestransitorias
tbtipojugadores
tbdocumentaciones
tbmotivoshabilitacionestransitorias
dbjugadores
tbtipodocumentos

*/

/* PARA Valoreshabilitacionestransitorias */


/* PARA Jugadoresmotivoshabilitacionestransitorias */

function existeJugadoresMotivosHabilitacionesTransitorias($reftemporada, $refcategoria, $refequipo, $refJugador, $refdocumentaciones,$refmotivoshabilitacionestransitorias) {
	$sql = "select iddbjugadormotivohabilitaciontransitoria 
				from dbjugadoresmotivoshabilitacionestransitorias 
				where reftemporadas = ".$reftemporada."
					  and refcategorias = ".$refcategoria."
					  and refequipos = ".$refequipo."
					  and refjugadores = ".$refJugador."
					  and refdocumentaciones = ".$refdocumentaciones."
					  and refmotivoshabilitacionestransitorias = ".$refmotivoshabilitacionestransitorias;
	$res = $this->query($sql,0);
	
	if (mysql_num_rows($res)>0) {
		return 1;
	}
	return 0;
}


function insertarJugadoresmotivoshabilitacionestransitorias($reftemporadas,$refjugadores,$refdocumentaciones,$refmotivoshabilitacionestransitorias,$refequipos,$refcategorias,$fechalimite,$observaciones) { 
$sql = "insert into dbjugadoresmotivoshabilitacionestransitorias(iddbjugadormotivohabilitaciontransitoria,reftemporadas,refjugadores,refdocumentaciones,refmotivoshabilitacionestransitorias,refequipos,refcategorias,fechalimite,observaciones) 
values ('',".$reftemporadas.",".$refjugadores.",".$refdocumentaciones.",".$refmotivoshabilitacionestransitorias.",".$refequipos.",".$refcategorias.",'".($fechalimite)."','".($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarJugadoresmotivoshabilitacionestransitorias($id,$reftemporadas,$refjugadores,$refdocumentaciones,$refmotivoshabilitacionestransitorias,$refequipos,$refcategorias,$fechalimite,$observaciones) { 
$sql = "update dbjugadoresmotivoshabilitacionestransitorias 
set 
reftemporadas = ".$reftemporadas.",refjugadores = ".$refjugadores.",refdocumentaciones = ".$refdocumentaciones.",refmotivoshabilitacionestransitorias = ".$refmotivoshabilitacionestransitorias.",refequipos = ".$refequipos.",refcategorias = ".$refcategorias.",fechalimite = '".($fechalimite)."',observaciones = '".($observaciones)."' 
where iddbjugadormotivohabilitaciontransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadoresmotivoshabilitacionestransitorias($id) { 
$sql = "delete from dbjugadoresmotivoshabilitacionestransitorias where iddbjugadormotivohabilitaciontransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresmotivoshabilitacionestransitorias() { 
$sql = "select 
j.iddbjugadormotivohabilitaciontransitoria,
j.reftemporadas,
j.refjugadores,
j.refdocumentaciones,
j.refmotivoshabilitacionestransitorias,
j.refequipos,
j.refcategorias,
j.fechalimite,
j.observaciones
from dbjugadoresmotivoshabilitacionestransitorias j 
inner join tbtemporadas tem ON tem.idtemporadas = j.reftemporadas 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join tbdocumentaciones doc ON doc.iddocumentacion = j.refdocumentaciones 
inner join tbmotivoshabilitacionestransitorias mot ON mot.idmotivoshabilitacionestransitoria = j.refmotivoshabilitacionestransitorias 
left join dbequipos equ ON equ.idequipo = j.refequipos 
inner join dbcountries co ON co.idcountrie = equ.refcountries 
inner join tbcategorias ca ON ca.idtcategoria = equ.refcategorias 
inner join tbdivisiones di ON di.iddivision = equ.refdivisiones 
inner join dbcontactos co ON co.idcontacto = equ.refcontactos 
inner join tbcategorias cat ON cat.idtcategoria = j.refcategorias 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresmotivoshabilitacionestransitoriasPorJugador($idJugador) { 
$sql = "select 
j.iddbjugadormotivohabilitaciontransitoria,
tem.temporada,
doc.descripcion as documentacion,
mot.descripcion as motivos,
equ.nombre as equipo,
cat.categoria,
j.fechalimite,
j.reftemporadas,
j.refjugadores,
j.refdocumentaciones,
j.refmotivoshabilitacionestransitorias,
j.refequipos,
j.refcategorias,

j.observaciones
from dbjugadoresmotivoshabilitacionestransitorias j 
inner join tbtemporadas tem ON tem.idtemporadas = j.reftemporadas 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbdocumentaciones doc ON doc.iddocumentacion = j.refdocumentaciones 
inner join tbmotivoshabilitacionestransitorias mot ON mot.idmotivoshabilitacionestransitoria = j.refmotivoshabilitacionestransitorias 
left join dbequipos equ ON equ.idequipo = j.refequipos 
inner join tbcategorias cat ON cat.idtcategoria = j.refcategorias 
where j.refjugadores = ".$idJugador."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresmotivoshabilitacionestransitoriasPorJugadorDeportiva($idJugador, $reftemporada, $refcategoria, $refequipos) { 
$sql = "select 
j.iddbjugadormotivohabilitaciontransitoria,
tem.temporada,
doc.descripcion as documentacion,
mot.descripcion as motivos,
equ.nombre as equipo,
cat.categoria,
j.reftemporadas,
j.refjugadores,
j.refdocumentaciones,
j.refmotivoshabilitacionestransitorias,
j.refequipos,
j.refcategorias,
j.fechalimite,
j.observaciones
from dbjugadoresmotivoshabilitacionestransitorias j 
inner join tbtemporadas tem ON tem.idtemporadas = j.reftemporadas 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbdocumentaciones doc ON doc.iddocumentacion = j.refdocumentaciones 
inner join tbmotivoshabilitacionestransitorias mot ON mot.idmotivoshabilitacionestransitoria = j.refmotivoshabilitacionestransitorias 
inner join dbequipos equ ON equ.idequipo = j.refequipos 
inner join tbcategorias cat ON cat.idtcategoria = j.refcategorias 
where j.refjugadores = ".$idJugador." and mot.descripcion = 'Edad'
	  and j.reftemporadas = ".$reftemporada."
	  and j.refequipos = ".$refequipos."
	  and j.refcategorias = ".$refcategoria."
	  and (now() < j.fechalimite or j.fechalimite is null)
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 

function traerJugadoresmotivoshabilitacionestransitoriasPorJugadorAdministrativa($idJugador) { 
$sql = "select 
j.iddbjugadormotivohabilitaciontransitoria,
tem.temporada,
doc.descripcion as documentacion,
mot.descripcion as motivos,
equ.nombre as equipo,
cat.categoria,
j.reftemporadas,
j.refjugadores,
j.refdocumentaciones,
j.refmotivoshabilitacionestransitorias,
j.refequipos,
j.refcategorias,
j.fechalimite,
j.observaciones
from dbjugadoresmotivoshabilitacionestransitorias j 
inner join tbtemporadas tem ON tem.idtemporadas = j.reftemporadas 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbdocumentaciones doc ON doc.iddocumentacion = j.refdocumentaciones 
inner join tbmotivoshabilitacionestransitorias mot ON mot.idmotivoshabilitacionestransitoria = j.refmotivoshabilitacionestransitorias 
left join dbequipos equ ON equ.idequipo = j.refequipos 
inner join tbcategorias cat ON cat.idtcategoria = j.refcategorias 
where j.refjugadores = ".$idJugador." and doc.descripcion <> 'Edad'
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 



function traerJugadoresmotivoshabilitacionestransitoriasPorJugadorAdministrativaDocumentacion($idJugador, $idDocumentacion) { 

$resTemporadas = $this->traerUltimaTemporada();	

if (mysql_num_rows($resTemporadas)>0) {
	$ultimaTemporada = mysql_result($resTemporadas,0,0);	
} else {
	$ultimaTemporada = 0;	
}
	
$sql = "select 
j.iddbjugadormotivohabilitaciontransitoria,
tem.temporada,
doc.descripcion as documentacion,
mot.descripcion as motivos,
equ.nombre as equipo,
cat.categoria,
j.reftemporadas,
j.refjugadores,
j.refdocumentaciones,
j.refmotivoshabilitacionestransitorias,
j.refequipos,
j.refcategorias,
j.fechalimite,
j.observaciones
from dbjugadoresmotivoshabilitacionestransitorias j 
inner join tbtemporadas tem ON tem.idtemporadas = j.reftemporadas 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbdocumentaciones doc ON doc.iddocumentacion = j.refdocumentaciones 
inner join tbmotivoshabilitacionestransitorias mot ON mot.idmotivoshabilitacionestransitoria = j.refmotivoshabilitacionestransitorias 
left join dbequipos equ ON equ.idequipo = j.refequipos 
inner join tbcategorias cat ON cat.idtcategoria = j.refcategorias 
where j.refjugadores = ".$idJugador." and doc.descripcion <> 'Edad' and doc.iddocumentacion = ".$idDocumentacion." and tem.idtemporadas = ".$ultimaTemporada."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
}


function traerJugadoresmotivoshabilitacionestransitoriasPorId($id) { 
$sql = "select iddbjugadormotivohabilitaciontransitoria,reftemporadas,refjugadores,refdocumentaciones,refmotivoshabilitacionestransitorias,refequipos,refcategorias,fechalimite,observaciones from dbjugadoresmotivoshabilitacionestransitorias where iddbjugadormotivohabilitaciontransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbjugadoresmotivoshabilitacionestransitorias*/


function insertarJugadoresvaloreshabilitacionestransitorias($refjugadores,$refvaloreshabilitacionestransitorias) { 
$sql = "insert into dbjugadoresvaloreshabilitacionestransitorias(iddbjugadorvalorhabilitaciontransitoria,refjugadores,refvaloreshabilitacionestransitorias) 
values ('',".$refjugadores.",".$refvaloreshabilitacionestransitorias.")"; 
$res = $this->query($sql,1); 
return $sql; 
} 


function modificarJugadoresvaloreshabilitacionestransitorias($id,$refjugadores,$refvaloreshabilitacionestransitorias) { 
$sql = "update dbjugadoresvaloreshabilitacionestransitorias 
set 
refjugadores = ".$refjugadores.",refvaloreshabilitacionestransitorias = ".$refvaloreshabilitacionestransitorias." 
where iddbjugadorvalorhabilitaciontransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarJugadoresvaloreshabilitacionestransitorias($id) { 
$sql = "delete from dbjugadoresvaloreshabilitacionestransitorias where iddbjugadorvalorhabilitaciontransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

function eliminarJugadoresvaloreshabilitacionestransitoriasPorJuagador($idJuagador) { 
$sql = "delete from dbjugadoresvaloreshabilitacionestransitorias where refjugadores =".$idJuagador; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresvaloreshabilitacionestransitorias() { 
$sql = "select 
j.iddbjugadorvalorhabilitaciontransitoria,
j.refjugadores,
j.refvaloreshabilitacionestransitorias
from dbjugadoresvaloreshabilitacionestransitorias j 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join tbvaloreshabilitacionestransitorias val ON val.idvalorhabilitaciontransitoria = j.refvaloreshabilitacionestransitorias 
inner join tbdocumentaciones do ON do.iddocumentacion = val.refdocumentaciones 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerJugadoresvaloreshabilitacionestransitoriasPorId($id) { 
$sql = "select iddbjugadorvalorhabilitaciontransitoria,refjugadores,refvaloreshabilitacionestransitorias from dbjugadoresvaloreshabilitacionestransitorias where iddbjugadorvalorhabilitaciontransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

function traerJugadoresvaloreshabilitacionestransitoriasPorJugador($idJugador) { 
$sql = "select 
j.refvaloreshabilitacionestransitorias,
v.descripcion,
(case when v.habilita= 1 then 'Si' else 'No' end) as habilita,
j.iddbjugadorvalorhabilitaciontransitoria,
j.refjugadores
from dbjugadoresvaloreshabilitacionestransitorias j 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join tbvaloreshabilitacionestransitorias val ON val.idvalorhabilitaciontransitoria = j.refvaloreshabilitacionestransitorias 
inner join tbdocumentaciones do ON do.iddocumentacion = val.refdocumentaciones 
where j.refjugadores = ".$idJugador."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 

function traerJugadoresvaloreshabilitacionestransitoriasPorJugadorDocumentacion($idJugador, $idDocumentacion) { 
$sql = "select 
j.refvaloreshabilitacionestransitorias,
v.descripcion,
(case when v.habilita= 1 then 'Si' else 'No' end) as habilita,
j.iddbjugadorvalorhabilitaciontransitoria,
j.refjugadores
from dbjugadoresvaloreshabilitacionestransitorias j 
inner join dbjugadores jug ON jug.idjugador = j.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join tbvaloreshabilitacionestransitorias val ON val.idvalorhabilitaciontransitoria = j.refvaloreshabilitacionestransitorias 
inner join tbdocumentaciones do ON do.iddocumentacion = val.refdocumentaciones 
where j.refjugadores = ".$idJugador." and do.iddocumentacion = ".$idDocumentacion."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbjugadoresvaloreshabilitacionestransitorias*/

function noPredeterminarTodo($refdocumentaciones) {
	$sql = "update tbvaloreshabilitacionestransitorias set predeterminado = 0 where refdocumentaciones = ".$refdocumentaciones;	
	$res = $this->query($sql,0);
	return $res;
}

function insertarValoreshabilitacionestransitorias($refdocumentaciones,$descripcion,$habilita,$predeterminado) { 
$sql = "insert into tbvaloreshabilitacionestransitorias(idvalorhabilitaciontransitoria,refdocumentaciones,descripcion,habilita,predeterminado) 
values ('',".$refdocumentaciones.",'".($descripcion)."',".$habilita.",".$predeterminado.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarValoreshabilitacionestransitorias($id,$refdocumentaciones,$descripcion,$habilita,$predeterminado) { 
$sql = "update tbvaloreshabilitacionestransitorias 
set 
refdocumentaciones = ".$refdocumentaciones.",descripcion = '".($descripcion)."',habilita = ".$habilita.",predeterminado = ".$predeterminado." 
where idvalorhabilitaciontransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarValoreshabilitacionestransitorias($id) { 
$sql = "delete from tbvaloreshabilitacionestransitorias where idvalorhabilitaciontransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerValoreshabilitacionestransitorias() { 
$sql = "select 
v.idvalorhabilitaciontransitoria,
doc.descripcion as documentacion,
v.descripcion,
(case when v.habilita= 1 then 'Si' else 'No' end) as habilita,
(case when v.predeterminado= 1 then 'Si' else 'No' end) as pordefecto,
v.refdocumentaciones
from tbvaloreshabilitacionestransitorias v 
inner join tbdocumentaciones doc ON doc.iddocumentacion = v.refdocumentaciones 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerValoreshabilitacionestransitoriasPorId($id) { 
$sql = "select idvalorhabilitaciontransitoria,refdocumentaciones,descripcion,habilita,predeterminado as pordefecto from tbvaloreshabilitacionestransitorias where idvalorhabilitaciontransitoria =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerValoreshabilitacionestransitoriasPorDocumentacion($idDocumentacion) { 
$sql = "select 
v.idvalorhabilitaciontransitoria,
doc.descripcion as documentacion,
v.descripcion,
(case when v.habilita= 1 then 'Si' else 'No' end) as habilita,
(case when v.predeterminado= 1 then 'Si' else 'No' end) as pordefecto,
v.refdocumentaciones
from tbvaloreshabilitacionestransitorias v 
inner join tbdocumentaciones doc ON doc.iddocumentacion = v.refdocumentaciones  
where doc.iddocumentacion = ".$idDocumentacion."
order by v.predeterminado desc"; 
$res = $this->query($sql,0); 
return $res; 
} 

function traerValoreshabilitacionestransitoriasPorDocumentacionJugadorActivas($idDocumentacion, $idJugador) {
$sql = "select 
v.idvalorhabilitaciontransitoria,
doc.descripcion as documentacion,
v.descripcion,
(case when v.habilita= 1 then 'Si' else 'No' end) as habilita,
coalesce(jvh.iddbjugadorvalorhabilitaciontransitoria,0) as seleccionado,
v.refdocumentaciones
from tbvaloreshabilitacionestransitorias v 
inner join tbdocumentaciones doc ON doc.iddocumentacion = v.refdocumentaciones  
left join dbjugadoresvaloreshabilitacionestransitorias jvh 
on jvh.refvaloreshabilitacionestransitorias = v.idvalorhabilitaciontransitoria and jvh.refjugadores = ".$idJugador."
where doc.iddocumentacion = ".$idDocumentacion."
order by 1";
$res = $this->query($sql,0); 
return $res; 	
}


/* /* Fin de la Tabla: tbvaloreshabilitacionestransitorias*/


//////////  Funciones para la etapa 3 y 4  //////////////////

//////// TABLAS ////////////////////////////////////////////
/*********************************************************************************

dbtorneos
dbequipos
tbpuntobonus
tbtiposanciones
tbfechasexcluidas
tbestadospartidos
dbdefinicionescategoriastemporadas
dbdefinicionescategoriastemporadastipojugador
definicionessancionesacumuladastempordas

**************************************************/


/* PARA Torneos */


/* PARA Tipotorneo */

function insertarTipotorneo($tipotorneo) { 
$sql = "insert into tbtipotorneo(idtipotorneo,tipotorneo) 
values ('','".($tipotorneo)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarTipotorneo($id,$tipotorneo) { 
$sql = "update tbtipotorneo 
set 
tipotorneo = '".($tipotorneo)."' 
where idtipotorneo =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarTipotorneo($id) { 
$sql = "delete from tbtipotorneo where idtipotorneo =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipotorneo() { 
$sql = "select 
t.idtipotorneo,
t.tipotorneo
from tbtipotorneo t 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTipotorneoPorId($id) { 
$sql = "select idtipotorneo,tipotorneo from tbtipotorneo where idtipotorneo =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbtipotorneo*/


function desactivarTorneos($idTorneo,$reftipotorneo,$reftemporadas,$refcategorias,$refdivisiones) {
	$sql = "update dbtorneos set activo = 0 where reftipotorneo=".$reftipotorneo." and reftemporadas=".$reftemporadas." and refcategorias=".$refcategorias." and refdivisiones=".$refdivisiones." and idtorneo <>".$idTorneo;
	$res = $this->query($sql,0); 
	return $res; 
}

function correrfechafixture($idtorneo, $nuevafecha, $fechadesde) {
	$ultimaFecha = $this->traerUltimaFechaFixtureSinEstadoPorTorneo($idtorneo);
	
	$diferencia = $ultimaFecha - $fechadesde;
	
	$cambios = 0;
	for ($i=$ultimaFecha; $i>=$fechadesde;$i--) {
		
		$this->modificarFixtureFechaPorRefFecha($idtorneo, $i, $nuevafecha);		
		$cambios += 1;
		$nuevafecha = strtotime ( '-7 day' , strtotime ( $nuevafecha ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
	}
	
	return 'Se modificaron '.$cambios.' fechas del torneo';
}

function insertarTorneos($descripcion,$reftipotorneo,$reftemporadas,$refcategorias,$refdivisiones,$cantidadascensos,$cantidaddescensos,$respetadefiniciontipojugadores,$respetadefinicionhabilitacionestransitorias,$respetadefinicionsancionesacumuladas,$acumulagoleadores,$acumulatablaconformada,$observaciones,$activo) { 
$sql = "insert into dbtorneos(idtorneo,descripcion,reftipotorneo,reftemporadas,refcategorias,refdivisiones,cantidadascensos,cantidaddescensos,respetadefiniciontipojugadores,respetadefinicionhabilitacionestransitorias,respetadefinicionsancionesacumuladas,acumulagoleadores,acumulatablaconformada,observaciones,activo) 
values ('','".($descripcion)."',".$reftipotorneo.",".$reftemporadas.",".$refcategorias.",".$refdivisiones.",".($cantidadascensos == '' ? 0 : $cantidadascensos).",".($cantidaddescensos == '' ? 0 : $cantidaddescensos).",".$respetadefiniciontipojugadores.",".$respetadefinicionhabilitacionestransitorias.",".$respetadefinicionsancionesacumuladas.",".$acumulagoleadores.",".$acumulatablaconformada.",'".($observaciones)."',".$activo.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarTorneos($id,$descripcion,$reftipotorneo,$reftemporadas,$refcategorias,$refdivisiones,$cantidadascensos,$cantidaddescensos,$respetadefiniciontipojugadores,$respetadefinicionhabilitacionestransitorias,$respetadefinicionsancionesacumuladas,$acumulagoleadores,$acumulatablaconformada,$observaciones,$activo) { 
$sql = "update dbtorneos 
set 
descripcion = '".($descripcion)."',reftipotorneo = ".$reftipotorneo.",reftemporadas = ".$reftemporadas.",refcategorias = ".$refcategorias.",refdivisiones = ".$refdivisiones.",cantidadascensos = ".($cantidadascensos == '' ? 0 : $cantidadascensos).",cantidaddescensos = ".($cantidaddescensos == '' ? 0 : $cantidaddescensos).",respetadefiniciontipojugadores = ".$respetadefiniciontipojugadores.",respetadefinicionhabilitacionestransitorias = ".$respetadefinicionhabilitacionestransitorias.",respetadefinicionsancionesacumuladas = ".$respetadefinicionsancionesacumuladas.",acumulagoleadores = ".$acumulagoleadores.",acumulatablaconformada = ".$acumulatablaconformada.",observaciones = '".($observaciones)."',activo = ".$activo." 
where idtorneo =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarTorneos($id) { 
$sql = "delete from dbtorneos where idtorneo =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTorneos() { 
$sql = "select 
t.idtorneo,
t.descripcion,
tip.tipotorneo as tipotorneo,
tem.temporada,
cat.categoria,
di.division,
t.cantidadascensos,
t.cantidaddescensos,
(case when t.respetadefiniciontipojugadores = 1 then 'Si' else 'No' end) as respetadefiniciontipojugadores,
(case when t.respetadefinicionhabilitacionestransitorias = 1 then 'Si' else 'No' end) as respetadefinicionhabilitacionestransitorias,
(case when t.respetadefinicionsancionesacumuladas = 1 then 'Si' else 'No' end) as respetadefinicionsancionesacumuladas,
(case when t.acumulagoleadores = 1 then 'Si' else 'No' end) as acumulagoleadores,
(case when t.acumulatablaconformada = 1 then 'Si' else 'No' end) as acumulatablaconformada,
observaciones,
(case when t.activo = 1 then 'Si' else 'No' end) as activo,
t.reftipotorneo,
t.reftemporadas,
t.refcategorias,
t.refdivisiones
from dbtorneos t 
inner join tbtipotorneo tip ON tip.idtipotorneo = t.reftipotorneo 
inner join tbtemporadas tem ON tem.idtemporadas = t.reftemporadas 
inner join tbcategorias cat ON cat.idtcategoria = t.refcategorias 
inner join tbdivisiones di ON di.iddivision = t.refdivisiones 
order by tem.temporada, t.idtorneo desc"; 
$res = $this->query($sql,0); 
return $res; 
}  


function traerTorneosActivos() { 

$resTemporadas = $this->traerUltimaTemporada();	

if (mysql_num_rows($resTemporadas)>0) {
	$ultimaTemporada = mysql_result($resTemporadas,0,0);	
} else {
	$ultimaTemporada = 0;	
}

$sql = "select 
t.idtorneo,
t.descripcion,
tip.tipotorneo as tipotorneo,
tem.temporada,
cat.categoria,
di.division,
t.cantidadascensos,
t.cantidaddescensos,
t.respetadefiniciontipojugadores,
t.respetadefinicionhabilitacionestransitorias,
t.respetadefinicionsancionesacumuladas,
t.acumulagoleadores,
t.acumulatablaconformada,
t.observaciones,
t.activo,
t.reftipotorneo,
t.reftemporadas,
t.refcategorias,
t.refdivisiones
from dbtorneos t 
inner join tbtipotorneo tip ON tip.idtipotorneo = t.reftipotorneo 
inner join tbtemporadas tem ON tem.idtemporadas = t.reftemporadas 
inner join tbcategorias cat ON cat.idtcategoria = t.refcategorias 
inner join tbdivisiones di ON di.iddivision = t.refdivisiones 
where t.activo = 1 and t.reftemporadas = ".$ultimaTemporada."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
}  


function traerTorneosPorId($id) { 
$sql = "select idtorneo,descripcion,reftipotorneo,reftemporadas,refcategorias,refdivisiones,cantidadascensos,cantidaddescensos,
(case when respetadefiniciontipojugadores = 1 then 'Si' else 'No' end) as respetadefiniciontipojugadores,
(case when respetadefinicionhabilitacionestransitorias = 1 then 'Si' else 'No' end) as respetadefinicionhabilitacionestransitorias,
(case when respetadefinicionsancionesacumuladas = 1 then 'Si' else 'No' end) as respetadefinicionsancionesacumuladas,
(case when acumulagoleadores = 1 then 'Si' else 'No' end) as acumulagoleadores,
(case when acumulatablaconformada = 1 then 'Si' else 'No' end) as acumulatablaconformada,
observaciones,
(case when activo = 1 then 'Si' else 'No' end) as activo from dbtorneos where idtorneo =".$id; 
$res = $this->query($sql,0); 
return $res;
} 


function traerTorneosPorTemporada($idTemporada) { 
$sql = "select idtorneo,descripcion,reftipotorneo,reftemporadas,refcategorias,refdivisiones,cantidadascensos,cantidaddescensos,
(case when respetadefiniciontipojugadores = 1 then 'Si' else 'No' end) as respetadefiniciontipojugadores,
(case when respetadefinicionhabilitacionestransitorias = 1 then 'Si' else 'No' end) as respetadefinicionhabilitacionestransitorias,
(case when respetadefinicionsancionesacumuladas = 1 then 'Si' else 'No' end) as respetadefinicionsancionesacumuladas,
(case when acumulagoleadores = 1 then 'Si' else 'No' end) as acumulagoleadores,
(case when acumulatablaconformada = 1 then 'Si' else 'No' end) as acumulatablaconformada,
observaciones,
(case when activo = 1 then 'Si' else 'No' end) as activo from dbtorneos where reftemporadas =".$idTemporada; 
$res = $this->query($sql,0); 
return $res;
} 


function traerTorneosDetallePorId($id) { 
$sql = "select 
t.idtorneo,
t.descripcion,
tip.tipotorneo as tipotorneo,
tem.temporada,
cat.categoria,
di.division,
t.cantidadascensos,
t.cantidaddescensos,
t.respetadefiniciontipojugadores,
t.respetadefinicionhabilitacionestransitorias,
t.respetadefinicionsancionesacumuladas,
t.acumulagoleadores,
t.acumulatablaconformada,
t.observaciones,
t.activo,
t.reftipotorneo,
t.reftemporadas,
t.refcategorias,
t.refdivisiones
from dbtorneos t 
inner join tbtipotorneo tip ON tip.idtipotorneo = t.reftipotorneo 
inner join tbtemporadas tem ON tem.idtemporadas = t.reftemporadas 
inner join tbcategorias cat ON cat.idtcategoria = t.refcategorias 
inner join tbdivisiones di ON di.iddivision = t.refdivisiones 
where t.idtorneo = ".$id."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
}  

/* Fin */
/* /* Fin de la Tabla: dbtorneos*/


/* PARA Equipos */

function insertarEquipos($refcountries,$nombre,$refcategorias,$refdivisiones,$refcontactos,$fechaalta,$fachebaja,$activo) { 
$sql = "insert into dbequipos(idequipo,refcountries,nombre,refcategorias,refdivisiones,refcontactos,fechaalta,fachebaja,activo) 
values ('',".$refcountries.",'".($nombre)."',".$refcategorias.",".$refdivisiones.",".$refcontactos.",'".($fechaalta)."','".($fachebaja)."',".$activo.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarEquipos($id,$refcountries,$nombre,$refcategorias,$refdivisiones,$refcontactos,$fechaalta,$fachebaja,$activo) { 
$sql = "update dbequipos 
set 
refcountries = ".$refcountries.",nombre = '".($nombre)."',refcategorias = ".$refcategorias.",refdivisiones = ".$refdivisiones.",refcontactos = ".$refcontactos.",fechaalta = '".($fechaalta)."',fachebaja = '".($fachebaja)."',activo = ".$activo." 
where idequipo =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarEquipos($id) { 
$sql = "update dbequipos set activo = 0, fachebaja = '".date('Y-m-d')."' where idequipo =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEquipos() { 
$sql = "select 
e.idequipo,
cou.nombre as countrie,
e.nombre,
cat.categoria,
di.division,
con.nombre as contacto,
e.fechaalta,
e.fachebaja,
(case when e.activo=1 then 'Si' else 'No' end) as activo,
e.refcountries,
e.refcategorias,
e.refdivisiones,
e.refcontactos
from dbequipos e 
inner join dbcountries cou ON cou.idcountrie = e.refcountries 
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
inner join tbcategorias cat ON cat.idtcategoria = e.refcategorias 
inner join tbdivisiones di ON di.iddivision = e.refdivisiones 
inner join dbcontactos con ON con.idcontacto = e.refcontactos 
inner join tbtipocontactos ti ON ti.idtipocontacto = con.reftipocontactos 
order by e.nombre"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEquiposPorEquipo($idEquipo) { 
$sql = "select 
e.idequipo,
cou.nombre as countrie,
e.nombre,
cat.categoria,
di.division,
con.nombre as contacto,
e.fechaalta,
e.fachebaja,
(case when e.activo=1 then 'Si' else 'No' end) as activo,
e.refcountries,
e.refcategorias,
e.refdivisiones,
e.refcontactos
from dbequipos e 
inner join dbcountries cou ON cou.idcountrie = e.refcountries 
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
inner join tbcategorias cat ON cat.idtcategoria = e.refcategorias 
inner join tbdivisiones di ON di.iddivision = e.refdivisiones 
inner join dbcontactos con ON con.idcontacto = e.refcontactos 
inner join tbtipocontactos ti ON ti.idtipocontacto = con.reftipocontactos 
where e.idequipo =".$idEquipo." 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEquiposPorEquipoIn($lstEquipo) { 
$sql = "select 
e.idequipo,
cou.nombre as countrie,
e.nombre,
cat.categoria,
di.division,
con.nombre as contacto,
e.fechaalta,
e.fachebaja,
(case when e.activo=1 then 'Si' else 'No' end) as activo,
e.refcountries,
e.refcategorias,
e.refdivisiones,
e.refcontactos
from dbequipos e 
inner join dbcountries cou ON cou.idcountrie = e.refcountries 
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
inner join tbcategorias cat ON cat.idtcategoria = e.refcategorias 
inner join tbdivisiones di ON di.iddivision = e.refdivisiones 
inner join dbcontactos con ON con.idcontacto = e.refcontactos 
inner join tbtipocontactos ti ON ti.idtipocontacto = con.reftipocontactos 
where e.idequipo in (".$lstEquipo.") 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEquiposPorId($id) { 
$sql = "select idequipo,refcountries,nombre,refcategorias,refdivisiones,refcontactos,fechaalta,fachebaja,(case when activo = 1 then 'Si' else 'No' end) as activo from dbequipos where idequipo =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEquiposPorCountries($idCountrie) { 
$sql = "select 
e.idequipo,
cou.nombre as countrie,
e.nombre,
cat.categoria,
di.division,
con.nombre as contacto,
e.fechaalta,
e.fachebaja,
(case when e.activo=1 then 'Si' else 'No' end) as activo,
e.refcountries,
e.refcategorias,
e.refdivisiones,
e.refcontactos
from dbequipos e 
inner join dbcountries cou ON cou.idcountrie = e.refcountries 
inner join tbposiciontributaria po ON po.idposiciontributaria = cou.refposiciontributaria 
inner join tbcategorias cat ON cat.idtcategoria = e.refcategorias 
inner join tbdivisiones di ON di.iddivision = e.refdivisiones 
inner join dbcontactos con ON con.idcontacto = e.refcontactos 
inner join tbtipocontactos ti ON ti.idtipocontacto = con.reftipocontactos 
where cou.idcountrie = ".$idCountrie."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerCategoriaPorEquipo($idEquipo) { 
$sql = "select 
e.idequipo,
cat.categoria
from dbequipos e 
inner join tbcategorias cat ON cat.idtcategoria = e.refcategorias 
where e.idequipo = ".$idEquipo."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEquipoPorCategoriaCountrie($idCategoria, $idCountrie) { 
$sql = "select 
e.idequipo,
e.nombre
from dbequipos e 
inner join tbcategorias cat ON cat.idtcategoria = e.refcategorias 
where cat.idtcategoria = ".$idCategoria." and e.refcountries = ".$idCountrie."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEquipoPorTorneo($idTorneo) { 
$sql = "select 
e.idequipo,
e.nombre,
(case when e.activo = 1 then 'Si' else 'No' end) as activo
from dbequipos e 
inner join dbtorneos t on e.refcategorias = t.refcategorias and e.refdivisiones = t.refdivisiones
where t.idtorneo = ".$idTorneo."
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
}


/* Fin */
/* /* Fin de la Tabla: dbequipos*/

/* PARA Puntobonus */

function insertarPuntobonus($descripcion,$cantidadfechas,$consecutivas,$comparacion,$valoracomparar,$puntosextra) { 
$sql = "insert into tbpuntobonus(idpuntobonus,descripcion,cantidadfechas,consecutivas,comparacion,valoracomparar,puntosextra) 
values ('','".($descripcion)."',".$cantidadfechas.",".$consecutivas.",'".$comparacion."',".$valoracomparar.",".$puntosextra.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarPuntobonus($id,$descripcion,$cantidadfechas,$consecutivas,$comparacion,$valoracomparar,$puntosextra) { 
$sql = "update tbpuntobonus 
set 
descripcion = '".($descripcion)."',cantidadfechas = ".$cantidadfechas.",consecutivas = ".$consecutivas.",comparacion = '".$comparacion."',valoracomparar = ".$valoracomparar.",puntosextra = ".$puntosextra." 
where idpuntobonus =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarPuntobonus($id) { 
$sql = "delete from tbpuntobonus where idpuntobonus =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerPuntobonus() { 
$sql = "select 
p.idpuntobonus,
p.descripcion,
p.cantidadfechas,
(case when p.consecutivas = 1 then 'Si' else 'No' end) as consecutivas,
p.comparacion,
p.valoracomparar,
p.puntosextra
from tbpuntobonus p 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerPuntobonusPorId($id) { 
$sql = "select idpuntobonus,descripcion,cantidadfechas,consecutivas,comparacion,valoracomparar,puntosextra from tbpuntobonus where idpuntobonus =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbpuntobonus*/


/* PARA Torneopuntobonus */

function insertarTorneopuntobonus($reftorneos,$refpuntobonus) { 

	$sqlExiste = "select idtorneopuntobonus from dbtorneopuntobonus where reftorneos=".$reftorneos;
	
	$existe = $this->existeDevuelveId($sqlExiste);
	
	if ($existe == 0) {
		$sql = "insert into dbtorneopuntobonus(idtorneopuntobonus,reftorneos,refpuntobonus) 
		values ('',".$reftorneos.",".$refpuntobonus.")"; 
		$res = $this->query($sql,1); 
		return $res; 
	} else {
		return $existe;	
	}
} 


function modificarTorneopuntobonus($id,$reftorneos,$refpuntobonus) { 
$sql = "update dbtorneopuntobonus 
set 
reftorneos = ".$reftorneos.",refpuntobonus = ".$refpuntobonus." 
where idtorneopuntobonus =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 



function eliminarTorneopuntobonus($id) { 
$sql = "delete from dbtorneopuntobonus where idtorneopuntobonus =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarTorneopuntobonusPorTorneo($idTorneo) { 
$sql = "delete from dbtorneopuntobonus where reftorneos =".$idTorneo; 
$res = $this->query($sql,0); 
return $res; 
}


function traerTorneopuntobonus() { 
$sql = "select 
t.idtorneopuntobonus,
t.reftorneos,
t.refpuntobonus
from dbtorneopuntobonus t 
inner join dbtorneos tor ON tor.idtorneo = t.reftorneos 
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo 
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas 
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias 
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones 
inner join tbpuntobonus pun ON pun.idpuntobonus = t.refpuntobonus 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTorneopuntobonusPorId($id) { 
$sql = "select idtorneopuntobonus,reftorneos,refpuntobonus from dbtorneopuntobonus where idtorneopuntobonus =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

function traerTorneopuntobonusPorTorneo($idTorneo) { 
$sql = "select idtorneopuntobonus,reftorneos,refpuntobonus from dbtorneopuntobonus where reftorneos =".$idTorneo; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbtorneopuntobonus*/



/* PARA Tiposanciones */

function insertarTiposanciones($expulsion,$amonestacion,$descripcion,$cantminfechas,$abreviatura,$cantmaxfechas,$cumpletodascategorias,$llevapendiente,$ocultardetallepublico) { 
$sql = "insert into tbtiposanciones(idtiposancion,expulsion,amonestacion,descripcion,cantminfechas,abreviatura,cantmaxfechas,cumpletodascategorias,llevapendiente,ocultardetallepublico) 
values ('',".$expulsion.",".$amonestacion.",'".($descripcion)."',".$cantminfechas.",'".($abreviatura)."',".$cantmaxfechas.",".$cumpletodascategorias.",".$llevapendiente.",".$ocultardetallepublico.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarTiposanciones($id,$expulsion,$amonestacion,$descripcion,$cantminfechas,$abreviatura,$cantmaxfechas,$cumpletodascategorias,$llevapendiente,$ocultardetallepublico) { 
$sql = "update tbtiposanciones 
set 
expulsion = ".$expulsion.",amonestacion = ".$amonestacion.",descripcion = '".($descripcion)."',cantminfechas = ".$cantminfechas.",abreviatura = '".($abreviatura)."',cantmaxfechas = ".$cantmaxfechas.",cumpletodascategorias = ".$cumpletodascategorias.",llevapendiente = ".$llevapendiente.",ocultardetallepublico = ".$ocultardetallepublico." 
where idtiposancion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarTiposanciones($id) { 
$sql = "delete from tbtiposanciones where idtiposancion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTiposanciones() { 
$sql = "select 
t.idtiposancion,
(case when t.expulsion = 1 then 'Si' else 'No' end) as expulsion,
(case when t.amonestacion = 1 then 'Si' else 'No' end) as amonestacion,
t.descripcion,
t.cantminfechas,
t.abreviatura,
t.cantmaxfechas,
(case when t.cumpletodascategorias = 1 then 'Si' else 'No' end) as cumpletodascategorias,
(case when t.llevapendiente = 1 then 'Si' else 'No' end) as llevapendiente,
(case when t.ocultardetallepublico = 1 then 'Si' else 'No' end) as ocultardetallepublico
from tbtiposanciones t 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerTiposancionesPorId($id) { 
$sql = "select idtiposancion,expulsion,amonestacion,descripcion,cantminfechas,abreviatura,cantmaxfechas,cumpletodascategorias,llevapendiente,ocultardetallepublico from tbtiposanciones where idtiposancion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbtiposanciones*/


/* PARA Fechasexcluidas */

function insertarFechasexcluidas($fecha,$descripcion) { 
$sql = "insert into tbfechasexcluidas(idfechaexcluida,fecha,descripcion) 
values ('','".($fecha)."','".($descripcion)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarFechasexcluidas($id,$fecha,$descripcion) { 
$sql = "update tbfechasexcluidas 
set 
fecha = '".($fecha)."',descripcion = '".($descripcion)."' 
where idfechaexcluida =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarFechasexcluidas($id) { 
$sql = "delete from tbfechasexcluidas where idfechaexcluida =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerFechasexcluidas() { 
$sql = "select 
f.idfechaexcluida,
f.fecha,
f.descripcion
from tbfechasexcluidas f 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerFechasexcluidasPorId($id) { 
$sql = "select idfechaexcluida,fecha,descripcion from tbfechasexcluidas where idfechaexcluida =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbfechasexcluidas*/


/* PARA Estadospartidos */

function insertarEstadospartidos($descripcion,$defautomatica,$goleslocalauto,$goleslocalborra,$golesvisitanteauto,$golesvisitanteborra,$puntoslocal,$puntosvisitante,$finalizado,$ocultardetallepublico,$visibleparaarbitros) { 
$sql = "insert into tbestadospartidos(idestadopartido,descripcion,defautomatica,goleslocalauto,goleslocalborra,golesvisitanteauto,golesvisitanteborra,puntoslocal,puntosvisitante,finalizado,ocultardetallepublico,visibleparaarbitros) 
values ('','".($descripcion)."',".$defautomatica.",".$goleslocalauto.",".$goleslocalborra.",".$golesvisitanteauto.",".$golesvisitanteborra.",".$puntoslocal.",".$puntosvisitante.",".$finalizado.",".$ocultardetallepublico.",".$visibleparaarbitros.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarEstadospartidos($id,$descripcion,$defautomatica,$goleslocalauto,$goleslocalborra,$golesvisitanteauto,$golesvisitanteborra,$puntoslocal,$puntosvisitante,$finalizado,$ocultardetallepublico,$visibleparaarbitros) { 
$sql = "update tbestadospartidos 
set 
descripcion = '".($descripcion)."',defautomatica = ".$defautomatica.",goleslocalauto = ".$goleslocalauto.",goleslocalborra = ".$goleslocalborra.",golesvisitanteauto = ".$golesvisitanteauto.",golesvisitanteborra = ".$golesvisitanteborra.",puntoslocal = ".$puntoslocal.",puntosvisitante = ".$puntosvisitante.",finalizado = ".$finalizado.",ocultardetallepublico = ".$ocultardetallepublico.",visibleparaarbitros = ".$visibleparaarbitros." 
where idestadopartido =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarEstadospartidos($id) { 
$sql = "delete from tbestadospartidos where idestadopartido =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEstadospartidos() { 
$sql = "select 
e.idestadopartido,
e.descripcion,
e.defautomatica,
e.goleslocalauto,
e.goleslocalborra,
e.golesvisitanteauto,
e.golesvisitanteborra,
e.puntoslocal,
e.puntosvisitante,
e.finalizado,
e.ocultardetallepublico,
e.visibleparaarbitros
,e.contabilizalocal,e.contabilizavisitante
from tbestadospartidos e 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 

function traerEstadospartidosArbitros() { 
$sql = "select 
e.idestadopartido,
e.descripcion,
e.defautomatica,
e.goleslocalauto,
e.goleslocalborra,
e.golesvisitanteauto,
e.golesvisitanteborra,
e.puntoslocal,
e.puntosvisitante,
e.finalizado,
e.ocultardetallepublico,
e.visibleparaarbitros
,e.contabilizalocal,e.contabilizavisitante
from tbestadospartidos e 
where e.visibleparaarbitros = 1
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerEstadospartidosPorId($id) { 
$sql = "select idestadopartido,descripcion,
(case when defautomatica = 1 then 'Si' else 'No' end) as defautomatica,
goleslocalauto,
(case when goleslocalborra = 1 then 'Si' else 'No' end) as goleslocalborra,
golesvisitanteauto,
(case when golesvisitanteborra = 1 then 'Si' else 'No' end) as golesvisitanteborra,
puntoslocal,
puntosvisitante,
(case when finalizado = 1 then 'Si' else 'No' end) as finalizado,
(case when ocultardetallepublico = 1 then 'Si' else 'No' end) as ocultardetallepublico,
(case when visibleparaarbitros = 1 then 'Si' else 'No' end) as visibleparaarbitros,
contabilizalocal,
contabilizavisitante from tbestadospartidos where idestadopartido =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: tbestadospartidos*/


/* PARA Definicionescategoriastemporadas */

function insertarDefinicionescategoriastemporadas($refcategorias,$reftemporadas,$cantmaxjugadores,$cantminjugadores,$refdias,$hora,$minutospartido,$cantidadcambiosporpartido,$conreingreso,$observaciones) {
$sql = "insert into dbdefinicionescategoriastemporadas(iddefinicioncategoriatemporada,refcategorias,reftemporadas,cantmaxjugadores,cantminjugadores,refdias,hora,minutospartido,cantidadcambiosporpartido,conreingreso,observaciones)
values ('',".$refcategorias.",".$reftemporadas.",".$cantmaxjugadores.",".$cantminjugadores.",".$refdias.",'".($hora)."',".$minutospartido.",".$cantidadcambiosporpartido.",".$conreingreso.",'".($observaciones)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarDefinicionescategoriastemporadas($id,$refcategorias,$reftemporadas,$cantmaxjugadores,$cantminjugadores,$refdias,$hora,$minutospartido,$cantidadcambiosporpartido,$conreingreso,$observaciones) {
$sql = "update dbdefinicionescategoriastemporadas
set
refcategorias = ".$refcategorias.",reftemporadas = ".$reftemporadas.",cantmaxjugadores = ".$cantmaxjugadores.",cantminjugadores = ".$cantminjugadores.",refdias = ".$refdias.",hora = '".($hora)."',minutospartido = ".$minutospartido.",cantidadcambiosporpartido = ".$cantidadcambiosporpartido.",conreingreso = ".$conreingreso.",observaciones = '".($observaciones)."'
where iddefinicioncategoriatemporada =".$id;
$res = $this->query($sql,0);
return $res;
} 


function eliminarDefinicionescategoriastemporadas($id) { 
$sql = "delete from dbdefinicionescategoriastemporadas where iddefinicioncategoriatemporada =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDefinicionescategoriastemporadas() { 
$sql = "select 
d.iddefinicioncategoriatemporada,
cat.categoria,
tem.temporada,
d.cantmaxjugadores,
d.cantminjugadores,
di.dia,
d.hora,
d.minutospartido,
d.cantidadcambiosporpartido,
d.conreingreso,
d.observaciones,
d.refcategorias,
d.reftemporadas,
d.refdias
from dbdefinicionescategoriastemporadas d 
inner join tbcategorias cat ON cat.idtcategoria = d.refcategorias 
inner join tbtemporadas tem ON tem.idtemporadas = d.reftemporadas 
inner join tbdias di ON di.iddia = d.refdias
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDefinicionescategoriastemporadasPorTemporadaCategoria($idTemporada, $idCategoria) { 
$sql = "select 
d.iddefinicioncategoriatemporada,
cat.categoria,
tem.temporada,
d.cantmaxjugadores,
d.cantminjugadores,
di.dia,
d.hora,
d.minutospartido,
d.cantidadcambiosporpartido,
d.conreingreso,
d.observaciones,
d.refcategorias,
d.reftemporadas,
d.refdias,
(case when d.conreingreso = 1 then 'Si' else 'No' end) as reingreso
from dbdefinicionescategoriastemporadas d 
inner join tbcategorias cat ON cat.idtcategoria = d.refcategorias 
inner join tbtemporadas tem ON tem.idtemporadas = d.reftemporadas 
inner join tbdias di ON di.iddia = d.refdias 
where cat.idtcategoria = ".$idCategoria." and tem.idtemporadas = ".$idTemporada; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDefinicionescategoriastemporadasPorId($id) { 
$sql = "select iddefinicioncategoriatemporada,refcategorias,reftemporadas,cantmaxjugadores,cantminjugadores,refdias,hora,minutospartido,cantidadcambiosporpartido,(case when conreingreso = 1 then 'Si' else 'No' end) as conreingreso,observaciones from dbdefinicionescategoriastemporadas where iddefinicioncategoriatemporada =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbdefinicionescategoriastemporadas*/



/* PARA Definicionescategoriastemporadastipojugador */


function insertarDefinicionescategoriastemporadastipojugador($refdefinicionescategoriastemporadas,$reftipojugadores,$edadmaxima,$edadminima,$cantjugadoresporequipo,$jugadorescancha,$observaciones) { 
$sql = "insert into dbdefinicionescategoriastemporadastipojugador(iddefinicionescategoriastemporadastipojugador,refdefinicionescategoriastemporadas,reftipojugadores,edadmaxima,edadminima,cantjugadoresporequipo,jugadorescancha,observaciones) 
values ('',".$refdefinicionescategoriastemporadas.",".$reftipojugadores.",".$edadmaxima.",".$edadminima.",".$cantjugadoresporequipo.",".$jugadorescancha.",'".($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarDefinicionescategoriastemporadastipojugador($id,$refdefinicionescategoriastemporadas,$reftipojugadores,$edadmaxima,$edadminima,$cantjugadoresporequipo,$jugadorescancha,$observaciones) { 
$sql = "update dbdefinicionescategoriastemporadastipojugador 
set 
refdefinicionescategoriastemporadas = ".$refdefinicionescategoriastemporadas.",reftipojugadores = ".$reftipojugadores.",edadmaxima = ".$edadmaxima.",edadminima = ".$edadminima.",cantjugadoresporequipo = ".$cantjugadoresporequipo.",jugadorescancha = ".$jugadorescancha.",observaciones = '".($observaciones)."' 
where iddefinicionescategoriastemporadastipojugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarDefinicionescategoriastemporadastipojugador($id) { 
$sql = "delete from dbdefinicionescategoriastemporadastipojugador where iddefinicionescategoriastemporadastipojugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDefinicionescategoriastemporadastipojugador() { 
$sql = "select 
d.iddefinicionescategoriastemporadastipojugador,
concat(ca.categoria, ' - ', te.temporada) as definicioncategoriatemporadas,
tip.tipojugador,
d.edadmaxima,
d.edadminima,
d.cantjugadoresporequipo,
d.jugadorescancha,
d.observaciones,
d.refdefinicionescategoriastemporadas,
d.reftipojugadores
from dbdefinicionescategoriastemporadastipojugador d 
inner join dbdefinicionescategoriastemporadas def ON def.iddefinicioncategoriatemporada = d.refdefinicionescategoriastemporadas 
inner join tbcategorias ca ON ca.idtcategoria = def.refcategorias 
inner join tbtemporadas te ON te.idtemporadas = def.reftemporadas 
inner join tbtipojugadores tip ON tip.idtipojugador = d.reftipojugadores 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDefinicionescategoriastemporadastipojugadorPorId($id) { 
$sql = "select iddefinicionescategoriastemporadastipojugador,refdefinicionescategoriastemporadas,reftipojugadores,edadmaxima,edadminima,cantjugadoresporequipo,jugadorescancha,observaciones from dbdefinicionescategoriastemporadastipojugador where iddefinicionescategoriastemporadastipojugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

function traerDefinicionesPorTemporadaCategoria($idTemporada, $idCategoria) {
	$sql = "select
				max(dct.cantmaxjugadores) as cantmaxjugadores, max(dctj.edadmaxima) as edadmaxima, max(dctj.edadminima) as edadminima, max((dctj.edadmaxima + dctj.edadminima) /2) as promedio
			from		dbdefinicionescategoriastemporadas dct
			inner
			join		dbdefinicionescategoriastemporadastipojugador dctj
			on			dct.iddefinicioncategoriatemporada = dctj.refdefinicionescategoriastemporadas
			where		dct.reftemporadas = ".$idTemporada." and refcategorias = ".$idCategoria;
	$res = $this->query($sql,0); 
	return $res; 	
}

function traerDefinicionesPorTemporadaCategoriaTipoJugador($idTemporada, $idCategoria, $idTipoJugador) {
	$sql = "select
				max(dct.cantmaxjugadores) as cantmaxjugadores, max(dctj.edadmaxima) as edadmaxima, max(dctj.edadminima) as edadminima, max((dctj.edadmaxima + dctj.edadminima) /2) as promedio
			from		dbdefinicionescategoriastemporadas dct
			inner
			join		dbdefinicionescategoriastemporadastipojugador dctj
			on			dct.iddefinicioncategoriatemporada = dctj.refdefinicionescategoriastemporadas
			where		dct.reftemporadas = ".$idTemporada." and refcategorias = ".$idCategoria." and reftipojugadores =".$idTipoJugador;
	$res = $this->query($sql,0); 
	return $res; 	
}

/* Fin */
/* /* Fin de la Tabla: dbdefinicionescategoriastemporadastipojugador*/


/* PARA Definicionessancionesacumuladastemporadas */

function insertarDefinicionessancionesacumuladastemporadas($reftiposanciones,$reftemporadas,$cantidadacumulada,$cantidadfechasacumplir) { 
$sql = "insert into dbdefinicionessancionesacumuladastemporadas(iddefinicionessancionesacumuladastemporadas,reftiposanciones,reftemporadas,cantidadacumulada,cantidadfechasacumplir) 
values ('',".$reftiposanciones.",".$reftemporadas.",".$cantidadacumulada.",".$cantidadfechasacumplir.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarDefinicionessancionesacumuladastemporadas($id,$reftiposanciones,$reftemporadas,$cantidadacumulada,$cantidadfechasacumplir) { 
$sql = "update dbdefinicionessancionesacumuladastemporadas 
set 
reftiposanciones = ".$reftiposanciones.",reftemporadas = ".$reftemporadas.",cantidadacumulada = ".$cantidadacumulada.",cantidadfechasacumplir = ".$cantidadfechasacumplir." 
where iddefinicionessancionesacumuladastemporadas =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarDefinicionessancionesacumuladastemporadas($id) { 
$sql = "delete from dbdefinicionessancionesacumuladastemporadas where iddefinicionessancionesacumuladastemporadas =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDefinicionessancionesacumuladastemporadas() { 
$sql = "select 
d.iddefinicionessancionesacumuladastemporadas,
tip.descripcion as tiposancion,
tem.temporada,
d.cantidadacumulada,
d.cantidadfechasacumplir,
d.reftiposanciones,
d.reftemporadas
from dbdefinicionessancionesacumuladastemporadas d 
inner join tbtiposanciones tip ON tip.idtiposancion = d.reftiposanciones 
inner join tbtemporadas tem ON tem.idtemporadas = d.reftemporadas 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerDefinicionessancionesacumuladastemporadasPorId($id) { 
$sql = "select iddefinicionessancionesacumuladastemporadas,reftiposanciones,reftemporadas,cantidadacumulada,cantidadfechasacumplir from dbdefinicionessancionesacumuladastemporadas where iddefinicionessancionesacumuladastemporadas =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbdefinicionessancionesacumuladastemporadas*/



/* PARA Fechas */

function insertarFechas($fecha) {
$sql = "insert into tbfechas(idfecha,fecha)
values ('','".utf8_decode($fecha)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarFechas($id,$fecha) {
$sql = "update tbfechas
set
fecha = '".utf8_decode($fecha)."'
where idfecha =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarFechas($id) {
$sql = "delete from tbfechas where idfecha =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerFechas() {
$sql = "select
f.idfecha,
f.fecha
from tbfechas f
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerFechasPorId($id) {
$sql = "select idfecha,fecha from tbfechas where idfecha =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbfechas*/


/* PARA Conector */
function actualizarConectoresPorJugador($refJugador, $idconector) {
	$sqlNoActualizar = "SELECT idconector FROM dbconector c
					inner
					join 	dbjugadoresmotivoshabilitacionestransitorias jm
					on		c.refjugadores = jm.refjugadores and c.refequipos = jm.refequipos and c.refcategorias = jm.refcategorias
					where	c.refjugadores = ".$refJugador." and c.activo = 1";
	
	$resConHab = $this->query($sqlNoActualizar,0);
	
	while ($row = mysql_fetch_array($resConHab)){
		$idconector .= ",".$row[0];
	}
	
	$sql = "update dbconector set activo = 0 where refjugadores =".$refJugador." and idconector not in (".$idconector.")";
	$res = $this->query($sql,0);
	return $res;
}

function existeConectorJugadorEquipo($refJugador, $refEquipo) {
	$sql = "select idconector from dbconector where refjugadores =".$refJugador." and refequipos = ".$refEquipo." and activo = 1";
	$res = $this->query($sql,0);
	
	if (mysql_num_rows($res)>0) {
		return 1;	
	}
	return 0;
}


function insertarConector($refjugadores,$reftipojugadores,$refequipos,$refcountries,$refcategorias,$esfusion,$activo) {
$sql = "insert into dbconector(idconector,refjugadores,reftipojugadores,refequipos,refcountries,refcategorias,esfusion,activo)
values ('',".$refjugadores.",".$reftipojugadores.",".$refequipos.",".$refcountries.",".$refcategorias.",".$esfusion.",".$activo.")";
$res = $this->query($sql,1);
return $res;
}


function modificarConector($id,$refjugadores,$reftipojugadores,$refequipos,$refcountries,$refcategorias,$esfusion,$activo) {
$sql = "update dbconector
set
refjugadores = ".$refjugadores.",reftipojugadores = ".$reftipojugadores.",refequipos = ".$refequipos.",refcountries = ".$refcountries.",refcategorias = ".$refcategorias.",esfusion = ".$esfusion.",activo = ".$activo."
where idconector =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarConector($id) {
$sql = "update dbconector set activo = 0 where idconector =".$id;
$res = $this->query($sql,0);
return $res;
}

function eliminarConectorDefinitivamente($id) {
$sql = "delete from dbconector where idconector =".$id;
$res = $this->query($sql,0);
return $res;
}



function eliminarConectorPorJugador($id) {
$sql = "update dbconector set activo = 0 where refjugadores =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerConector($refJugador) {
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
	jug.nrodocumento
    
from
    dbconector c
        inner join
    dbjugadores jug ON jug.idjugador = c.refjugadores
        inner join
    tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos
        inner join
    dbcountries co ON co.idcountrie = c.refcountries
        inner join
    tbtipojugadores tip ON tip.idtipojugador = c.reftipojugadores
        inner join
    dbequipos equ ON equ.idequipo = c.refequipos
        inner join
    tbdivisiones di ON di.iddivision = equ.refdivisiones
        inner join
    dbcontactos con ON con.idcontacto = equ.refcontactos
        inner join
    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
        inner join
    tbcategorias cat ON cat.idtcategoria = c.refcategorias
	where jug.idjugador = ".$refJugador."
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerConectorActivos($refJugador) {
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
	jug.nrodocumento
    
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
    dbcontactos con ON con.idcontacto = equ.refcontactos
        inner join
    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
        inner join
    tbcategorias cat ON cat.idtcategoria = c.refcategorias
	where jug.idjugador = ".$refJugador." and c.activo = 1
order by 1";
$res = $this->query($sql,0);
return $res;
}



function traerConectorCategoriasActivos($refCategorias) {
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
	jug.nrodocumento
    
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
    dbcontactos con ON con.idcontacto = equ.refcontactos
        inner join
    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
        inner join
    tbcategorias cat ON cat.idtcategoria = c.refcategorias
	where cat.idtcategoria = ".$refCategorias." and c.activo = 1
order by 1";
$res = $this->query($sql,0);
return $res;
}



function traerConectorTodosActivos() {
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
	jug.nrodocumento
    
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
    dbcontactos con ON con.idcontacto = equ.refcontactos
        inner join
    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
        inner join
    tbcategorias cat ON cat.idtcategoria = c.refcategorias
	where c.activo = 1
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerConectorActivosPorEquipos($refEquipos) {
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
	year(now()) - year(jug.fechanacimiento) as edad
    
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
    dbcontactos con ON con.idcontacto = equ.refcontactos
        inner join
    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
        inner join
    tbcategorias cat ON cat.idtcategoria = c.refcategorias
	where equ.idequipo = ".$refEquipos." and c.activo = 1
order by concat(jug.apellido,', ',jug.nombres)";
$res = $this->query($sql,0);
return $res;
}


function traerConectorActivosPorEquiposCategorias($refEquipos, $idCategoria) {
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
	year(now()) - year(jug.fechanacimiento) as edad
    
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
    dbcontactos con ON con.idcontacto = equ.refcontactos
        inner join
    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
        inner join
    tbcategorias cat ON cat.idtcategoria = c.refcategorias
	where equ.idequipo = ".$refEquipos." and c.activo = 1 and c.refcategorias = ".$idCategoria."
order by concat(jug.apellido,', ',jug.nombres)";
$res = $this->query($sql,0);
return $res;
}


function traerConectorActivosPorEquiposEdades($refEquipos) {
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
        inner join
    dbcontactos con ON con.idcontacto = equ.refcontactos
        inner join
    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
        inner join
    tbcategorias cat ON cat.idtcategoria = c.refcategorias
	where equ.idequipo = ".$refEquipos." and c.activo = 1";
$res = $this->query($sql,0);
return $res;
}



function traerConectorActivosPorConector($id) {
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
	year(now()) - year(jug.fechanacimiento) as edad
    
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
    dbcontactos con ON con.idcontacto = equ.refcontactos
        inner join
    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
        inner join
    tbcategorias cat ON cat.idtcategoria = c.refcategorias
	where c.idconector =".$id."
order by 1";
$res = $this->query($sql,0);
return $res;
}

function traerJugadoresPorCountries($idCountries) {
	$sql = "select
			j.nrodocumento,
			concat(j.apellido,', ',j.nombres) as apyn,
			j.email,
			j.fechanacimiento,
			j.observaciones
			from		dbjugadores j
			inner
			join		dbcountries cc
			on			cc.idcountrie = j.refcountries
			where		cc.idcountrie = ".$idCountries." and (j.fechabaja = '1900-01-01' or j.fechabaja = '0000-00-00')";	
	$res = $this->query($sql,0);
	return $res;
}

function traerJugadoresVariosEquipos($idtemporada) {
	
	$sql = "select
		j.nrodocumento,
		concat(j.apellido,', ',j.nombres) as apyn,
		j.email,
		j.fechanacimiento,
		count(r.refequipos) as cantidad,
		j.observaciones
		
		from	
		(
		select 
			c.refjugadores,
			c.refequipos
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
			dbcontactos con ON con.idcontacto = equ.refcontactos
				inner join
			tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
				inner join
			tbcategorias cat ON cat.idtcategoria = c.refcategorias
				inner join
			(select distinct fix.refconectorlocal 
				from dbfixture fix 
				inner join dbtorneos t ON t.idtorneo = fix.reftorneos
				where t.reftemporadas = ".$idtemporada.") as fe
			on fe.refconectorlocal = c.refequipos
		where
			c.activo = 1 and (jug.fechabaja = '1900-01-01' or jug.fechabaja = '0000-00-00')
		group by c.refjugadores,
			c.refequipos
		) as r
		inner
		join		dbjugadores j
		on			j.idjugador = r.refjugadores
		group by j.nrodocumento,
		j.apellido,
		j.nombres,
		j.email,
		j.fechanacimiento,
		j.observaciones
		having (count(r.refequipos) > 1)
		order by count(r.refequipos) desc";	
	$res = $this->query($sql,0);
	return $res;


			
				
}


function traerConectorPorId($id) {
$sql = "select idconector,refjugadores,reftipojugadores,refequipos,refcountries,refcategorias,esfusion,activo from dbconector where idconector =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */


function traerDias() {
$sql = "select
d.iddia,
d.dia
from tbdias d
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerDiasPorId($id) {
$sql = "select iddia,dia from tbdias where iddia =".$id;
$res = $this->query($sql,0);
return $res;
} 
/* /* Fin de la Tabla: dbconector*/



/* PARA Fixture */

function traerEtapas() {
$sql = "select idetapa,descripcion,valor from tbetapas order by 1";
$res = $this->query($sql,0);
return $res;
}

function insertarFixture($reftorneos,$reffechas,$refconectorlocal,$refconectorvisitante,$refarbitros,$juez1,$juez2,$refcanchas,$fecha,$hora,$refestadospartidos,$calificacioncancha,$puntoslocal,$puntosvisita,$goleslocal,$golesvisitantes,$observaciones,$publicar) {
$sql = "insert into dbfixture(idfixture,reftorneos,reffechas,refconectorlocal,refconectorvisitante,refarbitros,juez1,juez2,refcanchas,fecha,hora,refestadospartidos,calificacioncancha,puntoslocal,puntosvisita,goleslocal,golesvisitantes,observaciones,publicar)
values ('',".$reftorneos.",".$reffechas.",".$refconectorlocal.",".$refconectorvisitante.",".$refarbitros.",'".utf8_decode($juez1)."','".utf8_decode($juez2)."',".($refcanchas == '' ? 'NULL' : $refcanchas).",'".($fecha)."','".$hora."',".$refestadospartidos.",".$calificacioncancha.",".$puntoslocal.",".$puntosvisita.",".$goleslocal.",".$golesvisitantes.",'".utf8_decode($observaciones)."',".$publicar.")";
$res = $this->query($sql,1);
return $res;
}


function insertarFixtureNuevo($reftorneos,$reffechas,$refconectorlocal,$refconectorvisitante,$refarbitros,$juez1,$juez2,$refcanchas,$fecha,$hora,$refestadospartidos,$calificacioncancha,$puntoslocal,$puntosvisita,$goleslocal,$golesvisitantes,$observaciones,$publicar,$refetapas, $posicion) {
$sql = "insert into dbfixture(idfixture,reftorneos,reffechas,refconectorlocal,refconectorvisitante,refarbitros,juez1,juez2,refcanchas,fecha,hora,refestadospartidos,calificacioncancha,puntoslocal,puntosvisita,goleslocal,golesvisitantes,observaciones,publicar,refetapas,posicion)
values ('',".$reftorneos.",".$reffechas.",".$refconectorlocal.",".$refconectorvisitante.",".$refarbitros.",'".utf8_decode($juez1)."','".utf8_decode($juez2)."',".($refcanchas == '' ? 'NULL' : $refcanchas).",'".($fecha)."','".$hora."',".$refestadospartidos.",".$calificacioncancha.",".$puntoslocal.",".$puntosvisita.",".$goleslocal.",".$golesvisitantes.",'".utf8_decode($observaciones)."',".$publicar.",".$refetapas.",".$posicion.")";
$res = $this->query($sql,1);
return $res;
}


function modificarFixture($id,$reftorneos,$reffechas,$refconectorlocal,$refconectorvisitante,$refarbitros,$juez1,$juez2,$refcanchas,$fecha,$hora,$refestadospartidos,$calificacioncancha,$puntoslocal,$puntosvisita,$goleslocal,$golesvisitantes,$observaciones,$publicar) {
$sql = "update dbfixture
set
reftorneos = ".$reftorneos.",reffechas = ".$reffechas.",refconectorlocal = ".$refconectorlocal.",refconectorvisitante = ".$refconectorvisitante.",refarbitros = ".$refarbitros.",juez1 = '".utf8_decode($juez1)."',juez2 = '".utf8_decode($juez2)."',refcanchas = ".($refcanchas == '' ? 'NULL' : $refcanchas).",fecha = '".utf8_decode($fecha)."',hora = '".$hora."',refestadospartidos = ".$refestadospartidos.",calificacioncancha = ".$calificacioncancha.",puntoslocal = ".$puntoslocal.",puntosvisita = ".$puntosvisita.",goleslocal = ".$goleslocal.",golesvisitantes = ".$golesvisitantes.",observaciones = '".utf8_decode($observaciones)."',publicar = ".$publicar."
where idfixture =".$id;
$res = $this->query($sql,0);
return $res;
}

function modificarFixturePorEstados($id,$refestadospartidos,$puntoslocal,$puntosvisita,$goleslocal,$golesvisitantes,$publicar) {
$sql = "update dbfixture
set
refestadospartidos = ".$refestadospartidos.",puntoslocal = ".$puntoslocal.",puntosvisita = ".$puntosvisita.",goleslocal = ".$goleslocal.",golesvisitantes = ".$golesvisitantes.",publicar = ".$publicar."
where idfixture =".$id;
$res = $this->query($sql,0);
return $res;
}


function modificarFixturePorCancha($id,$refCanchas, $refArbitros, $juez1, $juez2, $calificacioncancha) {
$sql = "update dbfixture
set
refcanchas = ".$refCanchas.",
refarbitros = ".$refArbitros.",
juez1 = '".$juez1."',
juez2 = '".$juez2."',
calificacioncancha = ".$calificacioncancha."
where idfixture =".$id;
$res = $this->query($sql,0);
return $res;
}


function modificarFixtureFechaPorRefFecha($reftorneos,$reffechas, $fecha) {
$sql = "update dbfixture
set
fecha = '".$fecha."'
where reffechas =".$reffechas." and reftorneos =".$reftorneos;
$res = $this->query($sql,0);
return $res;
}



function eliminarFixture($id) {
$sql = "delete from dbfixture where idfixture =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerFixture() {
$sql = "select
f.idfixture,
f.reftorneos,
f.reffechas,
f.refconectorlocal,
f.refconectorvisitante,
f.refarbitros,
f.juez1,
f.juez2,
f.refcanchas,
f.fecha,
f.hora,
f.refestadospartidos,
f.calificacioncancha,
f.puntoslocal,
f.puntosvisita,
f.goleslocal,
f.golesvisitantes,
f.observaciones,
f.publicar
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbconector conl ON conl.idconector = f.refconectorlocal
inner join dbconector conv ON conv.idconector = f.refconectorvisitante
inner join dbarbitros arb ON arb.idarbitro = f.refarbitros
inner join tbcanchas can ON can.idcancha = f.refcanchas
inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerFixtureTodo() {
	
$resTemporadas = $this->traerUltimaTemporada();	

if (mysql_num_rows($resTemporadas)>0) {
	$ultimaTemporada = mysql_result($resTemporadas,0,0);	
} else {
	$ultimaTemporada = 0;	
}

	
$sql = "select
f.idfixture,
el.nombre as equipolocal,
f.puntoslocal,
f.puntosvisita,
ev.nombre as equipovisitante,
ca.categoria,
arb.nombrecompleto as arbitro,
f.goleslocal,
f.golesvisitantes,

can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y'),
f.hora,
est.descripcion as estado,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
f.refcanchas,
f.reftorneos,
f.reffechas,
f.refconectorlocal,
f.refconectorvisitante,
f.refestadospartidos,
f.refarbitros
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where tor.reftemporadas = ".$ultimaTemporada."
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerFixtureTodoPorTorneo($idTorneo) {
$sql = "select
f.idfixture,
el.nombre as equipolocal,
f.puntoslocal,
f.puntosvisita,
ev.nombre as equipovisitante,
ca.categoria,
arb.nombrecompleto as arbitro,
f.goleslocal,
f.golesvisitantes,
can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y'),
f.hora,
est.descripcion as estado,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
arb.telefonoparticular as telefono,
f.refcanchas,
f.reftorneos,
f.reffechas,
f.refconectorlocal,
f.refconectorvisitante,
f.refestadospartidos,
f.refarbitros
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where tor.idtorneo = ".$idTorneo."
order by f.reffechas, f.idfixture";
$res = $this->query($sql,0);
return $res;
}



function traerFixtureTodoPorTorneoPlayOff() {
$sql = "select
f.idfixture,
el.nombre as equipolocal,
f.puntoslocal,
f.puntosvisita,
ev.nombre as equipovisitante,
ca.categoria,
arb.nombrecompleto as arbitro,
f.goleslocal,
f.golesvisitantes,
can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y'),
f.hora,
est.descripcion as estado,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
arb.telefonoparticular as telefono,
f.refcanchas,
f.reftorneos,
f.reffechas,
f.refconectorlocal,
f.refconectorvisitante,
f.refestadospartidos,
f.refarbitros,
f.refetapas,
ep.descripcion,
ep.valor,
f.posicion
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
inner join tbetapas ep on ep.idetapa = f.refetapas
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where ti.idtipotorneo = 3
order by f.refetapas, f.posicion";
$res = $this->query($sql,0);
return $res;
}


function traerFixtureTodoPorTorneoPlayOffPorEtapas($idEtapa) {
$sql = "select
f.idfixture,
el.nombre as equipolocal,
f.puntoslocal,
f.puntosvisita,
ev.nombre as equipovisitante,
ca.categoria,
arb.nombrecompleto as arbitro,
f.goleslocal,
f.golesvisitantes,
can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y'),
f.hora,
est.descripcion as estado,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
arb.telefonoparticular as telefono,
f.refcanchas,
f.reftorneos,
f.reffechas,
f.refconectorlocal,
f.refconectorvisitante,
f.refestadospartidos,
f.refarbitros,
f.refetapas,
ep.descripcion,
ep.valor,
f.posicion
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
inner join tbetapas ep on ep.idetapa = f.refetapas
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where ti.idtipotorneo = 3 and f.refetapas = ".$idEtapa."
order by f.refetapas, f.posicion";
$res = $this->query($sql,0);
return $res;
}



function traerFixtureTodoPorTorneoPlayOffPorEtapasPosicion($idEtapa, $posicion) {
$sql = "select
f.idfixture,
el.nombre as equipolocal,
f.puntoslocal,
f.puntosvisita,
ev.nombre as equipovisitante,
ca.categoria,
arb.nombrecompleto as arbitro,
f.goleslocal,
f.golesvisitantes,
can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y'),
f.hora,
est.descripcion as estado,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
arb.telefonoparticular as telefono,
f.refcanchas,
f.reftorneos,
f.reffechas,
f.refconectorlocal,
f.refconectorvisitante,
f.refestadospartidos,
f.refarbitros,
f.refetapas,
ep.descripcion,
ep.valor,
f.posicion
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
inner join tbetapas ep on ep.idetapa = f.refetapas
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where ti.idtipotorneo = 3 and f.refetapas = ".$idEtapa." and f.posicion = ".$posicion."
order by f.refetapas, f.posicion";
$res = $this->query($sql,0);
return $res;
}

function traerFixtureTodoPorTorneoFecha($idTorneo, $refFechas) {
$sql = "select
f.idfixture,
el.nombre as equipolocal,
f.puntoslocal,
f.puntosvisita,
ev.nombre as equipovisitante,
ca.categoria,
arb.nombrecompleto as arbitro,
f.goleslocal,
f.golesvisitantes,
can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y') as fechapartido,
f.hora,
est.descripcion as estado,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
arb.telefonoparticular as telefono,
f.refcanchas,
f.reftorneos,
f.reffechas,
f.refconectorlocal,
f.refconectorvisitante,
f.refestadospartidos,
f.refarbitros,
coalesce(cl.nombre,'') as contactoLocal,
coalesce(cv.nombre,'') as contactoVisitante
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbcontactos cl ON cl.idcontacto = el.refcontactos
left join dbcontactos cv ON cv.idcontacto = ev.refcontactos
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where tor.idtorneo = ".$idTorneo." and f.reffechas = ".$refFechas."
order by f.reffechas, f.idfixture";
$res = $this->query($sql,0);
return $res;
}



function traerFixtureTodoPorTemporadaFecha($idTemporada, $refFechas) {
$sql = "select
f.idfixture,
el.nombre as equipolocal,
f.puntoslocal,
f.puntosvisita,
ev.nombre as equipovisitante,
ca.categoria,
arb.nombrecompleto as arbitro,
f.goleslocal,
f.golesvisitantes,
can.nombre as canchas,
fec.fecha,
date_format(f.fecha,'%d/%m/%Y') as fechapartido,
f.hora,
est.descripcion as estado,
f.calificacioncancha,
f.juez1,
f.juez2,
f.observaciones,
f.publicar,
arb.telefonoparticular as telefono,
f.refcanchas,
f.reftorneos,
f.reffechas,
f.refconectorlocal,
f.refconectorvisitante,
f.refestadospartidos,
f.refarbitros
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where tor.reftemporada = ".$idTemporada." and f.reffechas = ".$refFechas."
order by f.reffechas, f.idfixture";
$res = $this->query($sql,0);
return $res;
}


function traerFechasFixturePorTorneo($idTorneo) {
$sql = "select
f.reffechas,
fec.fecha
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where tor.idtorneo = ".$idTorneo."
group by f.reffechas,fec.fecha
order by f.reffechas";
$res = $this->query($sql,0);
return $res;
}


function traerFechasFixturePorTorneoEquipo($idTorneo, $idEquipos) {
$sql = "select
f.idfixture,
fec.fecha,
f.reffechas
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where tor.idtorneo = ".$idTorneo." and (el.idequipo = ".$idEquipos." or ev.idequipo = ".$idEquipos.")
order by f.reffechas";
$res = $this->query($sql,0);
return $res;
}


function traerFechasFixturePorTorneoEquipoLocal($idTorneo, $idEquipos) {
$sql = "select
f.idfixture,
fec.fecha,
f.reffechas
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where tor.idtorneo = ".$idTorneo." and f.refconectorlocal = ".$idEquipos." and f.refconectorlocal > 0
order by f.reffechas";
$res = $this->query($sql,0);
return $res;
}



function traerFechasFixturePorTorneoEquipoVisitante($idTorneo, $idEquipos) {
$sql = "select
f.idfixture,
fec.fecha,
f.reffechas
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where tor.idtorneo = ".$idTorneo." and f.refconectorvisitante = ".$idEquipos." and f.refconectorvisitante > 0
order by f.reffechas";
$res = $this->query($sql,0);
return $res;
}


function traerFechasFixturePorTorneoDesdeFecha($idTorneo, $refFechas, $idEquipos) {
$sql = "select
f.idfixture,
fec.fecha,
f.reffechas
from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where tor.idtorneo = ".$idTorneo." and f.reffechas >= ".$refFechas." and (el.idequipo = ".$idEquipos." or ev.idequipo = ".$idEquipos.")
order by f.reffechas";
$res = $this->query($sql,0);
return $res;
}

function traerUltimaFechaFixturePorTorneo($idTorneo) {
	$sql = "select
			distinct max(f.reffechas)
			from dbfixture f
			inner join dbtorneos tor ON tor.idtorneo = f.reftorneos 
			inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
			where tor.idtorneo = ".$idTorneo;
			
	$res = $this->existeDevuelveId($sql);
	return $res;
}

function traerUltimaFechaFixtureSinEstadoPorTorneo($idTorneo) {
	$sql = "select
			distinct max(f.reffechas)
			from dbfixture f
			inner join dbtorneos tor ON tor.idtorneo = f.reftorneos 
			where tor.idtorneo = ".$idTorneo;
			
	$res = $this->existeDevuelveId($sql);
	return $res;
}

function traerUltimaFechaCalendarioFixturePorTorneo($idTorneo) {
	$sql = "select
			distinct max(f.fecha)
			from dbfixture f
			inner join dbtorneos tor ON tor.idtorneo = f.reftorneos 
			where tor.idtorneo = ".$idTorneo;
			
	$res = $this->existeDevuelveId($sql);
	return $res;
}

function traerUltimaFechaFixturePorTorneoEquipo($idTorneo, $idEquipo) {
	$sql = "select
			distinct count(f.reffechas)
			from dbfixture f
			inner join dbtorneos tor ON tor.idtorneo = f.reftorneos 
			inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
			where tor.idtorneo = ".$idTorneo." and (f.refconectorlocal = ".$idEquipo." or f.refconectorvisitante = ".$idEquipo.")";
			
	$res = $this->existeDevuelveId($sql);
	return $res;
}

function traerFixturePorId($id) {
$sql = "select idfixture,reftorneos,reffechas,refconectorlocal,refconectorvisitante,refarbitros,juez1,juez2,refcanchas,fecha,hora,refestadospartidos,calificacioncancha,puntoslocal,puntosvisita,goleslocal,golesvisitantes,observaciones,publicar from dbfixture where idfixture =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerFixtureDetallePorId($idFixture) {
$sql = "select
f.idfixture,
el.nombre as equipolocal,
f.puntoslocal,
f.puntosvisita,
ev.nombre as equipovisitante,
ca.categoria,
arb.nombrecompleto as arbitro,
f.juez1,
f.juez2,
can.nombre as canchas,
fec.fecha,
f.fecha,
f.hora,
est.descripcion as estado,
f.calificacioncancha,
f.goleslocal,
f.golesvisitantes,
f.observaciones,
f.publicar,
ti.tipotorneo,
te.temporada,
di.division,
f.refcanchas,
f.reftorneos,
f.reffechas,
f.refconectorlocal,
f.refconectorvisitante,
f.refestadospartidos,
f.refarbitros,
(case when tor.respetadefiniciontipojugadores = 1 then 'Si' else 'No' end) as respetadefiniciontipojugadores,
(case when tor.respetadefinicionhabilitacionestransitorias = 1 then 'Si' else 'No' end) as respetadefinicionhabilitacionestransitorias,
(case when tor.respetadefinicionsancionesacumuladas = 1 then 'Si' else 'No' end) as respetadefinicionsancionesacumuladas,
(case when tor.acumulagoleadores = 1 then 'Si' else 'No' end) as acumulagoleadores,
(case when tor.acumulatablaconformada = 1 then 'Si' else 'No' end) as acumulatablaconformada,
tor.descripcion

from dbfixture f
inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
inner join tbfechas fec ON fec.idfecha = f.reffechas
inner join dbequipos el ON el.idequipo = f.refconectorlocal
inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
left join dbarbitros arb ON arb.idarbitro = f.refarbitros
left join tbcanchas can ON can.idcancha = f.refcanchas
left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
where f.idfixture = ".$idFixture;
$res = $this->query($sql,0);
return $res;
}



/* Fin */
/* /* Fin de la Tabla: dbfixture*/


/********************  nuevos tablas 20/02/2017 para las ESTADISTICAS ************//////

/* PARA Mejorjugador */

function existeFixturePorMejorJugador($idJugador, $idFixture) {
	$sql = "select * from dbmejorjugador where refjugadores =".$idJugador." and reffixture =".$idFixture;
	
	return $this->existeDevuelveId($sql);	
}


function insertarMejorjugador($refjugadores,$reffixture,$refequipos,$refcategorias,$refdivisiones) { 
$sql = "insert into dbmejorjugador(idmejorjugador,refjugadores,reffixture,refequipos,refcategorias,refdivisiones) 
values ('',".$refjugadores.",".$reffixture.",".$refequipos.",".$refcategorias.",".$refdivisiones.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarMejorjugador($id,$refjugadores,$reffixture,$refequipos,$refcategorias,$refdivisiones) { 
$sql = "update dbmejorjugador 
set 
refjugadores = ".$refjugadores.",reffixture = ".$reffixture.",refequipos = ".$refequipos.",refcategorias = ".$refcategorias.",refdivisiones = ".$refdivisiones." 
where idmejorjugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 



function eliminarMejorjugador($id) { 
$sql = "delete from dbmejorjugador where idmejorjugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
}


function eliminarMejorjugadorPorJugadorFixture($idJugador, $idFixture) { 
$sql = "delete from dbmejorjugador where refjugadores = ".$idJugador." and reffixture = ".$idFixture; 
$res = $this->query($sql,0); 
return $res; 
} 

function eliminarMejorjugadorMasivo($reffixture) { 
$sql = "delete from dbmejorjugador where reffixture = ".$reffixture; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMejorjugador() { 
$sql = "select 
p.idmejorjugador,
p.refjugadores,
p.reffixture,
p.refequipos,
p.refcategorias,
p.refdivisiones
from dbmejorjugador p 
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMejorjugadorPorJugadorFixture($idJugador, $idFixture) { 
$sql = "select 
p.idmejorjugador,
p.refjugadores,
p.reffixture,
p.refequipos,
p.refcategorias,
p.refdivisiones
from dbmejorjugador p 
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
where p.refjugadores = ".$idJugador." and p.reffixture =".$idFixture; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMejorjugadorPorId($id) { 
$sql = "select idmejorjugador,refjugadores,reffixture,refequipos,refcategorias,refdivisiones from dbmejorjugador where idmejorjugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbmejorjugador*/


/* PARA Minutosjugados */

function existeFixturePorMinutosJugados($idJugador, $idFixture) {
	$sql = "select * from dbminutosjugados where refjugadores =".$idJugador." and reffixture =".$idFixture;
	
	return $this->existeDevuelveId($sql);	
}

function insertarMinutosjugados($refjugadores,$reffixture,$refequipos,$refcategorias,$refdivisiones,$minutos) { 
$sql = "insert into dbminutosjugados(idminutojugado,refjugadores,reffixture,refequipos,refcategorias,refdivisiones,minutos) 
values ('',".$refjugadores.",".$reffixture.",".$refequipos.",".$refcategorias.",".$refdivisiones.",".$minutos.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarMinutosjugados($id,$refjugadores,$reffixture,$refequipos,$refcategorias,$refdivisiones,$minutos) { 
$sql = "update dbminutosjugados 
set 
refjugadores = ".$refjugadores.",reffixture = ".$reffixture.",refequipos = ".$refequipos.",refcategorias = ".$refcategorias.",refdivisiones = ".$refdivisiones.",minutos = ".$minutos." 
where idminutojugado =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarMinutosjugados($id) { 
$sql = "delete from dbminutosjugados where idminutojugado =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMinutosjugados() { 
$sql = "select 
p.idminutojugado,
p.refjugadores,
p.reffixture,
p.refequipos,
p.refcategorias,
p.refdivisiones,
p.minutos
from dbminutosjugados p 
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 

function traerMinutosjugadosPorJugadorFixture($idJugador, $idFixture) { 
$sql = "select 
p.idminutojugado,
p.refjugadores,
p.reffixture,
p.refequipos,
p.refcategorias,
p.refdivisiones,
p.minutos
from dbminutosjugados p 
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
where p.refjugadores = ".$idJugador." and p.reffixture =".$idFixture; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMinutosjugadosPorId($id) { 
$sql = "select idminutojugado,refjugadores,reffixture,refequipos,refcategorias,refdivisiones,minutos from dbminutosjugados where idminutojugado =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbminutosjugados*/


/* PARA Penalesjugadores */

function existeFixturePorPenalesJugador($idJugador, $idFixture) {
	$sql = "select * from dbpenalesjugadores where refjugadores =".$idJugador." and reffixture =".$idFixture;
	
	return $this->existeDevuelveId($sql);	
}

function insertarPenalesjugadores($refjugadores,$reffixture,$refequipos,$refcategorias,$refdivisiones,$penalconvertido,$penalerrado,$penalatajado) { 
$sql = "insert into dbpenalesjugadores(idpenaljugador,refjugadores,reffixture,refequipos,refcategorias,refdivisiones,penalconvertido,penalerrado,penalatajado) 
values ('',".$refjugadores.",".$reffixture.",".$refequipos.",".$refcategorias.",".$refdivisiones.",".$penalconvertido.",".$penalerrado.",".$penalatajado.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarPenalesjugadores($id,$refjugadores,$reffixture,$refequipos,$refcategorias,$refdivisiones,$penalconvertido,$penalerrado,$penalatajado) { 
$sql = "update dbpenalesjugadores 
set 
refjugadores = ".$refjugadores.",reffixture = ".$reffixture.",refequipos = ".$refequipos.",refcategorias = ".$refcategorias.",refdivisiones = ".$refdivisiones.",penalconvertido = ".$penalconvertido.",penalerrado = ".$penalerrado.",penalatajado = ".$penalatajado." 
where idpenaljugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarPenalesjugadores($id) { 
$sql = "delete from dbpenalesjugadores where idpenaljugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerPenalesjugadores() { 
$sql = "select 
p.idpenaljugador,
p.refjugadores,
p.reffixture,
p.refequipos,
p.refcategorias,
p.refdivisiones,
p.penalconvertido,
p.penalerrado,
p.penalatajado
from dbpenalesjugadores p 
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerPenalesjugadoresPorJugadorFixture($idJugador, $idFixture) { 
$sql = "select 
p.idpenaljugador,
p.refjugadores,
p.reffixture,
p.refequipos,
p.refcategorias,
p.refdivisiones,
p.penalconvertido,
p.penalerrado,
p.penalatajado
from dbpenalesjugadores p 
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
where p.refjugadores = ".$idJugador." and p.reffixture =".$idFixture;
$res = $this->query($sql,0); 
return $res; 
} 
 

function traerPenalesjugadoresPorId($id) { 
$sql = "select idpenaljugador,refjugadores,reffixture,refequipos,refcategorias,refdivisiones,penalconvertido,penalerrado,penalatajado from dbpenalesjugadores where idpenaljugador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbpenalesjugadores*/


/* PARA Sancionesfallosacumuladas */

function insertarSancionesfallosacumuladas($refsancionesjugadores,$cantidadfechas,$fechadesde,$fechahasta,$amarillas,$fechascumplidas,$pendientescumplimientos,$pendientesfallo,$generadaporacumulacion,$observaciones) { 
$sql = "insert into dbsancionesfallosacumuladas(idsancionfalloacumuladas,refsancionesjugadores,cantidadfechas,fechadesde,fechahasta,amarillas,fechascumplidas,pendientescumplimientos,pendientesfallo,generadaporacumulacion,observaciones) 
values ('',".$refsancionesjugadores.",".$cantidadfechas.",'".utf8_decode($fechadesde)."','".utf8_decode($fechahasta)."',".$amarillas.",".$fechascumplidas.",".$pendientescumplimientos.",".$pendientesfallo.",".$generadaporacumulacion.",'".utf8_decode($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarSancionesfallosacumuladas($id,$refsancionesjugadores,$cantidadfechas,$fechadesde,$fechahasta,$amarillas,$fechascumplidas,$pendientescumplimientos,$pendientesfallo,$generadaporacumulacion,$observaciones) { 
$sql = "update dbsancionesfallosacumuladas 
set 
refsancionesjugadores = ".$refsancionesjugadores.",cantidadfechas = ".$cantidadfechas.",fechadesde = '".utf8_decode($fechadesde)."',fechahasta = '".utf8_decode($fechahasta)."',amarillas = ".$amarillas.",fechascumplidas = ".$fechascumplidas.",pendientescumplimientos = ".$pendientescumplimientos.",pendientesfallo = ".$pendientesfallo.",generadaporacumulacion = ".$generadaporacumulacion.",observaciones = '".utf8_decode($observaciones)."' 
where idsancionfalloacumuladas =".$id; 
$res = $this->query($sql,0); 
return $res; 
}


function modificarSancionesfallosacumuladasPorSancionJugador($refsancionesjugadores) { 
$sql = "update dbsancionesfallosacumuladas 
set 
fechascumplidas = 1 
where refsancionesjugadores =".$refsancionesjugadores; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarSancionesfallosacumuladas($id) { 
$sql = "delete from dbsancionesfallosacumuladas where idsancionfalloacumuladas =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarSancionesfallosacumuladasPorIdSancionJugador($id) { 
$sql = "delete from dbsancionesfallosacumuladas where refsancionesjugadores =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerSancionesfallosacumuladas() { 
$sql = "select 
s.idsancionfalloacumuladas,
s.refsancionesjugadores,
s.cantidadfechas,
s.fechadesde,
s.fechahasta,
s.amarillas,
s.fechascumplidas,
s.pendientescumplimientos,
s.pendientesfallo,
s.generadaporacumulacion,
s.observaciones
from dbsancionesfallosacumuladas s 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerSancionesfallosacumuladasPorId($id) { 
$sql = "select idsancionfalloacumuladas,refsancionesjugadores,cantidadfechas,fechadesde,fechahasta,amarillas,fechascumplidas,pendientescumplimientos,pendientesfallo,generadaporacumulacion,observaciones from dbsancionesfallosacumuladas where idsancionfalloacumuladas =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerSancionesfallosacumuladasPorIdSancionJugador($idSancionJugador) { 
$sql = "select idsancionfalloacumuladas,refsancionesjugadores,cantidadfechas,fechadesde,fechahasta,amarillas,fechascumplidas,pendientescumplimientos,pendientesfallo,generadaporacumulacion,observaciones from dbsancionesfallosacumuladas where refsancionesjugadores =".$idSancionJugador; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbsancionesfallosacumuladas*/

/* PARA Sancionesfallos */

/* para buscar sanciones entre fechas */

function existeYaLaSancion($reffixture, $refjugadores, $refsancionesfallos) {
	$sql = "select idsancionfechacumplida from dbsancionesfechascumplidas 
			where reffixture =".$reffixture." and refjugadores = ".$refjugadores." and refsancionesfallos=".$refsancionesfallos;
			
	return $this->existe($sql);	
}


function traerSancionesfallosacumuladasCambioPorEquipoFechaDesdeHasta($idEquipo,$fechaDesde, $fechaHasta, $idCategoria) { 
$sql = "SELECT 
    ff.fecha, fix.fecha as fechajuego, e.descripcion
FROM
    dbfixture fix
		inner join
	dbtorneos tor ON tor.idtorneo = fix.reftorneos and tor.reftemporadas = 6 and tor.refcategorias = ".$idCategoria."
		inner join
	tbestadospartidos e ON e.idestadopartido = fix.refestadospartidos
        INNER JOIN
    tbfechas ff ON ff.idfecha = fix.reffechas
WHERE		(fix.refconectorlocal = ".$idEquipo." or fix.refconectorvisitante = ".$idEquipo." )
and fix.fecha between '".$fechaDesde."' and '".$fechaHasta."' order by ff.idfecha"; 
$res = $this->query($sql,0); 
return $res; 
} 

/* fin */


function insertarSancionesfallos($refsancionesjugadores,$cantidadfechas,$fechadesde,$fechahasta,$amarillas,$fechascumplidas,$pendientescumplimientos,$pendientesfallo,$generadaporacumulacion,$observaciones) { 
$sql = "insert into dbsancionesfallos(idsancionfallo,refsancionesjugadores,cantidadfechas,fechadesde,fechahasta,amarillas,fechascumplidas,pendientescumplimientos,pendientesfallo,generadaporacumulacion,observaciones) 
values ('',".$refsancionesjugadores.",".$cantidadfechas.",'".utf8_decode($fechadesde)."','".utf8_decode($fechahasta)."',".$amarillas.",".$fechascumplidas.",".$pendientescumplimientos.",".$pendientesfallo.",".$generadaporacumulacion.",'".utf8_decode($observaciones)."')"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarSancionesfallos($id,$refsancionesjugadores,$cantidadfechas,$fechadesde,$fechahasta,$amarillas,$fechascumplidas,$pendientescumplimientos,$pendientesfallo,$generadaporacumulacion,$observaciones) { 
$sql = "update dbsancionesfallos 
set 
refsancionesjugadores = ".$refsancionesjugadores.",cantidadfechas = ".$cantidadfechas.",fechadesde = '".utf8_decode($fechadesde)."',fechahasta = '".utf8_decode($fechahasta)."',amarillas = ".$amarillas.",fechascumplidas = ".$fechascumplidas.",pendientescumplimientos = ".$pendientescumplimientos.",pendientesfallo = ".$pendientesfallo.",generadaporacumulacion = ".$generadaporacumulacion.",observaciones = '".utf8_decode($observaciones)."' 
where idsancionfallo =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarSancionesfallos($id) {
	
	$idSancionFallo = mysql_result($this->traerSancionesjugadoresPorId($id),0,'refsancionesfallos');
	
	$sqlMovimientos = "delete from dbsancionesfechascumplidas where refsancionesfallos =".$idSancionFallo;
	$res = $this->query($sqlMovimientos,0);
	
	$this->modificarSancionesjugadoresFalladas($id, 'NULL');
		
	$sql = "delete from dbsancionesfallos where idsancionfallo =".$idSancionFallo;
	$res = $this->query($sql,0);
	
	$this->eliminarSancionesjugadores($id);
	
	return $res;
}

function eliminarSancionesfallosPorSacionJugador($idSancionJugador) {
$sql = "delete from dbsancionesfallos where refsancionesjugadores =".$idSancionJugador;
$res = $this->query($sql,0);
return $res;
}


function traerSancionesfallos() {
$sql = "select
s.idsancionfallo,
s.refsancionesjugadores,
s.cantidadfechas,
s.fechadesde,
s.fechahasta,
s.amarillas,
s.fechascumplidas,
s.pendientescumplimientos,
s.pendientesfallo,
s.generadaporacumulacion,
s.observaciones
from dbsancionesfallos s
inner join dbsancionesjugadores san ON san.idsancionjugador = s.refsancionesjugadores
inner join tbtiposanciones ti ON ti.idtiposancion = san.reftiposanciones
inner join dbjugadores ju ON ju.idjugador = san.refjugadores
inner join dbequipos eq ON eq.idequipo = san.refequipos
inner join dbfixture fi ON fi.idfixture = san.reffixture
inner join tbcategorias ca ON ca.idtcategoria = san.refcategorias
inner join tbdivisiones di ON di.iddivision = san.refdivisiones
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerSancionesfallosPorId($id) {
$sql = "select idsancionfallo,refsancionesjugadores,cantidadfechas,fechadesde,fechahasta,amarillas,fechascumplidas,
(case when pendientescumplimientos=1 then 'Si' else 'No' end) as pendientescumplimientos,
(case when pendientesfallo=1 then 'Si' else 'No' end) as pendientesfallo,
(case when generadaporacumulacion=1 then 'Si' else 'No' end) as generadaporacumulacion,
observaciones from dbsancionesfallos where idsancionfallo =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbsancionesfallos*/




/* PARA Sancionesjugadores */

function existeFixturePorSanciones($idJugador, $idTipoSancion, $idFixture) {
	$sql = "select * from dbsancionesjugadores where refjugadores =".$idJugador." and reffixture =".$idFixture." and reftiposanciones =".$idTipoSancion;
	
	return $this->existeDevuelveId($sql);	
}


function insertarSancionesjugadores($reftiposanciones,$refjugadores,$refequipos,$reffixture,$fecha,$cantidad,$refcategorias,$refdivisiones,$refsancionesfallos) {
$sql = "insert into dbsancionesjugadores(idsancionjugador,reftiposanciones,refjugadores,refequipos,reffixture,fecha,cantidad,refcategorias,refdivisiones,refsancionesfallos)
values ('',".$reftiposanciones.",".$refjugadores.",".$refequipos.",".$reffixture.",'".utf8_decode($fecha)."',".$cantidad.",".$refcategorias.",".$refdivisiones.",".$refsancionesfallos.")";
$res = $this->query($sql,1);
return $res;
}


function modificarSancionesjugadores($id,$reftiposanciones,$refjugadores,$refequipos,$reffixture,$fecha,$cantidad,$refcategorias,$refdivisiones,$refsancionesfallos) {
$sql = "update dbsancionesjugadores
set
reftiposanciones = ".$reftiposanciones.",refjugadores = ".$refjugadores.",refequipos = ".$refequipos.",reffixture = ".$reffixture.",fecha = '".utf8_decode($fecha)."',cantidad = ".$cantidad.",refcategorias = ".$refcategorias.",refdivisiones = ".$refdivisiones.",refsancionesfallos = ".$refsancionesfallos."
where idsancionjugador =".$id;
$res = $this->query($sql,0);
return $res;
}

function modificarSancionesjugadoresSinAlterarFallo($id,$reftiposanciones,$refjugadores,$refequipos,$reffixture,$fecha,$cantidad,$refcategorias,$refdivisiones) {
$sql = "update dbsancionesjugadores
set
reftiposanciones = ".$reftiposanciones.",refjugadores = ".$refjugadores.",refequipos = ".$refequipos.",reffixture = ".$reffixture.",fecha = '".utf8_decode($fecha)."',cantidad = ".$cantidad.",refcategorias = ".$refcategorias.",refdivisiones = ".$refdivisiones."
where idsancionjugador =".$id;
$res = $this->query($sql,0);
return $res;
}

function modificarSancionesjugadoresFalladas($id,$refsancionesfallos) {
	
	
	$sql = "update dbsancionesjugadores
	set
	refsancionesfallos = ".$refsancionesfallos."
	where idsancionjugador =".$id;
	
	$res = $this->query($sql,0);
	return $res;
}


function eliminarSancionesjugadores($id) {

$sql = "delete from dbsancionesjugadores where idsancionjugador =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerSancionesjugadores() {
$sql = "select
p.idsancionjugador,
p.reftiposanciones,
p.refjugadores,
p.refequipos,
p.reffixture,
p.fecha,
p.cantidad,
p.refcategorias,
p.refdivisiones,
p.refsancionesfallos
from dbsancionesjugadores p
inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerSancionesjugadoresPorId($id) {
$sql = "select idsancionjugador,reftiposanciones,refjugadores,refequipos,reffixture,fecha,cantidad,refcategorias,refdivisiones,refsancionesfallos from dbsancionesjugadores where idsancionjugador =".$id;
$res = $this->query($sql,0);
return $res;
}

function traerSancionesjugadoresPorIdSancionFallo($idSancionesFallos) {
$sql = "select idsancionjugador,reftiposanciones,refjugadores,refequipos,reffixture,fecha,cantidad,refcategorias,refdivisiones,refsancionesfallos from dbsancionesjugadores where refsancionesfallos =".$idSancionesFallos;
$res = $this->query($sql,0);
return $res;
}

function traerSancionesjugadoresPorIdDetalles($id) {
$sql = "select
p.idsancionjugador,
concat(jug.apellido, ', ', jug.nombres) as jugador,
jug.nrodocumento,
equ.nombre as equipo,
p.fecha,
tip.descripcion as tiposancion,
p.cantidad,
cat.categoria,
divi.division,
sf.cantidadfechas as cantidadfechas,
sf.observaciones,
p.reftiposanciones,
p.refjugadores,
p.refequipos,
p.reffixture,
p.refcategorias,
p.refdivisiones,
p.refsancionesfallos
from dbsancionesjugadores p
inner join dbsancionesfallos sf ON sf.idsancionfallo = p.refsancionesfallos
inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones  
where idsancionjugador =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerSancionesjugadoresPorFixtureEquipoTotales($idFixture, $idEquipo) {
$sql = "select

equ.nombre as equipo,
coalesce((case when p.reftiposanciones = 1 then sum(p.cantidad) end),0) as amarillas,
coalesce((case when p.reftiposanciones = 2 then sum(p.cantidad) end),0) as rojas,
coalesce((case when p.reftiposanciones = 3 then sum(p.cantidad) end),0) as informados,
coalesce((case when p.reftiposanciones = 4 then sum(p.cantidad) end),0) as dobleamarilla,
coalesce((case when p.reftiposanciones = 5 then sum(p.cantidad) end),0) as cdtd
from dbsancionesjugadores p
inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones  
where fix.idfixture =".$idFixture." and equ.idequipo = ".$idEquipo;
$res = $this->query($sql,0);
return $res;
}



function traerSancionesjugadoresPorIdDetallesSinFallo($id) {
$sql = "select
p.idsancionjugador,
concat(jug.apellido, ', ', jug.nombres) as jugador,
jug.nrodocumento,
equ.nombre as equipo,
p.fecha,
tip.descripcion as tiposancion,
p.cantidad,
cat.categoria,
divi.division,
sf.cantidadfechas as cantidadfechas,
sf.observaciones,
p.reftiposanciones,
p.refjugadores,
p.refequipos,
p.reffixture,
p.refcategorias,
p.refdivisiones,
p.refsancionesfallos
from dbsancionesjugadores p
left join dbsancionesfallos sf ON sf.idsancionfallo = p.refsancionesfallos
inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones  
where idsancionjugador =".$id;
$res = $this->query($sql,0);
return $res;
}

function traerSancionesjugadoresPorJugadorConValor($idJugador, $idFixture, $idCategorias, $idDivision, $idTipoSancion) {
	$sql = "select idsancionjugador,reftiposanciones,refjugadores,refequipos,reffixture,fecha,cantidad,refcategorias,refdivisiones,refsancionesfallos from dbsancionesjugadores where refjugadores =".$idJugador." and reffixture =".$idFixture." and refcategorias = ".$idCategorias." and refdivisiones =".$idDivision." and reftiposanciones =".$idTipoSancion;
	
	$res = $this->query($sql,0);
	if (mysql_num_rows($res)>0) {
		return mysql_result($res,0,'cantidad');
	}

	return 0;
}

function traerSancionesjugadoresPorJugadorFixtureConValor($idJugador, $idFixture) {
	$sql = "select idsancionjugador,reftiposanciones,refjugadores,refequipos,reffixture,fecha,cantidad,refcategorias,refdivisiones,refsancionesfallos from dbsancionesjugadores where refjugadores =".$idJugador." and refsancionesfallos is not null and reffixture =".$idFixture;
	
	$res = $this->query($sql,0);
	if (mysql_num_rows($res)>0) {
		return mysql_result($res,0,'idsancionjugador');
	}

	return 0;
}

function traerSancionesjugadoresPorJugador($idJugador, $idFixture, $idCategorias, $idDivision, $idTipoSancion) {
	$sql = "select idsancionjugador,reftiposanciones,refjugadores,refequipos,reffixture,fecha,cantidad,refcategorias,refdivisiones,refsancionesfallos from dbsancionesjugadores where refjugadores =".$idJugador." and reffixture =".$idFixture." and refcategorias = ".$idCategorias." and refdivisiones =".$idDivision." and reftiposanciones =".$idTipoSancion;
	
	$res = $this->query($sql,0);
	if (mysql_num_rows($res)>0) {
		return mysql_result($res,0,'cantidad');
	}

	return 0;
}


function traerSancionesjugadoresSinFallos() {
$sql = "select
p.idsancionjugador,
concat(jug.apellido, ', ', jug.nombres) as jugador,
jug.nrodocumento,
equ.nombre as equipo,
p.fecha,
tip.descripcion as tiposancion,
p.cantidad,
p.reftiposanciones,
p.refjugadores,
p.refequipos,
p.reffixture,
p.refcategorias,
p.refdivisiones,
p.refsancionesfallos
from dbsancionesjugadores p
inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
where p.cantidad >0 and p.refsancionesfallos is null and tip.idtiposancion <> 1
union all
select
p.idsancionjugador,
concat(jug.apellido, ', ', jug.nombres) as jugador,
jug.nrodocumento,
equ.nombre as equipo,
p.fecha,
tip.descripcion as tiposancion,
p.cantidad,
p.reftiposanciones,
p.refjugadores,
p.refequipos,
p.reffixture,
p.refcategorias,
p.refdivisiones,
p.refsancionesfallos
from dbsancionesjugadores p
inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
where p.cantidad >2 and p.refsancionesfallos is null and tip.idtiposancion = 1
";
$res = $this->query($sql,0);
return $res;
}


/* recordar poner buscar por temporada activa */
function traerSancionesJugadoresConFallos() {
	
$resTemporadas = $this->traerUltimaTemporada();	

if (mysql_num_rows($resTemporadas)>0) {
	$ultimaTemporada = mysql_result($resTemporadas,0,0);	
} else {
	$ultimaTemporada = 0;	
}	
	
	
	$sql = "select
			p.idsancionjugador,
			concat(jug.apellido, ', ', jug.nombres) as jugador,
			jug.nrodocumento,
			equ.nombre as equipo,
			p.fecha,
			tip.descripcion as tiposancion,
			p.cantidad,
			sf.cantidadfechas,
			sf.fechadesde,
			sf.fechahasta,
			sf.amarillas,
			coalesce( sfc.cumplidas,0) as fechascumplidas,
			(case when sf.pendientescumplimientos = 1 then 'Si' else 'No' end) as pendientescumplimientos,
			(case when sf.pendientesfallo = 1 then 'Si' else 'No' end) as pendientesfallo,
			(case when sf.generadaporacumulacion = 1 then 'Si' else 'No' end) as generadaporacumulacion,
			sf.observaciones,
			p.reftiposanciones,
			p.refjugadores,
			p.refequipos,
			p.reffixture,
			p.refcategorias,
			p.refdivisiones,
			p.refsancionesfallos
		from dbsancionesjugadores p
		inner join dbsancionesfallos sf ON sf.idsancionfallo = p.refsancionesfallos
		inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
		inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
		inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
		inner join dbcountries co ON co.idcountrie = jug.refcountries 
		inner join dbfixture fix ON fix.idfixture = p.reffixture 
		inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
		inner join tbfechas fe ON fe.idfecha = fix.reffechas 
		inner join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
		inner join dbequipos equ ON equ.idequipo = p.refequipos 
		inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
		inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
		inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
		left join
				(select fc.refsancionesfallos,torc.refcategorias, count(*) as cumplidas 
					from dbsancionesfechascumplidas fc
					inner join dbfixture fixf on fixf.idfixture = fc.reffixture
					inner join dbtorneos torc on torc.idtorneo = fixf.reftorneos 
					group by fc.refsancionesfallos,torc.refcategorias) sfc
				ON  sfc.refsancionesfallos = sf.idsancionfallo and sfc.refcategorias = p.refcategorias
		where tor.reftemporadas = ".$ultimaTemporada."		
		";	
		
		$res = $this->query($sql,0);
		return $res;
}


/* recordar poner buscar por temporada activa */
function traerSancionesJugadoresConFallosAcumulados() {
	$sql = "select
			p.idsancionjugador,
			concat(jug.apellido, ', ', jug.nombres) as jugador,
			jug.nrodocumento,
			equ.nombre as equipo,
			p.fecha,
			tip.descripcion as tiposancion,
			p.cantidad,
			sf.cantidadfechas,
			sf.fechadesde,
			sf.fechahasta,
			sf.amarillas,
			coalesce( sf.fechascumplidas,0) as fechascumplidas,
			(case when sf.pendientescumplimientos = 1 then 'Si' else 'No' end) as pendientescumplimientos,
			(case when sf.pendientesfallo = 1 then 'Si' else 'No' end) as pendientesfallo,
			(case when sf.generadaporacumulacion = 1 then 'Si' else 'No' end) as generadaporacumulacion,
			sf.observaciones,
			p.reftiposanciones,
			p.refjugadores,
			p.refequipos,
			p.reffixture,
			p.refcategorias,
			p.refdivisiones,
			p.refsancionesfallos
		from dbsancionesjugadores p
		inner join dbsancionesfallosacumuladas sf ON sf.refsancionesjugadores = p.idsancionjugador
		inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
		inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
		inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
		inner join dbcountries co ON co.idcountrie = jug.refcountries 
		inner join dbfixture fix ON fix.idfixture = p.reffixture 
		inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
		inner join tbfechas fe ON fe.idfecha = fix.reffechas 
		inner join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
		inner join dbequipos equ ON equ.idequipo = p.refequipos 
		inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
		inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
		inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones ";	
		
		$res = $this->query($sql,0);
		return $res;
}



/* recordar poner buscar por temporada activa */
function traerSancionesJugadoresPendientesConFallos() {
	$sql = "select
			p.idsancionjugador,
			concat(jug.apellido, ', ', jug.nombres) as jugador,
			jug.nrodocumento,
			equ.nombre as equipo,
			p.fecha,
			tip.descripcion as tiposancion,
			p.cantidad,
			sf.cantidadfechas,
			sf.fechadesde,
			sf.fechahasta,
			sf.amarillas,
			sf.fechascumplidas,
			(case when sf.pendientescumplimientos = 1 then 'Si' else 'No' end) as pendientescumplimientos,
			(case when sf.pendientesfallo = 1 then 'Si' else 'No' end) as pendientesfallo,
			(case when sf.generadaporacumulacion = 1 then 'Si' else 'No' end) as generadaporacumulacion,
			sf.observaciones,
			p.reftiposanciones,
			p.refjugadores,
			p.refequipos,
			p.reffixture,
			p.refcategorias,
			p.refdivisiones,
			p.refsancionesfallos
		from dbsancionesjugadores p
		inner join dbsancionesfallos sf ON sf.idsancionfallo = p.refsancionesfallos
		inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
		inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
		inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
		inner join dbcountries co ON co.idcountrie = jug.refcountries 
		inner join dbfixture fix ON fix.idfixture = p.reffixture 
		inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
		inner join tbfechas fe ON fe.idfecha = fix.reffechas 
		inner join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
		inner join dbequipos equ ON equ.idequipo = p.refequipos 
		inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
		inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
		inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
		where sf.pendientesfallo = 1";	
		
		$res = $this->query($sql,0);
		return $res;
}


/* recordar poner buscar por temporada activa */
function traerSancionesJugadoresConFallosPorJugador($idJugador, $reffecha) {
	$sql = "select
			p.idsancionjugador
		from dbsancionesjugadores p
		inner join dbsancionesfallos sf ON sf.idsancionfallo = p.refsancionesfallos
		inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
		inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
		inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
		inner join dbcountries co ON co.idcountrie = jug.refcountries 
		inner join dbfixture fix ON fix.idfixture = p.reffixture 
		inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
		inner join tbfechas fe ON fe.idfecha = fix.reffechas 
		inner join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
		inner join dbequipos equ ON equ.idequipo = p.refequipos 
		inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
		inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
		inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
		inner join dbmovimientosanciones ms ON ms.refsancionesjugadores = p.idsancionjugador
		where jug.idjugador =".$idJugador." and ms.reffechas = ".$reffecha;	
		
		$res = $this->query($sql,0);
		
		if (mysql_num_rows($res)>0) {
			return 1;	
		}
		return 0;
		

}


/* recordar poner buscar por temporada activa */
function suspendidoPorDias($idJugador, $idTipoTorneo) {
	$sql = "select
			p.idsancionjugador
		from dbsancionesjugadores p
		inner join dbsancionesfallos sf ON sf.idsancionfallo = p.refsancionesfallos
		inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
		inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
		inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
		inner join dbcountries co ON co.idcountrie = jug.refcountries 
		inner join dbfixture fix ON fix.idfixture = p.reffixture 
		inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos and tor.reftipotorneo = ".$idTipoTorneo."
		inner join tbfechas fe ON fe.idfecha = fix.reffechas 
		inner join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
		inner join dbequipos equ ON equ.idequipo = p.refequipos 
		inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
		inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
		inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
		where jug.idjugador =".$idJugador." and sf.fechadesde >= '".date('Y-m-d')."' and sf.fechahasta <= '".date('Y-m-d')."'";	
		
		$res = $this->query($sql,0);
		
		if (mysql_num_rows($res)>0) {
			return 1;	
		}
		return 0;
}


/* recordar poner buscar por temporada activa */
function traerSancionesJugadoresConFallosPorSancion($idFallo, $idTipoTorneo) {
	$sql = "select
			p.idsancionjugador,
			concat(jug.apellido, ', ', jug.nombres) as jugador,
			jug.nrodocumento,
			equ.nombre as equipo,
			p.fecha,
			tip.descripcion as tiposancion,
			p.cantidad,
			sf.cantidadfechas,
			DATE_FORMAT(sf.fechadesde, '%d/%m/%Y') as fechadesde,
			DATE_FORMAT(sf.fechahasta, '%d/%m/%Y') as fechahasta,
			sf.amarillas,
			sf.fechascumplidas,
			(case when sf.pendientescumplimientos = 1 then 'Si' else 'No' end) as pendientescumplimientos,
			(case when sf.pendientesfallo = 1 then 'Si' else 'No' end) as pendientesfallo,
			(case when sf.generadaporacumulacion = 1 then 'Si' else 'No' end) as generadaporacumulacion,
			sf.observaciones,
			p.reftiposanciones,
			p.refjugadores,
			p.refequipos,
			p.reffixture,
			p.refcategorias,
			p.refdivisiones,
			p.refsancionesfallos
		from dbsancionesjugadores p
		inner join dbsancionesfallos sf ON sf.idsancionfallo = p.refsancionesfallos
		inner join tbtiposanciones tip ON tip.idtiposancion = p.reftiposanciones
		inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
		inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
		inner join dbcountries co ON co.idcountrie = jug.refcountries 
		inner join dbfixture fix ON fix.idfixture = p.reffixture 
		inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos and tor.reftipotorneo = ".$idTipoTorneo."
		inner join tbfechas fe ON fe.idfecha = fix.reffechas 
		inner join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
		inner join dbequipos equ ON equ.idequipo = p.refequipos 
		inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
		inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
		inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
		where p.idsancionjugador = ".$idFallo;	
		
		$res = $this->query($sql,0);
		return $res;
}

/* Fin */
/* /* Fin de la Tabla: dbsancionesjugadores*/



/* PARA Movimientosanciones */

function existeMovimientoEnFechaPorAcumulacion($reffecha, $idJugador) {
	$sql = "select
			sj.idsancionjugador
			from		dbmovimientosanciones mov
			inner
			join		dbsancionesjugadores sj
			on			sj.idsancionjugador = mov.refsancionesjugadores
			inner
			join		dbsancionesfallos sf
			on			sf.idsancionfallo = sj.refsancionesfallos
			inner
			join		dbfixture fix
			on			fix.idfixture = mov.reffixture
			inner
			join		dbtorneos t
			on			t.idtorneo = fix.reftorneos
			where		mov.reffechas = ".$reffecha." and t.activo = 1 and mov.cumplidas = 0 and sf.generadaporacumulacion = 1 and mov.finalizo = 0 and sj.refjugadores = ".$idJugador;	
			
	$res = $this->query($sql,0); 
	return $res; 
}


function existeMovimientoEnFechaPorCantidadFecha($reffecha, $idJugador) {
	$sql = "select
			sj.idsancionjugador
			from		dbmovimientosanciones mov
			inner
			join		dbsancionesjugadores sj
			on			sj.idsancionjugador = mov.refsancionesjugadores
			inner
			join		dbsancionesfallos sf
			on			sf.idsancionfallo = sj.refsancionesfallos
			inner
			join		dbfixture fix
			on			fix.idfixture = mov.reffixture
			inner
			join		dbtorneos t
			on			t.idtorneo = fix.reftorneos
			where		mov.reffechas = ".$reffecha." and t.activo = 1 and mov.cumplidas = 0 and sf.generadaporacumulacion = 0 and mov.finalizo = 0 and sj.refjugadores = ".$idJugador;	
			
	$res = $this->query($sql,0); 
	return $res; 
}


function insertarMovimientosanciones($refsancionesjugadores,$reffechas,$reffixture,$cumplidas,$finalizo,$orden) { 
$sql = "insert into dbmovimientosanciones(idmovimientosancion,refsancionesjugadores,reffechas,reffixture,cumplidas,finalizo,orden) 
values ('',".$refsancionesjugadores.",".$reffechas.",".$reffixture.",".$cumplidas.",".$finalizo.",".$orden.")"; 
$res = $this->query($sql,1); 
return $res; 
} 

 
function insertarMovimientosancionesManual($refsancionesjugadores,$reffechas,$cumplidas,$orden) {
	
	$resDetalle = $this->traerSancionesjugadoresPorIdDetalles($refsancionesjugadores);
	$finalizo = 0;
	
	$sql = "insert into dbmovimientosanciones(idmovimientosancion,refsancionesjugadores,reffechas,reffixture,cumplidas,finalizo,orden) 
values ('',".$refsancionesjugadores.",".$reffechas.",".mysql_result($resDetalle,0,'reffixture').",".$cumplidas.",".$finalizo.",".$orden.")";
 
	$res = $this->query($sql,1); 
	return $res; 
} 


function modificarMovimientosanciones($id,$refsancionesjugadores,$reffechas,$reffixture,$cumplidas,$finalizo,$orden) { 
$sql = "update dbmovimientosanciones 
set 
refsancionesjugadores = ".$refsancionesjugadores.",reffechas = ".$reffechas.",reffixture = ".$reffixture.",cumplidas = ".$cumplidas.",finalizo = ".$finalizo.",orden = ".$orden." 
where idmovimientosancion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

function modificarMovimientosancionesCumplidas($refsancionesjugadores,$reffechas,$reffixture) { 
$sql = "update dbmovimientosanciones 
set 
cumplidas = 1
where refsancionesjugadores = ".$refsancionesjugadores." and reffechas = ".$reffechas." and reffixture = ".$reffixture;
$res = $this->query($sql,0); 
return $res; 
} 


function modificarMovimientosancionesCumplidasPorId($id,$cumple) { 
$sql = "update dbmovimientosanciones 
set 
cumplidas = ".$cumple."
where idmovimientosancion =".$id;
$res = $this->query($sql,0); 
return $res; 
} 

function modificarMovimientosancionesCorrerFechas($refsancionesjugadores,$reffechas,$reffechasNueva) { 
$sql = "update dbmovimientosanciones 
set 
reffechas = ".$reffechasNueva."
where refsancionesjugadores = ".$refsancionesjugadores." and reffechas = ".$reffechas;
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarMovimientosanciones($id) { 
$sql = "delete from dbmovimientosanciones where idmovimientosancion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarMovimientosancionesPorSancionJugadorAcumuadasAmarillas($idSancionJugador) { 
$sql = "delete from dbmovimientosanciones where refsancionesjugadores =".$idSancionJugador." and orden = 2"; 
$res = $this->query($sql,0); 
return $res; 
} 

function eliminarMovimientosancionesPorSancionJugador($idSancionJugador) { 
$sql = "delete from dbmovimientosanciones where refsancionesjugadores =".$idSancionJugador; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarMovimientosancionesPorSancionJugadorPorFechas($idSancionJugador, $reffechas) { 
$sql = "delete from dbmovimientosanciones where refsancionesjugadores =".$idSancionJugador." and orden = 1 and reffechas in (".$reffechas.") and cumplidas <> 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarMovimientosancionesApartirDe($idSancionJugador, $refFechas) { 
$sql = "delete from dbmovimientosanciones where refsancionesjugadores =".$idSancionJugador." and reffechas <= ".$refFechas; 
$res = $this->query($sql,0); 
return $res; 
}

function traerMovimientosanciones() { 
$sql = "select 
m.idmovimientosancion,
m.refsancionesjugadores,
m.reffechas,
m.reffixture,
m.cumplidas,
m.finalizo,
m.orden
from dbmovimientosanciones m 
inner join dbsancionesjugadores san ON san.idsancionjugador = m.refsancionesjugadores 
inner join tbtiposanciones ti ON ti.idtiposancion = san.reftiposanciones 
inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
inner join dbequipos eq ON eq.idequipo = san.refequipos 
inner join tbfechas fec ON fec.idfecha = m.reffechas 
inner join dbfixture fix ON fix.idfixture = m.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 

function traerMovimientosancionesCompletoPorSancionesJugadores($idSancionJugador) { 
$sql = "select 
m.idmovimientosancion,
fec.fecha,
m.refsancionesjugadores,
m.reffechas,
m.reffixture,
(case when m.cumplidas = 1 then 'Si' else 'No' end) as cumplidas,
m.finalizo,
m.orden
from dbmovimientosanciones m 
inner join dbsancionesjugadores san ON san.idsancionjugador = m.refsancionesjugadores 
inner join tbtiposanciones ti ON ti.idtiposancion = san.reftiposanciones 
inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
inner join dbequipos eq ON eq.idequipo = san.refequipos 
inner join tbfechas fec ON fec.idfecha = m.reffechas 
inner join dbfixture fix ON fix.idfixture = m.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
where san.idsancionjugador = ".$idSancionJugador."
order by m.reffechas"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerMovimientosancionesPorId($id) { 
$sql = "select idmovimientosancion,refsancionesjugadores,reffechas,reffixture,cumplidas,finalizo,orden from dbmovimientosanciones where idmovimientosancion =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function hayMovimientosViejo($idJugador, $idFixture) {
	$sql = "select
			*
			from dbmovimientosanciones ms
			inner join dbsancionesjugadores san ON san.idsancionjugador = ms.refsancionesjugadores 
			inner join dbsancionesfallos sf ON sf.idsancionfallo = san.refsancionesfallos
			inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
			inner join tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
			inner join dbfixture fix on fix.idfixture = ".$idFixture."
			inner join dbtorneos tor on tor.idtorneo = fix.reftorneos
			inner join dbfixture fixv ON fixv.idfixture = san.reffixture
			where ju.idjugador =".$idJugador." and tor.activo = 1 and ms.cumplidas = 0 and tip.cumpletodascategorias = 1 and fix.reffechas > fixv.reffechas";
			
	return $this->existe($sql);			
}

function estaFechaYaFueCumplida($idJugador, $idFixture) {
	$sql = "select * from dbsancionesfechascumplidas where reffixture = ".$idFixture." and refjugadores = ".$idJugador." and cumplida = 1";	
	
	return $this->existe($sql);
}


function hayPendienteDeFallo($idJugador, $idFixture, $idTipoTorneo) {
	$sql = "SELECT 
				coalesce(1,0) as faltan
			FROM
				dbsancionesjugadores san
					INNER JOIN
				dbsancionesfallos sf ON sf.idsancionfallo = san.refsancionesfallos
					INNER JOIN
				dbjugadores ju ON ju.idjugador = san.refjugadores
					INNER JOIN
				tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
					INNER JOIN
				dbfixture fix ON fix.idfixture = ".$idFixture." AND fix.fecha > san.fecha
					INNER JOIN
				dbtorneos tor ON tor.idtorneo = fix.reftorneos
					INNER JOIN
				dbfixture fixv ON fixv.idfixture = san.reffixture
					inner join
				dbtorneos torv ON torv.idtorneo = fixv.reftorneos and torv.reftipotorneo = ".$idTipoTorneo."
					left join
				(select fc.refsancionesfallos,torc.refcategorias, count(*) as cumplidas 
					from dbsancionesfechascumplidas fc
					inner join dbfixture fixf on fixf.idfixture = fc.reffixture
					inner join dbtorneos torc on torc.idtorneo = fixf.reftorneos 
					group by fc.refsancionesfallos,torc.refcategorias) sfc
				ON  sfc.refsancionesfallos = sf.idsancionfallo and sfc.refcategorias = san.refcategorias
			WHERE
				ju.idjugador = ".$idJugador."
					AND sf.pendientesfallo = 1
					AND (case when torv.idtorneo <> tor.idtorneo then fix.reffechas >= 1 else fix.reffechas > fixv.reffechas end)";
			
	return $this->existeDevuelveId($sql);			
}

function hayMovimientos($idJugador, $idFixture, $idTipoTorneo) {
	$sql = "SELECT 
				coalesce(sf.cantidadfechas -  coalesce(sfc.cumplidas,0),0) as faltan
			FROM
				dbsancionesjugadores san
					INNER JOIN
				dbsancionesfallos sf ON sf.idsancionfallo = san.refsancionesfallos
					INNER JOIN
				dbjugadores ju ON ju.idjugador = san.refjugadores
					INNER JOIN
				tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
					INNER JOIN
				dbfixture fix ON fix.idfixture = ".$idFixture." AND fix.fecha > san.fecha
					INNER JOIN
				dbtorneos tor ON tor.idtorneo = fix.reftorneos and tor.reftipotorneo = ".$idTipoTorneo."
					INNER JOIN
				dbfixture fixv ON fixv.idfixture = san.reffixture
					inner join
				dbtorneos torv ON torv.idtorneo = fixv.reftorneos
					left join
				(select fc.refsancionesfallos,torc.refcategorias, count(*) as cumplidas 
					from dbsancionesfechascumplidas fc
					inner join dbfixture fixf on fixf.idfixture = fc.reffixture
					inner join dbtorneos torc on torc.idtorneo = fixf.reftorneos 
					group by fc.refsancionesfallos,torc.refcategorias) sfc
				ON  sfc.refsancionesfallos = sf.idsancionfallo and sfc.refcategorias = san.refcategorias
			WHERE
				ju.idjugador = ".$idJugador."
					AND tip.cumpletodascategorias = 1
					AND sf.fechascumplidas <> sf.cantidadfechas
					AND (case when torv.idtorneo <> tor.idtorneo then fix.reffechas >= 1 else fix.reffechas > fixv.reffechas end)";
			
	return $this->existeDevuelveId($sql);			
}


function hayMovimientosDevuelveId($idJugador, $idFixture, $idTipoTorneo) {
	$sql = "SELECT 
				distinct san.refsancionesfallos
			FROM
				dbsancionesjugadores san
					INNER JOIN
				dbsancionesfallos sf ON sf.idsancionfallo = san.refsancionesfallos
					INNER JOIN
				dbjugadores ju ON ju.idjugador = san.refjugadores
					INNER JOIN
				tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
					INNER JOIN
				dbfixture fix ON fix.idfixture = ".$idFixture."
					INNER JOIN
				dbtorneos tor ON tor.idtorneo = fix.reftorneos and tor.reftipotorneo = ".$idTipoTorneo."
					INNER JOIN
				dbfixture fixv ON fixv.idfixture = san.reffixture
					inner join
				dbtorneos torv ON torv.idtorneo = fixv.reftorneos
					left join
				(select fc.refsancionesfallos, count(*) as cumplidas 
					from dbsancionesfechascumplidas fc 
					group by fc.refsancionesfallos) sfc
				ON  sfc.refsancionesfallos = sf.idsancionfallo
			WHERE
				ju.idjugador = ".$idJugador."
					AND tip.cumpletodascategorias = 1
					AND sf.fechascumplidas <> sf.cantidadfechas
					AND (case when torv.idtorneo <> tor.idtorneo then fix.reffechas >= 1 else fix.reffechas > fixv.reffechas end)";
			
	return $this->existeDevuelveId($sql);			
}

function hayMovimientosAmarillasAcumuladas($idJugador, $idFixture, $idCategoria, $idTipoTorneo) {
	$sql = "SELECT 
				coalesce(sf.cantidadfechas - sf.fechascumplidas,0) as faltan
			FROM
				dbsancionesjugadores san
					INNER JOIN
				dbsancionesfallosacumuladas sf ON sf.refsancionesjugadores = san.idsancionjugador
					INNER JOIN
				dbjugadores ju ON ju.idjugador = san.refjugadores
					INNER JOIN
				tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
					INNER JOIN
				dbfixture fix ON fix.idfixture = ".$idFixture." AND fix.fecha > san.fecha
					INNER JOIN
				dbtorneos tor ON tor.idtorneo = fix.reftorneos and san.refcategorias = tor.refcategorias
					INNER JOIN
				dbfixture fixv ON fixv.idfixture = san.reffixture
					inner join
				dbtorneos torv ON torv.idtorneo = fixv.reftorneos and torv.reftipotorneo = ".$idTipoTorneo."
			WHERE
				ju.idjugador = ".$idJugador."
					AND tor.refcategorias = ".$idCategoria."
					AND sf.generadaporacumulacion = 1
					and sf.fechascumplidas = 0
					AND (case when torv.idtorneo <> tor.idtorneo then fix.reffechas >= 1 else fix.reffechas > fixv.reffechas end)";
	
					
	return $this->existeDevuelveId($sql);	
}

function hayMovimientosAmarillasAcumuladasDevuelveId($idJugador, $idFixture, $idCategoria, $idTipoTorneo) {
	$sql = "SELECT 
				distinct san.idsancionjugador
			FROM
				dbsancionesjugadores san
					INNER JOIN
				dbsancionesfallosacumuladas sf ON sf.refsancionesjugadores = san.idsancionjugador
					INNER JOIN
				dbjugadores ju ON ju.idjugador = san.refjugadores
					INNER JOIN
				tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
					INNER JOIN
				dbfixture fix ON fix.idfixture = ".$idFixture."
					INNER JOIN
				dbtorneos tor ON tor.idtorneo = fix.reftorneos and san.refcategorias = tor.refcategorias
					INNER JOIN
				dbfixture fixv ON fixv.idfixture = san.reffixture
					inner join
				dbtorneos torv ON torv.idtorneo = fixv.reftorneos and torv.reftipotorneo = ".$idTipoTorneo."
					
			WHERE
				ju.idjugador = ".$idJugador."
					AND tor.refcategorias = ".$idCategoria."
					AND sf.generadaporacumulacion = 1
					and sf.fechascumplidas = 0
					AND (case when torv.idtorneo <> tor.idtorneo then fix.reffechas >= 1 else fix.reffechas > fixv.reffechas end)";
					
	return $this->existeDevuelveId($sql);	
}

function hayMovimientosAmarillasAcumuladasDevuelveIdAcumulado($idJugador, $idFixture, $idCategoria, $idTipoTorneo) {
	$sql = "SELECT 
				distinct sf.idsancionfalloacumuladas
			FROM
				dbsancionesjugadores san
					INNER JOIN
				dbsancionesfallosacumuladas sf ON sf.refsancionesjugadores = san.idsancionjugador
					INNER JOIN
				dbjugadores ju ON ju.idjugador = san.refjugadores
					INNER JOIN
				tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
					INNER JOIN
				dbfixture fix ON fix.idfixture = ".$idFixture."
					INNER JOIN
				dbtorneos tor ON tor.idtorneo = fix.reftorneos and san.refcategorias = tor.refcategorias
					INNER JOIN
				dbfixture fixv ON fixv.idfixture = san.reffixture
					inner join
				dbtorneos torv ON torv.idtorneo = fixv.reftorneos and torv.reftipotorneo = ".$idTipoTorneo."
					
			WHERE
				ju.idjugador = ".$idJugador."
					AND tor.refcategorias = ".$idCategoria."
					AND sf.generadaporacumulacion = 1
					and sf.fechascumplidas = 0
					AND (case when torv.idtorneo <> tor.idtorneo then fix.reffechas >= 1 else fix.reffechas > fixv.reffechas end)";
					
	return $this->existeDevuelveId($sql);	
}

function devolverIdSancionJugadorPorSancion($idJugador, $idFixture, $idTipoTorneo) {
	$sql = "select
			*
			from dbmovimientosanciones ms
			inner join dbsancionesjugadores san ON san.idsancionjugador = ms.refsancionesjugadores 
			inner join dbsancionesfallos sf ON sf.idsancionfallo = san.refsancionesfallos
			inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
			inner join tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
			inner join dbfixture fix on fix.idfixture = ".$idFixture."
			inner join dbtorneos tor on tor.idtorneo = fix.reftorneos and tor.reftipotorneo = ".$idTipoTorneo."
			inner join dbfixture fixv ON fixv.idfixture = san.reffixture
			where ju.idjugador =".$idJugador." and tor.activo = 1 and ms.cumplidas = 0 and tip.cumpletodascategorias = 1 and fix.reffechas > fixv.reffechas";
			
	return $this->existe($sql);	
				
}


function traerMovimientosancionesPorSancionJugadorCumplidas($idSancionJugador) {
	$sql = "select
				ms.reffechas
			from dbmovimientosanciones ms
			inner join dbsancionesjugadores san ON san.idsancionjugador = ms.refsancionesjugadores 
			inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
			inner join tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
			where ms.refsancionesjugadores =".$idSancionJugador." and ms.cumplidas = 0 and tip.cumpletodascategorias = 1
			order by ms.reffechas
            limit 1";
			
	$res = $this->query($sql,0); 
	return $res; 				
}

function traerMovimientosancionesPorSancionJugador($idJugador) {
	$sql = "select
				t.idsancionjugador,t.idmovimientosancion,t.reffechas, t.cumplidas, t.finalizo,  t.tipofallo,t.refcategorias
			from 
			(
					select
							san.idsancionjugador,ms.idmovimientosancion,ms.reffechas, ms.cumplidas, ms.finalizo, 0 as refcategorias, 'Fechas' as tipofallo
						from dbmovimientosanciones ms
						inner join dbsancionesjugadores san ON san.idsancionjugador = ms.refsancionesjugadores 
						inner join dbfixture fix on fix.idfixture = san.reffixture
						inner join dbtorneos tor on tor.idtorneo = fix.reftorneos
						inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
						inner join tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
						where tip.cumpletodascategorias = 1 and tor.activo = 1 and ju.idjugador =".$idJugador."
			union all
					select
							san.idsancionjugador,ms.idmovimientosancion,ms.reffechas, ms.cumplidas, ms.finalizo, tor.refcategorias, 'Acu.Amarillas' as tipofallo
						from dbmovimientosanciones ms
						inner join dbsancionesjugadores san ON san.idsancionjugador = ms.refsancionesjugadores 
						inner join dbfixture fix on fix.idfixture = san.reffixture
						inner join dbtorneos tor on tor.idtorneo = fix.reftorneos
						inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
						inner join tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
						where tip.cumpletodascategorias = 0 and tor.activo = 1 and ju.idjugador = ".$idJugador."
			) t
			order by t.reffechas";
			
	$res = $this->query($sql,0); 
	return $res; 				
}

function traerMovimientosancionesPorSancion($idSancionJugador) {
	$sql = "select
				t.idsancionjugador,t.idmovimientosancion,t.reffechas, 
				(case when t.cumplidas = 1 then 'Si' else 'No' end) as cumplidas, 
				t.finalizo,  
				t.tipofallo,t.refcategorias, t.orden
			from 
			(
					select
							san.idsancionjugador,ms.idmovimientosancion,ms.reffechas, ms.cumplidas, ms.finalizo, 0 as refcategorias, 'Fechas' as tipofallo, ms.orden
						from dbmovimientosanciones ms
						inner join dbsancionesjugadores san ON san.idsancionjugador = ms.refsancionesjugadores 
						inner join dbfixture fix on fix.idfixture = san.reffixture
						inner join dbtorneos tor on tor.idtorneo = fix.reftorneos
						inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
						inner join tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
						where tip.cumpletodascategorias = 1 and tor.activo = 1 and san.idsancionjugador =".$idSancionJugador."
			union all
					select
							san.idsancionjugador,ms.idmovimientosancion,ms.reffechas, ms.cumplidas, ms.finalizo, tor.refcategorias, 'Acu.Amarillas' as tipofallo, ms.orden
						from dbmovimientosanciones ms
						inner join dbsancionesjugadores san ON san.idsancionjugador = ms.refsancionesjugadores 
						inner join dbfixture fix on fix.idfixture = san.reffixture
						inner join dbtorneos tor on tor.idtorneo = fix.reftorneos
						inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
						inner join tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
						where tip.cumpletodascategorias = 0 and tor.activo = 1 and san.idsancionjugador =".$idSancionJugador."
			) t
			order by t.reffechas";
			
	$res = $this->query($sql,0); 
	return $res; 				
}

function traerMovimientosancionesIdSancionPorSancionJugador($idJugador) {
	$sql = "select
				distinct t.idsancionjugador,t.idtorneo
			from 
			(
					select
							san.idsancionjugador,ms.idmovimientosancion,ms.reffechas, ms.cumplidas, ms.finalizo, 0 as refcategorias, 'Fechas' as tipofallo,tor.idtorneo
						from dbmovimientosanciones ms
						inner join dbsancionesjugadores san ON san.idsancionjugador = ms.refsancionesjugadores 
						inner join dbfixture fix on fix.idfixture = san.reffixture
						inner join dbtorneos tor on tor.idtorneo = fix.reftorneos
						inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
						inner join tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
						where tip.cumpletodascategorias = 1 and tor.activo = 1 and ju.idjugador = ".$idJugador."
			union all
					select
							san.idsancionjugador,ms.idmovimientosancion,ms.reffechas, ms.cumplidas, ms.finalizo, tor.refcategorias, 'Acu.Amarillas' as tipofallo,tor.idtorneo
						from dbmovimientosanciones ms
						inner join dbsancionesjugadores san ON san.idsancionjugador = ms.refsancionesjugadores 
						inner join dbfixture fix on fix.idfixture = san.reffixture
						inner join dbtorneos tor on tor.idtorneo = fix.reftorneos
						inner join dbjugadores ju ON ju.idjugador = san.refjugadores 
						inner join tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
						where tip.cumpletodascategorias = 0 and tor.activo = 1 and ju.idjugador = ".$idJugador."
			) t
			";	
			
	$res = $this->query($sql,0); 
	return $res; 
}

/* Fin */
/* /* Fin de la Tabla: dbmovimientosanciones*/


/* PARA Sancionesfechascumplidas */

function insertarSancionesfechascumplidas($reffixture,$refjugadores,$cumplida,$refsancionesfallos, $idTipoTorneo) { 

	$sqlExiste = "select idsancionfechacumplida from dbsancionesfechascumplidas where reffixture =".$reffixture." and refjugadores =".$refjugadores;
	
	$resExiste = $this->existe($sqlExiste);
	
	if ($resExiste == 0) {
		$resFix = $this->TraerFixturePorId($reffixture);
		
		$resTorneo	=	$this->traerTorneosPorId(mysql_result($resFix,0,'reftorneos'));
		
		$idCategoria	=	mysql_result($resTorneo,0,'refcategorias');
										
		$suspendidoCategorias		=	$this->hayMovimientos($refjugadores,$reffixture, $idTipoTorneo);
		
		$suspendidoCategoriasAA		=	$this->hayMovimientosAmarillasAcumuladas($refjugadores,$reffixture, $idCategoria, $idTipoTorneo);
		
		//primero sanciono por fecha desde y hasta
		if ($suspendidoCategorias != 0) {
			//busco el refsancionesfallos
			$refsancionesfallos = $this->hayMovimientosDevuelveId($refjugadores,$reffixture, $idTipoTorneo);
			$idAcumulado = 0;
		} else {
			if ($suspendidoCategoriasAA != 0) {
				$refsancionesJugadores = $this->hayMovimientosAmarillasAcumuladasDevuelveId($refjugadores,$reffixture, $idCategoria, $idTipoTorneo);
				$idAcumulado		 = $this->hayMovimientosAmarillasAcumuladasDevuelveIdAcumulado($refjugadores,$reffixture, $idCategoria, $idTipoTorneo);
				//hago cumplir la fecha
				$this->modificarSancionesfallosacumuladasPorSancionJugador($refsancionesJugadores);
				$refsancionesfallos = 0;
			}
		}
		
		$sql = "insert into dbsancionesfechascumplidas(idsancionfechacumplida,reffixture,refjugadores,cumplida,refsancionesfallos,refsancionesfallosacumuladas) 
		values ('',".$reffixture.",".$refjugadores.",".$cumplida.",".$refsancionesfallos.",".$idAcumulado.")"; 
		$res = $this->query($sql,1); 
		return $res; 
	
	}
} 

function insertarSancionCumplidaSolo($reffixture, $refjugadores, $cumplida, $refsancionesfallos, $idAcumulado) {
	$sql = "insert into dbsancionesfechascumplidas(idsancionfechacumplida,reffixture,refjugadores,cumplida,refsancionesfallos,refsancionesfallosacumuladas) 
		values ('',".$reffixture.",".$refjugadores.",".$cumplida.",".$refsancionesfallos.",".$idAcumulado.")"; 
		$res = $this->query($sql,1); 
		return $res;
}



function modificarSancionesfechascumplidas($id,$reffixture,$refjugadores,$cumplida,$refsancionesfallos) { 
$sql = "update dbsancionesfechascumplidas 
set 
reffixture = ".$reffixture.",refjugadores = ".$refjugadores.",cumplida = ".$cumplida.",refsancionesfallos = ".$refsancionesfallos." 
where idsancionfechacumplida =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarSancionesfechascumplidas($id) { 
$sql = "delete from dbsancionesfechascumplidas where idsancionfechacumplida =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarSancionesfechascumplidasPorSancionFallo($idSancionFallo) { 
$sql = "delete from dbsancionesfechascumplidas where refsancionesfallos =".$idSancionFallo; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerSancionesfechascumplidas() { 
$sql = "select 
s.idsancionfechacumplida,
s.reffixture,
s.refjugadores,
s.cumplida,
s.refsancionesfallos
from dbsancionesfechascumplidas s 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerSancionesfechascumplidasPorSancionJugador($idSancionJugador) { 
$sql = "select 
			s.idsancionfechacumplida,
			fec.fecha,
			cat.categoria,
			(case
				when s.cumplida = 1 then 'Si'
				else 'No'
			end) as cumplida,
			s.reffixture,
			s.refjugadores,
			s.refsancionesfallos
		from
			dbsancionesfechascumplidas s
				inner join
			dbsancionesjugadores sj ON s.refsancionesfallos = sj.refsancionesfallos
				inner join
			dbfixture fix ON fix.idfixture = s.reffixture
				inner join
			dbtorneos tor ON tor.idtorneo = fix.reftorneos
				inner join
			tbcategorias cat ON cat.idtcategoria = tor.refcategorias
				inner join
			tbfechas fec ON fec.idfecha = fix.reffechas
		where sj.idsancionjugador = ".$idSancionJugador."
		order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerSancionesfechascumplidasPorSancionJugadorEnSuCategoria($idSancionJugador) { 
$sql = "select 
			s.idsancionfechacumplida,
			fec.fecha,
			cat.categoria,
			(case
				when s.cumplida = 1 then 'Si'
				else 'No'
			end) as cumplida,
			s.reffixture,
			s.refjugadores,
			s.refsancionesfallos
			
		from
			dbsancionesfechascumplidas s
				inner join
			dbsancionesjugadores sj ON s.refsancionesfallos = sj.refsancionesfallos
				inner join
			dbfixture fix ON fix.idfixture = s.reffixture
				inner join
			dbtorneos tor ON tor.idtorneo = fix.reftorneos and tor.refcategorias = sj.refcategorias
				inner join
			tbcategorias cat ON cat.idtcategoria = tor.refcategorias
				inner join
			tbfechas fec ON fec.idfecha = fix.reffechas
		where sj.idsancionjugador = ".$idSancionJugador."
		order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerSancionesfechascumplidasPorId($id) { 
$sql = "select idsancionfechacumplida,reffixture,refjugadores,(case when cumplida = 1 then 'Si' else 'No' end) as cumplida,refsancionesfallos from dbsancionesfechascumplidas where idsancionfechacumplida =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbsancionesfechascumplidas*/

/* PARA Goleadores */


function existeFixturePorGoleadores($idJugador, $idFixture) {
	$sql = "select * from dbgoleadores where refjugadores =".$idJugador." and reffixture =".$idFixture;
	
	return $this->existeDevuelveId($sql);	
}


function insertarGoleadores($refjugadores,$reffixture,$refequipos,$refcategorias,$refdivisiones,$goles,$encontra) { 
$sql = "insert into dbgoleadores(idgoleador,refjugadores,reffixture,refequipos,refcategorias,refdivisiones,goles,encontra) 
values ('',".$refjugadores.",".$reffixture.",".$refequipos.",".$refcategorias.",".$refdivisiones.",".$goles.",".$encontra.")"; 
$res = $this->query($sql,1); 
return $res; 
} 


function modificarGoleadores($id,$refjugadores,$reffixture,$refequipos,$refcategorias,$refdivisiones,$goles,$encontra) { 
$sql = "update dbgoleadores 
set 
refjugadores = ".$refjugadores.",reffixture = ".$reffixture.",refequipos = ".$refequipos.",refcategorias = ".$refcategorias.",refdivisiones = ".$refdivisiones.",goles = ".$goles.",encontra = ".$encontra." 
where idgoleador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 


function eliminarGoleadores($id) { 
$sql = "delete from dbgoleadores where idgoleador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

function modificaGoleadoresPorFixtureMasivo($idfixture, $idEquipo) {
	$sql	=	"update dbgoleadores set goles = 0, encontra = 0 where reffixture =".$idfixture." and refequipos = ".$idEquipo;
	$res = $this->query($sql,0); 
	
	$sqlP	=	"update dbpenalesjugadores set penalconvertido = 0, penalerrado = 0, penalatajado = 0 where reffixture =".$idfixture." and refequipos = ".$idEquipo;
	$resP = $this->query($sqlP,0); 
	
	return $res; 
}


function traerGoleadores() { 
$sql = "select 
p.idgoleador,
p.refjugadores,
p.reffixture,
p.refequipos,
p.refcategorias,
p.refdivisiones,
p.goles,
p.encontra
from dbgoleadores p
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
order by 1"; 
$res = $this->query($sql,0); 
return $res; 
} 


function traerGoleadoresPorJugadorFixture($idJugador, $idFixture) { 
$sql = "select 
p.idgoleador,
p.refjugadores,
p.reffixture,
p.refequipos,
p.refcategorias,
p.refdivisiones,
p.goles,
p.encontra
from dbgoleadores p
inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
inner join dbcountries co ON co.idcountrie = jug.refcountries 
inner join dbfixture fix ON fix.idfixture = p.reffixture 
inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
inner join tbfechas fe ON fe.idfecha = fix.reffechas 
left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
inner join dbequipos equ ON equ.idequipo = p.refequipos 
inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
where p.refjugadores = ".$idJugador." and p.reffixture =".$idFixture;
$res = $this->query($sql,0); 
return $res; 
}


function traerIncidenciasPorFixtureEquipoLocal($idFixture, $idEquipo) { 
$sql = "select
r.apyn,
r.nrodocumento,
r.refjugadores,
r.reffixture,
r.refequipos,
r.refcategorias,
r.refdivisiones,
sum(r.goles) as goles,
sum(r.encontra) as encontra,
max(r.aei) as aei,
sum(r.pc) as pc,
sum(r.pa) as pa,
sum(r.pe) as pe
from (
select 
	concat(jug.apellido, ', ', jug.nombres) as apyn, 
	jug.nrodocumento,
	p.refjugadores,
	p.reffixture,
	p.refequipos,
	p.refcategorias,
	p.refdivisiones,
	p.goles,
	p.encontra,
	0 as aei,
	0 as pc,
	0 as pa,
	0 as pe
	from dbgoleadores p
	inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
	inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
	inner join dbcountries co ON co.idcountrie = jug.refcountries 
	inner join dbfixture fix ON fix.idfixture = p.reffixture 
	inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
	inner join tbfechas fe ON fe.idfecha = fix.reffechas 
	left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
	inner join dbequipos equ ON equ.idequipo = p.refequipos 
	inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
	inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
	inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
	where p.reffixture =".$idFixture." and p.refequipos =".$idEquipo."
	
	union all
	
	select 
	concat(jug.apellido, ', ', jug.nombres) as apyn, 
	jug.nrodocumento,
	p.refjugadores,
	p.reffixture,
	p.refequipos,
	p.refcategorias,
	p.refdivisiones,
	0 as goles,
	0 as encontra,
	0 as aei,
	p.penalconvertido as pc,
	p.penalatajado as pa,
	p.penalerrado as pe
	from dbpenalesjugadores p
	inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
	inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
	inner join dbcountries co ON co.idcountrie = jug.refcountries 
	inner join dbfixture fix ON fix.idfixture = p.reffixture 
	inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
	inner join tbfechas fe ON fe.idfecha = fix.reffechas 
	left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
	inner join dbequipos equ ON equ.idequipo = p.refequipos 
	inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
	inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
	inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
	where p.reffixture =".$idFixture." and p.refequipos =".$idEquipo." and (p.penalconvertido > 0 or p.penalatajado > 0 or p.penalerrado > 0)
	
	
	union all
	
	select 
	concat(jug.apellido, ', ', jug.nombres) as apyn, 
	jug.nrodocumento,
	p.refjugadores,
	p.reffixture,
	p.refequipos,
	p.refcategorias,
	p.refdivisiones,
	0 as goles,
	0 as encontra,
	(case when p.reftiposanciones = 1 then 'A'
			when p.reftiposanciones = 2 then 'E'
			when p.reftiposanciones = 3 then 'I' end) as aei,
	0 as pc,
	0 as pa,
	0 as pe
	from dbsancionesjugadores p
	inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
	inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
	inner join dbcountries co ON co.idcountrie = jug.refcountries 
	inner join dbfixture fix ON fix.idfixture = p.reffixture 
	inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
	inner join tbfechas fe ON fe.idfecha = fix.reffechas 
	left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
	inner join dbequipos equ ON equ.idequipo = p.refequipos 
	inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
	inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
	inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
	where p.reffixture =".$idFixture." and p.refequipos =".$idEquipo." and p.reftiposanciones in (1,2,3) and p.cantidad >0
) as r
group by r.apyn,
r.nrodocumento,
r.refjugadores,
r.reffixture,
r.refequipos,
r.refcategorias,
r.refdivisiones";
$res = $this->query($sql,0); 
return $res; 
}


function traerIncidenciasPorFixtureEquipoVisitante($idFixture, $idEquipo) { 
$sql = "select
r.apyn,
r.nrodocumento,
r.refjugadores,
r.reffixture,
r.refequipos,
r.refcategorias,
r.refdivisiones,
sum(r.goles) as goles,
sum(r.encontra) as encontra,
max(r.aei) as aei,
sum(r.pc) as pc,
sum(r.pa) as pa,
sum(r.pe) as pe
from (
select 
	concat(jug.apellido, ', ', jug.nombres) as apyn, 
	jug.nrodocumento,
	p.refjugadores,
	p.reffixture,
	p.refequipos,
	p.refcategorias,
	p.refdivisiones,
	p.goles,
	p.encontra,
	0 as aei,
	0 as pc,
	0 as pa,
	0 as pe
	from dbgoleadores p
	inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
	inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
	inner join dbcountries co ON co.idcountrie = jug.refcountries 
	inner join dbfixture fix ON fix.idfixture = p.reffixture 
	inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
	inner join tbfechas fe ON fe.idfecha = fix.reffechas 
	left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
	inner join dbequipos equ ON equ.idequipo = p.refequipos 
	inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
	inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
	inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
	where p.reffixture =".$idFixture." and p.refequipos =".$idEquipo."
	
	union all
	
	select 
	concat(jug.apellido, ', ', jug.nombres) as apyn, 
	jug.nrodocumento,
	p.refjugadores,
	p.reffixture,
	p.refequipos,
	p.refcategorias,
	p.refdivisiones,
	0 as goles,
	0 as encontra,
	0 as aei,
	p.penalconvertido as pc,
	p.penalatajado as pa,
	p.penalerrado as pe
	from dbpenalesjugadores p
	inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
	inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
	inner join dbcountries co ON co.idcountrie = jug.refcountries 
	inner join dbfixture fix ON fix.idfixture = p.reffixture 
	inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
	inner join tbfechas fe ON fe.idfecha = fix.reffechas 
	left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
	inner join dbequipos equ ON equ.idequipo = p.refequipos 
	inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
	inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
	inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
	where p.reffixture =".$idFixture." and p.refequipos =".$idEquipo." and (p.penalconvertido > 0 or p.penalatajado > 0 or p.penalerrado > 0)
	
	
	union all
	
	select 
	concat(jug.apellido, ', ', jug.nombres) as apyn, 
	jug.nrodocumento,
	p.refjugadores,
	p.reffixture,
	p.refequipos,
	p.refcategorias,
	p.refdivisiones,
	0 as goles,
	0 as encontra,
	(case when p.reftiposanciones = 1 then 'A'
			when p.reftiposanciones = 2 then 'E'
			when p.reftiposanciones = 3 then 'I' end) as aei,
	0 as pc,
	0 as pa,
	0 as pe
	from dbsancionesjugadores p
	inner join dbjugadores jug ON jug.idjugador = p.refjugadores 
	inner join tbtipodocumentos ti ON ti.idtipodocumento = jug.reftipodocumentos 
	inner join dbcountries co ON co.idcountrie = jug.refcountries 
	inner join dbfixture fix ON fix.idfixture = p.reffixture 
	inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
	inner join tbfechas fe ON fe.idfecha = fix.reffechas 
	left join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
	inner join dbequipos equ ON equ.idequipo = p.refequipos 
	inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
	inner join tbcategorias cat ON cat.idtcategoria = p.refcategorias 
	inner join tbdivisiones divi ON divi.iddivision = p.refdivisiones 
	where p.reffixture =".$idFixture." and p.refequipos =".$idEquipo." and p.reftiposanciones in (1,2,3) and p.cantidad >0
) as r
group by r.apyn,
r.nrodocumento,
r.refjugadores,
r.reffixture,
r.refequipos,
r.refcategorias,
r.refdivisiones";
$res = $this->query($sql,0); 
return $res; 
}


function traerPromedioCanchasPorCountrie($idCountrie, $idTemporada) {
	$sql = "select
				r.idcountrie, r.countrie, r.cancha, round((r.calificacion / r.cantidad),2) as promedio
			from (
				select 
					cou.idcountrie, cou.nombre as countrie, cc.nombre as cancha
					, sum(fix.calificacioncancha) as calificacion, count(fix.idfixture) as cantidad
			
				from  dbfixture fix
				inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
				inner join tbfechas fe ON fe.idfecha = fix.reffechas 
				inner join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
				inner join dbequipos equ ON equ.idequipo = fix.refconectorlocal
				inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
				inner join dbcountriecanchas dc ON dc.refcountries = cou.idcountrie
				inner join tbcanchas cc ON cc.idcancha = dc.refcanchas
				where fix.calificacioncancha <> 0 and
				tor.reftemporadas = ".$idTemporada."
				group by cou.idcountrie, cc.nombre, cou.nombre
			) as r
			where r.idcountrie = ".$idCountrie."
			order by 4 desc,3";	
	$res = $this->query($sql,0); 
	return $res;
}

function traerPromedioCanchas($idTemporada) {
	$sql = "select
				r.idcountrie, r.countrie, round((r.calificacion / r.cantidad),2) as promedio
			from (
				select 
					cou.idcountrie, cou.nombre as countrie
					, sum(fix.calificacioncancha) as calificacion, count(fix.idfixture) as cantidad
			
				from  dbfixture fix
				inner join dbtorneos tor ON tor.idtorneo = fix.reftorneos 
				inner join tbfechas fe ON fe.idfecha = fix.reffechas 
				inner join tbestadospartidos es ON es.idestadopartido = fix.refestadospartidos 
				inner join dbequipos equ ON equ.idequipo = fix.refconectorlocal
				inner join dbcountries cou ON cou.idcountrie = equ.refcountries 
				inner join dbcountriecanchas dc ON dc.refcountries = cou.idcountrie
				inner join tbcanchas cc ON cc.idcancha = dc.refcanchas
				where fix.calificacioncancha <> 0 and
				tor.reftemporadas = ".$idTemporada."
				group by cou.idcountrie,  cou.nombre
			) as r
			order by 3 desc";
	$res = $this->query($sql,0); 
	return $res;	
}


function traerGoleadoresPorId($id) { 
$sql = "select idgoleador,refjugadores,reffixture,refequipos,refcategorias,refdivisiones,goles,encontra from dbgoleadores where idgoleador =".$id; 
$res = $this->query($sql,0); 
return $res; 
} 

/* Fin */
/* /* Fin de la Tabla: dbgoleadores*/


function traerEstadisticaPorFixtureJugadorCategoriaDivision($idJugador, $idFixture, $idCategoria, $idDivision) {
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
	coalesce(minj.minutos,-1) as minutosjugados,
	(case when coalesce(mj.idmejorjugador,0) > 0 then 'Si' else 'No' end) as mejorjugador,
	coalesce(gol.goles,0) as goles,
	coalesce(gol.encontra,0) as encontra,
	coalesce(pen.penalconvertido,0) as penalconvertido,
	coalesce(pen.penalerrado,0) as penalerrado,
	coalesce(pen.penalatajado,0) as penalatajado    
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
    dbcontactos con ON con.idcontacto = equ.refcontactos
        inner join
    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
        inner join
    tbcategorias cat ON cat.idtcategoria = c.refcategorias
		inner join
	dbfixture fix ON fix.refconectorlocal = equ.idequipo
		left join
	dbmejorjugador mj 
    ON 	mj.reffixture = fix.idfixture 
		and mj.refjugadores = jug.idjugador
        and mj.refcategorias = cat.idtcategoria
        and mj.refdivisiones = di.iddivision
        LEFT JOIN
    dbminutosjugados minj 
    ON 	minj.reffixture = fix.idfixture
		and minj.refjugadores = jug.idjugador
        and minj.refcategorias = cat.idtcategoria
        and minj.refdivisiones = di.iddivision
        LEFT JOIN
    dbgoleadores gol 
    ON 	gol.reffixture = fix.idfixture
		and gol.refjugadores = jug.idjugador
        and gol.refcategorias = cat.idtcategoria
        and gol.refdivisiones = di.iddivision
        LEFT JOIN
    dbpenalesjugadores pen 
    ON 	pen.reffixture = fix.idfixture
		and pen.refjugadores = jug.idjugador
        and pen.refcategorias = cat.idtcategoria
        and pen.refdivisiones = di.iddivision
	where jug.idjugador = ".$idJugador." and fix.idfixture = ".$idFixture." and c.refcategorias = ".$idCategoria." and di.iddivision = ".$idDivision;
	$res = $this->query($sql,0);

	
	return $res;
		
}


function traerEstadisticaPorFixtureJugadorCategoriaDivisionVisitante($idJugador, $idFixture, $idCategoria, $idDivision) {
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
	coalesce(minj.minutos,-1) as minutosjugados,
	(case when coalesce(mj.idmejorjugador,0) > 0 then 'Si' else 'No' end) as mejorjugador,
	coalesce(gol.goles,0) as goles,
	coalesce(gol.encontra,0) as encontra,
	coalesce(pen.penalconvertido,0) as penalconvertido,
	coalesce(pen.penalerrado,0) as penalerrado,
	coalesce(pen.penalatajado,0) as penalatajado    
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
    dbcontactos con ON con.idcontacto = equ.refcontactos
        inner join
    tbposiciontributaria po ON po.idposiciontributaria = co.refposiciontributaria
        inner join
    tbcategorias cat ON cat.idtcategoria = c.refcategorias
		inner join
	dbfixture fix ON fix.refconectorvisitante = equ.idequipo
		left join
	dbmejorjugador mj 
    ON 	mj.reffixture = fix.idfixture 
		and mj.refjugadores = jug.idjugador
        and mj.refcategorias = cat.idtcategoria
        and mj.refdivisiones = di.iddivision
        LEFT JOIN
    dbminutosjugados minj 
    ON 	minj.reffixture = fix.idfixture
		and minj.refjugadores = jug.idjugador
        and minj.refcategorias = cat.idtcategoria
        and minj.refdivisiones = di.iddivision
        LEFT JOIN
    dbgoleadores gol 
    ON 	gol.reffixture = fix.idfixture
		and gol.refjugadores = jug.idjugador
        and gol.refcategorias = cat.idtcategoria
        and gol.refdivisiones = di.iddivision
        LEFT JOIN
    dbpenalesjugadores pen 
    ON 	pen.reffixture = fix.idfixture
		and pen.refjugadores = jug.idjugador
        and pen.refcategorias = cat.idtcategoria
        and pen.refdivisiones = di.iddivision
	where jug.idjugador = ".$idJugador." and fix.idfixture = ".$idFixture." and c.refcategorias = ".$idCategoria." and di.iddivision = ".$idDivision;
	$res = $this->query($sql,0);
	return $res;	
}

/***************************************** Fin *****************************************/
/************  FUNCIONES PARA LA PARTE ADMINISTRATIVA  *********************/

/****** VERIFICO LA EDAD ******/////
function verificarEdad($refjugador) {
	$sql = "select DATE_FORMAT(fechanacimiento, '%Y') as fechanacimiento from dbjugadores where idjugador =".$refjugador;
	$res = $this->query($sql,0);
	
	$fechactual = date('Y');
	$edadJuagador = mysql_result($res,0,'fechanacimiento');
	
	$edad = $fechactual - $edadJuagador;
	
	return $edad;	
}
/******   FIN   *****///////////////

/******   COMPRUEBO SI PUEDO JUGAR EN ESA CATEGORIA Y TIPO DE JUGADOR, POR LA EDAD     *************/
function verificaEdadCategoriaJugador($refjugador, $refcategoria, $tipoJugador) {
	//## falta chocar contra una temporada
	$edad = $this->verificarEdad($refjugador);
	
	$sql = "SELECT 
				count(*) as verificado
			FROM
				dbdefinicionescategoriastemporadastipojugador dc
					INNER JOIN
				(SELECT 
					iddefinicioncategoriatemporada
				FROM
					dbdefinicionescategoriastemporadas ct
				WHERE
					ct.refcategorias = ".$refcategoria."
				ORDER BY iddefinicioncategoriatemporada DESC
				LIMIT 1) c
				on c.iddefinicioncategoriatemporada = dc.refdefinicionescategoriastemporadas
				where dc.reftipojugadores = ".$tipoJugador." and ".$edad." between dc.edadminima and dc.edadmaxima";
	$res = $this->query($sql,0);
	
	return mysql_result($res,0,0);
}

/***************************           FIN         ******************************/


/******   COMPRUEBO SI TIENE UNA HABILITACION TEMPORAL ADMINISTRATIVA     *************/
function verificaHabilitacionDeportiva($refjugador, $refcategoria, $reftemporada, $refequipo) {
	//## falta chocar contra una temporada
	
	$res = $this->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorDeportiva($refjugador, $reftemporada, $refcategoria, $refequipo);
	
	if (mysql_num_rows($res)>0) {
		return 1;	
	}
	
	return 0;
}

/***************************           FIN         ******************************/

/************      FIN        **********************************************/

/* Fin */

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