<?php
/* ------------------------------------------------
  ARCHIVO: usuarios.php
  DESCRIPCION: Contiene la vista principal del módulo de usuarios.
  FECHA DE CREACIÓN: 30/06/2017
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
print "<script>document.title = 'ProdegelRRHH - Usuarios'</script>";
date_default_timezone_set("America/Guayaquil");
/*
if(@$fic_usu->perfil != NULL){
    $mese = $fic_usu->perfil;
}else{
    $mese = 0;
}  

  $parametro = &get_instance();
  $parametro->load->model("Parametros_model");
  $nombreperfilvendedor = $parametro->Parametros_model->sel_nombreperfilvendedor();
*/

?>
<script>
$( document ).ready(function() {
    $("#frm_add").validationEngine();
    

    // Confirmacion para guardar un registro
    function conf_guar() {
        return  confirm("¿Confirma que desea guardar este registro?");
    }

/*
    $(document).on('change','#cmb_perfil', function(){
        perfil = $(this).val();
        $.ajax({
          type: "POST",
          dataType: "json",
          url: base_url + "Usuarios/temp_perfil",
          data: {perfil: perfil},
          success: function(json) {
              $('#empleado_perfil').load(base_url + "Usuarios/actualiza_empleados");
          }
        });
        return false;   
    });
*/
});

</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Usuarios
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>usuarios">Usuarios</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- SECCION DEL FORMULARIO-->
            <form id="frm_add" name="frm_add" method="post" role="form" class="form" enctype="multipart/form-data" action="<?php echo base_url('usuarios/guardar');?>">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title"><i class="fa fa-user"></i> Datos del Usuario</h3>
                    </div>
                    <div class="box-body">

                      <div class="row">
                        <div class="col-xs-3 text-center">
                            <h3 class="profile-username text-center">Foto del Usuario</h3>
                            <p class="text-muted text-center">Identificación</p>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-preview thumbnail"  id="fotomostrar">
                                    <img <?php
                                        if (@$fic_usu != NULL) {
                                            if ($fic_usu->fot_usu) {
                                                
                                                print "width='150' height='150' src='data:image/jpeg;base64,$fic_usu->fot_usu'";
                                                
                                            } else {
                                                ?>
                                                src="<?php print base_url(); ?>public/img/perfil.jpg" <?php
                                            }
                                        } else {
                                    ?>
                                            src="<?php print base_url(); ?>public/img/perfil.jpg" <?php }
                                        ?> alt="" onerror="this.src='<?php print base_url() . "public/img/perfil.jpg"; ?>';" />

                                </div>
                                <div>
                                <br>
                                    <span class="btn btn-file btn-success">
                                        <span class="fileupload-new">Imagen</span>
                                        <span class="fileupload-exists">Cambiar</span>
                                        <input type="file"  id="foto" name="foto" accept="image/*" /> 
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-9">
                            <?php /* CAMPO HIDDEN CON EL ID DE LA INSCRIPCIÓN (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                                if(@$fic_usu != NULL){ ?>
                                    <input type="hidden" id="txt_id" name="txt_id" value="<?php if($fic_usu != NULL){ print $fic_usu->id_usu; }?>" >    
                                <?php } else { ?>
                                    <input type="hidden" id="txt_id" name="txt_id" value="0">    
                            <?php } ?>  
                            <!-- Nombre del Usuario -->
                            <div class="form-group col-md-7">
                                <label for="txt_nombre">Nombres y Apellidos</label>
                                <input type="text" class="form-control validate[required]" name="txt_nombre" id="txt_nombre" placeholder="Nombre del Usuario" value="<?php if(@$fic_usu != NULL){ print @$fic_usu->nom_usu; }?>">
                            </div>

                            <!-- Estatus del Usuario -->
                            <div class="form-group col-md-3">
                                <label>Estatus</label>
                                <select class="form-control validate[required]" id="cmb_estatus" name="cmb_estatus">
                                    <!-- <option value="0">Seleccione...</option>  -->
                                    <?php if($fic_usu != NULL){ ?>
                                    <?php if($fic_usu->est_usu == 'A'){ ?>
                                        <option value="<?php if($fic_usu != NULL){ print $fic_usu->est_usu; }?>" selected="TRUE">Activo</option>
                                        <option value="I">Inactivo</option>
                                    <?php } else {?>
                                        <option value="A">Activo</option> 
                                        <option value="<?php if($fic_usu != NULL){ print $fic_usu->est_usu; }?>" selected="TRUE">Inactivo</option>    
                                    <?php } 
                                        }
                                    ?>
                                    <?php if(@$fic_usu == NULL){ ?>
                                      <option value="A" selected="TRUE">Activo</option> 
                                      <option value="I">Inactivo</option>  
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-5">
                                <label>Perfil</label>
                                <select class="form-control validate[required]" id="cmb_perfil" name="cmb_perfil">
                                    <?php 
                                      if(@$perfil != NULL){ ?>
                                        <option  value="0" selected="TRUE">Seleccione...</option>
                                    <?php }  
                                              if (count($perfil) > 0) {
                                                foreach ($perfil as $pe):
                                                    if(@$fic_usu->perfil != NULL){
                                                        if($pe->id_perfil == $fic_usu->perfil){ ?>
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

                            <div class="form-group col-md-5">
                              <label>Empleado</label>
                              <div id="empleado_perfil">  
                                <select class="form-control" id="cmb_empleado" name="cmb_empleado">
                                    <?php 
                                      if(@$empleado != NULL){ ?>
                                        <option  value="0" selected="TRUE">Seleccione...</option>
                                    <?php }  
                                      if (count($empleado) > 0) {
                                        foreach ($empleado as $emp):
                                            if(@$fic_usu->id_empleado != NULL){
                                                if($emp->id_empleado == $fic_usu->id_empleado){ ?>
                                                    <option  value="<?php  print $emp->id_empleado; ?>" selected="TRUE"><?php  print $emp->nombres . ' ' . $emp->apellidos ?></option> 
                                                    <?php
                                                }else{ ?>
                                                    <option value="<?php  print $emp->id_empleado; ?>"> <?php  print $emp->nombres . ' ' . $emp->apellidos ?> </option>
                                                    <?php
                                                }
                                            }else{ ?>
                                                <option value="<?php  print $emp->id_empleado; ?>"> <?php  print $emp->nombres . ' ' . $emp->apellidos ?> </option>
                                                <?php
                                                }   ?>
                                            <?php

                                        endforeach;
                                    }
                                    ?>
                                </select>
                              </div>    
                            </div>    


                            <!-- Nombre del Usuario para el Inicio de Sesion -->
                            <div class="form-group  col-md-5">
                                <label for="txt_usuario">Usuario</label>
                                <input type="text" class="form-control validate[required]" id="txt_usuario" name="txt_usuario" placeholder="Usuario" value="<?php if(@$fic_usu != NULL){ print @$fic_usu->log_usu; }?>">
                            </div>
                            <!-- Contraseña del Usuario -->
                            <div class="form-group  col-md-4">
                                <label for="txt_clave">Contraseña</label>
                                <input type="password" class="form-control validate[required]" id="txt_clave" name="txt_clave" placeholder="Password" >
                            </div>
                        </div>

                      </div>
                    </div>
                    <div  align="center" class="box-footer">
                        <div class="form-actions ">
                            <button type="submit" class="btn btn-success  btn-grad no-margin-bottom">
                                <i class="fa fa-save "></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>
</div>