<?php



function calcularPuntoBonusViejo($refTorneo, $idEquipo) {
    $resPuntosBonus = traerPuntobonusPorId(1);
    
    $cantidadFechas = (integer)mysql_result($resPuntosBonus,0,'cantidadfechas');
    
    $puntosextra    = (integer)mysql_result($resPuntosBonus,0,'puntosextra');
    
    
    //determinar ultima fecha jugado del torneo 
    $ultimaFecha    =   traerUltimaFechaFixturePorTorneoEquipo($refTorneo, $idEquipo);
    
    $mod            = floor($ultimaFecha / $cantidadFechas );
    
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
            
            $resCalculo = existeDevuelveId($calculo);
            if ($resCalculo > 0) {  
                $puntos += $puntosextra;    
            }
                
        }
        
        return $puntos;
                
    }
    
    return $puntos; 
    
    
}

function traerPuntobonusPorId($id) { 
$sql = "select idpuntobonus,descripcion,cantidadfechas,consecutivas,comparacion,valoracomparar,puntosextra from tbpuntobonus where idpuntobonus =".$id; 
$res = query($sql,0); 
return $res; 
} 

function traerUltimaFechaFixturePorTorneoEquipoNuevo($idTorneo, $idEquipo) {
    $sql = "select
            max(f.reffechas)
            from dbfixture f
            inner join dbtorneos tor ON tor.idtorneo = f.reftorneos 
            inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
            where tor.idtorneo = ".$idTorneo." and (f.refconectorlocal = ".$idEquipo." or f.refconectorvisitante = ".$idEquipo.")";
            
    $res = existeDevuelveId($sql);
    return $res;
}


