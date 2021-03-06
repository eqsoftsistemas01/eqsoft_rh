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
          <h3 class="box-title"></i> Datos de Ciudad</h3>
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
                        <label for="lb_cat">Nombre de Ciudad</label>
                        <input type="text" class="form-control validate[required]" name="txt_nombre" id="txt_nombre" placeholder="Nombre de Ciudad" value="<?php if(@$obj != NULL){ print @$obj->nombre_ciudad; }?>" >
                    </div>

                    <div class="form-group col-md-12">
                      <label for="lb_res">Provincia</label>
                      <select id="cmb_provincia" name="cmb_provincia" class="form-control">
                      <?php 
                        if(@$provincia != NULL){ ?>
                        <?php } else { ?>
                        <option  value="" selected="TRUE">Seleccione...</option>
                        <?php } 
                          if (count($provincia) > 0) {
                            foreach ($provincia as $tipo):
                                if(@$obj->id_provincia != NULL){
                                    if($obj->id_provincia == $tipo->id){ ?>
                                         <option value="<?php  print $tipo->id; ?>" selected="TRUE"> <?php  print $tipo->nombre_provincia; ?> </option>
                                        <?php
                                    }else{ ?>
                                        <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->nombre_provincia; ?> </option>
                                        <?php
                                    }
                                }else{ ?>
                                    <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->nombre_provincia; ?> </option>
                                    <?php
                                    }   ?>
                                <?php
                            endforeach;
                          }
                        ?>
                      </select>                                  
                    </div>
                   

                    <div class="form-group col-md-6">
                        <input id="chkactivo" name="chkactivo" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->activo == 1){ print " checked";} } else {print " checked";} ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Activo</strong>
                    </div>

                    </div>

                </div>
            </div>
            <div  align="center" class="box-footer">
                <div class="form-actions ">
                    <button type="submit" class="btn btn-success btn-grad no-margin-bottom btnguardarciudad">
                    <i class="fa fa-save "></i> Guardar Ciudad
                </button>
                </div>
            </div>
        </form>
    </div>
</div>