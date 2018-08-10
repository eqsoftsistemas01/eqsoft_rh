<?php

/* ------------------------------------------------
  ARCHIVO: Rubro_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la Rubro.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */

class Rubro_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function lst_tiporubro() {
        $query = $this->db->query("SELECT id, tiporubro FROM tiporubro;");
        $result = $query->result();
        return $result;
    }

    public function lst_periodo() {
        $query = $this->db->query("SELECT 1 as id, 'Mensual' as periodicidad
                                   UNION
                                   SELECT 2 as id, 'Anual' as periodicidad;");
        $result = $query->result();
        return $result;
    }

    public function lst_mesactivo() {
        $query = $this->db->query("SELECT 0 as id, 'Todos' as mes 
                                   UNION SELECT 1 as id, 'Enero' as mes
                                   UNION SELECT 2 as id, 'Febrero' as mes
                                   UNION SELECT 3 as id, 'Marzo' as mes
                                   UNION SELECT 4 as id, 'Abril' as mes
                                   UNION SELECT 5 as id, 'Mayo' as mes
                                   UNION SELECT 6 as id, 'Junio' as mes
                                   UNION SELECT 7 as id, 'Julio' as mes
                                   UNION SELECT 8 as id, 'Agosto' as mes
                                   UNION SELECT 9 as id, 'Septiembre' as mes
                                   UNION SELECT 10 as id, 'Octubre' as mes
                                   UNION SELECT 11 as id, 'Noviembre' as mes
                                   UNION SELECT 12 as id, 'Diciembre' as mes;");
        $result = $query->result();
        return $result;
    }

    /* lista de empleados */
    public function lst_rubro() {
        $query = $this->db->query("SELECT r.id, r.codigo_rubro, r.nombre_rubro, r.tipo_rubro, r.afectadopordias, r.periodicidadmensual, 
                                          r.mesactivo, r.diasgracia, r.editable, r.expresioncalculo, r.activo,
                                          t.tiporubro
                                     FROM rubro r
                                     INNER JOIN tiporubro t on t.id = r.tipo_rubro
                                     ORDER BY r.codigo_rubro;");
        $result = $query->result();
        return $result;
    }

}
