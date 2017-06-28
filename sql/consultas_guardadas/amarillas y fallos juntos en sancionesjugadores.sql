SELECT
*
from (
SELECT s.`idsancionjugador`,s.`reftiposanciones`,s.`refjugadores`,s.`reffixture`,ee.nombre
FROM `dbsancionesjugadores` s
inner join dbfixture fix on fix.idfixture = s.reffixture 
inner join dbtorneos tt on tt.idtorneo = fix.reftorneos
inner join dbequipos ee on ee.idequipo = s.refequipos
WHERE `reftiposanciones` in (1) and cantidad in (2) and tt.idtorneo = 156) t
INNER
join (SELECT s.`idsancionjugador`,s.`reftiposanciones`,s.`refjugadores`,s.`reffixture` ,ee.nombre
FROM `dbsancionesjugadores` s
inner join dbfixture fix on fix.idfixture = s.reffixture 
inner join dbtorneos tt on tt.idtorneo = fix.reftorneos
inner join dbequipos ee on ee.idequipo = s.refequipos
WHERE `reftiposanciones` in (2,3,4,5) and cantidad in (1) and tt.idtorneo = 156) r 
on t.reffixture = r.reffixture and t.refjugadores = r.refjugadores
order by t.nombre