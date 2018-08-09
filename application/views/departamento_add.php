<style>
    #contenido_ret{
        width: 500px;
    }   
</style>
<script type="text/javascript">
    $("#formRET").validationEngine();

</script>
<div id = "contenido_ret" class="col-md-6">
    <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"></i> Datos del Departamento</h3>
        </div>
        <form id="formRET" name="formRET" method='POST' action="#" onSubmit='return false' >
            <div class="box-body">
                <div class="row">
                    <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                        if(@$obj != NULL){ ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="<?php if($obj != NULL){ print $obj->id; }?>" >    
                        <?php } else { ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="0">    
                    <?php } ?>  

                    <div class="form-group col-md-12">
                        <label for="lb_cat">Nombre del Departamento</label>
                        <input type="text" class="form-control validate[required]" name="txt_nombre" id="txt_nombre" placeholder="Nombre del Departamento" value="<?php if(@$obj != NULL){ print @$obj->nombre_departamento; }?>" >
                    </div>

                    <!-- Jefe -->
                    <div style="" class="form-group col-md-12">
                      <label for="lb_res">Nombre del Jefe</label>
                      <select id="cmb_empleado" name="cmb_empleado" class="form-control">
                      <?php 
                        $jefe = NULL;
                        if ($obj) { $jefe  = $obj->id_jefedepartamento; }
                        if((@$jefe != NULL) && (@$jefe != 0)){ ?>
                        <?php } else { ?>
                        <option  value="" selected="TRUE">Seleccione Jefe del Departamento...</option>
                        <?php } 
                          if (count($empleados) > 0) {
                            foreach ($empleados as $emp):
                                if(@$emp->id_empleado != NULL){
                                    if($obj->id_jefedepartamento == $emp->id_empleado){ ?>
                                         <option value="<?php  print $emp->id_empleado; ?>" selected="TRUE"> <?php  print $emp->nombre_empleado; ?> </option>
                                        <?php
                                    }else{ ?>
                                        <option value="<?php  print $emp->id_empleado; ?>" > <?php  print $emp->nombre_empleado; ?> </option>
                                        <?php
                                    }
                                }else{ ?>
                                    <option value="<?php  print $emp->id_empleado; ?>" > <?php  print $emp->nombre_empleado; ?> </option>
                                    <?php
                                    }   ?>
                                <?php
                            endforeach;
                          }
                        ?>
                      </select>                                  
                    </div>

                    <div class="form-group col-md-6">
                        <input id="chkactivodpto" name="chkactivodpto" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->activo == 1){ print " checked";} }  ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Activo</strong>
                    </div>

                    </div>

                </div>
            </div>
            <div  align="center" class="box-footer">
                <div class="form-actions ">
                    <button type="submit" class="btn btn-danger btn-grad no-margin-bottom btnguardardpto">
                    <i class="fa fa-save "></i> Guardar
                </button>
                </div>
            </div>
        </form>
    </div>
</div>