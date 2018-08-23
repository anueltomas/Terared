<div class="bancos form">
<?php echo $this->Form->create('Banco'); ?>
	<fieldset>
		<legend><?php echo __('Add Banco'); ?></legend>
	<?php
		echo $this->Form->input('nombrebanco');
		echo $this->Form->input('estadobanco');
		echo $this->Form->input('borrado');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Bancos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Transferencias'), array('controller' => 'transferencias', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transferencia'), array('controller' => 'transferencias', 'action' => 'add')); ?> </li>
	</ul>
</div>
