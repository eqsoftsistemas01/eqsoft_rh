<?php

/*------------------------------------------------
  ARCHIVO: Empleado.php
  DESCRIPCION: Contiene los métodos relacionados Empleado.
  
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Empleado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Empleado_model");
        $this->load->Model("usuario_model");
        $this->load->Model("Departamento_model");
        $this->load->Model("Jornada_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $data["base_url"] = base_url();
        $data["content"] = "empleado";
        $this->load->view("layout", $data);
    }

    public function tmp_empleado() {
        $this->session->unset_userdata("tmp_empleado_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_empleado_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_empleado_id", $id);
        } else {
            $this->session->set_userdata("tmp_empleado_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    function carga_empleadotmp($idempleado) {
        $idusu = $this->session->userdata("sess_id");
        $id = $this->Empleado_model->get_empleadotmp($idusu, $idempleado);
        $this->session->unset_userdata("tmp_empleado_idtmp"); 
        $this->session->set_userdata("tmp_empleado_idtmp", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_empleado_idtmp", $id);
        } else {
            $this->session->set_userdata("tmp_empleado_idtmp", NULL);
        }
    }

    public function listadoEmpleados() {
        $registro = $this->Empleado_model->lst_empleado();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id_empleado.'\" class=\"btn btn-success btn-xs btn-grad ret_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Asistencia\" id=\"'.$row->id_empleado.'\" class=\"btn btn-primary btn-xs btn-grad reta_ver\"><i class=\"fa fa-calendar-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id_empleado.'\" class=\"btn btn-danger btn-xs btn-grad ret_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id_empleado. '",
                        "apellido":"' .$row->apellidos. '",
                        "nombre":"' .$row->nombres. '",
                        "identificacion":"' .$row->nro_ident. '",
                        "departamento":"' .$row->nombre_departamento. '",
                        "telefono":"' .$row->telf_empleado. '",
                        "correo":"' .$row->correo_empleado. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
    public function asiEmpleado() {
        $registro = $this->Empleado_model->asi_empleado();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id_empleado.'\" class=\"btn btn-success btn-xs btn-grad ret_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Asistencia\" id=\"'.$row->id_empleado.'\" class=\"btn btn-primary btn-xs btn-grad reta_ver\"><i class=\"fa fa-calendar-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id_empleado.'\" class=\"btn btn-danger btn-xs btn-grad ret_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "fecha":"' .$row->fecha. '",
                        "entrada":"' .$row->entrada_trabajo. '",
                        "salida":"' .$row->salida_trabajo. '",
                        "entrada almuerzo":"' .$row->entrada_almuerzo. '",
                        "salida almuerzo":"' .$row->entrada_almuerzo. '",
                        "apellidos":"' .$row->apellidos. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function upd_empleado(){
        $id = $this->session->userdata("tmp_empleado_id");
        $this->carga_empleadotmp($id);
        $tipoident = $this->Empleado_model->lst_tipoidentificacion();
        $perfil = $this->usuario_model->perfil_lst();
        $departamento = $this->Departamento_model->sel_departamento();
        $data["departamento"] = $departamento;
        $data["perfil"] = $perfil;
        $data["tipoident"] = $tipoident;
        $data["base_url"] = base_url();
        $obj = $this->Empleado_model->sel_empleado_id($id);
        $data["obj"] = $obj;
        $parentesco = $this->Empleado_model->lst_parentesco();
        $data["parentesco"] = $parentesco;
        $estadocivil = $this->Empleado_model->lst_estadocivil();
        $data["estadocivil"] = $estadocivil;
        $tipovivienda = $this->Empleado_model->lst_tipovivienda();
        $data["tipovivienda"] = $tipovivienda;
        $tipocuentabanco = $this->Empleado_model->lst_tipocuentabanco();
        $data["tipocuenta"] = $tipocuentabanco;
        $banco = $this->Empleado_model->lst_banco();
        $data["banco"] = $banco;
        $sexo = $this->Empleado_model->lst_sexo();
        $data["sexo"] = $sexo;
        $tiposangre = $this->Empleado_model->lst_tiposangre();
        $data["tiposangre"] = $tiposangre;
        $tipodiscapacidad = $this->Empleado_model->lst_tipodiscapacidad();
        $data["tipodiscapacidad"] = $tipodiscapacidad;
        $ciudad = $this->Empleado_model->lst_ciudad();
        $data["ciudad"] = $ciudad;
        $cargo = $this->Empleado_model->lst_cargo();
        $data["cargo"] = $cargo;
        $empresa = $this->Empleado_model->lst_empresa();
        $data["empresa"] = $empresa;
        $tipocontrato = $this->Empleado_model->lst_tipocontrato();
        $data["tipocontrato"] = $tipocontrato;
        $jornadas = $this->Jornada_model->lst_jornada();
        $data["jornadas"] = $jornadas;
        $tipotrabajador = $this->Empleado_model->lst_tipotrabajador();
        $data["tipotrabajador"] = $tipotrabajador;

        $data["content"] = "empleado_edit";
        $this->load->view("layout", $data);
//        $this->load->view("empleado_add", $data);
    }

    public function guardar(){
        $id = $this->input->post('txt_id'); 
        $apellido = $this->input->post('txt_apellido');
        $nombre = $this->input->post('txt_nombre');
        $tipoident = $this->input->post('cmb_tipoident');
        $identificacion = $this->input->post('txt_ident');
        $perfil = $this->input->post('cmb_perfil');
        $departamento = $this->input->post('cmb_departamento');
        $calleprincipal = $this->input->post('txt_calleprincipal');
        $numerovivienda = $this->input->post('txt_numerovivienda');
        $calletransversal = $this->input->post('txt_calletransversal');
        $sector = $this->input->post('txt_sector');
        $referenciavivienda = $this->input->post('txt_referenciavivienda');
        $telefono = $this->input->post('txt_telefono');
        $celular = $this->input->post('txt_celular');
        $correo = $this->input->post('txt_correo');
        $activo = $this->input->post('chkactivo');

        $banco = $this->input->post('cmb_banco');
        $tipocuenta = $this->input->post('cmb_tipocuenta');
        $numerocuenta = $this->input->post('txt_numerocuenta');
        $nombrecontacto = $this->input->post('txt_nombrecontacto');
        $direccioncontacto = $this->input->post('txt_direccioncontacto');
        $parentescocontacto = $this->input->post('cmb_parentesco');
        $telefonocontacto = $this->input->post('txt_telefonocontacto');

        $lugarexpedicion = $this->input->post('txt_lugarexpedicion');
        $cedulamilitar = $this->input->post('txt_cedulamilitar');
        $profesion = $this->input->post('txt_profesion');
        $pasaporte = $this->input->post('txt_pasaporte');
        $sexo = $this->input->post('cmb_sexo');

        $tipovivienda = $this->input->post('cmb_tipovivienda');
        $tiposangre = $this->input->post('cmb_tiposangre');
        $tipodiscapacidad = $this->input->post('cmb_tipodiscapacidad'); 
        $p100discapacidad = $this->input->post('txt_p100discapacidad');
        $estadocivil = $this->input->post('cmb_estadocivil'); 
        $fec = $this->input->post('fechanac');
        if ((!$fec) || (trim($fec) == '')) 
            { $fecha_nacimiento = ''; }
        else {
            $fecha_nacimiento = str_replace('/', '-', $fec); 
            $fecha_nacimiento = date("Y-m-d", strtotime($fecha_nacimiento));
        }
        $peso = $this->input->post('txt_peso');
        $talla = $this->input->post('txt_talla');
        $vivefamiliares = $this->input->post('chkvivefamiliar');
        $codigoreloj = $this->input->post('txt_codigoreloj');
        $ciudad = $this->input->post('cmb_ciudad'); 
        $cargo = $this->input->post('cmb_cargo'); 
        $empresa = $this->input->post('cmb_empresa'); 

        $contrato = $this->input->post('txt_idcontrato');
        $tipocontrato = $this->input->post('cmb_tipocontrato'); 
        $sueldo = $this->input->post('txt_sueldo');
        $fec = $this->input->post('fechaingreso');
        if ((!$fec) || (trim($fec) == '')) 
            { $fechaingreso = ''; }
        else {
            $fechaingreso = str_replace('/', '-', $fec); 
            $fechaingreso = date("Y-m-d", strtotime($fechaingreso));
        }
        $fec = $this->input->post('fechasalida');
        if ((!$fec) || (trim($fec) == '')) 
            { $fechasalida = ''; }
        else {
            $fechasalida = str_replace('/', '-', $fec); 
            $fechasalida = date("Y-m-d", strtotime($fechasalida));
        }

        if($activo == 'on'){ $activo = 1; } else { $activo = 0; }
        if($vivefamiliares == 'on'){ $vivefamiliares = 1; } else { $vivefamiliares = 0; }

        $causasalida = $this->input->post('txt_causasalida');
        $idjornada = $this->input->post('cmb_jornada'); 
        $tipotrabajador = $this->input->post('cmb_tipotrabajador'); 


        if($id != 0){
            $resu = $this->Empleado_model->upd_empleado($id, $nombre, $apellido, $tipoident, $identificacion, $perfil, $telefono, 
                                 $celular, $correo, $activo, $departamento, $lugarexpedicion, $cedulamilitar,$profesion, $pasaporte, 
                                 $fecha_nacimiento, $sexo, $estadocivil, $peso, $talla, $codigoreloj, $calleprincipal, 
                                 $numerovivienda, $calletransversal, $sector, $referenciavivienda, $ciudad, $tipovivienda, 
                                 $vivefamiliares, $banco, $tipocuenta, $numerocuenta, $nombrecontacto, $direccioncontacto, 
                                 $parentescocontacto, $telefonocontacto, $empresa, $tiposangre, $tipodiscapacidad, 
                                 $p100discapacidad, $contrato, $cargo, $tipocontrato, $fechaingreso, $fechasalida, $sueldo,
                                 $idjornada, $causasalida, $tipotrabajador);
        } else {
            $resu = $this->Empleado_model->add_empleado($nombre, $apellido, $tipoident, $identificacion, $perfil, $telefono, 
                                 $celular, $correo, $activo, $departamento, $lugarexpedicion, $cedulamilitar,$profesion, $pasaporte, 
                                 $fecha_nacimiento, $sexo, $estadocivil, $peso, $talla, $codigoreloj, $calleprincipal, 
                                 $numerovivienda, $calletransversal, $sector, $referenciavivienda, $ciudad, $tipovivienda, 
                                 $vivefamiliares, $banco, $tipocuenta, $numerocuenta, $nombrecontacto, $direccioncontacto, 
                                 $parentescocontacto, $telefonocontacto, $empresa, $tiposangre, $tipodiscapacidad, 
                                 $p100discapacidad, $contrato, $cargo, $tipocontrato, $fechaingreso, $fechasalida, $sueldo,
                                 $idjornada, $causasalida, $tipotrabajador);
        }
        print "<script> window.location.href = '" . base_url() . "empleado'; </script>";
    }

    public function add_empleado(){
        $this->carga_empleadotmp(0);
        $tipoident = $this->Empleado_model->lst_tipoidentificacion();
        $perfil = $this->usuario_model->perfil_lst();
        $departamento = $this->Departamento_model->sel_departamento();
        $data["departamento"] = $departamento;
        $data["perfil"] = $perfil;
        $data["tipoident"] = $tipoident;
        $parentesco = $this->Empleado_model->lst_parentesco();
        $data["parentesco"] = $parentesco;
        $estadocivil = $this->Empleado_model->lst_estadocivil();
        $data["estadocivil"] = $estadocivil;
        $tipovivienda = $this->Empleado_model->lst_tipovivienda();
        $data["tipovivienda"] = $tipovivienda;
        $tipocuentabanco = $this->Empleado_model->lst_tipocuentabanco();
        $data["tipocuentabanco"] = $tipocuentabanco;
        $banco = $this->Empleado_model->lst_banco();
        $data["banco"] = $banco;
        $sexo = $this->Empleado_model->lst_sexo();
        $data["sexo"] = $sexo;
        $tiposangre = $this->Empleado_model->lst_tiposangre();
        $data["tiposangre"] = $tiposangre;
        $tipodiscapacidad = $this->Empleado_model->lst_tipodiscapacidad();
        $data["tipodiscapacidad"] = $tipodiscapacidad;
        $ciudad = $this->Empleado_model->lst_ciudad();
        $data["ciudad"] = $ciudad;
        $cargo = $this->Empleado_model->lst_cargo();
        $data["cargo"] = $cargo;
        $empresa = $this->Empleado_model->lst_empresa();
        $data["empresa"] = $empresa;
        $tipocontrato = $this->Empleado_model->lst_tipocontrato();
        $data["tipocontrato"] = $tipocontrato;
        $jornadas = $this->Jornada_model->lst_jornada();
        $data["jornadas"] = $jornadas;
        $tipotrabajador = $this->Empleado_model->lst_tipotrabajador();
        $data["tipotrabajador"] = $tipotrabajador;

        $data["base_url"] = base_url();
        $data["content"] = "empleado_edit";
        $this->load->view("layout", $data);
//        $this->load->view("empleado_add", $data);
    } 

    public function del_empleado(){
        $id = $this->input->post('id'); 
        $resu = $this->Empleado_model->del_empleado($id);
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

     /* Verificar Identificador  */
    public function existeIdentificacion(){
        $id = $this->input->post('id');
        $identificacion = $this->input->post('identificacion');
        $resu = $this->Empleado_model->existeIdentificacion($id, $identificacion);
        $arr['resu'] = $resu;
        print json_encode($arr);

    }

     /* Verificar Identificador  */
    public function existeIdentificacionCarga(){
        $id = $this->input->post('id');
        $identificacion = $this->input->post('identificacion');
        $resu = $this->Empleado_model->existeIdentificacionCarga($id, $identificacion);
        $arr['resu'] = $resu;
        print json_encode($arr);

    }

    public function listadoCargaFamiliar() {
        $id = $this->session->userdata("tmp_empleado_idtmp");
        $registro = $this->Empleado_model->sel_cargafamiliar_tmpid($id);
        $tabla = "";
        foreach ($registro as $row) {
            $fec = "";
            if ($row->fecha_nacimiento){
                $fec = str_replace('-', '/', $row->fecha_nacimiento); $fec = date("d/m/Y", strtotime($fec));
            } 
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad carga_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad carga_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "apellido":"' .$row->apellidos_familiar. '",
                        "nombre":"' .$row->nombres_familiar. '",
                        "identificacion":"' .$row->nro_ident. '",
                        "parentesco":"' .$row->parentesco. '",
                        "telefono":"' .$row->telf_familiar. '",
                        "fechanac":"' .$fec. '",
                        "sexo":"' .$row->sexonombre. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
    public function listadoRubroEmpleado() {
        $id = $this->session->userdata("tmp_empleado_idtmp");
        $registro = $this->Empleado_model->sel_rubrosempleado_tmpid($id);
        $tabla = "";
        foreach ($registro as $row) {
           
           if ($row->existe == 0) { $marcado = ''; } else { $marcado = 'checked'; }
           $ver = '<div ><input type=\"checkbox\" class=\"chk_rubro\" name=\"'.$row->editable.'\" id=\"'.$row->id.'\" value=\"'.$row->existe.'\" '. $marcado .'></div>';

           if (($row->existe == 0) || ($row->editable == 0)) { $deshabilitado = 'disabled'; } else { $deshabilitado = ''; }
           $valor = '<div ><input type=\"text\" class=\"valor_rubro\" name=\"'.$row->id.'\" id=\"'.$row->id.'\" value=\"'.$row->valor_neto.'\" '. $deshabilitado .'></div>';

            $tabla.='{  "id":"' .$row->id. '",
                        "codigo":"' .$row->codigo_rubro. '",
                        "descripcion":"' .$row->nombre_rubro. '",
                        "valor":"' .$valor. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function add_cargafamiliar(){
        $parentesco = $this->Empleado_model->lst_parentesco();
        $data["parentesco"] = $parentesco;
        $sexo = $this->Empleado_model->lst_sexo();
        $data["sexo"] = $sexo;

        $data["base_url"] = base_url();
        $this->load->view("empleadocarga_add", $data);
    } 

    public function tmp_carga() {
        $this->session->unset_userdata("tmp_carga_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_carga_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_carga_id", $id);
        } else {
            $this->session->set_userdata("tmp_carga_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function edit_cargafamiliar(){
        $id = $this->session->userdata("tmp_carga_id");
        $parentesco = $this->Empleado_model->lst_parentesco();
        $data["parentesco"] = $parentesco;
        $sexo = $this->Empleado_model->lst_sexo();
        $data["sexo"] = $sexo;
        $obj = $this->Empleado_model->sel_cargafamiliar_id($id);
        $data["obj"] = $obj;

        $data["base_url"] = base_url();
        $this->load->view("empleadocarga_add", $data);
    } 

    public function guardar_carga(){
        $empleadotmp = $this->session->userdata("tmp_empleado_idtmp");
        $id = $this->input->post('id'); 
        $apellidos = $this->input->post('apellidos'); 
        $nombres = $this->input->post('nombres'); 
        $activo = $this->input->post('activo'); 
        $ident = $this->input->post('ident'); 
        $parentesco = $this->input->post('parentesco'); 
        $telf = $this->input->post('telefono'); 
        $sexo = $this->input->post('sexo'); 
        $fec = $this->input->post('fechanac'); 
        if ((!$fec) || (trim($fec) == '')) 
            { $fechanac = ''; }
        else {
            $fechanac = str_replace('/', '-', $fec); 
            $fechanac = date("Y-m-d", strtotime($fechanac));
        }
        $fec = $this->input->post('fechafall'); 
        if ((!$fec) || (trim($fec) == '')) 
            { $fechafall = ''; }
        else {
            $fechafall = str_replace('/', '-', $fec); 
            $fechafall = date("Y-m-d", strtotime($fechafall));
        }

        if ($id == 0){
            $resu = $this->Empleado_model->add_cargafamiliar_tmp($empleadotmp, $apellidos, $nombres, $ident, $parentesco, $telf, $fechanac, $fechafall, $activo, $sexo);
        }
        else {
            $resu = $this->Empleado_model->upd_cargafamiliar_tmp($id, $apellidos, $nombres, $ident, $parentesco, $telf, $fechanac, $fechafall, $activo, $sexo);
        }
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

    public function actualiza_rubroempleado(){
        $idusu = $this->session->userdata("sess_id");
        $empleadotmp = $this->session->userdata("tmp_empleado_idtmp");
        $id = $this->input->post('id'); 
        $existe = $this->input->post('existe'); 
        $valor = $this->input->post('valor'); 
        $this->Empleado_model->actualiza_rubroempleado($idusu, $empleadotmp, $id, $existe, $valor);
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

}

?>