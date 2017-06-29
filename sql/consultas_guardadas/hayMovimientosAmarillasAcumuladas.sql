SELECT 
    COALESCE(sf.cantidadfechas - sf.fechascumplidas,
            0) AS faltan
FROM
    dbsancionesjugadores san
        INNER JOIN
    dbsancionesfallosacumuladas sf ON sf.refsancionesjugadores = san.idsancionjugador
        INNER JOIN
    dbjugadores ju ON ju.idjugador = san.refjugadores
        INNER JOIN
    tbtiposanciones tip ON tip.idtiposancion = san.reftiposanciones
        INNER JOIN
    dbfixture fix ON fix.idfixture = 8821
        AND fix.fecha > san.fecha
        INNER JOIN
    dbtorneos tor ON tor.idtorneo = fix.reftorneos
        AND san.refcategorias = tor.refcategorias
        INNER JOIN
    dbfixture fixv ON fixv.idfixture = san.reffixture
        INNER JOIN
    dbtorneos torv ON torv.idtorneo = fixv.reftorneos
        AND torv.reftipotorneo = 1
WHERE
    ju.idjugador = 3965
        AND tor.refcategorias = 5
        AND sf.generadaporacumulacion = 1
        AND sf.fechascumplidas = 0
        AND (CASE
        WHEN torv.idtorneo <> tor.idtorneo THEN fix.reffechas >= 1
        ELSE fix.reffechas > fixv.reffechas
    END)
