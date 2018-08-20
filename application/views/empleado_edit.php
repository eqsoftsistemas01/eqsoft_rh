<?php
/* ------------------------------------------------
  ARCHIVO: parametros.php
  DESCRIPCION: Contiene la vista principal del módulo de parametros.
  FECHA DE CREACIÓN: 05/07/2017
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
print "<script>document.title = 'ProdegelRRHH - Datos de Empleado'</script>";
date_default_timezone_set("America/Guayaquil");
?>

<style type="text/css">
  
.linea{
  border-width: 2px 0 0;
  margin-bottom: 3px;
  margin-top: 5px;
  border-color: currentcolor currentcolor;
} 


</style>

<script>


  $( document ).ready(function() {

    $("#frm_emp").validationEngine();

    $('#fechanac').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fechanac').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    $('#fechaingreso').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fechaingreso').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    $('#fechasalida').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fechasalida').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
    
    $('#TableRubroEmpleado').dataTable({
      "language":{  "lengthMenu":"Mostrar _MENU_ registros por página.",
                    "zeroRecords": "Lo sentimos. No se encontraron registros.",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros aún.",
                    "infoFiltered": "(filtrados de un total de _MAX_ registros)",
                    "search" : "Búsqueda",
                    "LoadingRecords": "Cargando ...",
                    "Processing": "Procesando...",
                    "SearchPlaceholder": "Comience a teclear...",
                    "paginate": { "previous": "Anterior", "next": "Siguiente", }
                    },
        'ajax': "listadoRubroEmpleado",
        'columns': [
            {"data": "ver"},                            
            {"data": "codigo"},
            {"data": "descripcion"},
            {"data": "valor"}   
        ]
    });

    $('#TableCargaFamiliar').dataTable({
      "language":{  "lengthMenu":"Mostrar _MENU_ registros por página.",
                    "zeroRecords": "Lo sentimos. No se encontraron registros.",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros aún.",
                    "infoFiltered": "(filtrados de un total de _MAX_ registros)",
                    "search" : "Búsqueda",
                    "LoadingRecords": "Cargando ...",
                    "Processing": "Procesando...",
                    "SearchPlaceholder": "Comience a teclear...",
                    "paginate": { "previous": "Anterior", "next": "Siguiente", }
                    },
        'ajax': "listadoCargaFamiliar",
        'columns': [
            {"data": "apellido"},
            {"data": "nombre"},
            {"data": "identificacion"},   
            {"data": "parentesco"},   
            {"data": "telefono"},   
            {"data": "fechanac"},   
            {"data": "sexo"},   
            {"data": "ver"}                            
        ]
    });

    $(document).on('click', '.add_carga', function(){
      $.fancybox.open({
        type: "ajax",
        width: 550,
        height: 550,
        ajax: {
           dataType: "html",
           type: "POST"
        },
        href: "<?php echo base_url('Empleado/add_cargafamiliar');?>"
      });
    });

    $(document).on('click', '.carga_ver', function(){
        id = $(this).attr('id');
        $.ajax({
          type: "POST",
          dataType: "json",
          url: "<?php echo base_url('Empleado/tmp_carga');?>",
          data: {id: id},
          success: function(json) {
            $.fancybox.open({
              type: "ajax",
              width: 550,
              height: 550,
              ajax: {
                 dataType: "html",
                 type: "POST"
              },
              href: "<?php echo base_url('Empleado/edit_cargafamiliar');?>"
            });
          }
        });


    });

    $(document).on('click','.btnguardarcarga', function() {
        id = $('#txt_id_fam').val();
        apellidos = $('#txt_apellidos_fam').val();
        nombres = $('#txt_nombres_fam').val();
        activo = $('#chkactivo_fam').val();
        if(activo == 'on'){ activo = 1; } else { activo = 0; }
        ident = $('#txt_ident_fam').val();
        parentesco = $('#cmb_parentesco_fam').val();
        telefono = $('#txt_telefono_fam').val();
        fechanac = $('#fechanac_fam').val();
        fechafall = $('#fechafall_fam').val();
        sexo = $('#cmb_sexo_fam').val();

        $.ajax({
          url: base_url + "Empleado/guardar_carga",
          data: { id: id, apellidos: apellidos, nombres: nombres, activo: activo, ident: ident, sexo: sexo,
                  parentesco: parentesco, telefono: telefono, fechanac: fechanac, fechafall: fechafall },
          type: 'POST',
          dataType: 'json',
          success: function(json) {
            $.fancybox.close();
            $('#TableCargaFamiliar').DataTable().ajax.reload();
          }
        });
    });

    $(document).on('change','#cmb_tipodiscapacidad', function(){
        actualiza_p100discapacidad();
    });   

    function actualiza_p100discapacidad(){
        var estado = $('#cmb_tipodiscapacidad').val();
        if (!estado) { estado = 0; }
        estado = estado * 1;
        if (estado > 0) {
          $("#txt_p100discapacidad").attr("disabled", false);
        } else {
          $("#txt_p100discapacidad").attr("disabled", true);
          $("#txt_p100discapacidad").val("0");
        }
    }  

    $(document).on('click', '.btnaddcontrato', function(){
      $(".seccioncontrato").show();
      $("#txt_idcontrato").val('0');
      $(".btnaddcontrato").hide();
    });

    function actualiza_estado_fechasalida(){
        if($("#chkfechasalida").is(":checked")){ 
          $('#fechasalida').attr('disabled',false); 
        } 
        else{ 
          $('#fechasalida').attr('disabled',true); 
        }  
    }      

    $(document).on('click', '#chkfechasalida', function(){
      actualiza_estado_fechasalida();
    });

    $(document).on('click', '.chk_rubro', function(){
      var id = this.id;
      var existe = 1;
      if ($('.chk_rubro[id='+id+']').is(":checked") == false){
        $('.valor_rubro[id='+id+']').val('0.00');
        $('.valor_rubro[id='+id+']').attr('disabled',true); 
        existe = 0;
      }
      else {
        if ($('.chk_rubro[id='+id+']').name() == 1){
          $('.valor_rubro[id='+id+']').attr('disabled',false); 
        }
      }
      var valor = $('.valor_rubro[id='+id+']').val();

      $.ajax({
        url: base_url + "Empleado/actualiza_rubroempleado",
        data: { id: id, existe: existe, valor: valor },
        type: 'POST',
        dataType: 'json',
        success: function(json) {
        }
      });
    });

    $(document).on('blur', '.valor_rubro', function(){
      var id = this.id;
      var existe = 1;
      var valor = $('.valor_rubro[id='+id+']').val();

      $.ajax({
        url: base_url + "Empleado/actualiza_rubroempleado",
        data: { id: id, existe: existe, valor: valor },
        type: 'POST',
        dataType: 'json',
        success: function(json) {
        }
      });
    });

    actualiza_estado_fechasalida();

  });

</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <i class="fa fa-fort-awesome"></i> Datos de Empleado </a></li>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>empleado">Empleados</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

        <div class="box-header with-border">

          <form id="frm_emp" name="frm_emp" method="post" role="form" class="form" action="<?php echo base_url('Empleado/guardar');?>">
              <div class="box-body">

                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                   <li class="active"><a href="#tabpersonal" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> DATOS PERSONALES</a></li>                            
                   <li ><a href="#tabgeneral" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> DATOS GENERALES</a></li>                            
                   <li ><a href="#tabrubro" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> RUBROS</a></li>                            
                   <li ><a href="#tabcargafamiliar" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> CARGAS FAMILIARES</a></li>                            
                  </ul>

                  <div class="tab-content">
                    <div class="tab-pane active" id="tabpersonal">
                    
                      <div class="box box-danger">
                      
                      <div class="box-header with-border">

                        <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                            if(@$obj != NULL){ ?>
                                <input type="hidden" id="txt_id" name="txt_id" value="<?php if($obj != NULL){ print $obj->id_empleado; }?>" >    
                            <?php } else { ?>
                                <input type="hidden" id="txt_id" name="txt_id" value="0">    
                        <?php } ?>  

                        <div class="col-md-12">

                        <div class="form-group col-md-4">
                            <label for="lb_cat">Apellidos</label>
                            <input type="text" class="form-control validate[required]" name="txt_apellido" id="txt_apellido" placeholder="Apellidos" value="<?php if(@$obj != NULL){ print @$obj->apellidos; }?>" >
                        </div>

                        <div class="form-group col-md-4">
                            <label for="lb_cat">Nombres</label>
                            <input type="text" class="form-control validate[required]" name="txt_nombre" id="txt_nombre" placeholder="Nombres" value="<?php if(@$obj != NULL){ print @$obj->nombres; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                          <label for="lb_res">Sexo</label>
                          <select id="cmb_sexo" name="cmb_sexo" class="form-control">
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

                        <div class="form-group col-md-2 text-center">
                            <input id="chkactivo" name="chkactivo" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->activo == 1){ print " checked";} } else {print " checked";} ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Activo</strong>
                        </div>

                        </div>

                        <div style="" class="form-group col-md-2">
                          <label for="lb_res">Tipo Identificacion</label>
                          <select id="cmb_tipoident" name="cmb_tipoident" class="form-control">
                          <?php 
                            if(@$tipoident != NULL){ ?>
                            <?php } else { ?>
                            <option  value="" selected="TRUE">Seleccione Tipo Identificacion...</option>
                            <?php } 
                              if (count($tipoident) > 0) {
                                foreach ($tipoident as $tipo):
                                    if(@$obj->tipo_identificacion != NULL){
                                        if($obj->tipo_identificacion == $tipo->id_identificacion){ ?>
                                             <option name="<?php  print $tipo->cod_identificacion; ?>" value="<?php  print $tipo->id_identificacion; ?>" selected="TRUE"> <?php  print $tipo->desc_identificacion; ?> </option>
                                            <?php
                                        }else{ ?>
                                            <option name="<?php  print $tipo->cod_identificacion; ?>" value="<?php  print $tipo->id_identificacion; ?>" > <?php  print $tipo->desc_identificacion; ?> </option>
                                            <?php
                                        }
                                    }else{ ?>
                                        <option name="<?php  print $tipo->cod_identificacion; ?>" value="<?php  print $tipo->id_identificacion; ?>" > <?php  print $tipo->desc_identificacion; ?> </option>
                                        <?php
                                        }   ?>
                                    <?php
                                endforeach;
                              }
                            ?>
                          </select>                                  
                        </div>

                        <div class="form-group col-md-3">
                            <label for="lb_cat">Identificacion</label>
                            <input type="text" class="form-control validate[required]" name="txt_ident" id="txt_ident" placeholder="Identificacion" value="<?php if(@$obj != NULL){ print @$obj->nro_ident; }?>" >
                        </div>

                        <div class="form-group col-md-3">
                            <label for="lb_cat">Lugar Expedicion</label>
                            <input type="text" class="form-control" name="txt_lugarexpedicion" id="txt_lugarexpedicion" placeholder="Lugar Expedicion" value="<?php if(@$obj != NULL){ print @$obj->lugarexpedicion; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Pasaporte</label>
                            <input type="text" class="form-control" name="txt_pasaporte" id="txt_pasaporte" placeholder="Pasaporte" value="<?php if(@$obj != NULL){ print @$obj->pasaporte; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Cedula Militar</label>
                            <input type="text" class="form-control" name="txt_cedulamilitar" id="txt_cedulamilitar" placeholder="Cedula Militar" value="<?php if(@$obj != NULL){ print @$obj->cedulamilitar; }?>" >
                        </div>
                        <div class="form-group col-md-2">
                            <label for="lb_cat">Profesión</label>
                            <input type="text" class="form-control" name="txt_profesion" id="txt_profesion" placeholder="Profesión" value="<?php if(@$obj != NULL){ print @$obj->profesion; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Calle Principal</label>
                            <input type="text" class="form-control " name="txt_calleprincipal" id="txt_calleprincipal" placeholder="Calle Principal" value="<?php if(@$obj != NULL){ print @$obj->calleprincipal; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Numero Vivienda</label>
                            <input type="text" class="form-control " name="txt_numerovivienda" id="txt_numerovivienda" placeholder="Numero Vivienda" value="<?php if(@$obj != NULL){ print @$obj->numerovivienda; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Calle Transversal</label>
                            <input type="text" class="form-control " name="txt_calletransversal" id="txt_calletransversal" placeholder="Calle Transversal" value="<?php if(@$obj != NULL){ print @$obj->calletransversal; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Sector</label>
                            <input type="text" class="form-control " name="txt_sector" id="txt_sector" placeholder="Sector" value="<?php if(@$obj != NULL){ print @$obj->sector; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Referencia</label>
                            <input type="text" class="form-control " name="txt_referenciavivienda" id="txt_referenciavivienda" placeholder="Referencia" value="<?php if(@$obj != NULL){ print @$obj->referenciavivienda; }?>" >
                        </div>

                        <div style="" class="form-group col-md-2">
                          <label for="lb_res">Tipo Vivienda</label>
                          <select class="form-control" id="cmb_tipovivienda" name="cmb_tipovivienda">
                              <?php 
                                if(@$tipovivienda != NULL){ ?>
                                  <option  value="0" selected="TRUE">Seleccione...</option>
                              <?php }  
                                        if (count($tipovivienda) > 0) {
                                          foreach ($tipovivienda as $pe):
                                              if(@$obj->id_tipovivienda != NULL){
                                                  if($pe->id == $obj->id_tipovivienda){ ?>
                                                      <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->tipovivienda ?></option> 
                                                      <?php
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipovivienda ?> </option>
                                                      <?php
                                                  }
                                              }else{ ?>
                                                  <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipovivienda ?> </option>
                                                  <?php
                                                  }   ?>
                                              <?php

                                          endforeach;
                                        }
                                        ?>
                          </select>
                        </div>

                        <div style="" class="form-group col-md-2">
                          <label for="lb_res">Ciudad</label>
                          <select class="form-control" id="cmb_ciudad" name="cmb_ciudad">
                              <?php 
                                if(@$ciudad != NULL){ ?>
                                  <option  value="0" selected="TRUE">Seleccione...</option>
                              <?php }  
                                        if (count($ciudad) > 0) {
                                          foreach ($ciudad as $pe):
                                              if(@$obj->id_ciudad != NULL){
                                                  if($pe->id == $obj->id_ciudad){ ?>
                                                      <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->nombre_ciudad ?></option> 
                                                      <?php
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_ciudad ?> </option>
                                                      <?php
                                                  }
                                              }else{ ?>
                                                  <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_ciudad ?> </option>
                                                  <?php
                                                  }   ?>
                                              <?php

                                          endforeach;
                                        }
                                        ?>
                          </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Telefono</label>
                            <input type="text" class="form-control " name="txt_telefono" id="txt_telefono" placeholder="Telefono" value="<?php if(@$obj != NULL){ print @$obj->telf_empleado; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Celular</label>
                            <input type="text" class="form-control " name="txt_celular" id="txt_celular" placeholder="Celular" value="<?php if(@$obj != NULL){ print @$obj->celular_empleado; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Correo</label>
                            <input type="text" class="form-control " name="txt_correo" id="txt_correo" placeholder="Correo" value="<?php if(@$obj != NULL){ print @$obj->correo_empleado; }?>" >
                        </div>

                        <div style="" class="form-group col-md-2">
                          <label for="lb_res">Tipo Sangre</label>
                          <select class="form-control" id="cmb_tiposangre" name="cmb_tiposangre">
                              <?php 
                                if(@$tiposangre != NULL){ ?>
                                  <option  value="0" selected="TRUE">Seleccione...</option>
                              <?php }  
                                        if (count($tiposangre) > 0) {
                                          foreach ($tiposangre as $pe):
                                              if(@$obj->id_tiposangre != NULL){
                                                  if($pe->id == $obj->id_tiposangre){ ?>
                                                      <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->tiposangre ?></option> 
                                                      <?php
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tiposangre ?> </option>
                                                      <?php
                                                  }
                                              }else{ ?>
                                                  <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tiposangre ?> </option>
                                                  <?php
                                                  }   ?>
                                              <?php

                                          endforeach;
                                        }
                                        ?>
                          </select>
                        </div>

                        <div style="" class="form-group col-md-2">
                          <label for="lb_res">Estado Civil</label>
                          <select class="form-control" id="cmb_estadocivil" name="cmb_estadocivil">
                              <?php 
                                if(@$estadocivil != NULL){ ?>
                                  <option  value="0" selected="TRUE">Seleccione...</option>
                              <?php }  
                                        if (count($estadocivil) > 0) {
                                          foreach ($estadocivil as $pe):
                                              if(@$obj->id_estadocivil != NULL){
                                                  if($pe->id == $obj->id_estadocivil){ ?>
                                                      <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->estadocivil ?></option> 
                                                      <?php
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->estadocivil ?> </option>
                                                      <?php
                                                  }
                                              }else{ ?>
                                                  <option value="<?php  print $pe->id; ?>"> <?php  print $pe->estadocivil ?> </option>
                                                  <?php
                                                  }   ?>
                                              <?php

                                          endforeach;
                                        }
                                        ?>
                          </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Fecha Nacimiento</label>
                            <input type="text" class="form-control " name="fechanac" id="fechanac" placeholder="Fecha Nacimiento" value="<?php if(@$obj != NULL){ @$fec = str_replace('-', '/', @$obj->fecha_nacimiento); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec; } ?>" >
                        </div>                       

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Peso</label>
                            <input type="text" class="form-control " name="txt_peso" id="txt_peso" placeholder="Peso" value="<?php if(@$obj != NULL){ print @$obj->peso; }?>" >
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">Talla</label>
                            <input type="text" class="form-control " name="txt_talla" id="txt_talla" placeholder="Talla" value="<?php if(@$obj != NULL){ print @$obj->talla; }?>" >
                        </div>

                        <div style="" class="form-group col-md-2">
                          <label for="lb_res">Tipo Discapacidad</label>
                          <select class="form-control" id="cmb_tipodiscapacidad" name="cmb_tipodiscapacidad">
                              <?php 
                                if(@$tipodiscapacidad != NULL){ ?>
                                  <option  value="0" selected="TRUE">Seleccione...</option>
                              <?php }  
                                        if (count($tipodiscapacidad) > 0) {
                                          foreach ($tipodiscapacidad as $pe):
                                              if(@$obj->id_tipodiscapacidad != NULL){
                                                  if($pe->id == $obj->id_tipodiscapacidad){ ?>
                                                      <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->tipodiscapacidad ?></option> 
                                                      <?php
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipodiscapacidad ?> </option>
                                                      <?php
                                                  }
                                              }else{ ?>
                                                  <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipodiscapacidad ?> </option>
                                                  <?php
                                                  }   ?>
                                              <?php

                                          endforeach;
                                        }
                                        ?>
                          </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="lb_cat">%Discapacidad</label>
                            <input type="text" class="form-control" name="txt_p100discapacidad" id="txt_p100discapacidad" placeholder="%Discapacidad" value="<?php if(@$obj != NULL){ print @$obj->p100discapacidad; }?>" <?php if(@$obj != NULL){ if (@$obj->id_tipodiscapacidad == NULL) {print "disabled";} } else { print "disabled";} ?>>
                        </div>

                        <div class="form-group col-md-2 text-center" style="padding-left: 0px;padding-right: 0px;">
                            <input id="chkvivefamiliar" name="chkvivefamiliar" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->vivefamiliares == 1){ print " checked";} } else {print " checked";} ?> style="margin-top:31px; margin-right:0px; margin-left:0px;" > <strong>Vive con Familiares</strong>
                        </div>

                      </div>
                      
                      </div>


                    </div>  <!-- Tab Personal --> 

                    <div class="tab-pane" id="tabgeneral">

                      <div class="box box-danger">
                      
                        <div class="box-header with-border">

                          <div class="form-group col-md-12">

                            <input type="hidden" id="txt_idcontrato" name="txt_idcontrato" value="<?php if(@$obj != NULL) { if($obj->id_contrato != NULL) { print $obj->id_empleado; } } ?>" >    

                            <spam>
                              <strong>Contrato</strong>  

                            <div class="form-actions pull-right">
                                <button type="button" class="btn btn-info btn-grad btn-xs no-margin-bottom btnaddcontrato" title="Añadir Contrato">
                                    <i class="fa fa-plus-square "></i> Añadir
                                </button>
                            </div>

                            </spam>

                            <hr class="linea">

                            <div class="seccioncontrato" <?php if(@$obj->id_tipocontrato != NULL) { print 'style="display:block"';} else { print 'style="display:none"'; } ?> >

                            <div class="form-group col-md-2">
                                <label for="lb_cat">Fecha Ingreso</label>
                                <input type="text" class="form-control  validate[required]" name="fechaingreso" id="fechaingreso" placeholder="Fecha Ingreso" value="<?php if(@$obj != NULL){ if(@$obj->fecha_ingreso != NULL){ @$fec = str_replace('-', '/', @$obj->fecha_ingreso); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec; }} ?>" >
                            </div>                       

                            <div class="form-group col-md-2">
                              <div class="form-group col-md-12 text-center" style="padding-left: 0px;padding-right: 0px;padding-bottom: 0px;margin-bottom: 3px;">
                                <input id="chkfechasalida" name="chkfechasalida" type="checkbox" <?php if(@$obj != NULL){ if(@$obj->fecha_salida == 1){ print " checked";} } ?> > <strong>Fecha Salida</strong>
                              </div>  
                                <input type="text" class="form-control " name="fechasalida" id="fechasalida" placeholder="Fecha Salida" value="<?php if(@$obj != NULL){ if(@$obj->fecha_salida != NULL){ @$fec = str_replace('-', '/', @$obj->fecha_salida); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec; }} ?>" >
                            </div>                       

                            <div style="" class="form-group col-md-3">
                              <label for="lb_res">Tipo Contrato</label>
                              <select class="form-control  validate[required]" id="cmb_tipocontrato" name="cmb_tipocontrato">
                                  <?php 
                                    if(@$tipocontrato != NULL){ ?>
                                      <option  value="0" selected="TRUE">Seleccione...</option>
                                  <?php }  
                                            if (count($tipocontrato) > 0) {
                                              foreach ($tipocontrato as $pe):
                                                  if(@$obj->id_tipocontrato != NULL){
                                                      if($pe->id == $obj->id_tipocontrato){ ?>
                                                          <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->tipocontrato ?></option> 
                                                          <?php
                                                      }else{ ?>
                                                          <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipocontrato ?> </option>
                                                          <?php
                                                      }
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipocontrato ?> </option>
                                                      <?php
                                                      }   ?>
                                                  <?php

                                              endforeach;
                                            }
                                            ?>
                              </select>
                            </div>

                            <div style="" class="form-group col-md-3">
                              <label for="lb_res">Cargo</label>
                              <select class="form-control  validate[required]" id="cmb_cargo" name="cmb_cargo">
                                  <?php 
                                    if(@$cargo != NULL){ ?>
                                      <option  value="0" selected="TRUE">Seleccione...</option>
                                  <?php }  
                                            if (count($cargo) > 0) {
                                              foreach ($cargo as $pe):
                                                  if(@$obj->id_cargo != NULL){
                                                      if($pe->id == $obj->id_cargo){ ?>
                                                          <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->nombre_cargo ?></option> 
                                                          <?php
                                                      }else{ ?>
                                                          <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_cargo ?> </option>
                                                          <?php
                                                      }
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_cargo ?> </option>
                                                      <?php
                                                      }   ?>
                                                  <?php

                                              endforeach;
                                            }
                                            ?>
                              </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="lb_cat">Sueldo</label>
                                <input type="text" class="form-control  validate[required]" name="txt_sueldo" id="txt_sueldo" placeholder="Sueldo" value="<?php if(@$obj != NULL){ print @$obj->sueldo; }?>" >
                            </div>

                            </div>

                          </div>  

                          <div class="form-group col-md-12">

                            <spam>
                              <strong>Datos de Contacto</strong>  
                            </spam>
                            <hr class="linea">

                            <div class="form-group col-md-4">
                                <label for="lb_cat">Nombres y Apellidos</label>
                                <input type="text" class="form-control " name="txt_nombrecontacto" id="txt_nombrecontacto" placeholder="Nombres y Apellidos" value="<?php if(@$obj != NULL){ print @$obj->nombrecontacto; }?>" >
                            </div>

                            <div style="" class="form-group col-md-2">
                              <label for="lb_res">Parentesco</label>
                              <select class="form-control" id="cmb_parentesco" name="cmb_parentesco">
                                  <?php 
                                    if(@$parentesco != NULL){ ?>
                                      <option  value="0" selected="TRUE">Seleccione...</option>
                                  <?php }  
                                            if (count($parentesco) > 0) {
                                              foreach ($parentesco as $pe):
                                                  if(@$obj->id_parentescocontacto != NULL){
                                                      if($pe->id == $obj->id_parentescocontacto){ ?>
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
                                <label for="lb_cat">Direccion</label>
                                <input type="text" class="form-control " name="txt_direccioncontacto" id="txt_direccioncontacto" placeholder="Direccion" value="<?php if(@$obj != NULL){ print @$obj->direccioncontacto; }?>" >
                            </div>

                            <div class="form-group col-md-2">
                                <label for="lb_cat">Telefonos</label>
                                <input type="text" class="form-control " name="txt_telefonocontacto" id="txt_telefonocontacto" placeholder="Telefonos" value="<?php if(@$obj != NULL){ print @$obj->telefonocontacto; }?>" >
                            </div>
                          </div>  

                          <div class="form-group col-md-12">

                            <spam>
                              <strong>Datos Bancarios</strong>  
                            </spam>
                            <hr class="linea">

                            <div style="" class="form-group col-md-4">
                              <label for="lb_res">Banco</label>
                              <select class="form-control" id="cmb_banco" name="cmb_banco">
                                  <?php 
                                    if(@$banco != NULL){ ?>
                                      <option  value="0" selected="TRUE">Seleccione...</option>
                                  <?php }  
                                            if (count($banco) > 0) {
                                              foreach ($banco as $pe):
                                                  if(@$obj->id_banco != NULL){
                                                      if($pe->id == $obj->id_banco){ ?>
                                                          <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->nombre_banco ?></option> 
                                                          <?php
                                                      }else{ ?>
                                                          <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_banco ?> </option>
                                                          <?php
                                                      }
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_banco ?> </option>
                                                      <?php
                                                      }   ?>
                                                  <?php

                                              endforeach;
                                            }
                                            ?>
                              </select>
                            </div>

                            <div style="" class="form-group col-md-4">
                              <label for="lb_res">Tipo Cuenta</label>
                              <select class="form-control" id="cmb_tipocuenta" name="cmb_tipocuenta">
                                  <?php 
                                    if(@$tipocuenta != NULL){ ?>
                                      <option  value="0" selected="TRUE">Seleccione...</option>
                                  <?php }  
                                            if (count($tipocuenta) > 0) {
                                              foreach ($tipocuenta as $pe):
                                                  if(@$obj->id_tipocuenta != NULL){
                                                      if($pe->id == $obj->id_tipocuenta){ ?>
                                                          <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->tipocuentabanco ?></option> 
                                                          <?php
                                                      }else{ ?>
                                                          <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipocuentabanco ?> </option>
                                                          <?php
                                                      }
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->tipocuentabanco ?> </option>
                                                      <?php
                                                      }   ?>
                                                  <?php

                                              endforeach;
                                            }
                                            ?>
                              </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="lb_cat">Numero Cuenta</label>
                                <input type="text" class="form-control " name="txt_numerocuenta" id="txt_numerocuenta" placeholder="Numero Cuenta" value="<?php if(@$obj != NULL){ print @$obj->numerocuenta; }?>" >
                            </div>
                          </div>  

                          <div class="form-group col-md-12">

                            <spam>
                              <strong>Otros</strong>  
                            </spam>
                            <hr class="linea">

                            <div style="" class="form-group col-md-3">
                              <label for="lb_res">Perfil de Usuario</label>
                              <select class="form-control validate[required]" id="cmb_perfil" name="cmb_perfil">
                                  <?php 
                                    if(@$perfil != NULL){ ?>
                                      <option  value="0" selected="TRUE">Seleccione...</option>
                                  <?php }  
                                            if (count($perfil) > 0) {
                                              foreach ($perfil as $pe):
                                                  if(@$obj->perfil != NULL){
                                                      if($pe->id_perfil == $obj->perfil){ ?>
                                                          <option  value="<?php  print $pe->id_perfil; ?>" selected="TRUE"><?php print $pe->nom_perfil ?></option> 
                                                          <?php
                                                      }else{ ?>
                                                          <option value="<?php  print $pe->id_perfil; ?>"> <?php  print $pe->nom_perfil ?> </option>
                                                          <?php
                                                      }
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id_perfil; ?>"> <?php  print $pe->nom_perfil ?> </option>
                                                      <?php
                                                      }   ?>
                                                  <?php

                                              endforeach;
                                            }
                                            ?>
                              </select>
                            </div>

                            <div style="" class="form-group col-md-3">
                              <label for="lb_res">Departamento</label>
                              <select class="form-control" id="cmb_departamento" name="cmb_departamento">
                                  <?php 
                                    if(@$departamento != NULL){ ?>
                                      <option  value="0" selected="TRUE">Seleccione...</option>
                                  <?php }  
                                            if (count($departamento) > 0) {
                                              foreach ($departamento as $pe):
                                                  if(@$obj->id_departamento != NULL){
                                                      if($pe->id == $obj->id_departamento){ ?>
                                                          <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->nombre_departamento ?></option> 
                                                          <?php
                                                      }else{ ?>
                                                          <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_departamento ?> </option>
                                                          <?php
                                                      }
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_departamento ?> </option>
                                                      <?php
                                                      }   ?>
                                                  <?php

                                              endforeach;
                                            }
                                            ?>
                              </select>
                            </div>

                            <div style="" class="form-group col-md-3">
                              <label for="lb_res">Empresa</label>
                              <select class="form-control" id="cmb_empresa" name="cmb_empresa">
                                  <?php 
                                    if(@$empresa != NULL){ ?>
                                      <option  value="0" selected="TRUE">Seleccione...</option>
                                  <?php }  
                                            if (count($empresa) > 0) {
                                              foreach ($empresa as $pe):
                                                  if(@$obj->id_empresa != NULL){
                                                      if($pe->id == $obj->id_empresa){ ?>
                                                          <option  value="<?php  print $pe->id; ?>" selected="TRUE"><?php print $pe->nombre_empresa ?></option> 
                                                          <?php
                                                      }else{ ?>
                                                          <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_empresa ?> </option>
                                                          <?php
                                                      }
                                                  }else{ ?>
                                                      <option value="<?php  print $pe->id; ?>"> <?php  print $pe->nombre_empresa ?> </option>
                                                      <?php
                                                      }   ?>
                                                  <?php

                                              endforeach;
                                            }
                                            ?>
                              </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="lb_cat">Codigo Reloj</label>
                                <input type="text" class="form-control " name="txt_codigoreloj" id="txt_codigoreloj" placeholder="Codigo Reloj" value="<?php if(@$obj != NULL){ print @$obj->codigoreloj; }?>" >
                            </div>
                          </div>  
          
                        </div>  

                      </div>  

                    </div>  <!-- Tab General --> 

                    <div class="tab-pane" id="tabrubro">
                         <div class="box box-danger">
                      
                            <div class="box-header with-border">

                                <div class="form-group col-md-12">
              

                                </div>
                            </div>
                         </div>

                         <div class="row">
                            <div class="col-xs-12">
                                <div class="box-body table-responsive">
                                  <table id="TableRubroEmpleado" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                      <tr >
                                        <th>Habilitado</th>
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                        <th>Valor</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                          </div>                      

                    </div>  <!-- tabadicional --> 

                    <div class="tab-pane" id="tabcargafamiliar">

                      <div class="box box-danger">
                      
                        <div class="box-header with-border">

                          <div class="pull-right">
                              <button type="button" class="btn btn-info btn-grad add_carga">
                                  <i class="fa fa-plus-square"></i> Añadir
                              </button>
                          </div>

                          <div class="row">
                            <div class="col-xs-12">
                                <div class="box-body table-responsive">
                                  <table id="TableCargaFamiliar" class="table table-bordered table-striped table-responsive">
                                    <thead>
                                      <tr >
                                        <th>Apellidos</th>
                                        <th>Nombres</th>
                                        <th>Identificacion</th>
                                        <th>Parentesco</th>
                                        <th>Telefono</th>
                                        <th>Fecha Nac.</th>
                                        <th>Sexo</th>
                                        <th>Accion</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                          </div>                      

                        </div>
                      </div>    
                    </div>  <!-- tabcargafamiliar --> 


                  </div>  <!-- Nav Tab Control --> 
                </div>
              </div>

              <div  align="center" class="box-footer">
                  <div class="form-actions ">
                      <button type="submit" class="btn btn-success btn-grad no-margin-bottom">
                          <i class="fa fa-save "></i> Guardar
                      </button>
                  </div>
              </div>
          </form> 

        </div>
      </div>
    </section>      
</div>
