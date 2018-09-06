<?php

  $usua = $this->session->userdata('usua');
  $id = $usua->id_usu;
  $perfil = $usua->perfil;

?>

<style>
    #contenido_ret{
        width: 500px;       
    }   

  
</style>



<script type="text/javascript">


   $(document).ready(function () {

    $("#formpermisoausencia").validationEngine();

    $(".hora").mask("99:99");

    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $('#fecha_desde').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fecha_desde').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });  
    $('#fecha_hasta').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fecha_hasta').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });  

    var perfil = "<?php print @$perfil ?>";
    if (perfil == "2"){
      $("#chkaprobado").attr("disabled", false);
    }
  });     

</script>
<div id = "contenido_ret" class="col-md-6">
    <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"></i> Datos de Permiso de Ausencia</h3>
        </div>
        <form id="formpermisoausencia" name="formpermisoausencia" method='POST' action="<?=base_url();?>Permisoausencia/guardar">
            <div class="box-body">
                <div class="row">
                    <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                        if(@$obj != NULL){ ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="<?php if($obj != NULL){ print $obj->id; }?>" >    
                        <?php } else { ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="0">    
                    <?php } ?>  

                    <div class="form-group col-md-9">
                      <label for="lb_res">Empleado</label>
                      <select id="cmb_empleado" name="cmb_empleado" class="form-control validate[required]">
                      <?php 
                        if(@$empleado != NULL){ ?>
                        <?php } else { ?>
                        <option  value="" selected="TRUE">Seleccione empleado...</option>
                        <?php } 
                          if (count($empleado) > 0) {
                            foreach ($empleado as $tipo):
                                if(@$obj->id_empleado != NULL){
                                    if($obj->id_empleado == $tipo->id_empleado){ ?>
                                         <option value="<?php  print $tipo->id_empleado; ?>" selected="TRUE"> <?php  print $tipo->apellidos . ' ' . $tipo->nombres; ?> </option>
                                        <?php
                                    }else{ ?>
                                        <option value="<?php  print $tipo->id_empleado; ?>" > <?php  print $tipo->apellidos . ' ' . $tipo->nombres; ?> </option>
                                        <?php
                                    }
                                }else{ ?>
                                    <option value="<?php  print $tipo->id_empleado; ?>" > <?php  print $tipo->apellidos . ' ' . $tipo->nombres; ?> </option>
                                    <?php
                                    }   ?>
                                <?php
                            endforeach;
                          }
                        ?>
                      </select>                                  
                    </div>

                    <div class="form-group col-md-3 text-center" style="padding-left: 0px;padding-right: 0px;">
                        <input id="chkaprobado" name="chkaprobado" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->aprobado == 1){ print " checked";} } ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" disabled> <strong>Aprobado</strong>
                    </div>

                    <div class="form-group col-md-9">
                      <label for="lb_res">Tipo de Permiso</label>
                      <select id="cmb_tipopermiso" name="cmb_tipopermiso" class="form-control validate[required]">
                      <?php 
                        if(@$tipopermiso != NULL){ ?>
                        <?php } else { ?>
                        <option  value="" selected="TRUE">Seleccione ...</option>
                        <?php } 
                          if (count($tipopermiso) > 0) {
                            foreach ($tipopermiso as $tipo):
                                if(@$obj->id_tipopermiso != NULL){
                                    if($obj->id_tipopermiso == $tipo->id){ ?>
                                         <option value="<?php  print $tipo->id; ?>" selected="TRUE"> <?php  print $tipo->tipopermiso; ?> </option>
                                        <?php
                                    }else{ ?>
                                        <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->tipopermiso; ?> </option>
                                        <?php
                                    }
                                }else{ ?>
                                    <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->tipopermiso; ?> </option>
                                    <?php
                                    }   ?>
                                <?php
                            endforeach;
                          }
                        ?>
                      </select>                                  
                    </div>


                    <div class="form-group col-md-6">
                        <label for="lb_cat">Fecha Salida</label>
                        <input type="text" class="form-control " name="fecha_desde" id="fecha_desde" placeholder="Fecha Salida" value="<?php if(@$obj != NULL){ @$fec = str_replace('-', '/', @$obj->fecha_desde); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec; } ?>" >
                    </div>                       

                    <div class="form-group col-md-6">
                      <label >Hora Salida</label>
                      <div class="input-group">
                        <input style="width:100px;" type="text" class="form-control text-center validate[required] hora" id="hora_desde" name="hora_desde" value="<?php if(@$obj != NULL){ print @$obj->hora_desde; } else {print '00:00:00';} ?>">
                      </div>
                    </div>                       

                    <div class="form-group col-md-6">
                        <label for="lb_cat">Fecha Entrada</label>
                        <input type="text" class="form-control " name="fecha_hasta" id="fecha_hasta" placeholder="Fecha Entrada" value="<?php if(@$obj != NULL){ @$fec = str_replace('-', '/', @$obj->fecha_hasta); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec; } ?>" >
                    </div>                       

                    <div class="form-group col-md-6">
                      <label >Hora Entrada</label>
                      <div class="input-group">
                        <input style="width:100px;" type="text" class="form-control text-center validate[required] hora" id="hora_hasta" name="hora_hasta" value="<?php if(@$obj != NULL){ print @$obj->hora_hasta; } else {print '23:59:59';} ?>">
                      </div>
                    </div>                       

                    <div class="form-group col-md-12">
                        <label for="lb_cat">Motivo</label>
                        <input type="text" class="form-control " name="txt_motivo" id="txt_motivo" placeholder="Motivo" value="<?php if(@$obj != NULL){ print @$obj->motivo; }?>" >
                    </div>


                </div>
            </div>
            <div  align="center" class="box-footer">
                <div class="form-actions ">
                    <button type="submit" class="btn btn-success btn-grad no-margin-bottom ">
                    <i class="fa fa-save "></i> Guardar
                </button>
                </div>
            </div>
        </form>
    </div>
</div>