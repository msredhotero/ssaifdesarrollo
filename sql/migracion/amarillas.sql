INSERT INTO `ssaif_prod_abril`.`dbsancionesjugadores`
(`idsancionjugador`,
`reftiposanciones`,
`refjugadores`,
`refequipos`,
`reffixture`,
`fecha`,
`cantidad`,
`refcategorias`,
`refdivisiones`,
`refsancionesfallos`)

SELECT s.`sancionjugadorid`,
    s.`tiposancionid`,
    s.`jugadorid`,
    s.`equipoid`,
    s.`partidoid`,
    s.`fecha`,
    s.`cantidad`,
    s.`categoriasancionorigenid`,
    e.divisionid,
    s.`sancionfalloid`
FROM `ssaif_bck_09052017`.`sancionesjugadores` s
inner
join	ssaif_bck_09052017.equipos e
on		s.equipoid = e.equipoid;
