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
    public function crea_tabla_ciudad(){
      $query = $this->db->query("CREATE TABLE ciudad (
                                    id SERIAL,
                                    nombre_ciudad varchar(255),
                                    activo int,
                                    PRIMARY KEY (id) 
                                    )");

    }
    public function crea_tabla_empleado(){
      $query = $this->db->query("CREATE TABLE empleado (
                                    id_empleado SERIAL,
                                    nombre_empleado varchar(255),
                                    tipo_identificacion int,
                                    telf_empleado varchar(255),
                                    nro_ident varchar(255),
                                    correo_empleado varchar(255),
                                    direccion_empleado varchar(255),
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


}
