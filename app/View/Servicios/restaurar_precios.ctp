<?php
//debug($fechas);

?>

<?php //debug($cajero); ?>
<?php //debug($fecha); ?>


<div class="box box-danger box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Restaurar Precios de los Servicios</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>


	<?php echo $this->Form->input('fecha', array('options' => array($fechas), 'empty' => 'Fechas ', 'class' => 'form-control select2 select2-hidden-accessible',  'label' => false)) ?>

<?php $seleccion = 0; ?>
<?php if ($seleccion == 0) {
?>

<center><h1>Debe seleccionar una fecha</h1></center>
<?php
} else {


?>


	<div class="box-body">
	<div class="col-md-10 col-md-offset-1">
		<div class="table-responsive">
			<table class="table">
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


<?php 
}

 ?>








	
</div>



<script type="text/javascript">

  addEventListener('load', ajax, false);
    
  	
	function ajax(){
		var req = new XMLHttpRequest();

		mostrar();

		req.onreadystatechange = function(){
			if (req.readyState == 4 && req.status == 200) {
				document.getElementById('ticketsPorCobrar').innerHTML = req.responseText;
			}
		}

		req.open('GET', 'tabla_administrar', true);
		req.send();
	}

	setInterval(function(){ajax();}, 1000);

	function mostrar(){
		$('#procesando').fadeToggle(2000);
	}
	
</script>

<br>
<br>


