INSERT INTO `ssaif_local_noviembre`.`dbarbitros`
(`idarbitro`,
`nombrecompleto`,
`telefonoparticular`,
`telefonoceleluar`,
`telefonolaboral`,
`telefonofamiliar`,
`email`)
SELECT `arbitros`.`arbitroid`,
    concat(`arbitros`.`apellido`,', ',    `arbitros`.`nombres`),
    
    `arbitros`.`telefono`,
    `arbitros`.`celular`,
    '',
    '',
    `arbitros`.`email`
FROM `tempo000000002`.`arbitros`;


INSERT INTO `ssaif_local_noviembre`.`tbposiciontributaria`
(`idposiciontributaria`,
`posiciontributaria`,
`activo`)
SELECT `posicionestributarias`.`postributariaid`,
    `posicionestributarias`.`descripcion`,
    1
FROM `tempo000000002`.`posicionestributarias`;




INSERT INTO `ssaif_local_noviembre`.`dbcountries`
(`idcountrie`,
`nombre`,
`cuit`,
`fechaalta`,
`fechabaja`,
`refposiciontributaria`,
`latitud`,
`longitud`,
`activo`,
`referencia`,
`imagen`,
`direccion`,
`telefonoadministrativo`,
`telefonocampo`,
`email`,
`localidad`,
`codigopostal`)
SELECT `clubes`.`clubid`,
    `clubes`.`nombre`,
    `clubes`.`cuit`,
    `clubes`.`fechaalta`,
    `clubes`.`fechabaja`,
    `clubes`.`postributariaid`,
    `clubes`.`coordgpslat`,
    `clubes`.`coordgpslong`,
	`clubes`.`activo`,
    '' as referencia,
    `clubes`.`logo`,
    '',
    '',
    '',
    '',
    '',
    ''
FROM `tempo000000002`.`clubes`;



INSERT INTO `ssaif_local_noviembre`.`tbcanchas`
(`idcancha`,
`refcountries`,
`nombre`)
SELECT c.`canchaid`,
    coalesce(min(cc.`clubid`),0),
    c.`descripcion`
FROM `tempo000000002`.`canchas` c
left
join tempo000000002.relclubescanchas cc
on c.canchaid = cc.canchaid
group by c.`canchaid`,c.`descripcion`;


INSERT INTO `ssaif_local_noviembre`.`dbcountriecanchas`
(`idcountriecancha`,
`refcountries`,
`refcanchas`)

SELECT '',
cc.`clubid`,
c.`canchaid`
FROM `tempo000000002`.`canchas` c
inner
join tempo000000002.relclubescanchas cc
on c.canchaid = cc.canchaid;


INSERT INTO `ssaif_local_noviembre`.`tbcategorias`
(`idtcategoria`,
`categoria`)
SELECT `categorias`.`categoriaid`,
    `categorias`.`descripcion`
FROM `tempo000000002`.`categorias`;


INSERT INTO `ssaif_local_noviembre`.`tbdias`
(`iddia`,
`dia`)
SELECT `tbdias`.`iddia`,
    `tbdias`.`dia`
FROM `ssaif_desa_host`.`tbdias`;


INSERT INTO `ssaif_local_noviembre`.`tbdivisiones`
(`iddivision`,
`division`)
SELECT `divisiones`.`divisionid`,
    `divisiones`.`descripcion`
FROM `tempo000000002`.`divisiones`;

INSERT INTO `ssaif_local_noviembre`.`tbdocumentaciones`
(`iddocumentacion`,
`descripcion`,
`obligatoria`,
`observaciones`)
SELECT `documentacionjugadores`.`docjugadoresid`,
    `documentacionjugadores`.`descripcion`,
    `documentacionjugadores`.`obligatoria`,
    `documentacionjugadores`.`observaciones`
FROM `tempo000000002`.`documentacionjugadores`;



