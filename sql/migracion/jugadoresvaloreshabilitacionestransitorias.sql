INSERT INTO `ssaif_prod_abril`.`dbjugadoresvaloreshabilitacionestransitorias`
(`iddbjugadorvalorhabilitaciontransitoria`,
`refjugadores`,
`refvaloreshabilitacionestransitorias`)
SELECT 
'',
s.`jugadorid`,
    v.idvalorhabilitaciontransitoria
    
FROM ssaif_back_abril.reljugadoresdocumentacionjugadores s
    inner
    join ssaif_back_abril.documentacionjugadoresvalores d
    on	d.docjugadoresid = s.docjugadoresid and d.valorid = s.valorid
    inner
    join tbvaloreshabilitacionestransitorias v
    on	v.valorviejo = d.valorid and v.refdocumentaciones = s.docjugadoresid
    where s.docjugadoresid not in (1,2,6,7,9) 













