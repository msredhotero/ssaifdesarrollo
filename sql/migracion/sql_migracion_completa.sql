INSERT INTO `ssaif_prod_abril`.`dbarbitros`
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
FROM `ssaif_bck_09052017`.`arbitros`;


INSERT INTO `ssaif_prod_abril`.`tbposiciontributaria`
(`idposiciontributaria`,
`posiciontributaria`,
`activo`)
SELECT `posicionestributarias`.`postributariaid`,
    `posicionestributarias`.`descripcion`,
    1
FROM `ssaif_bck_09052017`.`posicionestributarias`;



INSERT INTO `ssaif_prod_abril`.`tbposiciontributaria`
(`idposiciontributaria`,
`posiciontributaria`,
`activo`)
SELECT `posicionestributarias`.`postributariaid`,
    `posicionestributarias`.`descripcion`,
    1
FROM `ssaif_bck_09052017`.`posicionestributarias`;


INSERT INTO `ssaif_prod_abril`.`dbcountries`
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
FROM `ssaif_bck_09052017`.`clubes`;



INSERT INTO `ssaif_prod_abril`.`tbcanchas`
(`idcancha`,
`refcountries`,
`nombre`)
SELECT c.`canchaid`,
    coalesce(min(cc.`clubid`),0),
    c.`descripcion`
FROM `ssaif_bck_09052017`.`canchas` c
left
join ssaif_bck_09052017.relclubescanchas cc
on c.canchaid = cc.canchaid
group by c.`canchaid`,c.`descripcion`


INSERT INTO `ssaif_prod_abril`.`dbcountriecanchas`
(`idcountriecancha`,
`refcountries`,
`refcanchas`)

SELECT '',
cc.`clubid`,
c.`canchaid`
FROM `ssaif_bck_09052017`.`canchas` c
inner
join ssaif_bck_09052017.relclubescanchas cc
on c.canchaid = cc.canchaid


INSERT INTO `ssaif_prod_abril`.`tbcategorias`
(`idtcategoria`,
`categoria`)
SELECT `categorias`.`categoriaid`,
    `categorias`.`descripcion`
FROM `ssaif_bck_09052017`.`categorias`;


INSERT INTO `ssaif_prod_abril`.`tbdias`
(`iddia`,
`dia`)
SELECT `tbdias`.`iddia`,
    `tbdias`.`dia`
FROM `ssaif_desa_host`.`tbdias`;


INSERT INTO `ssaif_prod_abril`.`tbdivisiones`
(`iddivision`,
`division`)
SELECT `divisiones`.`divisionid`,
    `divisiones`.`descripcion`
FROM `ssaif_bck_09052017`.`divisiones`;

INSERT INTO `ssaif_prod_abril`.`tbdocumentaciones`
(`iddocumentacion`,
`descripcion`,
`obligatoria`,
`observaciones`)
SELECT `documentacionjugadores`.`docjugadoresid`,
    `documentacionjugadores`.`descripcion`,
    `documentacionjugadores`.`obligatoria`,
    `documentacionjugadores`.`observaciones`
FROM `ssaif_bck_09052017`.`documentacionjugadores`;



INSERT INTO `ssaif_prod_abril`.`tbestadospartidos`
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
FROM `ssaif_bck_09052017`.`estadospartidos`
where estadopartidoid > 0


INSERT INTO `ssaif_prod_abril`.`tbfechas`
(`idfecha`,
`fecha`)
SELECT `tbfechas`.`idfecha`,
    `tbfechas`.`fecha`
FROM `ssaif_desa_host`.`tbfechas`;


INSERT INTO `ssaif_prod_abril`.`tbmotivoshabilitacionestransitorias`
(`idmotivoshabilitacionestransitoria`,
`inhabilita`,
`descripcion`,
`refdocumentaciones`)
SELECT `motivoshabilitaciontransitoria`.`motivohabtransitoriaid`,
    `motivoshabilitaciontransitoria`.`inhabilitaalvencimiento`,
    `motivoshabilitaciontransitoria`.`descripcion`,
    `motivoshabilitaciontransitoria`.`docjugadoresid`
