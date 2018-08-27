<?php
/* ------------------------------------------------
  ARCHIVO: departamento.php
  DESCRIPCION: Contiene la vista principal del módulo de departamento.
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
  print "<script>document.title = 'ProdegelRRHH - Listado de Ciudades'</script>";
  date_default_timezone_set("America/Guayaquil");

?>

<style type="text/css">

</style>

<script type='text/javascript' language='javascript'>

  $(document).ready(function () {

    $("#formciudad").validationEngine();

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
        'ajax': "Ciudad/listadoCiudades",
        'columns': [
            {"data": "nombre"},
            {"data": "provincia"},
            {"data": "ver"}                            
        ]
    });

    $(document).on('click', '.btnguardarciudad', function(){
      id = $("#txt_id").val();
      if (id == '') { id = 0; }
      nombre = $("#txt_nombre").val();
      if (nombre == '') {
        alert("Ingrese el nombre");
        return false;
      }
      provincia = $("#cmb_provincia").val();
      if($("#chkactivo").is(":checked")){ activo = 1; } 
        else{ activo = 0; } 

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Ciudad/agregar');?>",
        data: {id: id, nombre: nombre, provincia: provincia, activo: activo},
        success: function(json) {
          $.fancybox.close();
          $('#TableObj').DataTable().ajax.reload();
        }  
      });
    });

    $(document).on('click', '.ciudad_ver', function(){
      id = $(this).attr('id');
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Ciudad/tmp_ciudad');?>",
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
            href: "<?php echo base_url('Ciudad/upd_ciudad');?>"
          });
        }
      });
    });  

    $(document).on('click', '.ciudad_add', function(){
      $.fancybox.open({
        type: "ajax",
        width: 550,
        height: 550,
        ajax: {
           dataType: "html",
           type: "POST"
        },
        href: "<?php echo base_url('Ciudad/add_ciudad');?>"
      });
    });

    $(document).on('click','.ciudad_del', function() {
      id = $(this).attr('id');
        if (conf_del()) {
          $.ajax({
            url: base_url + "Ciudad/del_ciudad",
            data: { id: id },
            type: 'POST',
            dataType: 'json',
            success: function(json) {
              if (json.mens == 1){
                $('#TableObj').DataTable().ajax.reload();
              } else {
                alert("No se pudo eliminar la ciudad. Existe informacion asociada.");
                return false;                
              }  
            }
          });
      }
    });


    function conf_del() {
        return  confirm("¿Confirma que desea eliminar esta ciudad?");
    }



  }); 


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-map-marker"></i> Lista de Cuidades
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>ciudad">Ciudades</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title"></i> Datos de Cuidades</h3>
                      <div class="pull-right"> 

                          <button type="button" class="btn btn-info btn-grad ciudad_add" >
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
                                    <th>Nombre de Ciudad</th>
                                    <th>Nombre de Provincia</th>
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

