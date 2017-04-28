INSERT INTO `ssaif_prod_abril`.`tbdivisiones`
(`iddivision`,
`division`)
SELECT `divisiones`.`divisionid`,
    `divisiones`.`descripcion`
FROM `ssaif_back_abril`.`divisiones`;








