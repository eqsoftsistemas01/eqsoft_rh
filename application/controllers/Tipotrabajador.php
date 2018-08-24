<?php

/*------------------------------------------------
  ARCHIVO: Puntoemision.php
  DESCRIPCION: Contiene los métodos relacionados con Tipo de Empleado.
  FECHA DE CREACIÓN: 19/03/2018
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Tipotrabajador extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Tipotrabajador_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $idusu = $this->session->userdata("sess_id");
        $data["base_url"] = base_url();
        $data["content"] = "tipotrabajador";
        $this->load->view("layout", $data);
    }

    public function tmp_tipotrab() {
        $this->session->unset_userdata("tmp_tipotrab_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_tipotrab_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_tipotrab_id", $id);
        } else {
            $this->session->set_userdata("tmp_tipotrab_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function upd_tipotrabajador(){
        $id = $this->session->userdata("tmp_tipotrab_id");
        $data["base_url"] = base_url();
        $obj = $this->Tipotrabajador_model->sel_tipotrabajador_id($id);
        $data["obj"] = $obj;
        $this->load->view("tipotrabajador_add", $data);
    }

    public function agregar(){
        $id = $this->input->post('id'); 
        $tipotrabajador = $this->input->post('tipotrabajador'); 
        $descripcion = $this->input->post('descripcion'); 
       
        $activo = $this->input->post('activo');

        if($id != 0){
            $resu = $this->Tipotrabajador_model->upd_tipotrabajador($id, $tipotrabajador, $descripcion, $activo);
        } else {
            $resu = $this->Tipotrabajador_model->add_tipotrabajador($tipotrabajador, $descripcion, $activo);
        }
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

    public function add_tipotrabajador(){
        $data["base_url"] = base_url();
        $this->load->view("tipotrabajador_add", $data);
    } 

    public function del_tipotrabajador(){
        $id = $this->input->post('id'); 
        $resu = $this->Tipotrabajador_model->del_tipotrabajador($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }


    public function listadoTipoTrabajador() {
        $registro = $this->Tipotrabajador_model->sel_tipotrabajador();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad tipo_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad tipo_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "tipotrabajador":"' .$row->tipo_trabajador. '",
                        "descripcion":"' .$row->descripcion. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
}

?>