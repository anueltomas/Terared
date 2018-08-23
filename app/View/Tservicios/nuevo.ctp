
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-body">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Tipo de Servicio</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="tservicios form">
            <?php echo $this->Form->create('Tservicio'); ?>
              <div class="box-body">
                
                <div class="form-group">
                  <?php echo $this->Form->input('nombretipo', array('label' => 'Tipo del Servicio', 'class' => 'form-control', 'placeholder' => 'Tipo de Servicio')); ?>
                </div>
                
                <div class="checkbox">
                  <label>
                    <?php echo $this->Form->input('estadotipo', array('type' => "checkbox", 'label' => "Estado", 'default' => True)); ?>
                  </label>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
              <?php echo $this->Form->end('Guardar', array('class' => "btn btn-primary")); ?>
              </div>
            </div>
        </div>
    </div>
</div>
          <!-- /.box -->