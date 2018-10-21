<div class="detalleTickets view">
<h2><?php echo __('Detalle Ticket'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($detalleTicket['DetalleTicket']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cantidad'); ?></dt>
		<dd>
			<?php echo h($detalleTicket['DetalleTicket']['cantidad']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Monto'); ?></dt>
		<dd>
			<?php echo h($detalleTicket['DetalleTicket']['monto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($detalleTicket['DetalleTicket']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($detalleTicket['DetalleTicket']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ticket'); ?></dt>
		<dd>
			<?php echo $this->Html->link($detalleTicket['Ticket']['numeroticket'], array('controller' => 'tickets', 'action' => 'view', $detalleTicket['Ticket']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Servicio'); ?></dt>
		<dd>
			<?php echo $this->Html->link($detalleTicket['Servicio']['nombreservicio'], array('controller' => 'servicios', 'action' => 'view', $detalleTicket['Servicio']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Detalle Ticket'), array('action' => 'edit', $detalleTicket['DetalleTicket']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Detalle Ticket'), array('action' => 'delete', $detalleTicket['DetalleTicket']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $detalleTicket['DetalleTicket']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Detalle Tickets'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Detalle Ticket'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Servicios'), array('controller' => 'servicios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?> </li>
	</ul>
</div>
