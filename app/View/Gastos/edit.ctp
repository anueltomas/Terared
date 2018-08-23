
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-body">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Gasto</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="servicios form">
            <?php echo $this->Form->create('Gasto'); ?>
              <div class="box-body">
                <div class="form-group">

                  <?php echo $this->Form->input('id'); ?>
                  
                  <?php echo $this->Form->input('concepto', array('label' => 'Concepto', 'class' => 'form-control', 'placeholder' => 'Descripción')); ?>
                </div>

                <?php echo $this->Form->input('montogasto', array('type' => 'numeric', 'label' => 'Monto', 'class' => 'form-control', 'placeholder' => 'Monto')); ?>
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


