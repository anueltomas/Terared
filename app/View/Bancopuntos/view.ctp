<div class="bancopuntos view">
<h2><?php echo __('Bancopunto'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($bancopunto['Bancopunto']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($bancopunto['Bancopunto']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($bancopunto['Bancopunto']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($bancopunto['Bancopunto']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Bancopunto'), array('action' => 'edit', $bancopunto['Bancopunto']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Bancopunto'), array('action' => 'delete', $bancopunto['Bancopunto']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $bancopunto['Bancopunto']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Bancopuntos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bancopunto'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Puntos'), array('controller' => 'puntos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Punto'), array('controller' => 'puntos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Puntos'); ?></h3>
	<?php if (!empty($bancopunto['Punto'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Monto'); ?></th>
		<th><?php echo __('Codigoaprobado'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Bancopunto Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($bancopunto['Punto'] as $punto): ?>
		<tr>
			<td><?php echo $punto['id']; ?></td>
			<td><?php echo $punto['monto']; ?></td>
			<td><?php echo $punto['codigoaprobado']; ?></td>
			<td><?php echo $punto['created']; ?></td>
			<td><?php echo $punto['modified']; ?></td>
			<td><?php echo $punto['bancopunto_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'puntos', 'action' => 'view', $punto['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'puntos', 'action' => 'edit', $punto['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'puntos', 'action' => 'delete', $punto['id']), array('confirm' => __('Are you sure you want to delete # %s?', $punto['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Punto'), array('controller' => 'puntos', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
