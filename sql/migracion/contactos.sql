INSERT INTO `ssaif_mayo_15`.`dbcontactos`
(`idcontacto`,
`reftipocontactos`,
`nombre`,
`direccion`,
`localidad`,
`cp`,
`telefono`,
`celular`,
`fax`,
`email`,
`observaciones`,
`publico`,
bckidclub,
bckidcontacto)


SELECT '',
    `relclubescontactos`.`tipocontactoid`,
    
    `relclubescontactos`.`nombre`,
    
    `relclubescontactos`.`direccion`,
    `relclubescontactos`.`localidad`,
    `relclubescontactos`.`codpostal`,
    `relclubescontactos`.`telefono`,
    `relclubescontactos`.`celular`,
    `relclubescontactos`.`fax`,
    `relclubescontactos`.`mail`,
    `relclubescontactos`.`observaciones`,
	1,
	`relclubescontactos`.clubid,
	`relclubescontactos`.contactoid
FROM `ssaif_bck_abril`.`relclubescontactos`;

