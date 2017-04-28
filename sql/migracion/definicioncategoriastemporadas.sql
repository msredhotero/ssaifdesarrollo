INSERT INTO `ssaif_prod_abril`.`dbdefinicionescategoriastemporadas`
(`iddefinicioncategoriatemporada`,
`refcategorias`,
`reftemporadas`,
`cantmaxjugadores`,
`cantminjugadores`,
`refdias`,
`hora`,
`minutospartido`,
`cantidadcambiosporpartido`,
`conreingreso`,
`observaciones`)
SELECT '',
	`definicionescategoriastemporadas`.`categoriaid`,
    `definicionescategoriastemporadas`.`temporadaid`,
    `definicionescategoriastemporadas`.`cantmaxjugadores`,
    `definicionescategoriastemporadas`.`cantminjugadores`,
    1,
    `definicionescategoriastemporadas`.`hora`,
    `definicionescategoriastemporadas`.`minutospartido`,
    `definicionescategoriastemporadas`.`cantcambiosporpartido`,
    `definicionescategoriastemporadas`.`conreingreso`,
    `definicionescategoriastemporadas`.`observaciones`
FROM `ssaif_back_abril`.`definicionescategoriastemporadas`;





