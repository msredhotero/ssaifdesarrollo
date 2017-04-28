INSERT INTO `ssaif_prod_abril`.`dbarbitros`
(`idarbitro`,
`nombrecompleto`,
`telefonoparticular`,
`telefonoceleluar`,
`telefonolaboral`,
`telefonofamiliar`,
`email`)
SELECT `arbitros`.`arbitroid`,
    concat(`arbitros`.`apellido`,', ',    `arbitros`.`nombres`),
    
    `arbitros`.`telefono`,
    `arbitros`.`celular`,
    '',
    '',
    `arbitros`.`email`
FROM `ssaif_back_abril`.`arbitros`;