function calcularPuntoBonus($refTorneo, $idEquipo) {
    $resPuntosBonus = traerPuntobonusPorId(1);
    
    $cantidadFechas = (integer)mysql_result($resPuntosBonus,0,'cantidadfechas');
    
    $puntosextra    = (integer)mysql_result($resPuntosBonus,0,'puntosextra');
    
    
    //determinar ultima fecha jugado del torneo 
    $ultimaFecha    =   traerUltimaFechaFixturePorTorneoEquipoNuevo($refTorneo, $idEquipo);
    

    $puntos=0;
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
            where fix.reftorneos = ".$refTorneo." and fix.reffechas <= ".$ultimaFecha."
            and fix.refestadospartidos is not null
            AND (fix.refconectorlocal = ".$idEquipo."
            OR fix.refconectorvisitante = ".$idEquipo.")
            group by fix.reffechas order by fix.fecha";
        
        
        //return $calculo;
        $resCalcular = query($calculo,0);
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

// web lucio
function ResultadosPartidosAnteriores($refTorneo, $idequipo) {
    $sql = "select
                r.idfecha, r.fecha, r.resultado
            from (
            select 
                    f.reffechas as idfecha,f.fecha,
                    (case when f.puntoslocal > f.puntosvisita then 'G'
                          when f.puntoslocal < f.puntosvisita then 'P'
                          when f.puntoslocal = f.puntosvisita then 'E'
                     end) resultado
                from
                    dbfixture f
                inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
                inner join tbfechas fec ON fec.idfecha = f.reffechas
                inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
                where
                    tor.idtorneo = ".$refTorneo." and f.refconectorlocal = ".$idequipo." and est.finalizado = 1
            union all
            select 
                    f.reffechas as idfecha,f.fecha,
                    (case when f.puntosvisita > f.puntoslocal then 'G'
                          when f.puntosvisita < f.puntoslocal then 'P'
                          when f.puntosvisita = f.puntoslocal then 'E'
                     end) resultado
                from
                    dbfixture f
                inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
                inner join tbfechas fec ON fec.idfecha = f.reffechas
                inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
                where
                    tor.idtorneo = ".$refTorneo." and f.refconectorvisitante = ".$idequipo." and est.finalizado = 1
            ) r
                order by r.fecha desc
            limit 0,3"; 
            
    $res = query($sql,0);
    return $res;
    
}

// web lucio -- para la conformada
function ResultadosPartidosAnterioresPorCategoriaDivision($refCategoria, $refDivision, $idequipo) {
    $sql = "select
                r.idfecha, r.fecha, r.resultado
            from (
            select 
                    f.reffechas as idfecha,f.fecha,
                    (case when f.puntoslocal > f.puntosvisita then 'G'
                          when f.puntoslocal < f.puntosvisita then 'P'
                          when f.puntoslocal = f.puntosvisita then 'E'
                     end) resultado
                from
                    dbfixture f
                inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
                inner join tbfechas fec ON fec.idfecha = f.reffechas
                inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
                where
                    tor.refcategorias = ".$refCategoria." and refdivisiones = ".$refDivision." and f.refconectorlocal = ".$idequipo." and est.finalizado = 1
            union all
            select 
                    f.reffechas as idfecha,f.fecha,
                    (case when f.puntosvisita > f.puntoslocal then 'G'
                          when f.puntosvisita < f.puntoslocal then 'P'
                          when f.puntosvisita = f.puntoslocal then 'E'
                     end) resultado
                from
                    dbfixture f
                inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
                inner join tbfechas fec ON fec.idfecha = f.reffechas
                inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
                where
                    tor.refcategorias = ".$refCategoria." and refdivisiones = ".$refDivision." and f.refconectorvisitante = ".$idequipo." and est.finalizado = 1
            ) r
                order by r.fecha desc
            limit 1,3"; 
            
    $res = query($sql,0);
    return $res;
    
}


function traerTorneopuntobonusPorTorneo($idTorneo) { 
$sql = "select idtorneopuntobonus,reftorneos,refpuntobonus from dbtorneopuntobonus where reftorneos =".$idTorneo; 
$res = query($sql,0); 
return $res; 
} 

function existeDevuelveId($sql) {

    $res = query($sql,0);
    
    if (mysql_num_rows($res)>0) {
        return mysql_result($res,0,0);  
    }
    return 0;
}


function traerUltimaFechaFixturePorTorneo($idTorneo) {
    $sql = "select
            distinct max(f.reffechas)
            from dbfixture f
            inner join dbtorneos tor ON tor.idtorneo = f.reftorneos 
            inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
            where tor.idtorneo = ".$idTorneo;
            
    $res = existeDevuelveId($sql);
    return $res;
}

function PosicionFechaAnterior($refTorneo) {
    $sql = "
select 
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
from   
    (select 
        el.nombre as equipo,
            f.puntoslocal as puntos,
            ca.categoria,
            arb.nombrecompleto as arbitro,
            f.goleslocal as goles,
            f.golesvisitantes as golescontra,
            can.nombre as canchas,
            date_format(f.fecha, '%d/%m/%Y') as fechajuego,
            f.hora,
            f.calificacioncancha,
            f.juez1,
            f.juez2,
            f.observaciones,
            f.publicar,
            count(el.idequipo) as pj,
            sum(case
                when f.puntoslocal = 3 then 1
                else 0
            end) as pg,
            sum(case
                when f.puntoslocal = 0 then 1
                else 0
            end) as pp,
            sum(case
                when f.puntoslocal = 1 then 1
                else 0
            end) as pe,
            sum(coalesce(fixa.amarillas, 0)) as amarillas,
            sum(coalesce(fixr.rojas, 0)) as rojas,
            el.idequipo
    from
        dbfixture f
    inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
    inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
    inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
    inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
    inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
    inner join (select 
        max(fec.idfecha) - 1 as idfecha
    from
        dbfixture f
    inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
    inner join tbfechas fec ON fec.idfecha = f.reffechas
    inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
    where
        tor.idtorneo = ".$refTorneo." and est.finalizado = 1) fr ON f.reffechas <= fr.idfecha
    inner join dbequipos el ON el.idequipo = f.refconectorlocal
    left join dbarbitros arb ON arb.idarbitro = f.refarbitros
    left join tbcanchas can ON can.idcancha = f.refcanchas
    inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
        and est.finalizado = 1
    left join (SELECT 
        SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
    FROM
        dbsancionesjugadores sj
    INNER JOIN dbfixture fix ON sj.reffixture = fix.idfixture
        and fix.refconectorlocal = sj.refequipos
    INNER JOIN tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
    where
        ts.amonestacion = 1
            and (sj.refsancionesfallos is null
            or sj.refsancionesfallos = 0)
    GROUP BY fix.idfixture , sj.refequipos) fixa ON fixa.idfixture = f.idfixture
        and fixa.refequipos = el.idequipo
    left join (SELECT 
        SUM(sj.cantidad) AS rojas, fix.idfixture, sj.refequipos
    FROM
        dbsancionesjugadores sj
    INNER JOIN dbfixture fix ON sj.reffixture = fix.idfixture
        and fix.refconectorlocal = sj.refequipos
    INNER JOIN tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
    where
        ts.expulsion = 1
    GROUP BY fix.idfixture , sj.refequipos) fixr ON fixr.idfixture = f.idfixture
        and fixr.refequipos = el.idequipo
    where
        tor.idtorneo = ".$refTorneo."
    group by el.nombre , f.puntoslocal , ca.categoria , arb.nombrecompleto , f.goleslocal , f.golesvisitantes , can.nombre , f.fecha , f.hora , f.calificacioncancha , f.juez1 , f.juez2 , f.observaciones , f.publicar , el.idequipo 

union all 
select 
        ev.nombre as equipo,
            f.puntosvisita as puntos,
            ca.categoria,
            arb.nombrecompleto as arbitro,
            f.golesvisitantes as goles,
            f.goleslocal as golescontra,
            can.nombre as canchas,
            date_format(f.fecha, '%d/%m/%Y') as fechajuego,
            f.hora,
            f.calificacioncancha,
            f.juez1,
            f.juez2,
            f.observaciones,
            f.publicar,
            count(ev.idequipo) as pj,
            sum(case
                when f.puntosvisita = 3 then 1
                else 0
            end) as pg,
            sum(case
                when f.puntosvisita = 0 then 1
                else 0
            end) as pp,
            sum(case
                when f.puntosvisita = 1 then 1
                else 0
            end) as pe,
            sum(coalesce(fixa.amarillas, 0)) as amarillas,
            sum(coalesce(fixr.rojas, 0)) as rojas,
            ev.idequipo
    from
        dbfixture f
    inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
    inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
    inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
    inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
    inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
    inner join (select 
        max(fec.idfecha) - 1 as idfecha
    from
        dbfixture f
    inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
    inner join tbfechas fec ON fec.idfecha = f.reffechas
    inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
    where
        tor.idtorneo = ".$refTorneo." and est.finalizado = 1) fr ON f.reffechas <= fr.idfecha
    inner join dbequipos ev ON ev.idequipo = f.refconectorvisitante
    left join dbarbitros arb ON arb.idarbitro = f.refarbitros
    left join tbcanchas can ON can.idcancha = f.refcanchas
    inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
        and est.finalizado = 1
    left join (SELECT 
        SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
    FROM
        dbsancionesjugadores sj
    INNER JOIN dbfixture fix ON sj.reffixture = fix.idfixture
        and fix.refconectorvisitante = sj.refequipos
    INNER JOIN tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
    where
        ts.amonestacion = 1
            and (sj.refsancionesfallos is null
            or sj.refsancionesfallos = 0)
    GROUP BY fix.idfixture , sj.refequipos) fixa ON fixa.idfixture = f.idfixture
        and fixa.refequipos = ev.idequipo
    left join (SELECT 
        SUM(sj.cantidad) AS rojas, fix.idfixture, sj.refequipos
    FROM
        dbsancionesjugadores sj
    INNER JOIN dbfixture fix ON sj.reffixture = fix.idfixture
        and fix.refconectorvisitante = sj.refequipos
    INNER JOIN tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
    where
        ts.expulsion = 1
    GROUP BY fix.idfixture , sj.refequipos) fixr ON fixr.idfixture = f.idfixture
        and fixr.refequipos = ev.idequipo
    where
        tor.idtorneo = ".$refTorneo."
    group by ev.nombre , f.puntosvisita , ca.categoria , arb.nombrecompleto , f.golesvisitantes , f.goleslocal , can.nombre , f.fecha , f.hora , f.calificacioncancha , f.juez1 , f.juez2 , f.observaciones , f.publicar , ev.idequipo union all select 
        ev.nombre as equipo,
            0 as puntos,
            ca.categoria,
            '' as arbitro,
            0 as goles,
            0 as golescontra,
            '' as canchas,
            '' as fechajuego,
            '' as hora,
            '' as calificacioncancha,
            '' as juez1,
            '' as juez2,
            '' as observaciones,
            '' as publicar,
            0 as pj,
            0 as pg,
            0 as pp,
            0 as pe,
            0 as amarillas,
            0 as rojas,
            ev.idequipo
    from
        (select 
        e.idequipo, e.nombre, t.refcategorias
    from
        dbequipos e
    inner join dbtorneos t ON e.refcategorias = t.refcategorias
        and e.refdivisiones = t.refdivisiones
    inner join tbcategorias ca ON ca.idtcategoria = t.refcategorias
    where
        t.idtorneo = ".$refTorneo." and e.activo = 1 and t.activo = 1) ev
    inner join tbcategorias ca ON ca.idtcategoria = ev.refcategorias
    left join dbfixture f ON (ev.idequipo = f.refconectorlocal
        or ev.idequipo = f.refconectorvisitante)
        and f.reftorneos = ".$refTorneo."
        and f.refestadospartidos is not null
    where
        f.idfixture is null) p
group by p.equipo , p.idequipo
order by sum(p.puntos) desc , sum(p.rojas) asc , sum(p.amarillas) asc, sum(p.goles) desc, sum(p.golescontra) desc
 ";
    
    $res = query($sql,0);
    
    $arPosiciones = array();
    
    $puntosBonus = 0;
    
    $resPuntosBonus =   traerTorneopuntobonusPorTorneo($refTorneo);
    
    $posicion = 1;
    while ($row = mysql_fetch_array($res)) {
        $puntosBonus = 0;
        if (mysql_num_rows($resPuntosBonus)>0) {
            $puntosBonus = calcularPuntoBonus($refTorneo, $row['idequipo']); 
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
                              'idequipo'=> $row['idequipo'],
                              'posicion'=> $posicion);
        $posicion += 1;                   
        $puntosBonus = 0;                     
    }

    $sorted = array_orderby($arPosiciones, 'puntos', SORT_DESC, 'rojas', SORT_ASC, 'amarillas', SORT_ASC, 'goles', SORT_DESC, 'golescontra', SORT_ASC);

    return $sorted;
}

function devolverPuntoBonusFijo($reftorneos, $refequipos) {
    $sql = "select puntos from tbpuntosbonusfijo where reftorneos =".$reftorneos." and refequipos =".$refequipos;

    $res = query($sql,0);

    if (mysql_num_rows($res)>0) {
        return mysql_result($res, 0,0);
    }

    return 0;
}

function Posiciones($refTorneo) {
    
    $ultimaFecha = traerUltimaFechaFixturePorTorneo($refTorneo);
    
    
    $sql = "select
k.equipo,
k.puntos,
k.goles,
k.golescontra,
k.pj,
k.pg,
k.pp,
k.pe,
k.amarillas,
k.rojas,
k.idequipo,
k.observacionestorneo,
k.observacionesgenerales,
(case when ep.asterisco= 1 then '1' else '0' end) as asterisco,
ep.descripcion as observacion,
    @rownum:= @rownum + 1 'posicion'
from    (

    select

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
p.idequipo,
p.observacionestorneo,
p.observacionesgenerales,
max(p.idfixture ) as idfixture


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
el.idequipo,
tor.observaciones as observacionestorneo,
tor.observacionesgenerales,
f.idfixture
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
inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos and est.finalizado = 1

left join(SELECT 
            SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
        FROM
            dbsancionesjugadores sj
                INNER JOIN
            dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorlocal = sj.refequipos
                INNER JOIN
        tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
        where ts.amonestacion = 1 and (sj.refsancionesfallos is null or sj.refsancionesfallos = 0) and sj.cantidad <> 2
        GROUP BY fix.idfixture, sj.refequipos) fixa
on      fixa.idfixture = f.idfixture and fixa.refequipos = el.idequipo

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
on      fixr.idfixture = f.idfixture and fixr.refequipos = el.idequipo

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
            el.idequipo,
            tor.observaciones,
            tor.observacionesgenerales,
            f.idfixture

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
ev.idequipo,
tor.observaciones as observacionestorneo,
tor.observacionesgenerales,
f.idfixture   
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
inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos and est.finalizado = 1

left join(SELECT 
            SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
        FROM
            dbsancionesjugadores sj
                INNER JOIN
            dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorvisitante = sj.refequipos
                INNER JOIN
        tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
        where ts.amonestacion = 1 and (sj.refsancionesfallos is null or sj.refsancionesfallos = 0) and sj.cantidad <> 2
        GROUP BY fix.idfixture, sj.refequipos) fixa
on      fixa.idfixture = f.idfixture and fixa.refequipos = ev.idequipo

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
on      fixr.idfixture = f.idfixture and fixr.refequipos = ev.idequipo

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
            ev.idequipo,
            tor.observaciones,
            tor.observacionesgenerales,
            f.idfixture
            
        union all
        
        select
        
        ev.nombre as equipo,
        0 as puntos,
        ca.categoria,
        '' as arbitro,
        0 as goles,
        0 as golescontra,
        '' as canchas,
        '' as fecha,
        '' as fechajuego,
        '' as hora,
        '' as calificacioncancha,
        '' as juez1,
        '' as juez2,
        '' as observaciones,
        '' as publicar,
        0 as pj,
        0 as pg,
        0 as pp,
        0 as pe,
        0 as amarillas,
        0 as rojas,
        ev.idequipo,
        ev.observacionestorneo,
        ev.observacionesgenerales,
        ev.idfixture AS idfixture
    from (select 
                e.idequipo,
                e.nombre,
                t.refcategorias,
                t.observaciones as observacionestorneo,
                t.observacionesgenerales,
                fl.idfixture
        from dbequipos e 
        inner join dbtorneos t on e.refcategorias = t.refcategorias and e.refdivisiones = t.refdivisiones
        inner join tbcategorias ca on ca.idtcategoria = t.refcategorias
        inner join (select ff.refconectorlocal, ff.idfixture from dbfixture ff where ff.reftorneos=".$refTorneo." group by ff.refconectorlocal, ff.idfixture) fl
        on fl.refconectorlocal = e.idequipo
        where t.idtorneo = ".$refTorneo." and e.activo=1 and t.activo = 1) ev
inner join tbcategorias ca ON ca.idtcategoria = ev.refcategorias
left join dbfixture f ON (ev.idequipo = f.refconectorlocal or ev.idequipo = f.refconectorvisitante) and f.reftorneos = ".$refTorneo." and f.refestadospartidos is not null and f.reffechas= 1

where f.idfixture is null
) p
group by p.equipo, p.idequipo, p.observacionestorneo, p.observacionesgenerales
order by sum(p.puntos) desc, sum(p.rojas) asc, sum(p.amarillas) asc

) k 
inner join dbfixture fix on fix.idfixture = k.idfixture
left join tbestadospartidos ep on ep.idestadopartido = fix.refestadospartidos
, (SELECT @rownum:=0) R ";
    $res = query($sql,0);
    
    $arPosiciones = array();
    $arPosicionesAux = array();
    
    $puntosBonus = 0;
    $puntoBonusFijo = 0;
    
    $resPuntosBonus =   traerTorneopuntobonusPorTorneo($refTorneo);
    
    $posicion = 1;
    while ($row = mysql_fetch_array($res)) {
        $puntosBonus = 0;
        $puntoBonusFijo = 0;
        
        if (mysql_num_rows($resPuntosBonus)>0) {
            $puntoBonusFijo = devolverPuntoBonusFijo($refTorneo, $row['idequipo']);
            $puntosBonus = calcularPuntoBonus($refTorneo, $row['idequipo']); 
            $puntosBonus = $puntosBonus + $puntoBonusFijo;
        }
        //die(var_dump($puntosBonus));
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
                              'idequipo'=> $row['idequipo'],
                              'posicion'=> $posicion,
                              'observacionestorneo'=>$row['observacionestorneo'],
                              'observacionesgenerales'=>$row['observacionesgenerales'],
                              'asterisco'=>$row['asterisco'],
                              'observaciones'=>$row['observacion']);
        $posicion += 1;                   
        $puntosBonus = 0;                     
    }

    if ($ultimaFecha == 1) {
        $sorted = array_orderby($arPosiciones,'pj', SORT_DESC, 'puntos', SORT_DESC, 'rojas', SORT_ASC, 'amarillas', SORT_ASC, 'goles', SORT_DESC, 'golescontra', SORT_ASC);
    } else {
        $sorted = array_orderby($arPosiciones, 'puntos', SORT_DESC, 'rojas', SORT_ASC, 'amarillas', SORT_ASC, 'goles', SORT_DESC, 'golescontra', SORT_ASC);
    }
    
    $posicion = 1;
    foreach ($sorted as $row) {

        $arPosicionesAux[] = array('equipo'=> $row['equipo'],
                              'puntos'=> (integer)$row['puntos'],
                              'goles'=> $row['goles'],
                              'golescontra'=> $row['golescontra'],
                              'pj'=> $row['pj'],
                              'pg'=> $row['pg'],
                              'pp'=> $row['pp'],
                              'pe'=> $row['pe'],
                              'amarillas'=> $row['amarillas'],
                              'rojas'=> $row['rojas'],
                              'puntobonus'=> $row['puntobonus'],
                              'idequipo'=> $row['idequipo'],
                              'posicion'=> $posicion,
                              'observacionestorneo'=>$row['observacionestorneo'],
                              'observacionesgenerales'=>$row['observacionesgenerales'],
                              'asterisco'=>$row['asterisco'],
                              'observaciones'=>$row['observaciones']);
        $posicion += 1;                   
                  
    }
    
    return $arPosicionesAux;

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
inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos and est.finalizado = 1

