<?php

/* ------------------------------------------------
  ARCHIVO: asistencia_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la asistencia.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */

class Asistencia_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* lista de empleados */
    public function lst_asistencia($fecha, $hasta, $opcemp = 0) {
        $cond = "";
        $usua = $this->session->userdata('usua');
        if ($usua->perfil != 1) { 
          $idemp = 0;
          if ($usua->id_empleado != NULL) { $idemp = $usua->id_empleado; }
          if ($usua->perfil == 2) { 
            $cond = " AND e.id_departamento IN (SELECT id FROM departamento WHERE id_jefedepartamento = $idemp)"; 
          }
          if ($usua->perfil == 3) { 
            $cond = " AND e.id_empleado = $idemp"; 
          }
        }

        $query = $this->db->query("SELECT a.id, a.fecha, a.entrada_trabajo, a.salida_trabajo, 
                                          a.salida_almuerzo, a.entrada_almuerzo, a.codigoreloj,
                                          a.id_empleado, e.nombres, e.apellidos, e.nro_ident
                                     FROM asistencia a
                                     INNER JOIN empleado e on e.id_empleado = a.id_empleado
                                     Where a.fecha between '$fecha' AND '$hasta' AND
                                           (($opcemp = 0) OR (e.id_empleado = $opcemp)) $cond
                                     ORDER BY e.apellidos, e.nombres;");
        $result = $query->result();
        return $result;
    }
    public function add_asistencia($fecha, $empleado, $entrada_trabajo, $salida_almuerzo, $entrada_almuerzo, $salida_trabajo) {
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

        $query = $this->db->query("SELECT codigoreloj FROM empleado WHERE id_empleado = $empleado;");
        $result = $query->result();
        $codigoreloj = $result[0]->codigoreloj;

        $this->db->query("INSERT INTO asistencia (fecha, id_empleado, codigoreloj, entrada_trabajo, salida_almuerzo, 
                                                  entrada_almuerzo, salida_trabajo)
                            VALUES ('$fecha', $empleado, '$codigoreloj', $entrada_trabajo, $salida_almuerzo, 
                                    $entrada_almuerzo, $salida_trabajo)");        
    }
    public function upd_asistencia($id, $fecha, $empleado, $entrada_trabajo, $salida_almuerzo, 
                                   $entrada_almuerzo, $salida_trabajo) {
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

        $query = $this->db->query("SELECT codigoreloj FROM empleado WHERE id_empleado = $empleado;");
        $result = $query->result();
        $codigoreloj = $result[0]->codigoreloj;

        $this->db->query("UPDATE asistencia SET 
                             fecha = '$fecha', 
                             id_empleado = $empleado,
                             codigoreloj = '$codigoreloj', 
                             entrada_trabajo = $entrada_trabajo,
                             salida_almuerzo = $salida_almuerzo, 
                             entrada_almuerzo = $entrada_almuerzo,
                             salida_trabajo = $salida_trabajo
                            WHERE id = $id");        
    }

    public function candel_asistencia($id){
      $query = $this->db->query("SELECT count(*) as cant FROM empleado WHERE id_asistencia = $id");
      $result = $query->result();
      if ($result[0]->cant == 0)
        { return 1; }
      else
        { return 0; }
    }

    public function del_asistencia($id) {
      /*if ($this->candel_asistencia($id_asistencia) == 1){
        $query = $this->db->query("DELETE FROM asistencia WHERE id = $id_asistencia");
        return 1;
      } else {
        return 0;
      }       */
        $this->db->query("DELETE FROM asistencia WHERE id = $id");
        return 1;
    }

    public function sel_asistencia_id($id){
      $query = $this->db->query("SELECT id, fecha, id_empleado, codigoreloj, entrada_trabajo, salida_almuerzo, 
                                        entrada_almuerzo, salida_trabajo
                                  FROM asistencia 
                                  Where id = $id");
      $result = $query->result();
      return $result[0];
    }

    /* lista de empleados */
    public function lst_empleadofecha($fecha, $idempleado = 0) {
        $cond = "";
        $usua = $this->session->userdata('usua');
        if ($usua->perfil == 2) { 
          $idemp = 0;
          if ($usua->id_empleado != NULL) { $idemp = $usua->id_empleado; }
          $cond = " e.id_departamento IN (SELECT id FROM departamento WHERE id_jefedepartamento = $idemp) AND "; 
        }

        $query = $this->db->query("SELECT e.id_empleado, e.nombres, e.apellidos, e.nro_ident
                                     FROM empleado e
                                     WHERE e.activo = 1 AND $cond
                                           (e.id_empleado = $idempleado OR 
                                            NOT e.id_empleado IN (SELECT id_empleado FROM asistencia WHERE fecha = '$fecha'))
                                     ORDER BY e.apellidos, e.nombres;");
        $result = $query->result();
        return $result;
    }

    public function lst_empleado() {
        $cond = "";
        $usua = $this->session->userdata('usua');
        if ($usua->perfil == 2) { 
          $idemp = 0;
          if ($usua->id_empleado != NULL) { $idemp = $usua->id_empleado; }
          $cond = " AND e.id_departamento IN (SELECT id FROM departamento WHERE id_jefedepartamento = $idemp) "; 
        }

        $query = $this->db->query("SELECT 1 as tipo, e.id_empleado, e.nombres, e.apellidos, e.nro_ident
                                     FROM empleado e
                                     WHERE e.activo = 1 $cond
                                   UNION SELECT 0 as tipo, 0 as id_empleado, '' as nombres, ' TODOS' as apellidos, '' as nro_ident         
                                     ORDER BY tipo, apellidos, nombres;");
        $result = $query->result();
        return $result;
    }

    public function sel_asistencia_fecha($emp, $fecha){
      $query = $this->db->query("SELECT id, fecha, id_empleado, codigoreloj, entrada_trabajo, salida_almuerzo, 
                                        entrada_almuerzo, salida_trabajo
                                  FROM asistencia 
                                  Where id_empleado = $emp AND fecha = '$fecha'");
      $result = $query->result();
      if ($result){
        return $result[0];
      }
      else{
        return NULL;
      }
    }

}
