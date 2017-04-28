INSERT INTO `ssaif_prod`.`predio_menu`
(`idmenu`,
`url`,
`icono`,
`nombre`,
`Orden`,
`hover`,
`permiso`,
`administracion`,
`torneo`,
`reportes`)
SELECT `predio_menu`.`idmenu`,
    `predio_menu`.`url`,
    `predio_menu`.`icono`,
    `predio_menu`.`nombre`,
    `predio_menu`.`Orden`,
    `predio_menu`.`hover`,
    `predio_menu`.`permiso`,
    `predio_menu`.`administracion`,
    `predio_menu`.`torneo`,
    `predio_menu`.`reportes`
FROM `ssaif_desa_host`.`predio_menu`;


