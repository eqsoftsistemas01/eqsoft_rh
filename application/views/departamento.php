<?php
/* ------------------------------------------------
  ARCHIVO: departamento.php
  DESCRIPCION: Contiene la vista principal del módulo de departamento.
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
  print "<script>document.title = 'EQsoftRH - Listado de Departamentos'</script>";
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
        'ajax': "Departamento/listadoDepartamentos",
        'columns': [
            {"data": "nombre"},
            {"data": "jefe"},   
            {"data": "ver"}                            
        ]
    });

    $(document).on('click', '.btnguardardpto', function(){
      id = $("#txt_id").val();
      if (id == '') { id = 0; }
      nombre = $("#txt_nombre").val();
      if (nombre == '') {
        alert("Ingrese el nombre");
        return false;
      }
      jefe = $("#cmb_empleado").val();
      if (jefe == '') { jefe = 0; }
      if($("#chkactivodpto").is(":checked")){ activo = 1; } 
        else{ activo = 0; } 

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Departamento/agregar');?>",
        data: {id: id, nombre: nombre, jefe: jefe, activo: activo},
        success: function(json) {
          $.fancybox.close();
          $('#TableObj').DataTable().ajax.reload();
        }  
      });
    });

    $(document).on('click', '.dpto_ver', function(){
      id = $(this).attr('id');
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Departamento/tmp_departamento');?>",
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
            href: "<?php echo base_url('Departamento/upd_departamento');?>"
          });
        }
      });
    });  

    $(document).on('click', '.dpto_add', function(){
      $.fancybox.open({
        type: "ajax",
        width: 550,
        height: 550,
        ajax: {
           dataType: "html",
           type: "POST"
        },
        href: "<?php echo base_url('Departamento/add_departamento');?>",
        afterClose: function(){
          $('#TableObj').DataTable().ajax.reload();
        } 
      });
    });

    $(document).on('click','.dpto_del', function() {
      id = $(this).attr('id');
        if (conf_del()) {
          $.ajax({
            url: base_url + "Departamento/del_departamento",
            data: { id: id },
            type: 'POST',
            dataType: 'json',
            success: function(json) {
              if (json.mens == 1){
                $('#TableObj').DataTable().ajax.reload();
              } else {
                alert("No se pudo eliminar el departamento. Existe informacion asociada.");
                return false;                
              }  
            }
          });
      }
    });


    function conf_del() {
        return  confirm("¿Confirma que desea eliminar este departamento?");
    }



  }); 


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-registered"></i> Lista de Departamentos
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>departamento">Departamentos</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title"></i> Datos de Departamentos</h3>
                      <div class="pull-right"> 

                          <button type="button" class="btn btn-info btn-grad dpto_add" >
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
                                    <th>Nombre de Departamento</th>
                                    <th>Nombre de Jefe</th>
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

