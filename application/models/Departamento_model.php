<?php

/* ------------------------------------------------
  ARCHIVO: Departamento_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes al Departamento.
 * 
  ------------------------------------------------ */

class Departamento_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function sel_departamento(){
      $query = $this->db->query(" SELECT d.id, d.nombre_departamento, d.id_jefedepartamento, d.activo,
                                         e.nombre_empleado
                                  FROM departamento d
                                  LEFT JOIN empleado e on e.id_empleado = d.id_jefedepartamento
                                  ORDER BY d.nombre_departamento");
      $result = $query->result();
      return $result;
    }

    public function sel_departamento_id($departamento){
      $query = $this->db->query("SELECT id, nombre_departamento, id_jefedepartamento, activo
                                   FROM departamento WHERE id = $departamento");
      $result = $query->result();
      return $result[0];
    }

    public function upd_departamento($departamento, $nombre, $idjefe, $activo){
      if (($idjefe == NULL) || ($idjefe == '')) { $idjefe = 'NULL'; }
      $query = $this->db->query(" UPDATE departamento SET 
                                    nombre_departamento = '$nombre', 
                                    id_jefedepartamento = $idjefe,
                                    activo = $activo
                                   WHERE id_departamento = $departamento");
    }

    public function add_departamento($nombre, $idjefe, $activo){
      $query = $this->db->query("INSERT INTO departamento (nombre_departamento, id_jefedepartamento, activo)
                                   VALUES('$nombre', $idjefe, $activo);");
    }

    public function candel_departamento($departamento){
      $query = $this->db->query("SELECT count(*) as cant FROM empleado WHERE id_departamento = $departamento");
      $result = $query->result();
/*      if ($result[0]->cant == 0){
        $query = $this->db->query("SELECT count(*) as cant FROM caja_efectivo WHERE id_puntoemision = $puntoemision");
        $result = $query->result();
      }*/
      if ($result[0]->cant == 0)
        { return 1; }
      else
        { return 0; }
    }

    public function del_departamento($departamento){
      if ($this->candel_departamento($departamento) == 1){
        $query = $this->db->query("DELETE FROM departamento WHERE id = $departamento");
        return 1;
      } else {
        return 0;
      }
    }

    public function lst_empleado($departamento = 0){
      $query = $this->db->query("SELECT id_empleado, nombre_empleado
                                  FROM empleado WHERE id_departamento=$departamento AND perfil = 2 AND activo = 1
                                  ORDER BY nombre_empleado");
      $r = $query->result();
      return $r;
    }

}
