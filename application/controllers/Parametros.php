<?php

/*------------------------------------------------
  ARCHIVO: Empresa.php
  DESCRIPCION: Contiene los métodos relacionados con la Empresa.
  FECHA DE CREACIÓN: 05/07/2017
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Parametros extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Parametros_model");
        $this->load->Model("Rubro_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $data["base_url"] = base_url();

      /*  $iva = $this->Parametros_model->iva_get();
        $data["iva"] = $iva * 100;*/

        $lstrubro = $this->Rubro_model->lst_rubro();
        $data["lstrubro"] = $lstrubro;

        $sueldo = $this->Parametros_model->rubro_sueldo_get();
        $data["rubro_sueldo"] = $sueldo;

        $diastrab = $this->Parametros_model->rubro_diastrab_get();
        $data["rubro_diastrab"] = $diastrab;

        $netocobrar = $this->Parametros_model->rubro_netocobrar_get();
        $data["rubro_netocobrar"] = $netocobrar;

        $cfg = $this->Parametros_model->configuraciongeneral_get();        
        $data["cfg"] = $cfg;

        $data["content"] = "parametros";
        $this->load->view("layout", $data);
    }

    /* ACTUALIZAR LOS REGISTROS DE Parametros */
    public function guardar(){

/*        $iva = $this->input->post('txt_iva');
        $iva = number_format( $iva / 100, 2);*/

        $sueldo = $this->input->post('txt_sueldo');
        $diastrab = $this->input->post('txt_diastrab');
        $netocobrar = $this->input->post('txt_netocobrar');

        /* SE ACTUALIZA EL REGISTRO DEL USUARIO */
       /* $resu = $this->Parametros_model->iva_upd($iva);*/
        $resu = $this->Parametros_model->rubro_sueldo_upd($sueldo);
        $resu = $this->Parametros_model->rubro_diastrab_upd($diastrab);
        $resu = $this->Parametros_model->rubro_netocobrar_upd($netocobrar);

        /* Configuracion General */
        $razonsocial = $this->input->post('txt_razonsocial');
        $nombrecomercial = $this->input->post('txt_nombrecomercial');
        $identificacion = $this->input->post('txt_identificacion');

        $foto = $this->input->post('foto');
        if (isset($_FILES["foto"])) {
            $foto_name= $_FILES["foto"]["name"];
        }
        else{
            $foto_name = "";
        }
        /* ESTE CONDICIONAL NOS PERMITE GUARDAR O MODIFICAR USUARIOS SIN QUE LE ASIGNEN FOTO */
        if ($foto_name == NULL || $foto_name == ""){
            $fot = $this->input->post('rutaimagen');
        } else { 
            $foto_name= $_FILES["foto"]["name"];
            $foto_size= $_FILES["foto"]["size"];
            $foto_type= $_FILES["foto"]["type"];
            $foto_temporal= $_FILES["foto"]["tmp_name"];

            # Limitamos los formatos de imagen admitidos a: png, jpg y gif
            if ($foto_type=="image/x-png" OR $foto_type=="image/png") { $extension="image/png"; }
            if ($foto_type=="image/pjpeg" OR $foto_type=="image/jpeg"){ $extension="image/jpeg";}
            if ($foto_type=="image/gif" OR $foto_type=="image/gif")   { $extension="image/gif"; }

            $fot=time().$foto_name;
            $ndir = FCPATH."doc\\".$fot;

            move_uploaded_file($_FILES['foto']['tmp_name'], $ndir);
        }
        $this->Parametros_model->configuraciongeneral_upd($razonsocial, $nombrecomercial, $identificacion, $fot);


        $data["base_url"] = base_url();
        $data["content"] = "inicio";
        $this->load->view("layout", $data);

    }

}

?>