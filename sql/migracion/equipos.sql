INSERT INTO `ssaif_prod_abril`.`dbequipos`
(`idequipo`,
`refcountries`,
`nombre`,
`refcategorias`,
`refdivisiones`,
`refcontactos`,
`fechaalta`,
`fachebaja`,
`activo`)
SELECT `equipos`.`equipoid`,
    `equipos`.`clubid`,
    `equipos`.`descripcion`,
    `equipos`.`categoriaid`,
    `equipos`.`divisionid`,
    1,
    `equipos`.`fechaalta`,
    `equipos`.`fechabaja`,
    `equipos`.`activo`
FROM `ssaif_back_abril`.`equipos`;