INSERT INTO `ssaif_local_noviembre`.`tbestadospartidos`
(`idestadopartido`,
`descripcion`,
`defautomatica`,
`goleslocalauto`,
`goleslocalborra`,
`golesvisitanteauto`,
`golesvisitanteborra`,
`puntoslocal`,
`puntosvisitante`,
`finalizado`,
`ocultardetallepublico`,
`visibleparaarbitros`,
`contabilizalocal`,
`contabilizavisitante`)
SELECT `estadospartidos`.`estadopartidoid`,
    `estadospartidos`.`descripcion`,
    `estadospartidos`.`defautomatica`,
    `estadospartidos`.`goleslocalauto`,
    `estadospartidos`.`goleslocalborra`,
    `estadospartidos`.`golesvisitanteauto`,
    `estadospartidos`.`golesvisitanteborra`,
    `estadospartidos`.`puntoslocal`,
    `estadospartidos`.`puntosvisitante`,
    `estadospartidos`.`finalizado`,
    `estadospartidos`.`ocultardetallepublico`,
    `estadospartidos`.`visibleparaarbitros`,
    `estadospartidos`.`contabilizalocal`,
    `estadospartidos`.`contabilizavisitante`
FROM `tempo000000002`.`estadospartidos`
where estadopartidoid > 0;


INSERT INTO `ssaif_local_noviembre`.`tbfechas`
(`idfecha`,
`fecha`)
SELECT `tbfechas`.`idfecha`,
    `tbfechas`.`fecha`
FROM `ssaif_desa_host`.`tbfechas`;


INSERT INTO `ssaif_local_noviembre`.`tbmotivoshabilitacionestransitorias`
(`idmotivoshabilitacionestransitoria`,
`inhabilita`,
`descripcion`,
`refdocumentaciones`)
SELECT `motivoshabilitaciontransitoria`.`motivohabtransitoriaid`,
    `motivoshabilitaciontransitoria`.`inhabilitaalvencimiento`,
    `motivoshabilitaciontransitoria`.`descripcion`,
    `motivoshabilitaciontransitoria`.`docjugadoresid`
FROM `tempo000000002`.`motivoshabilitaciontransitoria`;


INSERT INTO `ssaif_local_noviembre`.`tbpuntobonus`
(`idpuntobonus`,
`descripcion`,
`cantidadfechas`,
`comparacion`,
`valoracomparar`,
`puntosextra`,
`consecutivas`)
SELECT `puntobonus`.`puntobonusid`,
    `puntobonus`.`descripcion`,
    `puntobonus`.`cantidadfechas`,
    
    `puntobonus`.`comparacion`,
    `puntobonus`.`valoracomparar`,
    `puntobonus`.`puntosextra`,
    `puntobonus`.`consecutivas`
FROM `tempo000000002`.`puntobonus`;


INSERT INTO `ssaif_local_noviembre`.`tbtemporadas`
(`idtemporadas`,
`temporada`)
SELECT `temporadas`.`temporadaid`,
    `temporadas`.`descripcion`
FROM `tempo000000002`.`temporadas`;


INSERT INTO `ssaif_local_noviembre`.`tbtipocontactos`
(`idtipocontacto`,
`tipocontacto`,
`activo`)
SELECT `tipocontactosclubes`.`tipocontactoid`,
    `tipocontactosclubes`.`descripcion`,
    1
FROM `tempo000000002`.`tipocontactosclubes`;


INSERT INTO `ssaif_local_noviembre`.`tbtipodocumentos`
(`idtipodocumento`,
`tipodocumento`)
SELECT `tbtipodocumentos`.`idtipodocumento`,
    `tbtipodocumentos`.`tipodocumento`
FROM `ssaif_desa_host`.`tbtipodocumentos`;


INSERT INTO `ssaif_local_noviembre`.`tbtipojugadores`
(`idtipojugador`,
`tipojugador`,
`abreviatura`)
SELECT `tipojugadores`.`tipojugadorid`,
    `tipojugadores`.`descripcion`,
    `tipojugadores`.`abreviatura`
