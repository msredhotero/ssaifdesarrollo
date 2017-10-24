select
sfc.*
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
inner
join	dbsancionesfechascumplidas sfc
on		sfc.refsancionesfallosacumuladas = sf.idsancionfallo
where	generadaporacumulacion=1 and tor.reftemporadas=6 and sf.fechascumplidas = 1
order by fix.fecha desc