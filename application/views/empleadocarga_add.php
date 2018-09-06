<style>
    #contenido_ret{
        width: 600px;
    }   
</style>
<script type="text/javascript">
    $("#formcarga").validationEngine();


    /* BUSQUEDA DINAMICA POR CEDULA */
    $('#txt_ident_fam00').blur(function(){
      var ident = $(this).val();    
      var id = $("#txt_id_fam").val();    

      if (ident === ""){
        alert("Debe ingresar un numero de identificación");
        return false;
      }   
      /* ruc / cedula valido*/
      var idtp = $('#cmb_tipoident_fam option:selected').attr('name');      
      $.ajax({
          type: "POST",
          dataType: "json",
          url: base_url + "Utiles/validarIdentificacion",
          data: { tipo: idtp, identificacion: ident },
          success: function(json) {
            if (json.resu == 1){
              $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: base_url + "Empleado/existeIdentificacionCarga",
                  data: { id: id, identificacion: ident },
                  success: function(json) {
                    if (json.resu != 0){
                        alert("El numero de identificación ya esta registrado para otro familiar");
                        $('#txt_ident_fam').focus();
                        return false;
                    } 
                  }
              });
            } else {
                alert("El numero de identificación no es valido");
                $('#txt_ident_fam').focus();
                return false;
              } 
          }
      });
    });

    $('#fechanac_fam').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fechanac_fam').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    $('#fechafall_fam').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fechafall_fam').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

</script>
<div id = "contenido_ret" class="col-md-6">
    <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"></i> Datos del Familiar</h3>
        </div>
        <form id="formcarga" name="formcarga" method='POST' action="#" onSubmit='return false' >
          <div class="box-body">
            <div class="row">
                <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                    if(@$obj != NULL){ ?>
                        <input type="hidden" id="txt_id_fam" name="txt_id_fam" value="<?php if($obj != NULL){ print $obj->id; }?>" >    
                    <?php } else { ?>
                        <input type="hidden" id="txt_id_fam" name="txt_id_fam" value="0">    
                <?php } ?>  

                <div class="form-group col-md-5">
                    <label for="lb_cat">Apellidos</label>
                    <input type="text" class="form-control validate[required]" name="txt_apellidos_fam" id="txt_apellidos_fam" placeholder="Apellidos" value="<?php if(@$obj != NULL){ print @$obj->apellidos_familiar; }?>" >
                </div>

                <div class="form-group col-md-5" >
                    <label for="lb_cat">Nombres</label>
                    <input type="text" class="form-control validate[required]" name="txt_nombres_fam" id="txt_nombres_fam" placeholder="Nombres" value="<?php if(@$obj != NULL){ print @$obj->nombres_familiar; }?>" >
                </div>

                <div class="form-group col-md-2" style="padding-left:0px;padding-right:0px;margin-left:0px;margin-right:0px;">
                  <label for="lb_res">Sexo</label>
                  <select id="cmb_sexo_fam" name="cmb_sexo_fam" class="form-control">
                  <?php 
                    if(@$sexo != NULL){ ?>
                    <?php } else { ?>
                    <option  value="" selected="TRUE">Seleccione Sexo...</option>
                    <?php } 
                      if (count($sexo) > 0) {
                        foreach ($sexo as $tipo):
                            if(@$obj->sexo != NULL){
                                if($obj->sexo == $tipo->id){ ?>
                                     <option value="<?php  print $tipo->id; ?>" selected="TRUE"> <?php  print $tipo->sexo; ?> </option>
                                    <?php
                                }else{ ?>
                                    <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->sexo; ?> </option>
                                    <?php
                                }
                            }else{ ?>
                                <option value="<?php  print $tipo->id; ?>" > <?php  print $tipo->sexo; ?> </option>
                                <?php
                                }   ?>
                            <?php
                        endforeach;
                      }
                    ?>
                  </select>                                  
                </div>

                <div class="form-group col-md-4">
                    <label for="lb_cat">Identificacion</label>
                    <input type="text" class="form-control validate[required]" name="txt_ident_fam" id="txt_ident_fam" placeholder="Identificacion" value="<?php if(@$obj != NULL){ print @$obj->nro_ident; }?>" >
                </div>

                <div style="" class="form-group col-md-4">
                  <label for="lb_res">Parentesco</label>
                  <select class="form-control validate[required]" id="cmb_parentesco_fam" name="cmb_parentesco_fam">
                      <?php 
                        if(@$parentesco != NULL){ ?>
                          <option  value="0" selected="TRUE">Seleccione...</option>
                      <?php }  
                                if (count($parentesco) > 0) {
                                  foreach ($parentesco as $pe):
                                      if(@$obj->tipo_parentesco != NULL){
                                          if($pe->id == $obj->tipo_parentesco){ ?>
                                              <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->parentesco ?></option> 
                                              <?php
                                          }else{ ?>
                                              <option value="<?php  print $pe->id; ?>"> <?php  print $pe->parentesco ?> </option>
                                              <?php
                                          }
                                      }else{ ?>
                                          <option value="<?php  print $pe->id; ?>"> <?php  print $pe->parentesco ?> </option>
                                          <?php
                                          }   ?>
                                      <?php

                                  endforeach;
                                }
                                ?>
                  </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="lb_cat">Telefonos</label>
                    <input type="text" class="form-control " name="txt_telefono_fam" id="txt_telefono_fam" placeholder="Telefono" value="<?php if(@$obj != NULL){ print @$obj->telf_familiar; }?>" >
                </div>

                <div class="form-group col-md-5">
                    <label for="lb_cat">Fecha Nacimiento</label>
                    <input type="text" class="form-control " name="fechanac_fam" id="fechanac_fam" placeholder="Fecha Nacimiento" value="<?php if(@$obj != NULL){ print @$obj->fecha_nacimiento; }?>" >
                </div>

                <div class="form-group col-md-5">
                    <label for="lb_cat">Fecha Fallecimiento</label>
                    <input type="text" class="form-control " name="fechafall_fam" id="fechafall_fam" placeholder="Fecha Fallecimiento" value="<?php if(@$obj != NULL){ print @$obj->fecha_fallece; }?>" >
                </div>

                <div class="form-group col-md-2 text-center" style="padding-left:0px;">
                    <input id="chkactivo_fam" name="chkactivo_fam" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->activo == 1){ print " checked";} } else {print " checked";} ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Activo</strong>
                </div>

            </div>
          </div>
          <div  align="center" class="box-footer">
              <div class="form-actions ">
                  <button type="submit" class="btn btn-success btn-grad no-margin-bottom btnguardarcarga">
                  <i class="fa fa-save "></i> Guardar carga familiar
              </button>
              </div>
          </div>
        </form>
    </div>
</div>