FROM `tempo000000002`.`tipojugadores`;


INSERT INTO `ssaif_local_noviembre`.`tbtiposanciones`
(`idtiposancion`,
`descripcion`,
`cantminfechas`,
`cantmaxfechas`,
`abreviatura`,
`expulsion`,
`amonestacion`,
`cumpletodascategorias`,
`llevapendiente`,
`ocultardetallepublico`)
SELECT `tiposanciones`.`tiposancionid`,
    `tiposanciones`.`descripcion`,
    `tiposanciones`.`cantminfechas`,
    `tiposanciones`.`cantmaxfechas`,
    `tiposanciones`.`abreviatura`,
    `tiposanciones`.`expulsion`,
    `tiposanciones`.`amonestacion`,
    `tiposanciones`.`cumpletodascategorias`,
    `tiposanciones`.`llevapendiente`,
    `tiposanciones`.`ocultardetallepublico`
FROM `tempo000000002`.`tiposanciones`;


INSERT INTO `ssaif_local_noviembre`.`tbtipotorneo`
(`idtipotorneo`,
`tipotorneo`)
SELECT `formatostorneo`.`formatotorneoid`,
    `formatostorneo`.`descripcion`
FROM `tempo000000002`.`formatostorneo`;


INSERT INTO `ssaif_local_noviembre`.`tbvaloreshabilitacionestransitorias`
(`idvalorhabilitaciontransitoria`,
`refdocumentaciones`,
`descripcion`,
`habilita`,
`predeterminado`,
valorviejo)
SELECT '', 
	`documentacionjugadoresvalores`.`docjugadoresid`,
    `documentacionjugadoresvalores`.`descripcion`,
    `documentacionjugadoresvalores`.`habilita`,
    `documentacionjugadoresvalores`.`esdefault`,
    valorid
FROM `tempo000000002`.`documentacionjugadoresvalores`;


INSERT INTO `ssaif_local_noviembre`.`dbdefinicionescategoriastemporadas`
(`iddefinicioncategoriatemporada`,
`refcategorias`,
`reftemporadas`,
`cantmaxjugadores`,
`cantminjugadores`,
`refdias`,
`hora`,
`minutospartido`,
`cantidadcambiosporpartido`,
`conreingreso`,
`observaciones`)
SELECT '',
	`definicionescategoriastemporadas`.`categoriaid`,
    `definicionescategoriastemporadas`.`temporadaid`,
    `definicionescategoriastemporadas`.`cantmaxjugadores`,
    `definicionescategoriastemporadas`.`cantminjugadores`,
    1,
    `definicionescategoriastemporadas`.`hora`,
    `definicionescategoriastemporadas`.`minutospartido`,
    `definicionescategoriastemporadas`.`cantcambiosporpartido`,
    `definicionescategoriastemporadas`.`conreingreso`,
    `definicionescategoriastemporadas`.`observaciones`
FROM `tempo000000002`.`definicionescategoriastemporadas`;



INSERT INTO `ssaif_local_noviembre`.`dbdefinicionescategoriastemporadastipojugador`
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
FROM `tempo000000002`.`definicionescategoriastemporadastipojugador` dt
inner
join	tempo000000002.definicionescategoriastemporadas d
on		d.categoriaid = dt.categoriaid and d.temporadaid = dt.temporadaid
inner
join	ssaif_local_noviembre.dbdefinicionescategoriastemporadas t
on		d.categoriaid = t.refcategorias and d.temporadaid = t.reftemporadas;



INSERT INTO `ssaif_local_noviembre`.`dbdefinicionessancionesacumuladastemporadas`
(`iddefinicionessancionesacumuladastemporadas`,
`reftiposanciones`,
`reftemporadas`,
`cantidadacumulada`,
`cantidadfechasacumplir`)
SELECT '', 
	`definicionessancionesacumuladastemporadas`.`tiposancionid`,
    `definicionessancionesacumuladastemporadas`.`temporadaid`,
    `definicionessancionesacumuladastemporadas`.`cantacumulada`,
    `definicionessancionesacumuladastemporadas`.`cantfechasacumplir`
