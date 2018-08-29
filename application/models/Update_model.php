<?php

/* ------------------------------------------------
  ARCHIVO: Update_model.php
  DESCRIPCION: Manejo de consultas para la actualizacion de BD.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */

class Update_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function actualizabase(){


      $res = $this->existe_tabla('departamento');
      if ($res != true) $this->crea_tabla_departamento();

      $res = $this->existe_tabla('empleado');
      if ($res != true) $this->crea_tabla_empleado();

      $res = $this->existe_tabla('paises');
      if ($res != true) $this->crea_tabla_paises();

      $res = $this->existe_tabla('ciudad');
      if ($res != true) $this->crea_tabla_ciudad();

      $this->chequea_tabla_perfil();

      $res = $this->existe_tabla('cargafamiliar');
      if ($res != true) $this->crea_tabla_cargafamiliar();

      $res = $this->existe_tabla('empleado_tmp');
      if ($res != true) $this->crea_tabla_empleado_tmp();

      $res = $this->existe_tabla('cargafamiliar_tmp');
      if ($res != true) $this->crea_tabla_cargafamiliar_tmp();

      $this->chequea_tabla_parentesco();
      $this->chequea_tabla_estadocivil();
      $this->chequea_tabla_tipovivienda();
      $this->chequea_tabla_region();
      $this->chequea_tabla_niveleducacion();
      $this->chequea_tabla_tipocuentabanco();
      $this->chequea_tabla_tiposangre();
      $this->chequea_tabla_tipodiscapacidad();

      $res = $this->existe_columna_tabla('empleado','profesion');
      if ($res != true) $this->add_columna_tabla('empleado','profesion', 'varchar(100)', "");
      $res = $this->existe_columna_tabla('empleado','region');
      if ($res != true) $this->add_columna_tabla('empleado','region', 'varchar(50)', "");

