<?php
/* ------------------------------------------------
  ARCHIVO: dialaborable.php
  DESCRIPCION: Contiene la vista principal del módulo de dialaborable.
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
  print "<script>document.title = 'ProdegelRRHH - Registro de Dias Laborables'</script>";
  date_default_timezone_set("America/Guayaquil");

?>

<style type="text/css">

</style>

<script type='text/javascript' language='javascript'>

  $(document).ready(function () {

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
        'ajax': "Dialaborable/listadoDialaborable",
        'columns': [
            {"data": "mes"},
            {"data": "nombremes"},
            {"data": "ver"}                            
        ]
    });

    $('.actualiza').click(function(){
      var anio = $("#cmb_anio").val();

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Dialaborable/tmp_dialaborable');?>",
        data: { anio: anio }
      }).done(function (result) {
            $('#TableObj').DataTable().ajax.reload();
      }); 

    });

    $(document).on('change','.diaslab', function() {
        var mes = $(this).attr('id');
        var dias = $(this).val();
        $.ajax({
          url: base_url + "Dialaborable/upd_dialaborable",
          data: { mes: mes, dias: dias },
          type: 'POST',
          dataType: 'json',
          success: function(json) {
          }
        });
      return false; 
    });


  }); 


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-thumbs-up"></i> Registro de Dias Laborables 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>dialaborable">Dias Laborables</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
<!--                       <h3 class="box-title"></i> Datos de dialaborable</h3>
 -->
                      <div style="" class="form-group col-md-2">
                        <label for="lb_res" class="col-md-3">Año</label>
                        <div class="col-md-9">                        
                          <select class="form-control validate[required] actualiza" id="cmb_anio" name="cmb_anio">
                            <?php 
                              if(@$anios != NULL){ ?>
                                <option  value="0" selected="TRUE">Seleccione...</option>
                            <?php }  
                              if (count($anios) > 0) {
                                foreach ($anios as $a):
                                    if(@$tmpanio != NULL){
                                        if($a->anio == $tmpanio){ ?>
                                            <option  value="<?php  print $a->anio; ?>" selected="TRUE"><?php print $a->anio ?></option> 
                                            <?php
                                        }else{ ?>
                                            <option value="<?php  print $a->anio; ?>"> <?php  print $a->anio ?> </option>
                                            <?php
                                        }
                                    }else{ ?>
                                        <option value="<?php  print $a->anio; ?>"> <?php  print $a->anio ?> </option>
                                        <?php
                                        }   ?>
                                    <?php

                                endforeach;
                              }
                              ?>
                          </select>
                        </div>
                      </div>

                    </div>
                    <div class="box-body">

                      <div class="row">
                        <div class="col-xs-12">
                            <div class="box-body table-responsive">
                              <table id="TableObj" class="table table-bordered table-striped table-responsive">
                                <thead>
                                  <tr >
                                    <th>#</th>
                                    <th>Mes</th>
                                    <th>Dias Laborables</th>
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

