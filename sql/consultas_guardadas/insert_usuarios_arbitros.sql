INSERT INTO `ssaif_desarrollo_2018`.`dbusuarios`
(`idusuario`,
`usuario`,
`password`,
`refroles`,
`email`,
`nombrecompleto`,
`refcountries`,
`activo`)
SELECT 
    '',
    REPLACE(a.nombrecompleto, ',', '') as usuario,
    CONCAT(UPPER(LEFT(concat(SUBSTR(REPLACE(CONCAT(SUBSTRING_INDEX(REPLACE(a.nombrecompleto, ',', ''),
                    ' ',
                    1),
	SUBSTR( REPLACE(a.nombrecompleto, ',', ''), LENGTH( SUBSTRING_INDEX(REPLACE(a.nombrecompleto, ',', ''), " ", 1) ) + 1 )
            ), ' ', ''),1,10),'1+'), 1)), LOWER(SUBSTRING(concat(SUBSTR(REPLACE(CONCAT(SUBSTRING_INDEX(REPLACE(a.nombrecompleto, ',', ''),
                    ' ',
                    1),
	SUBSTR( REPLACE(a.nombrecompleto, ',', ''), LENGTH( SUBSTRING_INDEX(REPLACE(a.nombrecompleto, ',', ''), " ", 1) ) + 1 )
            ), ' ', ''),1,10),'1+'), 2))) as pass,
    3,
    a.email,
    REPLACE(a.nombrecompleto, ',', ''),
    a.nrodocumento,
    0
FROM
    dbarbitros a
where a.nrodocumento is not null
