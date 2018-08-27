<?php

/* ------------------------------------------------
  ARCHIVO: asistencia_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la asistencia.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */

class Asistenciat_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* lista de empleados */
    public function lst_asistenciat($empleado) {
              $query=$this->db->query("SELECT a.id, a.fecha, a.entrada_trabajo, a.salida_trabajo, 
                                          a.salida_almuerzo, a.entrada_almuerzo, a.codigoreloj,
                                          a.id_empleado, e.nombres, e.apellidos, e.nro_ident
                                     FROM asistencia a
                                     INNER JOIN empleado e on e.id_empleado = a.id_empleado
                                     Where a.id_empleado = '$empleado'
                                     ORDER BY a.fecha;");
    return $query->result();
    }
    

}
