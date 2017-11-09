select
*
from			dbsancionesjugadores sj
inner
join			dbsancionesfallos sf
on				sj.idsancionjugador = sf.refsancionesjugadores
inner
join			dbsancionesfechascumplidas sfc
on				sfc.refsancionesfallos = sf.idsancionfallo
inner
join			dbfixture fix
on				fix.idfixture = sj.reffixture
inner
join			dbtorneos t
on				t.idtorneo = fix.reftorneos
where			t.reftemporadas=6 and sf.generadaporacumulacion=1