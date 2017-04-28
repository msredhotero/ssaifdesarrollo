INSERT INTO `ssaif_prod_abril`.`tbtipotorneo`
(`idtipotorneo`,
`tipotorneo`)
SELECT `formatostorneo`.`formatotorneoid`,
    `formatostorneo`.`descripcion`
FROM `ssaif_back_abril`.`formatostorneo`;




















