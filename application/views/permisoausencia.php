<?php
/* ------------------------------------------------
  ARCHIVO: permisoausencia.php
  DESCRIPCION: Contiene la vista principal del módulo de permisoausencia.
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
  print "<script>document.title = 'ProdegelRRHH - Registro de Permisos de Ausencia'</script>";
  date_default_timezone_set("America/Guayaquil");

?>

<style type="text/css">

</style>

<script type='text/javascript' language='javascript'>

  $(document).ready(function () {

    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $('#desde').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#desde').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });  
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
        'ajax': "Permisoausencia/listadoPermisoausencia",
        'columns': [
            {"data": "empleado"},
            {"data": "fecha_desde"},
            {"data": "hora_desde"},   
            {"data": "fecha_hasta"},   
            {"data": "hora_hasta"},   
            {"data": "motivo"},   
            {"data": "aprobado"},   
            {"data": "ver"}                            
        ]
    });

    $('.actualiza').click(function(){
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Permisoausencia/tmp_fecha');?>",
        data: { desde: desde, hasta: hasta }
      }).done(function (result) {
            $('#TableObj').DataTable().ajax.reload();
      }); 

    });

    $(document).on('click', '.permisoausencia_ver', function(){
      id = $(this).attr('id');
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Permisoausencia/tmp_permisoausencia');?>",
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
            href: "<?php echo base_url('Permisoausencia/upd_permisoausencia');?>",
            afterClose: function(){
              $('#TableObj').DataTable().ajax.reload();
            }
          });
        }
      });
    });  


    $(document).on('click', '.permisoausencia_add', function(){
      $.fancybox.open({
        type: "ajax",
        width: 550,
        height: 550,
        ajax: {
           dataType: "html",
           type: "POST"
        },
        href: "<?php echo base_url('permisoausencia/add_permisoausencia');?>",
        afterClose: function(){
          $('#TableObj').DataTable().ajax.reload();
        } 
      });
    });

    $(document).on('click','.permisoausencia_del', function() {
        id = $(this).attr('id');
        if (conf_del()) {
          $.ajax({
            url: base_url + "permisoausencia/del_permisoausencia",
            data: { id: id },
            type: 'POST',
            dataType: 'json',
            success: function(json) {
              if (json.mens == 1){
                $('#TableObj').DataTable().ajax.reload();
              } else {
                alert("No se pudo eliminar el Permiso de ausencia del empleado. Existe informacion asociada.");
                return false;                
              }  
            }
          });
      }
      return false; 
    });


    function conf_del() {
        return  confirm("¿Confirma que desea eliminar este Permiso de ausencia?");
    }

  }); 


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-thumbs-up"></i> Registro de Permiso de Ausencia 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>permisoausencia">Permisos de Ausencia</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
<!--                       <h3 class="box-title"></i> Datos de permisoausencia</h3>
 -->
                      <div class="form-group col-md-8" style="margin-bottom: 0px; margin-top: 8px;">
                        <label class="col-sm-2 control-label" style="padding-left: 0px;">Desde</label>
                        <div class="col-sm-3">                         
                          <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control pull-right validate[required]" id="desde" name="desde" value="<?php if (@$desde != NULL) {@$fec = str_replace('-', '/', @$desde); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec;} else { print date("d/m/Y"); } ?>">
                          </div>
                        </div>

                        <label class="col-sm-2 control-label" style="padding-left: 0px;">Hasta</label>
                        <div class="col-sm-4">                         
                          <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control pull-right validate[required]" id="hasta" name="hasta" value="<?php if (@$hasta != NULL) {@$fec = str_replace('-', '/', @$hasta); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec;} else { print date("d/m/Y"); } ?>">

                            <span class="input-group-btn">
                              <button class="btn btn-success btn-flat actualiza" type="button"><i class="fa fa-retweet" aria-hidden="true"></i></button>
                            </span>

                          </div>
                        </div>
                      </div> 

                      <div class="pull-right"> 

                          <button type="button" class="btn btn-info btn-grad permisoausencia_add" >
                            <i class="fa fa-plus-square"></i> Solicitar permiso
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
                                    <th>Empleado</th>
                                    <th>Salida</th>
                                    <th>Hora</th>
                                    <th>Entrada</th>
                                    <th>Hora</th>
                                    <th>Motivo</th>
                                    <th>Aprobado</th>
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

