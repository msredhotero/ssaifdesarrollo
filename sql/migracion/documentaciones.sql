INSERT INTO `ssaif_prod_abril`.`tbdocumentaciones`
(`iddocumentacion`,
`descripcion`,
`obligatoria`,
`observaciones`)
SELECT `documentacionjugadores`.`docjugadoresid`,
    `documentacionjugadores`.`descripcion`,
    `documentacionjugadores`.`obligatoria`,
    `documentacionjugadores`.`observaciones`
FROM `ssaif_back_abril`.`documentacionjugadores`;










