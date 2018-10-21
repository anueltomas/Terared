<div class="cierres view">
<h2><?php echo __('Cierre'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cierre['Cierre']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nreportezx'); ?></dt>
		<dd>
			<?php echo h($cierre['Cierre']['nreportezx']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Totalzx'); ?></dt>
		<dd>
			<?php echo h($cierre['Cierre']['totalzx']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Totalcierre'); ?></dt>
		<dd>
			<?php echo h($cierre['Cierre']['totalcierre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($cierre['Cierre']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($cierre['Cierre']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Turno Cajero'); ?></dt>
		<dd>
			<?php echo $this->Html->link($cierre['TurnoCajero']['id'], array('controller' => 'turno_cajeros', 'action' => 'view', $cierre['TurnoCajero']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cierre'), array('action' => 'edit', $cierre['Cierre']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cierre'), array('action' => 'delete', $cierre['Cierre']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $cierre['Cierre']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Cierres'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cierre'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Turno Cajeros'), array('controller' => 'turno_cajeros', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Turno Cajero'), array('controller' => 'turno_cajeros', 'action' => 'add')); ?> </li>
	</ul>
</div>
