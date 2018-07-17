SELECT 
    fix.idfixture,
    c.refdorsalsale,
    ca.categoria,
    di.division,
    fix.fecha,
    e.nombre
FROM
    dbcambios c
        INNER JOIN
    dbfixture fix ON fix.idfixture = c.reffixture
        AND fix.refconectorlocal = c.refequipos
        LEFT JOIN
    dbdorsales ds ON c.refdorsalsale = ds.numero
        AND ds.reffixture = fix.idfixture
        AND fix.refconectorlocal = ds.refequipos
        LEFT JOIN
    dbjugadores js ON js.idjugador = ds.refjugadores
        INNER JOIN
    dbtorneos t ON t.idtorneo = fix.reftorneos
        INNER JOIN
    tbcategorias ca ON ca.idtcategoria = c.refcategorias
        INNER JOIN
    tbdivisiones di ON di.iddivision = c.refdivisiones
		inner join
	dbequipos e on e.idequipo = c.refequipos
WHERE
    t.reftemporadas = 7
        AND ds.iddorsal IS NULL
order by fix.fecha, ca.categoria, di.division