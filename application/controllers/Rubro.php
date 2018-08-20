<?php

/*------------------------------------------------
  ARCHIVO: Rubro.php
  DESCRIPCION: Contiene los métodos relacionados rubro.
  
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class rubro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Rubro_model");
        //$this->load->Model("usuario_model");
        //$this->load->Model("Departamento_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $data["base_url"] = base_url();
        $data["content"] = "rubro";
        $this->load->view("layout", $data);
    }

    public function tmp_rubro() {
        $this->session->unset_userdata("tmp_rubro_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_rubro_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_rubro_id", $id);
        } else {
            $this->session->set_userdata("tmp_rubro_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    function carga_rubrotmp($idrubro) {
        $idusu = $this->session->userdata("sess_id");
        $id = $this->Rubro_model->get_rubrotmp($idusu, $idrubro);
        $this->session->unset_userdata("tmp_rubro_idtmp"); 
        $this->session->set_userdata("tmp_rubro_idtmp", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_rubro_idtmp", $id);
        } else {
            $this->session->set_userdata("tmp_rubro_idtmp", NULL);
        }
    }

    public function listadoRubros() {
        $registro = $this->Rubro_model->lst_rubro();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad rubro_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad rubro_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "nombre":"' .$row->nombre_rubro. '",
                        "codigo":"' .$row->codigo_rubro. '",
                        "tiporubro":"' .$row->tiporubro. '",
                        "periodicidad":"' .$row->periodicidadmensual. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function upd_rubro(){
        $id = $this->session->userdata("tmp_rubro_id");
        $obj = $this->Rubro_model->sel_rubro_id($id);
        $data["obj"] = $obj;

        $tiporubro = $this->Rubro_model->lst_tiporubro();
        $data["tiporubro"] = $tiporubro;
        $periodo = $this->Rubro_model->lst_periodo();
        $data["periodo"] = $periodo;
        $mesactivo = $this->Rubro_model->lst_mesactivo();
        $data["mesactivo"] = $mesactivo;

        $data["base_url"] = base_url();
        $this->load->view("rubro_add", $data);

    }

    public function guardar(){
        $id = $this->input->post("txt_id");
        $codigo_rubro=$this->input->post('codigo_rubro');
/*        echo $codigo_rubro;*/
        $nombre_rubro=$this->input->post('nombre_rubro');
        $rubro_activo =$this->input->post('chkactivo');
        $tipo_rubro =$this->input->post('cmb_tiporubro');

        if ($rubro_activo == 'on') {
            $rubro_activo = '1';
        }else
        {
            $rubro_activo = '0';
        }

        $periodo =$this->input->post('cmb_periodo');
/*        echo "Periodo: ".$periodo;
        echo '<br>';*/

        $mesactivo =$this->input->post('cmb_mesactivo');
        if ($mesactivo == null ) {
            $mesactivo = 0;
        }
        /*echo  "Mes activo: ".$mesactivo;
        echo '<br>';*/
        $diastrabajados =$this->input->post('chkdias');
        if ($diastrabajados == 'on') {
            $diastrabajados = '1';
        }else
        {
            $diastrabajados = '0';
        }
        /*echo "Dias trabajados: ". $diastrabajados;
        echo '<br>';*/
        $diasgracia =$this->input->post('txt_diasgracia');
        if ($diasgracia == '') { $diasgracia = 0; }
        /*echo $diasgracia;
        echo '<br>';*/
        $calculado =$this->input->post('chkcalculo');
        if ($calculado == 'on') {
            $calculado = '1';
        }else
        {
            $calculado = '0';
        }
        /*echo $calculado;
        echo '<br>';*/
        $expresion =$this->input->post('txt_expresion');
        /*echo $expresion;
        echo '<br>';*/


        if($id != 0){
            $resu = $this->Rubro_model->upd_rubro($id, $codigo_rubro, $nombre_rubro, $rubro_activo,$tipo_rubro, $periodo, $mesactivo, $diastrabajados, $diasgracia, $calculado, $expresion);
        } else {
            $resu = $this->Rubro_model->add_rubro($codigo_rubro, $nombre_rubro, $rubro_activo, $tipo_rubro, $periodo, $mesactivo, $diastrabajados, $diasgracia, $calculado, $expresion);
        }
        print "<script> window.location.href = '" . base_url() . "rubro'; </script>";
    }

    public function add_rubro(){
        $tiporubro = $this->Rubro_model->lst_tiporubro();
        $data["tiporubro"] = $tiporubro;
        $periodo = $this->Rubro_model->lst_periodo();
        $data["periodo"] = $periodo;
        $mesactivo = $this->Rubro_model->lst_mesactivo();
        $data["mesactivo"] = $mesactivo;

        $data["base_url"] = base_url();
        $this->load->view("rubro_add", $data);
    } 

    public function del_rubro(){
        $id = $this->input->post('id'); 
        $resu = $this->Rubro_model->del_rubro($id);
        $arr['mens'] = $id;
        print json_encode($arr); 
    }


}

?>