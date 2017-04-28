INSERT INTO `ssaif_prod_abril`.`dbdefinicionessancionesacumuladastemporadas`
(`iddefinicionessancionesacumuladastemporadas`,
`reftiposanciones`,
`reftemporadas`,
`cantidadacumulada`,
`cantidadfechasacumplir`)
SELECT '', 
	`definicionessancionesacumuladastemporadas`.`tiposancionid`,
    `definicionessancionesacumuladastemporadas`.`temporadaid`,
    `definicionessancionesacumuladastemporadas`.`cantacumulada`,
    `definicionessancionesacumuladastemporadas`.`cantfechasacumplir`
FROM `ssaif_back_abril`.`definicionessancionesacumuladastemporadas`;




