<?php
  /* Consulta para mostrar la foto del Usuario */
  $usu_mod = &get_instance();
  $usu_mod->load->model("usuario_model");
  $usua = $this->session->userdata('usua');
  $id = $usua->id_usu;
  $perfil = $usua->perfil;
  $fic_fot = $usu_mod->usuario_model->usu_get_fot($id);
  /* Consulta Accesos al menu */

/*  $rol_mod = &get_instance();
  $rol_mod->load->model("rol_model");
  $rolacces = $rol_mod->rol_model->rol_modulo($id);

  foreach ($rolacces as $r){
    $mod = $r->desc_mod_det;

    switch ($mod){
      case "Categorias": $cat_ver = $r->accion;

    }

  }
  */

/*
  $parametro = &get_instance();
  $parametro->load->model("Parametros_model");
  $pedidovista = $parametro->Parametros_model->sel_pedidovista();
  $parametro->load->model("Parametros_model");
  $tp = $parametro->Parametros_model->tipo_precio();
*/

?>

<script>
  $( document ).ready(function() {

    $(document).on('click', '.abrircajaefectivo', function(){
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Cajaapertura/existecajaefectivo_noabierta');?>",
        success: function(json) {
          if (json.resu > 0){
            location.replace("<?php print $base_url ?>cajaapertura");
          } else {
            alert("No existen cajas disponibles para la apertura.");
            return false;
          }
        }
      });
    });  

    $(document).on('click', '.cerrarcajaefectivo', function(){
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('Cajacierre/existecajaefectivo_abierta');?>",
        success: function(json) {
          if (json.resu > 0){
            location.replace("<?php print $base_url ?>cajacierre");
          } else {
            alert("No existen cajas abiertas.");
            return false;
          }
        }
      });
    });  

  });

</script>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img class="img-rounded" <?php
            if (@$fic_fot != NULL) {
              if ($fic_fot->fot_usu) { print " src='data:image/jpeg;base64,$fic_fot->fot_usu'"; } 
              else { ?> src="<?php print base_url(); ?>public/img/perfil.jpg" <?php } } 
            else { ?> src="<?php print base_url(); ?>public/img/perfil.jpg" <?php } ?> 
            alt="" onerror="this.src='<?php print base_url() . "public/img/perfil.jpg"; ?>';" />
        </div>
        <div class="pull-left info">
          <p><?php  print $this->session->userdata("sess_na"); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Usuario Actual</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menú Principal</li>
        
        <li class="<?php  if ($content == 'inicio') { print 'active';} ?> ">
          <a href="<?php   print $base_url ?>inicio"><i class="fa fa-home"></i> <span>Inicio</span></a>
        </li> 

        <?php if($perfil != 2) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-address-book"></i> <span>EMPLEADOS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($perfil == 1) { ?>
            <li><a href="<?php print $base_url ?>departamento"><i class="fa fa-sort-amount-asc"></i> Departamentos</a></li>
            <?php } ?> 
            <?php if($perfil == 1) { ?>
            <li><a href="<?php print $base_url ?>cargo"><i class="fa fa-balance-scale"></i> Cargos</a></li>
            <?php } ?>
            <?php if($perfil == 1) { ?>
            <li><a href="<?php print $base_url ?>tipotrabajador"><i class="fa fa-balance-scale"></i> Tipo de trabajador </a></li>
            <?php } ?>            
            <?php if($perfil == 1) { ?>
            <li><a href="<?php print $base_url ?>empleado"><i class="fa fa-id-card"></i> Empleados</a></li>
            <?php } ?> 
            <?php if($perfil == 1) { ?>
            <li><a href="<?php print $base_url ?>empresa"><i class="fa fa-home"></i> Empresas</a></li>
            <?php } ?> 
            <?php if($perfil == 1) { ?>
            <li><a href="<?php print $base_url ?>rubro"><i class="fa fa-home"></i> Rubros</a></li>
            <?php } ?> 

          </ul>
        </li> 
        <?php } ?> 

        <li class="treeview">
          <a href="#">
            <i class="fa fa-handshake-o"></i> <span>NOMINA</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php print $base_url ?>rol"><i class="fa fa-calendar"></i> Rol de Pagos</a></li>

          </ul>
        </li> 
        <li class="treeview">
          <a href="#">
            <i class="fa fa-hand-paper-o"></i> <span>ASISTENCIA</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php print $base_url ?>rolpagos"><i class="fa fa-calendar"></i> Rol de Pagos</a></li>

          </ul>
        </li> 
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gears"></i> <span>CONFIGURACION</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          
          <ul class="treeview-menu">
          <?php if($perfil == 1) { ?>
          <li><a href="<?php print $base_url ?>ciudad"><i class="fa fa-list-alt"></i> Ciudades</a></li>
          <?php } ?> 
          <?php if($perfil == 1) { ?>
          <li><a href="<?php print $base_url ?>provincia"><i class="fa fa-universal-access"></i> Provincias</a></li>
          <?php } ?> 
          <?php if($perfil == 1) { ?>
          <li><a href="<?php print $base_url ?>paises"><i class="fa fa-universal-access"></i> Paises</a></li>
          <?php } ?> 
          <?php if($perfil == 1) { ?>
          <li><a href="<?php print $base_url ?>empresa"><i class="fa fa-fort-awesome"></i> Empresa</a></li>
          <?php } ?>          
          <?php if($perfil == 1) { ?>
          <li><a href="<?php print $base_url ?>usuarios"><i class="fa fa-user-circle-o"></i> Usuarios</a></li>
          <?php } ?>          
          <?php if($perfil == 1) { ?>          
          <li><a href="<?php print $base_url ?>correo"><i class="fa fa-envelope-o" aria-hidden="true"></i> Correo</a></li>
          <?php } ?>
          <?php if($perfil == 1) { ?>          
          <li><a href="<?php print $base_url ?>banco"><i class="fa fa-university" aria-hidden="true"></i> Bancos</a></li>
          <?php } ?>
          <?php if($perfil == 1) { ?>          
          <li><a href="<?php print $base_url ?>parametros"><i class="fa fa-gears" aria-hidden="true"></i> Parametros</a></li>
          <?php } ?>
          

          </ul>
        </li> 



  
        <?php if($perfil == 1) { ?>
        <li class="treeview">
            <a href="#">
              <i class="fa fa-cubes"></i> <span>Utilitarios</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php print $base_url ?>backup"><i class="fa fa-fort-awesome"></i> Respaldo de Base de Datos </a></li>
            </ul>
        </li>
        <?php } ?>            





      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>