<?php //debug($gastos); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-star-o"></i>Gestión de Gastos</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	

	
	<div class="box-body">

<?php $privilegio = $this->Session->read('privilegio_id'); ?>

<?php if ($privilegio == 1 || $privilegio == 2) { ?>

<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-plus'></i> Nuevo", array(
				'action' => 'add',),array('class' => 'btn btn-primary pull-left', 'escape' => false)); 
			?>			
		</div>
	</div>

		<div class="col-md-10 col-md-offset-1">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
						<th>Id</th>
						<th>Concepto</th>
						<th>Monto</th>
						<th>Fecha</th>
						<th class="actions"><?php echo __('Acciones'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php $numero = 0; ?>
						<?php foreach ($gastos as $gasto): ?>
				<tr>
					
						

					
						<td><?php echo h($gasto['Gasto']['id']); ?>&nbsp;</td>

						<td><?php echo h($gasto['Gasto']['concepto']); ?>&nbsp;</td>

						<td><?php echo number_format($gasto['Gasto']['montogasto'], 2,",","."); ?> Bs. </td>

						<td><?php echo h($gasto['Gasto']['modified']); ?>&nbsp;</td>

						<td class="actions">

						<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $gasto['Gasto']['id']), array('class' => 'btn btn-sm btn-default')); ?>

						<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $gasto['Gasto']['id']), array('class' => 'btn btn-sm btn-default', 'confirm' => __('Are you sure you want to delete # %s?', $gasto['Gasto']['id']))); ?>

					

						</td>
				</tr>
				
			<?php endforeach; ?>
					</tbody>
				</table>
				<p>
					<?php
						//echo $this->Paginator->counter(array(
							//'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
						?>
				</p>
				<div class="paging">
					<?php
						//echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
						//echo $this->Paginator->numbers(array('separator' => ''));
						//echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
					?>
				</div>
			</div>
			</div>

<?php } else { ?>

	<?php if ($cajeroNoActivo != null) { ?>

		<h3>Usted debe tener un turno activo como cajero</h3>

	<?php } else { ?>

	<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-plus'></i> Nuevo", array(
				'action' => 'add',),array('class' => 'btn btn-primary pull-left', 'escape' => false)); 
			?>			
		</div>
	</div>

		<?php if ($gastos == null) { ?>

			<h3>Usted no ha registrado gastos aún.</h3>

		<?php } else { ?>

		
			
			<div class="col-md-10 col-md-offset-1">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
						<th>Id</th>
						<th>Concepto</th>
						<th>Monto</th>
						<th>Fecha</th>
						<th class="actions"><?php echo __('Acciones'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php $numero = 0; ?>
						<?php foreach ($gastos as $gasto): ?>
				<tr>
					
						

					<?php //debug($gasto); ?>
						<td><?php echo h($gasto['Gasto']['id']); ?>&nbsp;</td>

						<td><?php echo h($gasto['Gasto']['concepto']); ?>&nbsp;</td>

						<td><?php echo number_format($gasto['Gasto']['montogasto'], 2,",","."); ?> Bs. </td>

						<td><?php echo h($gasto['Gasto']['modified']); ?>&nbsp;</td>

						<td class="actions">

						<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $gasto['Gasto']['id']), array('class' => 'btn btn-sm btn-default')); ?>

						<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $gasto['Gasto']['id']), array('class' => 'btn btn-sm btn-default', 'confirm' => __('Are you sure you want to delete # %s?', $gasto['Gasto']['id']))); ?>

					

						</td>
				</tr>
				
			<?php endforeach; ?>
					</tbody>
				</table>
				<p>
					<?php
						//echo $this->Paginator->counter(array(
							//'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));
						?>
				</p>
				<div class="paging">
					<?php
						//echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
						//echo $this->Paginator->numbers(array('separator' => ''));
						//echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
					?>
				</div>
			</div>
			</div>

		<?php } ?>

	<?php } ?>

<?php } ?>



	</div>



	<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'principal', 'action' => 'index'),array('class' => 'btn btn-danger pull-right', 'escape' => false)); 
			?>			

		</div>
	</div>
</div>

