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


        $data["base_url"] = base_url();
        $data["content"] = "inicio";
        $this->load->view("layout", $data);

    }

}

?>