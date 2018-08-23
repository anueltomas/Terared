<?php //debug($totales); ?>
<?php //debug($detalles); ?>
<?php //debug($tickets); ?>
<?php //debug($pagado); ?>

<div class="box box-danger box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Detalles del ticket por cobrar</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	<?php $total_pagado = $pagado['0']['0']['subtotal']; ?>

	<?php if ($total_pagado == null || $total_pagado == 0): ?>

		<?php $total_pagado = 0; ?>
		
	<?php endif ?>

	

	<div class="box-body">
	
<?php //debug($detalles) ?>
<?php //debug($datosTicket) ?>
      <div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Nombre del servicio</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Monto a pagar</th>
						<th>Usuario responsable</th>
						
					</tr>
				</thead>
				<tbody>
					<?php foreach ($detalles as $detalle): ?>
						
					<tr>
				
				<td><?php echo h($detalle['Servicio']['nombreservicio']); ?>&nbsp;</td>
				<td><?php echo h($detalle['DetalleTicket']['cantidad']); ?>&nbsp;</td>
				<td><?php echo number_format($detalle['DetalleTicket']['precio'], 2,",","."); ?> Bs.</td>
				<td><?php echo number_format($detalle['DetalleTicket']['monto'], 2,",","."); ?> Bs.</td>
				<td><?php echo h($detalle['Usuario']['nombreusuario']); ?>&nbsp;</td>

				
		


			</tr>

					<?php endforeach; ?>
				</tbody>
			</table>

			<?php echo $this->Form->create('Ticket'); ?>

				<div class="row-fluid">

		                  <div class="col-md-4">
		                  
		                  		<?php echo $this->Form->input('forma_pago', array('label' => 'Forma de Pago', 'options' => array('Punto','Efectivo', 'Transferencia'), 'class' => 'form-control', 'Default' => 'Punto')) ?>
		                  </div>

                </div>


               

		                  <div class="col-md-4">
		                  	<label>Monto Pagado</label>
		                  		<div class="input-group">
			                  		<?php echo $this->Form->input('', array('label' => false, 'class' => 'form-control', 'Default' => 'Punto', 'disabled' => true, 'value' => number_format($total_pagado, 2,",","."))); ?> 
			                  		<span class="input-group-btn">
				                      <?php echo $this->Html->link('Detalle de pagos', array('controller' => 'detallePagos', 'action' => 'detalle_pagos', $idTicket), array('class' => 'btn btn-primary')); ?>
				                    </span>
			                    </div>

		                  </div>
        

           <div class="row-fluid">
			<h3 class="pull-right">
  				<span class="total">Total a cobrar:</span>
				<span id="total" class="total">
    				<?php echo number_format($totalticket, 2,",","."); ?> Bs.
				</span>
			</h3>
		</div>

			
			
		</div>

		<?php $idTicket = $detalles[0]['Ticket']['id']; ?>

			<?php echo $this->Form->hidden('IdTicket', array('value' => $idTicket)); ?>

		</div>

		

	</div><!-- fin box-body -->

	<div class="box-footer">
    <div class="form-group">

    <?php if ($total_pagado < $totalticket) {
    	 echo $this->Form->submit('Ingresar Pago', array('type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false, 'class' =>'btn btn-success pull-left', )); 
    } else {
      

      echo $this->Html->link("<i class='fa fa-save'></i> Procesar Ticket", array('action' => 'procesar_ticket', $idTicket), array('type' => 'submit', 'class' => 'btn btn-primary pull-left', 'escape' => false)); 
     
  }
      ?>

      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('action' => 'caja'), array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>
    </div>
  </div>
	
	
</div>


