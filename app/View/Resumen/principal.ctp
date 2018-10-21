<?php //debug($cierres); ?>
<?php //debug($totales); ?>
<?php //debug($detalles); ?>
<?php //debug($tickets); ?>
<?php //debug($cajero); ?>


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
								<th>Id</th>
								<th>Total Cierre</th>
								<th>Fecha</th>
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
	
	
</div>






