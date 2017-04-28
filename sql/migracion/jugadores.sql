INSERT INTO `ssaif_prod_abril`.`dbjugadores`
(`idjugador`,
`reftipodocumentos`,
`nrodocumento`,
`apellido`,
`nombres`,
`email`,
`fechanacimiento`,
`fechaalta`,
`fechabaja`,
`refcountries`,
`observaciones`)
SELECT `jugadores`.`jugadorid`,
    `jugadores`.`tipodocumento`,
    `jugadores`.`documento`,
    `jugadores`.`apellido`,
    `jugadores`.`nombres`,
    `jugadores`.`email`,
    `jugadores`.`fechanac`,
    `jugadores`.`fechaalta`,
    `jugadores`.`fechabaja`,
    `jugadores`.`clubid`,
    `jugadores`.`observaciones`
FROM `ssaif_back_abril`.`jugadores`;