      $res = $this->existe_columna_tabla('empleado','apellidos');
      if ($res != true) $this->add_columna_tabla('empleado','apellidos', 'varchar(100)', "");
      $res = $this->existe_columna_tabla('empleado','lugarexpedicion');
      if ($res != true) $this->add_columna_tabla('empleado','lugarexpedicion', 'varchar(100)', "");
      $res = $this->existe_columna_tabla('empleado','cedulamilitar');
      if ($res != true) $this->add_columna_tabla('empleado','cedulamilitar', 'varchar(50)', "");
      $res = $this->existe_columna_tabla('empleado','pasaporte');
      if ($res != true) $this->add_columna_tabla('empleado','pasaporte', 'varchar(50)', "");
      $res = $this->existe_columna_tabla('empleado','fecha_nacimiento');
      if ($res != true) $this->add_columna_tabla('empleado','fecha_nacimiento', 'date', "");
      $res = $this->existe_columna_tabla('empleado','sexo');
      if ($res != true) $this->add_columna_tabla('empleado','sexo', 'char(1)', "");
      $res = $this->existe_columna_tabla('empleado','id_estadocivil');
      if ($res != true) $this->add_columna_tabla('empleado','id_estadocivil', 'int', "");
      $res = $this->existe_columna_tabla('empleado','peso');
      if ($res != true) $this->add_columna_tabla('empleado','peso', 'numeric(10,2)', "");
      $res = $this->existe_columna_tabla('empleado','talla');
      if ($res != true) $this->add_columna_tabla('empleado','talla', 'numeric(10,2)', "");
      $res = $this->existe_columna_tabla('empleado','celular_empleado');
      if ($res != true) $this->add_columna_tabla('empleado','celular_empleado', 'varchar(100)', "");
      $res = $this->existe_columna_tabla('empleado','codigoreloj');
      if ($res != true) $this->add_columna_tabla('empleado','codigoreloj', 'varchar(100)', "");
      $res = $this->existe_columna_tabla('empleado','calleprincipal');
      if ($res != true) $this->add_columna_tabla('empleado','calleprincipal', 'varchar(50)', "");
      $res = $this->existe_columna_tabla('empleado','numerovivienda');
      if ($res != true) $this->add_columna_tabla('empleado','numerovivienda', 'varchar(20)', "");
      $res = $this->existe_columna_tabla('empleado','calletransversal');
      if ($res != true) $this->add_columna_tabla('empleado','calletransversal', 'varchar(50)', "");
      $res = $this->existe_columna_tabla('empleado','sector');
      if ($res != true) $this->add_columna_tabla('empleado','sector', 'varchar(50)', "");
      $res = $this->existe_columna_tabla('empleado','referenciavivienda');
      if ($res != true) $this->add_columna_tabla('empleado','referenciavivienda', 'varchar(50)', "");
      $res = $this->existe_columna_tabla('empleado','id_ciudad');
      if ($res != true) $this->add_columna_tabla('empleado','id_ciudad', 'int', "");
      $res = $this->existe_columna_tabla('empleado','id_tipovivienda');
      if ($res != true) $this->add_columna_tabla('empleado','id_tipovivienda', 'int', "");
      $res = $this->existe_columna_tabla('empleado','vivefamiliares');
      if ($res != true) $this->add_columna_tabla('empleado','vivefamiliares', 'int', "");
      $res = $this->existe_columna_tabla('empleado','id_banco');
      if ($res != true) $this->add_columna_tabla('empleado','id_banco', 'int', "");
      $res = $this->existe_columna_tabla('empleado','id_tipocuenta');
      if ($res != true) $this->add_columna_tabla('empleado','id_tipocuenta', 'int', "");
      $res = $this->existe_columna_tabla('empleado','numerocuenta');
      if ($res != true) $this->add_columna_tabla('empleado','numerocuenta', 'varchar(50)', "");
      $res = $this->existe_columna_tabla('empleado','nombrecontacto');
      if ($res != true) $this->add_columna_tabla('empleado','nombrecontacto', 'varchar(100)', "");
      $res = $this->existe_columna_tabla('empleado','direccioncontacto');
      if ($res != true) $this->add_columna_tabla('empleado','direccioncontacto', 'varchar(100)', "");
      $res = $this->existe_columna_tabla('empleado','id_parentescocontacto');
      if ($res != true) $this->add_columna_tabla('empleado','id_parentescocontacto', 'int', "");
      $res = $this->existe_columna_tabla('empleado','telefonocontacto');
      if ($res != true) $this->add_columna_tabla('empleado','telefonocontacto', 'varchar(50)', "");
      $res = $this->existe_columna_tabla('empleado','id_empresa');
      if ($res != true) $this->add_columna_tabla('empleado','id_empresa', 'int', "");
      $res = $this->existe_columna_tabla('empleado','id_tiposangre');
      if ($res != true) $this->add_columna_tabla('empleado','id_tiposangre', 'int', "");
      $res = $this->existe_columna_tabla('empleado','id_tipodiscapacidad');
      if ($res != true) $this->add_columna_tabla('empleado','id_tipodiscapacidad', 'int', "");
      $res = $this->existe_columna_tabla('empleado','p100discapacidad');
      if ($res != true) $this->add_columna_tabla('empleado','p100discapacidad', 'numeric(10,2)', "");
      $res = $this->existe_columna_tabla('empleado','id_contrato');
      if ($res != true) $this->add_columna_tabla('empleado','id_contrato', 'int', "");
      $res = $this->existe_columna_tabla('empleado','id_cargo');
      if ($res != true) $this->add_columna_tabla('empleado','id_cargo', 'int', "");
      $res = $this->existe_columna_tabla('empleado','fecha_ingreso');
      if ($res != true) $this->add_columna_tabla('empleado','fecha_ingreso', 'date', "");
      $res = $this->existe_columna_tabla('empleado','fecha_salida');
      if ($res != true) $this->add_columna_tabla('empleado','fecha_salida', 'date', "");
      $res = $this->existe_columna_tabla('empleado','sueldo');
      if ($res != true) $this->add_columna_tabla('empleado','sueldo', 'numeric(10,2)', "");

      $res = $this->existe_tabla('tipobanco');
      if ($res != true) $this->crea_tabla_tipobanco();
      $res = $this->existe_tabla('banco');
      if ($res != true) $this->crea_tabla_banco();

      $res = $this->existe_columna_tabla('banco','tipo');
      if ($res != true) $this->add_columna_tabla('banco','tipo', 'int', "update banco set tipo=1");

      $res = $this->existe_tabla('cargo');
      if ($res != true) $this->crea_tabla_cargo();

      $res = $this->existe_tabla('empresa');
      if ($res != true) $this->crea_tabla_empresa();

      $res = $this->existe_tabla('provincia');
      if ($res != true) $this->crea_tabla_provincia();

      $res = $this->existe_columna_tabla('ciudad','id_provincia');
      if ($res != true) $this->add_columna_tabla('ciudad','id_provincia', 'int', "");

      $res = $this->existe_tabla('tipocontrato');
      if ($res != true) $this->crea_tabla_tipocontrato();

