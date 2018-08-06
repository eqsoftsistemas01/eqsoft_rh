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
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $idusu = $this->session->userdata("sess_id");
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

    public function listadoEmpleados() {
        $registro = $this->Empleado_model->lst_empleado();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id_empleado.'\" class=\"btn btn-success btn-xs btn-grad ret_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id_empleado.'\" class=\"btn btn-danger btn-xs btn-grad ret_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id_empleado. '",
                        "nombre":"' .$row->nombre_empleado. '",
                        "identificacion":"' .$row->nro_ident. '",
                        "departamento":"' .$row->nombre_departamento. '",
                        "direccion":"' .$row->direccion_empleado. '",
                        "telefono":"' .$row->telf_empleado. '",
                        "correo":"' .$row->correo_empleado. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function upd_empleado(){
        $id = $this->session->userdata("tmp_empleado_id");
        $tipoident = $this->Empleado_model->lst_tipoidentificacion();
        $perfil = $this->usuario_model->perfil_lst();
        $departamento = $this->Departamento_model->sel_departamento();
        $data["departamento"] = $departamento;
        $data["perfil"] = $perfil;
        $data["tipoident"] = $tipoident;
        $data["base_url"] = base_url();
        $obj = $this->Empleado_model->sel_empleado_id($id);
        $data["obj"] = $obj;
        $this->load->view("empleado_add", $data);
    }

    public function guardar(){
        $id = $this->input->post('id'); 
        $nombre = $this->input->post('nombre');
        $tipoident = $this->input->post('tipoident');
        $ident = $this->input->post('ident');
        $perfil = $this->input->post('perfil');
        $departamento = $this->input->post('departamento');
        $direccion = $this->input->post('direccion');
        $telefono = $this->input->post('telefono');
        $correo = $this->input->post('correo');
        $activo = $this->input->post('activo');
        if($activo == 'on'){ $activo = 1; } else { $activo = 0; }
        if($id != 0){
            $resu = $this->Empleado_model->upd_empleado($id, $nombre, $tipoident, $ident, $perfil, $direccion, $telefono, $correo, $activo, $departamento);
        } else {
            $resu = $this->Empleado_model->add_empleado($nombre, $tipoident, $ident, $perfil, $direccion, $telefono, $correo, $activo, $departamento);
        }
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

    public function add_empleado(){
        $tipoident = $this->Empleado_model->lst_tipoidentificacion();
        $perfil = $this->usuario_model->perfil_lst();
        $departamento = $this->Departamento_model->sel_departamento();
        $data["departamento"] = $departamento;
        $data["perfil"] = $perfil;
        $data["tipoident"] = $tipoident;
        $data["base_url"] = base_url();
        $this->load->view("empleado_add", $data);
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

}

?>