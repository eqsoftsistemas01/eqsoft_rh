<?php

/*------------------------------------------------
  ARCHIVO: Cargo.php
  DESCRIPCION: Contiene los métodos relacionados con el Cargo.
  FECHA DE CREACIÓN: 19/03/2018
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Cargo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Cargo_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $idusu = $this->session->userdata("sess_id");
        $data["base_url"] = base_url();
        $data["content"] = "cargo";
        $this->load->view("layout", $data);
    }

    public function tmp_cargo() {
        $this->session->unset_userdata("tmp_cargo_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_cargo_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_cargo_id", $id);
        } else {
            $this->session->set_userdata("tmp_cargo_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function upd_cargo(){
        $id = $this->session->userdata("tmp_cargo_id");
        $data["base_url"] = base_url();
        $obj = $this->Cargo_model->sel_cargo_id($id);
        $data["obj"] = $obj;
        $this->load->view("cargo_add", $data);
    }

    public function agregar(){
/*        $id = $this->input->post('txt_id'); 
        $nombre = $this->input->post('txt_nombre'); 
        $jefe = $this->input->post('cmb_empleado');
        $activo = $this->input->post('chkactivo');
        if($activo == 'on'){ $activo = 1; } else { $activo = 0; }
*/
        $id = $this->input->post('id'); 
        $nombre = $this->input->post('nombre'); 
        $activo = $this->input->post('activo');

        if($id != 0){
            $resu = $this->Cargo_model->upd_cargo($id, $nombre, $activo);
        } else {
            $resu = $this->Cargo_model->add_cargo($nombre, $activo);
        }
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

    public function add_cargo(){
        
        $data["base_url"] = base_url();
        $this->load->view("cargo_add", $data);
    } 

    public function puede_eliminar(){
        $id = $this->input->post('id'); 
        $resu = $this->Cargo_model->candel_cargo($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }

    public function del_cargo(){
        $id = $this->input->post('id'); 
        $resu = $this->Cargo_model->del_cargo($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }


    public function listadoCargos() {
        $registro = $this->Cargo_model->sel_cargo();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar Cargo\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad cargo_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad cargo_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "nombre":"' .$row->nombre_cargo. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
}

?>