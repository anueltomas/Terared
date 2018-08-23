
			<table class="table">
				<thead>
					<tr>
						<th>N° Ticket</th>
						<th>Nombre del Cliente</th>
						<th>Monto a pagar</th>
						<th>Estado</th>
						
					</tr>
				</thead>
				<tbody>
					<?php foreach ($tickets as $ticket): ?>
						
					<tr>
				<td><?php echo h($ticket['Ticket']['numeroticket']); ?>&nbsp;</td>

				<td><?php echo h($ticket['Cliente']['nombre']); ?>&nbsp;</td>

				<td><?php echo number_format($ticket['Ticket']['montoticket'], 2,",","."); ?> Bs.</td>

				<?php if($ticket['Ticket']['estadoticket'] == 'Atencion') { ?>
					<td><div class="label label-danger">Siendo Atendido</div></td>
				<?php }else{ ?>
						<?php if($ticket['Ticket']['estadoticket'] == 'Espera') { ?>
							<td><div class="label label-default">En espera</div></td>
						<?php }else{ ?>
								<td><div class="label label-success">Por pagar</div></td>
						<?php } ?>
				<?php } ?>


				<?php foreach ($usuarios as $usuario): ?>

					<?php if ($ticket['Ticket']['usuario_id'] == $usuario['Usuario']['id']) { ?>

						<?php if ($ticket['Ticket']['usuario_id'] === $current_user['id']) { ?>
							<td class="actions">
								<?php echo $this->Html->link(__('Editar'), array('action' => 'editar', $ticket['Ticket']['id']), array('class' => 'btn btn-sm btn-primary')); ?>
							</td>
						<?php } else { ?>
								<td><?php echo $usuario['Usuario']['nombreusuario']; ?></td>
						<?php } ?>
					<?php } else { ?>


					<?php } ?>

				<?php endforeach; ?>
			
			
				<?php if($ticket['Ticket']['estadoticket'] != 'Atencion') { ?>
							<?php if($ticket['Ticket']['estadoticket'] != 'Espera') { ?>

							<td class="actions">
								<?php echo $this->Html->link(__('Editar'), array('action' => 'editar', $ticket['Ticket']['id']), array('class' => 'btn btn-sm btn-primary')); ?>
							</td>

							<?php } ?>
						
							
				<?php } ?>


				<?php $privilegio = $this->Session->read('privilegio_id'); ?>

				<?php if ($privilegio == 1 || $privilegio == 2) {  ?>
							<td class="actions">
								<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $ticket['Ticket']['id']), array('class' => 'btn btn-sm btn-danger', 'confirm' => __('Realmente desea eliminar: %s?', $ticket['Ticket']['id']))); ?>
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
		