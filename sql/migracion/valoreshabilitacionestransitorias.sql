INSERT INTO `ssaif_prod_abril`.`tbvaloreshabilitacionestransitorias`
(`idvalorhabilitaciontransitoria`,
`refdocumentaciones`,
`descripcion`,
`habilita`,
`predeterminado`,
valorviejo)
SELECT '', 
	`documentacionjugadoresvalores`.`docjugadoresid`,
    `documentacionjugadoresvalores`.`descripcion`,
    `documentacionjugadoresvalores`.`habilita`,
    `documentacionjugadoresvalores`.`esdefault`,
    valorid
FROM `ssaif_back_abril`.`documentacionjugadoresvalores`;



