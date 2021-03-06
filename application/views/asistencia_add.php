<style>
    #contenido_ret{
        width: 500px;       
    }   

  
</style>



<script type="text/javascript">


   $(document).ready(function () {

    $("#formasistencia").validationEngine();

    $(".hora").mask("99:99");

    $('#fechaedit').css('z-index', 9999);

    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $('#fechaedit').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fechaedit').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });  

    $(document).on('change', '#fechaedit', function(){
      var fecha = $(this).val();
      var emp = $("#cmb_empleado").val();
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Asistencia/verifica_asistencia');?>",
        data: {emp: emp, fecha: fecha},
        success: function(json) {
          if (json){
            alert("entro");
            $("#txt_id").val(json.id);
            $("#entrada_trabajo").val(json.entrada_trabajo);
            $("#salida_trabajo").val(json.salida_trabajo);
            $("#salida_almuerzo").val(json.salida_almuerzo);
            $("#entrada_almuerzo").val(json.entrada_almuerzo);
          }
        }
      });
    });  

  });     

</script>
<div id = "contenido_ret" class="col-md-6">
    <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"></i> Datos de Asistencia</h3>
        </div>
        <form id="formasistencia" name="formasistencia" method='POST' action="<?=base_url();?>Asistencia/guardar">
            <div class="box-body">
                <div class="row">
                    <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                        if(@$obj != NULL){ ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="<?php if($obj != NULL){ print $obj->id; }?>" >    
                        <?php } else { ?>
                            <input type="hidden" id="txt_id" name="txt_id" value="0">    
                    <?php } ?>  

                    <div class="form-group col-md-7">
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

                    <div class="form-group col-md-5" >
                      <label class="control-label">Fecha</label>
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" class="form-control pull-right validate[required]" id="fechaedit" name="fechaedit" value="<?php if (@$fecha != NULL) { print @$fecha;} else { print date("d/m/Y"); } ?>">
                      </div>
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
                    <button type="submit" class="btn btn-success btn-grad no-margin-bottom ">
                    <i class="fa fa-save "></i> Guardar
                </button>
                </div>
            </div>
        </form>
    </div>
</div>