FROM `tempo000000002`.`definicionessancionesacumuladastemporadas`;



INSERT INTO `ssaif_local_noviembre`.`dbtorneos`
(`idtorneo`,
`descripcion`,
`reftipotorneo`,
`reftemporadas`,
`refcategorias`,
`refdivisiones`,
`cantidadascensos`,
`cantidaddescensos`,
`respetadefiniciontipojugadores`,
`respetadefinicionhabilitacionestransitorias`,
`respetadefinicionsancionesacumuladas`,
`acumulagoleadores`,
`acumulatablaconformada`,
`observaciones`,
`activo`)
SELECT `torneos`.`torneoid`,
    `torneos`.`descripcion`,
    `torneos`.`formatotorneoid`,
    `torneos`.`temporadaid`,
    `torneos`.`categoriaid`,
    `torneos`.`divisionid`,
    `torneos`.`cantascensos`,
    `torneos`.`cantdescensos`,
    `torneos`.`respetadeftipojugadores`,
    `torneos`.`respetadefhabtransitorias`,
    `torneos`.`respetadefsancionesacum`,
    `torneos`.`acumulagoleadores`,
    `torneos`.`acumulatablaconformada`,
    `torneos`.`observaciones`,
    1
FROM `tempo000000002`.`torneos`;



INSERT INTO `ssaif_local_noviembre`.`dbcontactos`
(`idcontacto`,
`reftipocontactos`,
`nombre`,
`direccion`,
`localidad`,
`cp`,
`telefono`,
`celular`,
`fax`,
`email`,
`observaciones`,
`publico`,
clubid,
contactoid,
tipocontactoid)


SELECT '',
    `relclubescontactos`.`tipocontactoid`,
    
    `relclubescontactos`.`nombre`,
    
    `relclubescontactos`.`direccion`,
    `relclubescontactos`.`localidad`,
    `relclubescontactos`.`codpostal`,
    `relclubescontactos`.`telefono`,
    `relclubescontactos`.`celular`,
    `relclubescontactos`.`fax`,
    `relclubescontactos`.`mail`,
    `relclubescontactos`.`observaciones`,
	1,
	`relclubescontactos`.clubid,
	`relclubescontactos`.contactoid,
    `relclubescontactos`.tipocontactoid
FROM `tempo000000002`.`relclubescontactos`;


INSERT INTO `ssaif_local_noviembre`.`dbcountriecontactos`
(`idcountriecontacto`,
`refcountries`,
`refcontactos`)
SELECT '',
	`dbcontactos`.`clubid`,
	`dbcontactos`.`idcontacto`
FROM `ssaif_local_noviembre`.`dbcontactos`;



INSERT INTO `ssaif_local_noviembre`.`dbequipos`
(`idequipo`,
`refcountries`,
`nombre`,
`refcategorias`,
`refdivisiones`,
`refcontactos`,
`fechaalta`,
`fachebaja`,
`activo`)
SELECT `equipos`.`equipoid`,
    `equipos`.`clubid`,
    `equipos`.`descripcion`,
    `equipos`.`categoriaid`,
    `equipos`.`divisionid`,
    1,
    `equipos`.`fechaalta`,
    `equipos`.`fechabaja`,
    `equipos`.`activo`
FROM `tempo000000002`.`equipos`;





INSERT INTO `ssaif_local_noviembre`.`dbjugadores`
(`idjugador`,
`reftipodocumentos`,
`nrodocumento`,
`apellido`,
`nombres`,
`email`,
`fechanacimiento`,
`fechaalta`,
`fechabaja`,
`refcountries`,
`observaciones`)
SELECT `jugadores`.`jugadorid`,
    `jugadores`.`tipodocumento`,
    `jugadores`.`documento`,
    `jugadores`.`apellido`,
    `jugadores`.`nombres`,
    `jugadores`.`email`,
    `jugadores`.`fechanac`,
    `jugadores`.`fechaalta`,
    `jugadores`.`fechabaja`,
    `jugadores`.`clubid`,
    `jugadores`.`observaciones`
