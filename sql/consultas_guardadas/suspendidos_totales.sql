select
j.*,sf.*,sj.*
from		dbsancionesfallos sf
inner
join		dbsancionesjugadores sj
on			sf.refsancionesjugadores = sj.idsancionjugador
inner
join		dbfixture fix
on			fix.idfixture = sj.reffixture
inner
join		dbjugadores j
on			j.idjugador = sj.refjugadores
where		sf.cantidadfechas <> sf.fechascumplidas or (sf.fechahasta >= now() and sf.fechadesde <> '1900-01-01')
order by j.apellido, j.nombres