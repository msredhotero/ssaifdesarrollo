INSERT INTO `ssaif_prod`.`dbconector`
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
FROM `ssaif_bck_abril`.`reljugadoresequipos` je
inner
join	ssaif_bck_abril.equipos e
on		je.equipoid = e.equipoid
inner
join	ssaif_bck_abril.jugadores j
on		j.jugadorid = je.jugadorid

