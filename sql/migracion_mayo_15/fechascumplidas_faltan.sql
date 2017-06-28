INSERT INTO `ssaif_desa_host_06`.`dbsancionesfechascumplidas`
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
FROM `ssaif_back_abril`.`partidoscumplimientosanciones` sc
inner
join	ssaif_back_abril.sancionesfallos sf
on 		sf.sancionfalloid = sc.sancionfalloid
inner
join	ssaif_back_abril.sancionesjugadores sj
on		sj.sancionjugadorid = sf.sancionjugadorid

group by sc.`partidoidcumplimiento`,
    sc.`sancionfalloid`,
sj.jugadorid,
	sf.sancionfalloid
