<?php
/* ------------------------------------------------
  ARCHIVO: rol_add.php
  DESCRIPCION: Contiene la vista principal del módulo de Rol de Pago.
  FECHA DE CREACIÓN: 05/07/2017
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
print "<script>document.title = 'ProdegelRRHH - Datos de Rol de Pago'</script>";
date_default_timezone_set("America/Guayaquil");
?>

<style type="text/css">
  
.linea{
  border-width: 2px 0 0;
  margin-bottom: 3px;
  margin-top: 5px;
  border-color: currentcolor currentcolor;
} 

.tdvalor{
  width: 40px;
}

</style>

<script>


  $( document ).ready(function() {

    $("#frm_emp").validationEngine();

    $('#fechainirol').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fechainirol').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    $('#fechafinrol').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fechafinrol').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    $('#feciniasist').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#feciniasist').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    $('#fecfinasist').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy', 
        firstDay: 1
      });
    $('#fecfinasist').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
  /*  
    $('#TableEmpleado').dataTable({
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
        'ajax': "listadoEmpleado",
        'columns': [
            {"data": "apellido"},                            
            {"data": "nombre"},
            {"data": "valor"}   
        ]
    });
*/
    $('#TableRubro').dataTable({
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
        'ajax': "listadoRubro",
        'columns': [
            {"data": "codigo"},                            
            {"data": "nombre"},
            {"data": "valor"},   
            {"data": "neto"}   
        ]
    });


    $(document).on('click', '.selectdetalle', function(){
      $('.selectdetalle').each(function(){
        $(this).removeAttr('bgcolor');
      })
      $(this).attr('bgcolor',"gray");
      $('.printrol').each(function(){
        $(this).attr('disabled', true);
      })

      var id = $(this).attr('name');

      $('.printrol[id='+id+']').attr("disabled",false);

      $.ajax({
        url: base_url + "Rol/tmp_empleado",
        data: { id: id },
        type: 'POST',
        dataType: 'json',
        success: function(json) {
            $('#TableRubro').DataTable().ajax.reload();
        }  
      });  

    });  

    $(document).on('change', '.valor_rubro', function(){
      var id = this.id;
      var valor = $(this).val();
      if (valor == '') { valor = 0; }

      $.ajax({
        url: base_url + "Rol/upd_valor_rubro",
        data: { id: id, valor: valor },
        type: 'POST',
        dataType: 'json',
        success: function(json) {
            $('#TableRubro').DataTable().ajax.reload();
            $.ajax({
              url: base_url + "Rol/sel_rubroneto_tmp",
              type: 'POST',
              dataType: 'json',
              success: function(json) {
                  /*alert("json.valor " + json.valor);*/
                  $('.valor_neto[id='+ json.idemp +']').html(json.valor);
              }  
            });  
        }  
      });  

    });  

    $(document).on('change', '.actualiza_rubro', function(){
      var fechainirol = $('#fechainirol').val();
      var fechafinrol = $('#fechafinrol').val();
      var feciniasist = $('#feciniasist').val();
      var fecfinasist = $('#fecfinasist').val();
      var txt_descripcion = $('#txt_descripcion').val();

      $.ajax({
        url: base_url + "Rol/upd_tmprol",
        data: { fechainirol: fechainirol, fechafinrol: fechafinrol,
                feciniasist: feciniasist, fecfinasist: fecfinasist,
                txt_descripcion: txt_descripcion },
        type: 'POST',
        dataType: 'json',
        success: function(json) {
        }  
      });  

    });  

    $(document).on('click', '.printrol', function(){
      $.fancybox.open({
        type:'iframe',
        width: 800,
        height: 550,
        ajax: {
           dataType: "html",
           type: "POST",
        },
        href: base_url + 'Rol/print_tmprol' 
      });
    });  

    $(document).on('click', '.printrolall', function(){
      $.fancybox.open({
        type:'iframe',
        width: 800,
        height: 550,
        ajax: {
           dataType: "html",
           type: "POST",
        },
        href: base_url + 'Rol/print_tmprolall' 
      });
    });  

  });



