<?php //debug($cajero); ?>
<?php //debug($fecha); ?>


<div class="box box-danger box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-money"></i> Administrar Turnos de Cajeros</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>


     <div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-rocket'></i> Frecuencia de Facturas", array('controller' => 'configurations', 'action' => 'index',),array('class' => 'btn btn-primary pull-left', 'escape' => false)); 
			?>		


		</div>
	</div>

	<?php if ($cajero != null) {?>

     <div class="box-footer">
		<div class="form-group">



		<h2>Turno abierto por: <?php echo $cajero['Usuario']['nombreusuario']; ?></h2> 
		<h2>Fecha: <?php echo $this->Time->format('d-m-Y; h:i:s', h($cajero['TurnoCajero']['created'])); ?></h2> 

		<br>
		
			<?php echo $this->Form->postlink(__('Cerrar Turno'), array('action' => 'cerrar_turno', $cajero['TurnoCajero']['id']), array('class' => 'btn bg-navy pull-left', 'confirm' => __('Esta seguro que desea cerrar el turno?'))); 
			?>	
		</div>
	</div>

	<?php } else { ?>

	<div class="box-footer">
		<div class="form-group">

		<h3>No existe ningún cajero activo</h3>
		
			<?php echo $this->Html->link("<i class='fa fa-ticket'></i> Aperturar Caja", array('action' => 'iniciar_caja'),array('class' => 'btn bg-navy pull-left', 'escape' => false)); 
			?>		

			<?php echo $this->Form->postlink(__('Cerrar Caja'), array('action' => 'cerrar_caja'), array('class' => 'btn btn-danger pull-right', 'confirm' => __('Esta seguro que desea cerrar la caja?'))); 
			?>	

		</div>
	</div>

	<?php } ?>

	<div class="box-body">


	<div class="table-responsive">
     			<div class="col-xs-12 col-md-8 col-md-offset-2">
					
						<div class="box-body">
							<div id="ticketsPorCobrar">

							</div>
							<div class="progress oculto" id="procesando">
			        			<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100% Complete</span>
			        			</div>
			      			</div>
			      		</div>
					</div>
				</div>
	

	</div>
	
	
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

