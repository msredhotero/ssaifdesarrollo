INSERT INTO `ssaif_prod_abril`.`dbconector`
(`idconector`,
`refjugadores`,
`reftipojugadores`,
`refequipos`,
`refcountries`,
`refcategorias`,
`esfusion`,
`activo`)
SELECT '',
	je.`jugadorid`,
    je.`tipojugadorid`,
	je.`equipoid`,
    j.clubid,
	e.categoriaid,
	(case when j.clubid <> e.clubid then 1 else 0 end),
	1
FROM `ssaif_bck_09052017`.`reljugadoresequipos` je
inner
join	ssaif_bck_09052017.equipos e
on		je.equipoid = e.equipoid
inner
join	ssaif_bck_09052017.jugadores j
on		j.jugadorid = je.jugadorid;

