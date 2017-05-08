INSERT INTO `ssaif_test_final`.`dbgoleadores`
(`idgoleador`,
`refjugadores`,
`reffixture`,
`refequipos`,
`refcategorias`,
`refdivisiones`,
`goles`,
`encontra`)
SELECT '',
    pd.jugadorid,
    pd.partidoid,
    pd.equipoid,
    e.categoriaid,
    e.divisionid,
    (case when ip.incidenciapartidoid = 1 then pd.valor else 0 end) as goles,
    (case when ip.incidenciapartidoid = 2 then pd.valor else 0 end) as engoles
FROM
    ssaif_back_abril.partidosdetalle pd
inner
join	ssaif_back_abril.incidenciaspartidos ip
on		pd.incidenciapartidoid = ip.incidenciapartidoid
inner
join    ssaif_back_abril.equipos e
on		e.equipoid = pd.equipoid
where	ip.incidenciapartidoid in (1,2)