left join(SELECT 
            SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
        FROM
            dbsancionesjugadores sj
                INNER JOIN
            dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorlocal = sj.refequipos
                INNER JOIN
        tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
        where ts.amonestacion = 1 and (sj.refsancionesfallos is null or sj.refsancionesfallos = 0) and sj.cantidad <> 2
        GROUP BY fix.idfixture, sj.refequipos) fixa
on      fixa.idfixture = f.idfixture and fixa.refequipos = el.idequipo

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
on      fixr.idfixture = f.idfixture and fixr.refequipos = el.idequipo

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
inner join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos and est.finalizado = 1

left join(SELECT 
            SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
        FROM
            dbsancionesjugadores sj
                INNER JOIN
            dbfixture fix ON sj.reffixture = fix.idfixture and fix.refconectorvisitante = sj.refequipos
                INNER JOIN
        tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
        where ts.amonestacion = 1 and (sj.refsancionesfallos is null or sj.refsancionesfallos = 0) and sj.cantidad <> 2
        GROUP BY fix.idfixture, sj.refequipos) fixa
on      fixa.idfixture = f.idfixture and fixa.refequipos = ev.idequipo

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
on      fixr.idfixture = f.idfixture and fixr.refequipos = ev.idequipo

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
            
union all

select

ev.nombre as equipo,
0 as puntos,
ca.categoria,
'' as arbitro,
0 as goles,
0 as golescontra,
'' as canchas,
'' as fecha,
'' as fechajuego,
'' as hora,
'' as calificacioncancha,
'' as juez1,
'' as juez2,
'' as observaciones,
'' as publicar,
0 as pj,
0 as pg,
0 as pp,
0 as pe,
0 as amarillas,
0 as rojas,
ev.idequipo  
from (select 
        e.idequipo,
        e.nombre,
        t.refcategorias
        from dbequipos e 
        inner join dbtorneos t on e.refcategorias = t.refcategorias and e.refdivisiones = t.refdivisiones
        inner join tbcategorias ca on ca.idtcategoria = t.refcategorias
        inner join (select ff.refconectorlocal from dbfixture ff where ff.reftorneos=".$refTorneo." group by ff.refconectorlocal) fl
        on fl.refconectorlocal = e.idequipo
        where t.idtorneo = ".$refTorneo." and e.activo=1 and t.activo = 1) ev
