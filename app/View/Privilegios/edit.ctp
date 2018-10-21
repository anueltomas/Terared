

<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-body">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Privilegio</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="PrecioServicio form">
            <?php echo $this->Form->create('Privilegio'); ?>
              <div class="box-body">

              <div class="form-group">
                  <?php echo $this->Form->input('id'); ?>
                </div>
                
                <div class="form-group">
                  <?php echo $this->Form->input('nombreprivilegio', array('label' => 'Nombre de Privilegio', 'class' => 'form-control', 'placeholder' => 'Nombre Privilegio')); ?>
                </div>

                
              </div>
              <!-- /.box-body -->

              <div class="form-group">
                <?php echo $this->Form->button('Guardar', array('class' => "btn btn-primary pull-left", 'escape' => false)); ?>      

                <?php echo $this->Form->end(); ?>
   

                <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array(
                  'action' => 'index',),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
                ?>
              </div>
            </div>
        </div>
    </div>
</div>
          <!-- /.box -->
