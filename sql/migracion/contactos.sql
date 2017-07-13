INSERT INTO `ssaif_local_julio`.`dbcontactos`
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
`publico`)


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
    1
FROM `aif_bck_up_mayo_15`.`relclubescontactos`;