inner join tbcategorias ca ON ca.idtcategoria = ev.refcategorias
left join dbfixture f ON (ev.idequipo = f.refconectorlocal or ev.idequipo = f.refconectorvisitante) and f.reftorneos = ".$refTorneo." and f.refestadospartidos is not null

where f.idfixture is null

) p
group by p.equipo, p.idequipo
order by sum(p.puntos) desc, sum(p.rojas) asc, sum(p.amarillas) asc, sum(p.goles) desc, sum(p.encontra) desc

";  
    $res = query($sql,0);

    return $res;

}


function unique_multidim_array($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
} 



function PosicionesConformada($idTemporada, $idCategoria, $idDivision) {
    
    $sql = "select idtorneo from dbtorneos where reftemporadas =".$idTemporada;
    
    $resConformada = query($sql,0);
    
    $lstPosiciones = array();
    
    $lstPosicionesFinal = array();
    
    $observacionesgenerales = '';

    while ($rowT = mysql_fetch_array($resConformada)) {
    
        $arPosiciones = Posiciones($rowT['idtorneo']);
        
        foreach ($arPosiciones as $valorT) {
            
            $lstPosiciones[] = array('equipo'=> $valorT['equipo'],
                                  'puntos'=> (integer)$valorT['puntos'],
                                  'goles'=> (integer)$valorT['goles'],
                                  'golescontra'=> (integer)$valorT['golescontra'],
                                  'pj'=> (integer)$valorT['pj'],
                                  'pg'=> (integer)$valorT['pg'],
                                  'pp'=> (integer)$valorT['pp'],
                                  'pe'=> (integer)$valorT['pe'],
                                  'amarillas'=> (integer)$valorT['amarillas'],
                                  'rojas'=> (integer)$valorT['rojas'],
                                  'puntobonus'=> (integer)$valorT['puntobonus'],
                                  'observacionesgenerales'=> $valorT['observacionesgenerales'],
                                  'idequipo'=> (integer)$valorT['idequipo']);
                                                      
        }

    
    }
    
    $sorted = array_orderby($lstPosiciones, 'idequipo', SORT_ASC);
    
    $cambio = 0;
    $primero = 0;
    
    $equipo     = '';
    $puntos     = 0;
    $goles      = 0;
    $golescontra= 0;
    $pj         = 0;
    $pg         = 0;
    $pp         = 0;
    $pe         = 0;
    $amarillas  = 0;
    $rojas      = 0;
    $puntobonus = 0;
    $soloUno    = 0;
    
    
    $tamañoAr = count($sorted);
    
    //die(var_dump($sorted));
    if (mysql_num_rows($resConformada) > 1) {
        foreach ($sorted as $tblFinal) {
            if ($cambio != $tblFinal['idequipo']) {
                
                if (($soloUno != 0) && ($primero == 1)) {
                    $lstPosicionesFinal[] = array('equipo'=> $equipo,
                                      'puntos'=> $puntos,
                                      'goles'=> $goles,
                                      'golescontra'=> $golescontra,
                                      'pj'=> $pj,
                                      'pg'=> $pg,
                                      'pp'=> $pp,
                                      'pe'=> $pe,
                                      'amarillas'=> $amarillas,
                                      'rojas'=> $rojas,
                                      'puntobonus'=> $puntobonus,
                                      'observacionesgenerales' => $observacionesgenerales,
                                      'idequipo'=> $tblFinal['idequipo']);
                    
                    $primero = 0;
                }
                $cambio = $tblFinal['idequipo'];
                
                $equipo     = '';
                $puntos     = 0;
                $goles      = 0;
                $pj         = 0;
                $pg         = 0;
                $pp         = 0;
                $pe         = 0;
                $amarillas  = 0;
                $rojas      = 0;
                $puntobonus = 0;
                $golescontra= 0;

            }
            
            $equipo     = $tblFinal['equipo'];
            $puntos     += (integer)$tblFinal['puntos'];
            $goles      += (integer)$tblFinal['goles'];
            $golescontra+= (integer)$tblFinal['golescontra'];
            $pj         += (integer)$tblFinal['pj'];
            $pg         += (integer)$tblFinal['pg'];
            $pp         += (integer)$tblFinal['pp'];
            $pe         += (integer)$tblFinal['pe'];
            $amarillas  += (integer)$tblFinal['amarillas'];
            $rojas      += (integer)$tblFinal['rojas'];
            $puntobonus += (integer)$tblFinal['puntobonus'];
            
            if ($tblFinal['observacionesgenerales'] != '') {
                $observacionesgenerales = $tblFinal['observacionesgenerales'];    
            }
            
            
            if ($primero != 0) {
                $lstPosicionesFinal[] = array('equipo'=> $equipo,
                                  'puntos'=> $puntos,
                                  'goles'=> $goles,
                                  'golescontra'=> $golescontra,
                                  'pj'=> $pj,
                                  'pg'=> $pg,
                                  'pp'=> $pp,
                                  'pe'=> $pe,
                                  'amarillas'=> $amarillas,
                                  'rojas'=> $rojas,
                                  'puntobonus'=> $puntobonus,
                                  'observacionesgenerales' => $observacionesgenerales,
                                  'idequipo'=> $tblFinal['idequipo']);
                
                $primero = 0;
            } else {
                $soloUno = 1;
                $primero += 1;  
            }

        
         
        }
        
        $tamañoAr2 = count($lstPosicionesFinal);

        if ($tamañoAr != $tamañoAr2) {
            $lstPosicionesFinal[] = array('equipo'=> $equipo,
                                  'puntos'=> $puntos,
                                  'goles'=> $goles,
                                  'golescontra'=> $golescontra,
                                  'pj'=> $pj,
                                  'pg'=> $pg,
                                  'pp'=> $pp,
                                  'pe'=> $pe,
                                  'amarillas'=> $amarillas,
                                  'rojas'=> $rojas,
                                  'puntobonus'=> $puntobonus,
                                  'observacionesgenerales' => $observacionesgenerales,
                                  'idequipo'=> $cambio);
        }
    
    } else {
        $lstPosicionesFinal = $lstPosiciones;
    }
    
    
    $sorted = array_orderby($lstPosicionesFinal, 'puntos', SORT_DESC, 'rojas', SORT_ASC, 'amarillas', SORT_ASC, 'goles',SORT_DESC, 'golescontra', SORT_ASC);
    
    
    $resss = unique_multidim_array($sorted,'idequipo');
    return $resss;

}



