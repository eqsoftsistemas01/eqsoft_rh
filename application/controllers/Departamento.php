<?php

/*------------------------------------------------
  ARCHIVO: Puntoemision.php
  DESCRIPCION: Contiene los métodos relacionados con el departamento.
  FECHA DE CREACIÓN: 19/03/2018
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Departamento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Departamento_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $idusu = $this->session->userdata("sess_id");
        $data["base_url"] = base_url();
        $data["content"] = "departamento";
        $this->load->view("layout", $data);
    }

    public function tmp_departamento() {
        $this->session->unset_userdata("tmp_dpto_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_dpto_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_dpto_id", $id);
        } else {
            $this->session->set_userdata("tmp_dpto_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function upd_departamento(){
        $id = $this->session->userdata("tmp_dpto_id");
        $empleados = $this->Departamento_model->lst_empleado($id);
        $data["empleados"] = $empleados;
        $data["base_url"] = base_url();
        $obj = $this->Departamento_model->sel_departamento_id($id);
        $data["obj"] = $obj;
        $this->load->view("departamento_add", $data);
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
        $jefe = $this->input->post('jefe');
        $activo = $this->input->post('activo');

        if($id != 0){
            $resu = $this->Departamento_model->upd_departamento($id, $nombre, $jefe, $activo);
        } else {
            $resu = $this->Departamento_model->add_departamento($nombre, $jefe, $activo);
        }
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

    public function add_departamento(){
        $empleados = $this->Departamento_model->lst_empleado();
        $data["empleados"] = $empleados;
        $data["base_url"] = base_url();
        $this->load->view("departamento_add", $data);
    } 

    public function puede_eliminar(){
        $id = $this->input->post('id'); 
        $resu = $this->Departamento_model->candel_departamento($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }

    public function del_departamento(){
        $id = $this->input->post('id'); 
        $resu = $this->Departamento_model->del_departamento($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }


    public function listadoDepartamentos() {
        $registro = $this->Departamento_model->sel_departamento();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar Departamento\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad dpto_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad dpto_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "nombre":"' .$row->nombre_departamento. '",
                        "jefe":"' .$row->nombre_empleado. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }
}

?>