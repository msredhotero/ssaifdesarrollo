
function PosicionesConformadaNueva2018($idtemporada, $idcategoria, $iddivision) {
    $sql = "    select
m.equipo,
sum(m.puntos) as puntos,
sum(m.goles) as goles,
sum(m.golescontra) as golescontra,
sum(m.pj) as pj,
sum(m.pg) as pg,
sum(m.pp) as pp,
sum(m.pe) as pe,
sum(m.amarillas) as amarillas,
sum(m.rojas) as rojas,
m.idequipo,
max(m.observacionestorneo) as observacionestorneo
    from (
    select
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
    (case when ep.asterisco= 1 then '1' else '0' end) as asterisco,
    ep.descripcion as observacion
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

where tor.reftemporadas = ".$idtemporada." and tor.refcategorias = ".$idcategoria." and tor.refdivisiones = ".$iddivision."  
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

where tor.reftemporadas = ".$idtemporada." and tor.refcategorias = ".$idcategoria." and tor.refdivisiones = ".$iddivision." 
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
0 as idfixture
from (select 
        e.idequipo,
        e.nombre,
        t.refcategorias,
        t.observaciones as observacionestorneo
        from dbequipos e 
        inner join dbtorneos t on e.refcategorias = t.refcategorias and e.refdivisiones = t.refdivisiones
        inner join tbcategorias ca on ca.idtcategoria = t.refcategorias
        inner join (select ff.refconectorlocal 
                    from dbfixture ff 
                    inner join dbtorneos tt on tt.idtorneo = ff.reftorneos
                    where tt.reftemporadas = ".$idtemporada." and tt.refcategorias = ".$idcategoria." and tt.refdivisiones = ".$iddivision."   group by ff.refconectorlocal) fl
        on fl.refconectorlocal = e.idequipo
        where t.reftemporadas = ".$idtemporada." and t.refcategorias = ".$idcategoria." and t.refdivisiones = ".$iddivision."   and e.activo=1 and t.activo = 1) ev
inner join tbcategorias ca ON ca.idtcategoria = ev.refcategorias
left join dbfixture f ON (ev.idequipo = f.refconectorlocal or ev.idequipo = f.refconectorvisitante) 
/*and f.reftorneos = ".$refTorneo." */
and f.refestadospartidos is not null and f.reffechas= 1
inner join dbtorneos tto on tto.idtorneo = f.reftorneos and tto.reftemporadas = ".$idtemporada." and tto.refcategorias = ".$idcategoria." and tto.refdivisiones = ".$iddivision." 
where f.idfixture is null
) p
group by p.equipo, p.idequipo, p.observacionestorneo
order by sum(p.puntos) desc, sum(p.rojas) asc, sum(p.amarillas) asc

) k 
inner join dbfixture fix on fix.idfixture = k.idfixture
inner join tbestadospartidos ep on ep.idestadopartido = fix.refestadospartidos) m
group by m.idequipo, m.equipo 
order by sum(m.puntos) desc, sum(m.rojas) asc, sum(m.amarillas) asc
";

$res = $this->query($sql,0);
    
    $arPosiciones = array();
    $arPosicionesAux = array();
    
    $puntosBonus = 0;
    $puntoBonusFijo = 0;
    
    $resPuntosBonus =   $this->traerTorneopuntobonusPorTorneo($refTorneo);
    
    $posicion = 1;
    while ($row = mysql_fetch_array($res)) {
        $puntosBonus = 0;
        $puntoBonusFijo = 0;
        
        if (mysql_num_rows($resPuntosBonus)>0) {
            $puntoBonusFijo = $this->devolverPuntoBonusFijo($refTorneo, $row['idequipo']);
            $puntosBonus = $this->calcularPuntoBonus($refTorneo, $row['idequipo']); 
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
                              'asterisco'=>$row['asterisco'],
                              'observaciones'=>$row['observacion']);
        $posicion += 1;                   
        $puntosBonus = 0;                     
    }

    $sorted = $this->array_orderby($arPosiciones, 'puntos', SORT_DESC, 'rojas', SORT_ASC, 'amarillas', SORT_ASC, 'goles', SORT_DESC, 'golescontra', SORT_ASC);
    
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
                              'asterisco'=>$row['asterisco'],
                              'observaciones'=>$row['observaciones']);
        $posicion += 1;                   
                  
    }
    
    return $arPosicionesAux;
}