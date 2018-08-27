<?php
/* ------------------------------------------------
  ARCHIVO: asistencia.php
  DESCRIPCION: Contiene la vista principal del módulo de asistencia.
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
  print "<script>document.title = 'ProdegelRRHH - Registro de Asistencia por empleado'</script>";
  date_default_timezone_set("America/Guayaquil");

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
        'ajax': "Asistenciat/listadoAsistenciat",
        'columns': [
            {"data": "empleado"},
            {"data": "entrada_trabajo"},
            {"data": "salida_almuerzo"},   
            {"data": "entrada_almuerzo"},   
            {"data": "salida_trabajo"}   
                                       
        ]
    });

   

</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-hand-o-up"></i> Registro de Asistencia 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url; ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>asistenciat">Asistencia</a></li>
        
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
                      <div class="form-group col-md-4" style="margin-bottom: 0px; margin-top: 8px;">
                        <label class="col-sm-3 control-label" style="padding-left: 0px;">Fecha</label>
                        <div class="input-group date col-sm-7">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                          <input type="text" class="form-control pull-right validate[required]" id="fecha" name="fecha" value="<?php if (@$fecha != NULL) {@$fec = str_replace('-', '/', @$fecha); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec;} else { print date("d/m/Y"); } ?>">

                          <span class="input-group-btn">
                            <button class="btn btn-success btn-flat actualiza" type="button"><i class="fa fa-retweet" aria-hidden="true"></i></button>
                          </span>

                        </div>
                      </div> 

                      <div class="pull-right"> 

                          <button type="button" class="btn btn-info btn-grad asistencia_add" >
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
                                  <tr>
                                    <th>Empleado t</th>
                                    <th>Ent. Trabajo</th>
                                    <th>Sal.Trabajo</th>
                                    <th>Ent. Almuerzo</th>
                                    <th>Sal. Almuerzo</th>
                                    
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($datos as $dato) { ?>
                                  <tr>
                                    <th><?=$dato->apellidos;?></th>
                                    <th><?=$dato->entrada_trabajo;?></th>
                                    <th><?=$dato->salida_trabajo;?></th>
                                    <th><?=$dato->entrada_almuerzo;?></th>
                                   <th><?=$dato->salida_almuerzo;?></th>
                                  </tr>
                                 <?php } ?>
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

