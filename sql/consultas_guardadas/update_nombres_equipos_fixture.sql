SELECT 
    *
    
update
    dbfixture f
        LEFT JOIN
    dbequipos el ON f.refconectorlocal = el.idequipo
        LEFT JOIN
    dbequipos ev ON f.refconectorvisitante = ev.idequipo
        INNER JOIN
    dbtorneos t ON t.idtorneo = f.reftorneos
set f.nombreequipolocal = el.nombre, f.nombreequipovisitante = ev.nombre
WHERE
    t.reftemporadas = 8
        AND (f.nombreequipolocal IS NULL
        OR f.nombreequipovisitante IS NULL)