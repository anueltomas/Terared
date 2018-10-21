<?php //debug($cierres); ?>
<?php //debug($totales); ?>
<?php //debug($detalles); ?>
<?php //debug($tickets); ?>
<?php //debug($cajero); ?>

<?php

	$this->Paginator->options(array(
		'update' => '#tabla-cierres',
		'before' => $this->Js->get('#procesando')->effect('fadeIn', array('buffer' => false)),
		'complete' => $this->Js->get('#procesando')->effect('fadeOut', array('buffer' => false))
		)
	);

?>

<div id="tabla-cierres">


<div class="box box-danger box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Resumen de Cierres</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	

     <div class="box-footer">
		<div class="form-group">

		
								


		</div>
	</div>

	<div class="box-body">
	


     
      

     	<div class="table-responsive">
     		<div class="col-xs-12 col-md-8 col-md-offset-2">
					
				<div class="box-body">
					<table class="table tabla-condensed table-striped"">
						<thead>
							<tr>
								<th><?php echo $this->Paginator->sort('Id'); ?></th>
								<th><?php echo $this->Paginator->sort('Total Cierre'); ?></th>
								<th><?php echo $this->Paginator->sort('Fecha'); ?></th>
								<th class="actions"><?php echo __('Acciones'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($cierres as $cierre): ?>
						
							<tr>
								<td><?php echo h($cierre['Cierre']['id']); ?>&nbsp;</td>


								<td><?php echo number_format($cierre['Cierre']['montocierre'], 2,",","."); ?> Bs.</td>

								<td><?php echo $this->Time->format('d-m-Y ; h:i A', h($cierre['Cierre']['created'])); ?></td>
								
								<td class="actions">
									<?php echo $this->Html->link(__('Ver'), array('action' => 'detalle', $cierre['Cierre']['id']), array('class' => 'btn btn-sm btn-success')); ?>
								</td>

						
			


							</tr>

							<?php endforeach; ?>
						</tbody>
					</table>

			
			<div class="progress oculto" id="procesando">
	        	<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100% Complete</span>
	        	</div>
	      	</div>
			<p>
				<?= $this->Paginator->counter('Página {:page} de {:pages}, mostrando {:current} registro(s) de {:count} en total, desde {:start}, hasta {:end}');
						?>
			</p>
			
				<ul class="pagination pagination-sm no-margin pull-left">
			        <li><?php echo $this->Paginator->prev('<' .__('Anterior'), array('tag' => false), null, array('class' => 'prev disabled')); ?></li>
						<?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active')); ?>
					<li><?php echo $this->Paginator->next(__('Siguiente') . ' >', array('tag' => false), null, array('class' => 'next disabled')); ?></li>
		        </ul>

		        <?php echo $this->Js->writeBuffer(); ?>
			    </div>
			</div>
		</div>



	</div>
	
	
</div>

</div>