</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <i class="fa fa-fort-awesome"></i> Datos de Rol de Pagos </a></li>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>rol">Roles de Pago</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

        <div class="box-header with-border">

          <form id="frm_rol" name="frm_rol" method="post" role="form" class="form" action="<?php echo base_url('Rol/guardar');?>">
            <div class="box-body">

              <div class="form-group col-md-10" style="padding-left: 0px;padding-bottom: 0px; margin-left: 0px; margin-top: 0px; margin-bottom: 0px;">

                <?php /* CAMPO HIDDEN CON EL ID  (EN CASO DE MODIFICACIÓN DEL REGISTRO) */ 
                    if(@$obj != NULL){ ?>
                        <input type="hidden" id="txt_id" name="txt_id" value="<?php if($idrol != NULL){ print $idrol; }?>" >    
                    <?php } else { ?>
                        <input type="hidden" id="txt_id" name="txt_id" value="0">    
                <?php } ?>  


                <div class="form-group col-md-2">
                  <label >Inicio Rol</label>
                  <input type="text" class="form-control actualiza_rubro" name="fechainirol" id="fechainirol" value="<?php if(@$obj != NULL){ @$fec = str_replace('-', '/', @$obj->fechaini_rol); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec; } ?>" >
                </div>                       

                <div class="form-group col-md-2">
                    <label >Fin Rol</label>
                    <input type="text" class="form-control actualiza_rubro" name="fechafinrol" id="fechafinrol" value="<?php if(@$obj != NULL){ @$fec = str_replace('-', '/', @$obj->fechafin_rol); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec; } ?>" >
                </div>                       

                <div class="form-group col-md-2">
                    <label >Inicio Asistenc.</label>
                    <input type="text" class="form-control actualiza_rubro" name="feciniasist" id="feciniasist" value="<?php if(@$obj != NULL){ @$fec = str_replace('-', '/', @$obj->asistencia_ini); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec; } ?>" >
                </div>                       

                <div class="form-group col-md-2">
                    <label >Fin Asistencia</label>
                    <input type="text" class="form-control actualiza_rubro" name="fecfinasist" id="fecfinasist" value="<?php if(@$obj != NULL){ @$fec = str_replace('-', '/', @$obj->asistencia_fin); @$fec = date("d/m/Y", strtotime(@$fec)); print @$fec; } ?>" >
                </div>                       

                <div class="form-group col-md-2">
                    <label >Dias Laborables</label>
                    <input type="text" class="form-control" name="diaslab" id="diaslab" value="<?php if(@$obj != NULL){ print $obj->diaslaborables; } ?>" readonly>
                </div>                       

              </div>                       

              <div class="form-actions col-md-2 pull-right">
                  <button type="submit" class="btn btn-success btn-grad no-margin-bottom">
                      <i class="fa fa-save "></i> Guardar
                  </button>
              </div>

              <div class="col-md-12" >
                <label >Descripcion</label>
                <input type="text" class="form-control actualiza_rubro" name="txt_descripcion" id="txt_descripcion" value="<?php if(@$obj != NULL){ print @$obj->descripcion_rol; }?>" >
              </div>

              <div class="col-md-6" style="margin-top: 15px;">
                
                <div class="box box-danger">
            
                  <div class="box-header with-border">

                    <h3 class="box-title"><i class="fa fa-user"></i> Empleados </h3> 

                    <div class="pull-right" >
                        <button type="button" class="btn btn-success btn-grad no-margin-bottom printrolall" title="Rol de todos los empleados">
                            <i class="fa fa-save "></i> Imprimir
                        </button>
                    </div>

                    <div class="row">
                      <div class="col-xs-12">
                          <div class="box-body table-responsive">

                            <table class="table table-clear " id="tabladetalle">
                              <thead>
                                <tr>
                                  <th class="text-center col-md-1">#</th>
                                  <th class="text-center col-md-1">Apellidos</th>                    
                                  <th class="text-center col-md-1">Nombres</th>                    
                                  <th class="text-center col-md-1">Monto</th>                    
                                  <th class="text-center col-md-1">Ver</th>                    
                                </tr>
                              </thead>
                              <tbody>                                                        
                                <?php 
                                $numc=1;
                                $detant=0;
                                $numitem=0;
                                foreach ($empleados as $det) {
                                ?>
                                  <tr class="selectdetalle" name="<?php print $det->id_empleado; ?>" >
                                    <td class="text-center">
                                      <?php print $numc; $numc++; ?>
                                    </td>
                                    <td class="text-center">
                                      <?php print $det->apellidos; ?>
                                    </td>

                                    <td class="text-center">
                                      <?php print $det->nombres; ?>
                                    </td>

                                    <td class="text-center valor_neto" id="<?php print $det->id_empleado; ?>">
                                      <?php print $det->valor_neto; ?>
                                    </td>

                                    <td class="text-center">
                                      <div class="text-center">
                                        <a href="#" title="Imprimir Rol" id="<?php print $det->id_empleado; ?>" class="btn btn-success btn-xs btn-grad printrol" disabled><i class="fa fa-print"></i></a>  
                                      </div>
                                    </td>

                                   </tr>
                                <?php 
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                      </div>
                    </div>                      

                  </div>
                </div>

              </div>

              <div class="col-md-6" style="margin-top: 15px;">
                
                <div class="box box-danger">
            
                  <div class="box-header with-border">

                    <h3 class="box-title"><i class="fa fa-user"></i> Rubros </h3> 
                    <div class="row">
                      <div class="col-xs-12">
                          <div class="box-body table-responsive">
                            <table id="TableRubro" class="table table-bordered table-striped table-responsive">
                              <thead>
                                <tr >
                                  <th>Codigo</th>
                                  <th>Nombre</th>
                                  <th>Valor</th>
                                  <th>Monto</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                      </div>
                    </div>                      

                  </div>
                </div>

              </div>

            </div>

            <div  align="center" class="box-footer">
            </div>
          </form> 

        </div>
      </div>
    </section>      
</div>
