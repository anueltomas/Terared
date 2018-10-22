
<?php //debug($prueba); ?>



<?php

	$this->Paginator->options(array(
		'update' => '#tabla-tickets',
		'before' => $this->Js->get('#procesando')->effect('fadeIn', array('buffer' => false)),
		'complete' => $this->Js->get('#procesando')->effect('fadeOut', array('buffer' => false))
		)
	);

?>

<div id="tabla-tickets">

<div class="box box-success box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Facturas emitidas</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	

    

	<div class="box-body">
	<br><br>

      <?php if ($turnos == null) { ?>

      <h1>No existen facturas generadas</h1>

      <?php } else { ?>



      <div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('N° Factura'); ?></th>
						<th><?php echo $this->Paginator->sort('Cliente'); ?></th>
						<th><?php echo $this->Paginator->sort('Fecha'); ?></th>
						<th><?php echo $this->Paginator->sort('Total'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($turnos as $turno): ?>
						
					<tr>
				<td><?php echo h($turno['Factura']['nfactura']); ?>&nbsp;</td>

				<td><?php echo h($turno['Cliente']['nombre']); ?>&nbsp;</td>

				<td><?php echo h($turno['Factura']['created']); ?>&nbsp;</td>

				<td><?php echo number_format($turno['Factura']['totalfactura'], 2,",","."); ?> Bs.</td>

						
				
				
				<td class="actions">
					<?php echo $this->Html->link(__('Ver Tickets'), array('controller' => 'tickets', 'action' => 'tickets_facturas', $turno['Ticket']['id'], $idcierre), array('class' => 'btn btn-sm btn-danger')); ?>
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
			<?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", $this->request->referer(), array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
			?>
		</div>
	</div>



	</div>


	
	
</div>

