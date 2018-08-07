<?php

/*------------------------------------------------
  ARCHIVO: Empleado.php
  DESCRIPCION: Contiene los métodos relacionados Empleado.
  
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Empleado extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Empleado_model");
        $this->load->Model("usuario_model");
        $this->load->Model("Departamento_model");
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $data["base_url"] = base_url();
        $data["content"] = "empleado";
        $this->load->view("layout", $data);
    }

    public function tmp_empleado() {
        $this->session->unset_userdata("tmp_empleado_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_empleado_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_empleado_id", $id);
        } else {
            $this->session->set_userdata("tmp_empleado_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function listadoEmpleados() {
        $registro = $this->Empleado_model->lst_empleado();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id_empleado.'\" class=\"btn btn-success btn-xs btn-grad ret_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id_empleado.'\" class=\"btn btn-danger btn-xs btn-grad ret_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id_empleado. '",
                        "apellido":"' .$row->apellidos. '",
                        "nombre":"' .$row->nombres. '",
                        "identificacion":"' .$row->nro_ident. '",
                        "departamento":"' .$row->nombre_departamento. '",
                        "telefono":"' .$row->telf_empleado. '",
                        "correo":"' .$row->correo_empleado. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function upd_empleado(){
        $id = $this->session->userdata("tmp_empleado_id");
        $tipoident = $this->Empleado_model->lst_tipoidentificacion();
        $perfil = $this->usuario_model->perfil_lst();
        $departamento = $this->Departamento_model->sel_departamento();
        $data["departamento"] = $departamento;
        $data["perfil"] = $perfil;
        $data["tipoident"] = $tipoident;
        $data["base_url"] = base_url();
        $obj = $this->Empleado_model->sel_empleado_id($id);
        $data["obj"] = $obj;
        $parentesco = $this->Empleado_model->lst_parentesco();
        $data["parentesco"] = $parentesco;
        $estadocivil = $this->Empleado_model->lst_estadocivil();
        $data["estadocivil"] = $estadocivil;
        $tipovivienda = $this->Empleado_model->lst_tipovivienda();
        $data["tipovivienda"] = $tipovivienda;
        $tipocuentabanco = $this->Empleado_model->lst_tipocuentabanco();
        $data["tipocuenta"] = $tipocuentabanco;
        $banco = $this->Empleado_model->lst_banco();
        $data["banco"] = $banco;
        $sexo = $this->Empleado_model->lst_sexo();
        $data["sexo"] = $sexo;
        $data["content"] = "empleado_edit";
        $this->load->view("layout", $data);
//        $this->load->view("empleado_add", $data);
    }

    public function guardar(){
        $id = $this->input->post('txt_id'); 
        $apellido = $this->input->post('txt_apellido');
        $nombre = $this->input->post('txt_nombre');
        $tipoident = $this->input->post('cmb_tipoident');
        $identificacion = $this->input->post('txt_ident');
        $perfil = $this->input->post('cmb_perfil');
        $departamento = $this->input->post('cmb_departamento');
        $calleprincipal = $this->input->post('txt_calleprincipal');
        $numerovivienda = $this->input->post('txt_numerovivienda');
        $calletransversal = $this->input->post('txt_calletransversal');
        $sector = $this->input->post('txt_sector');
        $referenciavivienda = $this->input->post('txt_referenciavivienda');
        $telefono = $this->input->post('txt_telefono');
        $celular = $this->input->post('txt_celular');
        $correo = $this->input->post('txt_correo');
        $activo = $this->input->post('chkactivo');

        $banco = $this->input->post('cmb_banco');
        $tipocuenta = $this->input->post('cmb_tipocuenta');
        $numerocuenta = $this->input->post('txt_numerocuenta');
        $nombrecontacto = $this->input->post('txt_nombrecontacto');
        $direccioncontacto = $this->input->post('txt_direccioncontacto');
        $parentescocontacto = $this->input->post('cmb_parentesco');
        $telefonocontacto = $this->input->post('txt_telefonocontacto');

        $lugarexpedicion = $this->input->post('txt_lugarexpedicion');
        $cedulamilitar = $this->input->post('txt_cedulamilitar');
        $pasaporte = $this->input->post('txt_pasaporte');
        $sexo = $this->input->post('cmb_sexo');

        $fecha_nacimiento = '';
        $estadocivil = '';
        $peso = '0';
        $talla = '0';
        $codigoreloj = '';
        $ciudad = '';
        $tipovivienda = ''; 
        $vivefamiliares = '0';
        $empresa = '';
        $tiposangre = '';
        $tipodiscapacidad = ''; 
        $p100discapacidad = '0';
        $contrato = '';
        $cargo = '';

        if($activo == 'on'){ $activo = 1; } else { $activo = 0; }
        if($id != 0){
            $resu = $this->Empleado_model->upd_empleado($id, $nombre, $apellido, $tipoident, $identificacion, $perfil, $telefono, 
                                 $celular, $correo, $activo, $departamento, $lugarexpedicion, $cedulamilitar, $pasaporte, 
                                 $fecha_nacimiento, $sexo, $estadocivil, $peso, $talla, $codigoreloj, $calleprincipal, 
                                 $numerovivienda, $calletransversal, $sector, $referenciavivienda, $ciudad, $tipovivienda, 
                                 $vivefamiliares, $banco, $tipocuenta, $numerocuenta, $nombrecontacto, $direccioncontacto, 
                                 $parentescocontacto, $telefonocontacto, $empresa, $tiposangre, $tipodiscapacidad, 
                                 $p100discapacidad, $contrato, $cargo);
        } else {
            $resu = $this->Empleado_model->add_empleado($nombre, $apellido, $tipoident, $identificacion, $perfil, $telefono, 
                                 $celular, $correo, $activo, $departamento, $lugarexpedicion, $cedulamilitar, $pasaporte, 
                                 $fecha_nacimiento, $sexo, $estadocivil, $peso, $talla, $codigoreloj, $calleprincipal, 
                                 $numerovivienda, $calletransversal, $sector, $referenciavivienda, $ciudad, $tipovivienda, 
                                 $vivefamiliares, $banco, $tipocuenta, $numerocuenta, $nombrecontacto, $direccioncontacto, 
                                 $parentescocontacto, $telefonocontacto, $empresa, $tiposangre, $tipodiscapacidad, 
                                 $p100discapacidad, $contrato, $cargo);
        }
        print "<script> window.location.href = '" . base_url() . "empleado'; </script>";
    }

    public function add_empleado(){
        $tipoident = $this->Empleado_model->lst_tipoidentificacion();
        $perfil = $this->usuario_model->perfil_lst();
        $departamento = $this->Departamento_model->sel_departamento();
        $data["departamento"] = $departamento;
        $data["perfil"] = $perfil;
        $data["tipoident"] = $tipoident;
        $parentesco = $this->Empleado_model->lst_parentesco();
        $data["parentesco"] = $parentesco;
        $estadocivil = $this->Empleado_model->lst_estadocivil();
        $data["estadocivil"] = $estadocivil;
        $tipovivienda = $this->Empleado_model->lst_tipovivienda();
        $data["tipovivienda"] = $tipovivienda;
        $tipocuentabanco = $this->Empleado_model->lst_tipocuentabanco();
        $data["tipocuentabanco"] = $tipocuentabanco;
        $banco = $this->Empleado_model->lst_banco();
        $data["banco"] = $banco;
        $sexo = $this->Empleado_model->lst_sexo();
        $data["sexo"] = $sexo;

        $data["base_url"] = base_url();
        $data["content"] = "empleado_edit";
        $this->load->view("layout", $data);
//        $this->load->view("empleado_add", $data);
    } 

    public function del_empleado(){
        $id = $this->input->post('id'); 
        $resu = $this->Empleado_model->del_empleado($id);
        $arr['mens'] = $id;
        print json_encode($arr); 
    }

     /* Verificar Identificador  */
    public function existeIdentificacion(){
        $id = $this->input->post('id');
        $identificacion = $this->input->post('identificacion');
        $resu = $this->Empleado_model->existeIdentificacion($id, $identificacion);
        $arr['resu'] = $resu;
        print json_encode($arr);

    }

}

?>