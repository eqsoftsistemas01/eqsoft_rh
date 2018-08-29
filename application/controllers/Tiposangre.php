<?php

/*------------------------------------------------
  ARCHIVO: Puntoemision.php
  DESCRIPCION: Contiene los métodos relacionados con Tipo de Empleado.
  FECHA DE CREACIÓN: 19/03/2018
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Tiposangre extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Tiposangre_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $idusu = $this->session->userdata("sess_id");
        $data["base_url"] = base_url();
        $data["content"] = "tiposangre";
        $this->load->view("layout", $data);
    }

    public function tmp_tiposangre() {
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

    public function upd_tiposangre(){
        $id = $this->session->userdata("tmp_tipotrab_id");
        $data["base_url"] = base_url();
        $obj = $this->Tiposangre_model->sel_tiposangre_id($id);
        $data["obj"] = $obj;
        $this->load->view("tiposangre_add", $data);
    }

    public function agregar(){
        $id = $this->input->post('id'); 
        $tiposangre = $this->input->post('tiposangre'); 
       
        $activo = $this->input->post('activo');
        if ($activo == 'on') { $activo = '1'; } else { $activo = '0'; }

        if($id != 0){
            $resu = $this->Tiposangre_model->upd_tiposangre($id, $tiposangre, $activo);
        } else {
            $resu = $this->Tiposangre_model->add_tiposangre($tiposangre, $activo);
        }
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

    public function add_tiposangre(){
        $data["base_url"] = base_url();
        $this->load->view("tiposangre_add", $data);
    } 

    public function del_tiposangre(){
        $id = $this->input->post('id'); 
        $resu = $this->Tiposangre_model->del_tiposangre($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }


    public function listadotiposangre() {
        $registro = $this->Tiposangre_model->sel_tiposangre();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad tipo_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad tipo_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "tiposangre":"' .$row->tiposangre. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
}

?>