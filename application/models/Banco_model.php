<?php

/* ------------------------------------------------
  ARCHIVO: Banco_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la Banco.
  FECHA DE CREACIÓN: 28/11/2017
 * 
  ------------------------------------------------ */

class Banco_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function bancolst(){
    	$sql = $this->db->query(" SELECT b.id, tp.nombre as tipo, b.nombre_banco 
                                FROM banco b
                                INNER JOIN tipobanco tp ON tp.id = b.tipo
                                ORDER BY tp.id, b.nombre_banco ASC");
    	$resu = $sql->result();
    	return $resu;
    }

    public function bancotipo(){
      $sql = $this->db->query("SELECT id, nombre FROM tipobanco");
      $resu = $sql->result();
      return $resu;
    }

    public function selban($idban){
      $sql = $this->db->query("SELECT id, tipo, nombre_banco, tipo FROM banco WHERE id = $idban ");
      $resu = $sql->result();
      return $resu[0];
    }    

    public function savban($tipban, $nomban){
      $sql = $this->db->query("INSERT INTO banco (nombre_banco, tipo) VALUES ('$nomban', $tipban) ");
    } 

    public function updban($idban, $tipban, $nomban){
      $sql = $this->db->query("UPDATE banco SET nombre_banco = '$nomban', tipo = $tipban WHERE id = $idban ");
    } 

    public function delban($idban){
      $sql = $this->db->query("DELETE FROM banco WHERE id = $idban ");
    }

}
