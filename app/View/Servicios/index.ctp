<?php //debug($servicios); ?>
<?php //debug($current_user); ?>
<?php echo $this->Html->script(array('myjs/buscar')); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-server"></i> Gestión de Servicios</h3>
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

			<?php echo $this->Html->link("<i class='fa fa-remove'></i> Eliminados", array(
				'action' => 'eliminados',),array('class' => 'btn btn-danger pull-left', 'escape' => false)); 
			?>	

			<?php echo $this->Html->link("<i class='fa fa-list'></i> Modificar Precios", array(
				'action' => 'modificar_precios',),array('class' => 'btn btn-default pull-left', 'escape' => false)); 
			?>		

			<?php echo $this->Html->link("<i class='fa fa-rotate-left'></i> Restaurar Precios", array(
				'action' => 'restaurar_precios',),array('class' => 'btn btn-default pull-left', 'escape' => false)); 
			?>		

			<?php echo $this->Html->link("<i class='fa fa-print'></i> Imprimir Precios", array(
				'action' => 'imprimir', 'ext' => 'pdf'),array('class' => 'btn btn-default pull-right', 'escape' => false)); 
			?>		

		</div>
	</div>

	<div class="box-body">
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
      <div class="col-md-12 ">
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

					
					<td><?php echo $this->Html->link(number_format($servicio['Servicio']['precio'], 2,",","."), array('controller' => 'servicios', 'action' => 'edit', $servicio['Servicio']['id'])); ?></td>

				<?php } else { ?>
					
					<td><?php echo $this->Html->link('Añadir Precio', array('controller' => 'Servicios', 'action' => 'edit', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-danger')); ?></td>

				<?php } ?>

				<?php if ($servicio['Servicio']['precio'] == '0,00' || $servicio['Servicio']['fechaprecio'] != null ) {?>

				<td><?php echo $this->Time->format('d-m-Y', h($servicio['Servicio']['fechaprecio'])); ?>&nbsp;</td>

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
					<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-primary')); ?>
					<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-danger', 'confirm' => __('Realmente desea eliminar: %s?', $servicio['Servicio']['nombreservicio']))); ?>
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
	</div>
	
	
</div>


