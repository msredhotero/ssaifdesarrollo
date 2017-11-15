SELECT
count(*)
from	dbsancionesjugadores sj
inner
join	dbsancionesfallos sf
on		sj.idsancionjugador = sf.refsancionesjugadores
where	sj.reftiposanciones <> 1 and sj.refsancionesfallos = 0

UPDATE dbsancionesjugadores sj
JOIN dbsancionesfallos sf ON sj.idsancionjugador = sf.refsancionesjugadores
SET sj.refsancionesfallos = sf.idsancionfallo
where	sj.reftiposanciones <> 1 and sj.refsancionesfallos = 0;