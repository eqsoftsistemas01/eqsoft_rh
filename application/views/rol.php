<?php
/* ------------------------------------------------
  ARCHIVO: roles.php
  DESCRIPCION: Contiene la vista principal del módulo de roles.
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
  print "<script>document.title = 'ProdegelRRHH - Listado de Roles de Pago'</script>";
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
        'ajax': "Rol/listadoRoles",
        'columns': [
            {"data": "fechaini"},
            {"data": "fechafin"},
            {"data": "descripcion"},   
            {"data": "estado"},   
            {"data": "asistenciaini"},   
            {"data": "asistenciafin"},   
            {"data": "ver"}                            
        ]
    });


    $(document).on('click', '.rol_ver', function(){
      id = $(this).attr('id');
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Rol/tmp_rol');?>",
        data: {id: id},
        success: function(json) {
          location.replace("<?php print $base_url;?>Rol/upd_rol");
        }
      });
    });  

    $(document).on('click', '.rol_add', function(){
      location.replace("<?php print $base_url;?>Rol/add_rol");
    });  

    $(document).on('click','.rol_del', function() {
        id = $(this).attr('id');
        if (conf_del()) {
          $.ajax({
            url: base_url + "Rol/del_rol",
            data: { id: id },
            type: 'POST',
            dataType: 'json',
            success: function(json) {
              $('#TableObj').DataTable().ajax.reload();
            }
          });
      }
      return false; 
    });


    function conf_del() {
        return  confirm("¿Confirma que desea eliminar este Rol de Pago?");
    }


  }); 


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-registered"></i> Lista de Roles de Pago
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>roles">Roles de Pago</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title"></i> Datos de Rol de Pago</h3>
                      <div class="pull-right"> 

                          <button type="button" class="btn btn-info btn-grad rol_add" >
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
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    <th>Asist. Inicio</th>
                                    <th>Asist. Fin</th>
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

