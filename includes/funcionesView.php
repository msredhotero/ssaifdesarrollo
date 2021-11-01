<?php

date_default_timezone_set('America/Buenos_Aires');

class ServiciosView {


	function traerUsuariosAjax($length, $start, $busqueda,$colSort,$colSortDir) {

	   $where = '';

			$busqueda = str_replace("'","",$busqueda);
			if ($busqueda != '') {
				$where = " and u.usuario like '%".$busqueda."%' or r.descripcion like '%".$busqueda."%' or u.email like '%".$busqueda."%' or cou.nombre like '%".$busqueda."%'";
			}

	   $sql = "select u.idusuario,u.usuario, u.password, r.descripcion, u.email , u.nombrecompleto, cou.nombre, u.refroles,u.idusuario
			from dbusuarios u
			inner join tbroles r on u.refroles = r.idrol
			left join dbcountries cou on cou.idcountrie = u.refcountries
			where r.idrol <> 1 ".$where." 
	      ORDER BY ".$colSort." ".$colSortDir." ";
	      $limit = "limit ".$start.",".$length;
	    //die(var_dump( $sql));
	   $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
      return $res;
	}


	function traerUsuariosSimpleAjax($length, $start, $busqueda,$colSort,$colSortDir) {

	   $where = '';

			$busqueda = str_replace("'","",$busqueda);
			if ($busqueda != '') {
				$where = " where u.usuario like '%".$busqueda."%' or r.descripcion like '%".$busqueda."%' or u.email like '%".$busqueda."%' or cou.nombre like '%".$busqueda."%'";
			}

	   $sql = "select u.idusuario,u.usuario, u.password, r.descripcion, u.email , u.nombrecompleto, cou.nombre, u.refroles,u.idusuario
			from dbusuarios u
			inner join tbroles r on u.refroles = r.idrol
			left join dbcountries cou on cou.idcountrie = u.refcountries
			".$where." 
	      ORDER BY ".$colSort." ".$colSortDir." ";
	      $limit = "limit ".$start.",".$length;
	    //die(var_dump( $sql));
	   $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
      	return $res;
	}



	function traerArbitrosAjax($length, $start, $busqueda,$colSort,$colSortDir) {

	   $where = '';

			$busqueda = str_replace("'","",$busqueda);
			if ($busqueda != '') {
				$where = "where a.nombrecompleto like '%".$busqueda."%' or a.telefonoparticular like '%".$busqueda."%' or a.telefonoceleluar like '%".$busqueda."%' or a.email like '%".$busqueda."%' or a.telefonofamiliar like '%".$busqueda."%'";
			}

	   $sql = "select
	   a.idarbitro,
	   a.nombrecompleto,
	   a.telefonoparticular,
	   a.telefonoceleluar,
	   a.telefonolaboral,
	   a.telefonofamiliar,
	   a.email,
	   u.nombrecompleto
	   from dbarbitros a
	   left join dbusuarios u on u.idusuario = a.refusuarios
	   ".$where."
	      ORDER BY ".$colSort." ".$colSortDir." ";
	      $limit = "limit ".$start.",".$length;

	   //$res = $this->query($sql,0);
	   //die(var_dump( $sql));
	   $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
      return $res;
	}



function query($sql,$accion) {



        require_once 'appconfig.php';

        $appconfig  = new appconfig();
        $datos      = $appconfig->conexion();
        $hostname   = $datos['hostname'];
        $database   = $datos['database'];
        $username   = $datos['username'];
        $password   = $datos['password'];

        $conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());

        mysql_select_db($database);

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