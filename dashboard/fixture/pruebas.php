<?php

$equipos = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);

$mitad = count($equipos) / 2;

$mitadAvance = count($equipos) / 2;

$direccion = "local";

$avance = 2; //para ir corriendo

$fecha = 1;

$resultado = array();

$puedeEntrar = 0;

$pares = 1;
$impares = 2;

$eje = 1;
$ejeY = 0;
//recorro por fechas
for ($i = 0; $i<count($equipos)-2; $i++) {
	
	$puedeEntrar = floor(($avance - 2)/2); //me va a decir los equipos que entran despues del primer partido
	$ejeY = floor((count($equipos) - $avance)/2);
	
	//recorro los partidos
	for ($k=0; $k< (count($equipos)/2); $k++) {
		//voy por los pares
		if (($i%2)==0) {
			
			//primer partido
			if ($k==0) {
				array_push($resultado, $equipos[0]."***".$equipos[$avance-1]);
			} else {
				//ultimo partido de la fecha
				if (($k == (count($equipos)/2)-1) && ($i != count($equipos)-1)) {
					array_push($resultado, $equipos[$mitad + ($avance-$impares)]."***".$equipos[count($equipos)-1]);	
					//array_push($resultado, '0***0');
				} else {

					//resto: Fechas y partidos intermedios	
					if (($avance > 3) && ($puedeEntrar != 0)) {
						array_push($resultado, $equipos[$k]."***".$equipos[$avance - ($k+1)]);
						//array_push($resultado, '0***0');
						$puedeEntrar -= 1;
					} else {
						//array_push($resultado, '0***0');
						array_push($resultado, $equipos[$mitadAvance + $eje]."***".$equipos[$mitadAvance - $eje]);
						$eje += 1;
					}
				}
			}
			
			
			
		} else {
			
			
			//primer partido
			if ($k==0) {
				array_push($resultado, $equipos[$avance-1]."***".$equipos[0]);
			} else {
				//ultimo partido de la fecha
				if (($k == (count($equipos)/2)-1) && ($i != count($equipos)-1)) {
					array_push($resultado, $equipos[count($equipos)-1]."***".$equipos[$pares]);	
					//array_push($resultado, '0***0');
				} else {

					//resto: Fechas y partidos intermedios	
					if (($avance > 3) && ($puedeEntrar != 0)) {
						array_push($resultado, $equipos[$avance - ($k+1)]."***".$equipos[$k]);
						//array_push($resultado, '0***0');
						$puedeEntrar -= 1;
					} else {
						array_push($resultado, $equipos[$mitadAvance - $ejeY + 1]."***".$equipos[$mitadAvance + $ejeY]);
						$ejeY -= 1;
						//array_push($resultado, '0***0');
					}
				}
			}
			
			
		}
	}
	
	$avance += 1;
	$eje = 1;
	$ejeY = 1;
	if (($i%2)!=0) {
		$pares += 1;
		$mitadAvance += 1;
	} else {
		$impares += 1;	
		
	}
	
}


for ($k=0; $k< (count($equipos)/2); $k++) {
		//voy por los pares
		if ($k == 0) {
			array_push($resultado, $equipos[$mitad-1]."***".$equipos[$mitad]);	
		} else {
			if ($k == (count($equipos)/2)-1) {
				array_push($resultado, $equipos[0]."***".$equipos[(count($equipos))-1]);	
			} else {
				array_push($resultado, $equipos[$k]."***".$equipos[(count($equipos))-1 - $k]);	
			}
		}
}

//print_r($resultado);

$fechainicio = '2017-02-23';
// dia que se juega los partidos
$resDias = 2;

// dia que ponen para comenzar el torneo
$numeroDia = 4;
/*
if (mysql_num_rows($resDias)>0) {
	if ($numeroDia >= mysql_result($resDias,0,'refdias')) {
		$nuevoNumero = 7 - $numeroDia + $resDias;
	}
}
*/

$fecha = date_create('2017-02-23');



	if ($numeroDia >= $resDias) {
		$nuevoNumero = 7 - $numeroDia + $resDias;
		
		date_add($fecha, date_interval_create_from_date_string('-'.$nuevoNumero.' days'));
	}
	
echo date_format($fecha, 'Y-m-d');

?>