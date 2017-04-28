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
FROM `ssaif_back_abril`.`estadospartidos`
where estadopartidoid > 0









