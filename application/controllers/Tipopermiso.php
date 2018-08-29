<?php

/*------------------------------------------------
  ARCHIVO: tipopermiso.php
  DESCRIPCION: Contiene los métodos relacionados con Tipo de permiso.
  FECHA DE CREACIÓN: 19/03/2018
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Tipopermiso extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Tipopermiso_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $idusu = $this->session->userdata("sess_id");
        $data["base_url"] = base_url();
        $data["content"] = "tipopermiso";
        $this->load->view("layout", $data);
    }

    public function tmp_tipopermiso() {
        $this->session->unset_userdata("tmp_tipopermiso_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_tipopermiso_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_tipopermiso_id", $id);
        } else {
            $this->session->set_userdata("tmp_tipopermiso_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function upd_tipopermiso(){
        $id = $this->session->userdata("tmp_tipopermiso_id");
        $data["base_url"] = base_url();
        $obj = $this->Tipopermiso_model->sel_tipopermiso_id($id);
        $data["obj"] = $obj;
        $this->load->view("tipopermiso_add", $data);
    }

    public function agregar(){
        $id = $this->input->post('id'); 
        $tipopermiso = $this->input->post('tipopermiso');      
        $activo = $this->input->post('activo');

        if($id != 0){
            $resu = $this->Tipopermiso_model->upd_tipopermiso($id, $tipopermiso, $activo);
        } else {
            $resu = $this->Tipopermiso_model->add_tipopermiso($tipopermiso, $activo);
        }
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

    public function add_tipopermiso(){
        $data["base_url"] = base_url();
        $this->load->view("tipopermiso_add", $data);
    } 

    public function del_tipopermiso(){
        $id = $this->input->post('id'); 
        $resu = $this->Tipopermiso_model->del_tipopermiso($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }


    public function listadotipopermiso() {
        $registro = $this->Tipopermiso_model->sel_tipopermiso();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad tipo_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad tipo_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "tipopermiso":"' .$row->tipopermiso. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
}

?>