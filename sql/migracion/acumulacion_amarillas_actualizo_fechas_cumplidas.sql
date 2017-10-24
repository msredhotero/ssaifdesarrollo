UPDATE `dbsancionesfechascumplidas` 
SET 
    `refsancionesfallosacumuladas` = refsancionesfallos
WHERE
    `idsancionfechacumplida` IN (16949)
    
UPDATE `dbsancionesfechascumplidas` 
SET 
    `refsancionesfallos` = 0
WHERE
    `idsancionfechacumplida` IN (16949)