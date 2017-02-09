
<?php

date_default_timezone_set('America/Buenos_Aires');

class GenerarFixture {

function traerEquipoPorId($id) {

		$sql		=	"
			select 
				tge.refGrupo,
				g.nombre,
				tge.IdTorneoGE,
				tge.refequipo,
				e.Nombre,
				h.horario,
				tge.prioridad,
				tp.valor
			from
				dbtorneoge tge
					inner join
				dbturnosequiposprioridad tp ON tge.IdTorneoGE = tp.reftorneoge
					inner join
				dbequipos e ON e.IdEquipo = tge.refequipo
					inner join
				dbgrupos g ON g.IdGrupo = tge.refgrupo
					inner join
				tbhorarios h ON h.idhorario = tp.refturno
			where tge.refequipo = ".$id."
			order by g.nombre  , tp.valor desc , tge.prioridad desc

				";

	
	$res = query($sql,0);
	if (mysql_num_rows($res)>0) {
		return $res;
	}
	return 0;
}

//acordar de pasarle la division
function traerEquipos($idtorneo) {

		$sql		=	"
			select
				e.nombre, e.idequipo
			from		dbtorneos t
			inner
			join		dbequipos e
			on			t.refcategorias = e.refcategorias and t.refdivisiones = e.refdivisiones
			where		t.activo = 1 and e.activo = 1 and t.reftemporadas = 1 and t.idtorneo = ".$idtorneo." 
			order by e.nombre";

	
	$res2 = $this->query($sql,0);
//echo $sql;
	return $res2;
}

//acordar de pasarle la division
function devolverCantFilas($idtorneo) {
	$equipo = $this->traerEquipos($idtorneo);
	
	$cadFixture = '';
	$arEquipos = array();
	$arEquiposId = array();
	
	if ((mysql_num_rows($equipo)%2) == 1) {
		$cantidadEquipos = mysql_num_rows($equipo)+1;
		for ($p=0;$p<mysql_num_rows($equipo);$p++) {
			$arEquipos[$p] = mysql_result($equipo,$p,0);
			$arEquiposId[$p] = mysql_result($equipo,$p,1);
		}
		$arEquipos[$cantidadEquipos-1] = "borrar";
		$arEquiposId[$cantidadEquipos-1] = 0;
	} else {
		$cantidadEquipos = mysql_num_rows($equipo);
		for ($p=0;$p<mysql_num_rows($equipo);$p++) {
			$arEquipos[$p] = mysql_result($equipo,$p,0);
			$arEquiposId[$p] = mysql_result($equipo,$p,1);
		}
	}
	
	//var_dump($arEquipos);
	
	
	
	$columnas	= $cantidadEquipos - 1;
	$filas		= $cantidadEquipos / 2;
	
	return array("columnas"=>$columnas,"filas"=> $filas);
}


//acordar de pasar la division
function TraerTodoFixture($idtorneo) {
		$sql = "select
					f.idfixture,
					el.nombre as equipolocal,
					f.puntoslocal,
					f.puntosvisita,
					ev.nombre as equipovisitante,
					ca.categoria,
					arb.nombrecompleto as arbitro,
					f.juez1,
					f.juez2,
					can.nombre as canchas,
					fec.fecha,
					f.fecha,
					f.hora,
					est.descripcion as estado,
					f.calificacioncancha,
					f.goleslocal,
					f.golesvisitantes,
					f.observaciones,
					f.publicar,
					f.refcanchas,
					f.reftorneos,
					f.reffechas,
					f.refconectorlocal,
					f.refconectorvisitante,
					f.refestadospartidos,
					f.refarbitros
				from dbfixture f
				inner join dbtorneos tor ON tor.idtorneo = f.reftorneos
				inner join tbtipotorneo ti ON ti.idtipotorneo = tor.reftipotorneo
				inner join tbtemporadas te ON te.idtemporadas = tor.reftemporadas
				inner join tbcategorias ca ON ca.idtcategoria = tor.refcategorias
				inner join tbdivisiones di ON di.iddivision = tor.refdivisiones
				inner join tbfechas fec ON fec.idfecha = f.reffechas
				inner join dbconector conl ON conl.idconector = f.refconectorlocal
				inner join dbequipos el ON el.idequipo = conl.refequipos
				inner join dbconector conv ON conv.idconector = f.refconectorvisitante
				inner join dbequipos ev ON ev.idequipo = conv.refequipos
				inner join dbarbitros arb ON arb.idarbitro = f.refarbitros
				inner join tbcanchas can ON can.idcancha = f.refcanchas
				left join tbestadospartidos est ON est.idestadopartido = f.refestadospartidos
				where tor.idtorneo =".$idtorneo;
		 return $this-> query($sql,0);
	}

function Generar($idtorneo) {
	$equipo = $this->traerEquipos($idtorneo);
	//acordar de pasarle la division
	$res = $this->TraerTodoFixture($idtorneo);

$cadFixture = '';
$arEquipos = array();
$arEquiposId = array();

if ((mysql_num_rows($equipo)%2) == 1) {
	$cantidadEquipos = mysql_num_rows($equipo)+1;
	for ($p=0;$p<mysql_num_rows($equipo);$p++) {
		$arEquipos[$p] = mysql_result($equipo,$p,0);
		$arEquiposId[$p] = mysql_result($equipo,$p,1);
	}
	$arEquipos[$cantidadEquipos-1] = "borrar";
	$arEquiposId[$cantidadEquipos-1] = 0;
} else {
	$cantidadEquipos = mysql_num_rows($equipo);
	for ($p=0;$p<mysql_num_rows($equipo);$p++) {
		$arEquipos[$p] = mysql_result($equipo,$p,0);
		$arEquiposId[$p] = mysql_result($equipo,$p,1);
	}
}

//die(var_dump($arEquiposId));
//die(var_dump($cantidadEquipos));

/*
$columnas	= $cantidadEquipos - 1;
$filas		= $cantidadEquipos / 2;
*/
$columnas	= 5;
$filas		= 3;
//die(var_dump($columnas."-".$filas));

$fixture = array();

$fixtureNum = array();

//if (mysql_num_rows($res)<1) {

$k = $cantidadEquipos;
$m = 2;

for ($i=1;$i<=$filas;$i++) {
	echo $i;
	$m = $i + 1;

	if ($i >2) {
		$k = $k - 1;
	}

	for ($j=1;$j<=$columnas;$j++) {
		
		if (($i == 1) && ($j == 1)) {
			$fixture[$i-1][$j-1] = $arEquipos[0]."***".$arEquipos[1]."***".$arEquiposId[0]."***".$arEquiposId[1];
			$fixtureNum[$i-1][$j-1] = "1***2";

		} else {
			if ($i == 1) {

				$fixture[$i-1][$j-1] = $arEquipos[0]."***".$arEquipos[$cantidadEquipos+1-$j]."***".$arEquiposId[0]."***".$arEquiposId[$cantidadEquipos+1-$j];
					
			} else {

				$fixture[$i-1][$j-1] = $arEquipos[$k-1]."***".$arEquipos[$m-1]."***".$arEquiposId[$k-1]."***".$arEquiposId[$m-1];
				$fixtureNum[$i-1][$j-1] = ($k)."***".($m);
				$k = $k - 1;
				
					
				if ($k < 2) {
					$k = $cantidadEquipos;	
				}
				
				$m = $m - 1;

				if ($m < 2) {
					$m = $cantidadEquipos;	
				}
				
				
			}
		}
		
		
	}	
//}

}
//die(var_dump($fixture));
return $fixture;

}



function Generar360($idtorneo) {
	$equipo = $this->traerEquipos($idtorneo);

	$res = $this->TraerTodoFixture($idtorneo);

$cadFixture = '';
$arEquipos = array();
$arEquiposId = array();

if ((mysql_num_rows($equipo)%2) == 1) {
	$cantidadEquipos = mysql_num_rows($equipo)+1;
	for ($p=0;$p<mysql_num_rows($equipo);$p++) {
		$arEquipos[$p] = mysql_result($equipo,$p,0);
		$arEquiposId[$p] = mysql_result($equipo,$p,1);
	}
	$arEquipos[$cantidadEquipos-1] = "borrar";
	$arEquiposId[$cantidadEquipos-1] = 0;
} else {
	$cantidadEquipos = mysql_num_rows($equipo);
	for ($p=0;$p<mysql_num_rows($equipo);$p++) {
		$arEquipos[$p] = mysql_result($equipo,$p,0);
		$arEquiposId[$p] = mysql_result($equipo,$p,1);
	}
}

//die(var_dump($arEquipos));
//die(var_dump($cantidadEquipos));

//die(var_dump($arEquipos));
$columnas	= $cantidadEquipos - 1;
$filas		= $cantidadEquipos / 2;

//die(var_dump($columnas."-".$filas));

$fixture = array();

$fixtureNum = array();

//if (mysql_num_rows($res)<1) {

$k = $cantidadEquipos;
$m = 1;


//ok
for ($i=1;$i<=$columnas;$i++) {


	for ($j=1;$j<=$filas;$j++) {
		$fixture[$i-1][$j-1] = $arEquipos[$m-1]."***".$arEquiposId[$m-1];
		$fixtureNum[$i-1][$j-1] = $arEquiposId[$m-1];
		
		if ($m == ($cantidadEquipos-1)) {
			$m = 0;	
		}
		
		$m += 1;
	}
		
		
}	


//ok
for ($j=1;$j<=$columnas;$j++) {

	$fixture[$j-1][0] .= "***".$arEquipos[$cantidadEquipos - 1]."***".$arEquiposId[$cantidadEquipos - 1];
	$fixtureNum[$j-1][0] .= "***".$arEquiposId[$cantidadEquipos - 1];

	
}

	

$m = $cantidadEquipos - 1;

for ($i=1;$i<=$columnas;$i++) {


	for ($j=2;$j<=$filas;$j++) {
		$fixture[$i-1][$j-1] .= "***".$arEquipos[$m-1]."***".$arEquiposId[$m-1];
		$fixtureNum[$i-1][$j-1] .= "***".$arEquiposId[$m-1];
		
		if ($m == 1) {
			if (($cantidadEquipos % 2)==0) {
				$m = $cantidadEquipos;	
			} else {
				$m = $cantidadEquipos - 1;	
			}
		}
		
		$m -= 1;
		
	}
		
		
}	


//die(var_dump($fixture));
return $fixture;

}

function query($sql,$accion) {
	
	require_once 'appconfig.php';

	$appconfig	= new appconfig();
	$datos		= $appconfig->conexion();
	$hostname	= $datos['hostname'];
	$database	= $datos['database'];
	$username	= $datos['username'];
	$password	= $datos['password'];
	
	
	$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());
	
	mysql_select_db($database);
	
	$result = mysql_query($sql,$conex);
	if ($accion && $result) {
		$result = mysql_insert_id();
	}
	mysql_close($conex);
	return $result;
	
}


}
?>
</body>
</html>