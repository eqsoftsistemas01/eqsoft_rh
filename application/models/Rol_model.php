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
        $query = $this->db->query("DELETE FROM roldepagos_tmpdet WHERE id_usuario = $idusuario;");
        if ($idrol != 0){
          $this->db->query("INSERT INTO roldepagos_tmp (id_usuario, descripcion_rol, fechaini_rol, fechafin_rol, 
                                                        estado_rol, asistencia_ini, asistencia_fin)
                              SELECT $idusuario, descripcion_rol, fechaini_rol, fechafin_rol, 
                                    estado_rol, asistencia_ini, asistencia_fin 
                                FROM roldepagos 
                                WHERE id = $idrol;");

          $this->db->query("INSERT INTO roldepagos_tmpdet (id_usuario, id_empleado, id_rubro, valor_neto, valor_ingreso)
                              SELECT $idusuario, id_empleado, id_rubro, valor_neto, valor_ingreso 
                                FROM roldepagos_det 
                                WHERE id_rol = $idrol;");
        }
        else {
          $query = $this->db->query("SELECT count(*) as cant FROM roldepagos");
          $result = $query->result();
          if ($result[0]->cant > 0){
            $query = $this->db->query("SELECT date(max(fechafin_rol) + interval '1 day') as ini,
                                                date(date_trunc('month', max(fechafin_rol) + interval '1 day') + interval '1 month' - interval '1 day') as fin
                                          FROM roldepagos");
            $result = $query->result();

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
          $this->db->query("INSERT INTO roldepagos_tmp (id_usuario, descripcion_rol, estado_rol, fechaini_rol, fechafin_rol,
                                                        asistencia_ini, asistencia_fin) 
                              VALUES ($idusuario, '', 1, to_date('$inirol', 'YYYY-MM-DD'), to_date('$finrol', 'YYYY-MM-DD'),
                                                         to_date('$inirol', 'YYYY-MM-DD'), to_date('$finrol', 'YYYY-MM-DD'))");
        } 
        $this->db->query("INSERT INTO roldepagos_tmpdet (id_usuario, id_empleado, id_rubro, valor_neto, valor_ingreso)
                            SELECT $idusuario, r.id_empleado, r.id_rubro, 
                                   case u.editable WHEN 1 then 0 else r.valor_neto end as valor_neto,
                                   case u.editable WHEN 1 then r.valor_neto else 0 end as valor_ingreso
                              FROM empleado e 
                              INNER JOIN rubro_empleado r on r.id_empleado = e.id_empleado
                              INNER JOIN rubro u on u.id = r.id_rubro
                              WHERE NOT EXISTS (SELECT * FROM roldepagos_tmpdet t
                                                  WHERE t.id_usuario = $idusuario and 
                                                        t.id_empleado = r.id_empleado and
                                                        t.id_rubro = r.id_rubro);");

        /* actualizando sueldo */
        $this->db->query("UPDATE roldepagos_tmpdet 
                            SET valor_neto = empleado.sueldo,
                                valor_ingreso = 0
                            FROM empleado 
                            WHERE roldepagos_tmpdet.id_empleado = empleado.id_empleado AND
                                  roldepagos_tmpdet.id_usuario = $idusuario AND
                                  roldepagos_tmpdet.id_rubro = (SELECT valor FROM parametros WHERE id = 2)::integer;");

        $query = $this->db->query("SELECT id_usuario, descripcion_rol, fechaini_rol, fechafin_rol, 
                                          estado_rol, asistencia_ini, asistencia_fin 
                                    FROM roldepagos_tmp 
                                    WHERE id_usuario = $idusuario;");
        $result = $query->result();
        $ini_asis = $result[0]->asistencia_ini;
        $fin_asis = $result[0]->asistencia_fin;

        /* actualizando dias trabajados */
        $this->db->query("UPDATE roldepagos_tmpdet 
                            SET valor_ingreso = 0,
                                valor_neto = (SELECT count(*) FROM asistencia a
                                                LEFT JOIN empleado e on e.id_empleado = a.id_empleado
                                                LEFT JOIN jornada j on j.id = e.id_jornada
                                                WHERE a.id_empleado = roldepagos_tmpdet.id_empleado AND 
                                                      a.fecha BETWEEN '$ini_asis' AND '$fin_asis' AND
                                                      ((j.id IS NULL) OR 
                                                       (a.entrada_trabajo <= j.entrada_trabajo AND
                                                        a.salida_trabajo >= j.salida_trabajo AND
                                                        a.salida_almuerzo >= j.salida_almuerzo AND
                                                        a.entrada_almuerzo <= j.entrada_almuerzo))
                                              )
                            WHERE roldepagos_tmpdet.id_usuario = $idusuario AND
                                  roldepagos_tmpdet.id_empleado in (SELECT id_empleado FROM empleado WHERE editdiastrab = 0) AND 
                                  roldepagos_tmpdet.id_rubro = (SELECT valor FROM parametros WHERE id = 3)::integer;");

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
        $query = $this->db->query("SELECT t.id_rubro, r.codigo_rubro, r.nombre_rubro, r.expresioncalculo, t.valor_neto, 
                                          t.valor_ingreso, r.editable,
                                          CASE WHEN p.id IS NOT NULL then 0 else r.editable END as modificable,
                                          COALESCE(p.id,0) as idparametro                                                                                 
                                     FROM roldepagos_tmpdet t 
                                     INNER JOIN rubro r on r.id = t.id_rubro
                                     LEFT JOIN parametros p on p.valor = t.id_rubro::char
                                     WHERE t.id_usuario = $idusuario AND t.id_empleado = $idempleado
                                     ORDER BY r.codigo_rubro;");
        $result = $query->result();
        return $result;
    }

    public function lst_rubros_calculo($idusuario, $idempleado) {
        $query = $this->db->query("SELECT r.id as id_rubro, r.codigo_rubro, r.nombre_rubro, r.expresioncalculo, 
                                          COALESCE(t.valor_ingreso,0) as valor_ingreso, 
                                          COALESCE(t.valor_neto,0) as valor_neto, 
                                          r.editable, r.calculado,
                                          CASE WHEN p.id IS NOT NULL then 0 else r.editable END as modificable,
                                          COALESCE(p.id,0) as idparametro                                                                                  
                                     FROM rubro r 
                                     LEFT JOIN roldepagos_tmpdet t on t.id_rubro = r.id AND t.id_usuario = $idusuario AND t.id_empleado = $idempleado
                                     LEFT JOIN parametros p on p.valor = t.id_rubro::char
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

    public function actualiza_ingresorubro($idusuario, $idempleado, $idrubro, $valor) {
        if ($valor == '') { $valor = 0; }
        $query = $this->db->query("SELECT valor FROM parametros WHERE id = 3");
        $idrubrodias = 0;
        $result = $query->result();
        if ($result) { $idrubrodias = $result[0]->valor; }
        if ($idrubro != $idrubrodias){
          $this->db->query("UPDATE roldepagos_tmpdet SET valor_ingreso = $valor
                              WHERE id_usuario = $idusuario AND 
                                    id_empleado = $idempleado AND
                                    id_rubro = $idrubro;");
        }
        else {
          $this->db->query("UPDATE roldepagos_tmpdet SET valor_neto = $valor
                              WHERE id_usuario = $idusuario AND 
                                    id_empleado = $idempleado AND
                                    id_rubro = $idrubro;");
        }
    }

    public function sel_rubroneto_tmp($idusuario, $idempleado) {
        $query = $this->db->query("SELECT valor_neto
                                     FROM roldepagos_tmpdet t 
                                     WHERE id_rubro = (SELECT valor FROM parametros WHERE id = 4)::integer AND 
                                           t.id_usuario = $idusuario AND t.id_empleado = $idempleado;");
        $result = $query->result();
        if ($result) 
          return $result[0]->valor_neto;
        else
          return 0;
    }

    public function upd_tmprol($idusuario, $fechainirol, $fechafinrol, $feciniasist, $fecfinasist, $descripcion){

        if ((!$fechainirol) || (trim($fechainirol) == '')) 
          { $fechainirol = 'NULL'; }
        else 
          { $fechainirol = "to_date('" . $fechainirol . "', 'YYYY-MM-DD')"; }

        if ((!$fechafinrol) || (trim($fechafinrol) == '')) 
          { $fechafinrol = 'NULL'; }
        else 
          { $fechafinrol = "to_date('" . $fechafinrol . "', 'YYYY-MM-DD')"; }

        if ((!$feciniasist) || (trim($feciniasist) == '')) 
          { $feciniasist = 'NULL'; }
        else 
          { $feciniasist = "to_date('" . $feciniasist . "', 'YYYY-MM-DD')"; }

        if ((!$fecfinasist) || (trim($fecfinasist) == '')) 
          { $fecfinasist = 'NULL'; }
        else 
          { $fecfinasist = "to_date('" . $fecfinasist . "', 'YYYY-MM-DD')"; }

        $this->db->query("UPDATE roldepagos_tmp SET 
                              descripcion_rol = '$descripcion', 
                              fechaini_rol = $fechainirol, 
                              fechafin_rol = $fechafinrol, 
                              asistencia_ini = $feciniasist, 
                              asistencia_fin = $fecfinasist, 
                              estado_rol = 1
                            WHERE id_usuario = $idusuario;");

    }

    public function add_rol($idusu){
        $this->db->query("INSERT INTO roldepagos (descripcion_rol, fechaini_rol, fechafin_rol, 
                                                  asistencia_ini, asistencia_fin, estado_rol)
                            SELECT descripcion_rol, fechaini_rol, fechafin_rol, 
                                   asistencia_ini, asistencia_fin, estado_rol
                              FROM roldepagos_tmp     
                              WHERE id_usuario = $idusu");
        $query = $this->db->query("SELECT max(id) as maxid FROM roldepagos");
        $resultado = $query->result();
        $newid = $resultado[0]->maxid;

        $this->db->query("INSERT INTO roldepagos_det (id_rol, id_empleado, id_rubro, valor_neto, valor_ingreso)
                            SELECT $newid, id_empleado, id_rubro, valor_neto, valor_ingreso 
                              FROM roldepagos_tmpdet 
                              WHERE id_usuario = $idusu");
    }

    public function upd_rol($idusu, $id){
        $this->db->query("UPDATE roldepagos SET
                              descripcion_rol = t.descripcion_rol, 
                              fechaini_rol = t.fechaini_rol, 
                              fechafin_rol = t.fechafin_rol, 
                              asistencia_ini = t.asistencia_ini, 
                              asistencia_fin = t.asistencia_fin, 
                              estado_rol = t.estado_rol
                            FROM (SELECT * FROM roldepagos_tmp WHERE id_usuario = $idusu) t    
                            WHERE roldepagos.id = $id");
        $this->db->query("DELETE FROM roldepagos_det WHERE id_rol = $id");

        $this->db->query("INSERT INTO roldepagos_det (id_rol, id_empleado, id_rubro, valor_neto, valor_ingreso)
                            SELECT $id, id_empleado, id_rubro, valor_neto, valor_ingreso 
                              FROM roldepagos_tmpdet 
                              WHERE id_usuario = $idusu");
    }

    public function del_rol($id){
        $this->db->query("DELETE FROM roldepagos_det WHERE id_rol = $id");
        $this->db->query("DELETE FROM roldepagos WHERE id = $id");
    }

    public function lst_tmprolemp_encab($idusuario, $idempleado) {
        $query = $this->db->query("SELECT e.id_empleado, e.nombres, e.apellidos, c.nombre_cargo,
                                          l. fechafin_rol,
                                          COALESCE(t.valor_neto,0) as diastrab                                          
                                     FROM rubro r 
                                     INNER JOIN roldepagos_tmpdet t on t.id_rubro = r.id AND t.id_usuario = $idusuario AND 
                                                                       ($idempleado=0 OR t.id_empleado = $idempleado)
                                     INNER JOIN roldepagos_tmp l on l.id_usuario = t.id_usuario 
                                     INNER JOIN parametros p on p.valor = t.id_rubro::char 
                                     INNER JOIN empleado e on e.id_empleado = t.id_empleado
                                     LEFT JOIN cargo c on c.id = e.id_cargo
                                     WHERE p.id = 3"); /*dias trabajados*/
        $result = $query->result();
        return $result;
    }

    public function lst_tmprolemp_rubros($idusuario, $idempleado) {
        $query = $this->db->query("SELECT r.id as id_rubro, r.codigo_rubro, r.nombre_rubro, 
                                          COALESCE(t.valor_neto,0) as valor_neto, 
                                          COALESCE(t.valor_ingreso,0) as valor_ingreso, 
                                          r.tipo_rubro, r.editable
                                     FROM rubro r 
                                     LEFT JOIN roldepagos_tmpdet t on t.id_rubro = r.id AND t.id_usuario = $idusuario AND t.id_empleado = $idempleado
                                     WHERE not r.id::char in (SELECT valor FROM parametros WHERE id in (3,4)) /*excepto dias trab y neto a cobrar*/
                                     ORDER BY r.codigo_rubro;");
        $result = $query->result();
        return $result;
    }

}
