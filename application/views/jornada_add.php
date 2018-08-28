<style>
    #contenido_ret{
        width: 500px;       
    }   

  
</style>



<script type="text/javascript">


   $(document).ready(function () {

    $("#formjornada").validationEngine();

    $(".hora").mask("99:99:99");

  });     

</script>
<div id = "contenido_ret" class="col-md-6">
    <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"></i> Datos de jornada</h3>
        </div>
        <form id="formjornada" name="formjornada" method='POST' action="<?=base_url();?>Jornada/guardar">
            <div class="box-body">
                <div class="row">
                    <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                        if(@$obj != NULL){ ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="<?php if($obj != NULL){ print $obj->id; }?>" >    
                        <?php } else { ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="0">    
                    <?php } ?>  

                    <div class="form-group col-md-9">
                        <label for="lb_cat">Descripcion de jornada</label>
                        <input type="text" class="form-control validate[required]" name="descripcion" id="descripcion" placeholder="Descripcion de jornada" value="<?php if(@$obj != NULL){ print @$obj->descripcion; }?>" >
                    </div>

                    <div class="form-group col-md-3">
                        <input id="chkactivo" name="chkactivo" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->activo == 1){ print " checked";} } ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Activo</strong>
                    </div>

                    <div class="form-group col-md-6">
                      <label >Entrada Trabajo</label>
                      <div class="input-group">
                        <input style="width:100px;" type="text" class="form-control text-center validate[required] hora" id="entrada_trabajo" name="entrada_trabajo" value="<?php if(@$obj != NULL){ print @$obj->entrada_trabajo; } else {print '00:00:00';} ?>">
                      </div>
                    </div>                       

                    <div class="form-group col-md-6">
                      <label >Salida Trabajo</label>
                      <div class="input-group">
                        <input style="width:100px;" type="text" class="form-control text-center validate[required] hora" id="salida_trabajo" name="salida_trabajo" value="<?php if(@$obj != NULL){ print @$obj->salida_trabajo; } else {print '23:59:59';} ?>">
                      </div>
                    </div>                       

                    <div class="form-group col-md-6">
                      <label >Salida Almuerzo</label>
                      <div class="input-group">
                        <input style="width:100px;" type="text" class="form-control text-center hora" id="salida_almuerzo" name="salida_almuerzo" value="<?php if(@$obj != NULL){ print @$obj->salida_almuerzo; } else {print '00:00:00';} ?>">
                      </div>
                    </div>                       

                    <div class="form-group col-md-6">
                      <label >Entrada Almuerzo</label>
                      <div class="input-group">
                        <input style="width:100px;" type="text" class="form-control text-center hora" id="entrada_almuerzo" name="entrada_almuerzo" value="<?php if(@$obj != NULL){ print @$obj->entrada_almuerzo; } else {print '00:00:00';} ?>">
                      </div>
                    </div>                       

                </div>
            </div>
            <div  align="center" class="box-footer">
                <div class="form-actions ">
                    <button type="submit" class="btn btn-danger btn-grad no-margin-bottom ">
                    <i class="fa fa-save "></i> Guardar jornada
                </button>
                </div>
            </div>
        </form>
    </div>
</div>