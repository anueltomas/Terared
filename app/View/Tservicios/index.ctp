
<?php //debug($servicios); ?>
<?php //debug($current_user); ?>
<?php echo $this->Html->script(array('myjs/buscar')); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-server"></i> Gestión Tipos de Servicios</h3>
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
      <div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Estado</th>
						<th class="actions"><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($tservicios as $tservicio): ?>
					<tr>
				<td><?php echo h($tservicio['Tservicio']['nombretipo']); ?>&nbsp;</td>
							

				<?php //COMPROBANDO SI EL SERVICIO ESTA ACTIVO ?>
				<?php if($tservicio['Tservicio']['estadotipo'] == true){ ?>

				<td><div class="label label-success">Activo</div></td>

				<?php }else{ ?>
				
				<td><div class="label label-danger">Inactivo</div></td>
				
				<?php } ?>

				
				<td class="actions">
					<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $tservicio['Tservicio']['id']), array('class' => 'btn btn-sm btn-primary')); ?>
					<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $tservicio['Tservicio']['id']), array('class' => 'btn btn-sm btn-danger', 'confirm' => __('Realmente desea eliminar: %s?', $tservicio['Tservicio']['nombretipo']))); ?>
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



