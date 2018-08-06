<?php

/* ------------------------------------------------
  ARCHIVO: Empleado_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a Empleado.
  FECHA DE CREACIÓN: 05/07/2017
 * 
  ------------------------------------------------ */

class Empleado_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* lista de tipos de identificacion */
    public function lst_tipoidentificacion() {
        $query = $this->db->query("SELECT id_identificacion, desc_identificacion, cod_identificacion 
                                     FROM identificacion;");
        $result = $query->result();
        return $result;
    }

    /* lista de empleados */
    public function lst_empleado() {
        $query = $this->db->query("SELECT e.id_empleado, e.nombre_empleado, e.nro_ident, e.tipo_identificacion, 
                                          e.perfil, e.direccion_empleado, e.telf_empleado, e.correo_empleado,
                                          e.activo, e.id_departamento, i.desc_identificacion, d.nombre_departamento
                                     FROM empleado e
                                     INNER JOIN identificacion i on i.id_identificacion = e.tipo_identificacion
                                     LEFT JOIN departamento d on d.id = e.id_departamento
                                     ORDER BY e.nombre_empleado;");
        $result = $query->result();
        return $result;
    }

    public function lst_empleadotecnico() {
        $query = $this->db->query("SELECT id_empleado, nombre_empleado, nro_ident, tipo_identificacion, 
                                          direccion_empleado, telf_empleado, correo_empleado
                                     FROM empleado WHERE perfil = 4 AND activo = 1
                                     ORDER BY nombre_empleado;");
        $result = $query->result();
        return $result;
    }

    public function upd_empleado($idempleado, $nombre, $tipoident, $identificacion, $perfil, $direccion, $telefono, $correo, $activo, $departamento){
      if ((!$perfil) || (trim($perfil) == '')) { $perfil = 'NULL'; }
      $query = $this->db->query(" UPDATE empleado SET 
                                    nombre_empleado = '$nombre',
                                    tipo_identificacion = $tipoident,
                                    nro_ident = '$identificacion',
                                    perfil = $perfil,
                                    direccion_empleado = '$direccion',
                                    telf_empleado = '$telefono',
                                    correo_empleado = '$correo',
                                    id_departamento = $departamento,
                                    activo = $activo
                                   WHERE id_empleado = $idempleado");
    }

    public function add_empleado($nombre, $tipoident, $identificacion, $perfil, $direccion, $telefono, $correo, $activo, $departamento){
        if ((!$perfil) || (trim($perfil) == '')) { $perfil = 'NULL'; }
        $query = $this->db->query("INSERT INTO empleado (nombre_empleado, tipo_identificacion, nro_ident, perfil, direccion_empleado, telf_empleado, correo_empleado, activo, id_departamento)
                                    VALUES('$nombre', $tipoident, '$identificacion', $perfil, '$direccion', '$telefono', '$correo', $activo, $departamento);");
    }

    public function del_empleado($idempleado){
      $query = $this->db->query("DELETE FROM empleado WHERE id_empleado = $idempleado");
    }

    /* SELECCIONAR EL Empleado POR IDENTIF */
    public function existeIdentificacion($idempleado, $identificacion){
      $query = $this->db->query("SELECT count(*) as cant FROM empleado
                                   WHERE nro_ident = '$identificacion' and id_empleado != $idempleado");
      $resultado = $query->result();
      return $resultado[0]->cant;
    }

    public function sel_empleado_id($idempleado){
      $query = $this->db->query(" SELECT e.id_empleado, e.nombre_empleado, e.nro_ident, e.tipo_identificacion, 
                                         e.perfil, e.direccion_empleado, e.telf_empleado, e.correo_empleado, 
                                         e.activo, e.id_departamento
                                  FROM empleado e WHERE e.id_empleado = $idempleado");
      $result = $query->result();
      return $result[0];
    }

}
