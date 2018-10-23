


<?php 

echo $this->Html->css(array('datatables.net-bs/css/dataTables.bootstrap.min') ); 



//debug($servicios);

	if ($servicios == null) {

		?>

		<center><h1>No existen datos para esta fecha</h1></center>

<?php	

	}else{

 ?>

<center><h1 class="box-title">Reporte por cada Servicio</h1></center>

<table id="example1" class="table table-condensed table-striped">
					<thead>
						<tr>	
								<th>N°</th>
								<th>Nombre del servicio</th>
								<th>Monto generado</th>
								<th>Cantidad</th>
								
						</tr>
					</thead>
					<tbody>
					<?php $numero = 0 ?>
						<?php foreach ($servicios as $servicio): ?>
							<tr>
							<?php $numero = $numero + 1; ?>
								<td ><?php echo $numero; ?>&nbsp;</td>
								<td><?php echo h($servicio['servicios']['NOMBRE_SERVICIOS']); ?>&nbsp;</td>
								<td><?php echo h($servicio['0']['TOTAL']); ?>&nbsp;</td>
								<td><?php echo h($servicio['0']['CANT_POR_SERVICIO']); ?>&nbsp;</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

<?php } ?>


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