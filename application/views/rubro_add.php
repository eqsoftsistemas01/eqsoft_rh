<style>
    #contenido_ret{
        width: 500px;
    }   
</style>
<script type="text/javascript">

  $(document).ready(function () {

    $("#formrubro").validationEngine();

    $(document).on('click', '#cmb_periodo', function(){
        var periodo = $('#cmb_periodo').val();
        if(periodo == 2){ 
          $('#cmb_mesactivo').attr('disabled',false); 
        } 
        else{ 
          $('#cmb_mesactivo').val(1); 
          $('#cmb_mesactivo').attr('disabled',true); 
        }  
    });

    $(document).on('click', '#chkcalculo', function(){
        if($("#chkcalculo").is(":checked")){ 
          $('#txt_expresion').attr('disabled',false); 
        } 
        else{ 
          $('#txt_expresion').attr('disabled',true); 
        }  
    });

    /* MASCARA PARA COD */
    $("#codigo_rubro").mask("9999");

    $(document).on('blur', '#txt_expresion', function(){
      var exp = $(this).val();
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Rubro/eval_expresion');?>",
        data: {exp: exp},
        success: function(json) {
          if (json.mens == 0){
            $('.btnguardarubro').attr('disabled',true); 
            alert('Expresion no Válida.');
            $('#txt_expresion').focus();
          } else {
            $('.btnguardarubro').attr('disabled',false); 
          }
        }
      });
    });  

  });     

</script>
<div id = "contenido_ret" class="col-md-6">
    <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"></i> Datos de Rubro</h3>
        </div>
        <form id="formrubro" name="formrubro" method='POST' action="<?=base_url();?>Rubro/guardar">
            <div class="box-body">
                <div class="row">
                    <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                        if(@$obj != NULL){ ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="<?php if($obj != NULL){ print $obj->id; }?>" >    
                        <?php } else { ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="0">    
                    <?php } ?>  

                    <div class="form-group col-md-9">
                        <label for="lb_cat">Nombre de Rubro</label>
                        <input type="text" class="form-control validate[required]" name="nombre_rubro" id="nombre_rubro" placeholder="Nombre de Rubro" value="<?php if(@$obj != NULL){ print @$obj->nombre_rubro; }?>" >
                    </div>

                    <div class="form-group col-md-3">
                        <input id="chkactivo" name="chkactivo" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->activo == 1){ print " checked";} } ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Activo</strong>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="lb_cat">Codigo de Rubro</label>
                        <input type="text" class="form-control validate[required]" name="codigo_rubro" id="codigo_rubro" placeholder="Codigo de Rubro" value="<?php if(@$obj != NULL){ print @$obj->codigo_rubro; }?>" >
                    </div>

                    <div class="form-group col-md-6">
                      <label for="lb_res">Tipo</label>
                      <select id="cmb_tiporubro" name="cmb_tiporubro" class="form-control">
                      <?php 
                        if(@$tiporubro != NULL){ ?>
                        <?php } else { ?>
                        <option  value="" selected="TRUE">Seleccione...</option>
                        <?php } 
                          if (count($tiporubro) > 0) {
                            foreach ($tiporubro as $tipo):
                                if(@$obj->tipo_rubro != NULL){
                                    if($obj->tipo_rubro == $tipo->id){ ?>
                                         <option value="<?php  print $tipo->id; ?>" selected="TRUE"> <?php  print $tipo->tiporubro; ?> </option>
                                        <?php
                                    }else{ ?>
                                        <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->tiporubro; ?> </option>
                                        <?php
                                    }
                                }else{ ?>
                                    <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->tiporubro; ?> </option>
                                    <?php
                                    }   ?>
                                <?php
                            endforeach;
                          }
                        ?>
                      </select>                                  
                    </div>

                    <div class="form-group col-md-6">
                      <label for="lb_res">Periodicidad</label>
                      <select id="cmb_periodo" name="cmb_periodo" class="form-control">
                      <?php 
                        if(@$periodo != NULL){ ?>
                        <?php } else { ?>
                        <option  value="" selected="TRUE">Seleccione...</option>
                        <?php } 
                          if (count($periodo) > 0) {
                            foreach ($periodo as $tipo):
                                if(@$obj->periodicidadmensual != NULL){
                                    if($obj->periodicidadmensual == $tipo->id){ ?>
                                         <option value="<?php  print $tipo->id; ?>" selected="TRUE"> <?php  print $tipo->periodicidad; ?> </option>
                                        <?php
                                    }else{ ?>
                                        <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->periodicidad; ?> </option>
                                        <?php
                                    }
                                }else{ ?>
                                    <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->periodicidad; ?> </option>
                                    <?php
                                    }   ?>
                                <?php
                            endforeach;
                          }
                        ?>
                      </select>                                  
                    </div>

                    <div class="form-group col-md-6">
                      <label for="lb_res">Mes Activo</label>
                      <select id="cmb_mesactivo" name="cmb_mesactivo" class="form-control">
                      <?php 
                        if(@$mesactivo != NULL){ ?>
                        <?php } else { ?>
                        <option  value="" selected="TRUE">Seleccione...</option>
                        <?php } 
                          if (count($mesactivo) > 0) {
                            foreach ($mesactivo as $tipo):
                                if(@$obj->mesactivo != NULL){
                                    if($obj->mesactivo == $tipo->id){ ?>
                                         <option value="<?php  print $tipo->id; ?>" selected="TRUE"> <?php  print $tipo->mes; ?> </option>
                                        <?php
                                    }else{ ?>
                                        <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->mes; ?> </option>
                                        <?php
                                    }
                                }else{ ?>
                                    <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->mes; ?> </option>
                                    <?php
                                    }   ?>
                                <?php
                            endforeach;
                          }
                        ?>
                      </select>                                  
                    </div>
                   
                    <div class="form-group col-md-8">
                        <input id="chkdias" name="chkdias" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->afectadopordias == 1){ print " checked";} }  ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Vinculado a Dias Trabajados</strong>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="lb_cat">Dias de gracia</label>
                        <input type="text" class="form-control " name="txt_diasgracia" id="txt_diasgracia" placeholder="Dias de gracia" value="<?php if(@$obj != NULL){ print @$obj->diasgracia; }?>" >
                    </div>

                    <div class="form-group col-md-12">
                        <input id="chkcalculo" name="chkcalculo" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->editable == 0){ print " checked";} }  ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Calculado</strong>
                    </div>

                    <div class="form-group col-md-12">
                        <input type="text" class="form-control " name="txt_expresion" id="txt_expresion" placeholder="Expresion de Calculo" value="<?php if(@$obj != NULL){ print @$obj->expresioncalculo; }?>" <?php if(@$obj != NULL){ if(@$obj->editable == 1){ print " disabled";} } else { print " disabled";}  ?>>
                    </div>


                </div>
            </div>
            <div  align="center" class="box-footer">
                <div class="form-actions ">
                    <button type="submit" class="btn btn-danger btn-grad no-margin-bottom btnguardarubro">
                    <i class="fa fa-save "></i> Guardar
                </button>
                </div>
            </div>
        </form>
    </div>
</div>