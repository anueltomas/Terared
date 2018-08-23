



<?php //debug($servicios); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-text-width"></i> Gestión de Trabajadores</h3>
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
					<th>Cédula</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Teléfono</th>
					<th>Estado</th>
					<th class="actions"><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($trabajadores as $trabajador): ?>
					<tr>
					<td><?php echo h($trabajador['Trabajador']['cedula']); ?>&nbsp;</td>
					<td><?php echo h($trabajador['Trabajador']['nombre']); ?>&nbsp;</td>
					<td><?php echo h($trabajador['Trabajador']['apellido']); ?>&nbsp;</td>
					<td><?php echo h($trabajador['Trabajador']['telefono']); ?>&nbsp;</td>

					<?php //COMPROBANDO SI EL TRABAJADOR ESTA ACTIVO ?>
					<?php if($trabajador['Trabajador']['estadotrabajador'] == true){ ?>

					<td><div class="label label-success">Activo</div></td>

					<?php }else{ ?>
					
					<td><div class="label label-danger">Inactivo</div></td>
					
					<?php } ?>


					<td class="actions">
						
						<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $trabajador['Trabajador']['id']), array('class' => 'btn btn-sm btn-default')); ?>
						<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $trabajador['Trabajador']['id']), array('class' => 'btn btn-sm btn-default', 'confirm' => __('Está seguro que desea eliminar a # %s?', $trabajador['Trabajador']['nombre']))); ?>
					</td>
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


