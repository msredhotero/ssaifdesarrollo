/*
SELECT
s.id_carnet,j.*
FROM		dbo.Jugadores j
inner
join		dbo.Socios s
on			s.id_jugador = j.id_jugador
where		j.numero_de_documento = '24717875'
*/
select
distinct te.nombre, j.apellidos, j.nombres
--p.fecha_parido,te.nombre, sp.*
from		dbo.Partidos p
inner
join		dbo.Torneos t
on			p.id_torneo = t.id_torneo
inner
join		dbo.Temporadas te
on			te.id_temporada = p.id_temporada
inner
join		dbo.Socios_por_Partidos sp
on			sp.id_temporada = te.id_temporada and sp.id_torneo = t.id_torneo
inner
join		dbo.Socios ss
on			ss.id_carnet = sp.id_carnet
inner
join		dbo.Jugadores j
on			ss.id_jugador = j.id_jugador
where		j.numero_de_documento = '11607507' and 
			(sp.minutos_jugados is not null or
			sp.camiseta <> 0 or
			sp.goles_a_favor > 0 or
			sp.goles_en_contra > 0 or
			sp.amonestado_expulsado is not null or
			sp.mejor_jugador is not null or
			sp.penales_convertidos > 0 or
			sp.penales_atajados > 0 or 
			sp.camiseta = 1)
order by 1
--order by	p.fecha_parido


--2002,2003,2004,2005,2006,2009,2010,2011,2012

