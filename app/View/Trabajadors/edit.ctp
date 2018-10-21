<div class="box box-primary box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-user"></i> Editar Trabajador</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  
          <div class="box-body">

            <?php echo $this->Form->create('Trabajador',array(
      'inputDefaults' => array(
        'div'   => 'form-group',
                //'label' => false,
                'class' => 'input-lg'))); ?>
              <fieldset>
              <legend><?php echo __('Datos'); ?></legend>

                <div class="row-fluid">
                    <?php echo $this->Form->input('id'); ?>
                  
                </div>


                <div class="row-fluid">
                  <div class="col-md-4">
                  <?php echo $this->Form->input('cedula', array('label' => 'Cédula de identidad', 'class' => 'form-control', 'placeholder' => 'Cédula del trabajador')); ?>
                  </div>
                </div>

                <div class="row-fluid">
                  <div class="col-md-4">
                  <?php echo $this->Form->input('nombre', array('label' => 'Nombre', 'class' => 'form-control', 'placeholder' => 'Nombre')); ?>
                  </div>
                </div>

                <div class="row-fluid">
                  <div class="col-md-4">
                  <?php echo $this->Form->input('apellido', array('class' => 'form-control', 'label' => 'Apellido', 'placeholder' => 'Apellido')); ?>
                  </div>
                </div>

               
                <div class="row-fluid">
                  <div class="col-md-4">
                  <div class="input-group">
                    <?php echo $this->Form->input('telefono', array('class' => 'form-control', 'label' => 'Teléfono', 'placeholder' => 'Teléfono')); ?>
                  </div>
                  </div>
                </div>

                <div class="row-fluid">
                  <div class="col-md-4">
                    <div class="checkbox">
                      <label>
                        <?php echo $this->Form->input('estadotrabajador', array('type' => "checkbox", 'label' => "Estado", 'default' => True)); ?>
                      </label>
                    </div>
                  </div>
              </div>

                
              
              <!-- /.box-body -->

              </fieldset>

            </div>
 
  <div class="box-footer">
    <div class="form-group">
      <?php echo $this->Form->button("<i class='fa fa-save'></i> Grabar", array(
        'type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false)); 
      ?>
      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array(
        'action' => 'index',),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>

</div>