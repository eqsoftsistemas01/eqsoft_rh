<?php

/*------------------------------------------------
  ARCHIVO: Permisoausencia.php
  DESCRIPCION: Contiene los métodos relacionados permisoausencia.
  
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Permisoausencia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Permisoausencia_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $desde = $this->session->userdata("tmp_permiso_desde");
        if ($desde != NULL) { 
            $data["desde"] = $desde;
        }    
        $hasta = $this->session->userdata("tmp_permiso_hasta");
        if ($hasta != NULL)  { 
            $data["hasta"] = $hasta;
        }    
        $data["base_url"] = base_url();
        $data["content"] = "permisoausencia";
        $this->load->view("layout", $data);
    }

    public function tmp_permisoausencia() {
        $this->session->unset_userdata("tmp_permiso_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_permiso_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_permiso_id", $id);
        } else {
            $this->session->set_userdata("tmp_permiso_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function tmp_fecha() {
        $this->session->unset_userdata("tmp_permiso_desde"); 
        $id = $this->input->post("desde");
        $this->session->set_userdata("tmp_permiso_desde", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_permiso_desde", $id);
        } else {
            $this->session->set_userdata("tmp_permiso_desde", NULL);
        }

        $this->session->unset_userdata("tmp_permiso_hasta"); 
        $id = $this->input->post("hasta");
        $this->session->set_userdata("tmp_permiso_hasta", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_permiso_hasta", $id);
        } else {
            $this->session->set_userdata("tmp_permiso_hasta", NULL);
        }

        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function listadoPermisoausencia() {
        $fecha = $this->session->userdata("tmp_permiso_desde");
        if ($fecha != NULL) { 
            $fecha = str_replace('/', '-', $fecha); 
            $desde = date("Y-m-d", strtotime($fecha));
        } 
        else {
            $desde = date("d/m/Y");
        }
        $fecha = $this->session->userdata("tmp_permiso_hasta");
        if ($fecha != NULL) { 
            $fecha = str_replace('/', '-', $fecha); 
            $hasta = date("Y-m-d", strtotime($fecha));
        } 
        else {
            $hasta = date("d/m/Y");
        }
        $registro = $this->Permisoausencia_model->lst_permisoausencia($desde, $hasta);
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad permisoausencia_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad permisoausencia_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "empleado":"' .$row->apellidos . ' ' . $row->nombres . '",
                        "fecha_desde":"' .$row->fecha_desde. '",
                        "hora_desde":"' .$row->hora_desde. '",
                        "fecha_hasta":"' .$row->fecha_hasta. '",
                        "hora_hasta":"' .$row->hora_hasta. '",
                        "motivo":"' .$row->motivo. '",
                        "aprobado":"' .$row->aprobado. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function upd_permisoausencia(){
        $id = $this->session->userdata("tmp_permiso_id");
        $obj = $this->Permisoausencia_model->sel_permisoausencia_id($id);
        $data["obj"] = $obj;
        $fecha = $this->session->userdata("tmp_permiso_desde");
        $fecha = str_replace('/', '-', $fecha); 
        $desde = date("Y-m-d", strtotime($fecha));
        $fecha = $this->session->userdata("tmp_permiso_hasta");
        $fecha = str_replace('/', '-', $fecha); 
        $hasta = date("Y-m-d", strtotime($fecha));
        $empleado = $this->Permisoausencia_model->lst_empleado($desde, $hasta, $obj->id_empleado);
        $data["empleado"] = $empleado;

        $data["base_url"] = base_url();
        $this->load->view("permisoausencia_add", $data);

    }

    public function guardar(){
        $id = $this->input->post("txt_id");
        $empleado=$this->input->post('cmb_empleado');

        $fec = $this->input->post('fecha_desde');
        if ((!$fec) || (trim($fec) == '')) 
            { $fecha_desde = ''; }
        else {
            $fecha_desde = str_replace('/', '-', $fec); 
            $fecha_desde = date("Y-m-d", strtotime($fecha_desde));
        }
        $fec = $this->input->post('fecha_hasta');
        if ((!$fec) || (trim($fec) == '')) 
            { $fecha_hasta = ''; }
        else {
            $fecha_hasta = str_replace('/', '-', $fec); 
            $fecha_hasta = date("Y-m-d", strtotime($fecha_hasta));
        }

        $hora_desde=$this->input->post('hora_desde');
        $hora_hasta=$this->input->post('hora_hasta');

        $motivo=$this->input->post('txt_motivo');
        $aprobado=$this->input->post('chkaprobado');
        if($aprobado == 'on'){ $aprobado = 1; } else { $aprobado = 0; }

        if($id != 0){
            $resu = $this->Permisoausencia_model->upd_permisoausencia($id, $empleado, $fecha_desde, $hora_desde, $fecha_hasta, $hora_hasta, $motivo, $aprobado);
        } else {
            $resu = $this->Permisoausencia_model->add_permisoausencia($empleado, $fecha_desde, $hora_desde, $fecha_hasta, $hora_hasta, $motivo, $aprobado);
        }
        print "<script> window.location.href = '" . base_url() . "permisoausencia'; </script>";
    }

    public function add_permisoausencia(){
        $fecha = $this->session->userdata("tmp_permiso_desde");
        $fecha = str_replace('/', '-', $fecha); 
        $desde = date("Y-m-d", strtotime($fecha));
        $fecha = $this->session->userdata("tmp_permiso_hasta");
        $fecha = str_replace('/', '-', $fecha); 
        $hasta = date("Y-m-d", strtotime($fecha));
        $empleado = $this->Permisoausencia_model->lst_empleado($desde, $hasta, 0);
        $data["empleado"] = $empleado;
        $data["base_url"] = base_url();
        $this->load->view("permisoausencia_add", $data);
    } 

    public function del_permisoausencia(){
        $id = $this->input->post('id'); 
        $resu = $this->Permisoausencia_model->del_permisoausencia($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }



}

?>