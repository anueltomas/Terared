<?php //debug($servicios); ?>
<?php echo $this->Html->script(array('myjs/buscar')); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-server"></i>Servicios Eliminados</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	<!-- search form (Optional) -->
     
            <?php echo $this->Form->create('Servicio', array('type' => 'GET', 'class' => 'sidebar-form', 'url' => array('controller' => 'servicios', 'action' => 'buscar'))); ?>
              <div class="input-group">
			      	<?php echo $this->Form->input('buscar', array('label' => false, 'div' => false, 'id' => 'b', 'class' => 'form-control s', 'autocomplete' => 'off', 'placeholder' => 'Buscar servicio...' )); ?>
			      	<span class="input-group-btn">
			      	<?php echo $this->Form->button("<i class='fa fa-search'></i>", array('div' => false, 'class' => 'btn btn-flat')); ?>
			      	</span>
			  </div>
      		<?php echo $this->Form->end(); ?>
   
      <!-- /.search form -->

	<div class="box-body">
		<?php if ($servicios == null) { ?>
			No existen servicios eliminados en este momento
		<?php } else { ?>

			<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
					<th>Código</th>
					<th>Nombre Servicio</th>
					<th>Precio</th>
					<th>Fecha Precio</th>
					<th>Estado</th>
					<th class="actions"><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($servicios as $servicio): ?>
					<tr>
				<td><?php echo h($servicio['Servicio']['codigoservicio']); ?>&nbsp;</td>
				<td><?php echo h($servicio['Servicio']['nombreservicio']); ?>&nbsp;</td>
			

				<!--VALIDANDO SI EL SERVICIO TIENE ASIGNADO UN PRECIO-->

				<?php if ($servicio['Servicio']['precio'] > 0) { ?>

					<?php //PARA EDITAR EL PRECIO DE CADA SERVICIO ?>
					<?php //echo $this->Html->link(number_format($servicio['PrecioServicio']['0']['precio'], 2,",","."), array('controller' => 'precioServicios', 'action' => 'edit', $servicio['PrecioServicio']['0']['id'])); ?>

					<td><?php echo $this->Html->link(number_format($servicio['Servicio']['precio'], 2,",","."), array('controller' => 'servicios', 'action' => 'edit', $servicio['Servicio']['id'])); ?></td>

				<?php } else { ?>
					
					<td><?php echo $this->Html->link('Añadir Precio', array('controller' => 'Servicios', 'action' => 'edit', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-danger')); ?></td>

				<?php } ?>

				<?php if ($servicio['Servicio']['precio'] != null || $servicio['Servicio']['fechaprecio'] != null ) {?>

				<td><?php echo h($servicio['Servicio']['fechaprecio']); ?>&nbsp;</td>

				<?php } else { ?>

				<td><div class="label label-danger">Precio no establecido</div></td>

				<?php } ?>

				

				<?php //COMPROBANDO SI EL SERVICIO ESTA ACTIVO ?>
				<?php if($servicio['Servicio']['estadoservicio'] == true){ ?>

				<td><div class="label label-success">Activo</div></td>

				<?php }else{ ?>
				
				<td><div class="label label-danger">Inactivo</div></td>
				
				<?php } ?>

				
				<td class="actions">
					<?php echo $this->Html->link(__('Restaurar'), array('action' => 'restaurar', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-default')); ?>
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

		<?php } ?>
	</div>
	<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array(
				'action' => 'index',),array('type' => 'submit', 'class' => 'btn btn-success pull-right', 'escape' => false)); 
			?>
		</div>
	</div>
</div>