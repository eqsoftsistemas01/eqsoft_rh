<?php
/* ------------------------------------------------
  ARCHIVO: asistencia.php
  DESCRIPCION: Contiene la vista principal del módulo de asistencia.
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
  print "<script>document.title = 'ProdegelRRHH - Registro de Asistencia'</script>";
  date_default_timezone_set("America/Guayaquil");

  $usua = $this->session->userdata('usua');
  $id = $usua->id_usu;
  $perfil = $usua->perfil;

?>

<style type="text/css">

</style>

<script type='text/javascript' language='javascript'>

  $(document).ready(function () {

    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $('#fecha').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fecha').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });  

    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $('#hasta').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#hasta').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });  

    $('#TableObj').dataTable({
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
        'ajax': "Asistencia/listadoAsistencia",
        'columns': [
            {"data": "fecha"},
            {"data": "empleado"},
            {"data": "entrada_trabajo"},
            {"data": "salida_almuerzo"},   
            {"data": "entrada_almuerzo"},   
            {"data": "salida_trabajo"},   
            {"data": "ver"}                            
        ]
    });

    $('.actualiza').change(function(){
    var fecha = $("#fecha").val();
    var hasta = $("#hasta").val();
    var emp = $("#cmb_empleado").val();

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Asistencia/tmp_fecha');?>",
        data: { fecha: fecha, hasta: hasta, emp: emp }
      }).done(function (result) {
            $('#TableObj').DataTable().ajax.reload();
      }); 

    });

    $(document).on('click', '.asistencia_ver', function(){
      id = $(this).attr('id');
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Asistencia/tmp_asistencia');?>",
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
            href: "<?php echo base_url('Asistencia/upd_asistencia');?>",
            afterClose: function(){
              $('#TableObj').DataTable().ajax.reload();
            }
          });
        }
      });
    });  


    $(document).on('click', '.asistencia_add', function(){
      $.fancybox.open({
        type: "ajax",
        width: 550,
        height: 550,
        ajax: {
           dataType: "html",
           type: "POST"
        },
        href: "<?php echo base_url('Asistencia/add_asistencia');?>",
        afterClose: function(){
          $('#TableObj').DataTable().ajax.reload();
        } 
      });
    });

    $(document).on('click','.asistencia_del', function() {
        id = $(this).attr('id');
        if (conf_del()) {
          $.ajax({
            url: base_url + "Asistencia/del_asistencia",
            data: { id: id },
            type: 'POST',
            dataType: 'json',
            success: function(json) {
              if (json.mens == 1){
                $('#TableObj').DataTable().ajax.reload();
              } else {
                alert("No se pudo eliminar la asistencia del empleado. Existe informacion asociada.");
                return false;                
              }  
            }
          });
      }
      return false; 
    });

    $(document).on('click', '.asistencia_import', function(){
      $.fancybox.open({
        type: "ajax",
        width: 550,
        height: 550,
        ajax: {
           dataType: "html",
           type: "POST"
        },
        href: "<?php echo base_url('Asistencia/import_asistencia');?>",
        afterClose: function(){
          $('#TableObj').DataTable().ajax.reload();
        } 
      });
    });

    function conf_del() {
        return  confirm("¿Confirma que desea eliminar la asistencia del empleado?");
    }

    var perfil = "<?php print @$perfil ?>";
    if (perfil == "3"){
      $(".asistencia_add").remove();
    }

  }); 


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-registered"></i> Registro de Asistencia 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>asistencia">Asistencia</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
<!--                       <h3 class="box-title"></i> Datos de Asistencia</h3>
 -->
                      <div class="form-group col-md-3" style="margin-bottom: 0px; margin-top: 8px;">
                        <label class="col-sm-3 control-label" style="padding-left: 0px;">Fecha</label>
                        <div class="input-group date col-sm-7">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                          <input type="text" class="form-control pull-right validate[required] actualiza" id="fecha" name="fecha" value="<?php if (@$fecha != NULL) { print @$fecha;} else { print date("d/m/Y"); } ?>">

<!--                           <span class="input-group-btn">
                            <button class="btn btn-success btn-flat actualiza" type="button"><i class="fa fa-retweet" aria-hidden="true"></i></button>
                          </span>
 -->
                        </div>
                      </div> 

                      <div class="form-group col-md-3" style="margin-bottom: 0px; margin-top: 8px;">
                        <label class="col-sm-3 control-label" style="padding-left: 0px;">Hasta</label>
                        <div class="input-group date col-sm-7">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                          <input type="text" class="form-control pull-right validate[required] actualiza" id="hasta" name="hasta" value="<?php if (@$hasta != NULL) { print @$hasta;} else { print date("d/m/Y"); } ?>">
                        </div>
                      </div> 


                      <div class="form-group col-md-4" style="margin-bottom: 0px; margin-top: 8px; padding-left: 0px; padding-right: 0px;">
                        <label for="lb_res" class="col-sm-3 control-label" style="padding-left: 0px;">Empleado</label>
                        <div class="col-sm-7" style="padding-left: 0px;">
                          <select id="cmb_empleado" name="cmb_empleado" class="form-control validate[required] actualiza" >
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
                    </div>


                      <div class="pull-right"> 

                          <button type="button" class="btn btn-success btn-sm btn-grad asistencia_import" >
                            <i class="fa fa-upload"></i> Importar
                          </button>   

                          <button type="button" class="btn btn-info btn-sm btn-grad asistencia_add" >
                            <i class="fa fa-plus-square"></i> Añadir
                          </button>   
                     
                      </div>
                    </div>
                    <div class="box-body">

                      <div class="row">
                        <div class="col-xs-12">
                            <div class="box-body table-responsive">
                              <table id="TableObj" class="table table-bordered table-striped table-responsive">
                                <thead>
                                  <tr >
                                    <th>Fecha</th>
                                    <th>Empleado</th>
                                    <th>Entrada</th>
                                    <th>Sal.Almuerzo</th>
                                    <th>Ent.Almuerzo</th>
                                    <th>Salida</th>
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
                    <!-- /.box-body -->
                    <div  align="center" class="box-footer">
                        
                    </div>
                </div>
              <!-- /.box -->
            </div>


        </div>
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

