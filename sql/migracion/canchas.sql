INSERT INTO `ssaif_prod_abril`.`tbcanchas`
(`idcancha`,
`refcountries`,
`nombre`)
SELECT c.`canchaid`,
    coalesce(min(cc.`clubid`),0),
    c.`descripcion`
FROM `ssaif_back_abril`.`canchas` c
left
join ssaif_back_abril.relclubescanchas cc
on c.canchaid = cc.canchaid
group by c.`canchaid`,c.`descripcion`


