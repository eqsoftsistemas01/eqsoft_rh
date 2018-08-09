<?php

/* ------------------------------------------------
  ARCHIVO: Cargos_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes al Cargos.
 * 
  ------------------------------------------------ */

class Cargo_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function sel_cargo(){
      $query = $this->db->query(" SELECT p.id, p.nombre_cargo, p.activo                                        
                                  FROM cargo p                                  
                                  ORDER BY p.nombre_cargo");
      $result = $query->result();
      return $result;
    }

    public function sel_cargo_id($cargo){
      $query = $this->db->query("SELECT id, nombre_cargo, activo
                                   FROM cargo WHERE id = $cargo");
      $result = $query->result();
      return $result[0];
    }

    public function upd_cargo($cargo, $nombre, $activo){
      $query = $this->db->query(" UPDATE cargo SET 
                                    nombre_cargo = '$nombre', 
                                    activo = $activo
                                   WHERE id = $cargo");
    }

    public function add_cargo($nombre,  $activo){
      $query = $this->db->query("INSERT INTO cargo (nombre_cargo, activo)
                                   VALUES('$nombre', $activo);");
    }

    public function candel_cargo($cargo){
      $query = $this->db->query("SELECT count(*) as cant FROM empleado WHERE id_cargo = $cargo");
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

    public function del_cargo($cargo){
      if ($this->candel_cargo($cargo) == 1){
        $query = $this->db->query("DELETE FROM cargo WHERE id = $cargo");
        return 1;
      } else {
        return 0;
      }
    }

}
