<div class="privilegios view">
<h2><?php echo __('Privilegio'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($privilegio['Privilegio']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombreprivilegio'); ?></dt>
		<dd>
			<?php echo h($privilegio['Privilegio']['nombreprivilegio']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Privilegio'), array('action' => 'edit', $privilegio['Privilegio']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Privilegio'), array('action' => 'delete', $privilegio['Privilegio']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $privilegio['Privilegio']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Privilegios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Privilegio'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Usuarios'); ?></h3>
	<?php if (!empty($privilegio['Usuario'])): ?>
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
	<?php foreach ($privilegio['Usuario'] as $usuario): ?>
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
