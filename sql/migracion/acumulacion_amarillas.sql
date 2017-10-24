INSERT INTO `ssaif_local_octubre`.`dbsancionesfallosacumuladas`
(`idsancionfalloacumuladas`,
`refsancionesjugadores`,
`cantidadfechas`,
`fechadesde`,
`fechahasta`,
`amarillas`,
`fechascumplidas`,
`pendientescumplimientos`,
`pendientesfallo`,
`generadaporacumulacion`,
`observaciones`)
select
'',
sj.idsancionjugador,
1,
'0000-00-00',
'0000-00-00',
0,
sf.fechascumplidas,
sf.pendientescumplimientos,
0,
1,
'Acumulacion de 5 amarillas'
from	dbsancionesfallos sf

inner
join	dbsancionesjugadores sj
on		sj.idsancionjugador = sf.refsancionesjugadores

inner
join	dbfixture fix
on		fix.idfixture = sj.reffixture
inner
join	dbtorneos tor
on		tor.idtorneo = fix.reftorneos

where	generadaporacumulacion=1 and tor.reftemporadas=6
order by fix.fecha desc