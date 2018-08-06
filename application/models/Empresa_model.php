<?php

/* ------------------------------------------------
  ARCHIVO: Empresa_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la Empresa.
  FECHA DE CREACIÓN: 05/07/2017
 * 
  ------------------------------------------------ */

class Empresa_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* OBTENER TODOS LOS DATOS DE LA EMPRESA */
    public function emp_get() {
        $query = $this->db->query(" SELECT * FROM empresa;");
        $result = $query->result();
        return $result[0];
    }

    /* SE ACTUALIZAN LOS DATOS DE LA EMPRESA */
    public function emp_upd($id, $cod, $nom, $ruc, $rs, $ema, $tlf, $fax, $dir, $rep, $web, $img){
        $this->db->query("UPDATE empresa SET nom_emp = '$nom',
                                              cod_emp = '$cod',
                                              ruc_emp = '$ruc',
                                              raz_soc_emp = '$rs',
                                              ema_emp = '$ema',
                                              tlf_emp = '$tlf', 
                                              fax_emp = '$fax',
                                              dir_emp = '$dir', 
                                              rep_emp = '$rep',
                                              web_emp = '$web',
                                              logo_path = '$img'
                              WHERE id_emp = $id;");
    }

    public function emp_ins($cod, $nom, $ruc, $rs, $ema, $tlf, $fax, $dir, $rep, $web, $img){
        $this->db->query("INSERT INTO empresa (cod_emp,nom_emp,ruc_emp,raz_soc_emp,ema_emp,
                                               tlf_emp,fax_emp,dir_emp,rep_emp,web_emp, logo_path)
                            VALUES ('$cod', '$nom', '$ruc', '$rs', '$ema', '$tlf', '$fax', '$dir', '$rep', '$web', '$img');");
    }

    public function lst_empresa(){
      $sql = $this->db->query("SELECT id_emp, cod_emp, nom_emp, ruc_emp, raz_soc_emp, logo_path FROM empresa");
      $res = $sql->result();
      return $res;
    }

    public function sel_emp_id($idemp){
      $query = $this->db->query("SELECT * FROM empresa WHERE id_emp = $idemp");
      $result = $query->result();
      return $result[0];
    }

   /* ELIMINAR EL REGISTRO SELECCIONADO */
    public function emp_del($id){
      $this->db->query("DELETE FROM empresa WHERE id_emp = $id");
    }

    public function existe_info_emp($idemp){
      $query = $this->db->query("SELECT count(*) as cant FROM sucursal WHERE id_empresa = $idemp
                                  UNION 
                                 SELECT count(*) as cant FROM venta WHERE id_empresa = $idemp");
      $result = $query->result();
      return $result[0]->cant;
    }

}
