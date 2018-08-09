<?php

/* ------------------------------------------------
  ARCHIVO: Departamento_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes al Departamento.
 * 
  ------------------------------------------------ */

class Paises_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function sel_paises(){
      $query = $this->db->query(" SELECT p.id, p.nombre_pais, p.activo
                                         
                                  FROM paises p
                                  
                                  ORDER BY p.nombre_pais");
      $result = $query->result();
      return $result;
    }

    public function sel_pais_id($pais){
      $query = $this->db->query("SELECT id, nombre_pais, activo
                                   FROM paises WHERE id = $pais");
      $result = $query->result();
      return $result[0];
    }

    public function upd_paises($pais, $nombre, $activo){
      $query = $this->db->query(" UPDATE paises SET 
                                    nombre_pais = '$nombre', 
                                    activo = $activo
                                   WHERE id = $pais");
    }

    public function add_paises($nombre,  $activo){
      $query = $this->db->query("INSERT INTO paises (nombre_pais, activo)
                                   VALUES('$nombre', $activo);");
    }

    public function candel_pais($pais){
      $query = $this->db->query("SELECT count(*) as cant FROM provincia WHERE id_pais = $pais");
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

    public function del_pais($pais){
      if ($this->candel_pais($pais) == 1){
        $query = $this->db->query("DELETE FROM paises WHERE id = $pais");
        return 1;
      } else {
        return 0;
      }
    }


}
