<?php

/* ------------------------------------------------
  ARCHIVO: utilidad_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la utilidad.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */

class Utilidad_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* lista de empleados */
    public function lst_utilidad($anio, $utilidad) {
        $this->db->query("INSERT INTO utilidad (anio, id_empleado)
                            SELECT $anio, e.id_empleado                                    
                              FROM empleado e
                              WHERE NOT EXISTS (SELECT * FROM utilidad WHERE anio = $anio AND id_empleado = e.id_empleado);");
        $this->db->query("DELETE FROM utilidad
                            WHERE anio = $anio AND 
                                  NOT id_empleado IN (SELECT id_empleado  FROM empleado 
                                                       WHERE EXTRACT(YEAR FROM fecha_ingreso) <= $anio AND 
                                                             (fecha_salida IS NULL OR EXTRACT(YEAR FROM fecha_salida) >= $anio));");
        $this->db->query("UPDATE utilidad SET
                              dias = (SELECT sum(d.valor_neto) FROM roldepagos_det d 
                                        INNER JOIN roldepagos r on r.id = d.id_rol
                                        WHERE d.id_empleado = utilidad.id_empleado AND 
                                              EXTRACT(YEAR FROM fechaini_rol) = $anio AND
                                              d.id_rubro = (SELECT valor FROM parametros WHERE id = 3)::integer),
                              cargas = (SELECT count(*) FROM cargafamiliar c WHERE c.id_empleado = utilidad.id_empleado)                
                            WHERE anio = $anio");
        $this->db->query("UPDATE utilidad SET
                              monto_empleado = round($utilidad * 0.1 * dias / diastotal.diastotal,2),
                              monto_cargas = round($utilidad * 0.05 * dias * cargas / basetotal.basetotal,2)
                            FROM (SELECT sum(dias) as diastotal FROM dialaborable WHERE anio = $anio) as diastotal,  
                                 (SELECT SUM(dias * cargas) as basetotal FROM utilidad WHERE anio = $anio) as basetotal  
                            WHERE anio = $anio AND diastotal.diastotal > 0");
        $query = $this->db->query("SELECT d.anio, e.apellidos, e.nombres, e.nro_ident, d.dias,
                                          CASE WHEN EXTRACT(YEAR FROM e.fecha_ingreso) < $anio THEN 
                                            to_date('$anio' || '-01-01', 'YYYY-MM-DD') ELSE e.fecha_ingreso
                                          END as inicio,
                                          CASE WHEN e.fecha_salida IS NULL OR EXTRACT(YEAR FROM e.fecha_salida) > $anio THEN 
                                            to_date('$anio' || '-12-31', 'YYYY-MM-DD') ELSE e.fecha_salida
                                          END as fin,
                                          d.monto_empleado, d.cargas, d.monto_cargas
                                     FROM utilidad d
                                     INNER JOIN empleado e on e.id_empleado = d.id_empleado
                                     Where d.anio = $anio ORDER BY e.apellidos, e.nombres;");
        $result = $query->result();
        return $result;
    }
    public function add_utilidad($anio, $mes, $dias) {
        $this->db->query("INSERT INTO utilidad (anio, mes, dias) VALUES ($anio, $mes, $dias)");        
    }

    public function upd_utilidad($anio, $mes, $dias) {
        $this->db->query("UPDATE utilidad SET dias =$dias
                            WHERE anio = $anio and  mes = $mes");        
    }

    public function candel_utilidad($anio){
      $query = $this->db->query("SELECT count(*) as cant FROM asistencia WHERE EXTRACT(YEAR FROM fecha) = $anio");
      $result = $query->result();
      if ($result[0]->cant == 0)
        { return 1; }
      else
        { return 0; }
    }

    public function del_utilidad($anio) {
      if ($this->candel_utilidad($anio) == 1){
        $query = $this->db->query("DELETE FROM utilidad WHERE anio = $anio");
        return 1;
      } else {
        return 0;
      }       
    }

    public function sel_utilidad_aniomes($anio, $mes){
      $query = $this->db->query("SELECT anio, mes, dias FROM utilidad WHERE anio = $anio AND mes = $mes");
      $result = $query->result();
      return $result[0];
    }

    public function lst_meses() {
        $query = $this->db->query("SELECT id, nombremes FROM vista_meses ORDER BY id");
        $result = $query->result();
        return $result;
    }

    public function lst_anios() {
        $query = $this->db->query("SELECT count(*) as cant FROM utilidad");
        $result = $query->result();
        if ($result[0]->cant > 0){
          $query = $this->db->query("SELECT distinct anio from utilidad union
                                     select max(anio) + 1 as anio from utilidad union
                                     select max(anio) - 1 as anio from utilidad 
                                     order by anio");
        }
        else {
          $query = $this->db->query("SELECT extract(year from now()) as anio union
                                     select extract(year from now()) + 1 as anio union
                                     select extract(year from now()) - 1 as anio 
                                     order by anio");
        }  
        $result = $query->result();
        return $result;
    }

}
