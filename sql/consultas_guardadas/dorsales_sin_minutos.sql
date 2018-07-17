SELECT 
    fix.idfixture,
    CONCAT(j.apellido, ' ', j.nombres) AS apyn,
    ca.categoria,
    di.division,
    fix.fecha
FROM
    dbdorsales d
        INNER JOIN
    dbfixture fix ON fix.idfixture = d.reffixture
        INNER JOIN
    dbtorneos tor ON tor.idtorneo = fix.reftorneos
        INNER JOIN
    dbminutosjugados mj ON mj.reffixture = fix.idfixture
        AND mj.refjugadores = d.refjugadores
        INNER JOIN
    dbjugadores j ON j.idjugador = d.refjugadores
        INNER JOIN
    tbcategorias ca ON ca.idtcategoria = tor.refcategorias
        INNER JOIN
    tbdivisiones di ON di.iddivision = tor.refdivisiones
    where d.numero > 0 and mj.minutos = 0 and tor.reftemporadas = 7