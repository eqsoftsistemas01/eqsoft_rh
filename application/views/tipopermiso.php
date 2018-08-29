<?php
/* ------------------------------------------------
  ARCHIVO: tipopermiso.php
  DESCRIPCION: Contiene la vista principal del módulo de tipopermiso.
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
  print "<script>document.title = 'ProdegelRRHH - Listado de Tipos de Permiso'</script>";
  date_default_timezone_set("America/Guayaquil");

?>

<style type="text/css">

</style>

<script type='text/javascript' language='javascript'>

  $(document).ready(function () {

    $("#formtipopermiso").validationEngine();

    $('#Tablatipopermiso').dataTable({
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
        'ajax': "Tipopermiso/listadoTipopermiso",
        'columns': [
            {"data": "tipopermiso"},
            {"data": "ver"}                            
        ]
    });

    $(document).on('click', '.btnguardartipo', function(){
      id = $("#txt_id").val();
      if (id == '') { id = 0; }
      tipopermiso = $("#txt_tipopermiso").val();
      if (tipopermiso == '') {
        alert("Ingrese el tipo de permiso");
        return false;
      }
      
      if($("#chkactivo").is(":checked")){ activo = 1; } 
        else{ activo = 0; } 

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Tipopermiso/agregar');?>",
        data: {id: id, tipopermiso: tipopermiso, activo: activo},
        success: function(json) {
          $.fancybox.close();
          $('#Tablatipopermiso').DataTable().ajax.reload();
        }  
      });
    });

    $(document).on('click', '.tipo_ver', function(){
      id = $(this).attr('id');
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Tipopermiso/tmp_tipopermiso');?>",
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
            href: "<?php echo base_url('Tipopermiso/upd_tipopermiso');?>"
          });
        }
      });
    });  

    $(document).on('click', '.tipo_add', function(){
      $.fancybox.open({
        type: "ajax",
        width: 550,
        height: 550,
        ajax: {
           dataType: "html",
           type: "POST"
        },
        href: "<?php echo base_url('Tipopermiso/add_tipopermiso');?>"
      });
    });

    $(document).on('click','.tipo_del', function() {
      id = $(this).attr('id');
        if (conf_del()) {
          $.ajax({
            url: base_url + "Tipopermiso/del_tipopermiso",
            data: { id: id },
            type: 'POST',
            dataType: 'json',
            success: function(json) {
              if (json.mens == 1){
                $('#Tablatipopermiso').DataTable().ajax.reload();
              } else {
                alert("No se pudo eliminar el tipo de permiso. Existe informacion asociada.");
                return false;                
              }  
            }
          });
      }
    });


    function conf_del() {
        return  confirm("¿Confirma que desea eliminar este tipo de permiso?");
    }



  }); 


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-child"></i> Tipos de Permiso
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>tipopermiso">Tipos de Permiso</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title"></i> Tipos de Permiso</h3>
                      <div class="pull-right"> 

                          <button type="button" class="btn btn-info btn-grad tipo_add" >
                            <i class="fa fa-plus-square"></i> Añadir
                          </button>   

                       
                    </div>
                    </div>
                    <div class="box-body">

                      <div class="row">
                        <div class="col-xs-12">
                            <div class="box-body table-responsive">
                              <table id="Tablatipopermiso" class="table table-bordered table-striped table-responsive">
                                <thead>
                                  <tr >
                                    <th>Tipo de Permiso</th>
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

