
<table class="table tabla-condensed table-striped">
					<thead>
						<tr>
								<th>N°</th>
								<th>Nombre</th>
								<th>Fecha-Hora</th>
								<th class="actions"><?php echo __('Acciones'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php $numero = 0 ?>
						<?php foreach ($clientes as $cliente): ?>
							<tr>
							<?php $numero = $numero + 1; ?>
								<td ><?php echo $numero; ?>&nbsp;</td>
								<td><?php echo h($cliente['Cliente']['nombre']); ?>&nbsp;</td>
								<td><?php echo $this->Time->format('d-m-Y ; h:i A', h($cliente['Cliente']['created'])); ?>&nbsp;</td>
								<td class="actions">
									<?php //echo $this->Html->link(__('Atender'), array('controller' => 'clientes', 'action' => 'atender', $cliente['Cliente']['id']), array('class' => 'btn btn-sm btn-default')); ?>

									<?php echo $this->Html->link(__('Atender'), array('controller' => 'tickets', 'action' => 'nuevo', $cliente['Cliente']['id']), array('class' => 'btn btn-sm btn-success')); ?>

									<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $cliente['Cliente']['id']), array('class' => 'btn btn-sm btn-primary')); ?>
									<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $cliente['Cliente']['id']), array('class' => 'btn btn-sm btn-danger', 'confirm' => __('Realmente desea eliminar a : '.$cliente['Cliente']['nombre'], $cliente['Cliente']['id']))); ?>
									
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>