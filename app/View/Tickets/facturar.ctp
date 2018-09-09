<?php //debug($datos); ?>
<?php //debug($total); ?>
<?php //debug($prueba); ?>


<?php $total = $total[0][0]['total']; ?>

<?php echo $this->Html->script(array('myjs/buscar')); ?>
<div class="box bg-olive box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Facturación de Tickets</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
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

      

     	<?php if ($datos == null) { ?>
     		<center><h2>No existen tickets para facturar</h2></center>
     	<?php }else { ?>
     		<!--TABLA-->
     		<div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Servicio</th>
						<th>SubTotal</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($datos as $dato): ?>
						
					<tr>
						<td><?php echo h($dato['tservicios']['tipo']); ?>&nbsp;</td>

						<td><?php echo number_format($dato['0']['total'], 2,",","."); ?> Bs.</td>
			
			
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

		<div class="pull-right">
		  <h3>
			  <span class="total">Total:</span>
				<span id="total" class="total">
			    <?php echo number_format($total, 2,",","."); ?> Bs.
				</span>
			</h3>
		</div>
		</div>
		



	</div>
     	<!--FIN TABLA-->
     	<?php } ?>

     	<div class="box-footer">
    <div class="form-group">
    
      <?php if($datos == null){ ?>

      <?php }else{ ?>
      	<?php echo $this->Html->link("<i class='fa fa-save'></i> Facturar", array('controller' => 'facturas', 'action' => 'add'), array('type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false)); 
      ?>
      <?php } ?>
    
      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'tickets', 'action' => 'pagados'),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>
    </div>
  </div>



	</div>
	
	
</div>







