<?php

/* ------------------------------------------------
  ARCHIVO: jornada_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la jornada.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */

class Jornada_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* lista de empleados */
    public function lst_jornada() {
        $query = $this->db->query("SELECT id, descripcion, entrada_trabajo, salida_almuerzo, entrada_almuerzo, salida_trabajo, 
                                          activo, entrada_empresa, salida_empresa
                                     FROM jornada 
                                     Where activo = 1
                                     ORDER BY descripcion;");
        $result = $query->result();
        return $result;
    }
    public function add_jornada($descripcion, $entrada_trabajo, $salida_almuerzo, $entrada_almuerzo, $salida_trabajo, $activo, $entrada_empresa, $salida_empresa) {
        if ((!$entrada_trabajo) || (trim($entrada_trabajo) == '')) 
          { $entrada_trabajo = 'NULL'; }
        else 
          { $entrada_trabajo = "'" . $entrada_trabajo . "'"; }
        
        if ((!$salida_almuerzo) || (trim($salida_almuerzo) == '')) 
          { $salida_almuerzo = 'NULL'; }
        else 
          { $salida_almuerzo = "'" . $salida_almuerzo . "'"; }

        if ((!$entrada_almuerzo) || (trim($entrada_almuerzo) == '')) 
          { $entrada_almuerzo = 'NULL'; }
        else 
          { $entrada_almuerzo = "'" . $entrada_almuerzo . "'"; }

        if ((!$salida_trabajo) || (trim($salida_trabajo) == '')) 
          { $salida_trabajo = 'NULL'; }
        else 
          { $salida_trabajo = "'" . $salida_trabajo . "'"; }

        if ((!$entrada_empresa) || (trim($entrada_empresa) == '')) 
          { $entrada_empresa = 'NULL'; }
        else 
          { $entrada_empresa = "'" . $entrada_empresa . "'"; }

        if ((!$salida_empresa) || (trim($salida_empresa) == '')) 
          { $salida_empresa = 'NULL'; }
        else 
          { $salida_empresa = "'" . $salida_empresa . "'"; }

        $this->db->query("INSERT INTO jornada (descripcion, entrada_trabajo, salida_almuerzo, entrada_almuerzo, salida_trabajo, activo, 
                                               entrada_empresa, salida_empresa)
                            VALUES ('$descripcion', $entrada_trabajo, $salida_almuerzo, $entrada_almuerzo, $salida_trabajo, 
                                    $activo, $entrada_empresa, $salida_empresa)");        
    }
    public function upd_jornada($id, $descripcion, $entrada_trabajo, $salida_almuerzo, $entrada_almuerzo, $salida_trabajo, $activo, $entrada_empresa, $salida_empresa) {
        if ((!$entrada_trabajo) || (trim($entrada_trabajo) == '')) 
          { $entrada_trabajo = 'NULL'; }
        else 
          { $entrada_trabajo = "'" . $entrada_trabajo . "'"; }
        
        if ((!$salida_almuerzo) || (trim($salida_almuerzo) == '')) 
          { $salida_almuerzo = 'NULL'; }
        else 
          { $salida_almuerzo = "'" . $salida_almuerzo . "'"; }

        if ((!$entrada_almuerzo) || (trim($entrada_almuerzo) == '')) 
          { $entrada_almuerzo = 'NULL'; }
        else 
          { $entrada_almuerzo = "'" . $entrada_almuerzo . "'"; }

        if ((!$salida_trabajo) || (trim($salida_trabajo) == '')) 
          { $salida_trabajo = 'NULL'; }
        else 
          { $salida_trabajo = "'" . $salida_trabajo . "'"; }

        if ((!$entrada_empresa) || (trim($entrada_empresa) == '')) 
          { $entrada_empresa = 'NULL'; }
        else 
          { $entrada_empresa = "'" . $entrada_empresa . "'"; }

        if ((!$salida_empresa) || (trim($salida_empresa) == '')) 
          { $salida_empresa = 'NULL'; }
        else 
          { $salida_empresa = "'" . $salida_empresa . "'"; }

        $this->db->query("UPDATE jornada SET 
                             descripcion = '$descripcion', 
                             entrada_trabajo = $entrada_trabajo,
                             salida_almuerzo = $salida_almuerzo, 
                             entrada_almuerzo = $entrada_almuerzo,
                             salida_trabajo = $salida_trabajo, 
                             entrada_empresa = $entrada_empresa,
                             salida_empresa = $salida_empresa,
                             activo = $activo
                            WHERE id = $id");        
    }

    public function candel_jornada($id){
      $query = $this->db->query("SELECT count(*) as cant FROM empleado WHERE id_jornada = $id");
      $result = $query->result();
      if ($result[0]->cant == 0)
        { return 1; }
      else
        { return 0; }
    }

    public function del_jornada($id_jornada) {
      if ($this->candel_jornada($id_jornada) == 1){
        $query = $this->db->query("DELETE FROM jornada WHERE id = $id_jornada");
        return 1;
      } else {
        return 0;
      }       
    }

    public function sel_jornada_id($id){
      $query = $this->db->query("SELECT id, descripcion, entrada_trabajo, salida_almuerzo, entrada_almuerzo, salida_trabajo, 
                                        activo, entrada_empresa, salida_empresa
                                  FROM jornada 
                                  Where id = $id");
      $result = $query->result();
      return $result[0];
    }


}
