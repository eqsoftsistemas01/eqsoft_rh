<?php
/* ------------------------------------------------
  ARCHIVO: Inicio.php
  DESCRIPCION: Vista de la página de inicio de la aplicación.
  FECHA DE CREACIÓN: 30/06/2017
 * 
  ------------------------------------------------ */
// Setear el título HTML de la página


print "<script>document.title = 'EQsoft - Inicio' </script>";

/*  $objupdate = &get_instance();
  $objupdate->load->model("Update_model");
  $str1 = $objupdate->Update_model->actualizabase();
 <?php print $str1; ?>*/

?>
<style type="text/css">
    .img_res{
        background:url("<?php print base_url(); ?>public/img/home_app001.jpg");
        background-size: cover;       /* For flexibility */
    }
</style>
  <div class="content-wrapper">
    <section class="content-header">
        <h1>
            Inicio
            <small>Página Principal del Sistema</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php print $base_url ?>inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <!--        <li class="active">Página Principal del Sistema</li>-->
        </ol>
    </section>
    <!-- Main content -->
    <section class="content responsive img_res animated fadeIn" style="height: 877px">
    </section>

  </div>