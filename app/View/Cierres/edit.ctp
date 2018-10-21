<div class="cierres form">
<?php echo $this->Form->create('Cierre'); ?>
	<fieldset>
		<legend><?php echo __('Edit Cierre'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nreportezx');
		echo $this->Form->input('totalzx');
		echo $this->Form->input('totalcierre');
		echo $this->Form->input('turno_cajero_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Cierre.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Cierre.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Cierres'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Turno Cajeros'), array('controller' => 'turno_cajeros', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Turno Cajero'), array('controller' => 'turno_cajeros', 'action' => 'add')); ?> </li>
	</ul>
</div>
