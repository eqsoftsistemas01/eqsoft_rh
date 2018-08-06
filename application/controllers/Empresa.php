<?php

/*------------------------------------------------
  ARCHIVO: Empresa.php
  DESCRIPCION: Contiene los métodos relacionados con la Empresa.
  FECHA DE CREACIÓN: 05/07/2017
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Empresa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("empresa_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $data["base_url"] = base_url();
        $emp = $this->empresa_model->emp_get();
        $data["emp"] = $emp;
        $data["content"] = "empresa";
        $this->load->view("layout", $data);
    }

    public function listadoDataEmp() {

        $registro = $this->empresa_model->lst_empresa();
        $tabla = "";

        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id_emp.'\" class=\"btn btn-success btn-xs btn-grad emp_editar\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id_emp.'\" class=\"btn btn-danger btn-xs btn-grad emp_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{"id":"' . $row->id_emp . '",
                      "codigo":"' . $row->cod_emp . '",
                      "nombre":"' . $row->nom_emp . '",
                      "ruc":"' . $row->ruc_emp . '",
                      "razon":"' . $row->raz_soc_emp . '",
                      "ver":"'.$ver.'"},';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);

        echo '{"data":[' . $tabla . ']}';
    }
    
    public function tmp_emp() {
        $this->session->unset_userdata("tmp_emp_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_emp_id", NULL);
        if ($id != NULL) { $this->session->set_userdata("tmp_emp_id", $id); } 
        else { $this->session->set_userdata("tmp_emp_id", NULL); }
        $arr['resu'] = 1;
        print json_encode($arr);
    } 

    public function emp_editar(){
        $idemp = $this->session->userdata("tmp_emp_id");
        $empresa = $this->empresa_model->sel_emp_id($idemp); 
        $data["empresa"] = $empresa;       
        $data["base_url"] = base_url();
        $data["content"] = "emp_add";
        $this->load->view("layout", $data);        
    }

    public function emp_add(){
        $data["base_url"] = base_url();
        $data["content"] = "emp_add";
        $this->load->view("layout", $data);        
    }

    public function guardar(){
        $id = $this->input->post('txt_idemp');
        $cod = $this->input->post('txt_codigo');
        $nom = $this->input->post('txt_nom');
        $ruc = $this->input->post('txt_ruc');
        $rs = $this->input->post('txt_razon');
        $ema = $this->input->post('txt_email');
        $tlf = $this->input->post('txt_telefono');
        $fax = $this->input->post('txt_fax');
        $dir = $this->input->post('txt_dir');
        $rep = $this->input->post('txt_rep');
        $web = $this->input->post('txt_web');
        $logo = $this->input->post('logo');
        $old_logo = $this->input->post('old_logo');       

       
        if (isset($_POST['logo']) && $_POST['logo'] == ''){
            $img = '';
        }
        else{
            $logo_name= $_FILES["logo"]["name"];

            /* ESTE CONDICIONAL NOS PERMITE GUARDAR O MODIFICAR USUARIOS SIN QUE LE ASIGNEN logo */
            if ($logo_name == NULL || $logo_name == ""){
                $img = '';
            } else { 
                $logo_size= $_FILES["logo"]["size"];
                $logo_type= $_FILES["logo"]["type"];
                $logo_temporal= $_FILES["logo"]["tmp_name"];     

                /*$ext = pathinfo($logo_name, PATHINFO_EXTENSION);      */

                $split_logo = pathinfo($logo_name);
                $split_temporal = pathinfo($logo_temporal);

                $img = $split_temporal['filename'].".".$split_logo['extension'];
                $file_name = FCPATH.'/public/img/empresa/'.$img;

                $f1= fopen($logo_temporal,"rb");
                # Leemos el fichero completo limitando la lectura al tamaño del fichero
                $logo_reconvertida = fread($f1, $logo_size);
                fclose($f1);

                $file = fopen($file_name , 'w') or die("X_x");
                fwrite($file, $logo_reconvertida);
                fclose($file);
            }        
        }    

        if (($id == "") || ($id == 0))
            $resu = $this->empresa_model->emp_ins($cod, $nom, $ruc, $rs, $ema, $tlf, $fax, $dir, $rep, $web, $img);
        else {    
            $resu = $this->empresa_model->emp_upd($id, $cod, $nom, $ruc, $rs, $ema, $tlf, $fax, $dir, $rep, $web, $img);
            if (trim($old_logo) != ''){
                $file_name = FCPATH.'/public/img/empresa/'.$old_logo;
                if (file_exists($file_name))
                    unlink($file_name);
            }
        }    

        /*print "<script language='JavaScript'>alert('Los Datos Fueron Actualizados');</script>";*/

        print "<script> window.location.href = '" . base_url() . "empresa'; </script>";

    }
 
    /* SE ELIMINA EL REGISTRO SELECCIONADO */
    public function existe_info_emp(){
        $id = $this->input->post('id'); 
        $result = $this->empresa_model->existe_info_emp($id);
        $arr['mens'] = $result;
        print json_encode($arr); 
    }

    /* SE ELIMINA EL REGISTRO SELECCIONADO */
    public function eliminar(){
        $id = $this->input->post('id'); 
        $this->empresa_model->emp_del($id);
        $arr['mens'] = 1;
        print json_encode($arr); 
    }

  
}

?>