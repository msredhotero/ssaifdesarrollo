INSERT INTO `ssaif_prod_abril`.`dbpenalesjugadores`
(`idpenaljugador`,
`refjugadores`,
`reffixture`,
`refequipos`,
`refcategorias`,
`refdivisiones`,
`penalconvertido`,
`penalerrado`,
`penalatajado`)


SELECT '',
    pd.jugadorid,
    pd.partidoid,
    pd.equipoid,
    e.categoriaid,
    e.divisionid,
    (case when ip.incidenciapartidoid = 4 then pd.valor else 0 end) as penalconvertido,
    (case when ip.incidenciapartidoid = 6 then pd.valor else 0 end) as penalerrado,
    (case when ip.incidenciapartidoid = 5 then pd.valor else 0 end) as penalatajado
FROM
    ssaif_bck_09052017.partidosdetalle pd
inner
join	ssaif_bck_09052017.incidenciaspartidos ip
on		pd.incidenciapartidoid = ip.incidenciapartidoid
inner
join    ssaif_bck_09052017.equipos e
on		e.equipoid = pd.equipoid
where	ip.incidenciapartidoid in (4,5,6);
