INSERT INTO `ssaif_prod_abril`.`dbjugadoresdocumentacion`
(`idjugadordocumentacion`,
`refjugadores`,
`refdocumentaciones`,
`valor`,
`observaciones`)
SELECT '',
	s.`jugadorid`,
    s.`docjugadoresid`,
    0,
    s.`observaciones`
FROM ssaif_back_abril.reljugadoresdocumentacionjugadores s
    inner
    join ssaif_back_abril.documentacionjugadoresvalores d
    on	d.docjugadoresid = s.docjugadoresid and d.valorid = s.valorid
    where s.docjugadoresid not in (1,2,6,7,9)












