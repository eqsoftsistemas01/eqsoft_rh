<?php

/* ------------------------------------------------
  ARCHIVO: Departamento_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes al ciudad.
 * 
  ------------------------------------------------ */

class Tipotrabajador_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function sel_tipotrabajador(){
      $query = $this->db->query(" SELECT t.id, t.tipo_trabajador, t.descripcion, t.activo
                                  FROM tipotrabajador t
                                  ORDER BY t.tipo_trabajador");
      $result = $query->result();
      return $result;
    }

    public function sel_tipotrabajador_id($tipotrabajador){
      $query = $this->db->query("SELECT id, tipo_trabajador, descripcion, activo
                                   FROM tipo_trabajador WHERE id = $tipotrabajador");
      $result = $query->result();
      return $result[0];
    }

    public function upd_tipotrabajador($idtipotrabajador, $tipotrabajador, $descripcion, $activo){
      if ((!$idtipotrabajador) || (trim($idtipotrabajador) == '')) { $idtipotrabajador = 'NULL'; }
     
      $query = $this->db->query(" UPDATE tipotrabajador SET 
                                    tipo_trabajador = '$tipotrabajador', 
                                    descripcion = $descripcion,
                                    activo = $activo
                                   WHERE id = $idtipotrabajador");
    }

    public function add_tipotrabajador($tipotrabajador, $descripcion, $activo){
      if ((!$tipotrabajador) || (trim($tipotrabajador) == '')) { $tipotrabajador = 'NULL'; }
      $query = $this->db->query("INSERT INTO tipotrabajador (tipo_trabajador, descripcion, activo)
                                   VALUES('$tipotrabajador', $descripcion, $activo);");
    }

    public function cant_tipotrabajador($tipotrabajador){
      $query = $this->db->query("SELECT count(*) as cant FROM tipotrabajador WHERE id = $ciudad");
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

    public function del_tipotrabajador($tipotrabajador){
      if ($this->cant_tipotrabajador($tipotrabajador) == 1){
        $query = $this->db->query("DELETE FROM tipotrabajador WHERE id = $tipotrabajador");
        return 1;
      } else {
        return 0;
      }
    }

    public function lst_tipotrabajador(){
      $query = $this->db->query("SELECT id, tipo_trabajador, descripcion
                                  FROM tipotrabajador WHERE activo = 1
                                  ORDER BY tipo_trabajador");
      $r = $query->result();
      return $r;
    }

}
