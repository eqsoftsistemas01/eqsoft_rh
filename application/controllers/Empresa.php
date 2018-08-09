<?php

/*------------------------------------------------
  ARCHIVO: Empresa.php
  DESCRIPCION: Contiene los métodos relacionados con el empresa.
  FECHA DE CREACIÓN: 19/03/2018
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Empresa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Empresa_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $idusu = $this->session->userdata("sess_id");
        $data["base_url"] = base_url();
        $data["content"] = "empresa";
        $this->load->view("layout", $data);
    }

    public function tmp_empresa() {
        $this->session->unset_userdata("tmp_empresa_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_empresa_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_empresa_id", $id);
        } else {
            $this->session->set_userdata("tmp_empresa_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function upd_empresa(){
        $id = $this->session->userdata("tmp_empresa_id");
        $data["base_url"] = base_url();
        $obj = $this->Empresa_model->sel_empresa_id($id);
        $data["obj"] = $obj;
        $this->load->view("empresa_add", $data);
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
        $ruc = $this->input->post('ruc'); 
        $rep = $this->input->post('rep'); 
        $activo = $this->input->post('activo');

        if($id != 0){
            $resu = $this->Empresa_model->upd_empresa($id, $nombre, $ruc, $rep, $activo);
        } else {
            $resu = $this->Empresa_model->add_empresa($nombre, $ruc, $rep, $activo);
        }
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

    public function add_empresa(){
        
        $data["base_url"] = base_url();
        $this->load->view("empresa_add", $data);
    } 

    public function puede_eliminar(){
        $id = $this->input->post('id'); 
        $resu = $this->Empresa_model->candel_empresa($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }

    public function del_empresa(){
        $id = $this->input->post('id'); 
        $resu = $this->Empresa_model->del_empresa($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }


    public function listadoEmpresas() {
        $registro = $this->Empresa_model->sel_empresa();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar Empresa\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad empresa_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad empresa_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "nombre":"' .$row->nombre_empresa. '",
                        "ruc":"' .$row->ruc_empresa. '",
                        "representante":"' .$row->representante_empresa. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
}

?>