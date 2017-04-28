INSERT INTO `ssaif_prod_abril`.`dbjugadoresmotivoshabilitacionestransitorias`
(`iddbjugadormotivohabilitaciontransitoria`,
`reftemporadas`,
`refjugadores`,
`refdocumentaciones`,
`refmotivoshabilitacionestransitorias`,
`refequipos`,
`refcategorias`,
`fechalimite`,
`observaciones`)
SELECT 

'',
h.`temporadaid`,
    h.`jugadorid`,
    t.refdocumentaciones,
    h.`motivohabtransitoriaid`,
    h.`equipoid`,
    e.categoriaid,
    h.`fechalimhabtransitoria`,
    h.`observaciones`

FROM `ssaif_back_abril`.`habilitacionestranjugadores` h
inner
join	ssaif_back_abril.equipos e
on		e.equipoid = h.equipoid
inner
join	ssaif_prod_abril.tbmotivoshabilitacionestransitorias t
on		t.idmotivoshabilitacionestransitoria = h.motivohabtransitoriaid














