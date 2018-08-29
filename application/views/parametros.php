<?php
/* ------------------------------------------------
  ARCHIVO: parametros.php
  DESCRIPCION: Contiene la vista principal del módulo de parametros.
  FECHA DE CREACIÓN: 05/07/2017
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
print "<script>document.title = 'ProdegelRRHH - Parametros'</script>";
date_default_timezone_set("America/Guayaquil");
?>
<script>


  $( document ).ready(function() {
    $("#frm_emp").validationEngine();


  });

</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="frmparametro">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <i class="fa fa-fort-awesome"></i> Parametros Generales </a></li>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>parametros">Parametros Generales</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- SECCION DEL FORMULARIO-->
            <div class="col-md-6" style="padding-right: 5px;">
                <!-- general form elements -->
                <div class="box box-danger">
<!--                     <div class="box-header with-border">
                        <h3 class="box-title">Parametros Generales</h3>
                    </div> -->
                  <!--   <form role="form"> -->
             
                    <form id="frm_emp" name="frm_emp" method="post" role="form" class="form" enctype="multipart/form-data" action="<?php echo base_url('parametros/guardar');?>">
                        <div class="box-body">

                         <div class="nav-tabs-custom">
                          <ul class="nav nav-tabs">
                           <li class="active"><a href="#tabgeneral" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> GENERAL</a></li>                                                       
                           <li ><a href="#tabrubro" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> RUBROS</a></li>                                                       
                          </ul>

                          <div class="tab-content">
                            <div class="tab-pane active" id="tabgeneral" >

                              <div class="col-xs-9">

                                <div class="form-group col-md-12" style="padding-top: 20px;">
                                    <label for="lb_cat">Razon Social</label>
                                    <input type="text" class="form-control validate[required]" name="txt_razonsocial" id="txt_razonsocial" placeholder="Razon Social" value="<?php if(@$cfg != NULL){ print @$cfg->razonsocial; }?>" >
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="lb_cat">Nombre Comercial</label>
                                    <input type="text" class="form-control validate[required]" name="txt_nombrecomercial" id="txt_nombrecomercial" placeholder="Nombre Comercial" value="<?php if(@$cfg != NULL){ print @$cfg->nombrecomercial; }?>" >
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="lb_cat">Identificacion</label>
                                    <input type="text" class="form-control validate[required]" name="txt_identificacion" id="txt_Identificacion" placeholder="Identificacion" value="<?php if(@$cfg != NULL){ print @$cfg->identificacion; }?>" >
                                </div>
                              </div>

                              <div class="col-xs-3 text-center"  style="padding-top: 20px;">
                                  <h3 class="profile-username text-center">Logo de Empresa</h3>
<!--                                   <p class="text-muted text-center">Identificación</p>
 -->                                  <div class="fileupload fileupload-new" data-provides="fileupload">
                                      <div class="fileupload-preview thumbnail"  id="fotomostrar">
<!--                                            <img src="<?php print base_url() . "doc/". $cfg->logo_empresa; ?>" />
 -->                                           <img <?php 
                                              if ($cfg->logo_empresa != NULL) {
                                                  if ($cfg->logo_empresa != "") {
                                                      
                                                      print "width='150' height='150' src='" . base_url() ."doc/$cfg->logo_empresa'";
                                                      
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


                            </div>  <!-- Tab General --> 

                            <div class="tab-pane" id="tabrubro" >

                              <div class="form-group col-md-8" style="padding-top: 20px;">
                                <label>Identificador Rubro de Sueldo</label>
                                <select id="txt_sueldo" name="txt_sueldo" class="form-control">
                                  <?php 
                                    if(@$lstrubro != NULL){ ?>
                                    <?php } else { ?>
                                    <option  value="" selected="TRUE">Seleccione Rubro de Sueldo...</option>
                                    <?php } 
                                      if (count($lstrubro) > 0) {
                                        foreach ($lstrubro as $rubro):
                                            if(@$rubro_sueldo != NULL){
                                                if($rubro_sueldo == $rubro->id){ ?>
                                                     <option name="<?php  print $rubro->codigo_rubro; ?>" value="<?php  print $rubro->id; ?>" selected="TRUE"> <?php  print $rubro->codigo_rubro . ' - ' . $rubro->nombre_rubro; ?> </option>
                                                    <?php
                                                }else{ ?>
                                                    <option name="<?php  print $rubro->codigo_rubro; ?>" value="<?php  print $rubro->id; ?>" > <?php  print $rubro->codigo_rubro . ' - ' . $rubro->nombre_rubro; ?> </option>
                                                    <?php
                                                }
                                            }else{ ?>
                                                <option name="<?php  print $rubro->codigo_rubro; ?>" value="<?php  print $rubro->id; ?>" > <?php  print $rubro->codigo_rubro . ' - ' . $rubro->nombre_rubro; ?> </option>
                                                <?php
                                                }   ?>
                                            <?php
                                        endforeach;
                                      }
                                    ?>
                                </select>
                              </div>

                              <div class="form-group col-md-8">
                                <label>Identificador Rubro de Dias Trabajados</label>
                                <select id="txt_diastrab" name="txt_diastrab" class="form-control">
                                  <?php 
                                    if(@$lstrubro != NULL){ ?>
                                    <?php } else { ?>
                                    <option  value="" selected="TRUE">Seleccione Rubro de Dias Trabajados...</option>
                                    <?php } 
                                      if (count($lstrubro) > 0) {
                                        foreach ($lstrubro as $rubro):
                                            if(@$rubro_diastrab != NULL){
                                                if($rubro_diastrab == $rubro->id){ ?>
                                                     <option name="<?php  print $rubro->codigo_rubro; ?>" value="<?php  print $rubro->id; ?>" selected="TRUE"> <?php  print $rubro->codigo_rubro . ' - ' . $rubro->nombre_rubro; ?> </option>
                                                    <?php
                                                }else{ ?>
                                                    <option name="<?php  print $rubro->codigo_rubro; ?>" value="<?php  print $rubro->id; ?>" > <?php  print $rubro->codigo_rubro . ' - ' . $rubro->nombre_rubro; ?> </option>
                                                    <?php
                                                }
                                            }else{ ?>
                                                <option name="<?php  print $rubro->codigo_rubro; ?>" value="<?php  print $rubro->id; ?>" > <?php  print $rubro->codigo_rubro . ' - ' . $rubro->nombre_rubro; ?> </option>
                                                <?php
                                                }   ?>
                                            <?php
                                        endforeach;
                                      }
                                    ?>
                                </select>
                              </div>

                              <div class="form-group col-md-8">
                                <label>Identificador Rubro de Neto a Cobrar</label>
                                <select id="txt_netocobrar" name="txt_netocobrar" class="form-control">
                                  <?php 
                                    if(@$lstrubro != NULL){ ?>
                                    <?php } else { ?>
                                    <option  value="" selected="TRUE">Seleccione Rubro de Neto a Cobrar...</option>
                                    <?php } 
                                      if (count($lstrubro) > 0) {
                                        foreach ($lstrubro as $rubro):
                                            if(@$rubro_netocobrar != NULL){
                                                if($rubro_netocobrar == $rubro->id){ ?>
                                                     <option name="<?php  print $rubro->codigo_rubro; ?>" value="<?php  print $rubro->id; ?>" selected="TRUE"> <?php  print $rubro->codigo_rubro . ' - ' . $rubro->nombre_rubro; ?> </option>
                                                    <?php
                                                }else{ ?>
                                                    <option name="<?php  print $rubro->codigo_rubro; ?>" value="<?php  print $rubro->id; ?>" > <?php  print $rubro->codigo_rubro . ' - ' . $rubro->nombre_rubro; ?> </option>
                                                    <?php
                                                }
                                            }else{ ?>
                                                <option name="<?php  print $rubro->codigo_rubro; ?>" value="<?php  print $rubro->id; ?>" > <?php  print $rubro->codigo_rubro . ' - ' . $rubro->nombre_rubro; ?> </option>
                                                <?php
                                                }   ?>
                                            <?php
                                        endforeach;
                                      }
                                    ?>
                                </select>
                              </div>

                            </div>  <!-- Tab Rubro --> 

                          </div>  <!-- Tab Control --> 
                        </div>  <!-- Nav Tab Control --> 

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

        </div>
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

