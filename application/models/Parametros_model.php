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
        return $result[0]->valor;
    }

    /* ACTUALIZAR IVA */
    public function iva_upd($valor){
        $query = $this->db->query("UPDATE parametros SET valor='$valor' WHERE id=1;");
    }

    /* OBTENER Rubro Sueldo */
    public function rubro_sueldo_get() {
        $query = $this->db->query("SELECT valor FROM parametros WHERE id=2;");
        $result = $query->result();
        return $result[0]->valor;
    }

    /* ACTUALIZAR Rubro Sueldo */
    public function rubro_sueldo_upd($valor){
        $query = $this->db->query("UPDATE parametros SET valor='$valor' WHERE id=2;");
    }

    /* OBTENER Rubro Dias Trabajados */
    public function rubro_diastrab_get() {
        $query = $this->db->query("SELECT valor FROM parametros WHERE id=3;");
        $result = $query->result();
        return $result[0]->valor;
    }

    /* ACTUALIZAR Rubro Dias Trabajados */
    public function rubro_diastrab_upd($valor){
        $query = $this->db->query("UPDATE parametros SET valor='$valor' WHERE id=3;");
    }

    /* OBTENER Rubro Neto a Cobrar */
    public function rubro_netocobrar_get() {
        $query = $this->db->query("SELECT valor FROM parametros WHERE id=4;");
        $result = $query->result();
        return $result[0]->valor;
    }

    /* ACTUALIZAR Rubro Neto a Cobrar */
    public function rubro_netocobrar_upd($valor){
        $query = $this->db->query("UPDATE parametros SET valor='$valor' WHERE id=4;");
    }

}
