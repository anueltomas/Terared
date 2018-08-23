
<?php //debug($servicios); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-users"></i> Usuarios</h3>
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
					<th>Nombre de usuario</th>
					<th>Username</th>
					<th>Estado</th>
					<th>Trabajador</th>
					<th>Privilegios</th>
					<th class="actions"><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($usuarios as $usuario): ?>
					<tr>

					<?php if ($usuario['Usuario']['id'] == 1){ ?>
						
					<?php } else{ ?>
				<td><?php echo h($usuario['Usuario']['nombreusuario']); ?>&nbsp;</td>
				<td><?php echo h($usuario['Usuario']['username']); ?>&nbsp;</td>

				<?php //COMPROBANDO SI EL SERVICIO ESTA ACTIVO ?>
				<?php if($usuario['Usuario']['estadousuario'] == true){ ?>

				<td><div class="label label-success">Activo</div></td>

				<?php }else{ ?>
				
				<td><div class="label label-danger">Inactivo</div></td>
				
				<?php } ?>

				<td>
					<?php echo $this->Html->link($usuario['Trabajador']['nombre'], array('controller' => 'trabajadores', 'action' => 'edit', $usuario['Trabajador']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($usuario['Privilegio']['nombreprivilegio'], array('controller' => 'privilegios', 'action' => 'edit', $usuario['Privilegio']['id'])); ?>
				</td>
				<td class="actions">
					<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $usuario['Usuario']['id']), array('class' => 'btn btn-sm btn-default')); ?>
					<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $usuario['Usuario']['id']), array('class' => 'btn btn-sm btn-default', 'confirm' => __('Are you sure you want to delete # %s?', $usuario['Usuario']['id']))); ?>
				</td>

				<?php } ?>
			</tr>
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


