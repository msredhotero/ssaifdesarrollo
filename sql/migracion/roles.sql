INSERT INTO `ssaif_prod_abril`.`tbroles`
(`idrol`,
`descripcion`,
`activo`)
SELECT `tbroles`.`idrol`,
    `tbroles`.`descripcion`,
    `tbroles`.`activo`
FROM `ssaif_desa_host`.`tbroles`;




