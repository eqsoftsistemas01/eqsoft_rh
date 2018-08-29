<?php

/* ------------------------------------------------
  ARCHIVO: Tiposangre_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes al tipoangre.
 * 
  ------------------------------------------------ */

class Tiposangre_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function sel_tiposangre(){
      $query = $this->db->query(" SELECT t.id, t.tiposangre, t.activo
                                  FROM tiposangre t
                                  ORDER BY t.tiposangre");
      $result = $query->result();
      return $result;
    }

    public function sel_tiposangre_id($tiposangre){
      $query = $this->db->query("SELECT id, tiposangre, activo
                                   FROM tiposangre WHERE id = $tiposangre");
      $result = $query->result();
      return $result[0];
    }

    public function upd_tiposangre($idtiposangre, $tiposangre, $activo){
      if ((!$idtiposangre) || (trim($idtiposangre) == '')) { $idtiposangre = 'NULL'; }
     
      $query = $this->db->query(" UPDATE tiposangre SET 
                                    tiposangre = '$tiposangre', 
                                    activo = $activo
                                   WHERE id = $idtiposangre");
    }

    public function add_tiposangre($tiposangre, $activo){
      if ((!$tiposangre) || (trim($tiposangre) == '')) { $tiposangre = 'NULL'; }
      $query = $this->db->query("INSERT INTO tiposangre (tiposangre, activo)
                                   VALUES('$tiposangre', $activo);");
    }

    public function cant_tiposangre($tiposangre){
      $query = $this->db->query("SELECT count(*) as cant FROM empleado WHERE id_tiposangre = $tiposangre");
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

    public function del_tiposangre($tiposangre){
      if ($this->cant_tiposangre($tiposangre) == 1){
        $query = $this->db->query("DELETE FROM tiposangre WHERE id = $tiposangre");
        return 1;
      } else {
        return 0;
      }  
    }

    public function lst_tiposangre(){
      $query = $this->db->query("SELECT id, tiposangre, activo
                                  FROM tiposangre WHERE activo = 1
                                  ORDER BY tiposangre");
      $r = $query->result();
      return $r;
    }

}
