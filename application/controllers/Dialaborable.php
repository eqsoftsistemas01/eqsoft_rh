<?php

/*------------------------------------------------
  ARCHIVO: dialaborable.php
  DESCRIPCION: Contiene los métodos relacionados dialaborable.
  
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Dialaborable extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Dialaborable_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
       $anio = $this->session->userdata("tmp_aniolab");
       if ($anio == NULL) { 
            $anio = date("Y");           
            $this->session->unset_userdata("tmp_aniolab"); 
            $this->session->set_userdata("tmp_aniolab", $anio);
        }
        $data["tmpanio"] = $anio;
        $anios = $this->Dialaborable_model->lst_anios();
        $data["anios"] = $anios;
        $data["base_url"] = base_url();
        $data["content"] = "dialaborable";
        $this->load->view("layout", $data);
    }

    public function tmp_dialaborable() {
        $this->session->unset_userdata("tmp_aniolab"); 
        $id = $this->input->post("anio");
        $this->session->set_userdata("tmp_aniolab", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_aniolab", $id);
        } else {
            $this->session->set_userdata("tmp_aniolab", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function listadoDialaborable() {
        $anio = $this->session->userdata("tmp_aniolab");
        if ($anio == NULL) { 
            $anio = date("Y");
        }
        $registro = $this->Dialaborable_model->lst_dialaborable($anio);
        $tabla = "";
        foreach ($registro as $row) {

            $ver = '<div ><input type=\"text\" class=\"diaslab\" id=\"'.$row->mes.'\" value=\"'. $row->dias .'\" ></div>';

            $tabla.='{  "anio":"' .$row->anio. '",
                        "mes":"' .$row->mes . '",
                        "nombremes":"' .$row->nombremes. '",
                        "dias":"' .$row->dias. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function upd_dialaborable(){
        $anio = $this->session->userdata("tmp_aniolab");
        $mes = $this->input->post("mes");
        $dias = $this->input->post("dias");
        $resu = $this->Dialaborable_model->upd_dialaborable($anio, $mes, $dias);

        $arr['mens'] = $resu;
        print json_encode($arr); 
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
        $tipopermiso=$this->input->post('cmb_tipopermiso');

        if($id != 0){
            $resu = $this->dialaborable_model->upd_dialaborable($id, $empleado, $fecha_desde, $hora_desde, $fecha_hasta, $hora_hasta, $motivo, $aprobado, $tipopermiso);
        } else {
            $resu = $this->dialaborable_model->add_dialaborable($empleado, $fecha_desde, $hora_desde, $fecha_hasta, $hora_hasta, $motivo, $aprobado, $tipopermiso);
        }
        print "<script> window.location.href = '" . base_url() . "dialaborable'; </script>";
    }

    public function add_dialaborable(){
        $fecha = $this->session->userdata("tmp_permiso_desde");
        $fecha = str_replace('/', '-', $fecha); 
        $desde = date("Y-m-d", strtotime($fecha));
        $fecha = $this->session->userdata("tmp_permiso_hasta");
        $fecha = str_replace('/', '-', $fecha); 
        $hasta = date("Y-m-d", strtotime($fecha));
        $empleado = $this->dialaborable_model->lst_empleado($desde, $hasta, 0);
        $data["empleado"] = $empleado;
        $tipopermiso = $this->Tipopermiso_model->lst_tipopermiso();
        $data["tipopermiso"] = $tipopermiso;
        $data["base_url"] = base_url();
        $this->load->view("dialaborable_add", $data);
    } 

    public function del_dialaborable(){
        $id = $this->input->post('id'); 
        $resu = $this->dialaborable_model->del_dialaborable($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }



}

?>