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
                                   UNION SELECT 12 as id, 'Diciembre' as mes
                                   ORDER BY id;");
        $result = $query->result();
        return $result;
    }

    /* lista de empleados */
    public function lst_rubro() {
        $query = $this->db->query("SELECT r.id, r.codigo_rubro, r.nombre_rubro, r.tipo_rubro, r.afectadopordias, r.periodicidadmensual, 
                                          r.mesactivo, r.diasgracia, r.editable, r.expresioncalculo, r.activo,
                                          r.calculado, t.tiporubro
                                     FROM rubro r
                                     INNER JOIN tiporubro t on t.id = r.tipo_rubro
                                     Where r.activo = 1
                                     ORDER BY r.codigo_rubro;");
        $result = $query->result();
        return $result;
    }
    public function add_rubro($codigo_rubro, $nombre_rubro, $rubro_activo, $tipo_rubro, $periodo, $mesactivo, $diastrabajados, $diasgracia, $calculado, $expresion, $editable) {
        $this->db->query("INSERT INTO rubro (codigo_rubro, nombre_rubro, tipo_rubro, activo, periodicidadmensual, mesactivo, afectadopordias, diasgracia, editable, expresioncalculo, calculado)
                            VALUES ('$codigo_rubro', '$nombre_rubro', $tipo_rubro, $rubro_activo, $periodo, $mesactivo, $diastrabajados, $diasgracia, $editable, '$expresion', $calculado)");
        
    }
    public function upd_rubro($id, $codigo_rubro, $nombre_rubro, $rubro_activo,$tipo_rubro, $periodo, $mesactivo, $diastrabajados, $diasgracia, $calculado, $expresion, $editable) {
        $this->db->query("UPDATE rubro SET 
                             codigo_rubro = '$codigo_rubro', 
                             nombre_rubro = '$nombre_rubro',
                             tipo_rubro = $tipo_rubro, 
                             activo = $rubro_activo,
                             afectadopordias = $diastrabajados, 
                             periodicidadmensual = $periodo, 
                             mesactivo = $mesactivo, 
                             diasgracia = $diasgracia, 
                             editable = $editable, 
                             expresioncalculo = '$expresion',
                             calculado = $calculado
                            WHERE id = $id");        
    }

    public function candel_rubro($id){
      $query = $this->db->query("SELECT count(*) as cant FROM rubro_empleado WHERE id_rubro = $id");
      $result = $query->result();
/*      if ($result[0]->cant == 0){
        $query = $this->db->query("SELECT count(*) as cant FROM caja_efectivo WHERE id_puntoemision = $puntoemision");
        $result = $query->result();
      }*/
      if ($result[0]->cant == 0)
        { return 1; }
      else
        { return 0; }
    }

    public function del_rubro($id_rubro) {
      if ($this->candel_rubro($id_rubro) == 1){
        $query = $this->db->query("DELETE FROM rubro WHERE id = $id_rubro");
        return 1;
      } else {
        return 0;
      }       
    }

    public function sel_rubro_id($id){
      $query = $this->db->query("SELECT id, codigo_rubro, nombre_rubro, tipo_rubro, afectadopordias, calculado,
                                        periodicidadmensual, mesactivo, diasgracia, editable, expresioncalculo, activo
                                     FROM rubro 
                                     Where id = $id");
      $result = $query->result();
      return $result[0];
    }

    public function sel_rubro_codigo($codigo){
      $query = $this->db->query("SELECT id, codigo_rubro, nombre_rubro, tipo_rubro, afectadopordias, calculado,
                                        periodicidadmensual, mesactivo, diasgracia, editable, expresioncalculo, activo
                                     FROM rubro 
                                     Where codigo_rubro = '$codigo'");
      $result = $query->result();
      if ($result)
        return $result[0];
      else
        return NULL;
    }

}
