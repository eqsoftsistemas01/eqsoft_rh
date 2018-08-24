<?php
/* ------------------------------------------------
  ARCHIVO: Rubro.php
  DESCRIPCION: Contiene la vista principal del módulo de Rubro.
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
  print "<script>document.title = 'ProdegelRRHH - Listado de Rubros'</script>";
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
        'ajax': "Rubro/listadoRubros",
        'columns': [
            {"data": "codigo"},
            {"data": "nombre"},
            {"data": "tiporubro"},   
            {"data": "periodicidad"},   
            {"data": "calculado"},   
            {"data": "ver"}                            
        ]
    });

    $(document).on('click', '.rubro_ver', function(){
      id = $(this).attr('id');
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Rubro/tmp_rubro');?>",
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
            href: "<?php echo base_url('Rubro/upd_rubro');?>",
            afterClose: function(){
              $('#TableObj').DataTable().ajax.reload();
            }
          });
        }
      });
    });  


    $(document).on('click', '.ret_ver0', function(){
      id = $(this).attr('id');
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Rubro/tmp_Rubro');?>",
        data: {id: id},
        success: function(json) {
          location.replace("<?php print $base_url;?>Rubro/upd_Rubro");
        }
      });
    });  

    $(document).on('click', '.rubro_add', function(){
      $.fancybox.open({
        type: "ajax",
        width: 550,
        height: 550,
        ajax: {
           dataType: "html",
           type: "POST"
        },
        href: "<?php echo base_url('Rubro/add_rubro');?>",
        afterClose: function(){
          $('#TableObj').DataTable().ajax.reload();
        } 
      });
    });

    $(document).on('click','.rubro_del', function() {
        id = $(this).attr('id');
        if (conf_del()) {
          $.ajax({
            url: base_url + "Rubro/del_rubro",
            data: { id: id },
            type: 'POST',
            dataType: 'json',
            success: function(json) {
              if (json.mens == 1){
                $('#TableObj').DataTable().ajax.reload();
              } else {
                alert("No se pudo eliminar el rubro. Existe informacion asociada.");
                return false;                
              }  
            }
          });
      }
      return false; 
    });


    function conf_del() {
        return  confirm("¿Confirma que desea eliminar este Rubro?");
    }

    $(document).on('click', '.btnguardar', function(){ 
      var ident = $("#txt_ident").val();    
      var id = $("#txt_id").val();

      $.ajax({
          type: "POST",
          dataType: "json",
          url: base_url + "Rubro/existeIdentificacion",
          data: { id: id, identificacion: ident },
          success: function(json) {
            if (json.resu == 0){

              var tipoident = $('#cmb_tipoident option:selected').val();      
              var perfil = $('#cmb_perfil option:selected').val();      
              var departamento = $('#cmb_departamento option:selected').val();      
              var nombre = $("#txt_nombre").val();
              var activo = $("#chkactivo").val();
              var direccion = $("#txt_direccion").val();
              var telefono = $("#txt_telefono").val();
              var correo = $("#txt_correo").val();

              $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: base_url + "Rubro/guardar",
                  data: { id: id, ident: ident, tipoident: tipoident,
                          nombre: nombre, activo: activo, perfil: perfil,
                          direccion: direccion, telefono: telefono, 
                          correo: correo, departamento: departamento
                        },
                  success: function(json) {
                    $.fancybox.close();
                    location.replace("<?php print $base_url ?>Rubro");
                  }
              });

            } else {
                alert("El numero de identificación ya esta registrado para otro Rubro");
                $('#txt_ident').focus();
                return false;
            } 
          }
      });
    });  


  }); 


</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-registered"></i> Lista de Rubros 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>Rubro">Rubros</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title"></i> Datos de Rubros</h3>
                      <div class="pull-right"> 

                          <button type="button" class="btn btn-info btn-grad rubro_add" >
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
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Tipo Rubro</th>
                                    <th>Periodicidad</th>
                                    <th>Calculado</th>
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

