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
        $query = $this->db->query("SELECT e.id_empleado, e.nombres, e.apellidos, e.nro_ident, e.tipo_identificacion, 
                                          e.perfil, e.telf_empleado, e.correo_empleado, 
                                          e.activo, e.id_departamento, i.desc_identificacion, d.nombre_departamento
                                     FROM empleado e
                                     INNER JOIN identificacion i on i.id_identificacion = e.tipo_identificacion
                                     LEFT JOIN departamento d on d.id = e.id_departamento
                                     ORDER BY e.apellidos, e.nombres;");
        $result = $query->result();
        return $result;
    }


    public function upd_empleado($idempleado, $nombre, $apellido, $tipoident, $identificacion, $perfil, $telefono, $celular, $correo, 
                                 $activo, $departamento, $lugarexpedicion, $cedulamilitar, $pasaporte, $fecha_nacimiento, 
                                 $sexo, $estadocivil, $peso, $talla, $codigoreloj, $calleprincipal, $numerovivienda,
                                 $calletransversal, $sector, $referenciavivienda, $ciudad, $tipovivienda, $vivefamiliares, 
                                 $banco, $tipocuenta, $numerocuenta, $nombrecontacto, $direccioncontacto, 
                                 $parentescocontacto, $telefonocontacto, $empresa, $tiposangre, $tipodiscapacidad, 
                                 $p100discapacidad, $contrato, $cargo){

      if ((!$perfil) || (trim($perfil) == '')) { $perfil = 'NULL'; }
      if ((!$departamento) || (trim($departamento) == '')) { $departamento = 'NULL'; }
      if ((!$fecha_nacimiento) || (trim($fecha_nacimiento) == '')) { 
        $fecha_nacimiento = 'NULL'; 
      }
      else {
        $fecha_nacimiento = '$fecha_nacimiento'; 
      }
      if ((!$estadocivil) || (trim($estadocivil) == '')) { $estadocivil = 'NULL'; }
      if ((!$ciudad) || (trim($ciudad) == '')) { $ciudad = 'NULL'; }
      if ((!$tipovivienda) || (trim($tipovivienda) == '')) { $tipovivienda = 'NULL'; }
      if ((!$banco) || (trim($banco) == '')) { $banco = 'NULL'; }
      if ((!$tipocuenta) || (trim($tipocuenta) == '')) { $tipocuenta = 'NULL'; }
      if ((!$parentescocontacto) || (trim($parentescocontacto) == '')) { $parentescocontacto = 'NULL'; }
      if ((!$empresa) || (trim($empresa) == '')) { $empresa = 'NULL'; }
      if ((!$tiposangre) || (trim($tiposangre) == '')) { $tiposangre = 'NULL'; }
      if ((!$tipodiscapacidad) || (trim($tipodiscapacidad) == '')) { $tipodiscapacidad = 'NULL'; }
      if ((!$contrato) || (trim($contrato) == '')) { $contrato = 'NULL'; }
      if ((!$cargo) || (trim($cargo) == '')) { $cargo = 'NULL'; }

      $this->db->query(" UPDATE empleado SET 
                            apellidos = '$nombre',
                            nombres = '$nombre',
                            tipo_identificacion = $tipoident,
                            nro_ident = '$identificacion',
                            perfil = $perfil,
                            telf_empleado = '$telefono',
                            celular_empleado = '$celular',
                            correo_empleado = '$correo',
                            id_departamento = $departamento,
                            activo = $activo,
                            lugarexpedicion = '$lugarexpedicion', 
                            cedulamilitar = '$cedulamilitar', 
                            pasaporte = '$pasaporte', 
                            fecha_nacimiento = $fecha_nacimiento, 
                            sexo = '$sexo', 
                            id_estadocivil = $estadocivil, 
                            peso = $peso, 
                            talla = $talla, 
                            codigoreloj = '$codigoreloj', 
                            calleprincipal = '$calleprincipal', 
                            numerovivienda = '$numerovivienda',
                            calletransversal = '$calletransversal', 
                            sector = '$sector', 
                            referenciavivienda = '$referenciavivienda', 
                            id_ciudad = $ciudad, 
                            id_tipovivienda = $tipovivienda, 
                            vivefamiliares = $vivefamiliares, 
                            id_banco = $banco, 
                            id_tipocuenta = $tipocuenta, 
                            numerocuenta = '$numerocuenta', 
                            nombrecontacto = '$nombrecontacto', 
                            direccioncontacto = '$direccioncontacto', 
                            id_parentescocontacto = $parentescocontacto, 
                            telefonocontacto = '$telefonocontacto', 
                            id_empresa = $empresa, 
                            id_tiposangre = $tiposangre, 
                            id_tipodiscapacidad = $tipodiscapacidad, 
                            p100discapacidad = $p100discapacidad, 
                            id_contrato = $contrato, 
                            id_cargo = $cargo
                           WHERE id_empleado = $idempleado");
    }

    public function add_empleado($nombre, $apellido, $tipoident, $identificacion, $perfil, $telefono, $celular, $correo, 
                                 $activo, $departamento, $lugarexpedicion, $cedulamilitar, $pasaporte, $fecha_nacimiento, 
                                 $sexo, $estadocivil, $peso, $talla, $codigoreloj, $calleprincipal, $numerovivienda,
                                 $calletransversal, $sector, $referenciavivienda, $ciudad, $tipovivienda, $vivefamiliares, 
                                 $banco, $tipocuenta, $numerocuenta, $nombrecontacto, $direccioncontacto, 
                                 $parentescocontacto, $telefonocontacto, $empresa, $tiposangre, $tipodiscapacidad, 
                                 $p100discapacidad, $contrato, $cargo){

        if ((!$perfil) || (trim($perfil) == '')) { $perfil = 'NULL'; }
        if ((!$departamento) || (trim($departamento) == '')) { $departamento = 'NULL'; }
        if ((!$fecha_nacimiento) || (trim($fecha_nacimiento) == '')) { 
          $fecha_nacimiento = 'NULL'; 
        }
        else {
          $fecha_nacimiento = '$fecha_nacimiento'; 
        }
        if ((!$estadocivil) || (trim($estadocivil) == '')) { $estadocivil = 'NULL'; }
        if ((!$ciudad) || (trim($ciudad) == '')) { $ciudad = 'NULL'; }
        if ((!$tipovivienda) || (trim($tipovivienda) == '')) { $tipovivienda = 'NULL'; }
        if ((!$banco) || (trim($banco) == '')) { $banco = 'NULL'; }
        if ((!$tipocuenta) || (trim($tipocuenta) == '')) { $tipocuenta = 'NULL'; }
        if ((!$parentescocontacto) || (trim($parentescocontacto) == '')) { $parentescocontacto = 'NULL'; }
        if ((!$empresa) || (trim($empresa) == '')) { $empresa = 'NULL'; }
        if ((!$tiposangre) || (trim($tiposangre) == '')) { $tiposangre = 'NULL'; }
        if ((!$tipodiscapacidad) || (trim($tipodiscapacidad) == '')) { $tipodiscapacidad = 'NULL'; }
        if ((!$contrato) || (trim($contrato) == '')) { $contrato = 'NULL'; }
        if ((!$cargo) || (trim($cargo) == '')) { $cargo = 'NULL'; }

        $this->db->query("INSERT INTO empleado (nombres, apellidos, tipo_identificacion, nro_ident, perfil, 
                                               telf_empleado, celular_empleado, correo_empleado, activo, id_departamento,
                                               lugarexpedicion, cedulamilitar, pasaporte, fecha_nacimiento, sexo, 
                                               id_estadocivil, peso, talla, codigoreloj, calleprincipal, numerovivienda, 
                                               calletransversal, sector, referenciavivienda, id_ciudad, id_tipovivienda, 
                                               vivefamiliares, id_banco, id_tipocuenta, numerocuenta, nombrecontacto, 
                                               direccioncontacto, id_parentescocontacto, telefonocontacto, id_empresa, 
                                               id_tiposangre, id_tipodiscapacidad, p100discapacidad, id_contrato, id_cargo)
                            VALUES('$nombre', '$apellido', $tipoident, '$identificacion', $perfil, '$telefono', 
                                   '$celular', '$correo', $activo, $departamento, '$lugarexpedicion', '$cedulamilitar', 
                                   '$pasaporte', $fecha_nacimiento, '$sexo', $estadocivil, $peso, $talla, 
                                   '$codigoreloj', '$calleprincipal', '$numerovivienda', '$calletransversal', 
                                   '$sector', '$referenciavivienda', $ciudad, $tipovivienda, $vivefamiliares, 
                                   $banco, $tipocuenta, '$numerocuenta', '$nombrecontacto', '$direccioncontacto', 
                                   $parentescocontacto, '$telefonocontacto', $empresa, $tiposangre, $tipodiscapacidad, 
                                   $p100discapacidad, $contrato, $cargo);");
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
      $query = $this->db->query(" SELECT id_empleado, nombres, apellidos, nro_ident, tipo_identificacion, 
                                         perfil, telf_empleado, celular_empleado, correo_empleado, 
                                         activo, id_departamento, lugarexpedicion, cedulamilitar,
                                         pasaporte, fecha_nacimiento, sexo, id_estadocivil, peso, talla, 
                                         codigoreloj, calleprincipal, numerovivienda, calletransversal, 
                                         sector, referenciavivienda, id_ciudad, id_tipovivienda, vivefamiliares,
                                         id_banco, id_tipocuenta, numerocuenta, nombrecontacto, direccioncontacto,
                                         id_parentescocontacto, telefonocontacto, id_empresa, id_tiposangre,
                                         id_tipodiscapacidad, p100discapacidad, id_contrato, id_cargo
                                  FROM empleado WHERE id_empleado = $idempleado");
      $result = $query->result();
      return $result[0];
    }

    public function lst_parentesco() {
        $query = $this->db->query("SELECT id, parentesco FROM parentesco;");
        $result = $query->result();
        return $result;
    }

    public function lst_estadocivil() {
        $query = $this->db->query("SELECT id, estadocivil FROM estadocivil;");
        $result = $query->result();
        return $result;
    }

    public function lst_tipovivienda() {
        $query = $this->db->query("SELECT id, tipovivienda FROM tipovivienda;");
        $result = $query->result();
        return $result;
    }

    public function lst_tipocuentabanco() {
        $query = $this->db->query("SELECT id, tipocuentabanco FROM tipocuentabanco;");
        $result = $query->result();
        return $result;
    }

    public function lst_banco() {
        $query = $this->db->query("SELECT id, nombre_banco FROM banco WHERE activo = 1;");
        $result = $query->result();
        return $result;
    }

    public function lst_sexo() {
        $query = $this->db->query("SELECT 'M' as id, 'Masculino' as sexo
                                    UNION
                                    SELECT 'F' as id, 'Femenino' as sexo;");
        $result = $query->result();
        return $result;
    }

}