      $res = $this->existe_tabla('contrato');
      if ($res != true) $this->crea_tabla_contrato();

      $res = $this->existe_tabla('tiporubro');
      if ($res != true) $this->crea_tabla_tiporubro();

      $res = $this->existe_tabla('rubro');
      if ($res != true) $this->crea_tabla_rubro();
      $res = $this->existe_tabla('rubro_empleado');
      if ($res != true) $this->crea_tabla_rubro_empleado();
      $res = $this->existe_tabla('rubro_empleado_tmp');
      if ($res != true) $this->crea_tabla_rubro_empleado_tmp();
      $res = $this->existe_tabla('tipotrabajador');
      if ($res != true) $this->crea_tabla_tipotrabajador();

      $res = $this->existe_tabla('roldepagos');
      if ($res != true) $this->crea_tabla_roldepagos();
      $res = $this->existe_tabla('roldepagos_tmp');
      if ($res != true) $this->crea_tabla_roldepagos_tmp();

      $res = $this->existe_tabla('roldepagos_det');
      if ($res != true) $this->crea_tabla_roldepagos_det();
      $res = $this->existe_tabla('roldepagos_tmpdet');
      if ($res != true) $this->crea_tabla_roldepagos_tmpdet();

      $res = $this->existe_tabla('parametros');
      if ($res != true) $this->crea_tabla_parametros();

      $res = $this->existe_tabla('jornada');
      if ($res != true) $this->crea_tabla_jornada();

      $res = $this->existe_columna_tabla('empleado','id_jornada');
      if ($res != true) $this->add_columna_tabla('empleado','id_jornada', 'int', "");

      $res = $this->existe_columna_tabla('contrato','causa_salida');
      if ($res != true) $this->add_columna_tabla('contrato','causa_salida', 'varchar(255)', "");

      $res = $this->existe_columna_tabla('empleado','causa_salida');
      if ($res != true) $this->add_columna_tabla('empleado','causa_salida', 'varchar(255)', "");

      $res = $this->existe_tabla('asistencia');
      if ($res != true) $this->crea_tabla_asistencia();

      $res = $this->existe_tabla('permisoausencia');
      if ($res != true) $this->crea_tabla_permisoausencia();

      $res = $this->existe_columna_tabla('usu_sistemas','id_empleado');
      if ($res != true) $this->add_columna_tabla('usu_sistemas','id_empleado', 'int', "");

      $res = $this->existe_columna_tabla('usu_sistemas','ape_usu');
      if ($res == true){
        $this->drop_tabla('usu_sistemas');
        $this->crea_tabla_usu_sistemas();
      }  

      $res = $this->existe_columna_tabla('paises','codigo_pais');
      if ($res != true) $this->add_columna_tabla('paises','codigo_pais', 'varchar(20)', "");

      $res = $this->existe_tabla('configuracion');
      if ($res != true) $this->crea_tabla_configuracion();

