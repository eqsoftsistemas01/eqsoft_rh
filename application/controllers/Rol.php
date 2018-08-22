<?php

/*------------------------------------------------
  ARCHIVO: Rol.php
  DESCRIPCION: Contiene los métodos relacionados con la Rol.
  FECHA DE CREACIÓN: 27/07/2017
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');


class Rol extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth_library->sess_validate(true);
        $this->auth_library->mssg_get();
        $this->load->Model("Rol_model");
        $this->load->Model("Rubro_model");

        $this->load->library('Evalmath');       
    }

    /* MÉTODO PREDETERMINADO DEL CONTROLADOR */
    public function index() {
        $data["base_url"] = base_url();
        $data["content"] = "rol";
        $this->load->view("layout", $data);
    }

    public function listadoRoles() {
        $registro = $this->Rol_model->lst_roles();
        $tabla = "";
        foreach ($registro as $row) {
            $ver = '<div class=\"text-center\"><a href=\"#\" title=\"Editar\" id=\"'.$row->id.'\" class=\"btn btn-success btn-xs btn-grad rol_ver\"><i class=\"fa fa-pencil-square-o\"></i></a> <a href=\"#\" title=\"Eliminar\" id=\"'.$row->id.'\" class=\"btn btn-danger btn-xs btn-grad rol_del\"><i class=\"fa fa-trash-o\"></i></a></div>';
            $tabla.='{  "id":"' .$row->id. '",
                        "fechaini":"' .$row->fechaini_rol. '",
                        "fechafin":"' .$row->fechafin_rol. '",
                        "descripcion":"' .$row->descripcion_rol. '",
                        "estado":"' .$row->estado_rol. '",
                        "asistenciaini":"' .$row->asistencia_ini. '",
                        "asistenciafin":"' .$row->asistencia_fin. '",
                        "ver":"'.$ver.'"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function listadoEmpleado() {
        $idusu = $this->session->userdata("sess_id");
        $registro = $this->Rol_model->lst_empleados($idusu);
        $tabla = "";
        foreach ($registro as $row) {
            $tabla.='{  "id":"' .$row->id_empleado. '",
                        "apellido":"' .$row->apellidos. '",
                        "nombre":"' .$row->nombres. '",
                        "identificacion":"' .$row->nro_ident. '",
                        "valor":"' .$row->valor_neto. '"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function tmp_empleado() {
        $this->session->unset_userdata("tmp_emprol_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_emprol_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_emprol_id", $id);
        } else {
            $this->session->set_userdata("tmp_emprol_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function listadoRubro() {
        $idusu = $this->session->userdata("sess_id");
        $idemp = $this->session->userdata("tmp_emprol_id");
        if (($idemp == '') || ($idemp == '')) { $idemp =0; }
        $registro = $this->Rol_model->lst_rubros($idusu, $idemp);
        $this->calcula_valorrubros($idusu, $idemp, $registro);
        $registro = $this->Rol_model->lst_rubros($idusu, $idemp);
        $tabla = "";
        foreach ($registro as $row) {
            if ($row->modificable == 1) { 
              $valor = '<div ><input type=\"text\" class=\"valor_rubro\" name=\"'.$row->id_rubro.'\" id=\"'.$row->id_rubro.'\" value=\"'.$row->valor_neto.'\" ></div>';
            } 
            else {
              $valor = $row->valor_neto;
            }    
            $tabla.='{  "id":"' .$row->id_rubro. '",
                        "codigo":"' .$row->codigo_rubro. '",
                        "nombre":"' .$row->nombre_rubro. '",
                        "valor":"' .$valor. '"
                    },';
        }
        $tabla = substr($tabla, 0, strlen($tabla) - 1);
        echo '{"data":[' . $tabla . ']}';
    }

    public function add_rol(){
        $idusu = $this->session->userdata("sess_id");
        $obj = $this->Rol_model->carga_rol(0, $idusu);
        $data["obj"] = $obj;
        $empleados = $this->Rol_model->lst_empleados($idusu);
        $data["empleados"] = $empleados;       

        $data["base_url"] = base_url();
        $data["content"] = "rol_add";
        $this->load->view("layout", $data);
    } 

    function get_expresion_por_id($exp){
        $newexp = '';
        $idx = 0;
        while ($idx < strlen($exp)){
          if ($exp[$idx] != '[') {
            $newexp.= $exp[$idx];
            $idx++;
          } else {
            $newexp.= '[';
            $idx++;
            $codigo = '';
            while (($exp[$idx] != ']') && ($idx < strlen($exp))){
              $codigo.= $exp[$idx];
              $idx++;
            }  
            $idx++;
            $newval = '';
            $objrubro = $this->Rubro_model->sel_rubro_codigo($codigo);
            if ($objrubro){ 
              $newval = $objrubro->id;
            }  
            $newexp.= $newval . ']';
          }
        }
        return $newexp;
    }

    public function calcula_valorrubros($idusuario, $idempleado, $listarubros){
        $calculador = new Rubro_Calculador;
        foreach ($listarubros as $rubro) {
          $objrubro = new Rubro;
          $objrubro->id = $rubro->id_rubro;
          $objrubro->valor = $rubro->valor_neto;
          $objrubro->escalculado = ($rubro->editable == 0);
          $objrubro->expresion = $this->get_expresion_por_id($rubro->expresioncalculo);
          $objrubro->calculadorealizado = ($rubro->editable == 1);
          $calculador->arreglo[$rubro->id_rubro] = $objrubro;
        }
        $calculador->calcular();
        foreach ($calculador->arreglo as $rubro) {
          $this->Rol_model->actualiza_valorrubro($idusuario, $idempleado, $rubro->id, $rubro->valor);
        }  
    } 

    public function upd_valor_rubro(){
        $idusu = $this->session->userdata("sess_id");
        $idemp = $this->session->userdata("tmp_emprol_id");
        if (($idemp == '') || ($idemp == '')) { $idemp =0; }
        $id = $this->input->post("id");
        $valor = $this->input->post("valor");
        $this->Rol_model->actualiza_valorrubro($idusu, $idemp, $id, $valor);
        $arr['resu'] = 1;
        print json_encode($arr);
    } 

}

class Rubro {
  public $id;
  public $valor;
  public $escalculado;
  public $expresion;
  public $calculadorealizado;
}


class Rubro_Calculador {
  public $arreglo = array();

  public function calcular(){
    $m = new EvalMath;
    $m->suppress_errors = true;
    foreach ($this->arreglo as $rubro) {
      if ($rubro->escalculado == true){
        $this->calcula_rubro($rubro->id, $m);
      }
    }  
  }

  public function calcula_rubro($id, $m){
    $obj = $this->arreglo[$id];
    if ($obj){
      if (($obj->escalculado == false) || ($obj->calculadorealizado == true)){
        return $obj->valor;
      }
      else {
        $exp = $obj->expresion;
        $newexp = '';
        $idx = 0;
        while ($idx < strlen($exp)){
          if ($exp[$idx] != '[') {
            $newexp.= $exp[$idx];
            $idx++;
          } else {
            $idx++;
            $newid = '';
            while (($exp[$idx] != ']') && ($idx < strlen($exp))){
              $newid.= $exp[$idx];
              $idx++;
            }  
            $idx++;
            $newval = $this->calcula_rubro($newid, $m);
            $newexp.= $newval;
          }
        }
        $result = $m->evaluate($newexp);
        $obj->valor = $result;
        $obj->calculadorealizado = true;
        return $obj->valor;
      }
    } else {
      return 0;
    }

  }

}

?>