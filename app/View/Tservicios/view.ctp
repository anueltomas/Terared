<div class="tservicios view">
<h2><?php echo __('Tservicio'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tservicio['Tservicio']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombretipo'); ?></dt>
		<dd>
			<?php echo h($tservicio['Tservicio']['nombretipo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estadotipo'); ?></dt>
		<dd>
			<?php echo h($tservicio['Tservicio']['estadotipo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($tservicio['Tservicio']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($tservicio['Tservicio']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tservicio'), array('action' => 'edit', $tservicio['Tservicio']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tservicio'), array('action' => 'delete', $tservicio['Tservicio']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tservicio['Tservicio']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Tservicios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tservicio'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Servicios'), array('controller' => 'servicios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Servicios'); ?></h3>
	<?php if (!empty($tservicio['Servicio'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Codigoservicio'); ?></th>
		<th><?php echo __('Nombreservicio'); ?></th>
		<th><?php echo __('Estadoservicio'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Tservicio Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($tservicio['Servicio'] as $servicio): ?>
		<tr>
			<td><?php echo $servicio['id']; ?></td>
			<td><?php echo $servicio['codigoservicio']; ?></td>
			<td><?php echo $servicio['nombreservicio']; ?></td>
			<td><?php echo $servicio['estadoservicio']; ?></td>
			<td><?php echo $servicio['created']; ?></td>
			<td><?php echo $servicio['modified']; ?></td>
			<td><?php echo $servicio['tservicio_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'servicios', 'action' => 'view', $servicio['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'servicios', 'action' => 'edit', $servicio['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'servicios', 'action' => 'delete', $servicio['id']), array('confirm' => __('Are you sure you want to delete # %s?', $servicio['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
