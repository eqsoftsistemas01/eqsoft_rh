<?php

/*------------------------------------------------
  ARCHIVO: Rol.php
  DESCRIPCION: Contiene los métodos relacionados con la Rol.
  FECHA DE CREACIÓN: 27/07/2017
  ------------------------------------------------ */

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/fpdf.php');

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

    public function tmp_rol() {
        $this->session->unset_userdata("tmp_rol_id"); 
        $id = $this->input->post("id");
        $this->session->set_userdata("tmp_rol_id", NULL);
        if ($id != NULL) {
            $this->session->set_userdata("tmp_rol_id", $id);
        } else {
            $this->session->set_userdata("tmp_rol_id", NULL);
        }
        $arr['resu'] = 1;
        print json_encode($arr);
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
        $tabla = "";
        $idusu = $this->session->userdata("sess_id");
        $idemp = $this->session->userdata("tmp_emprol_id");
        if (($idemp == '') || ($idemp == '')) { $idemp =0; }
        else {
          $registro = $this->Rol_model->lst_rubros_calculo($idusu, $idemp);
          $this->calcula_valorrubros($idusu, $idemp, $registro);
          $registro = $this->Rol_model->lst_rubros($idusu, $idemp);
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
        }
        echo '{"data":[' . $tabla . ']}';
    }

    public function add_rol(){
        $this->session->unset_userdata("tmp_emprol_id"); 
        $idusu = $this->session->userdata("sess_id");
        $obj = $this->Rol_model->carga_rol(0, $idusu);
        $data["obj"] = $obj;
        $data["idrol"] = 0;
        $empleados = $this->Rol_model->lst_empleados($idusu);

        foreach ($empleados as $emp) {
          $registro = $this->Rol_model->lst_rubros_calculo($idusu, $emp->id_empleado);
          $this->calcula_valorrubros($idusu, $emp->id_empleado, $registro);          
        }

        $empleados = $this->Rol_model->lst_empleados($idusu);
        $data["empleados"] = $empleados;       

        $data["base_url"] = base_url();
        $data["content"] = "rol_add";
        $this->load->view("layout", $data);
    } 

    public function upd_rol(){
        $this->session->unset_userdata("tmp_emprol_id"); 
        $idusu = $this->session->userdata("sess_id");
        $id = $this->session->userdata("tmp_rol_id");
        $data["idrol"] = $id;
        $obj = $this->Rol_model->carga_rol($id, $idusu);
        $data["obj"] = $obj;
        $empleados = $this->Rol_model->lst_empleados($idusu);

        foreach ($empleados as $emp) {
          $registro = $this->Rol_model->lst_rubros_calculo($idusu, $emp->id_empleado);
          $this->calcula_valorrubros($idusu, $emp->id_empleado, $registro);          
        }

        $empleados = $this->Rol_model->lst_empleados($idusu);
        $data["empleados"] = $empleados;       

        $data["base_url"] = base_url();
        $data["content"] = "rol_add";
        $this->load->view("layout", $data);
    } 

    public function del_rol() {
        $id = $this->input->post("id");
        if ($id == '') { $id = 0; }
        $valor = $this->Rol_model->del_rol($id);
        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function sel_rubroneto_tmp() {
        $idusu = $this->session->userdata("sess_id");
        $idemp = $this->session->userdata("tmp_emprol_id");
        if ($idemp == '') { $idemp = 0; }
        $valor = $this->Rol_model->sel_rubroneto_tmp($idusu, $idemp);
        $arr['valor'] = $valor;
        $arr['idemp'] = $idemp;
        print json_encode($arr);
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
       /* var_dump($calculador->arreglo);die();*/

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

    public function upd_tmprol(){
        $idusu = $this->session->userdata("sess_id");

        $fec = $this->input->post('fechainirol');
        $fechainirol = str_replace('/', '-', $fec); 
        $fechainirol = date("Y-m-d", strtotime($fechainirol));

        $fec = $this->input->post('fechafinrol');
        $fechafinrol = str_replace('/', '-', $fec); 
        $fechafinrol = date("Y-m-d", strtotime($fechafinrol));

        $fec = $this->input->post('feciniasist');
        $feciniasist = str_replace('/', '-', $fec); 
        $feciniasist = date("Y-m-d", strtotime($feciniasist));

        $fec = $this->input->post('fecfinasist');
        $fecfinasist = str_replace('/', '-', $fec); 
        $fecfinasist = date("Y-m-d", strtotime($fecfinasist));

        $descripcion = $this->input->post('txt_descripcion');

        $this->Rol_model->upd_tmprol($idusu, $fechainirol, $fechafinrol, $feciniasist, $fecfinasist, $descripcion);

        $arr['resu'] = 1;
        print json_encode($arr);
    }

    public function guardar(){
        $idusu = $this->session->userdata("sess_id");
        $id = $this->input->post('txt_id'); 

        if($id != 0){
            $resu = $this->Rol_model->upd_rol($idusu, $id);
        } else {
            $resu = $this->Rol_model->add_rol($idusu);
        }
        print "<script> window.location.href = '" . base_url() . "rol'; </script>";
    }

    public function print_tmprol(){
        $idemp = $this->session->userdata("tmp_emprol_id");
        $idusu = $this->session->userdata("sess_id");
        if (($idemp == '') || ($idemp == '')) { $idemp =0; }

        $emp = $this->Rol_model->lst_tmprolemp_encab($idusu, $idemp);
        $lstrubros = $this->Rol_model->lst_tmprolemp_rubros($idusu, $idemp);

        $neto = $this->Rol_model->sel_rubroneto_tmp($idusu, $idemp);

        $fechahoy = date('Y-m-d');

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);

        $pdf->SetXY(1,1);
        $pdf->Cell(20,10,'EMPRESA ');

        $pdf->SetXY(70,1);
        $pdf->Cell(20,10,'PLANILLA INDIVIDUAL AL ' . $emp->fechafin_rol);

        $pdf->SetXY(170,1);
        $pdf->Cell(20,10,'Fecha: ' . $fechahoy);

        $pdf->SetXY(70,6);
        $pdf->Cell(20,10,$emp->apellidos . ' ' . $emp->nombres );

        $pdf->SetXY(70,11);
        $pdf->Cell(20,10,$emp->nombre_cargo);

        $pdf->SetXY(1,16);
        $pdf->Cell(20,10,'DIAS TRABAJADOS: ' . number_format($emp->diastrab,0));

        $pdf->SetXY(1,26);
        $pdf->Cell(20,10,'INGRESOS: ');
        $tmp_ying = 26;
        $total_ing = 0;
        foreach ($lstrubros as $rubro) {
          if ($rubro->tipo_rubro == 1){
            $tmp_ying += 5;
            $total_ing += $rubro->valor_neto;

            $pdf->SetXY(1,$tmp_ying);
            $pdf->Cell(20,10,$rubro->nombre_rubro);

            $pdf->SetXY(70,$tmp_ying);
            $pdf->Cell(20,10,$rubro->valor_neto);
          }
        }

        $pdf->SetXY(100,26);
        $pdf->Cell(20,10,'DESCUENTOS: ');
        $tmp_yegre = 26;
        $total_egre = 0;
        foreach ($lstrubros as $rubro) {
          if ($rubro->tipo_rubro == 2){
            $tmp_yegre += 5;
            $total_egre += $rubro->valor_neto;

            $pdf->SetXY(100,$tmp_yegre);
            $pdf->Cell(20,10,$rubro->nombre_rubro);

            $pdf->SetXY(170,$tmp_yegre);
            $pdf->Cell(20,10,$rubro->valor_neto);
          }
        }

        $tmp_y = $tmp_ying;
        if ($tmp_ying < $tmp_yegre) {
          $tmp_y = $tmp_yegre;
        }
        $tmp_y += 5;
        $pdf->SetXY(1,$tmp_y);
        $pdf->Cell(20,10,'TOTAL INGRESOS: ');
        $pdf->SetXY(70,$tmp_y);
        $pdf->Cell(20,10,number_format($total_ing,2));

        $pdf->SetXY(100,$tmp_y);
        $pdf->Cell(20,10,'TOTAL DESCUENTOS: ');
        $pdf->SetXY(170,$tmp_y);
        $pdf->Cell(20,10,number_format($total_egre,2));

        $tmp_y += 15;
        $pdf->SetXY(70,$tmp_y);
        $pdf->Cell(20,10,'Neto a Recibir: ' . number_format($neto,2));

        $pdf->Output('PLANILLA INDIVIDUAL DE PAGO','I');

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
   /* $keys=array_keys($this->arreglo);
    if (array_search($id, $keys) == false){
      return 0;
    }*/
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