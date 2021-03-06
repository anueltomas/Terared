<?php echo $this->Html->css(array('datatables.net-bs/css/dataTables.bootstrap.min') );  ?>
<!-- -->

<?php //debug($servicios); ?>


<?php echo $this->Html->script(array('myjs/buscar')); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-server"></i> Servicios</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	<div class="box-footer">
		<div class="form-group">	

			<?php echo $this->Html->link("<i class='fa fa-print'></i> Imprimir Precios", array(
				'action' => 'imprimir', 'ext' => 'pdf'),array('class' => 'btn btn-default pull-right', 'escape' => false)); 
			?>		

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
	<div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table id="example1" class="table table-striped">
				<thead>
					<tr>
					<th>Código</th>
					<th>Nombre Servicio</th>
					<th>Precio</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($servicios as $servicio): ?>
					<tr>
						<td><?php echo h($servicio['Servicio']['codigoservicio']); ?>&nbsp;</td>
						<td><?php echo h($servicio['Servicio']['nombreservicio']); ?>&nbsp;</td>
						<td><?php echo number_format($servicio['Servicio']['precio'], 2,",","."); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
		</div>
	</div>
	</div>
	<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'principal', 'action' => 'index',),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
			?>
		</div>
	</div>
</div>



<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
