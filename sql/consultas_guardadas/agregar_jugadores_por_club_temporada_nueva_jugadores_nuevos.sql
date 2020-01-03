INSERT INTO `dbjugadoresclub`
(`idjugadorclub`,
`refjugadores`,
`fechabaja`,
`articulo`,
`numeroserielote`,
`temporada`,
`refcountries`)
SELECT 
    '',
    j.idjugador,
    0,
    0,
    '',
    2020,
    j.refcountries
FROM
    dbjugadores j
        LEFT JOIN
    dbjugadoresclub jc ON j.idjugador = jc.refjugadores
        AND jc.temporada = 2020
        left join
	dbjugadorespre jp on jp.nrodocumento = j.nrodocumento
WHERE
    jc.idjugadorclub IS NULL and j.refcountries not in (1,84)
        AND (j.fechabaja IS NULL
        OR j.fechabaja = '1900-01-01'
        OR j.fechabaja = '0000-00-00'
        OR j.fechabaja >= NOW())
	and jp.idjugadorpre is null
