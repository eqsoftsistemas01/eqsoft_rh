<?php

/*------------------------------------------------
  ARCHIVO: jornada.php
  DESCRIPCION: Contiene los métodos relacionados jornada.
  
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Jornada extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Jornada_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $data["base_url"] = base_url();
        $data["content"] = "jornada";
        $this->load->view("layout", $data);
    }

    public function tmp_jornada() {
        $this->session->unset_userdata("tmp_jornada_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_jornada_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_jornada_id", $id);
        } else {
            $this->session->set_userdata("tmp_jornada_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function listadoJornadas() {
        $registro = $this->Jornada_model->lst_jornada();
        $tabla = "";
        foreach ($registro as $row) {
/*            $fec = str_replace('-', '/', $row->entrada_trabajo); $entrada_trabajo = date("d/m/Y  H:i:s", strtotime(@$fec));
            $fec = str_replace('-', '/', $row->salida_almuerzo); $salida_almuerzo = date("d/m/Y  H:i:s", strtotime(@$fec));
            $fec = str_replace('-', '/', $row->entrada_almuerzo); $entrada_almuerzo = date("d/m/Y  H:i:s", strtotime(@$fec));
            $fec = str_replace('-', '/', $row->salida_trabajo); $salida_trabajo = date("d/m/Y  H:i:s", strtotime(@$fec));
*/
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad jornada_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad jornada_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "descripcion":"' .$row->descripcion. '",
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

    public function upd_jornada(){
        $id = $this->session->userdata("tmp_jornada_id");
        $obj = $this->Jornada_model->sel_jornada_id($id);
        $data["obj"] = $obj;

        $data["base_url"] = base_url();
        $this->load->view("jornada_add", $data);

    }

    public function guardar(){
        $id = $this->input->post("txt_id");
        $descripcion=$this->input->post('descripcion');
        $entrada_trabajo=$this->input->post('entrada_trabajo');
        if ((!$entrada_trabajo) || (trim($entrada_trabajo) == '')) { $entrada_trabajo = ''; }
        $salida_trabajo=$this->input->post('salida_trabajo');
        if ((!$salida_trabajo) || (trim($salida_trabajo) == '')) { $salida_trabajo = ''; }
        $salida_almuerzo=$this->input->post('salida_almuerzo');
        if ((!$salida_almuerzo) || (trim($salida_almuerzo) == '')) { $salida_almuerzo = ''; }
        $entrada_almuerzo=$this->input->post('entrada_almuerzo');
        if ((!$entrada_almuerzo) || (trim($entrada_almuerzo) == '')) { $entrada_almuerzo = ''; }
        $jornada_activo =$this->input->post('chkactivo');
        if ($jornada_activo == 'on') {
            $activo = '1';
        }else
        {
            $activo = '0';
        }

        if($id != 0){
            $resu = $this->Jornada_model->upd_jornada($id, $descripcion, $entrada_trabajo, $salida_almuerzo, $entrada_almuerzo, $salida_trabajo, $activo);
        } else {
            $resu = $this->Jornada_model->add_jornada($descripcion, $entrada_trabajo, $salida_almuerzo, $entrada_almuerzo, $salida_trabajo, $activo);
        }
        print "<script> window.location.href = '" . base_url() . "jornada'; </script>";
    }

    public function add_jornada(){
            $data["base_url"] = base_url();
        $this->load->view("jornada_add", $data);
    } 

    public function del_jornada(){
        $id = $this->input->post('id'); 
        $resu = $this->Jornada_model->del_jornada($id);
        $arr['mens'] = $id;
        print json_encode($arr); 
    }



}

?>