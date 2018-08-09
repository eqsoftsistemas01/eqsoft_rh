<?php

/*------------------------------------------------
  ARCHIVO: Provincia.php
  DESCRIPCION: Contiene los métodos relacionados con provincia.
  FECHA DE CREACIÓN: 19/03/2018
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Provincia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Provincia_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $idusu = $this->session->userdata("sess_id");
        $data["base_url"] = base_url();
        $data["content"] = "provincia";
        $this->load->view("layout", $data);
    }

    public function tmp_provincia() {
        $this->session->unset_userdata("tmp_provincia_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_provincia_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_provincia_id", $id);
        } else {
            $this->session->set_userdata("tmp_provincia_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function upd_provincia(){
        $id = $this->session->userdata("tmp_provincia_id");
        $pais = $this->Provincia_model->lst_pais();
        $data["pais"] = $pais;
        $data["base_url"] = base_url();
        $obj = $this->Provincia_model->sel_provincia_id($id);
        $data["obj"] = $obj;
        $this->load->view("provincia_add", $data);
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
        $pais = $this->input->post('pais'); 
       
        $activo = $this->input->post('activo');

        if($id != 0){
            $resu = $this->Provincia_model->upd_provincia($id, $nombre, $pais, $activo);
        } else {
            $resu = $this->Provincia_model->add_provincia($nombre, $pais, $activo);
        }
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

    public function add_provincia(){
        $pais = $this->Provincia_model->lst_pais();
        $data["pais"] = $pais;
        $data["base_url"] = base_url();
        $this->load->view("provincia_add", $data);
    } 

    public function puede_eliminar(){
        $id = $this->input->post('id'); 
        $resu = $this->Provincia_model->candel_provincia($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }

    public function del_provincia(){
        $id = $this->input->post('id'); 
        $resu = $this->Provincia_model->del_provincia($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }


    public function listadoProvincias() {
        $registro = $this->Provincia_model->sel_provincia();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar Provincia\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad prov_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad prov_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "nombre":"' .$row->nombre_provincia. '",
                        "pais":"' .$row->nombre_pais. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
}

?>