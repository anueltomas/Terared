<div class="usuarios view">
<h2><?php echo __('Usuario'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombreusuario'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['nombreusuario']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pass'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['pass']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estadousuario'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['estadousuario']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($usuario['Usuario']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Transcriptor'); ?></dt>
		<dd>
			<?php echo $this->Html->link($usuario['Transcriptor']['nombre'], array('controller' => 'transcriptors', 'action' => 'view', $usuario['Transcriptor']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Privilegio'); ?></dt>
		<dd>
			<?php echo $this->Html->link($usuario['Privilegio']['nombreprivilegio'], array('controller' => 'privilegios', 'action' => 'view', $usuario['Privilegio']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Usuario'), array('action' => 'edit', $usuario['Usuario']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Usuario'), array('action' => 'delete', $usuario['Usuario']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $usuario['Usuario']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Transcriptors'), array('controller' => 'transcriptors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transcriptor'), array('controller' => 'transcriptors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Privilegios'), array('controller' => 'privilegios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Privilegio'), array('controller' => 'privilegios', 'action' => 'add')); ?> </li>
	</ul>
</div>
