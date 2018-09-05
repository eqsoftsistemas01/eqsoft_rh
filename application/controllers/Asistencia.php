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
        $this->load->Model("Empleado_model");       
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $fecha = $this->session->userdata("tmp_asist_fecha");
        if ($fecha == NULL) { 
            $this->session->unset_userdata("tmp_asist_fecha"); 
            $fecha = date("d/m/Y");
            $this->session->set_userdata("tmp_asist_fecha", $fecha);
        }    
        $hasta = $this->session->userdata("tmp_asist_hasta");
        if ($hasta == NULL) { 
            $this->session->unset_userdata("tmp_asist_hasta"); 
            $hasta = date("d/m/Y");
            $this->session->set_userdata("tmp_asist_hasta", $hasta);
        }    
        $idemp = $this->session->userdata("tmp_asist_emp");
        if ($idemp == NULL) { 
            $this->session->unset_userdata("tmp_asist_emp"); 
            $idemp = 0;
            $this->session->set_userdata("tmp_asist_emp", $idemp);
        }    
        $empleado = $this->Asistencia_model->lst_empleado();
        $data["fecha"] = $fecha;
        $data["hasta"] = $hasta;
        $data["empleado"] = $empleado;
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

        $this->session->unset_userdata("tmp_asist_hasta"); 
        $id = $this->input->post("hasta");
        $this->session->set_userdata("tmp_asist_hasta", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_asist_hasta", $id);
        } else {
            $this->session->set_userdata("tmp_asist_hasta", NULL);
        }

        $this->session->unset_userdata("tmp_asist_emp"); 
        $emp = $this->input->post("emp");
        $this->session->set_userdata("tmp_asist_emp", NULL);
        if ($emp != NULL) {
            $this->session->set_userdata("tmp_asist_emp", $emp);
        } else {
            $this->session->set_userdata("tmp_asist_emp", NULL);
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
        $hasta = $this->session->userdata("tmp_asist_hasta");
        if ($hasta != NULL) { 
            $hasta = str_replace('/', '-', $hasta); 
            $hasta = date("Y-m-d", strtotime($hasta));
        } 
        else {
            $hasta = date("d/m/Y");
        }
        $emp = $this->session->userdata("tmp_asist_emp");
        if (($emp == NULL) || ($emp == '')) { $emp = 0; } 
        $registro = $this->Asistencia_model->lst_asistencia($fecha, $hasta, $emp);
        $tabla = "";

        $usua = $this->session->userdata('usua');
        $perfil = $usua->perfil;

        foreach ($registro as $row) {

            $fecha = str_replace('-', '/', $row->fecha); $fecha = date("d/m/Y", strtotime($fecha));

            if ($perfil != 3){
                $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad asistencia_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad asistencia_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            } else {
                $ver = '';
            }    
            $tabla.='{  "id":"' .$row->id. '",
                        "fecha":"' .$fecha. '",
                        "empleado":"' .addslashes($row->apellidos . ' ' . $row->nombres) . '",
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
        $fec = $this->session->userdata("tmp_asist_fecha");
        $data["fecha"] = $fec;
        $fhasta = $this->session->userdata("tmp_asist_hasta");
        $data["hasta"] = $fhasta;
        $fecha = str_replace('/', '-', $fec); 
        $fecha = date("Y-m-d", strtotime($fecha));
        $hasta = str_replace('/', '-', $fhasta); 
        $hasta = date("Y-m-d", strtotime($hasta));
        $empleado = $this->Asistencia_model->lst_empleadofecha($fecha, $hasta, $obj->id_empleado);
        $data["empleado"] = $empleado;

        $data["base_url"] = base_url();
        $this->load->view("asistencia_add", $data);

    }

    public function guardar(){
/*        $fecha = $this->session->userdata("tmp_asist_fecha");*/
        $fecha = $this->input->post("fechaedit");
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
        $fec = $this->session->userdata("tmp_asist_fecha");
        $data["fecha"] = $fec;
        $fhasta = $this->session->userdata("tmp_asist_hasta");
        $data["hasta"] = $fhasta;
        $fecha = str_replace('/', '-', $fec); 
        $fecha = date("Y-m-d", strtotime($fecha));
        $hasta = str_replace('/', '-', $fhasta); 
        $hasta = date("Y-m-d", strtotime($hasta));
        $empleado = $this->Asistencia_model->lst_empleadofecha($fecha, $hasta, 0);
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

    public function verifica_asistencia(){
        $emp = $this->input->post('emp'); 
        $fecha = $this->input->post('fecha'); 
        $fecha = str_replace('/', '-', $fecha); 
        $fecha = date("Y-m-d", strtotime($fecha));
        $res = $this->Asistencia_model->sel_asistencia_fecha($emp, $fecha);
        print json_encode($res); 
    }

    public function import_asistencia(){
        $data["base_url"] = base_url();
        $this->load->view("asistencia_import", $data);
    } 

    function multiexplode ($delimiters,$string) {
       
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }

    public function import_archivo_asist(){
        if ($_FILES['fichero_usuario']['tmp_name'] != ''){
            $file_lines = file($_FILES['fichero_usuario']['tmp_name']);
            $arremp = [];
            $arrfecha = [];
            $arrlines = [];
            foreach ($file_lines as $key => $line) {
                if ($key != 0){
                    $arr = explode("\t", $line);
                    $arrlines[] = $arr;
                    if (in_array($arr[2], $arremp) != true){
                        $arremp[] = $arr[2];
                    }                       
                    $arr2 = explode(" ", $arr[6]);
                    if (in_array($arr2[0], $arrfecha) != true){
                        $arrfecha[] = $arr2[0];
                    }                       
                }
            }
            foreach ($arrfecha as $fec) {
                $fecha = str_replace('/', '-', $fec); 
                foreach ($arremp as $codemp) {
                    $emp = $this->Empleado_model->sel_empleado_codigoreloj($codemp);
                    if ($emp){
                        $asist = [];
                        foreach ($arrlines as $line) {
                            $arr2 = explode(" ", $line[6]);
                            if (($arr2[0] == $fec) && ($line[2] == $codemp)){
                                $asist[] = $line[6];
                            }
                        }    
                        if (count($asist) > 0) { $entrada_trabajo = $asist[0]; } else { $entrada_trabajo = ''; }
                        if (count($asist) > 1) { $salida_almuerzo = $asist[1]; } else { $salida_almuerzo = ''; }
                        if (count($asist) > 2) { $entrada_almuerzo = $asist[2]; } else { $entrada_almuerzo = ''; }
                        if (count($asist) > 3) { $salida_trabajo = $asist[3]; } else { $salida_trabajo = ''; }
                        if (count($asist) > 0) {
                            $res = $this->Asistencia_model->sel_asistencia_fecha($emp->id_empleado, $fecha);
                            if ($res){
                                $resu = $this->Asistencia_model->upd_asistencia($res->id, $fecha, $emp->id_empleado, $entrada_trabajo, $salida_almuerzo, $entrada_almuerzo, $salida_trabajo);
                            } else {
                                $resu = $this->Asistencia_model->add_asistencia($fecha, $emp->id_empleado, $entrada_trabajo, $salida_almuerzo, $entrada_almuerzo, $salida_trabajo);
                            }
                        }    

                    }    
                }
            }    

        }
        print "<script> window.location.href = '" . base_url() . "asistencia'; </script>";       
    } 

}

?>