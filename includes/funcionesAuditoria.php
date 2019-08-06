<?php

/**
 * @author www.intercambiosvirtuales.org
 * @copyright 2013
 */
date_default_timezone_set('America/Buenos_Aires');

class serviciosAuditoria {

   function traerAuditoriaPorIdGral($token) {
   $sql = "select
   a.idauditoria,
   a.tabla,
   a.operacion,
   a.campo,
   a.valornuevo,
   a.valorviejo,
   a.id,
   a.usuario,
   a.fecha,
   a.token
   from dbauditoria a
   where a.token = '".$token."'
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerAuditoriaPorId($id) {
   $sql = "select idauditoria,tabla,operacion,campo,valornuevo,valorviejo,id,usuario,fecha,token from dbauditoria where idauditoria =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function traerAuditoriaGral($tabla) {
      $sql = "
            SELECT
                a.idauditoria as id,
                (CASE
                    WHEN a.operacion = 'E' THEN 'Se elimino '
                    WHEN a.operacion = 'I' THEN 'Se agrego '
                    WHEN a.operacion = 'M' THEN 'Se modifico '
                END) AS operacion,
                (CASE
                    WHEN a.operacion = 'E' THEN 'danger'
                    WHEN a.operacion = 'I' THEN 'success'
                    WHEN a.operacion = 'M' THEN 'warning'
                END) AS color,
                (CASE
                    WHEN a.operacion = 'E' THEN 'remove'
                    WHEN a.operacion = 'I' THEN 'ok'
                    WHEN a.operacion = 'M' THEN 'edit'
                END) AS icon,
                (CASE
                    when a.campo = 'todos refjugadores' and a.tabla = 'dbjugadoresdocumentacion' THEN 'proceso masivo sobre las documentaciones'
                    when a.campo = 'todos refjugadores' and a.tabla = 'dbjugadoresvaloreshabilitacionestransitorias' THEN 'proceso masivo sobre las documentaciones valores'
                    WHEN a.tabla = 'dbdocumentacionjugadorimagenes' THEN 'un archivo documentacion del jugador'
                    WHEN a.tabla = 'dbjugadores' THEN 'un jugador'
                    WHEN a.tabla = 'dbconector' THEN 'un jugador de un equipo'
                    WHEN a.tabla = 'dbjugadoresdocumentacion' THEN 'una documentacion del jugador'
                    WHEN a.tabla = 'dbjugadoresvaloreshabilitacionestransitorias' THEN 'una documentacion valor del jugador'
                END) AS leyenda,
                a.id AS idtabla,
                a.fecha,
                a.usuario
            FROM
                dbauditoria a
            WHERE
                (((a.campo LIKE '%idjugador%'
                    OR a.campo LIKE '%refjugadores%')
                    AND (a.valornuevo = ".$idjugador."
                    OR a.valorviejo = ".$idjugador.")) or (a.campo LIKE '%todos refjugadores%' and id = ".$idjugador."))
                    and a.visible = 1
         ORDER BY a.fecha desc
         LIMIT 30";

      $res = $this->query($sql,0);
      return $res;
   }

   function jugadoresHabilitados($fechadesde, $fechashasta, $idcountrie) {

      $cadWhere = '';

      if ($idcountrie != 0) {
         $cadWhere .= ' where j.refcountries = '.$idCountrie;
      }

      $sql = "SELECT
                  j.idjugador,
                  j.nrodocumento,
                  j.apellido,
                  j.nombres,
                  '' as token,
                  jh.observacion AS leyenda,
                  jh.fecha,
                  'warning' AS color,
                  'edit' AS icon,
                  jh.usuario,
                  'Estado Habilitacion' AS operacion,
                  1 AS orden
            FROM
                dbjugadoreshabilitados jh
                    INNER JOIN
                dbjugadores j ON j.idjugador = jh.refjugadores
                    INNER JOIN
                dbequipos e ON e.idequipo = jh.refequipos ".$cadWhere;

      $res = $this->query($sql,0);

      return $res;
   }

   function traerUltimaTemporada() {
      $sql = "select
      t.idtemporadas,
      t.temporada
      from tbtemporadas t
      order by 1 desc
      limit 1";

      $res = $this->query($sql,0);
      return $res;
   }

   function auditoriaFiltros($idfiltro, $idcountrie, $fechadesde, $fechahasta, $nombrecompleto) {

      $resTemporadas = $this->traerUltimaTemporada();

      if (mysql_num_rows($resTemporadas)>0) {
          $ultimaTemporada = mysql_result($resTemporadas,0,0);
      } else {
          $ultimaTemporada = 0;
      }

      $cadTablas = '';
      $cadHabilitados = 0;

      $cadWhere = '';
      $cadWhereAux = '';

      if ($idcountrie != 0) {
         $cadWhere .= ' and j.refcountries = '.$idcountrie;
      }

      if ($nombrecompleto != '') {

         $cadWhereAux .= " and usuario like '%".$nombrecompleto."%'";
      }

      switch ($idfiltro) {
         case 0:
            $cadTablas = "and a.tabla in ('dbjugadores', 'dbconector', 'dbjugadoresdocumentacion', 'dbjugadoresvaloreshabilitacionestransitorias','dbdocumentacionjugadorimagenes')";
            $cadHabilitados = 1;
         break;
         case 1:
            $cadTablas = "and a.tabla in ('dbjugadoresdocumentacion')";
            $cadHabilitados = 0;
         break;
         case 2:
            $cadTablas = "and a.tabla =''";
            $cadHabilitados = 1;
         break;
         case 3:
            $cadTablas = "and a.tabla in ('dbjugadoresdocumentacion')";
            $cadHabilitados = 1;
         break;
         case 4:
            $cadTablas = "and a.tabla in ('dbjugadoresvaloreshabilitacionestransitorias')";
            $cadHabilitados = 0;
         break;
         case 5:
            $cadTablas = "and a.tabla in ('dbjugadoresdocumentacion','dbjugadoresvaloreshabilitacionestransitorias')";
            $cadHabilitados = 1;
         break;
         case 6:
            $cadTablas = "and a.tabla in ('dbjugadoresvaloreshabilitacionestransitorias')";
            $cadHabilitados = 1;
         break;
         case 7:
            $cadTablas = "and a.tabla in ('dbdocumentacionjugadorimagenes')";
            $cadHabilitados = 0;
         break;
         case 8:
            $cadTablas = "and a.tabla in ('dbjugadoresdocumentacion','dbdocumentacionjugadorimagenes')";
            $cadHabilitados = 0;
         break;
         case 9:
            $cadTablas = "and a.tabla in ('dbconector')";
            $cadHabilitados = 0;
         break;
         case 10:
            $cadTablas = "and a.tabla =''";
            $cadHabilitados = 2;
         break;

         default:
            // code...
            break;
      }


      $cadWhereCountry = '';

      if ($idcountrie != 0) {
         $cadWhereCountry .= ' and j.refcountries = '.$idcountrie;
      }

      if ($cadHabilitados == 2) {
         $sql = "select
                  r.idjugador,
                  r.nrodocumento,
                  r.apellido,
                  r.nombres,
                  r.idequipo,
                  r.nombreequipo,
                  '' as token,
                  jhc.observacion AS leyenda,
                  jhc.fecha,
                  (case when jhc.habilitado = 'INHAB.' then 'danger' else 'success' end) AS color,
                  (case when jhc.habilitado = 'INHAB.' then 'remove' else 'ok' end) AS icon,
                  jhc.usuario,
                  jhc.habilitado AS operacion,
                  1 AS orden,
                  0 as id
                  from (
                  	SELECT
                  		j.idjugador,
                  		j.nrodocumento,
                  		j.apellido,
                  		j.nombres,
                  		e.idequipo,
                  		concat(e.nombre,' ',cat.categoria,' ',di.division) as nombreequipo,
                  		max(jh.idjugadorhabilitado) as id
                  	FROM
                  		dbjugadoreshabilitados jh
                  			INNER JOIN
                  		dbjugadores j ON j.idjugador = jh.refjugadores
                  			INNER JOIN
                  		dbequipos e ON e.idequipo = jh.refequipos
                           INNER join
                      tbcategorias cat ON cat.idtcategoria = e.refcategorias
                          INNER JOIN
                      tbdivisiones di ON di.iddivision = e.refdivisiones
                  	WHERE
                  		jh.fecha >= '".$fechadesde."' and jh.fecha <= '".$fechahasta."' ".$cadWhereCountry."
                  	group by j.idjugador,
                  		j.nrodocumento,
                  		j.apellido,
                  		j.nombres,
                  		e.idequipo,
                  		e.nombre,cat.categoria,di.division
                  	having count(DISTINCT jh.habilitado) > 1
                      ) r
                      inner join dbjugadoreshabilitados jhc on jhc.idjugadorhabilitado = r.id
                       ".$cadWhereAux."
                  UNION All
                  SELECT
                  	r.idjugador,
                  	r.nrodocumento,
                  	r.apellido,
                  	r.nombres,
                  	r.idequipo,
                  	r.nombreequipo,
                  	'' as token,
                  	jhc.observacion AS leyenda,
                  	jhc.fecha,
                  	(case when jhc.habilitado = 'INHAB.' then 'danger' else 'success' end) AS color,
                  	(case when jhc.habilitado = 'INHAB.' then 'remove' else 'ok' end) AS icon,
                  	jhc.usuario,
                  	jhc.habilitado AS operacion,
                  	1 AS orden,
                  	0 as id
                  FROM
                      (SELECT
                          j.idjugador,
                              j.nrodocumento,
                              j.apellido,
                              j.nombres,
                              e.idequipo,
                              concat(e.nombre,' ',cat.categoria,' ',di.division) as nombreequipo,
                              MAX(jh.idjugadorhabilitado) AS id
                      FROM
                          dbjugadoreshabilitados jh
                      INNER JOIN dbjugadores j ON j.idjugador = jh.refjugadores
                      INNER JOIN dbequipos e ON e.idequipo = jh.refequipos
                      INNER join
                        tbcategorias cat ON cat.idtcategoria = e.refcategorias
                      INNER JOIN
                        tbdivisiones di ON di.iddivision = e.refdivisiones
                      WHERE
                          jh.fecha >= '".$fechadesde."'
                              AND jh.fecha <= '".$fechahasta."' ".$cadWhereCountry."
                      GROUP BY j.idjugador , j.nrodocumento , j.apellido , j.nombres , e.idequipo , e.nombre
                              ,cat.categoria,di.division
                      HAVING COUNT(DISTINCT jh.habilitado) = 1) r
                          LEFT JOIN
                      (SELECT
                          j.idjugador,
                              j.nrodocumento,
                              j.apellido,
                              j.nombres,
                              e.idequipo,
                              e.nombre AS nombreequipo,
                              MAX(jh.habilitado) AS habilitado,
                              MAX(jh.idjugadorhabilitado) AS id
                      FROM
                          dbjugadoreshabilitados jh
                      INNER JOIN dbjugadores j ON j.idjugador = jh.refjugadores
                      INNER JOIN dbequipos e ON e.idequipo = jh.refequipos
                      WHERE
                          jh.fecha < '".$fechadesde."' ".$cadWhereCountry."
                              AND jh.refjugadores IN (SELECT
                                  j.idjugador
                              FROM
                                  dbjugadoreshabilitados jh
                              INNER JOIN dbjugadores j ON j.idjugador = jh.refjugadores
                              WHERE
                                  jh.fecha >= '".$fechadesde."'
                                      AND jh.fecha <= '".$fechahasta."' ".$cadWhereCountry."
                              GROUP BY j.idjugador
                              HAVING COUNT(DISTINCT jh.habilitado) = 1)
                              AND jh.refequipos IN (SELECT
                                  jh.refequipos
                              FROM
                                  dbjugadoreshabilitados jh
                              INNER JOIN dbjugadores j ON j.idjugador = jh.refjugadores
                              WHERE
                                  jh.fecha >= '".$fechadesde."'
                                      AND jh.fecha <= '".$fechahasta."' ".$cadWhereCountry."
                              GROUP BY jh.refequipos
                              HAVING COUNT(DISTINCT jh.habilitado) = 1)
                      GROUP BY j.idjugador , j.nrodocumento , j.apellido , j.nombres , e.idequipo , e.nombre) t
                      ON t.idjugador = r.idjugador
                          AND t.idequipo = r.idequipo
                  	inner
                      join	dbjugadoreshabilitados jhc
                      on		jhc.idjugadorhabilitado = r.id
                      where	jhc.habilitado <> t.habilitado ".$cadWhereAux."";
      } else {


         if ($cadHabilitados == 1) {


            $sqlHabilitados = "union all SELECT
                     j.idjugador,
                     j.nrodocumento,
                     j.apellido,
                     j.nombres,
                     '' as token,
                     jh.observacion AS leyenda,
                     jh.fecha,
                     (case when habilitado = 'INHAB.' then 'danger' else 'success' end) AS color,
                     (case when habilitado = 'INHAB.' then 'remove' else 'ok' end) AS icon,
                     jh.usuario,
                     habilitado AS operacion,
                     1 AS orden,
                     e.idequipo,
                     concat(e.nombre,' ',cat.categoria,' ',di.division) as nombreequipo,
                     0 as id
                  FROM
                      dbjugadoreshabilitados jh
                          INNER JOIN
                      dbjugadores j ON j.idjugador = jh.refjugadores
                          INNER JOIN
                      dbequipos e ON e.idequipo = jh.refequipos
                         INNER join
                     tbcategorias cat ON cat.idtcategoria = e.refcategorias
                         INNER JOIN
                     tbdivisiones di ON di.iddivision = e.refdivisiones
                      where jh.fecha >= '".$fechadesde."' and jh.fecha <= '".$fechahasta."' ".$cadWhereCountry.$cadWhereAux;
         } else {
            $sqlHabilitados = '';
         }

         $sql = "select
               r.idjugador,
               r.nrodocumento,
               r.apellido,
               r.nombres,
               r.token,
               r.leyenda,
               r.fecha,
               r.color,
               r.icon,
               r.usuario,
               r.operacion,
               r.orden,
               r.idequipo,
               r.nombreequipo,
               r.id

               from (SELECT
                   j.idjugador,
                   j.nrodocumento,
                   j.apellido,
                   j.nombres,
                   t.token,
                   t.leyenda,
                   t.fecha,
                   t.color,
                   t.icon,
                   t.usuario,
                   t.operacion,
                   t.orden,
                   0 as idequipo,
                   '' as nombreequipo,
                   t.id
               FROM
                   (SELECT
                       a.token,
                           COALESCE(a.valornuevo, a.valorviejo) AS idjugador,
                           a.tabla,
                           (CASE
                               WHEN a.operacion = 'E' THEN 'Se elimino '
                               WHEN a.operacion = 'I' THEN 'Se agrego '
                               WHEN a.operacion = 'M' THEN 'Se modifico '
                           END) AS operacion,
                           (CASE
                               WHEN a.operacion = 'E' THEN 'danger'
                               WHEN a.operacion = 'I' THEN 'success'
                               WHEN a.operacion = 'M' THEN 'warning'
                           END) AS color,
                           (CASE
                               WHEN a.operacion = 'E' THEN 'remove'
                               WHEN a.operacion = 'I' THEN 'ok'
                               WHEN a.operacion = 'M' THEN 'edit'
                           END) AS icon,
                           (CASE
                               WHEN
                                   a.campo = 'todos refjugadores'
                                       AND a.tabla = 'dbjugadoresdocumentacion'
                               THEN
                                   'proceso masivo sobre las documentaciones'
                               WHEN
                                   a.campo = 'todos refjugadores'
                                       AND a.tabla = 'dbjugadoresvaloreshabilitacionestransitorias'
                               THEN
                                   'proceso masivo sobre las documentaciones valores'
                               WHEN a.tabla = 'dbdocumentacionjugadorimagenes' THEN 'un archivo documentacion del jugador'
                               WHEN a.tabla = 'dbjugadores' THEN 'un jugador'
                               WHEN a.tabla = 'dbconector' THEN 'un jugador de un equipo'
                               WHEN a.tabla = 'dbjugadoresdocumentacion' THEN 'una documentacion del jugador'
                               WHEN a.tabla = 'dbjugadoresvaloreshabilitacionestransitorias' THEN 'una documentacion valor del jugador'
                           END) AS leyenda,
                           MAX(a.fecha) AS fecha,
                           a.usuario,
                           0 as orden,
                           MAX(a.idauditoria) AS id
                   FROM
                       dbauditoria a
                   WHERE
                       (a.campo LIKE 'idjugador'
                           OR a.campo LIKE 'refjugadores')
                           AND a.campo <> 'todos refjugadores'
                           ".$cadTablas."
                           AND a.token IS NOT NULL
                           and a.fecha >= '".$fechadesde."' and a.fecha <= '".$fechahasta."' ".$cadWhereAux."
                   GROUP BY a.token , COALESCE(a.valornuevo, a.valorviejo) , a.tabla , a.operacion , a.campo, a.usuario) t
                       INNER JOIN
                   dbjugadores j ON j.idjugador = CAST(t.idjugador AS UNSIGNED) ".$cadWhere."
                    ".$sqlHabilitados." ) r
                      LEFT JOIN
                      dbconector c ON c.refjugadores = r.idjugador
                          AND c.activo = 1
                          AND c.reftemporadas = ".$ultimaTemporada."
                          LEFT JOIN
                      dbequipos e ON e.idequipo = c.refequipos
                          LEFT JOIN
                      tbcategorias cat ON cat.idtcategoria = e.refcategorias
                          LEFT JOIN
                      tbdivisiones di ON di.iddivision = e.refdivisiones
            			order by r.fecha desc
                     Limit 200";

      }

      //die(var_dump($sql));
      $res = $this->query($sql,0);

      return $res;

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
		mysql_query("SET NAMES 'utf8'");
		        $error = 0;
		mysql_query("BEGIN");
		$result=mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysql_query("ROLLBACK");
			return false;
		}
		 else{
			mysql_query("COMMIT");
			return $result;
		}

	}












	}

?>
