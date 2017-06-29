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
    CONCAT('(', e.idequipo, ') ', e.nombre) AS equipos,
    sj.fecha,
    sf.cantidadfechas,
    0 cumplidas,
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
WHERE
    sf.cantidadfechas <> sf.fechascumplidas
        OR (sf.fechahasta >= NOW()
        AND sf.fechadesde <> '1900-01-01')
ORDER BY j.apellido , j.nombres