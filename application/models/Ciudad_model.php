<?php

/* ------------------------------------------------
  ARCHIVO: Departamento_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes al ciudad.
 * 
  ------------------------------------------------ */

class Ciudad_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function sel_ciudad(){
      $query = $this->db->query(" SELECT c.id, c.nombre_ciudad, c.activo
                                  FROM ciudad c
                                  ORDER BY c.nombre_ciudad");
      $result = $query->result();
      return $result;
    }

    public function sel_ciudad_id($ciudad){
      $query = $this->db->query("SELECT id, nombre_ciudad, activo
                                   FROM ciudad WHERE id = $ciudad");
      $result = $query->result();
      return $result[0];
    }

    public function upd_ciudad($ciudad, $nombre, $activo){
     
      $query = $this->db->query(" UPDATE ciudad SET 
                                    nombre_ciudad = '$nombre', 
                                    activo = $activo
                                   WHERE id_ciudad = $ciudad");
    }

    public function add_ciudad($nombre, $activo){
      $query = $this->db->query("INSERT INTO ciudad (nombre_ciudad, activo)
                                   VALUES('$nombre', $activo);");
    }

    public function candel_ciudad($ciudad){
      $query = $this->db->query("SELECT count(*) as cant FROM ciudad WHERE id_ciudad = $ciudad");
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

    public function del_ciudad($ciudad){
      if ($this->candel_ciudad($ciudad) == 1){
        $query = $this->db->query("DELETE FROM ciudad WHERE id = $ciudad");
        return 1;
      } else {
        return 0;
      }
    }

    public function lst_ciudad($ciudad = 0){
      $query = $this->db->query("SELECT id, nombre_ciudad
                                  FROM ciudad WHERE id_ciudad=$ciudad activo = 1
                                  ORDER BY nombre_ciudad");
      $r = $query->result();
      return $r;
    }

}
