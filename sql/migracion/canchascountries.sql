INSERT INTO `ssaif_prod_abril`.`dbcountriecanchas`
(`idcountriecancha`,
`refcountries`,
`refcanchas`)

SELECT '',
cc.`clubid`,
c.`canchaid`
FROM `ssaif_back_abril`.`canchas` c
inner
join ssaif_back_abril.relclubescanchas cc
on c.canchaid = cc.canchaid



