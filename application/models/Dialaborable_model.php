<?php

/* ------------------------------------------------
  ARCHIVO: dialaborable_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la dialaborable.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */

class Dialaborable_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* lista de empleados */
    public function lst_dialaborable($anio) {
        $this->db->query("INSERT INTO dialaborable (anio, mes, dias)
                            SELECT $anio, id, 24
                              FROM vista_meses
                              WHERE NOT EXISTS (SELECT anio FROM dialaborable WHERE anio = $anio);");
        $query = $this->db->query("SELECT d.anio, d.mes, d.dias, m.nombremes 
                                     FROM dialaborable d
                                     INNER JOIN vista_meses m on m.id = d.mes
                                     Where d.anio = $anio ORDER BY d.mes;");
        $result = $query->result();
        return $result;
    }
    public function add_dialaborable($anio, $mes, $dias) {
        $this->db->query("INSERT INTO dialaborable (anio, mes, dias) VALUES ($anio, $mes, $dias)");        
    }

    public function upd_dialaborable($anio, $mes, $dias) {
        $this->db->query("UPDATE dialaborable SET dias =$dias
                            WHERE anio = $anio and  mes = $mes");        
    }

    public function candel_dialaborable($anio){
      $query = $this->db->query("SELECT count(*) as cant FROM asistencia WHERE EXTRACT(YEAR FROM fecha) = $anio");
      $result = $query->result();
      if ($result[0]->cant == 0)
        { return 1; }
      else
        { return 0; }
    }

    public function del_dialaborable($anio) {
      if ($this->candel_dialaborable($anio) == 1){
        $query = $this->db->query("DELETE FROM dialaborable WHERE anio = $anio");
        return 1;
      } else {
        return 0;
      }       
    }

    public function sel_dialaborable_aniomes($anio, $mes){
      $query = $this->db->query("SELECT anio, mes, dias FROM dialaborable WHERE anio = $anio AND mes = $mes");
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
