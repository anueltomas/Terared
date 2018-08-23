<?php //debug($servicios); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-star-o"></i>Gestión de Privilegios</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-plus'></i> Nuevo", array(
				'action' => 'add',),array('class' => 'btn btn-primary pull-left', 'escape' => false)); 
			?>			
		</div>
	</div>

	
	<div class="box-body">
	<div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
					<th>Id</th>
					<th>Nombre del privilegio</th>
					<th class="actions"><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php $numero = 0; ?>
					<?php foreach ($privilegios as $privilegio): ?>
			<tr>
				
					

					<?php if ($privilegio['Privilegio']['id'] == 1) { 

					} else { ?>

					<td><?php echo h($numero); ?>&nbsp;</td>
					<td><?php echo h($privilegio['Privilegio']['nombreprivilegio']); ?>&nbsp;</td>

					<td class="actions">

					<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $privilegio['Privilegio']['id']), array('class' => 'btn btn-sm btn-default')); ?>

					<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $privilegio['Privilegio']['id']), array('class' => 'btn btn-sm btn-default', 'confirm' => __('Are you sure you want to delete # %s?', $privilegio['Privilegio']['id']))); ?>

					<?php } ?>

					</td>
			</tr>
			<?php $numero = $numero + 1; ?>
		<?php endforeach; ?>
				</tbody>
			</table>
			<p>
				<?php
					echo $this->Paginator->counter(array(
						'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
					?>
			</p>
			<div class="paging">
				<?php
					echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ''));
					echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
				?>
			</div>
		</div>
		</div>
	</div>
	<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'principal', 'action' => 'index'),array('class' => 'btn btn-danger pull-right', 'escape' => false)); 
			?>			

		</div>
	</div>
</div>