      return 1;
    }

    public function existe_tabla($tabla){
      $mydb = $this->db->database;
      $query = $this->db->query("SELECT count(*) as cant 
                                    FROM pg_tables
                                    WHERE schemaname = 'public'
                                    AND tablename = '$tabla'");
      $r = $query->result();
      if ($r != null){
        $myresult = ($r[0]->cant > 0);
      } else {
        $myresult = false;      
      } 
      return $myresult;
    }

    public function existe_columna_tabla($tabla, $columna){
      $query = $this->db->query("select count(*) as cant
                                  from information_schema.columns
                                  where column_name = '$columna'
                                    and table_name = '$tabla'");
      $r = $query->result();
      if ($r != null){
        $myresult = ($r[0]->cant > 0);
      } else {
        $myresult = false;      
      } 
      return $myresult;
    }

    public function add_columna_tabla($tabla, $columna, $tipodato, $consulta){
      $query = $this->db->query("ALTER TABLE $tabla ADD $columna $tipodato");
      if (trim($consulta) != ""){
        $query = $this->db->query($consulta);
      } 
    }

    public function drop_columna_tabla($tabla, $columna){
      $query = $this->db->query("ALTER TABLE $tabla DROP COLUMN $columna");
      if (trim($consulta) != ""){
        $query = $this->db->query($consulta);
      } 
    }

    public function upd_columna_tabla($tabla, $columna, $tipodato){
      $query = $this->db->query("ALTER TABLE $tabla ALTER COLUMN $columna $tipodato");
    }

    public function drop_tabla($tabla){
      $this->db->query("DROP TABLE IF EXISTS $tabla;");
    }

    public function crea_tabla_departamento(){
      $query = $this->db->query("CREATE TABLE departamento (
                                    id SERIAL,
                                    nombre_departamento varchar(255),
                                    id_jefedepartamento int,
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");

    }
    public function crea_tabla_paises(){
      $query = $this->db->query("CREATE TABLE paises (
                                    id SERIAL,
                                    nombre_pais varchar(255),
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");

    }
    public function crea_tabla_provincia(){
      $query = $this->db->query("CREATE TABLE provincia (
                                    id SERIAL,
                                    nombre_provincia varchar(255),
                                    id_pais int,
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");

    }
    public function crea_tabla_ciudad(){
      $query = $this->db->query("CREATE TABLE ciudad (
                                    id SERIAL,
                                    nombre_ciudad varchar(255),
                                    id_provincia int,
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");

    }
    public function crea_tabla_empleado(){
      $query = $this->db->query("CREATE TABLE empleado (
                                    id_empleado SERIAL,
                                    nombres varchar(255),
                                    tipo_identificacion int,
                                    telf_empleado varchar(255),
                                    nro_ident varchar(255),
                                    correo_empleado varchar(255),
                                    foto_empleado bytea,
                                    perfil int,
                                    id_departamento int,
                                    activo int,
                                    PRIMARY KEY (id_empleado) 
                                    )");

    }

    public function chequea_tabla_perfil(){
      $res = $this->existe_tabla('perfil');
      if ($res == true) {
            $query = $this->db->query("SELECT count(*) as cant FROM perfil");
            $r = $query->result();
            $res = ($r[0]->cant != 3);
      }
      if ($res != true){
            $this->db->query("DROP TABLE IF EXISTS perfil;");
            $this->db->query("CREATE TABLE perfil (
                                id_perfil int NOT NULL,
                                nom_perfil varchar(255) DEFAULT NULL,
                                PRIMARY KEY (id_perfil)
                              )");

            $this->db->query("INSERT INTO perfil (id_perfil, nom_perfil) VALUES(1, 'Administrador')");
            $this->db->query("INSERT INTO perfil (id_perfil, nom_perfil) VALUES(2, 'Jefe Departamento')");
            $this->db->query("INSERT INTO perfil (id_perfil, nom_perfil) VALUES(3, 'Empleado')");
      }        
    }

    public function crea_tabla_cargafamiliar(){
      $this->db->query("CREATE TABLE cargafamiliar (
                          id SERIAL,
                          id_empleado int,
                          nombres_familiar varchar(255),
                          apellidos_familiar varchar(255),
                          nro_ident varchar(100),
                          tipo_parentesco int,
                          telf_familiar varchar(100),
                          fecha_nacimiento date,
                          fecha_fallece date,
                          sexo char(1),/*M-Masculino, F-Femenino*/
                          activo int,
                          PRIMARY KEY (id) 
                          )");

    }

    public function crea_tabla_empleado_tmp(){
      $this->db->query("CREATE TABLE empleado_tmp (
                          id SERIAL,
                          id_empleado int,
                          id_usuario int,
                          PRIMARY KEY (id) 
                          )");

    }

    public function crea_tabla_cargafamiliar_tmp(){
      $this->db->query("CREATE TABLE cargafamiliar_tmp (
                          id SERIAL,
                          id_empleadotmp int,
                          nombres_familiar varchar(255),
                          apellidos_familiar varchar(255),
                          nro_ident varchar(100),
                          tipo_parentesco int,
                          telf_familiar varchar(100),
                          fecha_nacimiento date,
                          fecha_fallece date,
                          sexo char(1),/*M-Masculino, F-Femenino*/
                          activo int,
                          PRIMARY KEY (id) 
                          )");

    }

    public function chequea_tabla_parentesco(){
      $res = $this->existe_tabla('parentesco');
      if ($res == true) {
            $query = $this->db->query("SELECT count(*) as cant FROM parentesco");
            $r = $query->result();
            $res = ($r[0]->cant != 7);
      }
      if ($res != true){
            $this->db->query("DROP TABLE IF EXISTS parentesco;");

            $this->db->query("CREATE TABLE parentesco (
                                id int,
                                parentesco varchar(255),
                                PRIMARY KEY (id) 
                                )");
            $this->db->query("INSERT INTO parentesco (id, parentesco) VALUES(1, 'Hijo(a)')");
            $this->db->query("INSERT INTO parentesco (id, parentesco) VALUES(2, 'Conyuge')");
            $this->db->query("INSERT INTO parentesco (id, parentesco) VALUES(3, 'Madre')");
            $this->db->query("INSERT INTO parentesco (id, parentesco) VALUES(4, 'Padre')");
            $this->db->query("INSERT INTO parentesco (id, parentesco) VALUES(5, 'Hermano(a)')");
            $this->db->query("INSERT INTO parentesco (id, parentesco) VALUES(6, 'Nieto(a)')");
            $this->db->query("INSERT INTO parentesco (id, parentesco) VALUES(7, 'Abuelo(a)')");
      }      
    }

    public function chequea_tabla_estadocivil(){
      $res = $this->existe_tabla('estadocivil');
      if ($res == true) {
            $query = $this->db->query("SELECT count(*) as cant FROM estadocivil");
            $r = $query->result();
            $res = ($r[0]->cant != 5);
      }
      if ($res != true){
            $this->db->query("DROP TABLE IF EXISTS estadocivil;");

            $this->db->query("CREATE TABLE estadocivil (
                                id int,
                                estadocivil varchar(255),
                                PRIMARY KEY (id) 
                                )");
            $this->db->query("INSERT INTO estadocivil (id, estadocivil) VALUES(1, 'Soltero(a)')");
            $this->db->query("INSERT INTO estadocivil (id, estadocivil) VALUES(2, 'Casado(a)')");
            $this->db->query("INSERT INTO estadocivil (id, estadocivil) VALUES(3, 'Viudo(a)')");
            $this->db->query("INSERT INTO estadocivil (id, estadocivil) VALUES(4, 'Divorciado(a)')");
            $this->db->query("INSERT INTO estadocivil (id, estadocivil) VALUES(5, 'Union Libre')");
      }      
    }

    public function chequea_tabla_tipovivienda(){
      $res = $this->existe_tabla('tipovivienda');
      if ($res == true) {
            $query = $this->db->query("SELECT count(*) as cant FROM tipovivienda");
            $r = $query->result();
            $res = ($r[0]->cant != 2);
      }
      if ($res != true){
            $this->db->query("DROP TABLE IF EXISTS tipovivienda;");

            $this->db->query("CREATE TABLE tipovivienda (
                                id int,
                                tipovivienda varchar(255),
                                PRIMARY KEY (id) 
                                )");
            $this->db->query("INSERT INTO tipovivienda (id, tipovivienda) VALUES(1, 'Propia')");
            $this->db->query("INSERT INTO tipovivienda (id, tipovivienda) VALUES(2, 'Arrendada')");
      }      
    }
    public function chequea_tabla_region(){
      $res = $this->existe_tabla('region');
      if ($res == true) {
            $query = $this->db->query("SELECT count(*) as cant FROM region");
            $r = $query->result();
            $res = ($r[0]->cant != 2);
      }
      if ($res != true){
            $this->db->query("DROP TABLE IF EXISTS region;");

            $this->db->query("CREATE TABLE region (
                                id int,
                                region varchar(80),
                                PRIMARY KEY (id) 
                                )");
            $this->db->query("INSERT INTO region (id, region) VALUES(1, 'COSTA')");
            $this->db->query("INSERT INTO region (id, region) VALUES(2, 'SIERRA')");
            $this->db->query("INSERT INTO region (id, region) VALUES(3, 'ORIENTE')");
            $this->db->query("INSERT INTO region (id, region) VALUES(4, 'INSULAR')");


      }      
    }
    public function chequea_tabla_niveleducacion(){
      $res = $this->existe_tabla('nivel_educacion');
      if ($res == true) {
            $query = $this->db->query("SELECT count(*) as cant FROM nivel_educacion");
            $r = $query->result();
            $res = ($r[0]->cant != 2);
      }
      if ($res != true){
            $this->db->query("DROP TABLE IF EXISTS nivel_educacion;");

            $this->db->query("CREATE TABLE nivel_educacion (
                                id int,
                                nivel_educacion varchar(80),
                                PRIMARY KEY (id) 
                                )");
            $this->db->query("INSERT INTO nivel_educacion (id, nivel_educacion) VALUES(1, 'PRIMARIA')");
            $this->db->query("INSERT INTO nivel_educacion (id, nivel_educacion) VALUES(2, 'SECUNDARIA')");
            $this->db->query("INSERT INTO nivel_educacion (id, nivel_educacion) VALUES(3, 'SUPERIOR')");
            $this->db->query("INSERT INTO nivel_educacion (id, nivel_educacion) VALUES(4, 'PRIMER NIVEL')");
            $this->db->query("INSERT INTO nivel_educacion (id, nivel_educacion) VALUES(5, 'SEGUNDO NIVEL')");
            $this->db->query("INSERT INTO nivel_educacion (id, nivel_educacion) VALUES(6, 'TERCER NIVEL')");


      }      
    }
    

    public function chequea_tabla_tipocuentabanco(){
      $res = $this->existe_tabla('tipocuentabanco');
      if ($res == true) {
            $query = $this->db->query("SELECT count(*) as cant FROM tipocuentabanco");
            $r = $query->result();
            $res = ($r[0]->cant != 2);
      }
      if ($res != true){
            $this->db->query("DROP TABLE IF EXISTS tipocuentabanco;");

            $this->db->query("CREATE TABLE tipocuentabanco (
                                id int,
                                tipocuentabanco varchar(255),
                                PRIMARY KEY (id) 
                                )");
            $this->db->query("INSERT INTO tipocuentabanco (id, tipocuentabanco) VALUES(1, 'Corriente')");
            $this->db->query("INSERT INTO tipocuentabanco (id, tipocuentabanco) VALUES(2, 'Ahorro')");
      }      
    }

    public function crea_tabla_banco(){
      $this->db->query("CREATE TABLE banco (
                                    id SERIAL,
                                    nombre_banco varchar(255),
                                    tipo int,
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");
    }

    public function crea_tabla_tipobanco(){
      $this->db->query("CREATE TABLE tipobanco (
                                    id int,
                                    nombre varchar(255),
                                    PRIMARY KEY (id) 
                                    )");
      $this->db->query("INSERT INTO tipobanco (id, nombre) VALUES(1, 'Banco')");
      $this->db->query("INSERT INTO tipobanco (id, nombre) VALUES(2, 'Cooperativa de Ahorro y Credito')");
    }

    public function chequea_tabla_tiposangre(){
      $res = $this->existe_tabla('tiposangre');
      if ($res == true) {
            $query = $this->db->query("SELECT count(*) as cant FROM tiposangre");
            $r = $query->result();
            $res = ($r[0]->cant != 8);
      }
      if ($res != true){
            $this->db->query("DROP TABLE IF EXISTS tiposangre;");

            $this->db->query("CREATE TABLE tiposangre (
                                id int,
                                tiposangre varchar(255),
                                PRIMARY KEY (id) 
                                )");
            $this->db->query("INSERT INTO tiposangre (id, tiposangre) VALUES(1, 'A negativo')");
            $this->db->query("INSERT INTO tiposangre (id, tiposangre) VALUES(2, 'A positivo')");
            $this->db->query("INSERT INTO tiposangre (id, tiposangre) VALUES(3, 'B negativo')");
            $this->db->query("INSERT INTO tiposangre (id, tiposangre) VALUES(4, 'B positivo')");
            $this->db->query("INSERT INTO tiposangre (id, tiposangre) VALUES(5, 'AB negativo')");
            $this->db->query("INSERT INTO tiposangre (id, tiposangre) VALUES(6, 'AB positivo')");
            $this->db->query("INSERT INTO tiposangre (id, tiposangre) VALUES(7, 'O negativo')");
            $this->db->query("INSERT INTO tiposangre (id, tiposangre) VALUES(8, 'O positivo')");
      }      
    }

    public function chequea_tabla_tipodiscapacidad(){
      $res = $this->existe_tabla('tipodiscapacidad');
      if ($res == true) {
            $query = $this->db->query("SELECT count(*) as cant FROM tipodiscapacidad");
            $r = $query->result();
            $res = ($r[0]->cant != 6);
      }
      if ($res != true){
            $this->db->query("DROP TABLE IF EXISTS tipodiscapacidad;");

            $this->db->query("CREATE TABLE tipodiscapacidad (
                                id int,
                                tipodiscapacidad varchar(255),
                                PRIMARY KEY (id) 
                                )");
            $this->db->query("INSERT INTO tipodiscapacidad (id, tipodiscapacidad) VALUES(1, 'Auditiva')");
            $this->db->query("INSERT INTO tipodiscapacidad (id, tipodiscapacidad) VALUES(2, 'Física')");
            $this->db->query("INSERT INTO tipodiscapacidad (id, tipodiscapacidad) VALUES(3, 'Intelectual')");
            $this->db->query("INSERT INTO tipodiscapacidad (id, tipodiscapacidad) VALUES(4, 'Lenguaje')");
            $this->db->query("INSERT INTO tipodiscapacidad (id, tipodiscapacidad) VALUES(5, 'Psicosocial')");
            $this->db->query("INSERT INTO tipodiscapacidad (id, tipodiscapacidad) VALUES(6, 'Visual')");
      }      
    }

    public function crea_tabla_cargo(){
      $this->db->query("CREATE TABLE cargo (
                                    id SERIAL,
                                    nombre_cargo varchar(255),
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");
    }

    public function crea_tabla_empresa(){
      $this->db->query("CREATE TABLE empresa (
                                    id SERIAL,
                                    nombre_empresa varchar(255),
                                    ruc_empresa varchar(255),
                                    representante_empresa varchar(255),
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");
    }

    public function crea_tabla_tipocontrato(){
      $this->db->query("CREATE TABLE tipocontrato (
                                    id SERIAL,
                                    tipocontrato varchar(255),
                                    PRIMARY KEY (id) 
                                    )");
      $this->db->query("INSERT INTO tipocontrato (id, tipocontrato) VALUES(1, 'Tiempo Indefinido')");
      $this->db->query("INSERT INTO tipocontrato (id, tipocontrato) VALUES(2, 'Eventual')");
      $this->db->query("INSERT INTO tipocontrato (id, tipocontrato) VALUES(3, 'Ocasional')");
      $this->db->query("INSERT INTO tipocontrato (id, tipocontrato) VALUES(4, 'De Temporada')");
      $this->db->query("INSERT INTO tipocontrato (id, tipocontrato) VALUES(5, 'Por Obra Cierta')");
      $this->db->query("INSERT INTO tipocontrato (id, tipocontrato) VALUES(6, 'De Aprendizaje')");
      $this->db->query("INSERT INTO tipocontrato (id, tipocontrato) VALUES(7, 'Por Tarea')");
      $this->db->query("INSERT INTO tipocontrato (id, tipocontrato) VALUES(8, 'A Destajo')");
    }

    public function crea_tabla_contrato(){
      $this->db->query("CREATE TABLE contrato (
                                    id SERIAL,
                                    id_tipo int,
                                    id_empleado int,
                                    id_cargo int,
                                    fecha_inicio date,
                                    fecha_fin date,
                                    causa_salida varchar(255),
                                    sueldo numeric(10,2),
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");
    }

    public function crea_tabla_tiporubro(){
      $this->db->query("CREATE TABLE tiporubro (
                                    id SERIAL,
                                    tiporubro varchar(255),
                                    ingresoegreso int,
                                    PRIMARY KEY (id) 
                                    )");
      $this->db->query("INSERT INTO tiporubro (id, tiporubro, ingresoegreso) VALUES(1, 'Ingreso', 1)");
      $this->db->query("INSERT INTO tiporubro (id, tiporubro, ingresoegreso) VALUES(2, 'Egreso', -1)");
      $this->db->query("INSERT INTO tiporubro (id, tiporubro, ingresoegreso) VALUES(3, 'Informativo', 1)");
    }

    public function crea_tabla_rubro(){
      $this->db->query("CREATE TABLE rubro (
                                    id SERIAL,
                                    codigo_rubro varchar(4),
                                    nombre_rubro varchar(255),
                                    tipo_rubro int,
                                    afectadopordias int,
                                    periodicidadmensual int,
                                    mesactivo int,
                                    diasgracia int,
                                    editable int,
                                    expresioncalculo varchar(500),
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");
    }

    public function crea_tabla_rubro_empleado(){
      $this->db->query("CREATE TABLE rubro_empleado (
                                    id SERIAL,
                                    id_rubro int,
                                    id_empleado int,
                                    valor_neto numeric(10,2),
                                    PRIMARY KEY (id) 
                                    )");
    }

    public function crea_tabla_rubro_empleado_tmp(){
      $this->db->query("CREATE TABLE rubro_empleado_tmp (
                                    id_usuario int,
                                    id_rubro int,
                                    id_empleadotmp int,
                                    existe int,
                                    valor_neto numeric(10,2),
                                    PRIMARY KEY (id_usuario, id_rubro, id_empleadotmp) 
                                    )");
    }

    public function crea_tabla_roldepagos(){
      $this->db->query("CREATE TABLE roldepagos (
                                    id SERIAL,
                                    descripcion_rol varchar(255),
                                    fechaini_rol date,
                                    fechafin_rol date,
                                    estado_rol int,
                                    asistencia_ini date,
                                    asistencia_fin date,
                                    PRIMARY KEY (id) 
                                    )");
    }

    public function crea_tabla_roldepagos_tmp(){
      $this->db->query("CREATE TABLE roldepagos_tmp (
                                    id_usuario int,
                                    descripcion_rol varchar(255),
                                    fechaini_rol date,
                                    fechafin_rol date,
                                    estado_rol int,
                                    asistencia_ini date,
                                    asistencia_fin date,
                                    PRIMARY KEY (id_usuario) 
                                    )");
    }

    public function crea_tabla_roldepagos_det(){
      $this->db->query("CREATE TABLE roldepagos_det (
                                    id SERIAL,
                                    id_rol int,
                                    id_empleado int,
                                    id_rubro int,
                                    valor_neto numeric(10,2),
                                    PRIMARY KEY (id) 
                                    )");
    }

    public function crea_tabla_roldepagos_tmpdet(){
      $this->db->query("CREATE TABLE roldepagos_tmpdet (
                                    id SERIAL,
                                    id_usuario int,
                                    id_empleado int,
                                    id_rubro int,
                                    valor_neto numeric(10,2),
                                    PRIMARY KEY (id) 
                                    )");
    }

    public function crea_tabla_tipotrabajador(){
      $query = $this->db->query("CREATE TABLE tipotrabajador (
                                    id SERIAL,
                                    tipo_trabajador varchar(120),
                                    descripcion varchar(255),
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");

    }

    public function crea_tabla_parametros(){
      $this->db->query("CREATE TABLE parametros (
                                    id int,
                                    descripcion varchar(255),
                                    valor varchar(255),
                                    PRIMARY KEY (id) 
                                    )");
      $this->db->query("INSERT INTO parametros (id, descripcion, valor) VALUES(1, 'IVA', '0.12')");
      $this->db->query("INSERT INTO parametros (id, descripcion, valor) VALUES(2, 'ID Rubro Sueldo Base', '')");
      $this->db->query("INSERT INTO parametros (id, descripcion, valor) VALUES(3, 'ID Rubro Dias Trabajados', '')");
      $this->db->query("INSERT INTO parametros (id, descripcion, valor) VALUES(4, 'ID Rubro Neto a Cobrar', '')");
    }

    public function crea_tabla_jornada(){
      $query = $this->db->query("CREATE TABLE jornada (
                                    id SERIAL,
                                    descripcion varchar(255),
                                    entrada_trabajo time,
                                    salida_almuerzo time,
                                    entrada_almuerzo time,
                                    salida_trabajo time,
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");

    }

    public function crea_tabla_asistencia(){
      $query = $this->db->query("CREATE TABLE asistencia (
                                    id SERIAL,
                                    fecha date,
                                    id_empleado int,
                                    codigoreloj varchar(100),
                                    entrada_trabajo time,
                                    salida_almuerzo time,
                                    entrada_almuerzo time,
                                    salida_trabajo time,
                                    PRIMARY KEY (id) 
                                    )");

    }

    public function crea_tabla_permisoausencia(){
      $query = $this->db->query("CREATE TABLE permisoausencia (
                                    id SERIAL,
                                    id_empleado int,
                                    fecha_desde date,
                                    hora_desde time,
                                    fecha_hasta date,
                                    hora_hasta time,
                                    motivo varchar(255),
                                    aprobado int,
                                    PRIMARY KEY (id) 
                                    )");

    }

    public function crea_tabla_usu_sistemas(){
      $query = $this->db->query("CREATE TABLE usu_sistemas (
                                    id_usu SERIAL,
                                    nom_usu varchar(255),
                                    log_usu varchar(255),
                                    pwd_usu varchar(255),
                                    est_usu varchar(3),
                                    fot_usu bytea,
                                    perfil int,
                                    id_empleado int,
                                    ultimoacceso timestamp,
                                    PRIMARY KEY (id_usu) 
                                    )");

      $this->db->query("INSERT INTO usu_sistemas (nom_usu, log_usu, pwd_usu, est_usu, perfil, ultimoacceso) 
                          VALUES('admin', 'admin', MD5('admin'), 'A', 1, now())");
    }

    public function crea_tabla_configuracion(){
      $query = $this->db->query("CREATE TABLE configuracion (
                                    id int,
                                    razonsocial varchar(255),
                                    nombrecomercial varchar(255),
                                    identificacion varchar(50),
                                    logo_empresa varchar(255),
                                    PRIMARY KEY (id) 
                                    )");

      $this->db->query("INSERT INTO configuracion (id, razonsocial, identificacion) 
                          VALUES(1, 'EMPRESA', '9999999999999')");
    }

}
