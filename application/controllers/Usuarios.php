<?php

/* ------------------------------------------------
  ARCHIVO: Usuarios.php
  DESCRIPCION: Contiene los métodos relacionados con Usuarios.
  FECHA DE CREACIÓN: 30/06/2017 
 * 
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("usuario_model");
    }

    // MÉTODO PREDETERMINADO DEL CONTROLADOR
    public function index() {
        $data["base_url"] = base_url();
        $data["content"] = "usu_listar";
        $this->load->view("layout", $data);
    }

    public function agregar(){
        $perfil = $this->usuario_model->perfil_lst();
        $data['perfil'] = $perfil;        
        $empleado = $this->usuario_model->lst_empleado();
        $data['empleado'] = $empleado;        

        $data["base_url"] = base_url();
        $data["content"] = "usu_add";
        $this->load->view("layout", $data);
    } 

    public function usu_edit(){
        $data["base_url"] = base_url();
        $id_usu = $this->session->userdata("tmp_id_usu");
        $val = 1;        
        $fic_usu = $this->usuario_model->usu_get($id_usu);
        $perfil = $this->usuario_model->perfil_lst();
        $data['fic_usu'] = $fic_usu;
        $data['perfil'] = $perfil;
        $idemp = $fic_usu->id_empleado;
        if (($idemp == NULL) || ($idemp == '')) { $idemp = 0; }
        $empleado = $this->usuario_model->lst_empleado($idemp);
        $data['empleado'] = $empleado;        
        $data["content"] = "usu_add";
        $this->load->view("layout", $data);
    }

    public function guardar(){
        /* SE CAPTURAN LOS DATOS DEL FORMULARIO */
        $id = $this->input->post('txt_id');
        $nom = $this->input->post('txt_nombre');  
        $usu = $this->input->post('txt_usuario');
        $pwd = $this->input->post('txt_clave');
        $est = $this->input->post('cmb_estatus');
        $foto = $this->input->post('foto');
        $perfil = $this->input->post('cmb_perfil');
        $idempleado = $this->input->post('cmb_empleado');
        if($idempleado == ''){ $idempleado = 0; }

        $foto_name= $_FILES["foto"]["name"];
        /* ESTE CONDICIONAL NOS PERMITE GUARDAR O MODIFICAR USUARIOS SIN QUE LE ASIGNEN FOTO */
        if ($foto_name == NULL || $foto_name == ""){
            $fot = NULL;
        } else { 
            $foto_name= $_FILES["foto"]["name"];
            $foto_size= $_FILES["foto"]["size"];
            $foto_type= $_FILES["foto"]["type"];
            $foto_temporal= $_FILES["foto"]["tmp_name"];

            # Limitamos los formatos de imagen admitidos a: png, jpg y gif
            if ($foto_type=="image/x-png" OR $foto_type=="image/png") { $extension="image/png"; }
            if ($foto_type=="image/pjpeg" OR $foto_type=="image/jpeg"){ $extension="image/jpeg";}
            if ($foto_type=="image/gif" OR $foto_type=="image/gif")   { $extension="image/gif"; }

            /*Reconversion de la imagen para meter en la tabla abrimos el fichero temporal en modo lectura "r" y binaria "b"*/
            $f1= fopen($foto_temporal,"rb");
            # Leemos el fichero completo limitando la lectura al tamaño del fichero
            $foto_reconvertida = fread($f1, $foto_size);
            /* Se cifra en Base64 Encode de manera que la foto quede cifrada dentro de la base de datos */
            $fot = base64_encode($foto_reconvertida);
            /* cerrar el fichero temporal */
            fclose($f1);  
        }

        /* EVALUAR SI EL REGISTRO ES DE ACTUALIZACION O DE INGRESO */
        if($id != 0){
            /* SE ACTUALIZA EL REGISTRO DEL USUARIO */
            $resu = $this->usuario_model->usu_upd($id, $nom, $usu, $pwd, $est, $fot, $perfil, $idempleado);
        } else {
            /* SE GUARDA EL REGISTRO DEL USUARIO */
            $resu = $this->usuario_model->usu_add($nom, $usu, $pwd, $est, $fot, $perfil, $idempleado);
        }

        /* SE REDIRECCIONA A LA PANTALLA PRINCIPAL*/
        print "<script> window.location.href = '" . base_url() . "usuarios'; </script>";
        /*        print "<script> alert('LISTO'); </script>";*/
                        
    } 

        public function temp_usu() {
            $id = $this->input->post("id");
            $this->session->set_userdata("tmp_id_usu", NULL);
            if ($id != NULL) {
                $this->session->set_userdata("tmp_id_usu", $id);
            } else {
                $this->session->set_userdata("tmp_id_usu", NULL);
            }
            $arr['resu'] = 1;
            print json_encode($arr);
    }


    public function listadoDataUsu() {

        $registro = $this->usuario_model->lst_usu();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Ver\" id=\"'.$row->id_usu.'\" class=\"btn btn-success btn-xs btn-grad usu_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id_usu.'\" class=\"btn btn-danger btn-xs btn-grad usu_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{"id":"' . $row->id_usu . '",
                      "nombres":"' . $row->nom_usu . '",
                      "usuario":"' . $row->log_usu . '",
                      "estatus":"' . $row->est_usu . '",
                      "ver":"'.$ver.'"},';
