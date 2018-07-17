SELECT 
    r.reffixture, ca.categoria, di.division, count(r.refjugadores), fixx.fecha
FROM
    (SELECT 
        d.numero,
            CONCAT(j.apellido, ' ', j.nombres) AS apyn,
            fix.refconectorlocal AS equipo,
            1 AS orden,
            d.refjugadores,
            d.reffixture
    FROM
        dbdorsales d
    INNER JOIN dbjugadores j ON j.idjugador = d.refjugadores
    INNER JOIN dbfixture fix ON fix.idfixture = d.reffixture
        AND fix.refconectorlocal = d.refequipos
	inner join dbtorneos t on t.idtorneo = fix.reftorneos
    inner join dbminutosjugados mj on mj.reffixture = d.reffixture and mj.refjugadores = d.refjugadores and mj.minutos >0
    WHERE
        t.reftemporadas = 7 and d.numero > 0) r
left join (SELECT 
            de.numero AS numeroentra, fix.idfixture
        FROM
            dbcambios c
                INNER JOIN
            dbfixture fix ON fix.idfixture = c.reffixture
                AND fix.refconectorlocal = c.refequipos
                INNER JOIN
            dbdorsales ds ON c.refdorsalsale = ds.numero
                AND ds.reffixture = fix.idfixture
                AND fix.refconectorlocal = ds.refequipos
                INNER JOIN
            dbjugadores js ON js.idjugador = ds.refjugadores
                INNER JOIN
            dbdorsales de ON c.refdorsalentra = de.numero
                AND de.reffixture = fix.idfixture
                AND fix.refconectorlocal = de.refequipos
                INNER JOIN
            dbjugadores je ON je.idjugador = de.refjugadores
				inner join dbtorneos t on t.idtorneo = fix.reftorneos
                inner join dbminutosjugados mj on mj.reffixture = c.reffixture and mj.refjugadores = ds.refjugadores and mj.minutos >0
        WHERE
            t.reftemporadas = 7 and mj.minutos >0
        ) t on t.idfixture = r.reffixture and t.numeroentra = r.numero
inner join dbfixture fixx on fixx.idfixture = r.reffixture
inner join dbtorneos tor on tor.idtorneo = fixx.reftorneos
inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
where t.numeroentra is null
group by r.reffixture, ca.categoria, di.division, fixx.fecha
order by fixx.fecha

