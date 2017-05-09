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
    (case when t.refdocumentaciones=0 then 2 else t.refdocumentaciones end) as refdocumentaciones,
    h.`motivohabtransitoriaid`,
    h.`equipoid`,
    e.categoriaid,
    h.`fechalimhabtransitoria`,
    h.`observaciones`

FROM `ssaif_bck_09052017`.`habilitacionestranjugadores` h
inner
join	ssaif_bck_09052017.equipos e
on		e.equipoid = h.equipoid
inner
join	ssaif_prod_abril.tbmotivoshabilitacionestransitorias t
on		t.idmotivoshabilitacionestransitoria = h.motivohabtransitoriaid














INSERT INTO `ssaif_prod_abril`.`dbjugadoresmotivoshabilitacionestransitorias` (`iddbjugadormotivohabilitaciontransitoria`, `reftemporadas`, `refjugadores`, `refdocumentaciones`, `refmotivoshabilitacionestransitorias`, `refequipos`, `refcategorias`, `fechalimite`, `observaciones`) SELECT   '', h.`temporadaid`,     h.`jugadorid`,     (case when t.refdocumentaciones=0 then 2 else t.refdocumentaciones end) as refdocumentaciones,     h.`motivohabtransitoriaid`,     h.`equipoid`,     e.categoriaid,     h.`fechalimhabtransitoria`,     h.`observaciones`  FROM `ssaif_bck_09052017`.`habilitacionestranjugadores` h inner join ssaif_bck_09052017.equipos e on  e.equipoid = h.equipoid inner join ssaif_prod_abril.tbmotivoshabilitacionestransitorias t on  t.idmotivoshabilitacionestransitoria = h.motivohabtransitoriaid
