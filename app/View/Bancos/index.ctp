<div class="bancos index">
	<h2><?php echo __('Bancos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nombrebanco'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('estadobanco'); ?></th>
			<th><?php echo $this->Paginator->sort('borrado'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($bancos as $banco): ?>
	<tr>
		<td><?php echo h($banco['Banco']['id']); ?>&nbsp;</td>
		<td><?php echo h($banco['Banco']['nombrebanco']); ?>&nbsp;</td>
		<td><?php echo h($banco['Banco']['created']); ?>&nbsp;</td>
		<td><?php echo h($banco['Banco']['modified']); ?>&nbsp;</td>
		<td><?php echo h($banco['Banco']['estadobanco']); ?>&nbsp;</td>
		<td><?php echo h($banco['Banco']['borrado']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $banco['Banco']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $banco['Banco']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $banco['Banco']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $banco['Banco']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Banco'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Transferencias'), array('controller' => 'transferencias', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transferencia'), array('controller' => 'transferencias', 'action' => 'add')); ?> </li>
	</ul>
</div>
