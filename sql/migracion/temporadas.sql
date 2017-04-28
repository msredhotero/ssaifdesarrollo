INSERT INTO `ssaif_prod_abril`.`tbtemporadas`
(`idtemporadas`,
`temporada`)
SELECT `temporadas`.`temporadaid`,
    `temporadas`.`descripcion`
FROM `ssaif_back_abril`.`temporadas`;
