FROM `ssaif_bck_09052017`.`motivoshabilitaciontransitoria`;


INSERT INTO `ssaif_prod_abril`.`tbpuntobonus`
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
FROM `ssaif_bck_09052017`.`puntobonus`;


INSERT INTO `ssaif_prod_abril`.`tbtemporadas`
(`idtemporadas`,
`temporada`)
SELECT `temporadas`.`temporadaid`,
    `temporadas`.`descripcion`
FROM `ssaif_bck_09052017`.`temporadas`;


INSERT INTO `ssaif_prod_abril`.`tbtipocontactos`
(`idtipocontacto`,
`tipocontacto`,
`activo`)
SELECT `tipocontactosclubes`.`tipocontactoid`,
    `tipocontactosclubes`.`descripcion`,
    1
FROM `ssaif_bck_09052017`.`tipocontactosclubes`;


INSERT INTO `ssaif_prod_abril`.`tbtipodocumentos`
(`idtipodocumento`,
`tipodocumento`)
SELECT `tbtipodocumentos`.`idtipodocumento`,
    `tbtipodocumentos`.`tipodocumento`
FROM `ssaif_desa_host`.`tbtipodocumentos`;


INSERT INTO `ssaif_prod_abril`.`tbtipojugadores`
(`idtipojugador`,
`tipojugador`,
`abreviatura`)
SELECT `tipojugadores`.`tipojugadorid`,
    `tipojugadores`.`descripcion`,
    `tipojugadores`.`abreviatura`
FROM `ssaif_bck_09052017`.`tipojugadores`;


INSERT INTO `ssaif_prod_abril`.`tbtiposanciones`
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
FROM `ssaif_bck_09052017`.`tiposanciones`;


INSERT INTO `ssaif_prod_abril`.`tbtipotorneo`
(`idtipotorneo`,
`tipotorneo`)
SELECT `formatostorneo`.`formatotorneoid`,
    `formatostorneo`.`descripcion`
FROM `ssaif_bck_09052017`.`formatostorneo`;


INSERT INTO `ssaif_prod_abril`.`tbvaloreshabilitacionestransitorias`
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
FROM `ssaif_bck_09052017`.`documentacionjugadoresvalores`;


INSERT INTO `ssaif_prod_abril`.`dbdefinicionescategoriastemporadas`
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
FROM `ssaif_bck_09052017`.`definicionescategoriastemporadas`;



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
FROM `ssaif_bck_09052017`.`definicionescategoriastemporadastipojugador` dt
inner
join	ssaif_bck_09052017.definicionescategoriastemporadas d
on		d.categoriaid = dt.categoriaid and d.temporadaid = dt.temporadaid
inner
join	ssaif_prod_abril.dbdefinicionescategoriastemporadas t
on		d.categoriaid = t.refcategorias and d.temporadaid = t.reftemporadas



INSERT INTO `ssaif_prod_abril`.`dbdefinicionessancionesacumuladastemporadas`
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
FROM `ssaif_bck_09052017`.`definicionessancionesacumuladastemporadas`;



INSERT INTO `ssaif_prod_abril`.`dbtorneos`
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
FROM `ssaif_bck_09052017`.`torneos`;



INSERT INTO `ssaif_prod_abril`.`dbequipos`
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
FROM `ssaif_bck_09052017`.`equipos`;



