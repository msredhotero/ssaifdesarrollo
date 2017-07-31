INSERT INTO ssaif_local_julio.dbminutosjugados
(`idminutojugado`,
`refjugadores`,
`reffixture`,
`refequipos`,
`refcategorias`,
`refdivisiones`,
`minutos`)
SELECT '',
    pd.jugadorid,
    pd.partidoid,
    pd.equipoid,
    e.categoriaid,
    e.divisionid,
    pd.valor as minutos
FROM
    aif_bck_up_mayo_15.partidosdetalle pd
inner
join	aif_bck_up_mayo_15.incidenciaspartidos ip
on		pd.incidenciapartidoid = ip.incidenciapartidoid
inner
join    aif_bck_up_mayo_15.equipos e
on		e.equipoid = pd.equipoid
where	ip.incidenciapartidoid in (3) and pd.partidoid < 8081