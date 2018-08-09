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
      $query = $this->db->query(" SELECT c.id, c.nombre_ciudad, c.id_provincia, c.activo, p.nombre_provincia
                                  FROM ciudad c
                                  LEFT JOIN provincia p on p.id = c.id_provincia
                                  ORDER BY c.nombre_ciudad");
      $result = $query->result();
      return $result;
    }

    public function sel_ciudad_id($ciudad){
      $query = $this->db->query("SELECT id, nombre_ciudad, id_provincia, activo
                                   FROM ciudad WHERE id = $ciudad");
      $result = $query->result();
      return $result[0];
    }

    public function upd_ciudad($ciudad, $nombre, $provincia, $activo){
      if ((!$provincia) || (trim($provincia) == '')) { $provincia = 'NULL'; }
     
      $query = $this->db->query(" UPDATE ciudad SET 
                                    nombre_ciudad = '$nombre', 
                                    id_provincia = $provincia,
                                    activo = $activo
                                   WHERE id = $ciudad");
    }

    public function add_ciudad($nombre, $provincia, $activo){
      if ((!$provincia) || (trim($provincia) == '')) { $provincia = 'NULL'; }
      $query = $this->db->query("INSERT INTO ciudad (nombre_ciudad, id_provincia, activo)
                                   VALUES('$nombre', $provincia, $activo);");
    }

    public function candel_ciudad($ciudad){
      $query = $this->db->query("SELECT count(*) as cant FROM ciudad WHERE id = $ciudad");
      $result = $query->result();
/*      if ($result[0]->cant == 0){
        $query = $this->db->query("SELECT count(*) as cant FROM caja_efectivo WHERE id_puntoemision = $puntoemision");
        $result = $query->result();
      }*/
/*      if ($result[0]->cant == 0)
        { return 1; }
      else
        { return 0; }*/

        return 1;
    }

    public function del_ciudad($ciudad){
      if ($this->candel_ciudad($ciudad) == 1){
        $query = $this->db->query("DELETE FROM ciudad WHERE id = $ciudad");
        return 1;
      } else {
        return 0;
      }
    }

    public function lst_provincia(){
      $query = $this->db->query("SELECT id, nombre_provincia
                                  FROM provincia WHERE activo = 1
                                  ORDER BY nombre_provincia");
      $r = $query->result();
      return $r;
    }

}
