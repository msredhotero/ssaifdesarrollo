select
	jd.refjugadores, jd.refdocumentaciones, count(jd.idjugadordocumentacion)
from dbjugadoresdocumentacion jd
group by jd.refjugadores, jd.refdocumentaciones
having count(jd.refdocumentaciones) > 1