INSERT INTO `ssaif_prod_abril`.`dbjugadores`
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
FROM `ssaif_bck_09052017`.`jugadores`;


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
FROM ssaif_bck_09052017.reljugadoresdocumentacionjugadores s
    inner
    join ssaif_bck_09052017.documentacionjugadoresvalores d
    on	d.docjugadoresid = s.docjugadoresid and d.valorid = s.valorid
    where s.docjugadoresid not in (1,2,6,7,9);
    /*where s.docjugadoresid in (1,2,6,7,9)*/
    
    
    
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
FROM ssaif_bck_09052017.reljugadoresdocumentacionjugadores s
    inner
    join ssaif_bck_09052017.documentacionjugadoresvalores d
    on	d.docjugadoresid = s.docjugadoresid and d.valorid = s.valorid
    where s.docjugadoresid in (1,2,6,7,9);
    
    
INSERT INTO `ssaif_prod_abril`.`dbjugadoresvaloreshabilitacionestransitorias`
(`iddbjugadorvalorhabilitaciontransitoria`,
`refjugadores`,
`refvaloreshabilitacionestransitorias`)
SELECT 
'',
s.`jugadorid`,
    v.idvalorhabilitaciontransitoria
    
FROM ssaif_bck_09052017.reljugadoresdocumentacionjugadores s
    inner
    join ssaif_bck_09052017.documentacionjugadoresvalores d
    on	d.docjugadoresid = s.docjugadoresid and d.valorid = s.valorid
    inner
    join tbvaloreshabilitacionestransitorias v
    on	v.valorviejo = d.valorid and v.refdocumentaciones = s.docjugadoresid
    where s.docjugadoresid not in (1,2,6,7,9) ;
    
    
    
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
on		t.idmotivoshabilitacionestransitoria = h.motivohabtransitoriaid;



INSERT INTO `ssaif_prod_abril`.`dbconector`
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
FROM `ssaif_bck_09052017`.`reljugadoresequipos` je
inner
join	ssaif_bck_09052017.equipos e
on		je.equipoid = e.equipoid
inner
join	ssaif_bck_09052017.jugadores j
on		j.jugadorid = je.jugadorid;


INSERT INTO `ssaif_prod_abril`.`dbfixture`
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
    `partidos`.`estadopartidoid`,
    `partidos`.`calificacioncancha`,
    `partidos`.`puntoslocal`,
    `partidos`.`puntosvisita`,
    `partidos`.`goleslocal`,
    `partidos`.`golesvisita`,
    `partidos`.`observaciones`,
    `partidos`.`publicar`
FROM `ssaif_bck_09052017`.`partidos`;



INSERT INTO `ssaif_prod_abril`.`predio_menu`
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
FROM `ssaif_test_final`.`predio_menu`;


INSERT INTO `ssaif_prod_abril`.`tbroles`
(`idrol`,
`descripcion`,
`activo`)
SELECT `tbroles`.`idrol`,
    `tbroles`.`descripcion`,
    `tbroles`.`activo`
FROM `ssaif_desa_host`.`tbroles`;


INSERT INTO `ssaif_prod_abril`.`dbtorneopuntobonus`
(`idtorneopuntobonus`,
`reftorneos`,
`refpuntobonus`)
SELECT '',
	`reltorneospuntobonus`.`torneoid`,
	`reltorneospuntobonus`.`puntobonusid`
    
FROM `ssaif_bck_09052017`.`reltorneospuntobonus`;



INSERT INTO `ssaif_prod_abril`.`dbusuarios`
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
FROM `ssaif_desa_host`.`dbusuarios`;


INSERT INTO `ssaif_prod_abril`.`dbgoleadores`
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
    ssaif_bck_09052017.partidosdetalle pd
inner
join	ssaif_bck_09052017.incidenciaspartidos ip
on		pd.incidenciapartidoid = ip.incidenciapartidoid
inner
join    ssaif_bck_09052017.equipos e
on		e.equipoid = pd.equipoid
where	ip.incidenciapartidoid in (1,2);


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




INSERT INTO `ssaif_prod_abril`.`dbsancionesfallos`
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
FROM `ssaif_bck_09052017`.`sancionesfallos`;




    
    

    
    
    







