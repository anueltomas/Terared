<?php //debug($datos); ?>
<?php //debug($total); ?>
<?php //debug($tickets); ?>
<?php //debug($facturaanterior); ?>

<?php $total = $total[0][0]['total']; ?>


<div class="box bg-olive box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Crear factura simple</h3>
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
		<center><h2>Detalle de Factura</h2></center>
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


		<!-- FORMULARIO -->

		<div class="col-md-10 col-md-offset-1">
			<?php echo $this->Form->create('Factura'); ?>
             <fieldset>

             	<?php 
             	//Variable que obtiene el ultimo numero de factura y la incrementa
             		$new_num_factura = $facturaanterior + 1;
             	 ?>
             
              <legend><h2>Datos a Facturar</h2></legend>
                <div class="row-fluid">
                  <div class="col-md-4">
                  <?php echo $this->Form->input('nfactura', array('label' => 'Número de Factura', 'class' => 'form-control', 'placeholder' => 'Número de Factura', 'value' => $new_num_factura, 'disabled' => true)); ?>
                  </div>
                </div>

                 <?php echo $this->Form->input('nfactura', array('type'=> 'hidden', 'value' => $new_num_factura)); ?>

                 <?php 
                //VARIABLE QUE GUARDA EL CODIGO DE LA IMPRESORA FISCAL
                $impFiscal = 'Z7A000458';
                 ?>

                <div class="row-fluid">
                  <div class="col-md-4">
                  <?php echo $this->Form->input('nfiscal', array('label' => 'Número Fiscal', 'class' => 'form-control', 'placeholder' => 'Número Fiscal', 'value' => $impFiscal, 'disabled' => true)); ?>
                  </div>
                </div>


               <div class="row-fluid">
                  <div class="col-md-4">
                  <?php echo $this->Form->input('totalfactura', array('type' => 'numeric', 'disabled' => true, 'label' => 'Monto Total', 'class' => 'form-control', 'value' => $total)); ?>
                  </div>
                </div>

                <?php echo $this->Form->input('totalfactura', array('type'=> 'hidden', 'value' => $total)); ?>

                <?php echo $this->Form->input('nfiscal', array('type'=> 'hidden', 'value' => $impFiscal)); ?>
                
                <!-- /.box-body -->

               </fieldset>
		</div>

		<!-- FIN FORMULARIO -->
		



	</div>
     	<!--FIN TABLA-->

    <div class="box-footer">
    <div class="form-group">
      <?php echo $this->Form->button("<i class='fa fa-save'></i> Grabar", array(
        'type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false)); 
      ?>
      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'tickets', 'action' => 'pagados',),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>



	</div>
	
	
</div>







