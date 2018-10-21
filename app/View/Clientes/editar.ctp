
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-body">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Cliente</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="PrecioServicio form">
            <?php echo $this->Form->create('Cliente'); ?>
              <div class="box-body">

              <div class="form-group">
                  <?php echo $this->Form->input('id'); ?>
                </div>
                
                <div class="form-group">
                  <?php echo $this->Form->input('nombre', array('label' => 'Nombre del cliente', 'class' => 'form-control', 'placeholder' => 'Nombre')); ?>
                </div>
                
              
                    <?php echo $this->Form->input('estadocliente', array('type' => "hidden", 'label' => "Estado", 'default' => True)); ?>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
              <?php echo $this->Form->button('Guardar', array('class' => "btn btn-primary")); ?>
              </div>
              <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
          <!-- /.box -->
