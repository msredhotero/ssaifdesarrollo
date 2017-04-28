INSERT INTO `ssaif_prod_abril`.`tbcategorias`
(`idtcategoria`,
`categoria`)
SELECT `categorias`.`categoriaid`,
    `categorias`.`descripcion`
FROM `ssaif_back_abril`.`categorias`;




