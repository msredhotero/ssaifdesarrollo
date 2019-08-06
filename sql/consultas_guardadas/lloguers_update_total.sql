
update	dblloguers l
inner join (select
sum(round((d.preu / 7) * d.dias,2)) as monto, d.`ID LLOGUER` as id
from migracioncasacaliente.detalllloguer d
group by d.`ID LLOGUER`) d on l.idlloguer = d.id

set l.total = d.monto