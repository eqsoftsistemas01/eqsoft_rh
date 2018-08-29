<style>
    #contenido_ret{
        width: 500px;
    }   
</style>
<script type="text/javascript">

</script>
<div id = "contenido_ret" class="col-md-6">
    <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"></i> Datos de Tipo de Trabajador</h3>
        </div>
        <form id="formdpto" name="formdpto" method='POST' action="#" onSubmit='return false' >
            <div class="box-body">
                <div class="row">
                    <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                        if(@$obj != NULL){ ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="<?php if($obj != NULL){ print $obj->id; }?>" >    
                        <?php } else { ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="0">    
                    <?php } ?>  

                    <div class="form-group col-md-12">
                        <label for="lb_cat">Tipo de Trabajador</label>
                        <input type="text" class="form-control validate[required]" name="txt_tipotrabajador" id="txt_tipotrabajador" placeholder="Tipo de Sangre" value="<?php if(@$obj != NULL){ print @$obj->tipo_trabajador; }?>" >
                    </div>

                    <div class="form-group col-md-12">
                        <label for="lb_cat">Descripcion</label>
                        <input type="text" class="form-control validate[required]" name="txt_descripcion" id="txt_descripcion" placeholder="Descripcion" value="<?php if(@$obj != NULL){ print @$obj->descripcion; }?>" >
                    </div>                

                    <div class="form-group col-md-6">
                        <input id="chkactivo" name="chkactivo" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->activo == 1){ print " checked";} } else {print " checked";} ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Activo</strong>
                    </div>

                    </div>

                </div>
            </div>
            <div  align="center" class="box-footer">
                <div class="form-actions ">
                    <button type="submit" class="btn btn-danger btn-grad no-margin-bottom btnguardartipo">
                    <i class="fa fa-save "></i> Guardar
                </button>
                </div>
            </div>
        </form>
    </div>
</div>