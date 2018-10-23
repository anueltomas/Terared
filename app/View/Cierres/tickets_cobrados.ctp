<?php //debug($totales); ?>
<?php //debug($detalles); ?>
<?php //debug($tickets); ?>
<?php //debug($cajero); ?>
<?php //debug($pagos); ?>
<?php //debug($idcierre); ?>

<?php CakeSession::write('idFactura', $idfactura); ?>



<?php

	$this->Paginator->options(array(
		'update' => '#tabla-tickets',
		'before' => $this->Js->get('#procesando')->effect('fadeIn', array('buffer' => false)),
		'complete' => $this->Js->get('#procesando')->effect('fadeOut', array('buffer' => false))
		)
	);

?>

<div id="tabla-tickets">

<div class="box box-warning box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Historico de tickets</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	

    

	<div class="box-body">
	<br><br>

      <?php if ($tickets == null) { ?>

      <h1>No existen tickets generados</h1>

      <?php } else { ?>



      <div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('N° Ticket'); ?></th>
						<th><?php echo $this->Paginator->sort('Nombre del Cliente'); ?></th>
						<th><?php echo $this->Paginator->sort('Total'); ?></th>
						<th><?php echo $this->Paginator->sort('Fecha'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($tickets as $ticket): ?>
						
					<tr>
				<td><?php echo h($ticket['Ticket']['numeroticket']); ?>&nbsp;</td>

				<td><?php echo h($ticket['Cliente']['nombre']); ?>&nbsp;</td>

				<td><?php echo number_format($ticket['Ticket']['montoticket'], 2,",","."); ?> Bs.</td>

				<td><?php echo h($ticket['Ticket']['modified']); ?></td>
		
				
				
				<td class="actions">
					<?php echo $this->Html->link(__('Ver'), array('controller' => 'cierres', 'action' => 'detalle_tickets', $ticket['Ticket']['id'], $idturno), array('class' => 'btn btn-sm btn-danger')); ?>
				</td>

			</tr>

					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="progress oculto" id="procesando">
	        	<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100% Complete</span>
	        	</div>
	      	</div>
			<p>
				<?= $this->Paginator->counter('Página {:page} de {:pages}, mostrando {:current} registro(s) de {:count} en total, desde {:start}, hasta {:end}');
						?>
			</p>
			
				<ul class="pagination pagination-sm no-margin pull-left">
			        <li><?php echo $this->Paginator->prev('<' .__('Anterior'), array('tag' => false), null, array('class' => 'prev disabled')); ?></li>
						<?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
					<li><?php echo $this->Paginator->next(__('Siguiente') . ' >', array('tag' => false), null, array('class' => 'next disabled')); ?></li>
		        </ul>

		        <?php echo $this->Js->writeBuffer(); ?>
			
		</div>
		</div>
</div>

<?php } ?>

<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'cierres', 'action' => 'facturas_emitidas', $idturno), array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>
			?>
		</div>
	</div>



	</div>


	
	
</div>

