INSERT INTO `ssaif_prod_abril`.`tbtipodocumentos`
(`idtipodocumento`,
`tipodocumento`)
SELECT `tbtipodocumentos`.`idtipodocumento`,
    `tbtipodocumentos`.`tipodocumento`
FROM `ssaif_desa_host`.`tbtipodocumentos`;




















