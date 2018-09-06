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
          <h3 class="box-title"></i> Datos de Empresa</h3>
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
                        <label for="lb_cat">Nombre de Empresa</label>
                        <input type="text" class="form-control validate[required]" name="txt_nombre" id="txt_nombre" placeholder="Nombre de empresa" value="<?php if(@$obj != NULL){ print @$obj->nombre_empresa; }?>" >
                    </div>

                    <div class="form-group col-md-12">
                        <label for="lb_cat">RUC de Empresa</label>
                        <input type="text" class="form-control validate[required]" name="txt_ruc" id="txt_ruc" placeholder="RUC de empresa" value="<?php if(@$obj != NULL){ print @$obj->ruc_empresa; }?>" >
                    </div>

                    <div class="form-group col-md-12">
                        <label for="lb_cat">Representante</label>
                        <input type="text" class="form-control validate[required]" name="txt_representante" id="txt_representante" placeholder="Representante" value="<?php if(@$obj != NULL){ print @$obj->representante_empresa; }?>" >
                    </div>
                    
                    <div class="form-group col-md-6">
                        <input id="chkactivo" name="chkactivo" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->activo == 1){ print " checked";} } else {print " checked";} ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Activo</strong>
                    </div>

                    </div>

                </div>
            </div>
            <div  align="center" class="box-footer">
                <div class="form-actions ">
                    <button type="submit" class="btn btn-success btn-grad no-margin-bottom btnguardarempresa">
                    <i class="fa fa-save "></i> Guardar
                </button>
                </div>
            </div>
        </form>
    </div>
</div>