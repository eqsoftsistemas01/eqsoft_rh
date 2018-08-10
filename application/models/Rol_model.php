<?php

/* ------------------------------------------------
  ARCHIVO: Rol_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la Rol.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */

class Rol_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function lst_tipocuentabanco() {
        $query = $this->db->query("SELECT id, tipocuentabanco FROM tipocuentabanco;");
        $result = $query->result();
        return $result;
    }

    /* lista de empleados */
    public function lst_roles() {
        $query = $this->db->query("SELECT e.id_empleado, e.nombres, e.apellidos, e.nro_ident, e.tipo_identificacion, 
                                          e.perfil, e.telf_empleado, e.correo_empleado, 
                                          e.activo, e.id_departamento, i.desc_identificacion, d.nombre_departamento
                                     FROM empleado e
                                     INNER JOIN identificacion i on i.id_identificacion = e.tipo_identificacion
                                     LEFT JOIN departamento d on d.id = e.id_departamento
                                     ORDER BY e.apellidos, e.nombres;");
        $result = $query->result();
        return $result;
    }

}
