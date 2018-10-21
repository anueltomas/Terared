<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-list-alt"></i> Bancos Transferencias</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

     <div class="box-footer">
		<div class="form-group">
			
			<?php echo $this->Html->link("<i class='fa fa-plus'></i> Nuevo", array(
				'action' => 'add'),array('class' => 'btn btn-primary pull-left', 'escape' => false)); 
			?>		
		</div>
	</div>

	<div class="box-body">
	
      <div class="col-md-6 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Denominación</th>
						<th>Estado</th>
						<th class="actions"><?php echo __('Acciones'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($bancos as $banco): ?>
						
					<tr>
						<td><?php echo h($banco['Banco']['nombrebanco']); ?>&nbsp;</td>

						<?php //COMPROBANDO SI EL PUNTO ESTA ACTIVO ?>
						<?php if($banco['Banco']['estadobanco'] == true){ ?>

						<td><div class="label label-success">Activo</div></td>

						<?php }else{ ?>
						
						<td><div class="label label-danger">Inactivo</div></td>
						
						<?php } ?>
						
						
						<td class="actions">
							<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $banco['Banco']['id']), array('class' => 'btn btn-sm btn-primary')); ?>
							<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $banco['Banco']['id']), array('class' => 'btn btn-sm btn-danger', 'confirm' => __('Are you sure you want to delete # %s?', $banco['Banco']['id']))); ?>
						</td>

						
					</tr>

					<?php endforeach; ?>
				</tbody>
			</table>
			
		</div>
		</div>
	</div>
	
	
</div>



