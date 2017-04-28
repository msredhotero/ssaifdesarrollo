INSERT INTO `ssaif_prod`.`dbtorneopuntobonus`
(`idtorneopuntobonus`,
`reftorneos`,
`refpuntobonus`)
SELECT '',
	`reltorneospuntobonus`.`torneoid`,
	`reltorneospuntobonus`.`puntobonusid`
    
FROM `ssaif_bck_abril`.`reltorneospuntobonus`;

