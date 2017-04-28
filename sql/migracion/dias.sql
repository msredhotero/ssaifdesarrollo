INSERT INTO `ssaif_prod_abril`.`tbdias`
(`iddia`,
`dia`)
SELECT `tbdias`.`iddia`,
    `tbdias`.`dia`
FROM `ssaif_desa_host`.`tbdias`;






