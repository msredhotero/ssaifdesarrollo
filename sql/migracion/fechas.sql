INSERT INTO `ssaif_prod_abril`.`tbfechas`
(`idfecha`,
`fecha`)
SELECT `tbfechas`.`idfecha`,
    `tbfechas`.`fecha`
FROM `ssaif_desa_host`.`tbfechas`;











