<?php

/*------------------------------------------------
  ARCHIVO: utilidad.php
  DESCRIPCION: Contiene los métodos relacionados utilidad.
  
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Utilidad extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Utilidad_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
       $anio = $this->session->userdata("tmp_anioutil");
       if ($anio == NULL) { 
            $anio = date("Y");           
            $this->session->unset_userdata("tmp_anioutil"); 
            $this->session->set_userdata("tmp_anioutil", $anio);
        }
        $data["tmpanio"] = $anio;
        $anios = $this->Utilidad_model->lst_anios();
        $data["anios"] = $anios;
        $data["base_url"] = base_url();
        $data["content"] = "utilidad";
        $this->load->view("layout", $data);
    }

    public function tmp_utilidad() {
        $this->session->unset_userdata("tmp_anioutil"); 
        $id = $this->input->post("anio");
        $this->session->set_userdata("tmp_anioutil", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_anioutil", $id);
        } else {
            $this->session->set_userdata("tmp_anioutil", NULL);
        }
        $utilidad = $this->input->post("utilidad");
        $this->session->set_userdata("tmp_utilidad", NULL);
        if ($utilidad != NULL) {
            $this->session->set_userdata("tmp_utilidad", $utilidad);
        } else {
            $this->session->set_userdata("tmp_utilidad", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function listadoutilidad() {
        $anio = $this->session->userdata("tmp_anioutil");
        $utilidad = $this->session->userdata("tmp_utilidad");
        if ($anio == NULL) { $anio = date("Y"); }
        if ($utilidad == '') { $utilidad = 0; }
        $registro = $this->Utilidad_model->lst_utilidad($anio, $utilidad);
        $tabla = "";
        $cc = 0;
        foreach ($registro as $row) {
            $cc++;
            /*$ver = '<div ><input type=\"text\" class=\"diaslab\" id=\"'.$row->mes.'\" value=\"'. $row->dias .'\" ></div>';*/

            $tabla.='{  "num":"' .$cc. '",
                        "apellidos":"' .$row->apellidos . '",
                        "nombres":"' .$row->nombres. '",
                        "dias":"' .$row->dias. '",
                        "codigo":"' .$row->nro_ident. '",
                        "inicio":"' .$row->inicio. '",
                        "fin":"' .$row->fin. '",
                        "montoempleado":"' .$row->monto_empleado. '",
                        "cargas":"' .$row->cargas. '",
                        "montocarga":"' .$row->monto_cargas. '"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }







    public function upd_utilidad(){
        $anio = $this->session->userdata("tmp_aniolab");
        $mes = $this->input->post("mes");
        $dias = $this->input->post("dias");
        $resu = $this->utilidad_model->upd_utilidad($anio, $mes, $dias);

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
            $resu = $this->utilidad_model->upd_utilidad($id, $empleado, $fecha_desde, $hora_desde, $fecha_hasta, $hora_hasta, $motivo, $aprobado, $tipopermiso);
        } else {
            $resu = $this->utilidad_model->add_utilidad($empleado, $fecha_desde, $hora_desde, $fecha_hasta, $hora_hasta, $motivo, $aprobado, $tipopermiso);
        }
        print "<script> window.location.href = '" . base_url() . "utilidad'; </script>";
    }

    public function add_utilidad(){
        $fecha = $this->session->userdata("tmp_permiso_desde");
        $fecha = str_replace('/', '-', $fecha); 
        $desde = date("Y-m-d", strtotime($fecha));
        $fecha = $this->session->userdata("tmp_permiso_hasta");
        $fecha = str_replace('/', '-', $fecha); 
        $hasta = date("Y-m-d", strtotime($fecha));
        $empleado = $this->utilidad_model->lst_empleado($desde, $hasta, 0);
        $data["empleado"] = $empleado;
        $tipopermiso = $this->Tipopermiso_model->lst_tipopermiso();
        $data["tipopermiso"] = $tipopermiso;
        $data["base_url"] = base_url();
        $this->load->view("utilidad_add", $data);
    } 

    public function del_utilidad(){
        $id = $this->input->post('id'); 
        $resu = $this->utilidad_model->del_utilidad($id);
        $arr['mens'] = $resu;
        print json_encode($arr); 
    }



}

?>