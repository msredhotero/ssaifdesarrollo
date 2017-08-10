INSERT INTO `ssaif_local_agosto`.`dbcountriecontactos`
(`idcountriecontacto`,
`refcountries`,
`refcontactos`)
SELECT '',
	`dbcontactos`.`clubid`,
	`dbcontactos`.`idcontacto`
FROM `ssaif_local_agosto`.`dbcontactos`;

