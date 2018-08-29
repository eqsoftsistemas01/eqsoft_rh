<?php

/* ------------------------------------------------
  ARCHIVO: tipopermiso_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes al tipoangre.
 * 
  ------------------------------------------------ */

class Tipopermiso_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function sel_tipopermiso(){
      $query = $this->db->query(" SELECT t.id, t.tipopermiso, t.activo
                                  FROM tipopermiso t
                                  ORDER BY t.tipopermiso");
      $result = $query->result();
      return $result;
    }

    public function sel_tipopermiso_id($tipopermiso){
      $query = $this->db->query("SELECT id, tipopermiso, activo
                                   FROM tipopermiso WHERE id = $tipopermiso");
      $result = $query->result();
      return $result[0];
    }

    public function upd_tipopermiso($idtipopermiso, $tipopermiso, $activo){
      if ((!$idtipopermiso) || (trim($idtipopermiso) == '')) { $idtipopermiso = 'NULL'; }
     
      $query = $this->db->query(" UPDATE tipopermiso SET 
                                    tipopermiso = '$tipopermiso', 
                                    activo = $activo
                                   WHERE id = $idtipopermiso");
    }

    public function add_tipopermiso($tipopermiso, $activo){
      if ((!$tipopermiso) || (trim($tipopermiso) == '')) { $tipopermiso = 'NULL'; }
      $query = $this->db->query("INSERT INTO tipopermiso (tipopermiso, activo)
                                   VALUES('$tipopermiso', $activo);");
    }

    public function cant_tipopermiso($tipopermiso){
      $query = $this->db->query("SELECT count(*) as cant FROM permisoausencia WHERE id_tipopermiso = $tipopermiso");
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

    public function del_tipopermiso($tipopermiso){
      if ($this->cant_tipopermiso($tipopermiso) == 1){
        $query = $this->db->query("DELETE FROM tipopermiso WHERE id = $tipopermiso");
        return 1;
      } else {
        return 0;
      }  
    }

    public function lst_tipopermiso(){
      $query = $this->db->query("SELECT id, tipopermiso, activo
                                  FROM tipopermiso WHERE activo = 1
                                  ORDER BY tipopermiso");
      $r = $query->result();
      return $r;
    }

}
