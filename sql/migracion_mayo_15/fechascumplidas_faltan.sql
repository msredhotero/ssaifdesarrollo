INSERT INTO `ssaif_mayo_15`.`dbsancionesfechascumplidas`
(`idsancionfechacumplida`,
`reffixture`,
`refjugadores`,
`cumplida`,
`refsancionesfallos`,
`refsancionesfallosacumuladas`)

SELECT 
	'',
	sc.`partidoidcumplimiento`,
	sj.jugadorid,
	1,
	sc.`sancionfalloid`,
	0
FROM `aif_mayo_15`.`partidoscumplimientosanciones` sc
inner
join	aif_mayo_15.sancionesfallos sf
on 		sf.sancionfalloid = sc.sancionfalloid
inner
join	aif_mayo_15.sancionesjugadores sj
on		sj.sancionjugadorid = sf.sancionjugadorid

group by sc.`partidoidcumplimiento`,
    sc.`sancionfalloid`,
sj.jugadorid,
	sf.sancionfalloid
