<?php
/* ------------------------------------------------
  ARCHIVO: cargo.php
  DESCRIPCION: Contiene la vista principal del módulo de cargo.
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
  print "<script>document.title = 'ProdegelRRHH - Listado de Tipos de Empleado'</script>";
  date_default_timezone_set("America/Guayaquil");

?>

<style type="text/css">

</style>

<script type='text/javascript' language='javascript'>

  $(document).ready(function () {

    $("#formtipotrabajador").validationEngine();

    $('#TablaTipoTrabajador').dataTable({
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
        'ajax': "Tipotrabajador/listadoTipoTrabajador",
        'columns': [
            {"data": "tipotrabajador"},
            {"data": "descripcion"},
            {"data": "ver"}                            
        ]
    });

    $(document).on('click', '.btnguardartipo', function(){
      id = $("#txt_id").val();
      if (id == '') { id = 0; }
      tipotrabajador = $("#txt_tipotrabajador").val();
      if (tipotrabajador == '') {
        alert("Ingrese el Tipo de trabajador");
        return false;
      }
      descripcion = $("#txt_descripcion").val();
      
      if($("#chkactivo").is(":checked")){ activo = 1; } 
        else{ activo = 0; } 

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Tipotrabajador/agregar');?>",
        data: {id: id, tipotrabajador: tipotrabajador, descripcion: descripcion, activo: activo},
        success: function(json) {
          $.fancybox.close();
          $('#TablaTipoTrabajador').DataTable().ajax.reload();
        }  
      });
    });

    $(document).on('click', '.tipo_ver', function(){
      id = $(this).attr('id');
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Tipotrabajador/tmp_tipotrab');?>",
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
            href: "<?php echo base_url('Tipotrabajador/upd_tipotrabajador');?>"
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
        href: "<?php echo base_url('Tipotrabajador/add_tipotrabajador');?>"
      });
    });

    $(document).on('click','.tipo_del', function() {
      id = $(this).attr('id');
        if (conf_del()) {
          $.ajax({
            url: base_url + "Tipotrabajador/del_tipotrabajador",
            data: { id: id },
            type: 'POST',
            dataType: 'json',
            success: function(json) {
              if (json.mens == 1){
                $('#TablaTipoTrabajador').DataTable().ajax.reload();
              } else {
                alert("No se pudo eliminar el tipo de empleado. Existe informacion asociada.");
                return false;                
              }  
            }
          });
      }
    });


    function conf_del() {
        return  confirm("¿Confirma que desea eliminar este tipo de empleado?");
    }



  }); 


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-child"></i> Tipos de trabajador
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>tipotrabajador">Tipo de</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title"></i> Tipos de trabajador</h3>
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
                              <table id="TablaTipoTrabajador" class="table table-bordered table-striped table-responsive">
                                <thead>
                                  <tr >
                                    <th>Tipo de trabajador</th>
                                    <th>Descripcion</th>
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

