<?php

/* ------------------------------------------------
  ARCHIVO: Parametros_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a Parametros Generales.
  FECHA DE CREACIÓN: 05/07/2017
 * 
  ------------------------------------------------ */

class Parametros_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* OBTENER IVA */
    public function iva_get() {
        $query = $this->db->query("SELECT valor FROM parametros WHERE id=1;");
        $result = $query->result();
        return $result[0];
    }

    /* ACTUALIZAR IVA */
    public function iva_upd($valor){
        $query = $this->db->query("UPDATE parametros SET valor='$valor' WHERE id=1;");
    }

    /* OBTENER Rubro Neto a Cobrar */
    public function iva_get() {
        $query = $this->db->query("SELECT valor FROM parametros WHERE id=2;");
        $result = $query->result();
        return $result[0];
    }

    /* ACTUALIZAR Rubro Neto a Cobrar */
    public function iva_upd($valor){
        $query = $this->db->query("UPDATE parametros SET valor='$valor' WHERE id=2;");
    }

}
