<?php

/*------------------------------------------------
  ARCHIVO: asistencia.php
  DESCRIPCION: Contiene los métodos relacionados asistencia.
  
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Asistencia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Asistencia_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $fecha = $this->session->userdata("tmp_asist_fecha");
        if ($fecha == NULL) { 
            $this->session->unset_userdata("tmp_asist_fecha"); 
            $fecha = date("d/m/Y");
            $this->session->set_userdata("tmp_asist_fecha", $fecha);
        }    
        $data["base_url"] = base_url();
        $data["content"] = "asistencia";
        $this->load->view("layout", $data);
    }

    public function tmp_asistencia() {
        $this->session->unset_userdata("tmp_asistencia_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_asistencia_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_asistencia_id", $id);
        } else {
            $this->session->set_userdata("tmp_asistencia_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function tmp_fecha() {
        $this->session->unset_userdata("tmp_asist_fecha"); 
        $id = $this->input->post("fecha");
        $this->session->set_userdata("tmp_asist_fecha", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_asist_fecha", $id);
        } else {
            $this->session->set_userdata("tmp_asist_fecha", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function listadoAsistencia() {
        $fecha = $this->session->userdata("tmp_asist_fecha");
        if ($fecha != NULL) { 
            $fecha = str_replace('/', '-', $fecha); 
            $fecha = date("Y-m-d", strtotime($fecha));
        } 
        else {
            $fecha = date("d/m/Y");
        }
        $registro = $this->Asistencia_model->lst_asistencia($fecha);
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad asistencia_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad asistencia_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "empleado":"' .$row->apellidos . ' ' . $row->nombres . '",
                        "entrada_trabajo":"' .$row->entrada_trabajo. '",
                        "salida_almuerzo":"' .$row->salida_almuerzo. '",
                        "entrada_almuerzo":"' .$row->entrada_almuerzo. '",
                        "salida_trabajo":"' .$row->salida_trabajo. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function upd_asistencia(){
        $id = $this->session->userdata("tmp_asistencia_id");
        $obj = $this->Asistencia_model->sel_asistencia_id($id);
        $data["obj"] = $obj;
        $fecha = $this->session->userdata("tmp_asist_fecha");
        $fecha = str_replace('/', '-', $fecha); 
        $fecha = date("Y-m-d", strtotime($fecha));
        $empleado = $this->Asistencia_model->lst_empleado($fecha, $obj->id_empleado);
        $data["empleado"] = $empleado;

        $data["base_url"] = base_url();
        $this->load->view("asistencia_add", $data);

    }

    public function guardar(){
        $fecha = $this->session->userdata("tmp_asist_fecha");
        $fecha = str_replace('/', '-', $fecha); 
        $fecha = date("Y-m-d", strtotime($fecha));
        $id = $this->input->post("txt_id");
        $empleado=$this->input->post('cmb_empleado');
        $entrada_trabajo=$this->input->post('entrada_trabajo');
        if ((!$entrada_trabajo) || (trim($entrada_trabajo) == '')) { $entrada_trabajo = ''; }
        $salida_trabajo=$this->input->post('salida_trabajo');
        if ((!$salida_trabajo) || (trim($salida_trabajo) == '')) { $salida_trabajo = ''; }
        $salida_almuerzo=$this->input->post('salida_almuerzo');
        if ((!$salida_almuerzo) || (trim($salida_almuerzo) == '')) { $salida_almuerzo = ''; }
        $entrada_almuerzo=$this->input->post('entrada_almuerzo');
        if ((!$entrada_almuerzo) || (trim($entrada_almuerzo) == '')) { $entrada_almuerzo = ''; }

        if($id != 0){
            $resu = $this->Asistencia_model->upd_asistencia($id, $fecha, $empleado, $entrada_trabajo, $salida_almuerzo, $entrada_almuerzo, $salida_trabajo);
        } else {
            $resu = $this->Asistencia_model->add_asistencia($fecha, $empleado, $entrada_trabajo, $salida_almuerzo, $entrada_almuerzo, $salida_trabajo);
        }
        print "<script> window.location.href = '" . base_url() . "asistencia'; </script>";
    }

    public function add_asistencia(){
        $fecha = $this->session->userdata("tmp_asist_fecha");
        $fecha = str_replace('/', '-', $fecha); 
        $fecha = date("Y-m-d", strtotime($fecha));
        $empleado = $this->Asistencia_model->lst_empleado($fecha, 0);
        $data["empleado"] = $empleado;
        $data["base_url"] = base_url();
        $this->load->view("asistencia_add", $data);
    } 

    public function del_asistencia(){
        $id = $this->input->post('id'); 
        $resu = $this->Asistencia_model->del_asistencia($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }



}

?>