FROM `tempo000000002`.`jugadores`;


INSERT INTO `ssaif_local_noviembre`.`dbjugadoresdocumentacion`
(`idjugadordocumentacion`,
`refjugadores`,
`refdocumentaciones`,
`valor`,
`observaciones`)
SELECT '',
	s.`jugadorid`,
    s.`docjugadoresid`,
    d.habilita,
    s.`observaciones`
FROM tempo000000002.reljugadoresdocumentacionjugadores s
    inner
    join tempo000000002.documentacionjugadoresvalores d
    on	d.docjugadoresid = s.docjugadoresid and d.valorid = s.valorid
    where s.docjugadoresid not in (1,2,6,7,9);
    /*where s.docjugadoresid in (1,2,6,7,9)*/
    
    
    
INSERT INTO `ssaif_local_noviembre`.`dbjugadoresdocumentacion`
(`idjugadordocumentacion`,
`refjugadores`,
`refdocumentaciones`,
`valor`,
`observaciones`)
SELECT '',
	s.`jugadorid`,
    s.`docjugadoresid`,
    d.habilita,
    s.`observaciones`
FROM tempo000000002.reljugadoresdocumentacionjugadores s
    inner
    join tempo000000002.documentacionjugadoresvalores d
    on	d.docjugadoresid = s.docjugadoresid and d.valorid = s.valorid
    where s.docjugadoresid in (1,2,6,7,9);
    
    
INSERT INTO `ssaif_local_noviembre`.`dbjugadoresvaloreshabilitacionestransitorias`
(`iddbjugadorvalorhabilitaciontransitoria`,
`refjugadores`,
`refvaloreshabilitacionestransitorias`)
SELECT 
'',
s.`jugadorid`,
    v.idvalorhabilitaciontransitoria
    
FROM tempo000000002.reljugadoresdocumentacionjugadores s
    inner
    join tempo000000002.documentacionjugadoresvalores d
    on	d.docjugadoresid = s.docjugadoresid and d.valorid = s.valorid
    inner
    join ssaif_local_noviembre.tbvaloreshabilitacionestransitorias v
    on	v.valorviejo = d.valorid and v.refdocumentaciones = s.docjugadoresid
    where s.docjugadoresid not in (1,2,6,7,9) ;
    
    
    
INSERT INTO `ssaif_local_noviembre`.`dbjugadoresmotivoshabilitacionestransitorias`
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

FROM `tempo000000002`.`habilitacionestranjugadores` h
inner
join	tempo000000002.equipos e
on		e.equipoid = h.equipoid
inner
join	ssaif_local_noviembre.tbmotivoshabilitacionestransitorias t
on		t.idmotivoshabilitacionestransitoria = h.motivohabtransitoriaid;



INSERT INTO `ssaif_local_noviembre`.`dbconector`
(`idconector`,
`refjugadores`,
`reftipojugadores`,
`refequipos`,
`refcountries`,
`refcategorias`,
`esfusion`,
`activo`)
SELECT '',
	je.`jugadorid`,
    je.`tipojugadorid`,
	je.`equipoid`,
    j.clubid,
	e.categoriaid,
	(case when j.clubid <> e.clubid then 1 else 0 end),
	1
FROM `tempo000000002`.`reljugadoresequipos` je
inner
join	tempo000000002.equipos e
on		je.equipoid = e.equipoid
inner
join	tempo000000002.jugadores j
on		j.jugadorid = je.jugadorid;


