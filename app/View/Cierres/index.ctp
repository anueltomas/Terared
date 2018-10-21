<div class="cierres index">
	<h2><?php echo __('Cierres'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nreportezx'); ?></th>
			<th><?php echo $this->Paginator->sort('totalzx'); ?></th>
			<th><?php echo $this->Paginator->sort('totalcierre'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('turno_cajero_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($cierres as $cierre): ?>
	<tr>
		<td><?php echo h($cierre['Cierre']['id']); ?>&nbsp;</td>
		<td><?php echo h($cierre['Cierre']['nreportezx']); ?>&nbsp;</td>
		<td><?php echo h($cierre['Cierre']['totalzx']); ?>&nbsp;</td>
		<td><?php echo h($cierre['Cierre']['totalcierre']); ?>&nbsp;</td>
		<td><?php echo h($cierre['Cierre']['created']); ?>&nbsp;</td>
		<td><?php echo h($cierre['Cierre']['modified']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($cierre['TurnoCajero']['id'], array('controller' => 'turno_cajeros', 'action' => 'view', $cierre['TurnoCajero']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $cierre['Cierre']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cierre['Cierre']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cierre['Cierre']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $cierre['Cierre']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Cierre'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Turno Cajeros'), array('controller' => 'turno_cajeros', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Turno Cajero'), array('controller' => 'turno_cajeros', 'action' => 'add')); ?> </li>
	</ul>
</div>
