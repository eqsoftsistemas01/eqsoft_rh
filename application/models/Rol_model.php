<?php

/* ------------------------------------------------
  ARCHIVO: Rol_model.php
  DESCRIPCION: Manejo de consultas y excepciones referentes a la Rol.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */

class Rol_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /* lista de roles */
    public function lst_roles() {
        $query = $this->db->query("SELECT id, descripcion_rol, fechaini_rol, fechafin_rol, 
                                          estado_rol, asistencia_ini, asistencia_fin 
                                     FROM roldepagos 
                                     ORDER BY fechaini_rol DESC;");
        $result = $query->result();
        return $result;
    }

    public function carga_rol($idrol, $idusuario) {
        $query = $this->db->query("DELETE FROM roldepagos_tmp WHERE id_usuario = $idusuario;");
        if ($idrol != 0){
          $this->db->query("INSERT INTO roldepagos_tmp (id_usuario, descripcion_rol, fechaini_rol, fechafin_rol, 
                                                        estado_rol, asistencia_ini, asistencia_fin)
                              SELECT $idusuario, descripcion_rol, fechaini_rol, fechafin_rol, 
                                    estado_rol, asistencia_ini, asistencia_fin 
                                FROM roldepagos 
                                WHERE id = $idrol;");

          $this->db->query("INSERT INTO roldepagos_tmpdet (id_usuario, id_empleado, id_rubro, valor_neto)
                              SELECT $idusuario, id_empleado, id_rubro, valor_neto 
                                FROM roldepagos_det 
                                WHERE id = $idrol;");
        }
        else {
          $query = $this->db->query("SELECT date(max(fechafin_rol) + interval '1 day') as ini,
                                              date(date_trunc('month', max(fechafin_rol) + interval '1 day') + interval '1 month' - interval '1 day') as fin
                                        FROM roldepagos");
          $result = $query->result();
          if ($result){
            $inirol = $result[0]->ini;
            $finrol = $result[0]->fin;
          }
          else {
            $query = $this->db->query("SELECT date(date_trunc('month', current_date)) as ini,
                                              date(date_trunc('month', current_date) + interval '1 month' - interval '1 day') as fin");
            $result = $query->result();
            $inirol = $result[0]->ini;
            $finrol = $result[0]->fin;
          }
          $result = $query->result();
          $this->db->query("INSERT INTO roldepagos_tmp (id_usuario, descripcion_rol, estado_rol, fechaini_rol, fechafin_rol,
                                                        asistencia_ini, asistencia_fin) 
                              VALUES ($idusuario, '', 1, to_date('$inirol', 'YYYY-MM-DD'), to_date('$finrol', 'YYYY-MM-DD'),
                                                         to_date('$inirol', 'YYYY-MM-DD'), to_date('$finrol', 'YYYY-MM-DD'))");
        } 
        $this->db->query("INSERT INTO roldepagos_tmpdet (id_usuario, id_empleado, id_rubro, valor_neto)
                            SELECT $idusuario, r.id_empleado, r.id_rubro, r.valor_neto 
                              FROM empleado e 
                              INNER JOIN rubro_empleado r on r.id_empleado = e.id_empleado
                              WHERE NOT EXISTS (SELECT * FROM roldepagos_tmpdet t
                                                  WHERE t.id_usuario = $idusuario and 
                                                        t.id_empleado = r.id_empleado and
                                                        t.id_rubro = r.id_rubro);");

        $query = $this->db->query("SELECT id_usuario, descripcion_rol, fechaini_rol, fechafin_rol, 
                                          estado_rol, asistencia_ini, asistencia_fin 
                                    FROM roldepagos_tmp 
                                    WHERE id_usuario = $idusuario;");
        $result = $query->result();
        return $result[0];
    }


    /* lista de empleados */
    public function lst_empleados($idusuario) {
        $query = $this->db->query("SELECT e.id_empleado, e.nombres, e.apellidos, e.nro_ident, t.valor_neto                                                                                  
                                     FROM roldepagos_tmpdet t 
                                     INNER JOIN empleado e on e.id_empleado = t.id_empleado
                                     WHERE t.id_usuario = $idusuario AND 
                                           t.id_rubro = (SELECT valor FROM parametros WHERE id = 4)::integer /*neto a cobrar*/
                                     ORDER BY e.apellidos, e.nombres;");
        $result = $query->result();
        return $result;
    }

    /* lista de empleados */
    public function lst_rubros($idusuario, $idempleado) {
        $query = $this->db->query("SELECT t.id_rubro, r.codigo_rubro, r.nombre_rubro, r.expresioncalculo, t.valor_neto, r.editable,
                                          CASE WHEN p.id IS NOT NULL then 0 else r.editable END as modificable                                                                                  
                                     FROM roldepagos_tmpdet t 
                                     INNER JOIN rubro r on r.id = t.id_rubro
                                     LEFT JOIN parametros p on p.valor = t.id_rubro::char
                                     WHERE t.id_usuario = $idusuario AND t.id_empleado = $idempleado
                                     ORDER BY r.codigo_rubro;");
        $result = $query->result();
        return $result;
    }

    public function actualiza_valorrubro($idusuario, $idempleado, $idrubro, $valor) {
        if ($valor == '') { $valor = 0; }
        $this->db->query("UPDATE roldepagos_tmpdet SET valor_neto = $valor
                            WHERE id_usuario = $idusuario AND 
                                  id_empleado = $idempleado AND
                                  id_rubro = $idrubro;");
    }

}
