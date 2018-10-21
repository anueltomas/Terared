<div class="transcriptors view">
<h2><?php echo __('Transcriptor'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($transcriptor['Transcriptor']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cedula'); ?></dt>
		<dd>
			<?php echo h($transcriptor['Transcriptor']['cedula']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($transcriptor['Transcriptor']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Apellido'); ?></dt>
		<dd>
			<?php echo h($transcriptor['Transcriptor']['apellido']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Telefono'); ?></dt>
		<dd>
			<?php echo h($transcriptor['Transcriptor']['telefono']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estadotranscriptor'); ?></dt>
		<dd>
			<?php echo h($transcriptor['Transcriptor']['estadotranscriptor']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($transcriptor['Transcriptor']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($transcriptor['Transcriptor']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Transcriptor'), array('action' => 'edit', $transcriptor['Transcriptor']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Transcriptor'), array('action' => 'delete', $transcriptor['Transcriptor']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $transcriptor['Transcriptor']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Transcriptors'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transcriptor'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Tickets'); ?></h3>
	<?php if (!empty($transcriptor['Ticket'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Numeroticket'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Estadoticket'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Cliente Id'); ?></th>
		<th><?php echo __('Transcriptor Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($transcriptor['Ticket'] as $ticket): ?>
		<tr>
			<td><?php echo $ticket['id']; ?></td>
			<td><?php echo $ticket['numeroticket']; ?></td>
			<td><?php echo $ticket['created']; ?></td>
			<td><?php echo $ticket['estadoticket']; ?></td>
			<td><?php echo $ticket['modified']; ?></td>
			<td><?php echo $ticket['cliente_id']; ?></td>
			<td><?php echo $ticket['transcriptor_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'tickets', 'action' => 'view', $ticket['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'tickets', 'action' => 'edit', $ticket['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'tickets', 'action' => 'delete', $ticket['id']), array('confirm' => __('Are you sure you want to delete # %s?', $ticket['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Usuarios'); ?></h3>
	<?php if (!empty($transcriptor['Usuario'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nombreusuario'); ?></th>
		<th><?php echo __('User'); ?></th>
		<th><?php echo __('Pass'); ?></th>
		<th><?php echo __('Estadousuario'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Transcriptor Id'); ?></th>
		<th><?php echo __('Privilegio Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($transcriptor['Usuario'] as $usuario): ?>
		<tr>
			<td><?php echo $usuario['id']; ?></td>
			<td><?php echo $usuario['nombreusuario']; ?></td>
			<td><?php echo $usuario['user']; ?></td>
			<td><?php echo $usuario['pass']; ?></td>
			<td><?php echo $usuario['estadousuario']; ?></td>
			<td><?php echo $usuario['created']; ?></td>
			<td><?php echo $usuario['modified']; ?></td>
			<td><?php echo $usuario['transcriptor_id']; ?></td>
			<td><?php echo $usuario['privilegio_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'usuarios', 'action' => 'view', $usuario['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'usuarios', 'action' => 'edit', $usuario['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'usuarios', 'action' => 'delete', $usuario['id']), array('confirm' => __('Are you sure you want to delete # %s?', $usuario['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
