

			<table class="table tabla-condensed table-striped">
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
			<?php echo $this->Html->link(__('Ver'), array('action' => 'ver', $ticket['Ticket']['id']), array('class' => 'btn btn-sm btn-success')); ?>
		</td>

		

				<?php } ?>
			


			</tr>

					<?php endforeach; ?>
				</tbody>
			</table>

			
			<p>
				<?php
					//echo $this->Paginator->counter(array(
						//'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
					?>
			</p>
			<div class="paging">
				<?php
					//echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					//echo $this->Paginator->numbers(array('separator' => ''));
					//echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
				?>
			</div>
	
