<?php
/* ------------------------------------------------
  ARCHIVO: Sucursal.php
  DESCRIPCION: Contiene la vista principal del módulo de Sucursal.
  FECHA DE CREACIÓN: 13/07/2017
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
print "<script>document.title = 'ProdegelRRHH - Empresa'</script>";
date_default_timezone_set("America/Guayaquil");
?>
<script>
$( document ).ready(function() {
    $("#frm_add").validationEngine();
    
    $('#fecha').datepicker();
    $('#fecha').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });


});

</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-university"></i> Empresa
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>empresa">Empresa</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- SECCION DEL FORMULARIO-->
            <form id="frm_add" name="frm_add" method="post" role="form" class="form" enctype="multipart/form-data" action="<?php echo base_url('Empresa/guardar');?>">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title"></i> Datos de la Empresa</h3>
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="col-xs-3 text-center">
                            <h3 class="profile-username text-center">Logotipo</h3>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-preview thumbnail"  id="fotomostrar">
                                    <img  width="150" height="150"<?php
                                        if (@$empresa != NULL) {
                                            if (trim($empresa->logo_path) != '') {
                                                ?>
                                                src="<?php print base_url(); ?>public/img/empresa/<?php print $empresa->logo_path; ?>" <?php
                                                
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
                                        <input type="file"  id="logo" name="logo" accept="image/*" /> 
                                    </span>
                                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Quitar</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-9">
                            <div class="col-xs-12">
                            <!-- CAMPO HIDDEN CON EL ID DE LA INSCRIPCIÓN (EN CASO DE MODIFICACIÓN DEL REGISTRO) -->                                    
                                <input type="hidden" id="txt_idemp" name="txt_idemp" value="<?php if(@$empresa != NULL){ print $empresa->id_emp; } else {print 0;} ?>" >    
                                <input type="hidden" id="old_logo" name="old_logo" value="<?php if(@$empresa != NULL){ print $empresa->logo_path; } ?>" >    
                            </div> 

                            <!-- Nombrede la Usuario -->
                            <div class="form-group col-md-6">
                                <label for="lb_nom">Nombre</label>
                                <input type="text" class="form-control validate[required]" name="txt_nom" id="txt_nom" placeholder="Nombre de la Empresa" value="<?php if(@$empresa != NULL){ print @$empresa->nom_emp; }?>">
                            </div>

                            <!-- Codigo -->
                            <div class="form-group col-md-6">
                                <label for="lb_enca">Codigo</label>
                                <input type="text" class="form-control " name="txt_codigo" id="txt_codigo" placeholder="Codigo de la Empresa" value="<?php if(@$empresa != NULL){ print @$empresa->cod_emp; }?>">
                            </div>

                            <!-- RUC -->
                            <div class="form-group col-md-6">
                                <label for="lb_nom">RUC</label>
                                <input type="text" class="form-control validate[required]" name="txt_ruc" id="txt_ruc" placeholder="RUC de la Empresa" value="<?php if(@$empresa != NULL){ print @$empresa->ruc_emp; }?>">
                            </div>

                            <!-- razon social -->
                            <div class="form-group col-md-6">
                                <label for="lb_nom">Razon Social</label>
                                <input type="text" class="form-control validate[required]" name="txt_razon" id="txt_razon" placeholder="Razon Social de la Empresa" value="<?php if(@$empresa != NULL){ print @$empresa->raz_soc_emp; }?>">
                            </div>

                            <!-- Correo del Usuario -->
                            <div class="form-group col-md-4">
                                <label for="txt_email">Email</label>
                                    <input type="text" class="form-control " id="txt_email" name="txt_email" placeholder="Email de la Empresa" value="<?php if(@$empresa != NULL){ print @$empresa->ema_emp; }?>">
                            </div>

                            <!-- Teléfono del Usuario -->
                            <div class="form-group col-md-4">
                                <label>Telefono:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control " id="txt_telefono" name="txt_telefono" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?php if(@$empresa != NULL){ print @$empresa->tlf_emp; }?>">
                                </div>
                            </div> 

                            <!-- fax -->
                            <div class="form-group col-md-4">
                                <label>Fax:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control " id="txt_fax" name="txt_fax" data-inputmask='"mask": "(999) 999-9999"' data-mask value="<?php if(@$empresa != NULL){ print @$empresa->fax_emp; }?>">
                                </div>
                            </div> 

                            <!-- Apellido del Usuario -->
                            <div class="form-group col-md-12">
                                <label for="txt_apellido">Dirección</label>
                                <input type="text" class="form-control " name="txt_dir" id="txt_dir" placeholder="Dirección de la Empresa" value="<?php if(@$empresa != NULL){ print @$empresa->dir_emp; }?>">
                            </div>

                            <!-- Apellido del Usuario -->
                            <div class="form-group col-md-6">
                                <label for="txt_apellido">Representante</label>
                                <input type="text" class="form-control " name="txt_rep" id="txt_rep" placeholder="Representante de la Empresa" value="<?php if(@$empresa != NULL){ print @$empresa->rep_emp; }?>">
                            </div>

                            <!-- Apellido del Usuario -->
                            <div class="form-group col-md-6">
                                <label for="txt_apellido">Sitio Web</label>
                                <input type="text" class="form-control " name="txt_web" id="txt_web" placeholder="Sitio Web de la Empresa" value="<?php if(@$empresa != NULL){ print @$empresa->web_emp; }?>">
                            </div>

                        </div>

                      </div>
                    </div>
                    <!-- /.box-body -->
                    <div  align="center" class="box-footer">
                        <div class="form-actions ">
                            <button type="submit" class="btn btn-success btn-grad no-margin-bottom">
                                <i class="fa fa-save "></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
              <!-- /.box -->
            </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

