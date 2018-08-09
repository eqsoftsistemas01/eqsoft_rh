<?php

/* ------------------------------------------------
  ARCHIVO: Provincia_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes al Provincia.
 * 
  ------------------------------------------------ */

class Provincia_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function sel_provincia(){
      $query = $this->db->query(" SELECT c.id, c.nombre_provincia, c.id_pais, c.activo, p.nombre_pais
                                  FROM provincia c
                                  LEFT JOIN paises p on p.id = c.id_pais
                                  ORDER BY c.nombre_provincia");
      $result = $query->result();
      return $result;
    }

    public function sel_provincia_id($provincia){
      $query = $this->db->query("SELECT id, nombre_provincia, id_pais, activo
                                   FROM provincia WHERE id = $provincia");
      $result = $query->result();
      return $result[0];
    }

    public function upd_provincia($provincia, $nombre, $pais, $activo){
      if ((!$pais) || (trim($pais) == '')) { $pais = 'NULL'; }
     
      $query = $this->db->query(" UPDATE provincia SET 
                                    nombre_provincia = '$nombre', 
                                    id_pais = $pais,
                                    activo = $activo
                                   WHERE id = $provincia");
    }

    public function add_provincia($nombre, $pais, $activo){
      if ((!$pais) || (trim($pais) == '')) { $pais = 'NULL'; }
      $query = $this->db->query("INSERT INTO provincia (nombre_provincia, id_pais, activo)
                                   VALUES('$nombre', $pais, $activo);");
    }

    public function candel_provincia($provincia){
      $query = $this->db->query("SELECT count(*) as cant FROM ciudad WHERE id_provincia = $provincia");
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

    public function del_provincia($provincia){
      if ($this->candel_provincia($provincia) == 1){
        $query = $this->db->query("DELETE FROM provincia WHERE id = $provincia");
        return 1;
      } else {
        return 0;
      }
    }

    public function lst_pais(){
      $query = $this->db->query("SELECT id, nombre_pais
                                  FROM paises WHERE activo = 1
                                  ORDER BY nombre_pais");
      $r = $query->result();
      return $r;
    }

}
