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
          <h3 class="box-title"></i> Datos del País</h3>
        </div>
        <form id="formpais" name="formpais" method='POST' action="#" onSubmit='return false' >
            <div class="box-body">
                <div class="row">
                    <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                        if(@$obj != NULL){ ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="<?php if($obj != NULL){ print $obj->id; }?>" >    
                        <?php } else { ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="0">    
                    <?php } ?>  

                    <div class="form-group col-md-12">
                        <label for="lb_cat">Codigo del País</label>
                        <input type="text" class="form-control validate[required]" name="txt_codigo" id="txt_codigo" placeholder="Codigo del País" value="<?php if(@$obj != NULL){ print @$obj->codigo_pais; }?>" >
                    </div>

                    <div class="form-group col-md-12">
                        <label for="lb_cat">Nombre del País</label>
                        <input type="text" class="form-control validate[required]" name="txt_nombre" id="txt_nombre" placeholder="Nombre del País" value="<?php if(@$obj != NULL){ print @$obj->nombre_pais; }?>" >
                    </div>
                    
                    <div class="form-group col-md-6">
                        <input id="chkactivo" name="chkactivo" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->activo == 1){ print " checked";} } else {print " checked";} ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Activo</strong>
                    </div>

                    </div>

                </div>
            </div>
            <div  align="center" class="box-footer">
                <div class="form-actions ">
                    <button type="submit" class="btn btn-danger btn-grad no-margin-bottom btnguardarpais">
                    <i class="fa fa-save "></i> Guardar
                </button>
                </div>
            </div>
        </form>
    </div>
</div>