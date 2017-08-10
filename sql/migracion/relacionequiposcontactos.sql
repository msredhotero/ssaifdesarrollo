UPDATE dbequipos e
JOIN aif_bck_up_mayo_15.equipos ee 
ON ee.equipoid = e.idequipo
join aif_bck_up_mayo_15.relclubescontactos re
on	ee.contactoclubid = re.contactoid and ee.clubid = re.clubid
join dbcontactos cc
on cc.clubid = re.clubid and cc.contactoid = re.contactoid and cc.tipocontactoid = re.tipocontactoid
SET e.refcontactos = cc.idcontacto;