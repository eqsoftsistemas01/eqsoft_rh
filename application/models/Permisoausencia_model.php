<?php

/* ------------------------------------------------
  ARCHIVO: permisoausencia_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la permisoausencia.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */

class Permisoausencia_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* lista de empleados */
    public function lst_permisoausencia($desde, $hasta) {
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
        $query = $this->db->query("SELECT a.id, a.fecha_desde, a.hora_desde, a.fecha_hasta, a.hora_hasta,
                                          a.motivo, a.aprobado, a.id_tipopermiso,
                                          a.id_empleado, e.nombres, e.apellidos, e.nro_ident
                                     FROM permisoausencia a
                                     INNER JOIN empleado e on e.id_empleado = a.id_empleado
                                     Where ((date(fecha_desde) between '$desde' and '$hasta') OR
                                            (date(fecha_hasta) between '$desde' and '$hasta')) $cond
                                     ORDER BY e.apellidos, e.nombres;");
        $result = $query->result();
        return $result;
    }
    public function add_permisoausencia($empleado, $fecha_desde, $hora_desde, $fecha_hasta, $hora_hasta, $motivo, $aprobado, $tipopermiso) {
        if ((!$fecha_desde) || (trim($fecha_desde) == '')) { $fecha_desde = 'NULL'; }
        else { $fecha_desde = "to_date('" . $fecha_desde . "', 'YYYY-MM-DD')";  }
        if ((!$hora_desde) || (trim($hora_desde) == '')) { $hora_desde = 'NULL'; }
        else { $hora_desde = "'" . $hora_desde . "'"; }
        
        if ((!$fecha_hasta) || (trim($fecha_hasta) == '')) { $fecha_hasta = 'NULL'; }
        else { $fecha_hasta = "to_date('" . $fecha_hasta . "', 'YYYY-MM-DD')";  }
        if ((!$hora_hasta) || (trim($hora_hasta) == '')) { $hora_hasta = 'NULL'; }
        else { $hora_hasta = "'" . $hora_hasta . "'"; }
        if ((!$tipopermiso) || (trim($tipopermiso) == '')) { $tipopermiso = 'NULL'; }

        $this->db->query("INSERT INTO permisoausencia (id_empleado, fecha_desde, hora_desde, fecha_hasta, hora_hasta, motivo, aprobado, id_tipopermiso)
                            VALUES ($empleado, $fecha_desde, $hora_desde, $fecha_hasta, $hora_hasta, '$motivo', $aprobado, $tipopermiso)");        
    }
    public function upd_permisoausencia($id, $empleado, $fecha_desde, $hora_desde, $fecha_hasta, $hora_hasta, $motivo, $aprobado, $tipopermiso) {
        if ((!$fecha_desde) || (trim($fecha_desde) == '')) { $fecha_desde = 'NULL'; }
        else { $fecha_desde = "to_date('" . $fecha_desde . "', 'YYYY-MM-DD')";  }
        if ((!$hora_desde) || (trim($hora_desde) == '')) { $hora_desde = 'NULL'; }
        else { $hora_desde = "'" . $hora_desde . "'"; }
        
        if ((!$fecha_hasta) || (trim($fecha_hasta) == '')) { $fecha_hasta = 'NULL'; }
        else { $fecha_hasta = "to_date('" . $fecha_hasta . "', 'YYYY-MM-DD')";  }
        if ((!$hora_hasta) || (trim($hora_hasta) == '')) { $hora_hasta = 'NULL'; }
        else { $hora_hasta = "'" . $hora_hasta . "'"; }
        if ((!$tipopermiso) || (trim($tipopermiso) == '')) { $tipopermiso = 'NULL'; }

        $this->db->query("UPDATE permisoausencia SET 
                             id_empleado = $empleado,
                             fecha_desde = $fecha_desde, 
                             hora_desde = $hora_desde, 
                             fecha_hasta = $fecha_hasta, 
                             hora_hasta = $hora_hasta, 
                             motivo = '$motivo',
                             aprobado = $aprobado,
                             id_tipopermiso = $tipopermiso
                            WHERE id = $id");        
    }

    public function candel_permisoausencia($id){
      $query = $this->db->query("SELECT count(*) as cant FROM empleado WHERE id_permisoausencia = $id");
      $result = $query->result();
      if ($result[0]->cant == 0)
        { return 1; }
      else
        { return 0; }
    }

    public function del_permisoausencia($id) {
      /*if ($this->candel_permisoausencia($id_permisoausencia) == 1){
        $query = $this->db->query("DELETE FROM permisoausencia WHERE id = $id_permisoausencia");
        return 1;
      } else {
        return 0;
      }       */
        $this->db->query("DELETE FROM permisoausencia WHERE id = $id");
        return 1;
    }

    public function sel_permisoausencia_id($id){
      $query = $this->db->query("SELECT id, fecha_desde, hora_desde, fecha_hasta, hora_hasta,
                                        motivo, aprobado, id_empleado, id_tipopermiso
                                  FROM permisoausencia 
                                  Where id = $id");
      $result = $query->result();
      return $result[0];
    }

    /* lista de empleados */
    public function lst_empleado($desde, $hasta, $idempleado = 0) {
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
        $query = $this->db->query("SELECT e.id_empleado, e.nombres, e.apellidos, e.nro_ident
                                     FROM empleado e
                                     WHERE e.activo = 1 /*AND 
                                           e.id_empleado = $idempleado
                                           ( OR 
                                            NOT e.id_empleado IN (SELECT id_empleado FROM permisoausencia 
                                                                    WHERE (date(fecha_desde) between '$desde' and '$hasta') OR
                                                                          (date(fecha_hasta) between '$desde' and '$hasta')))*/
                                           $cond                                                              
                                     ORDER BY e.apellidos, e.nombres;");
        $result = $query->result();
        return $result;
    }

}