function PosicionesConformada2($idTemporada, $idCategoria, $idDivision) {
    
    $sql = "select idtorneo from dbtorneos where reftemporadas =".$idTemporada." and refcategorias = ".$idCategoria." and refdivisiones = ".$idDivision." and acumulatablaconformada = 1";
    
    $resConformada = query($sql,0);
    
    $lstPosiciones = array();
    
    $lstPosicionesFinal = array();

    while ($rowT = mysql_fetch_array($resConformada)) {
    
        $arPosiciones = Posiciones($rowT['idtorneo']);
        
        foreach ($arPosiciones as $valorT) {
            
            $lstPosiciones[] = array('equipo'=> $valorT['equipo'],
                                  'puntos'=> (integer)$valorT['puntos'],
                                  'goles'=> (integer)$valorT['goles'],
                                  'golescontra'=> (integer)$valorT['golescontra'],
                                  'pj'=> (integer)$valorT['pj'],
                                  'pg'=> (integer)$valorT['pg'],
                                  'pp'=> (integer)$valorT['pp'],
                                  'pe'=> (integer)$valorT['pe'],
                                  'amarillas'=> (integer)$valorT['amarillas'],
                                  'rojas'=> (integer)$valorT['rojas'],
                                  'puntobonus'=> (integer)$valorT['puntobonus'],
                                  'idequipo'=> (integer)$valorT['idequipo']);
                                                      
        }

    
    }
    
    $sorted = array_orderby($lstPosiciones, 'idequipo', SORT_ASC);
    
    $cambio = 0;
    $primero = 0;
    
    $equipo     = '';
    $puntos     = 0;
    $goles      = 0;
    $golescontra= 0;
    $pj         = 0;
    $pg         = 0;
    $pp         = 0;
    $pe         = 0;
    $amarillas  = 0;
    $rojas      = 0;
    $puntobonus = 0;
    $soloUno    = 0;

    $tamañoAr = count($sorted);
    
    //die(var_dump($sorted));
    foreach ($sorted as $tblFinal) {
        if ($cambio != $tblFinal['idequipo']) {
            
            if (($soloUno != 0) && ($primero == 1)) {
                $lstPosicionesFinal[] = array('equipo'=> $equipo,
                                  'puntos'=> $puntos,
                                  'goles'=> $goles,
                                  'golescontra'=> $golescontra,
                                  'pj'=> $pj,
                                  'pg'=> $pg,
                                  'pp'=> $pp,
                                  'pe'=> $pe,
                                  'amarillas'=> $amarillas,
                                  'rojas'=> $rojas,
                                  'puntobonus'=> $puntobonus,
                                  'idequipo'=> (integer)$tblFinal['idequipo']);
                
                $primero = 0;
            }

            $cambio = (integer)$tblFinal['idequipo'];
            
            $equipo     = '';
            $puntos     = 0;
            $goles      = 0;
            $pj         = 0;
            $pg         = 0;
            $pp         = 0;
            $pe         = 0;
            $amarillas  = 0;
            $rojas      = 0;
            $puntobonus = 0;
            $golescontra= 0;

        }
        
        $equipo     = $tblFinal['equipo'];
        $puntos     += (integer)$tblFinal['puntos'];
        $goles      += (integer)$tblFinal['goles'];
        $golescontra+= (integer)$tblFinal['golescontra'];
        $pj         += (integer)$tblFinal['pj'];
        $pg         += (integer)$tblFinal['pg'];
        $pp         += (integer)$tblFinal['pp'];
        $pe         += (integer)$tblFinal['pe'];
        $amarillas  += (integer)$tblFinal['amarillas'];
        $rojas      += (integer)$tblFinal['rojas'];
        $puntobonus += (integer)$tblFinal['puntobonus'];
        
        if ($primero != 0) {
            $lstPosicionesFinal[] = array('equipo'=> $equipo,
                              'puntos'=> $puntos,
                              'goles'=> $goles,
                              'golescontra'=> $golescontra,
                              'pj'=> $pj,
                              'pg'=> $pg,
                              'pp'=> $pp,
                              'pe'=> $pe,
                              'amarillas'=> $amarillas,
                              'rojas'=> $rojas,
                              'puntobonus'=> $puntobonus,
                              'idequipo'=> $tblFinal['idequipo']);
            
            $primero = 0;
        } else {
            $soloUno = 1;
            $primero += 1;  
        }
        
         
    }

    $tamañoAr2 = count($lstPosicionesFinal);

    if ($tamañoAr != $tamañoAr2) {
        $lstPosicionesFinal[] = array('equipo'=> $equipo,
                              'puntos'=> $puntos,
                              'goles'=> $goles,
                              'golescontra'=> $golescontra,
                              'pj'=> $pj,
                              'pg'=> $pg,
                              'pp'=> $pp,
                              'pe'=> $pe,
                              'amarillas'=> $amarillas,
                              'rojas'=> $rojas,
                              'puntobonus'=> $puntobonus,
                              'idequipo'=> $cambio);
    }
    
    
    $sorted = array_orderby($lstPosicionesFinal, 'puntos', SORT_DESC, 'rojas', SORT_ASC, 'amarillas', SORT_ASC, 'goles',SORT_DESC, 'golescontra', SORT_ASC);
    
    //die(var_dump($sorted));
    return $sorted;

}


