<div class="servicios view">
<h2><?php echo __('Servicio'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($servicio['Servicio']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Codigoservicio'); ?></dt>
		<dd>
			<?php echo h($servicio['Servicio']['codigoservicio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombreservicio'); ?></dt>
		<dd>
			<?php echo h($servicio['Servicio']['nombreservicio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estadoservicio'); ?></dt>
		<dd>
			<?php echo h($servicio['Servicio']['estadoservicio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($servicio['Servicio']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($servicio['Servicio']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tservicio'); ?></dt>
		<dd>
			<?php echo $this->Html->link($servicio['Tservicio']['nombretipo'], array('controller' => 'tservicios', 'action' => 'view', $servicio['Tservicio']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Servicio'), array('action' => 'edit', $servicio['Servicio']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Servicio'), array('action' => 'delete', $servicio['Servicio']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $servicio['Servicio']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Servicios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Servicio'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tservicios'), array('controller' => 'tservicios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tservicio'), array('controller' => 'tservicios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Detalle Tickets'), array('controller' => 'detalle_tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Detalle Ticket'), array('controller' => 'detalle_tickets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Precios'), array('controller' => 'precios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Precio'), array('controller' => 'precios', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Detalle Tickets'); ?></h3>
	<?php if (!empty($servicio['DetalleTicket'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Cantidad'); ?></th>
		<th><?php echo __('Monto'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Ticket Id'); ?></th>
		<th><?php echo __('Servicio Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($servicio['DetalleTicket'] as $detalleTicket): ?>
		<tr>
			<td><?php echo $detalleTicket['id']; ?></td>
			<td><?php echo $detalleTicket['cantidad']; ?></td>
			<td><?php echo $detalleTicket['monto']; ?></td>
			<td><?php echo $detalleTicket['created']; ?></td>
			<td><?php echo $detalleTicket['modified']; ?></td>
			<td><?php echo $detalleTicket['ticket_id']; ?></td>
			<td><?php echo $detalleTicket['servicio_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'detalle_tickets', 'action' => 'view', $detalleTicket['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'detalle_tickets', 'action' => 'edit', $detalleTicket['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'detalle_tickets', 'action' => 'delete', $detalleTicket['id']), array('confirm' => __('Are you sure you want to delete # %s?', $detalleTicket['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Detalle Ticket'), array('controller' => 'detalle_tickets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Precios'); ?></h3>
	<?php if (!empty($servicio['Precio'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Precio'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Estadoprecio'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Servicio Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($servicio['Precio'] as $precio): ?>
		<tr>
			<td><?php echo $precio['id']; ?></td>
			<td><?php echo $precio['precio']; ?></td>
			<td><?php echo $precio['created']; ?></td>
			<td><?php echo $precio['estadoprecio']; ?></td>
			<td><?php echo $precio['modified']; ?></td>
			<td><?php echo $precio['servicio_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'precios', 'action' => 'view', $precio['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'precios', 'action' => 'edit', $precio['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'precios', 'action' => 'delete', $precio['id']), array('confirm' => __('Are you sure you want to delete # %s?', $precio['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Precio'), array('controller' => 'precios', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
