<?php

/*------------------------------------------------
  ARCHIVO: Rubro.php
  DESCRIPCION: Contiene los métodos relacionados rubro.
  
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class rubro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Rubro_model");
        $this->load->Model("usuario_model");
        $this->load->Model("Departamento_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $data["base_url"] = base_url();
        $data["content"] = "rubro";
        $this->load->view("layout", $data);
    }

    public function tmp_rubro() {
        $this->session->unset_userdata("tmp_rubro_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_rubro_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_rubro_id", $id);
        } else {
            $this->session->set_userdata("tmp_rubro_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    function carga_rubrotmp($idrubro) {
        $idusu = $this->session->userdata("sess_id");
        $id = $this->Rubro_model->get_rubrotmp($idusu, $idrubro);
        $this->session->unset_userdata("tmp_rubro_idtmp"); 
        $this->session->set_userdata("tmp_rubro_idtmp", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_rubro_idtmp", $id);
        } else {
            $this->session->set_userdata("tmp_rubro_idtmp", NULL);
        }
    }

    public function listadoRubros() {
        $registro = $this->Rubro_model->lst_rubro();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad rubro_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad rubro_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "nombre":"' .$row->nombre_rubro. '",
                        "codigo":"' .$row->codigo_rubro. '",
                        "tiporubro":"' .$row->tiporubro. '",
                        "periodicidad":"' .$row->periodicidadmensual. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function upd_rubro(){
        $id = $this->session->userdata("tmp_rubro_id");
        $this->carga_rubrotmp($id);
        $tipoident = $this->Rubro_model->lst_tipoidentificacion();
        $perfil = $this->usuario_model->perfil_lst();
        $data["perfil"] = $perfil;
        $data["tipoident"] = $tipoident;
        $data["base_url"] = base_url();
        $obj = $this->rubro_model->sel_rubro_id($id);
        $data["obj"] = $obj;
        $parentesco = $this->rubro_model->lst_parentesco();
        $data["parentesco"] = $parentesco;
        $estadocivil = $this->rubro_model->lst_estadocivil();
        $data["estadocivil"] = $estadocivil;
        $tipovivienda = $this->rubro_model->lst_tipovivienda();
        $data["tipovivienda"] = $tipovivienda;
        $tipocuentabanco = $this->rubro_model->lst_tipocuentabanco();
        $data["tipocuenta"] = $tipocuentabanco;
        $banco = $this->rubro_model->lst_banco();
        $data["banco"] = $banco;
        $sexo = $this->rubro_model->lst_sexo();
        $data["sexo"] = $sexo;
        $tiposangre = $this->rubro_model->lst_tiposangre();
        $data["tiposangre"] = $tiposangre;
        $tipodiscapacidad = $this->rubro_model->lst_tipodiscapacidad();
        $data["tipodiscapacidad"] = $tipodiscapacidad;
        $ciudad = $this->rubro_model->lst_ciudad();
        $data["ciudad"] = $ciudad;
        $cargo = $this->rubro_model->lst_cargo();
        $data["cargo"] = $cargo;
        $empresa = $this->rubro_model->lst_empresa();
        $data["empresa"] = $empresa;
        $tipocontrato = $this->rubro_model->lst_tipocontrato();
        $data["tipocontrato"] = $tipocontrato;

        $data["content"] = "rubro_edit";
        $this->load->view("layout", $data);
//        $this->load->view("rubro_add", $data);
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

        if($id != 0){
            $resu = $this->rubro_model->upd_rubro($id, $nombre, $apellido, $tipoident, $identificacion, $perfil, $telefono, 
                                 $celular, $correo, $activo, $departamento, $lugarexpedicion, $cedulamilitar, $pasaporte, 
                                 $fecha_nacimiento, $sexo, $estadocivil, $peso, $talla, $codigoreloj, $calleprincipal, 
                                 $numerovivienda, $calletransversal, $sector, $referenciavivienda, $ciudad, $tipovivienda, 
                                 $vivefamiliares, $banco, $tipocuenta, $numerocuenta, $nombrecontacto, $direccioncontacto, 
                                 $parentescocontacto, $telefonocontacto, $empresa, $tiposangre, $tipodiscapacidad, 
                                 $p100discapacidad, $contrato, $cargo, $tipocontrato, $fechaingreso, $fechasalida, $sueldo);
        } else {
            $resu = $this->rubro_model->add_rubro($nombre, $apellido, $tipoident, $identificacion, $perfil, $telefono, 
                                 $celular, $correo, $activo, $departamento, $lugarexpedicion, $cedulamilitar, $pasaporte, 
                                 $fecha_nacimiento, $sexo, $estadocivil, $peso, $talla, $codigoreloj, $calleprincipal, 
                                 $numerovivienda, $calletransversal, $sector, $referenciavivienda, $ciudad, $tipovivienda, 
                                 $vivefamiliares, $banco, $tipocuenta, $numerocuenta, $nombrecontacto, $direccioncontacto, 
                                 $parentescocontacto, $telefonocontacto, $empresa, $tiposangre, $tipodiscapacidad, 
                                 $p100discapacidad, $contrato, $cargo, $tipocontrato, $fechaingreso, $fechasalida, $sueldo);
        }
        print "<script> window.location.href = '" . base_url() . "rubro'; </script>";
    }

    public function add_rubro(){
        $tiporubro = $this->Rubro_model->lst_tiporubro();
        $data["tiporubro"] = $tiporubro;
        $periodo = $this->Rubro_model->lst_periodo();
        $data["periodo"] = $periodo;
        $mesactivo = $this->Rubro_model->lst_mesactivo();
        $data["mesactivo"] = $mesactivo;

        $data["base_url"] = base_url();
        $this->load->view("rubro_add", $data);
    } 

    public function del_rubro(){
        $id = $this->input->post('id'); 
        $resu = $this->Rubro_model->del_rubro($id);
        $arr['mens'] = $id;
        print json_encode($arr); 
    }


}

?>