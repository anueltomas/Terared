<?php //debug($totales); ?>
<?php //debug($detalles); ?>
<?php //debug($tickets); ?>
<?php //debug($cajero); ?>
<?php //debug($pagos); ?>


<div class="box box-danger box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Tickets Pagados</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	

     <div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-rocket'></i> Express", array(
				'action' => 'express',),array('class' => 'btn btn-warning pull-left', 'escape' => false)); 
			?>	

			<?php echo $this->Html->link("<i class='fa fa-ticket'></i> Ticket Actual", array(
				'action' => 'ticketactual'),array('class' => 'btn bg-navy pull-left', 'escape' => false)); 
			?>		

			
		</div>
	</div>

	<div class="box-body">


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
						<th>Total</th>
						<th>Fecha</th>
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
					<?php echo $this->Html->link(__('Ver'), array('action' => 'detalles', $ticket['Ticket']['id']), array('class' => 'btn btn-sm btn-success')); ?>
				</td>

			
			


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


