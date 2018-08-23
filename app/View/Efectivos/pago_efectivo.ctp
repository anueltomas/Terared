<?php //debug($monto) ?>

<div class="box box-danger box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Pago en Efectivo</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	
	<div class="box-body">
	
   <?php echo $this->Form->create('Efectivo', array(
      'inputDefaults' => array(
        'div'   => 'form-group',
                //'label' => false,
                'class' => 'input-lg'))); ?>

              <fieldset>
      			<legend><?php echo __('Datos del pago'); ?></legend>
                <div class="row-fluid">
                  <div class="col-md-4">
                  <?php echo $this->Form->input('monto', array('label' => 'Monto por pagar', 'class' => 'form-control', 'placeholder' => 'Monto', 'type' => 'numeric', 'value' => $porpagar)); ?>
                  </div>
                  </div>
                

		
	</div> <!-- FIN box-body-->

	<div class="box-footer">
    <div class="form-group">
      

      <?php echo $this->Form->submit('Pagar', array('type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false, 'class' =>'btn btn-success pull-left', )); ?>

      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'tickets', 'action' => 'ver', $idTicket), array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>
    </div>
  </div>
	
	<?php echo $this->Form->end(); ?>
	
</div>


