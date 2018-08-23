<?php debug($detalleTickets); ?> 
<div class="detalleTickets index">
	<h2><?php echo __('Detalle Tickets'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('cantidad'); ?></th>
			<th><?php echo $this->Paginator->sort('monto'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('ticket_id'); ?></th>
			<th><?php echo $this->Paginator->sort('servicio_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($detalleTickets as $detalleTicket): ?>
	<tr>
		<td><?php echo h($detalleTicket['DetalleTicket']['id']); ?>&nbsp;</td>
		<td><?php echo h($detalleTicket['DetalleTicket']['cantidad']); ?>&nbsp;</td>
		<td><?php echo h($detalleTicket['DetalleTicket']['monto']); ?>&nbsp;</td>
		<td><?php echo h($detalleTicket['DetalleTicket']['created']); ?>&nbsp;</td>
		<td><?php echo h($detalleTicket['DetalleTicket']['modified']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($detalleTicket['Ticket']['numeroticket'], array('controller' => 'tickets', 'action' => 'view', $detalleTicket['Ticket']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($detalleTicket['Servicio']['nombreservicio'], array('controller' => 'servicios', 'action' => 'view', $detalleTicket['Servicio']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $detalleTicket['DetalleTicket']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $detalleTicket['DetalleTicket']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $detalleTicket['DetalleTicket']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $detalleTicket['DetalleTicket']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Detalle Ticket'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Servicios'), array('controller' => 'servicios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?> </li>
	</ul>
</div>
