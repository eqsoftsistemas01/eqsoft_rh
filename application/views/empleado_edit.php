<?php
/* ------------------------------------------------
  ARCHIVO: parametros.php
  DESCRIPCION: Contiene la vista principal del módulo de parametros.
  FECHA DE CREACIÓN: 05/07/2017
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
print "<script>document.title = 'EQsoft - Datos de Empleado'</script>";
date_default_timezone_set("America/Guayaquil");
?>

<style type="text/css">
  
.linea{
  border-width: 2px 0 0;
  margin-bottom: 3px;
  margin-top: 5px;
  border-color: currentcolor currentcolor;
} 


</style>

<script>


  $( document ).ready(function() {

    $("#frm_emp").validationEngine();


  });

</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <i class="fa fa-fort-awesome"></i> Datos de Empleado </a></li>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>empleado">Empleados</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

        <div class="box-header with-border">

          <form id="frm_emp" name="frm_emp" method="post" role="form" class="form" action="<?php echo base_url('Empleado/guardar');?>">
              <div class="box-body">

                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                   <li class="active"><a href="#tabpersonal" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> DATOS PERSONALES</a></li>                            
                   <li ><a href="#tabgeneral" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> DATOS GENERALES</a></li>                            
                   <li ><a href="#tabadicional" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> VALORES ADICIONALES</a></li>                            
                   <li ><a href="#tabcargafamiliar" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> CARGAS FAMILIARES</a></li>                            
                  </ul>

                  <div class="tab-content">
                    <div class="tab-pane active" id="tabpersonal">
                    
                      <div class="box box-danger">
                      
                      <div class="box-header with-border">

                        <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                            if(@$obj != NULL){ ?>
                                <input type="hidden" id="txt_id" name="txt_id" value="<?php if($obj != NULL){ print $obj->id_empleado; }?>" >    
                            <?php } else { ?>
                                <input type="hidden" id="txt_id" name="txt_id" value="0">    
                        <?php } ?>  

                        <div class="col-md-12">

                        <div class="form-group col-md-4">
                            <label for="lb_cat">Apellidos</label>
                            <input type="text" class="form-control validate[required]" name="txt_apellido" id="txt_apellido" placeholder="Apellidos" value="<?php if(@$obj != NULL){ print @$obj->apellidos; }?>" >
                        </div>

                        <div class="form-group col-md-4">
                            <label for="lb_cat">Nombres</label>
                            <input type="text" class="form-control validate[required]" name="txt_nombre" id="txt_nombre" placeholder="Nombres" value="<?php if(@$obj != NULL){ print @$obj->nombres; }?>" >
                        </div>

                        <div style="" class="form-group col-md-2">
                          <label for="lb_res">Perfil de Usuario</label>
                          <select class="form-control validate[required]" id="cmb_perfil" name="cmb_perfil">
                              <?php 
                                if(@$perfil != NULL){ ?>
                                  <option  value="0" selected="TRUE">Seleccione...</option>
                              <?php }  
                                        if (count($perfil) > 0) {
                                          foreach ($perfil as $pe):
                                              if(@$obj->perfil != NULL){
                                                  if($pe->id_perfil == $obj->perfil){ ?>
                                                      <option  value="<?php  print $pe->id_perfil; ?>" selected="TRUE"><?php print $pe->nom_perfil ?></option> 
                                                      <?php
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id_perfil; ?>"> <?php  print $pe->nom_perfil ?> </option>
                                                      <?php
                                                  }
                                              }else{ ?>
                                                  <option value="<?php  print $pe->id_perfil; ?>"> <?php  print $pe->nom_perfil ?> </option>
                                                  <?php
                                                  }   ?>
                                              <?php

                                          endforeach;
                                        }
                                        ?>
                          </select>
                        </div>

                        <div class="form-group col-md-2 text-center">
                            <input id="chkactivo" name="chkactivo" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->activo == 1){ print " checked";} } else {print " checked";} ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Activo</strong>
                        </div>

                        </div>

                        <div class="form-group col-md-2">
                          <label for="lb_res">Sexo</label>
                          <select id="cmb_sexo" name="cmb_sexo" class="form-control">
                          <?php 
                            if(@$sexo != NULL){ ?>
                            <?php } else { ?>
                            <option  value="" selected="TRUE">Seleccione Sexo...</option>
                            <?php } 
                              if (count($sexo) > 0) {
                                foreach ($sexo as $tipo):
                                    if(@$obj->sexo != NULL){
                                        if($obj->sexo == $tipo->id){ ?>
                                             <option value="<?php  print $tipo->id; ?>" selected="TRUE"> <?php  print $tipo->sexo; ?> </option>
                                            <?php
                                        }else{ ?>
                                            <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->sexo; ?> </option>
                                            <?php
                                        }
                                    }else{ ?>
                                        <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->sexo; ?> </option>
                                        <?php
                                        }   ?>
                                    <?php
                                endforeach;
                              }
                            ?>
                          </select>                                  
                        </div>

                        <div style="" class="form-group col-md-2">
                          <label for="lb_res">Tipo Identificacion</label>
                          <select id="cmb_tipoident" name="cmb_tipoident" class="form-control">
                          <?php 
                            if(@$tipoident != NULL){ ?>
                            <?php } else { ?>
                            <option  value="" selected="TRUE">Seleccione Tipo Identificacion...</option>
                            <?php } 
                              if (count($tipoident) > 0) {
                                foreach ($tipoident as $tipo):
                                    if(@$obj->tipo_identificacion != NULL){
                                        if($obj->tipo_identificacion == $tipo->id_identificacion){ ?>
                                             <option name="<?php  print $tipo->cod_identificacion; ?>" value="<?php  print $tipo->id_identificacion; ?>" selected="TRUE"> <?php  print $tipo->desc_identificacion; ?> </option>
                                            <?php
                                        }else{ ?>
                                            <option name="<?php  print $tipo->cod_identificacion; ?>" value="<?php  print $tipo->id_identificacion; ?>" > <?php  print $tipo->desc_identificacion; ?> </option>
                                            <?php
                                        }
                                    }else{ ?>
                                        <option name="<?php  print $tipo->cod_identificacion; ?>" value="<?php  print $tipo->id_identificacion; ?>" > <?php  print $tipo->desc_identificacion; ?> </option>
                                        <?php
                                        }   ?>
                                    <?php
                                endforeach;
                              }
                            ?>
                          </select>                                  
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Identificacion</label>
                            <input type="text" class="form-control validate[required]" name="txt_ident" id="txt_ident" placeholder="Identificacion" value="<?php if(@$obj != NULL){ print @$obj->nro_ident; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Lugar Expedicion</label>
                            <input type="text" class="form-control" name="txt_lugarexpedicion" id="txt_lugarexpedicion" placeholder="Lugar Expedicion" value="<?php if(@$obj != NULL){ print @$obj->lugarexpedicion; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Pasaporte</label>
                            <input type="text" class="form-control" name="txt_pasaporte" id="txt_pasaporte" placeholder="Pasaporte" value="<?php if(@$obj != NULL){ print @$obj->pasaporte; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Cedula Militar</label>
                            <input type="text" class="form-control" name="txt_cedulamilitar" id="txt_cedulamilitar" placeholder="Cedula Militar" value="<?php if(@$obj != NULL){ print @$obj->cedulamilitar; }?>" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="lb_cat">Calle Principal</label>
                            <input type="text" class="form-control " name="txt_calleprincipal" id="txt_calleprincipal" placeholder="Calle Principal" value="<?php if(@$obj != NULL){ print @$obj->calleprincipal; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Numero Vivienda</label>
                            <input type="text" class="form-control " name="txt_numerovivienda" id="txt_numerovivienda" placeholder="Numero Vivienda" value="<?php if(@$obj != NULL){ print @$obj->numerovivienda; }?>" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="lb_cat">Calle Transversal</label>
                            <input type="text" class="form-control " name="txt_calletransversal" id="txt_calletransversal" placeholder="Calle Transversal" value="<?php if(@$obj != NULL){ print @$obj->calletransversal; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Sector</label>
                            <input type="text" class="form-control " name="txt_sector" id="txt_sector" placeholder="Sector" value="<?php if(@$obj != NULL){ print @$obj->sector; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Referencia</label>
                            <input type="text" class="form-control " name="txt_referenciavivienda" id="txt_referenciavivienda" placeholder="Referencia" value="<?php if(@$obj != NULL){ print @$obj->referenciavivienda; }?>" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="lb_cat">Telefono</label>
                            <input type="text" class="form-control " name="txt_telefono" id="txt_telefono" placeholder="Telefono" value="<?php if(@$obj != NULL){ print @$obj->telf_empleado; }?>" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="lb_cat">Celular</label>
                            <input type="text" class="form-control " name="txt_celular" id="txt_celular" placeholder="Celular" value="<?php if(@$obj != NULL){ print @$obj->celular_empleado; }?>" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="lb_cat">Correo</label>
                            <input type="text" class="form-control " name="txt_correo" id="txt_correo" placeholder="Correo" value="<?php if(@$obj != NULL){ print @$obj->correo_empleado; }?>" >
                        </div>


                        <div style="" class="form-group col-md-3">
                          <label for="lb_res">Departamento</label>
                          <select class="form-control" id="cmb_departamento" name="cmb_departamento">
                              <?php 
                                if(@$departamento != NULL){ ?>
                                  <option  value="0" selected="TRUE">Seleccione...</option>
                              <?php }  
                                        if (count($departamento) > 0) {
                                          foreach ($departamento as $pe):
                                              if(@$obj->id_departamento != NULL){
                                                  if($pe->id == $obj->id_departamento){ ?>
                                                      <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->nombre_departamento ?></option> 
                                                      <?php
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_departamento ?> </option>
                                                      <?php
                                                  }
                                              }else{ ?>
                                                  <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_departamento ?> </option>
                                                  <?php
                                                  }   ?>
                                              <?php

                                          endforeach;
                                        }
                                        ?>
                          </select>
                        </div>

                      </div>
                      
                      </div>


                    </div>  <!-- Tab Personal --> 

                    <div class="tab-pane" id="tabgeneral">

                      <div class="box box-danger">
                      
                        <div class="box-header with-border">

                          <spam>
                            <strong>Datos de Contacto</strong>  
                          </spam>
                          <hr class="linea">

                          <div class="form-group col-md-4">
                              <label for="lb_cat">Nombres y Apellidos</label>
                              <input type="text" class="form-control " name="txt_nombrecontacto" id="txt_nombrecontacto" placeholder="Nombres y Apellidos" value="<?php if(@$obj != NULL){ print @$obj->nombrecontacto; }?>" >
                          </div>

                          <div style="" class="form-group col-md-2">
                            <label for="lb_res">Parentesco</label>
                            <select class="form-control" id="cmb_parentesco" name="cmb_parentesco">
                                <?php 
                                  if(@$parentesco != NULL){ ?>
                                    <option  value="0" selected="TRUE">Seleccione...</option>
                                <?php }  
                                          if (count($parentesco) > 0) {
                                            foreach ($parentesco as $pe):
                                                if(@$obj->id_parentescocontacto != NULL){
                                                    if($pe->id == $obj->id_parentescocontacto){ ?>
                                                        <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->parentesco ?></option> 
                                                        <?php
                                                    }else{ ?>
                                                        <option value="<?php  print $pe->id; ?>"> <?php  print $pe->parentesco ?> </option>
                                                        <?php
                                                    }
                                                }else{ ?>
                                                    <option value="<?php  print $pe->id; ?>"> <?php  print $pe->parentesco ?> </option>
                                                    <?php
                                                    }   ?>
                                                <?php

                                            endforeach;
                                          }
                                          ?>
                            </select>
                          </div>

                          <div class="form-group col-md-4">
                              <label for="lb_cat">Direccion</label>
                              <input type="text" class="form-control " name="txt_direccioncontacto" id="txt_direccioncontacto" placeholder="Direccion" value="<?php if(@$obj != NULL){ print @$obj->direccioncontacto; }?>" >
                          </div>

                          <div class="form-group col-md-2">
                              <label for="lb_cat">Telefonos</label>
                              <input type="text" class="form-control " name="txt_telefonocontacto" id="txt_telefonocontacto" placeholder="Telefonos" value="<?php if(@$obj != NULL){ print @$obj->telefonocontacto; }?>" >
                          </div>

                          <spam>
                            <strong>Datos Bancarios</strong>  
                          </spam>
                          <hr class="linea">

                          <div style="" class="form-group col-md-4">
                            <label for="lb_res">Banco</label>
                            <select class="form-control" id="cmb_banco" name="cmb_banco">
                                <?php 
                                  if(@$banco != NULL){ ?>
                                    <option  value="0" selected="TRUE">Seleccione...</option>
                                <?php }  
                                          if (count($banco) > 0) {
                                            foreach ($banco as $pe):
                                                if(@$obj->id_banco != NULL){
                                                    if($pe->id == $obj->id_banco){ ?>
                                                        <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->banco ?></option> 
                                                        <?php
                                                    }else{ ?>
                                                        <option value="<?php  print $pe->id; ?>"> <?php  print $pe->banco ?> </option>
                                                        <?php
                                                    }
                                                }else{ ?>
                                                    <option value="<?php  print $pe->id; ?>"> <?php  print $pe->banco ?> </option>
                                                    <?php
                                                    }   ?>
                                                <?php

                                            endforeach;
                                          }
                                          ?>
                            </select>
                          </div>

                          <div style="" class="form-group col-md-4">
                            <label for="lb_res">Tipo Cuenta</label>
                            <select class="form-control" id="cmb_tipocuenta" name="cmb_tipocuenta">
                                <?php 
                                  if(@$tipocuenta != NULL){ ?>
                                    <option  value="0" selected="TRUE">Seleccione...</option>
                                <?php }  
                                          if (count($tipocuenta) > 0) {
                                            foreach ($tipocuenta as $pe):
                                                if(@$obj->id_tipocuenta != NULL){
                                                    if($pe->id == $obj->id_tipocuenta){ ?>
                                                        <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->tipocuentabanco ?></option> 
                                                        <?php
                                                    }else{ ?>
                                                        <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipocuentabanco ?> </option>
                                                        <?php
                                                    }
                                                }else{ ?>
                                                    <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipocuentabanco ?> </option>
                                                    <?php
                                                    }   ?>
                                                <?php

                                            endforeach;
                                          }
                                          ?>
                            </select>
                          </div>

                          <div class="form-group col-md-4">
                              <label for="lb_cat">Numero Cuenta</label>
                              <input type="text" class="form-control " name="txt_numerocuenta" id="txt_numerocuenta" placeholder="Numero Cuenta" value="<?php if(@$obj != NULL){ print @$obj->numerocuenta; }?>" >
                          </div>

                        </div>  

                      </div>  

                    </div>  <!-- Tab General --> 

                    <div class="tab-pane" id="tabadicional">
                    </div>  <!-- tabadicional --> 

                    <div class="tab-pane" id="tabcargafamiliar">
                    </div>  <!-- tabcargafamiliar --> 


                  </div>  <!-- Nav Tab Control --> 
                </div>
              </div>

              <div  align="center" class="box-footer">
                  <div class="form-actions ">
                      <button type="submit" class="btn btn-success btn-grad btn-lg no-margin-bottom">
                          <i class="fa fa-save "></i> Guardar
                      </button>
                  </div>
              </div>
          </form> 

        </div>
      </div>
    </section>      
</div>
