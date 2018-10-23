
<?php //debug($prueba); ?>

<?php $idcierre = CakeSession::read('idCierre'); ?>

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
						<th>N° Factura</th>
						<th>Fecha</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($turnos as $turno): ?>
						
					<tr>
				<td><?php echo h($turno['facturas']['nfactura']); ?>&nbsp;</td>

				<td><?php echo h($turno['facturas']['created']); ?>&nbsp;</td>

				<td><?php echo number_format($turno['facturas']['totalfactura'], 2,",","."); ?> Bs.</td>

						
				
				
				<td class="actions">
					<?php echo $this->Html->link(__('Ver Tickets'), array('controller' => 'cierres', 'action' => 'tickets_cobrados', $turno['facturas']['id'], $idturno), array('class' => 'btn btn-sm btn-danger')); ?>
				</td>

			</tr>

					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="progress oculto" id="procesando">
	        	<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100% Complete</span>
	        	</div>
	      	</div>
						
				
			
		</div>
		</div>
</div>

<?php } ?>

<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'cierres', 'action' => 'ver', $idturno, $idcierre), array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false));
			?>
		</div>
	</div>



	</div>


	
	
</div>

