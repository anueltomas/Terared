<?php //debug($totales); ?>
<?php //debug($detalles); ?>
<?php //debug($tickets); ?>
<?php //debug($cajero); ?>

<?php echo $this->Html->script(array('myjs/buscar')); ?>
<div class="box box-danger box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Tickets por cobrar</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	

     <div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-rocket'></i> Express", array(
				'action' => 'iniciar_caja',),array('class' => 'btn btn-warning pull-left', 'escape' => false)); 
			?>	

			<?php echo $this->Html->link("<i class='fa fa-ticket'></i> Ticket Actual", array(
				'action' => 'ticketactual'),array('class' => 'btn bg-navy pull-left', 'escape' => false)); 
			?>		

			<?php echo $this->Html->link("<i class='fa fa-remove'></i> Cerrar caja", array(
				'action' => 'cerrar_caja', $cajero['TurnoCajero']['id']),array('class' => 'btn btn-danger pull-right', 'escape' => false)); 
			?>	
		</div>
	</div>

	<div class="box-body">
	<!-- search form (Optional) -->
     
            <?php echo $this->Form->create('Servicio', array('type' => 'GET', 'class' => 'sidebar-form', 'url' => array('controller' => 'servicios', 'action' => 'buscar'))); ?>
              <div class="input-group">
			      	<?php echo $this->Form->input('buscar', array('label' => false, 'div' => false, 'id' => 'b', 'class' => 'form-control s', 'autocomplete' => 'off', 'placeholder' => 'Buscar servicio...' )); ?>
			      	<span class="input-group-btn">
			      	<?php echo $this->Form->button("<i class='fa fa-search'></i>", array('div' => false, 'class' => 'btn btn-flat')); ?>
			      	</span>
			  </div>
      		<?php echo $this->Form->end(); ?>
   
      <!-- /.search form -->

      <?php if ($tickets == null) { ?>

      <h1>No existen tickets generados</h1>

      <?php } else { ?>

      <div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>N° Ticket</th>
						<th>Nombre del Cliente</th>
						<th>Monto a pagar</th>
						<th class="actions"><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($tickets as $ticket): ?>
						
					<tr>
				<td><?php echo h($ticket['Ticket']['numeroticket']); ?>&nbsp;</td>

				<td><?php echo h($ticket['Cliente']['nombre']); ?>&nbsp;</td>

				<td><?php echo number_format($ticket['Ticket']['montoticket'], 2,",","."); ?> Bs.</td>

						
				<?php if($ticket['Ticket']['estadoticket'] == 'Por pagar') { ?>
				
				
				<td class="actions">
					<?php echo $this->Html->link(__('Ver'), array('action' => 'ver', $ticket['Ticket']['id']), array('class' => 'btn btn-sm btn-default')); ?>
				</td>

				<?php } ?>
			


			</tr>

					<?php endforeach; ?>
				</tbody>
			</table>
			<p>
				<?php
					echo $this->Paginator->counter(array(
						'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
					?>
			</p>
			<div class="paging">
				<?php
					echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ''));
					echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
				?>
			</div>
		</div>
		</div>

<?php } ?>

	</div>
	
	
</div>


