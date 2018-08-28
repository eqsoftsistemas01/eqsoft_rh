<?php

/* ------------------------------------------------
  ARCHIVO: usuario_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a usuarios del sistema.
  FECHA DE CREACIÓN: 30/06/2017
 * 
  ------------------------------------------------ */

class Usuario_model extends CI_Model {

    function __construct() {
        parent::__construct();
/*        $query = $this->db->query("SET time_zone = '-5:00';");*/
    }

    /* INSERTA EL REGISTRO DEL USUARIO*/
    public function usu_add($nom, $usu, $pwd, $est, $fot, $perfil, $idempleado){
        $query = $this->db->query("INSERT INTO usu_sistemas (nom_usu, log_usu, pwd_usu, est_usu, fot_usu, perfil,
                                                             id_empleado, ultimoacceso)
                                   VALUES('$nom', '$usu', MD5('$pwd'), '$est', '$fot', $perfil, $idempleado, now())");
    }

  /* OBTENER TODOS LOS DATOS DEL USUARIO A TRAVÉS DE SU ID */
    public function usu_get($id_usu) {
        $query = $this->db->query(" SELECT * FROM usu_sistemas WHERE id_usu = $id_usu;");
        $result = $query->result();
        return $result[0];
    }

  /* OBTENER TODOS LOS DATOS DE LA FOTO DEL USUARIO A TRAVÉS DE SU ID */
    public function usu_get_fot($id_usu) {
        $query = $this->db->query(" SELECT fot_usu from usu_sistemas where id_usu = $id_usu;");
        $result = $query->result();
        return $result[0];
    }


    /* ACTUALIZA EL REGISTRO DEL USUARIO*/
    public function usu_upd($id, $nom, $usu, $pwd, $est, $fot, $perfil, $idempleado){
        if ($fot == NULL || $fot == ""){ $foto = ""; }
        else {$foto = "fot_usu = '$fot',"; }
        $query = $this->db->query("UPDATE usu_sistemas 
                                      SET nom_usu = '$nom', 
                                          log_usu = '$usu', 
                                          pwd_usu = MD5('$pwd'),
                                          ".$foto."
                                          est_usu = '$est',
                                          perfil = $perfil,
                                          id_empleado = $idempleado
                                    WHERE id_usu = $id");
                                    
    }

    //OBTENER EL ID DEL USUARIO
    public function usua_get_id($log_usu, $pas_usu) {
      $sql = $this->db->query("SELECT * FROM usu_sistemas WHERE log_usu = '$log_usu' AND pwd_usu = MD5('$pas_usu')");
      $resu = $sql->result();
      if ($resu){
        return $resu[0];      
      }
      else {
        return NULL;             
      }
    }
    public function usua_get_id00($log_usu, $pas_usu) {
      $sql = $this->db->query("CALL login('$log_usu', '$pas_usu')");
      $resu = $sql->result();
      $sql->next_result(); 
      $sql->free_result(); 
      return $resu[0];      
    }


  //OBTENER TODOS LOS DATOS DEL USUARIO A TRAVÉS DE SU ID

    public function usua_get_tod_log($id_usu) {
        $query = $this->db->query(" SELECT id_usu, nom_usu, log_usu, perfil, id_empleado
                                    FROM usu_sistemas
                                    WHERE id_usu = $id_usu");
        $result = $query->result();
        if (count($result) >= 1) {
            return $result[0];
        } else {
            return $result;
        }
    }

    //OBTENER LOS DATOS DE UN USUARIO A TRAVÉS DE SU ID (ESTA FUNCIÓN SE UTILIZA DESDE AUTH_LIBRARY)

    public function usua_get($id_usu) {
        $query = $this->db->query(" SELECT id_usu, nom_usu, log_usu, perfil, id_empleado
                                    FROM usu_sistemas
                                    WHERE id_usu = $id_usu");
        $result = $query->result();
        return $result[0];
    }

    /* OBTENER PERFIL DE ACCESO DEL USUARIO */
/*    public function perfil($id_usu){
        $query = $this->db->query(" SELECT m.desc_mod_det, a.evento, a.accion 
                                    FROM modulos_detalles m
                                    INNER JOIN acceso a ON a.id_mod_det = m.id_mod_det
                                    WHERE id_usu = $id_usu ");
    }*/

    /* Actualizar los accesos para Categorias */
    public function rol_usu_cat($id_usu, $catv, $cata, $catu, $cate, $catr){
      $query = $this->db->query("UPDATE acceso SET accion = $catv WHERE id_usu = $id_usu and id_mod_det = 1 and evento = 'ver'");
      $query = $this->db->query("UPDATE acceso SET accion = $cata WHERE id_usu = $id_usu and id_mod_det = 1 and evento = 'agrega'");
      $query = $this->db->query("UPDATE acceso SET accion = $catu WHERE id_usu = $id_usu and id_mod_det = 1 and evento = 'modifica'");
      $query = $this->db->query("UPDATE acceso SET accion = $cate WHERE id_usu = $id_usu and id_mod_det = 1 and evento = 'elimina'");
      $query = $this->db->query("UPDATE acceso SET accion = $catr WHERE id_usu = $id_usu and id_mod_det = 1 and evento = 'reporte'");

    }

    /* AGREGAR PERFIL DE USUARIO */
    public function perfil_lst(){
      $sql = $this->db->query("SELECT id_perfil, 
                                      nom_perfil
                                 FROM perfil");
      $resu = $sql->result();
      return $resu;
    }

    /* LISTADO DE USUARIOS */
    public function lst_usu(){
      $sql = $this->db->query("SELECT id_usu, nom_usu, log_usu, est_usu FROM usu_sistemas");
      $resu = $sql->result();
      return $resu;
    }

    /* lista de empleados */
    public function lst_empleado($idempleado = 0) {
        $query = $this->db->query("SELECT e.id_empleado, e.nombres, e.apellidos, e.nro_ident
                                     FROM empleado e
                                     WHERE e.activo = 1 AND
                                           (e.id_empleado = $idempleado OR 
                                            NOT exists (SELECT id_empleado FROM usu_sistemas u WHERE u.id_empleado = e.id_empleado))
                                     ORDER BY e.apellidos, e.nombres;");
        $result = $query->result();
        return $result;
    }


    /* LISTADO DE MESEROS */
    public function usua_del($id_usu){
      $sql = $this->db->query("DELETE FROM usu_sistemas WHERE id_usu = $id_usu");
    } 


  /* ACTUALIZAR FECHA Y HORA DE ULTIMO ACCESO DE USUARIO */
    public function usu_upd_acceso() {
        $usua = $this->session->userdata('usua');
        $id = $usua->id_usu;
        $query = $this->db->query("CALL usuario_upd_acceso($id);");
    }


}