function array_msort($array, $cols)
{
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;

}

function PosicionesConformadaPrueba($idTemporada, $idCategoria, $idDivision) {
    
    $sql = "select idtorneo from dbtorneos where reftemporadas =".$idTemporada." and refcategorias = ".$idCategoria." and refdivisiones = ".$idDivision." and acumulatablaconformada = 1";
    
    $resConformada = query($sql,0);
    
    $lstPosiciones = array();
    
    $lstPosicionesFinal = array();

    while ($rowT = mysql_fetch_array($resConformada)) {
    
        $arPosiciones = Posiciones($rowT['idtorneo']);
        
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
    
    $sorted = array_orderby($lstPosiciones, 'idequipo', SORT_ASC);

    
    
    $cambio = 0;
    $primero = 0;
    
    $equipo     = '';
    $puntos     = 0;
    $goles      = 0;
    $golescontra= 0;
    $pj         = 0;
    $pg         = 0;
    $pp         = 0;
    $pe         = 0;
    $amarillas  = 0;
    $rojas      = 0;
    $puntobonus = 0;
    $soloUno    = 0;
    
    //die(var_dump($sorted));
    foreach ($sorted as $tblFinal) {
        if ($cambio != $tblFinal['idequipo']) {
            
            if (($soloUno != 0) && ($primero == 1)) {
                $lstPosicionesFinal[] = array('equipo'=> $equipo,
                                  'puntos'=> $puntos,
                                  'goles'=> $goles,
                                  'golescontra'=> $golescontra,
                                  'pj'=> $pj,
                                  'pg'=> $pg,
                                  'pp'=> $pp,
                                  'pe'=> $pe,
                                  'amarillas'=> $amarillas,
                                  'rojas'=> $rojas,
                                  'puntobonus'=> $puntobonus,
                                  'idequipo'=> $tblFinal['idequipo']);
                
                $primero = 0;
            }
            $cambio = $tblFinal['idequipo'];
            
            $equipo     = '';
            $puntos     = 0;
            $goles      = 0;
            $pj         = 0;
            $pg         = 0;
            $pp         = 0;
            $pe         = 0;
            $amarillas  = 0;
            $rojas      = 0;
            $puntobonus = 0;
            $golescontra= 0;

        }
        
        $equipo     = $tblFinal['equipo'];
        $puntos     += (integer)$tblFinal['puntos'];
        $goles      += (integer)$tblFinal['goles'];
        $golescontra+= (integer)$tblFinal['golescontra'];
        $pj         += (integer)$tblFinal['pj'];
        $pg         += (integer)$tblFinal['pg'];
        $pp         += (integer)$tblFinal['pp'];
        $pe         += (integer)$tblFinal['pe'];
        $amarillas  += (integer)$tblFinal['amarillas'];
        $rojas      += (integer)$tblFinal['rojas'];
        $puntobonus += (integer)$tblFinal['puntobonus'];
        
        if ($primero != 0) {
            $lstPosicionesFinal[] = array('equipo'=> $equipo,
                              'puntos'=> $puntos,
                              'goles'=> $goles,
                              'golescontra'=> $golescontra,
                              'pj'=> $pj,
                              'pg'=> $pg,
                              'pp'=> $pp,
                              'pe'=> $pe,
                              'amarillas'=> $amarillas,
                              'rojas'=> $rojas,
                              'puntobonus'=> $puntobonus,
                              'idequipo'=> $tblFinal['idequipo']);
            
            $primero = 0;
        } else {
            $soloUno = 1;
            $primero += 1;  
        }
        
         
    }
    
    
    $sorted = array_orderby($lstPosicionesFinal, 'puntos', SORT_DESC, 'rojas', SORT_ASC, 'amarillas', SORT_ASC, 'goles',SORT_DESC, 'golescontra', SORT_ASC);
    
    die(var_dump($sorted));

    return $sorted;

    }


	function query($sql,$accion) {
        
  
        $hostname   = 'localhost';
        $database   = 'ssaif_desarrollo_2018';
        $username   = 'root';
        $password   = '';
        
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


    $res = PosicionesConformada(7,1,1);


?>

<!DOCTYPE html>

<html lang="es">

<head>
<title>Titulo de la web</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="estilos.css" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="alternate" title="Pozolería RSS" type="application/rss+xml" href="/feed.rss" />
</head>

<body>
    <header>
       <h1>Tabla de Equipos Conformada</h1>
       
    </header>
    <section>
       <article>
           <h2>Equipos<h2>
           
       </article>
       <table>
       		<thead>
       			<tr>
       				<th>Id</th>
	       			<th>Equipos</th>
					<th>Pts.</th>
					<th>PJ</th>
					<th>PG</th>
					<th>PE</th>
					<th>PP</th>
					<th>GF</th>
					<th>GC</th>
					<th>Amn.</th>
					<th>Exp.</th>
				</tr>
       		</thead>
       		<tbody>
       			<?php
       			$cantidadEquipo = 0;
       			foreach ($res as $row) {
       				$cantidadEquipo += 1;
       			?>
       			<tr>
       				<td><?php echo $row['idequipo']; ?></td>
	       			<td><?php echo $row['equipo']; ?></td>
					<td><?php echo $row['puntos']; ?></td>
					<td><?php echo $row['pj']; ?></td>
					<td><?php echo $row['pg']; ?></td>
					<td><?php echo $row['pe']; ?></td>
					<td><?php echo $row['pp']; ?></td>
					<td><?php echo $row['goles']; ?></td>
					<td><?php echo $row['golescontra']; ?></td>
					<td><?php echo $row['amarillas']; ?></td>
					<td><?php echo $row['rojas']; ?></td>
				</tr>
       			<?php
       			}
       			?>
       		</tbody>
       </table>
    </section>

</body>
</html>