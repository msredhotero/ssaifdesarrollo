INSERT INTO `ssaif_prod_abril`.`dbdefinicionescategoriastemporadastipojugador`
(`iddefinicionescategoriastemporadastipojugador`,
`refdefinicionescategoriastemporadas`,
`reftipojugadores`,
`edadmaxima`,
`edadminima`,
`cantjugadoresporequipo`,
`jugadorescancha`,
`observaciones`)
SELECT '',
	t.iddefinicioncategoriatemporada,
    dt.`tipojugadorid`,
    dt.`edadmaxima`,
    dt.`edadminima`,
    dt.`cantjugadoresporequipo`,
    dt.`cantjugadoresencancha`,
    dt.`observaciones`
FROM `ssaif_back_abril`.`definicionescategoriastemporadastipojugador` dt
inner
join	ssaif_back_abril.definicionescategoriastemporadas d
on		d.categoriaid = dt.categoriaid and d.temporadaid = dt.temporadaid
inner
join	dbdefinicionescategoriastemporadas t
on		d.categoriaid = t.refcategorias and d.temporadaid = t.reftemporadas







