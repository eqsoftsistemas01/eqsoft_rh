<?php

/* ------------------------------------------------
  ARCHIVO: Empresa_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes al Empresa.
 * 
  ------------------------------------------------ */

class Empresa_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function sel_empresa(){
      $query = $this->db->query(" SELECT id, nombre_empresa, ruc_empresa, representante_empresa, activo                                        
                                  FROM empresa                                  
                                  ORDER BY nombre_empresa");
      $result = $query->result();
      return $result;
    }

    public function sel_empresa_id($empresa){
      $query = $this->db->query("SELECT id, nombre_empresa, ruc_empresa, representante_empresa, activo
                                   FROM empresa WHERE id = $empresa");
      $result = $query->result();
      return $result[0];
    }

    public function upd_empresa($empresa, $nombre, $ruc, $representante, $activo){
      $query = $this->db->query(" UPDATE empresa SET 
                                    nombre_empresa = '$nombre', 
                                    ruc_empresa = '$ruc', 
                                    representante_empresa = '$representante', 
                                    activo = $activo
                                   WHERE id = $empresa");
    }

    public function add_empresa($nombre, $ruc, $representante,  $activo){
      $query = $this->db->query("INSERT INTO empresa (nombre_empresa, ruc_empresa, representante_empresa, activo)
                                   VALUES('$nombre', '$ruc', '$representante', $activo);");
    }

    public function candel_empresa($empresa){
      $query = $this->db->query("SELECT count(*) as cant FROM empleado WHERE id_empresa = $empresa");
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

    public function del_empresa($empresa){
      if ($this->candel_empresa($empresa) == 1){
        $query = $this->db->query("DELETE FROM empresa WHERE id = $empresa");
        return 1;
      } else {
        return 0;
      }
    }

}
