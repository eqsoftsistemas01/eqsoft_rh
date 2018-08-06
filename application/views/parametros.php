<?php
/* ------------------------------------------------
  ARCHIVO: parametros.php
  DESCRIPCION: Contiene la vista principal del módulo de parametros.
  FECHA DE CREACIÓN: 05/07/2017
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página
print "<script>document.title = 'EQsoft - Parametros'</script>";
date_default_timezone_set("America/Guayaquil");
?>
<script>


  $( document ).ready(function() {
    $("#frm_emp").validationEngine();

    $('#chk_serviciotecnico').click(function (event) {
        actualizacontroles_servicio();
    });    

    function actualizacontroles_servicio(){
        if ($('#chk_serviciotecnico').is(":checked")) {
            $('#chk_servicioserie').attr("disabled", false);
            $('#chk_serviciodetalle').attr("disabled", false);
            $('#chk_servicioencargado').attr("disabled", false);
            $('#chk_servicioprodutilizado').attr("disabled", false);
            $('#chk_servicioabono').attr("disabled", false);
            $('#pro_servicio').attr("disabled", false);           
        } else {
            $('#chk_servicioserie').attr("checked", false);
            $('#chk_serviciodetalle').attr("checked", false);
            $('#chk_servicioencargado').attr("checked", false);
            $('#chk_servicioprodutilizado').attr("checked", false);
            $('#chk_servicioabono').attr("checked", false);

            $('#chk_servicioserie').attr("disabled", true);
            $('#chk_serviciodetalle').attr("disabled", true);
            $('#chk_servicioencargado').attr("disabled", true);
            $('#chk_servicioprodutilizado').attr("disabled", true);
            $('#chk_servicioabono').attr("disabled", true);
            $('#pro_servicio').attr("disabled", true);           
        }
    }

    actualizacontroles_servicio();

  });

</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="frmparametro">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <i class="fa fa-fort-awesome"></i> Parametros Generales </a></li>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print $base_url ?>parametros">Parametros Generales</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- SECCION DEL FORMULARIO-->
            <div class="col-md-8" style="padding-right: 5px;">
                <!-- general form elements -->
                <div class="box box-danger">
<!--                     <div class="box-header with-border">
                        <h3 class="box-title">Parametros Generales</h3>
                    </div> -->
                  <!--   <form role="form"> -->
             
                    <form id="frm_emp" name="frm_emp" method="post" role="form" class="form" action="<?php echo base_url('parametros/guardar');?>">
                        <div class="box-body">

                         <div class="nav-tabs-custom">
                          <ul class="nav nav-tabs">
                           <li class="active"><a href="#tabgeneral" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> GENERAL</a></li>                            
                           <li ><a href="#tabrestaurante" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> RESTAURANTE</a></li>                            
                           <li ><a href="#tabservicio" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> SERVICIO TECNICO</a></li>                            
                           <li ><a href="#tabcitas" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> GESTION DE CITAS</a></li>                            
                           <li ><a href="#tabproducto" data-toggle="tab"><i class="fa fa-tint" aria-hidden="true"></i> PRODUCTOS</a></li>                            
                          </ul>

                          <div class="tab-content">
                           <div class="tab-pane active" id="tabgeneral">

                            <!-- Codigo Establecimiento -->
<!--                             <div class="form-group col-md-6">
                                <label for="txt_codestab">Codigo Establecimiento</label>
                                <input type="text" class="form-control validate[required] text-right" name="txt_codestab" id="txt_codestab" placeholder="Codigo de Establecimiento" value="<?php if(@$codestab != NULL){ print @$codestab; }?>">
                            </div> -->

                            <!-- Codigo Punto Emision -->
<!--                             <div class="form-group col-md-6">
                                <label for="txt_codptoemi">Codigo Punto Emision</label>
                                <input type="text" class="form-control validate[required] text-right" name="txt_codptoemi" id="txt_codptoemi" placeholder="Codigo de Punto de Emision" value="<?php if(@$codptoemi != NULL){ print @$codptoemi; }?>">
                            </div> -->

                            <!-- Contador Factura -->
<!--                             <div class="form-group col-md-6">
                                <label for="contfactura">Contador Factura</label>
                                <input type="text" class="form-control validate[required] text-right" name="txt_contfactura" id="txt_contfactura" placeholder="Contador de facturas" value="<?php if(@$factura != NULL){ print @$factura; }?>">
                            </div> -->
                            <!-- Contador Nota de Venta -->
<!--                             <div class="form-group col-md-6">
                                <label for="contnventa">Contador Nota de Venta</label>
                                <input type="text" class="form-control validate[required] text-right" name="txt_contnventa" id="txt_contnventa" placeholder="Contador de Notas de Venta" value="<?php if(@$notaventa != NULL){ print @$notaventa; }?>">
                            </div> -->

                            <!-- Porciento IVA -->
                            <div class="form-group col-md-6">
                                <label for="txt_iva">Porciento IVA</label>
                                <input type="text" class="form-control validate[required] text-right" name="txt_iva" id="txt_iva" placeholder="Porciento IVA" value="<?php if(@$iva != NULL){ print @$iva; }?>">
                            </div>

                            <!-- Contador Nota de Comprob Pago -->
<!--                             <div class="form-group col-md-6">
                                <label for="txt_comprobpago">Contador Comprobante de Pago</label>
                                <input type="text" class="form-control validate[required] text-right" name="txt_comprobpago" id="txt_comprobpago" placeholder="Contador de Comprobante de Pago" value="<?php if(@$comprobpago != NULL){ print @$comprobpago; }?>">
                            </div>
 -->
                            <!-- Contador Retencion Compra -->
<!--                             <div class="form-group col-md-6">
                                <label for="contretencion">Contador Retencion Compra</label>
                                <input type="text" class="form-control validate[required] text-right" name="txt_contretencion" id="txt_contretencion" placeholder="Contador de Retencion Compra" value="<?php if(@$retencion != NULL){ print @$retencion; }?>">
                            </div> -->

                            <div class="form-group col-md-6">
                              <label>Impresora para Factura</label>
                              <select id="txt_impfactura" name="txt_impfactura" class="form-control">
                                <?php 
                                  if(@$objfactura != NULL){ ?>
                                    <option  value="<?php if(@$objfactura != NULL){ print @$objfactura->id_comanda; }?>" selected="TRUE"><?php if($objfactura->nom_comanda != NULL){ print $objfactura->nom_comanda; }?></option>
                                <?php } else { ?>
                                    <option  value="0" selected="TRUE">Seleccione...</option>
                                <?php } 
                                    $tmpid = 0;  
                                    if(@$objfactura != NULL) {$tmpid = @$objfactura->id_comanda;} 
                                    if (count($impresoras) > 0) {
                                        foreach ($impresoras as $uni):
                                          if ($tmpid != $uni->id_comanda){
                                            ?>
                                            <option value="<?php  print $uni->id_comanda; ?>"> <?php  print $uni->nom_comanda ?> </option>
                                            <?php
                                        }    
                                        endforeach;
                                    }
                                    ?>
                              </select>
                            </div>

                            <!-- Limite de Productos en Venta -->
                            <div class="form-group col-md-6">
                                <label for="txt_limiteprodventa">Limite de Productos en Venta</label>
                                <input type="text" class="form-control validate[required] text-right" name="txt_limiteprodventa" id="txt_limiteprodventa" placeholder="Limite de Productos en Factura" value="<?php if(@$limiteprodventa != NULL){ print @$limiteprodventa; }?>">
                            </div>

                            <div class="box box-info col-md-12">
                              <div class="form-group col-md-12">
                                <label>Impuesto Adicional</label>
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="txt_impuestoadicdescrip">Nombre de Impuesto</label>
                                  <input type="text" class="form-control " name="txt_impuestoadicdescrip" id="txt_impuestoadicdescrip" placeholder="Nombre de Impuesto" value="<?php if(@$impuestoadicdescrip != NULL){ print @$impuestoadicdescrip; }?>">
                              </div>
                              <div class="form-group col-md-6">
                                  <label for="txt_impuestoadicvalor">Valor de Impuesto</label>
                                  <input type="text" class="form-control text-right" name="txt_impuestoadicvalor" id="txt_impuestoadicvalor" placeholder="Valor de Impuesto" value="<?php if(@$impuestoadicvalor != NULL){ print @$impuestoadicvalor; }?>">
                              </div>
                            </div>

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_tipoprecio" id="chk_tipoprecio" class="minimal-red" <?php if(@$tipoprecio != NULL){ if(@$tipoprecio == 1){ print "checked='' ";} }?> > Habilitar Gestion de Tipos de Precios</label>
                            </div> 
                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_facturasinexistencia" id="chk_facturasinexistencia" class="minimal-red" <?php if(@$facturasinexistencia != NULL){ if(@$facturasinexistencia == 1){ print "checked='' ";} }?> > Habilitar Facturacion sin Existencia de Producto</label>
                            </div> 
                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_numeroserie" id="chk_numeroserie" class="minimal-red" <?php if(@$numeroserie != NULL){ if(@$numeroserie == 1){ print "checked='' ";} }?> > Habilitar Numero de Serie</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_clientevendedor" id="chk_clientevendedor" class="minimal-red" <?php if(@$clientevendedor != NULL){ if(@$clientevendedor == 1){ print "checked='' ";} }?> > Habilitar Asociacion Automatica entre Cliente y Vendedor</label>
                            </div> 
                            
                            <div class="col-md-12">
                                <label class="col-md-8 text-right" style="margin-right: 0px; padding-right: 0px;" for="txt_impuestoadicvalor">Cuota Minima de Venta para asociar</label>
                                <div class="form-group col-md-4">
                                  <input type="text" class="form-control text-right" name="txt_cuotaclientevendedor" id="txt_cuotaclientevendedor" placeholder="Cuota Minima" value="<?php if(@$cuotaclientevendedor != NULL){ print @$cuotaclientevendedor; }?>">
                                </div>
                            </div>

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_codigocliente" id="chk_codigocliente" class="minimal-red" <?php if(@$codigocliente != NULL){ if(@$codigocliente == 1){ print "checked='' ";} }?> > Habilitar Codigo de Cliente en Venta</label>
                            </div> 

                            <div class="form-group col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_facturaprecioconiva" id="chk_facturaprecioconiva" class="minimal-red" <?php if(@$facturaprecioconiva != NULL){ if(@$facturaprecioconiva == 1){ print "checked='' ";} }?> > Precio de Producto en Venta incluye IVA</label>
                            </div> 

                            <div class="form-group col-md-12">
                                <label class="col-md-7" for="txt_nombreperfilvendedor">Nombre de Perfil Vendedor</label>
                                <div class="form-group col-md-5">
                                  <input type="text" class="form-control text-left" name="txt_nombreperfilvendedor" id="txt_nombreperfilvendedor" placeholder="Nombre de Perfil Vendedor" value="<?php if(@$nombreperfilvendedor != NULL){ print @$nombreperfilvendedor; }?>">
                                </div>
                            </div>

                            <div class="form-group col-md-7" style="padding-top: 0px;">
                              <label>Formato de Impresion de Factura</label>
                              <select id="txt_formatoimpfactura" name="txt_formatoimpfactura" class="form-control">
                                <?php 
                                  $arrformat[] = null;
                                  $arrformat[0] = "Ticket";
                                  $arrformat[1] = "PDF";
                                  $arrformat[2] = "A4";
                                  if(@$facturapdf != NULL){ ?>
                                    <option  value="<?php print $facturapdf; ?>" selected="TRUE"><?php print $arrformat[$facturapdf]; ?></option>
                                    <?php } else { ?>
                                        <option  value="0" selected="TRUE">Seleccione...</option>
                                    <?php } 
                                    $tmpid = 0;  
                                    if(@$facturapdf != NULL) {$tmpid = @$facturapdf;} 
                                    foreach ($arrformat as $i => $item):
                                    if ($tmpid != $i){
                                        ?>
                                        <option value="<?php  print $i; ?>"> <?php  print $arrformat[$i]; ?> </option>
                                        <?php
                                    }    
                                    endforeach;
                                    ?>
                              </select>
                            </div>


                          </div>  <!-- Tab General --> 
                          <div class="tab-pane" id="tabrestaurante">

                            <div class="form-group col-md-12">
                              <label>Impresora para Precuenta</label>
                              <select id="txt_impprecuenta" name="txt_impprecuenta" class="form-control">
                                <?php 
                                  if(@$objprecuenta != NULL){ ?>
                                    <option  value="<?php if(@$objprecuenta != NULL){ print @$objprecuenta->id_comanda; }?>" selected="TRUE"><?php if($objprecuenta->nom_comanda != NULL){ print $objprecuenta->nom_comanda; }?></option>
                                <?php } else { ?>
                                    <option  value="0" selected="TRUE">Seleccione...</option>
                                <?php } 
                                    $tmpid = 0;  
                                    if(@$objprecuenta != NULL) {$tmpid = @$objprecuenta->id_comanda;} 
                                    if (count($impresoras) > 0) {
                                        foreach ($impresoras as $uni):
                                          if ($tmpid != $uni->id_comanda){
                                            ?>
                                            <option value="<?php  print $uni->id_comanda; ?>"> <?php  print $uni->nom_comanda ?> </option>
                                            <?php
                                        }    
                                        endforeach;
                                    }
                                    ?>
                              </select>
                            </div>

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pedidovista" id="chk_pedidovista" class="minimal-red" <?php if(@$pedidovista != NULL){ if(@$pedidovista == 1){ print "checked='' ";} }?> > Mostrar Vista de Pedido</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pedidocliente" id="chk_pedidocliente" class="minimal-red" <?php if(@$pedidocliente != NULL){ if(@$pedidocliente == 1){ print "checked='' ";} }?> > Mostrar Cliente en Pedido</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pedidomesero" id="chk_pedidomesero" class="minimal-red" <?php if(@$pedidomesero != NULL){ if(@$pedidomesero == 1){ print "checked='' ";} }?> > Mostrar Mesero en Pedido</label>
                            </div> 
                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_comandafactura" id="chk_comandafactura" class="minimal-red" <?php if(@$imprimircomandafactura != NULL){ if(@$imprimircomandafactura == 1){ print "checked='' ";} }?> > Imprimir Comanda al Facturar</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_numeroorden" id="chk_numeroorden" class="minimal-red" <?php if(@$habilitanumeroorden != NULL){ if(@$habilitanumeroorden == 1){ print "checked='' ";} }?> > Habilitar Numero de Orden en Factura</label>
                            </div> 

                          </div> 

                          <!--  SErvicio Tecnico -->
                          <div class="tab-pane" id="tabservicio">

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_serviciotecnico" id="chk_serviciotecnico" class="minimal-red" <?php if(@$serviciotecnico != NULL){ if(@$serviciotecnico->habilita_servicio == 1){ print "checked='' ";} }?> > Habilitar Gestion de Servicio</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_servicioserie" id="chk_servicioserie" class="minimal-red" <?php if(@$serviciotecnico != NULL){ if(@$serviciotecnico->habilita_serie == 1){ print "checked='' ";} }?> > Habilitar Busqueda de Producto por Serie</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_serviciodetalle" id="chk_serviciodetalle" class="minimal-red" <?php if(@$serviciotecnico != NULL){ if(@$serviciotecnico->habilita_detalle == 1){ print "checked='' ";} }?> > Habilitar Detalle de Servicio</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_servicioencargado" id="chk_servicioencargado" class="minimal-red" <?php if(@$serviciotecnico != NULL){ if(@$serviciotecnico->habilita_encargado == 1){ print "checked='' ";} }?> > Habilitar Encargado de Servicio</label>
                            </div> 

                             <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_servicioprodutilizado" id="chk_servicioprodutilizado" class="minimal-red" <?php if(@$serviciotecnico != NULL){ if(@$serviciotecnico->habilita_productoutilizado == 1){ print "checked='' ";} }?> > Habilitar Productos Utilizados</label>
                            </div>  

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_servicioabono" id="chk_servicioabono" class="minimal-red" <?php if(@$serviciotecnico != NULL){ if(@$serviciotecnico->habilita_abono == 1){ print "checked='' ";} }?> > Habilitar Abonos de Servicio</label>
                            </div>  

                            <div class="form-group col-md-12">
                              <label>Producto utilizado para generar Factura</label>
                              <select id="pro_servicio" name="pro_servicio" class="form-control">
                              <?php 
                                if(@$pro_servicio != NULL){ ?>
                                <?php } else { ?>
                                <option  value="" selected="TRUE">Seleccione Producto...</option>
                                <?php } 
                                  if (count($pro_servicio) > 0) {
                                    foreach ($pro_servicio as $pro):
                                        if(@$serviciotecnico->producto_servicio_factura != NULL){
                                            if($serviciotecnico->producto_servicio_factura == $pro->pro_id){ ?>
                                                 <option value="<?php  print $pro->pro_id; ?>" selected="TRUE"> <?php  print $pro->pro_nombre; ?> </option>
                                                <?php
                                            }else{ ?>
                                                <option value="<?php  print $pro->pro_id; ?>" > <?php  print $pro->pro_nombre; ?> </option>
                                                <?php
                                            }
                                        }else{ ?>
                                            <option value="<?php  print $pro->pro_id; ?>" > <?php  print $pro->pro_nombre; ?> </option>
                                            <?php
                                            }   ?>
                                        <?php
                                    endforeach;
                                  }
                                ?>
                              </select> 
                            </div>


                          </div> 

                          <!--  Gestion de Citas -->
                          <div class="tab-pane" id="tabcitas">

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_gestioncitas" id="chk_gestioncitas" class="minimal-red" <?php if(@$gestioncitas != NULL){ if(@$gestioncitas == 1){ print "checked='' ";} }?> > Habilitar Gestion de Citas</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_recomendacioncitas" id="chk_recomendacioncitas" class="minimal-red" <?php if(@$recomendacioncitas != NULL){ if(@$recomendacioncitas == 1){ print "checked='' ";} }?> > Habilitar Recomendaciones en Citas</label>
                            </div> 

                            <div class="form-group col-md-12">
                             <label class="col-md-5">Vincular Resultado de Cita</label>
                             <div class="col-md-7">
                              <select id="resultadocitas" name="resultadocitas" class="form-control">
                              <?php 
                                if(@$lstresultadocitas != NULL){ ?>
                                <?php } else { ?>
                                <option  value="" selected="TRUE">Seleccione Producto...</option>
                                <?php } 
                                  if (count($lstresultadocitas) > 0) {
                                    foreach ($lstresultadocitas as $res):
                                        if(@$resultadocitas != NULL){
                                            if($resultadocitas == $res->valor){ ?>
                                                 <option value="<?php  print $res->valor; ?>" selected="TRUE"> <?php  print $res->vinculo; ?> </option>
                                                <?php
                                            }else{ ?>
                                                <option value="<?php  print $res->valor; ?>" > <?php  print $res->vinculo; ?> </option>
                                                <?php
                                            }
                                        }else{ ?>
                                            <option value="<?php  print $res->valor; ?>" > <?php  print $res->vinculo; ?> </option>
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

                          <!--  Configuracion de Producto -->
                          <div class="tab-pane" id="tabproducto">

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pro_descripcion" id="chk_pro_descripcion" class="minimal-red" <?php if(@$procfg != NULL){ if(@$procfg->habilita_descripcion == 1){ print "checked='' ";} }?> > Habilitar Ingreso de Descripcion</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pro_imagen" id="chk_pro_imagen" class="minimal-red" <?php if(@$procfg != NULL){ if(@$procfg->habilita_imagen == 1){ print "checked='' ";} }?> > Habilitar Ingreso de Imagen</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pro_ingrediente" id="chk_pro_ingrediente" class="minimal-red" <?php if(@$procfg != NULL){ if(@$procfg->habilita_ingredientepreparado == 1){ print "checked='' ";} }?> > Habilitar Seleccion de Ingrediente / Preparado</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pro_clasificacion" id="chk_pro_clasificacion" class="minimal-red" <?php if(@$procfg != NULL){ if(@$procfg->habilita_clasificacion == 1){ print "checked='' ";} }?> > Habilitar Seleccion de Clasificacion</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pro_variante" id="chk_pro_variante" class="minimal-red" <?php if(@$procfg != NULL){ if(@$procfg->habilita_variante == 1){ print "checked='' ";} }?> > Habilitar Configuracion de Variantes</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pro_comanda" id="chk_pro_comanda" class="minimal-red" <?php if(@$procfg != NULL){ if(@$procfg->habilita_comanda == 1){ print "checked='' ";} }?> > Habilitar Configuracion de Impresion de Comanda</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pro_maximo" id="chk_pro_maximo" class="minimal-red" <?php if(@$procfg != NULL){ if(@$procfg->habilita_maximominimo == 1){ print "checked='' ";} }?> > Habilitar Ingreso de Maximo y Minimo</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pro_deducible" id="chk_pro_deducible" class="minimal-red" <?php if(@$procfg != NULL){ if(@$procfg->habilita_deducible == 1){ print "checked='' ";} }?> > Habilitar Seleccion de Deducible</label>
                            </div> 

                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                <label class="col-md-12"><input type="checkbox" name="chk_pro_conceptoretencion" id="chk_pro_conceptoretencion" class="minimal-red" <?php if(@$procfg != NULL){ if(@$procfg->habilita_conceptoretencion == 1){ print "checked='' ";} }?> > Habilitar Seleccion de Concepto de Retencion</label>
                            </div> 

                          </div> 

                         </div>  <!-- Tab Control --> 
                        </div>  <!-- Nav Tab Control --> 

                        </div>
                        <div  align="center" class="box-footer">
                            <div class="form-actions ">
                                <button type="submit" class="btn btn-success btn-grad btn-lg no-margin-bottom">
                                    <i class="fa fa-save "></i> Guardar
                                </button>
                            </div>
                        </div>
                   </form> 
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

