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
                            apellidos = '$apellido',
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

      $usua = $this->session->userdata('usua');
      $idusu = $usua->id_usu;
      $this->db->query("DELETE FROM cargafamiliar WHERE id_empleado = $idempleado"); 
      $this->db->query("INSERT INTO cargafamiliar (id_empleado, apellidos_familiar, nombres_familiar, nro_ident, 
                                                     tipo_parentesco, telf_familiar, activo, sexo, fecha_nacimiento, fecha_fallece)
                          SELECT $idempleado, apellidos_familiar, nombres_familiar, nro_ident, 
                                 tipo_parentesco, telf_familiar, activo, sexo, fecha_nacimiento, fecha_fallece
                            FROM cargafamiliar_tmp t
                            INNER JOIN empleado_tmp e on e.id = t.id_empleadotmp
                            WHERE e.id_usuario = $idusu");

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
        $query = $this->db->query("SELECT max(id_empleado) as maxid FROM empleado");
        $resultado = $query->result();
        $newid = $resultado[0]->maxid;

        $usua = $this->session->userdata('usua');
        $idusu = $usua->id_usu;
        $this->db->query("INSERT INTO cargafamiliar (id_empleado, apellidos_familiar, nombres_familiar, nro_ident, 
                                                     tipo_parentesco, telf_familiar, activo, sexo, fecha_nacimiento, fecha_fallece)
                            SELECT $newid, apellidos_familiar, nombres_familiar, nro_ident, 
                                   tipo_parentesco, telf_familiar, activo, sexo, fecha_nacimiento, fecha_fallece
                              FROM cargafamiliar_tmp t
                              INNER JOIN empleado_tmp e on e.id = t.id_empleadotmp
                              WHERE e.id_usuario = $idusu");

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

    public function get_empleadotmp($usuario, $idempleado = 0) {
        $this->db->query("DELETE FROM cargafamiliar_tmp WHERE NOT id_empleadotmp IN 
                            (SELECT DISTINCT id_empleado FROM empleado_tmp);");
        $this->db->query("DELETE FROM cargafamiliar_tmp WHERE id_empleadotmp IN 
                            (SELECT id_empleado FROM empleado_tmp WHERE id_usuario = $usuario AND id_empleado = $idempleado);");
        $this->db->query("DELETE FROM empleado_tmp WHERE id_usuario = $usuario AND id_empleado = $idempleado;");

        $this->db->query("INSERT INTO empleado_tmp (id_empleado, id_usuario) Values($idempleado, $usuario);");
        $query = $this->db->query("SELECT max(id) as newid FROM empleado_tmp;");
        $result = $query->result();
        $newtmpid =  $result[0]->newid;

        $usua = $this->session->userdata('usua');
        $idusu = $usua->id_usu;
        $this->db->query("INSERT INTO cargafamiliar_tmp (id_empleadotmp, apellidos_familiar, nombres_familiar, nro_ident, 
                                                       tipo_parentesco, telf_familiar, activo, sexo, fecha_nacimiento, fecha_fallece)
                            SELECT $newtmpid, apellidos_familiar, nombres_familiar, nro_ident, 
                                   tipo_parentesco, telf_familiar, activo, sexo, fecha_nacimiento, fecha_fallece
                              FROM cargafamiliar t
                              WHERE id_empleado = $idempleado");

        return $newtmpid;
    }

    public function del_empleadotmp($idempleadotmp) {
        $this->db->query("DELETE FROM cargafamiliar_tmp WHERE id_empleadotmp = $idempleadotmp;");
        $this->db->query("DELETE FROM empleado_tmp WHERE id = $idempleadotmp;");
    }

    public function sel_cargafamiliar_tmpid($idempleado){
      $query = $this->db->query("SELECT t.id, t.apellidos_familiar, t.nombres_familiar, t.nro_ident, t.tipo_parentesco, 
                                        t.telf_familiar, t.fecha_nacimiento, t.fecha_fallece, t.sexo, t.activo, p.parentesco,
                                        case t.sexo WHEN 'M' then 'Masculino' else 'Femenino' end as sexonombre
                                    FROM cargafamiliar_tmp t 
                                    LEFT JOIN parentesco p on p.id = t.tipo_parentesco
                                    WHERE id_empleadotmp = $idempleado");
      $result = $query->result();
      return $result;
    }

    public function sel_cargafamiliar_id($id){
      $query = $this->db->query("SELECT id, apellidos_familiar, nombres_familiar, nro_ident, tipo_parentesco, 
                                        telf_familiar, fecha_nacimiento, fecha_fallece, sexo, activo
                                    FROM cargafamiliar_tmp 
                                    WHERE id = $id");
      $result = $query->result();
      return $result[0];
    }

    /* SELECCIONAR EL Empleado POR IDENTIF */
    public function existeIdentificacionCarga($idempleado, $identificacion){
      $query = $this->db->query("SELECT count(*) as cant FROM cargafamiliar WHERE nro_ident = '$identificacion'");
      $resultado = $query->result();
      $res = $resultado[0]->cant;
      if ($res == 0){
        $query = $this->db->query("SELECT count(*) as cant FROM cargafamiliar_tmp 
                                     WHERE nro_ident = '$identificacion' AND id_empleadotmp = $idempleado");
        $resultado = $query->result();
        $res = $resultado[0]->cant;        
      }
      return $res;
    }

    public function add_cargafamiliar_tmp($empleado, $apellidos, $nombres, $ident, $parentesco, $telf, $fechanac, $fechafall, $activo, $sexo){
      if ((!$parentesco) || (trim($parentesco) == '')) { $parentesco = 'NULL'; }
      if (!$fechanac) { $fechanac = ''; } 
      if (!$fechafall) { $fechafall = ''; } 
      $this->db->query("INSERT INTO cargafamiliar_tmp (id_empleadotmp, apellidos_familiar, nombres_familiar, nro_ident, 
                                                       tipo_parentesco, telf_familiar, activo, sexo, fecha_nacimiento, fecha_fallece)
                          SELECT $empleado, '$apellidos', '$nombres', '$ident', $parentesco, '$telf', $activo, '$sexo',
                                 case when ('$fechanac' != '') then to_date('$fechanac', 'YYYY-MM-DD') else NULL end,
                                 case when ('$fechafall' != '') then to_date('$fechafall', 'YYYY-MM-DD') else NULL end");
    }

    public function upd_cargafamiliar_tmp($id, $apellidos, $nombres, $ident, $parentesco, $telf, $fechanac, $fechafall, $activo, $sexo){
      if ((!$parentesco) || (trim($parentesco) == '')) { $parentesco = 'NULL'; }
      if (!$fechanac) { $fechanac = ''; } 
      if (!$fechafall) { $fechafall = ''; } 
      $this->db->query("UPDATE cargafamiliar_tmp SET
                            apellidos_familiar = '$apellidos', 
                            nombres_familiar = '$nombres', 
                            nro_ident = '$ident', 
                            tipo_parentesco = $parentesco, 
                            telf_familiar = '$telf', 
                            fecha_nacimiento = case when ('$fechanac' != '') then to_date('$fechanac', 'YYYY-MM-DD') else NULL end, 
                            fecha_fallece = case when ('$fechafall' != '') then to_date('$fechafall', 'YYYY-MM-DD') else NULL end,  
                            activo = $activo,
                            sexo = '$sexo'
                          WHERE id = $id");
    }

}
