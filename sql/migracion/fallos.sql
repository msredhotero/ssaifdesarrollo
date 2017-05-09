INSERT INTO `ssaif_prod_abril`.`dbsancionesfallos`
(`idsancionfallo`,
`refsancionesjugadores`,
`cantidadfechas`,
`fechadesde`,
`fechahasta`,
`amarillas`,
`fechascumplidas`,
`pendientescumplimientos`,
`pendientesfallo`,
`generadaporacumulacion`,
`observaciones`)

SELECT `sancionesfallos`.`sancionfalloid`,
    `sancionesfallos`.`sancionjugadorid`,
    `sancionesfallos`.`cantfechas`,
    `sancionesfallos`.`fechadde`,
    `sancionesfallos`.`fechahta`,
    0,
    `sancionesfallos`.`fechascumplidas`,
    `sancionesfallos`.`pendcumplimiento`,
    `sancionesfallos`.`pendfallo`,
    `sancionesfallos`.`generadaporacumulacion`,
    `sancionesfallos`.`observaciones`
FROM `ssaif_bck_09052017`.`sancionesfallos`;

