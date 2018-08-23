<?php //debug($datos); ?>
<div class="box box-danger box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-server"></i> Frecuencia de facturación</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>



	<div class="box-body">
	

		<!--TABLA-->
     		<div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Tipo de Frecuencia</th>
						<th>Medida</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($datos as $dato): ?>
						
					<tr>
						<td><?php echo h($dato['Configuration']['tipo']); ?>&nbsp;</td>

						<?php if ($dato['Configuration']['tipo'] == 'TICKETS') { ?>

							<td><?php echo h($dato['Configuration']['ticket']); ?>&nbsp;</td>

						<?php } else { ?>
							<td><?php echo number_format($dato['Configuration']['monto'], 2,",","."); ?> Bs.</td>
						<?php } ?>

						<td class="actions">
						<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $dato['Configuration']['id']), array('class' => 'btn btn-sm btn-default')); ?>
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
     	<!--FIN TABLA-->





      
	</div>
	
	
</div>



<script type="text/javascript"> 
  addEventListener('load',inicio,false);
  	function inicio()
	  {
	    document.getElementById('option1').addEventListener('change',monto,false);
	    document.getElementById('option2').addEventListener('change',ticket,false);
	    deshabilitar();
	  }

	  function deshabilitar()
	  {
	  	var ticket = document.getElementById('ticket');
	  	var monto = document.getElementById('monto');
	  	ticket.disabled = true;
	  	monto.disabled = true;
	  }

    function monto()
	  {
	  	var ticket = document.getElementById('ticket');
	  	var monto = document.getElementById('monto');
	  	ticket.disabled = true;
	  	monto.disabled = false;
	  }

	  function ticket()
	  {
	  	var ticket = document.getElementById('ticket');
	  	var monto = document.getElementById('monto');
	  	ticket.disabled = false;
	  	monto.disabled = true;
	  }
 
</script>


