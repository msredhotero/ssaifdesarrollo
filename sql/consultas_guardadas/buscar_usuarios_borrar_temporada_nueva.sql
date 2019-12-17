select
j.email
from		dbjugadorespre j
left
join		dbjugadores jj
on			j.nrodocumento = jj.nrodocumento
inner
join		dbusuarios u on u.email = j.email COLLATE utf8_general_ci
where		jj.idjugador is null and j.email <> ''