INSERT INTO `ssaif_prod_abril`.`tbtipojugadores`
(`idtipojugador`,
`tipojugador`,
`abreviatura`)
SELECT `tipojugadores`.`tipojugadorid`,
    `tipojugadores`.`descripcion`,
    `tipojugadores`.`abreviatura`
FROM `ssaif_back_abril`.`tipojugadores`;






















