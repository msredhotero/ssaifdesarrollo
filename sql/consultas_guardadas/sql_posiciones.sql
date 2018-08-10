SELECT 
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
    (CASE
        WHEN ep.asterisco = 1 THEN '1'
        ELSE '0'
    END) AS asterisco,
    ep.descripcion AS observacion,
    @rownum:=@rownum + 1 'posicion'
FROM
    (SELECT 
        p.equipo,
            SUM(p.puntos) AS puntos,
            SUM(p.goles) AS goles,
            SUM(p.golescontra) AS golescontra,
            SUM(p.pj) AS pj,
            SUM(p.pg) AS pg,
            SUM(p.pp) AS pp,
            SUM(p.pe) AS pe,
            SUM(p.amarillas) AS amarillas,
            SUM(p.rojas) AS rojas,
            p.idequipo,
            p.observacionestorneo,
            MAX(p.idfixture) AS idfixture
    FROM
        (SELECT 
        el.nombre AS equipo,
            f.puntoslocal AS puntos,
            ca.categoria,
            arb.nombrecompleto AS arbitro,
            f.goleslocal AS goles,
            f.golesvisitantes AS golescontra,
            can.nombre AS canchas,
            fec.fecha,
            DATE_FORMAT(f.fecha, '%d/%m/%Y') AS fechajuego,
            f.hora,
            f.calificacioncancha,
            f.juez1,
            f.juez2,
            f.observaciones,
            f.publicar,
            COUNT(el.idequipo) AS pj,
            SUM(CASE
                WHEN f.puntoslocal = 3 THEN 1
                ELSE 0
            END) AS pg,
            SUM(CASE
                WHEN f.puntoslocal = 0 THEN 1
                ELSE 0
            END) AS pp,
            SUM(CASE
                WHEN f.puntoslocal = 1 THEN 1
                ELSE 0
            END) AS pe,
            SUM(COALESCE(fixa.amarillas, 0)) AS amarillas,
            SUM(COALESCE(fixr.rojas, 0)) AS rojas,
            el.idequipo,
            tor.observaciones AS observacionestorneo,
            f.idfixture
    FROM
        dbfixture f
    INNER JOIN dbtorneos tor ON tor.idtorneo = f.reftorneos
    INNER JOIN tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
    INNER JOIN tbtemporadas te ON te.idtemporadas = tor.reftemporadas
    INNER JOIN tbcategorias ca ON ca.idtcategoria = tor.refcategorias
    INNER JOIN tbdivisiones di ON di.iddivision = tor.refdivisiones
    INNER JOIN tbfechas fec ON fec.idfecha = f.reffechas
    INNER JOIN dbequipos el ON el.idequipo = f.refconectorlocal
    LEFT JOIN dbarbitros arb ON arb.idarbitro = f.refarbitros
    LEFT JOIN tbcanchas can ON can.idcancha = f.refcanchas
    INNER JOIN tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
        AND est.finalizado = 1
    LEFT JOIN (SELECT 
        SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
    FROM
        dbsancionesjugadores sj
    INNER JOIN dbfixture fix ON sj.reffixture = fix.idfixture
        AND fix.refconectorlocal = sj.refequipos
    INNER JOIN tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
    WHERE
        ts.amonestacion = 1
            AND (sj.refsancionesfallos IS NULL
            OR sj.refsancionesfallos = 0)
            AND sj.cantidad <> 2
    GROUP BY fix.idfixture , sj.refequipos) fixa ON fixa.idfixture = f.idfixture
        AND fixa.refequipos = el.idequipo
    LEFT JOIN (SELECT 
        SUM(sj.cantidad) AS rojas, fix.idfixture, sj.refequipos
    FROM
        dbsancionesjugadores sj
    INNER JOIN dbfixture fix ON sj.reffixture = fix.idfixture
        AND fix.refconectorlocal = sj.refequipos
    INNER JOIN tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
    WHERE
        ts.expulsion = 1
    GROUP BY fix.idfixture , sj.refequipos) fixr ON fixr.idfixture = f.idfixture
        AND fixr.refequipos = el.idequipo
    WHERE
        tor.idtorneo = 215
    GROUP BY el.nombre , f.puntoslocal , ca.categoria , arb.nombrecompleto , f.goleslocal , f.golesvisitantes , can.nombre , fec.fecha , f.fecha , f.hora , f.calificacioncancha , f.juez1 , f.juez2 , f.observaciones , f.publicar , el.idequipo , tor.observaciones , f.idfixture UNION ALL SELECT 
        ev.nombre AS equipo,
            f.puntosvisita AS puntos,
            ca.categoria,
            arb.nombrecompleto AS arbitro,
            f.golesvisitantes AS goles,
            f.goleslocal AS golescontra,
            can.nombre AS canchas,
            fec.fecha,
            DATE_FORMAT(f.fecha, '%d/%m/%Y') AS fechajuego,
            f.hora,
            f.calificacioncancha,
            f.juez1,
            f.juez2,
            f.observaciones,
            f.publicar,
            COUNT(ev.idequipo) AS pj,
            SUM(CASE
                WHEN f.puntosvisita = 3 THEN 1
                ELSE 0
            END) AS pg,
            SUM(CASE
                WHEN f.puntosvisita = 0 THEN 1
                ELSE 0
            END) AS pp,
            SUM(CASE
                WHEN f.puntosvisita = 1 THEN 1
                ELSE 0
            END) AS pe,
            SUM(COALESCE(fixa.amarillas, 0)) AS amarillas,
            SUM(COALESCE(fixr.rojas, 0)) AS rojas,
            ev.idequipo,
            tor.observaciones AS observacionestorneo,
            f.idfixture
    FROM
        dbfixture f
    INNER JOIN dbtorneos tor ON tor.idtorneo = f.reftorneos
    INNER JOIN tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
    INNER JOIN tbtemporadas te ON te.idtemporadas = tor.reftemporadas
    INNER JOIN tbcategorias ca ON ca.idtcategoria = tor.refcategorias
    INNER JOIN tbdivisiones di ON di.iddivision = tor.refdivisiones
    INNER JOIN tbfechas fec ON fec.idfecha = f.reffechas
    INNER JOIN dbequipos ev ON ev.idequipo = f.refconectorvisitante
    LEFT JOIN dbarbitros arb ON arb.idarbitro = f.refarbitros
    LEFT JOIN tbcanchas can ON can.idcancha = f.refcanchas
    INNER JOIN tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
        AND est.finalizado = 1
    LEFT JOIN (SELECT 
        SUM(sj.cantidad) AS amarillas, fix.idfixture, sj.refequipos
    FROM
        dbsancionesjugadores sj
    INNER JOIN dbfixture fix ON sj.reffixture = fix.idfixture
        AND fix.refconectorvisitante = sj.refequipos
    INNER JOIN tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
    WHERE
        ts.amonestacion = 1
            AND (sj.refsancionesfallos IS NULL
            OR sj.refsancionesfallos = 0)
            AND sj.cantidad <> 2
    GROUP BY fix.idfixture , sj.refequipos) fixa ON fixa.idfixture = f.idfixture
        AND fixa.refequipos = ev.idequipo
    LEFT JOIN (SELECT 
        SUM(sj.cantidad) AS rojas, fix.idfixture, sj.refequipos
    FROM
        dbsancionesjugadores sj
    INNER JOIN dbfixture fix ON sj.reffixture = fix.idfixture
        AND fix.refconectorvisitante = sj.refequipos
    INNER JOIN tbtiposanciones ts ON ts.idtiposancion = sj.reftiposanciones
    WHERE
        ts.expulsion = 1
    GROUP BY fix.idfixture , sj.refequipos) fixr ON fixr.idfixture = f.idfixture
        AND fixr.refequipos = ev.idequipo
    WHERE
        tor.idtorneo = 215
    GROUP BY ev.nombre , f.puntosvisita , ca.categoria , arb.nombrecompleto , f.golesvisitantes , f.goleslocal , can.nombre , fec.fecha , f.fecha , f.hora , f.calificacioncancha , f.juez1 , f.juez2 , f.observaciones , f.publicar , ev.idequipo , tor.observaciones , f.idfixture UNION ALL SELECT 
        ev.nombre AS equipo,
            0 AS puntos,
            ca.categoria,
            '' AS arbitro,
            0 AS goles,
            0 AS golescontra,
            '' AS canchas,
            '' AS fecha,
            '' AS fechajuego,
            '' AS hora,
            '' AS calificacioncancha,
            '' AS juez1,
            '' AS juez2,
            '' AS observaciones,
            '' AS publicar,
            0 AS pj,
            0 AS pg,
            0 AS pp,
            0 AS pe,
            0 AS amarillas,
            0 AS rojas,
            ev.idequipo,
            ev.observacionestorneo,
            0 AS idfixture
    FROM
        (SELECT 
        e.idequipo,
            e.nombre,
            t.refcategorias,
            t.observaciones AS observacionestorneo
    FROM
        dbequipos e
    INNER JOIN dbtorneos t ON e.refcategorias = t.refcategorias
        AND e.refdivisiones = t.refdivisiones
    INNER JOIN tbcategorias ca ON ca.idtcategoria = t.refcategorias
    INNER JOIN (SELECT 
        ff.refconectorlocal
    FROM
        dbfixture ff
    WHERE
        ff.reftorneos = 215
    GROUP BY ff.refconectorlocal) fl ON fl.refconectorlocal = e.idequipo
    WHERE
        t.idtorneo = 215
            AND e.activo = 1
            AND t.activo = 1) ev
    INNER JOIN tbcategorias ca ON ca.idtcategoria = ev.refcategorias
    LEFT JOIN dbfixture f ON (ev.idequipo = f.refconectorlocal
        OR ev.idequipo = f.refconectorvisitante)
        AND f.reftorneos = 215
        AND f.refestadospartidos IS NOT NULL
        AND f.reffechas = 1
    WHERE
        f.idfixture IS NULL) p
    GROUP BY p.equipo , p.idequipo , p.observacionestorneo
    ORDER BY SUM(p.puntos) DESC , SUM(p.rojas) ASC , SUM(p.amarillas) ASC) k
        INNER JOIN
    dbfixture fix ON fix.idfixture = k.idfixture
        INNER JOIN
    tbestadospartidos ep ON ep.idestadopartido = fix.refestadospartidos,
    (SELECT @rownum:=0) R