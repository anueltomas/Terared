<?php $fechaprecio = date('Y-m-d'); ?>

<div class="box box-primary box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-user"></i> Editar Servicios</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  
    <div class="box-body">
            <?php echo $this->Form->create('Servicio',array(
      'inputDefaults' => array(
        'div'   => 'form-group',
                //'label' => false,
                'class' => 'input-lg'))); ?>
              <fieldset>
              <legend><?php echo __('Datos'); ?></legend>

                <div class="form-group">
                  <?php echo $this->Form->input('id'); ?>
                </div>

                  <div class="row-fluid">
                  <div class="col-md-6">
                  <?php echo $this->Form->input('codigoservicio', array('label' => 'Código del Servicio', 'class' => 'form-control', 'placeholder' => 'Código')); ?>
                  </div>
                </div>

                  <div class="row-fluid">
                  <div class="col-md-6">
                  <?php echo $this->Form->input('nombreservicio', array('label' => 'Nombre del Servicio', 'class' => 'form-control', 'placeholder' => 'Nombre')); ?>
                  </div>
                </div>

                
                  <div class="row-fluid">
                  <div class="col-md-6">
                <label>Tipo Servicio</label>
                <div class="input-group">
                  <?php echo $this->Form->input('tservicio_id', array('label' => false, 'class' => 'form-control')); ?>
                  <div class="input-group-btn">
                    <?php echo $this->Html->link('Nuevo Tipo', array('controller' => 'tservicios', 'action' => 'nuevo'), array('class' => 'btn btn-primary')); ?>
                  </div>
                </div>
                </div>
              </div>

                
                  <div class="row-fluid">
                  <div class="col-md-4">
                  <?php echo $this->Form->input('precio', array('label' => 'Precio', 'class' => 'form-control', 'placeholder' => 'Precio', 'type' => 'numeric')); ?>
                  </div>
                </div>

                <?php echo $this->Form->input('fechaprecio', array('type' => 'hidden','value' => $fechaprecio)); ?>
                
                
                  <div class="row-fluid">
                  <div class="col-md-4">
                    <div class="checkbox">
                      <label>
                        <?php echo $this->Form->input('estadoservicio', array('type' => "checkbox", 'label' => "Estado del Servicio", 'default' => True)); ?>
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