/*
update ssaif_back_host_06.dbfixture

UPDATE ssaif_back_host_06.dbfixture p, ssaif_back_abril.partidos pp
SET p.refestadospartidos = pp.estadopartidoid,
	p.refarbitros = pp.arbitroid,
    p.juez1 = pp.juez1,
    p.juez2 = pp.juez2,
    p.refcanchas = pp.canchaid,
    p.fecha = pp.fecha,
    p.calificacioncancha = pp.calificacioncancha,
    p.puntoslocal = pp.puntoslocal,
    p.puntosvisita = pp.puntosvisita,
    p.goleslocal = pp.goleslocal,
    p.golesvisitantes = pp.golesvisita,
    p.observaciones = pp.observaciones
WHERE p.idfixture = pp.partidoid
AND p.fecha > '2017-04-01'

*/
INSERT INTO `ssaif_local_noviembre`.`dbfixture`
(`idfixture`,
`reftorneos`,
`reffechas`,
`refconectorlocal`,
`refconectorvisitante`,
`refarbitros`,
`juez1`,
`juez2`,
`refcanchas`,
`fecha`,
`hora`,
`refestadospartidos`,
`calificacioncancha`,
`puntoslocal`,
`puntosvisita`,
`goleslocal`,
`golesvisitantes`,
`observaciones`,
`publicar`)
SELECT `partidos`.`partidoid`,
    `partidos`.`torneoid`,
    `partidos`.`fechanro`,
    `partidos`.`equipolocalid`,
    `partidos`.`equipovisitaid`,
    `partidos`.`arbitroid`,
    `partidos`.`juez1`,
    `partidos`.`juez2`,
    `partidos`.`canchaid`,
    `partidos`.`fecha`,
    `partidos`.`hora`,
    (case when `partidos`.`estadopartidoid` = 0 then null else `partidos`.`estadopartidoid` end),
    `partidos`.`calificacioncancha`,
    `partidos`.`puntoslocal`,
    `partidos`.`puntosvisita`,
    `partidos`.`goleslocal`,
    `partidos`.`golesvisita`,
    `partidos`.`observaciones`,
    `partidos`.`publicar`
FROM `tempo000000002`.`partidos`;



INSERT INTO `ssaif_local_noviembre`.`predio_menu`
(`idmenu`,
`url`,
`icono`,
`nombre`,
`Orden`,
`hover`,
`permiso`,
`administracion`,
`torneo`,
`reportes`)
SELECT `predio_menu`.`idmenu`,
    `predio_menu`.`url`,
    `predio_menu`.`icono`,
    `predio_menu`.`nombre`,
    `predio_menu`.`Orden`,
    `predio_menu`.`hover`,
    `predio_menu`.`permiso`,
    `predio_menu`.`administracion`,
    `predio_menu`.`torneo`,
    `predio_menu`.`reportes`
FROM `ssaif_local_octubre_hosting2`.`predio_menu`;


INSERT INTO `ssaif_local_noviembre`.`tbroles`
(`idrol`,
`descripcion`,
`activo`)
SELECT `tbroles`.`idrol`,
    `tbroles`.`descripcion`,
    `tbroles`.`activo`
FROM `ssaif_local_octubre_hosting`.`tbroles`;


INSERT INTO `ssaif_local_noviembre`.`dbtorneopuntobonus`
(`idtorneopuntobonus`,
`reftorneos`,
`refpuntobonus`)
SELECT '',
	`reltorneospuntobonus`.`torneoid`,
	`reltorneospuntobonus`.`puntobonusid`
    
FROM `tempo000000002`.`reltorneospuntobonus`;



INSERT INTO `ssaif_local_noviembre`.`dbusuarios`
(`idusuario`,
`usuario`,
`password`,
`refroles`,
`email`,
`nombrecompleto`)
SELECT `dbusuarios`.`idusuario`,
    `dbusuarios`.`usuario`,
    `dbusuarios`.`password`,
    `dbusuarios`.`refroles`,
    `dbusuarios`.`email`,
    `dbusuarios`.`nombrecompleto`
FROM `ssaif_local_noviembre_hosting`.`dbusuarios`;


