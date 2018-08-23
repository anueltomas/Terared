<div class="documentos form">
<?php echo $this->Form->create('Documento'); ?>
	<fieldset>
		<legend><?php echo __('Edit Documento'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('estadoentrega');
		echo $this->Form->input('ticket_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Documento.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Documento.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Documentos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
	</ul>
</div>
