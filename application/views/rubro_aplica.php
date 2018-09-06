<style>
    #contenido_ret{
        width: 500px;
    }   
</style>
<script type="text/javascript">

  $(document).ready(function () {

    $(document).on('change', '#cmb_tipotrabajador', function(){
        var tipo = $('#cmb_tipotrabajador').val();
        if(tipo != 0){ 
          $('.btnaplicarubro').attr('disabled',false); 
        } 
        else{ 
          $('.btnaplicarubro').attr('disabled',true); 
        }  
    });

    /* MASCARA PARA COD */
    $("#codigo_rubro").mask("9999");


  });     

</script>
<div id = "contenido_ret" class="col-md-6">
    <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"></i> Aplicar Rubro</h3>
        </div>
        <form id="formrubro" name="formrubro" method='POST' action="#">
            <div class="box-body">
                <div class="row">
                    <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                        if(@$obj != NULL){ ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="<?php if($obj != NULL){ print $obj->id; }?>" >    
                        <?php } else { ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="0">    
                    <?php } ?>  

                    <div class="form-group col-md-8">
                        <label for="lb_cat">Nombre de Rubro</label>
                        <input type="text" class="form-control validate[required]" name="nombre_rubro" id="nombre_rubro" placeholder="Nombre de Rubro" value="<?php if(@$obj != NULL){ print @$obj->nombre_rubro; }?>" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="lb_cat">Codigo de Rubro</label>
                        <input type="text" class="form-control validate[required]" name="codigo_rubro" id="codigo_rubro" placeholder="Codigo de Rubro" value="<?php if(@$obj != NULL){ print @$obj->codigo_rubro; }?>" readonly>
                    </div>

                    <div style="" class="form-group col-md-8">
                      <label for="lb_res">Tipo de Trabajador</label>
                      <select class="form-control validate[required]" id="cmb_tipotrabajador" name="cmb_tipotrabajador">
                          <?php 
                            if(@$tipotrabajador != NULL){ ?>
                              <option  value="0" selected="TRUE">Seleccione...</option>
                          <?php }  
                            if (count($tipotrabajador) > 0) {
                              foreach ($tipotrabajador as $pe): ?>
                                <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipo_trabajador ?> </option>
                          <?php
                              endforeach;
                            }
                          ?>
                      </select>
                    </div>


                </div>
            </div>
            <div  align="center" class="box-footer">
                <div class="form-actions ">
                    <button type="button" class="btn btn-success btn-grad no-margin-bottom btnaplicarubro" disabled="true">
                    <i class="fa fa-save "></i> Aplicar
                </button>
                </div>
            </div>
        </form>
    </div>
</div>