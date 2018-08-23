<?php //debug($cajero); ?>
<?php //debug($fecha); ?>


<div class="box box-danger box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Cerrar Caja</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	

     <div class="box-footer">
		<div class="form-group">

		<h2>Caja abierta por: <?php echo $cajero['Usuario']['nombreusuario']; ?></h2> 
		<h2>Fecha: <?php echo $cajero['TurnoCajero']['created']; ?></h2> 

		<br>
		
			<?php echo $this->Html->link("<i class='fa fa-ticket'></i> Cerrar Caja", array('action' => 'cerrar_caja'),array('class' => 'btn bg-navy pull-left', 'escape' => false)); 
			?>		
		</div>
	</div>

	<div class="box-body">
	

	</div>
	
	
</div>

