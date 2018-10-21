<div class="bancos view">
<h2><?php echo __('Banco'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($banco['Banco']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombrebanco'); ?></dt>
		<dd>
			<?php echo h($banco['Banco']['nombrebanco']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($banco['Banco']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($banco['Banco']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estadobanco'); ?></dt>
		<dd>
			<?php echo h($banco['Banco']['estadobanco']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Borrado'); ?></dt>
		<dd>
			<?php echo h($banco['Banco']['borrado']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Banco'), array('action' => 'edit', $banco['Banco']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Banco'), array('action' => 'delete', $banco['Banco']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $banco['Banco']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Bancos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banco'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Transferencias'), array('controller' => 'transferencias', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transferencia'), array('controller' => 'transferencias', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Transferencias'); ?></h3>
	<?php if (!empty($banco['Transferencia'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Ntransferencia'); ?></th>
		<th><?php echo __('Monto'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Fechatransferencia'); ?></th>
		<th><?php echo __('Banco Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($banco['Transferencia'] as $transferencia): ?>
		<tr>
			<td><?php echo $transferencia['id']; ?></td>
			<td><?php echo $transferencia['ntransferencia']; ?></td>
			<td><?php echo $transferencia['monto']; ?></td>
			<td><?php echo $transferencia['created']; ?></td>
			<td><?php echo $transferencia['modified']; ?></td>
			<td><?php echo $transferencia['fechatransferencia']; ?></td>
			<td><?php echo $transferencia['banco_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'transferencias', 'action' => 'view', $transferencia['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'transferencias', 'action' => 'edit', $transferencia['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'transferencias', 'action' => 'delete', $transferencia['id']), array('confirm' => __('Are you sure you want to delete # %s?', $transferencia['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Transferencia'), array('controller' => 'transferencias', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
