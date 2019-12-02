update `dbfixture` f 
inner join dbtorneos t on f.reftorneos = t.idtorneo
set f.hora = '14:15:00'
where t.reftemporadas = 8 and t.refcategorias in (1) and f.fecha >= now()