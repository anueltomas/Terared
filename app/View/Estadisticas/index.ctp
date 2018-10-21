<?php //debug($datos[0]['servicios']['nombre']); ?>

<?php echo $this->Html->script(array('myjs/estadisticas')); ?>
<?php echo $this->Html->script(array('myjs/estadisticasServicios')); ?>

<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Estadísticas por usuarios</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
	              <div id="grafico" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

            </div>
</div>

<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Estadísticas por servicio</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
	              <div id="graficoServicios" style="min-width: 500px; height: 600px; max-width: 700px; margin: 0 auto"></div>
            </div>
</div>
            <!-- /.box-body -->
         

