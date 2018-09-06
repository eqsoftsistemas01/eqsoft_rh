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
    public function asi_empleado($empleado) {
        $query = $this->db->query("SELECT a.id, a.fecha, a.entrada_trabajo, a.salida_trabajo, 
                                          a.salida_almuerzo, a.entrada_almuerzo, a.codigoreloj,
                                          a.id_empleado, e.nombres, e.apellidos, e.nro_ident
                                     FROM asistencia a
                                     INNER JOIN empleado e on e.id_empleado = a.id_empleado
                                     Where a.id_empleado = '$empleado'
                                     ORDER BY a.fecha;");
        $result = $query->result();
        return $result;
    }

    public function upd_empleado($idempleado, $nombre, $apellido, $tipoident, $identificacion, $perfil, $telefono, $celular, $correo, 
                                 $activo, $departamento, $lugarexpedicion, $cedulamilitar,$profesion, $pasaporte, $fechanac, 
                                 $sexo, $estadocivil, $peso, $talla, $codigoreloj, $calleprincipal, $numerovivienda,
                                 $calletransversal, $sector, $referenciavivienda, $ciudad, $tipovivienda, $vivefamiliares, 
                                 $banco, $tipocuenta, $numerocuenta, $nombrecontacto, $direccioncontacto, 
                                 $parentescocontacto, $telefonocontacto, $empresa, $tiposangre, $tipodiscapacidad, 
                                 $p100discapacidad, $contrato, $cargo, $tipocontrato, $fechaingreso, $fechasalida, $sueldo,
                                 $idjornada, $causasalida, $tipotrabajador, $editdias){

      if ((!$perfil) || (trim($perfil) == '')) { $perfil = 'NULL'; }
      if ((!$departamento) || (trim($departamento) == '')) { $departamento = 'NULL'; }
      if ((!$fechanac) || (trim($fechanac) == '')) { $fechanac = 'NULL'; }
        else { $fechanac = "to_date('" . $fechanac . "', 'YYYY-MM-DD')";  }
      if ((!$estadocivil) || (trim($estadocivil) == '')) { $estadocivil = 'NULL'; }
      if ((!$ciudad) || (trim($ciudad) == '')) { $ciudad = 'NULL'; }
      if ((!$tipovivienda) || (trim($tipovivienda) == '')) { $tipovivienda = 'NULL'; }
      if ((!$banco) || (trim($banco) == '')) { $banco = 'NULL'; }
      if ((!$tipocuenta) || (trim($tipocuenta) == '')) { $tipocuenta = 'NULL'; }
      if ((!$parentescocontacto) || (trim($parentescocontacto) == '')) { $parentescocontacto = 'NULL'; }
      if ((!$empresa) || (trim($empresa) == '')) { $empresa = 'NULL'; }
      if ((!$tiposangre) || (trim($tiposangre) == '')) { $tiposangre = 'NULL'; }
      if ((!$tipodiscapacidad) || (trim($tipodiscapacidad) == '')) { $tipodiscapacidad = 'NULL'; }
      if ((!$p100discapacidad) || (trim($p100discapacidad) == '')) { $p100discapacidad = 0; }
      if (($contrato == NULL) || (trim($contrato) == '')) { $contrato = 'NULL'; }
      if ((!$cargo) || (trim($cargo) == '')) { $cargo = 'NULL'; }
      if ((!$tipocontrato) || (trim($tipocontrato) == '')) { $tipocontrato = 'NULL'; }
      if ((!$fechaingreso) || (trim($fechaingreso) == '')) { $fechaingreso = 'NULL'; }
        else { $fechaingreso = "to_date('" . $fechaingreso . "', 'YYYY-MM-DD')";  }
      if ((!$fechasalida) || (trim($fechasalida) == '')) { $fechasalida = 'NULL'; }
        else { $fechasalida = "to_date('" . $fechasalida . "', 'YYYY-MM-DD')";  }
      if ((!$sueldo) || (trim($sueldo) == '')) { $sueldo = 0; }
      if ((!$peso) || (trim($peso) == '')) { $peso = 'NULL'; }
      if ((!$talla) || (trim($talla) == '')) { $talla = 'NULL'; }
      if ((!$causasalida) || (trim($causasalida) == '')) { $causasalida = ''; }
      if ((!$idjornada) || (trim($idjornada) == '')) { $idjornada = 'NULL'; }
      if ((!$tipotrabajador) || (trim($tipotrabajador) == '')) { $tipotrabajador = 'NULL'; }

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
                            profesion = '$profesion', 
                            pasaporte = '$pasaporte', 
                            fecha_nacimiento = $fechanac, 
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
                            id_cargo = $cargo,
                            fecha_ingreso = $fechaingreso, 
                            fecha_salida = $fechasalida, 
                            causa_salida = '$causasalida', 
                            id_jornada = $idjornada, 
                            sueldo = $sueldo,
                            id_tipotrabajador = $tipotrabajador,
                            editdiastrab = $editdias
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

      if ($contrato != 'NULL'){
        if ($contrato < 1){
          $this->db->query("INSERT INTO contrato (id_tipo, id_empleado, id_cargo, fecha_inicio, fecha_fin, sueldo, activo, causa_salida)
                              VALUES($tipocontrato, $idempleado, $cargo, $fechaingreso, $fechasalida, $sueldo, 1, '$causasalida')");
          $query = $this->db->query("SELECT max(id) as newid from contrato;");
          $result = $query->result();
          $newid = $result[0]->newid;
          $this->db->query("UPDATE empleado set id_contrato = $newid WHERE id_empleado = $idempleado");
        } 
        else {
          $this->db->query("UPDATE contrato SET 
                              id_tipo = $tipocontrato, 
                              id_cargo = $cargo, 
                              fecha_inicio = $fechaingreso, 
                              fecha_fin = $fechasalida, 
                              causa_salida = '$causasalida',
                              sueldo = $sueldo
                              WHERE id = $contrato");
        }
      }

      $this->db->query("DELETE FROM rubro_empleado WHERE id_empleado = $idempleado"); 
      $this->db->query("INSERT INTO rubro_empleado (id_empleado, id_rubro, valor_neto)
                          SELECT $idempleado, t.id_rubro, t.valor_neto
                            FROM rubro_empleado_tmp t
                            INNER JOIN empleado_tmp e on e.id = t.id_empleadotmp
                            WHERE e.id_usuario = $idusu AND existe = 1");

    }

    public function add_empleado($nombre, $apellido, $tipoident, $identificacion, $perfil, $telefono, $celular, $correo, 
                                 $activo, $departamento, $lugarexpedicion, $cedulamilitar,$profesion, $pasaporte, $fechanac, 
                                 $sexo, $estadocivil, $peso, $talla, $codigoreloj, $calleprincipal, $numerovivienda,
                                 $calletransversal, $sector, $referenciavivienda, $ciudad, $tipovivienda, $vivefamiliares, 
                                 $banco, $tipocuenta, $numerocuenta, $nombrecontacto, $direccioncontacto, 
                                 $parentescocontacto, $telefonocontacto, $empresa, $tiposangre, $tipodiscapacidad, 
                                 $p100discapacidad, $contrato, $cargo, $tipocontrato, $fechaingreso, $fechasalida, $sueldo,
                                 $idjornada, $causasalida, $tipotrabajador, $editdias){

        if ((!$perfil) || (trim($perfil) == '')) { $perfil = 'NULL'; }
        if ((!$departamento) || (trim($departamento) == '')) { $departamento = 'NULL'; }
        if ((!$fechanac) || (trim($fechanac) == '')) { 
          $fechanac = 'NULL'; 
        }
        else {
          $fechanac = "to_date('" . $fechanac . "', 'YYYY-MM-DD')"; 
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
        if (($contrato == NULL) || (trim($contrato) == '')) { $contrato = 'NULL'; }
        if ((!$cargo) || (trim($cargo) == '')) { $cargo = 'NULL'; }
        if ((!$peso) || (trim($peso) == '')) { $peso = 'NULL'; }
        if ((!$talla) || (trim($talla) == '')) { $talla = 'NULL'; }
        if ((!$p100discapacidad) || (trim($p100discapacidad) == '')) { $p100discapacidad = 0; }
        if ((!$tipocontrato) || (trim($tipocontrato) == '')) { $tipocontrato = 'NULL'; }
        if ((!$fechaingreso) || (trim($fechaingreso) == '')) { $fechaingreso = 'NULL'; }
          else { $fechaingreso = "to_date('" . $fechaingreso . "', 'YYYY-MM-DD')";  }
        if ((!$fechasalida) || (trim($fechasalida) == '')) { $fechasalida = 'NULL'; }
          else { $fechasalida = "to_date('" . $fechasalida . "', 'YYYY-MM-DD')";  }
        if ((!$sueldo) || (trim($sueldo) == '')) { $sueldo = 0; }
        if ((!$causasalida) || (trim($causasalida) == '')) { $causasalida = ''; }
        if ((!$idjornada) || (trim($idjornada) == '')) { $idjornada = 'NULL'; }
      if ((!$tipotrabajador) || (trim($tipotrabajador) == '')) { $tipotrabajador = 'NULL'; }

        $this->db->query("INSERT INTO empleado (nombres, apellidos, tipo_identificacion, nro_ident, perfil, 
                                               telf_empleado, celular_empleado, correo_empleado, activo, id_departamento,
                                               lugarexpedicion, cedulamilitar,profesion, pasaporte, fecha_nacimiento, sexo, 
                                               id_estadocivil, peso, talla, codigoreloj, calleprincipal, numerovivienda, 
                                               calletransversal, sector, referenciavivienda, id_ciudad, id_tipovivienda, 
                                               vivefamiliares, id_banco, id_tipocuenta, numerocuenta, nombrecontacto, 
                                               direccioncontacto, id_parentescocontacto, telefonocontacto, id_empresa, 
                                               id_tiposangre, id_tipodiscapacidad, p100discapacidad, id_contrato, id_cargo,
                                               causa_salida, id_jornada, id_tipotrabajador, editdiastrab)
                            VALUES('$nombre', '$apellido', $tipoident, '$identificacion', $perfil, '$telefono', 
                                   '$celular', '$correo', $activo, $departamento, '$lugarexpedicion', '$cedulamilitar','$profesion', 
                                   '$pasaporte', 
                                   $fechanac,
                                   '$sexo', $estadocivil, $peso, $talla, 
                                   '$codigoreloj', '$calleprincipal', '$numerovivienda', '$calletransversal', 
                                   '$sector', '$referenciavivienda', $ciudad, $tipovivienda, $vivefamiliares, 
                                   $banco, $tipocuenta, '$numerocuenta', '$nombrecontacto', '$direccioncontacto', 
                                   $parentescocontacto, '$telefonocontacto', $empresa, $tiposangre, $tipodiscapacidad, 
                                   $p100discapacidad, $contrato, $cargo, '$causasalida', $idjornada, $tipotrabajador, $editdias);");
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

        if ($contrato != 'NULL'){
            $this->db->query("INSERT INTO contrato (id_tipo, id_empleado, id_cargo, fecha_inicio, fecha_fin, sueldo, activo, causa_salida)
                                VALUES($tipocontrato, $newid, $cargo, $fechaingreso, $fechasalida, $sueldo, 1, '$causasalida')");
            $query = $this->db->query("SELECT max(id) as newid from contrato;");
            $result = $query->result();
            $newcont = $result[0]->newid;
            $this->db->query("UPDATE empleado set id_contrato = $newcont WHERE id_empleado = $newid");
        } 

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
      $query = $this->db->query(" SELECT e.id_empleado, e.nombres, e.apellidos, e.nro_ident, e.tipo_identificacion, 
                                         e.perfil, e.telf_empleado, e.celular_empleado, e.correo_empleado, 
                                         e.activo, e.id_departamento, e.lugarexpedicion, e.cedulamilitar, e.profesion,
                                         e.pasaporte, e.fecha_nacimiento, e.sexo, e.id_estadocivil, e.peso, e.talla, 
                                         e.codigoreloj, e.calleprincipal, e.numerovivienda, e.calletransversal, 
                                         e.sector, e.referenciavivienda, e.id_ciudad, e.id_tipovivienda, e.vivefamiliares,
                                         e.id_banco, e.id_tipocuenta, e.numerocuenta, e.nombrecontacto, e.direccioncontacto,
                                         e.id_parentescocontacto, e.telefonocontacto, e.id_empresa, e.id_tiposangre,
                                         e.id_tipodiscapacidad, e.p100discapacidad, e.id_contrato, e.id_cargo,
                                         e.fecha_ingreso, e.fecha_salida, e.sueldo, e.id_jornada, e.causa_salida,
                                         c.id_tipo as id_tipocontrato, e.id_tipotrabajador, e.editdiastrab
                                  FROM empleado e
                                  LEFT JOIN contrato c on c.id = e.id_contrato
                                  WHERE e.id_empleado = $idempleado");
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

    public function lst_tiposangre() {
        $query = $this->db->query("SELECT id, tiposangre FROM tiposangre;");
        $result = $query->result();
        return $result;
    }

    public function lst_tipodiscapacidad() {
        $query = $this->db->query("SELECT id, tipodiscapacidad FROM tipodiscapacidad;");
        $result = $query->result();
        return $result;
    }

    public function lst_ciudad() {
        $query = $this->db->query("SELECT id, nombre_ciudad FROM ciudad WHERE activo = 1;");
        $result = $query->result();
        return $result;
    }

    public function get_empleadotmp($usuario, $idempleado = 0) {
        $this->db->query("DELETE FROM rubro_empleado_tmp WHERE NOT id_empleadotmp IN 
                            (SELECT DISTINCT id_empleado FROM empleado_tmp);");
        $this->db->query("DELETE FROM rubro_empleado_tmp WHERE id_empleadotmp IN 
                            (SELECT id_empleado FROM empleado_tmp WHERE id_usuario = $usuario AND id_empleado = $idempleado);");

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

        $this->db->query("INSERT INTO rubro_empleado_tmp (id_usuario, id_empleadotmp, id_rubro, existe, valor_neto)
                            SELECT $idusu, $newtmpid, r.id, 
                                   CASE WHEN t.id_rubro IS NULL THEN 0 ELSE 1 END, 
                                   COALESCE(t.valor_neto, 0)
                              FROM rubro r 
                              LEFT JOIN rubro_empleado t on t.id_rubro = r.id AND t.id_empleado = $idempleado");

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
    public function sel_rubrosempleado_tmpid($idempleado){
        $query = $this->db->query("SELECT r.id, r.codigo_rubro, r.nombre_rubro, t.valor_neto, t.existe, r.editable
                                    FROM rubro r 
                                    INNER JOIN rubro_empleado_tmp t on t.id_rubro = r.id
                                    WHERE t.id_empleadotmp = $idempleado");
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

    public function lst_cargo() {
        $query = $this->db->query("SELECT id, nombre_cargo FROM cargo WHERE activo = 1;");
        $result = $query->result();
        return $result;
    }

    public function lst_empresa() {
        $query = $this->db->query("SELECT id, nombre_empresa, ruc_empresa, representante_empresa FROM empresa 
                                     WHERE activo = 1;");
        $result = $query->result();
        return $result;
    }

    public function lst_tipocontrato() {
        $query = $this->db->query("SELECT id, tipocontrato FROM tipocontrato;");
        $result = $query->result();
        return $result;
    }

    public function actualiza_rubroempleado($idusu, $empleadotmp, $id, $existe, $valor) {
        $this->db->query("UPDATE rubro_empleado_tmp SET 
                              valor_neto = $valor,
                              existe = $existe
                            WHERE id_rubro = $id AND id_empleadotmp = $empleadotmp AND id_usuario = $idusu;");
    }

    public function lst_tipotrabajador() {
        $query = $this->db->query("SELECT id, tipo_trabajador FROM tipotrabajador WHERE activo = 1;");
        $result = $query->result();
        return $result;
    }

    public function sel_empleado_codigoreloj($codigoreloj){
      $query = $this->db->query(" SELECT e.id_empleado, e.nombres, e.apellidos, e.nro_ident, e.tipo_identificacion, 
                                         e.perfil, e.telf_empleado, e.celular_empleado, e.correo_empleado, 
                                         e.activo, e.id_departamento, e.lugarexpedicion, e.cedulamilitar, e.profesion,
                                         e.pasaporte, e.fecha_nacimiento, e.sexo, e.id_estadocivil, e.peso, e.talla, 
                                         e.codigoreloj, e.calleprincipal, e.numerovivienda, e.calletransversal, 
                                         e.sector, e.referenciavivienda, e.id_ciudad, e.id_tipovivienda, e.vivefamiliares,
                                         e.id_banco, e.id_tipocuenta, e.numerocuenta, e.nombrecontacto, e.direccioncontacto,
                                         e.id_parentescocontacto, e.telefonocontacto, e.id_empresa, e.id_tiposangre,
                                         e.id_tipodiscapacidad, e.p100discapacidad, e.id_contrato, e.id_cargo,
                                         e.fecha_ingreso, e.fecha_salida, e.sueldo, e.id_jornada, e.causa_salida,
                                         c.id_tipo as id_tipocontrato, id_tipotrabajador, e.editdiastrab
                                  FROM empleado e
                                  LEFT JOIN contrato c on c.id = e.id_contrato
                                  WHERE e.codigoreloj = '$codigoreloj'");
      $result = $query->result();
      if ($result)
        return $result[0];
      else
        return NULL;
    }

}
