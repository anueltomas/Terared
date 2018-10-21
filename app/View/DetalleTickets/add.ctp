

<div class="box box-primary box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-user"></i> Añadir Servicio a Ticket</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>

           <div class="box-body">
  
          
            <?php echo $this->Form->create('DetalleTicket'); ?>
             <fieldset>
              <legend><?php echo __('Datos generales'); ?></legend>
                <div class="row-fluid">
                  <div class="col-md-4">
                <label>Servicio</label>
                <div class="input-group">
                  <?php echo $this->Form->input('servicio_id', array('label' => false, 'class' => 'form-control')); ?>
                </div>
                </div>
              </div>

                <div class="row-fluid">
                  <div class="col-md-4">
                  <?php echo $this->Form->input('cantidad', array('label' => 'Cantidad', 'class' => 'form-control', 'placeholder' => 'Cantidad por el servicio', 'type' => 'numeric')); ?>
                  </div>
                </div>

               <?php echo $this->Form->input('usuario_id', array('type' => 'hidden','value' => $current_user['id'])); ?>

                
              <!-- /.box-body -->

               </fieldset>
            </div>
           
 
  <div class="box-footer">
    <div class="form-group">
      <?php echo $this->Form->button("<i class='fa fa-save'></i> Grabar", array(
        'type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false)); 
      ?>
      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'tickets', 'action' => 'ticketactual', $current_user['id']),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>
  </div>








