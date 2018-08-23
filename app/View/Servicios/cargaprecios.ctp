<?php //debug($servicios); ?>


<div class="row">
	
	<div class="col-md-2">
		
		<div class="actions">
				<ul>
					<?php echo $this->Html->link(__('Agregar Servicio'), array('action' => 'add'), array('class' => 'btn btn-primary')); ?>
				</ul>


			<ul>
				<?php echo $this->Html->link(__('Servicios eliminados'), array('action' => 'eliminados'), array('class' => 'btn btn-danger')); ?>
			</ul>

		</div>

	</div>
		

</div>

<div class="row">
			
	<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
		<div class="servicios index">
			<center><h2>Carga de precios</h2></center>
			<table class="table table-bordered">
			<thead>
			<tr>
					<th>Código</th>
					<th>Nombre Servicio</th>
					<th>Precio</th>
					<th>Estado</th>
					<th class="actions"><?php echo __('Acciones'); ?></th>
			</tr>
			</thead>
			<tbody>
			<!-- Indice para recorrer un campo de texto con el tabulador -->
			<?php $tabindex = 1; ?>/
			<?php foreach ($servicios as $servicio): ?>
			<tr>
				<td><?php echo h($servicio['Servicio']['codigoservicio']); ?>&nbsp;</td>
				<td><?php echo h($servicio['Servicio']['nombreservicio']); ?>&nbsp;</td>
			

				<!--VALIDANDO SI EL SERVICIO TIENE ASIGNADO UN PRECIO-->

				<?php if ($servicio['Servicio']['precio'] > 0) { ?>

					<?php //PARA EDITAR EL PRECIO DE CADA SERVICIO ?>
					<?php //echo $this->Html->link(number_format($servicio['PrecioServicio']['0']['precio'], 2,",","."), array('controller' => 'precioServicios', 'action' => 'edit', $servicio['PrecioServicio']['0']['id'])); ?>

					<!--
					<td><?php //echo $this->Html->link(number_format($servicio['Servicio']['precio'], 2,",","."), array('controller' => 'servicios', 'action' => 'edit', $servicio['Servicio']['id'])); ?></td>-->

					<td><?php echo $this->Form->input($servicio['Servicio']['id'], array('div' => false, 'class' => 'edit_cant form-control input-mdall', 'label' => false, 'size' => 2, 'maxlenght' => 3, 'tabindex' => $tabindex++, 'data-id' => $servicio['Servicio']['id'], 'data-servicio' => $servicio['Servicio']['id'], 'value' => $servicio['Servicio']['precio'])); ?></td>

				<?php } else { ?>
					
					<td><?php echo $this->Html->link('Añadir Precio', array('controller' => 'Servicios', 'action' => 'edit', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-danger')); ?></td>

				<?php } ?>

				

				<?php //COMPROBANDO SI EL SERVICIO ESTA ACTIVO ?>
				<?php if($servicio['Servicio']['estadoservicio'] == true){ ?>

				<td><div class="label label-success">Activo</div></td>

				<?php }else{ ?>
				
				<td><div class="label label-danger">Inactivo</div></td>
				
				<?php } ?>

				
				<td class="actions">
					<?php echo $this->Html->link(__('Editar Servicio'), array('action' => 'edit', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-default')); ?>
					<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-default', 'confirm' => __('Realmente desea eliminar: %s?', $servicio['Servicio']['nombreservicio']))); ?>
				</td>
			</tr>
		<?php endforeach; ?>
			</tbody>
			</table>
			<p>
			<?php
			echo $this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
			));
			?>	</p>
			<div class="paging">
			<?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled btn btn-sm btn-info'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled btn btn-sm btn-info'));
			?>
			</div>
		</div>

	</div>

</div>

