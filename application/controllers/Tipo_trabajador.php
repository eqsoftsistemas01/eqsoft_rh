<?php

/*------------------------------------------------
  ARCHIVO: Puntoemision.php
  DESCRIPCION: Contiene los métodos relacionados con ciudad.
  FECHA DE CREACIÓN: 19/03/2018
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Tipotrabajador extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Ciudad_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $idusu = $this->session->userdata("sess_id");
        $data["base_url"] = base_url();
        $data["content"] = "ciudad";
        $this->load->view("layout", $data);
    }

    public function tmp_ciudad() {
        $this->session->unset_userdata("tmp_ciudad_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_ciudad_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_ciudad_id", $id);
        } else {
            $this->session->set_userdata("tmp_ciudad_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function upd_ciudad(){
        $id = $this->session->userdata("tmp_ciudad_id");
        $provincia = $this->Ciudad_model->lst_provincia();
        $data["provincia"] = $provincia;
        $data["base_url"] = base_url();
        $obj = $this->Ciudad_model->sel_ciudad_id($id);
        $data["obj"] = $obj;
        $this->load->view("ciudad_add", $data);
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
        $provincia = $this->input->post('provincia'); 
       
        $activo = $this->input->post('activo');

        if($id != 0){
            $resu = $this->Ciudad_model->upd_ciudad($id, $nombre, $provincia, $activo);
        } else {
            $resu = $this->Ciudad_model->add_ciudad($nombre, $provincia, $activo);
        }
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

    public function add_ciudad(){
        $provincia = $this->Ciudad_model->lst_provincia();
        $data["provincia"] = $provincia;
        $data["base_url"] = base_url();
        $this->load->view("ciudad_add", $data);
    } 

    public function puede_eliminar(){
        $id = $this->input->post('id'); 
        $resu = $this->Ciudad_model->candel_ciudad($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }

    public function del_ciudad(){
        $id = $this->input->post('id'); 
        $resu = $this->Ciudad_model->del_ciudad($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }


    public function listadoTipoTrabajador() {
        $registro = $this->Ciudad_model->sel_tipotrabajador();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar Ciudad\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad ciudad_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad ciudad_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "nombre":"' .$row->tipo_trabajador. '",
                        "provincia":"' .$row->descripcion. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
}

?>