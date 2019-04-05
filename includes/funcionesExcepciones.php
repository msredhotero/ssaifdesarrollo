<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Buenos_Aires');

class ServiciosReferencias {
   /* PARA Excepcionesencancha */

   function insertarExcepcionesencancha($refequipos,$refjugadores,$reftemporadas) {
      $sql = "insert into dbexcepcionesencancha(idexcepcionencancha,refequipos,refjugadores,reftemporadas)
      values ('',".$refequipos.",".$refjugadores.",".$reftemporadas.")";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarExcepcionesencancha($id,$refequipos,$refjugadores,$reftemporadas) {
      $sql = "update dbexcepcionesencancha
      set
      refequipos = ".$refequipos.",refjugadores = ".$refjugadores.",reftemporadas = ".$reftemporadas."
      where idexcepcionencancha =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarExcepcionesencancha($id) {
      $sql = "delete from dbexcepcionesencancha where idexcepcionencancha =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerExcepcionesencancha() {
      $sql = "select
      e.idexcepcionencancha,
      e.refequipos,
      e.refjugadores,
      e.reftemporadas
      from dbexcepcionesencancha e
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerExcepcionesencanchaPorId($id) {
      $sql = "select idexcepcionencancha,refequipos,refjugadores,reftemporadas from dbexcepcionesencancha where idexcepcionencancha =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   /* Fin */
   /* /* Fin de la Tabla: dbexcepcionesencancha*/
}

?>
