<?php

/*------------------------------------------------
  ARCHIVO: asistencia.php
  DESCRIPCION: Contiene los métodos relacionados asistencia.
  
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Asistenciat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Asistenciat_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    

    public function listadoAsistenciat() {
        
        $empleado = 1;
       
        //alert ($empleado);
        $data["datos"]=$this->Asistenciat_model->lst_asistenciat($empleado);
        $this->load->view('asistenciat',$data);


    }

   

}

?>