/*            $tabla.='{"id":"' . $row->id_usu . '",
                      "cedula":"' . $row->ide_usu . '",
                      "nombres":"' . $row->nom_usu . '",
                      "apellidos":"' . $row->ape_usu . '",
                      "usuario":"' . $row->log_usu . '",
                      "estatus":"' . $row->est_usu . '",
                      "ver":"'.$ver.'"},';
*/
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';

    }
    /* ABRIR FORMULARIO CON ROLES */
    public function usu_rol(){
        $data["base_url"] = base_url();
        $id_usu = $this->session->userdata("tmp_id_usu");
        $fic_usu = $this->usuario_model->usu_get($id_usu);
        $data['fic_usu'] = $fic_usu;
        $data["content"] = "usu_roles";
        $this->load->view("layout", $data);
    }

    /* RECIBE LOS DATOS DE ROLES */
    public function usu_rol_add(){
        $id_usu = $this->session->userdata("tmp_id_usu");
        /* Seccion de Categoria */
        $catv = $this->input->post('catv');
        $cata = $this->input->post('cata');
        $catu = $this->input->post('catu');
        $cate = $this->input->post('cate');
        $catr = $this->input->post('catr');
        $rol_cat = $this->usuario_model->rol_usu_cat($id_usu, $catv, $cata, $catu, $cate, $catr);

        $arr['usu'] = $id_usu;
        $arr['catv'] = $catv;
        $arr['cata'] = $cata;
        $arr['catu'] = $catu;
        $arr['cate'] = $cate;
        $arr['catr'] = $catr;

        
        $resu = 1;
        $arr['resu'] = $resu;
        print json_encode($arr);

    }

    public function del_usu(){
        $id_usu = $this->input->post("id");
        $mesero = $this->usuario_model->usua_del($id_usu);
        $resu = $id_usu;
        $arr['resu'] = $resu;
        print json_encode($arr);
    }
  
    public function usu_upd_acceso(){
        $this->usuario_model->usu_upd_acceso();
        $resu = 1;
        $arr['resu'] = $resu;
        print json_encode($arr);
    }

    public function temp_perfil() {
        $perfil = $this->input->post("perfil");
        $this->session->set_userdata("tmp_perfil_usu", NULL);
        if ($perfil != NULL) {
            $this->session->set_userdata("tmp_perfil_usu", $perfil);
        } else {
            $this->session->set_userdata("tmp_perfil_usu", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function actualiza_empleados(){
        $perfil = $this->session->userdata("tmp_perfil_usu");
        if($perfil != ""){
            $mesero = $this->usuario_model->meseros($perfil);
            $data["mesero"] = $mesero;
            $data["base_url"] = base_url();
            $this->load->view("usu_empleado_perfil", $data);            
        }else{
            die;
        }

    }

}

?>