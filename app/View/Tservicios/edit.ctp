<div class="tservicios form">
<?php echo $this->Form->create('Tservicio'); ?>
	<fieldset>
		<legend><?php echo __('Edit Tservicio'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nombretipo');
		echo $this->Form->input('estadotipo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Tservicio.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Tservicio.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Tservicios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Servicios'), array('controller' => 'servicios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Servicio'), array('controller' => 'servicios', 'action' => 'add')); ?> </li>
	</ul>
</div>
