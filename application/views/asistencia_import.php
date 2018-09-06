<style>
    #contenido_ret{
        width: 500px;       
    }   

  
</style>



<script type="text/javascript">


   $(document).ready(function () {

    $("#formimport").validationEngine();

  });     

</script>
<div id = "contenido_ret" class="col-md-6">
    <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"></i> Importar Archivo de Asistencia</h3>
        </div>
        <form enctype="multipart/form-data" id="formimport" name="formimport" method='POST' action="<?=base_url();?>Asistencia/import_archivo_asist">
            <div class="box-body">
                <div class="row">

                  <!-- MAX_FILE_SIZE debe preceder al campo de entrada del fichero -->
                  <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                  <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
                  <!-- Enviar este fichero:  -->
                  <input name="fichero_usuario" type="file" />

<!--                   <input type="submit" value="Enviar fichero" />
 -->
                </div>
            </div>

            <div  align="center" class="box-footer">
                <div class="form-actions ">
                    <button type="submit" class="btn btn-success btn-grad no-margin-bottom ">
                    <i class="fa fa-upload"></i> Importar
                </button>
                </div>
            </div>
        </form>
    </div>
</div>