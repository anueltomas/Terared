<div class="documentos view">
<h2><?php echo __('Documento'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($documento['Documento']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estadoentrega'); ?></dt>
		<dd>
			<?php echo h($documento['Documento']['estadoentrega']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($documento['Documento']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($documento['Documento']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ticket'); ?></dt>
		<dd>
			<?php echo $this->Html->link($documento['Ticket']['numeroticket'], array('controller' => 'tickets', 'action' => 'view', $documento['Ticket']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Documento'), array('action' => 'edit', $documento['Documento']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Documento'), array('action' => 'delete', $documento['Documento']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $documento['Documento']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Documentos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documento'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
	</ul>
</div>
