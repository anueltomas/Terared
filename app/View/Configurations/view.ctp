<div class="configurations view">
<h2><?php echo __('Configuration'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($configuration['Configuration']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Monto'); ?></dt>
		<dd>
			<?php echo h($configuration['Configuration']['monto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($configuration['Configuration']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($configuration['Configuration']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Configuration'), array('action' => 'edit', $configuration['Configuration']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Configuration'), array('action' => 'delete', $configuration['Configuration']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $configuration['Configuration']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Configurations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Configuration'), array('action' => 'add')); ?> </li>
	</ul>
</div>