INSERT INTO `ssaif_local_noviembre`.`dbgoleadores`
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
    tempo000000002.partidosdetalle pd
inner
join	tempo000000002.incidenciaspartidos ip
on		pd.incidenciapartidoid = ip.incidenciapartidoid
inner
join    tempo000000002.equipos e
on		e.equipoid = pd.equipoid
where	ip.incidenciapartidoid in (1,2);


INSERT INTO `ssaif_local_noviembre`.`dbsancionesjugadores`
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
FROM `tempo000000002`.`sancionesjugadores` s
inner
join	tempo000000002.equipos e
on		s.equipoid = e.equipoid;




INSERT INTO `ssaif_local_noviembre`.`dbsancionesfallos`
(`idsancionfallo`,
`refsancionesjugadores`,
`cantidadfechas`,
`fechadesde`,
`fechahasta`,
`amarillas`,
`fechascumplidas`,
`pendientescumplimientos`,
`pendientesfallo`,
`generadaporacumulacion`,
`observaciones`)

SELECT `sancionesfallos`.`sancionfalloid`,
    `sancionesfallos`.`sancionjugadorid`,
    `sancionesfallos`.`cantfechas`,
    `sancionesfallos`.`fechadde`,
    `sancionesfallos`.`fechahta`,
    0,
    `sancionesfallos`.`fechascumplidas`,
    `sancionesfallos`.`pendcumplimiento`,
    `sancionesfallos`.`pendfallo`,
    `sancionesfallos`.`generadaporacumulacion`,
    `sancionesfallos`.`observaciones`
FROM `tempo000000002`.`sancionesfallos`;


INSERT INTO `ssaif_local_noviembre`.`dbpenalesjugadores`
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
    tempo000000002.partidosdetalle pd
inner
join	tempo000000002.incidenciaspartidos ip
on		pd.incidenciapartidoid = ip.incidenciapartidoid
inner
join    tempo000000002.equipos e
on		e.equipoid = pd.equipoid
where	ip.incidenciapartidoid in (4,5,6);


INSERT INTO ssaif_local_noviembre.dbminutosjugados
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
    tempo000000002.partidosdetalle pd
inner
join	tempo000000002.incidenciaspartidos ip
on		pd.incidenciapartidoid = ip.incidenciapartidoid
inner
join    tempo000000002.equipos e
on		e.equipoid = pd.equipoid
where	ip.incidenciapartidoid in (3);


INSERT INTO `ssaif_local_noviembre`.`dbmejorjugador`
(`idmejorjugador`,
`refjugadores`,
`reffixture`,
`refequipos`,
`refcategorias`,
`refdivisiones`)
SELECT '',
    pd.jugadorid,
    pd.partidoid,
    pd.equipoid,
    e.categoriaid,
    e.divisionid
FROM
    tempo000000002.partidosdetalle pd
inner
join	tempo000000002.incidenciaspartidos ip
on		pd.incidenciapartidoid = ip.incidenciapartidoid
inner
join    tempo000000002.equipos e
on		e.equipoid = pd.equipoid
where	ip.incidenciapartidoid in (8);



INSERT INTO `ssaif_local_noviembre`.`dbsancionesfechascumplidas`
(`idsancionfechacumplida`,
`reffixture`,
`refjugadores`,
`cumplida`,
`refsancionesfallos`,
`refsancionesfallosacumuladas`)

SELECT 
	'',
	sc.`partidoidcumplimiento`,
	sj.jugadorid,
	1,
	sc.`sancionfalloid`,
	0
FROM `tempo000000002`.`partidoscumplimientosanciones` sc
inner
join	tempo000000002.sancionesfallos sf
on 		sf.sancionfalloid = sc.sancionfalloid
inner
join	tempo000000002.sancionesjugadores sj
on		sj.sancionjugadorid = sf.sancionjugadorid

group by sc.`partidoidcumplimiento`,
    sc.`sancionfalloid`,
sj.jugadorid,
	sf.sancionfalloid




    
    

    
    
    







