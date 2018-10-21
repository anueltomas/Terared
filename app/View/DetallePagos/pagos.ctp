
<!-- -->

<?php //debug($detalletransferencias); ?>
<?php //debug($detalleefectivos); ?>
<?php //debug($detallepuntos); ?>


<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-server"></i> Detalle de pago</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	<?php if ($detalletransferencias != null || $detalleefectivos != null || $detallepuntos != null) {

		$pagos = true;

	} else {

		$pagos = false; 

	}

	
	?>

	<div class="box-body">

	<?php if ($pagos == true) { ?>
	<div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
					<th>Forma de pago</th>
					<th>Monto</th>
					</tr>
				</thead>
				<tbody>

				<?php if ($detalletransferencias != null) { ?>
					<?php foreach ($detalletransferencias as $transferencia): ?>
					<tr>
						<td>Transferencia</td>
						
						<td><?php echo number_format($transferencia['DetallePago']['total'], 2,",","."); ?></td>
					</tr>
					<?php endforeach; ?>

				<?php } ?>

				<?php if ($detalleefectivos != null) { ?>
					<?php foreach ($detalleefectivos as $efectivo): ?>
					<tr>
						<td>Efectivo</td>
						
						<td><?php echo number_format($efectivo['DetallePago']['total'], 2,",","."); ?></td>
					</tr>
					<?php endforeach; ?>


				<?php } ?>

				<?php if ($detallepuntos != null) { ?>
					<?php foreach ($detallepuntos as $punto): ?>
					<tr>
						<td>Punto</td>
						
						<td><?php echo number_format($punto['DetallePago']['total'], 2,",","."); ?></td>
					</tr>
					<?php endforeach; ?>
				<?php } ?>

				
				</tbody>
			</table>
			
		</div>
	</div>

	<?php } else { ?>

		<h1>No existen pagos para este ticket</h1>

	<?php } ?>
	</div>
	<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'tickets', 'action' => 'detalles', $idTicket),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
			?>
		</div>
	</div>
</div>

