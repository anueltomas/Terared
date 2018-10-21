<?php //debug($facturas); ?>
<?php //debug($totalAnterior); ?>
<?php //debug($montoanterior); ?>
<?php //debug($turno); ?>

<?php $montodeldia = $montoanterior['Cierre']['montocierre']; ?>

<?php 	$idCaja = $montoanterior['Cierre']['id']; ?>

<?php if ($datosCajero == null) { ?>

	

<?php } else { ?>
	<?php if($NoHayDatos == null){ ?>

	<?php $nombreCajero = $datosCajero['Usuario']['nombreusuario']; ?>

	<?php $efectivo = $efectivo[0][0]['EFECTIVO']; ?>

	<?php $puntos = $puntos[0][0]['PUNTOS']; ?>

	<?php $transferencias = $transferencias[0][0]['TRANSFERENCIAS']; ?>

	<?php $gastos = $gastos[0][0]['GASTOS']; ?>

	<?php $total = $total[0][0]['TOTAL']; ?>
	
<?php } else { ?>

 <?php } ?>
<?php } ?>


<div class="box box-warning box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class=""></i> Cierre de Turno</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	



	<div class="box-body">
		
			
			

<div class="col-md-6 ">
	<div class="box box-primary">
		<div class="cierres form">
	<?php echo $this->Form->create('Cierre'); ?>
	<fieldset>

	<?php if($facturas['inicio'] == null || $facturas['fin'] == null ) { ?>
		<span>Desde Factura N°</span> <span class="badge bg-aqua">Nulo</span>

		<span>Hasta Factura N°</span> <span class="badge bg-olive">Nulo</span>

	<?php } else { ?>
		<span>Desde Factura N°</span> <span class="badge bg-aqua"><?php echo $facturas['inicio'][0]['facturas']['nfactura']; ?></span>

		<span>Hasta Factura N°</span> <span class="badge bg-olive"><?php echo $facturas['fin'][0]['facturas']['nfactura']; ?></span>
	<?php } ?>
		
		

			<br>
			<br>


			<?php $total = $total + $gastos; ?>

			<?php $dia_mas_turno = $montodeldia + $total; ?>
									
					<?php echo $this->Form->input('total', array('label' => 'Monto del día ', 'value' => number_format($montodeldia, 2, ",",".") , 'disabled' => true)); ?>

			
			<br>



		
		
        <div class="col-md-6">

			<div class="input-group">
            <?php echo $this->Form->input('montoturno', array('value' => number_format($total, 2, ",","."), 'label' => 'Total turno ', 'disabled' => true, 'type' => 'numeric')); ?>         
            
                    
          	</div>
			
			
        	        
			<?php echo $this->Form->input('id_turno', array('type' => 'hidden', 'value' => $turno)); ?>

			<?php echo $this->Form->input('montoturno', array('type' => 'hidden', 'value' => $total)); ?>

			<?php echo $this->Form->input('dia_mas_turno', array('type' => 'hidden', 'value' => $dia_mas_turno)); ?>

			<?php echo $this->Form->input('idCaja', array('type' => 'hidden', 'value' => $idCaja)); ?>

			<br>

		
			<br>

			<?php echo $this->Form->input('nota', array('label' => 'Notas')); ?>


			<br>
		</div>
	
	
	</fieldset>
</div>
	</div>
</div>

<div class="col-md-6">
	<?php if($datosCajero == null) { ?>
				   	<h2>Usted no es el cajero que está de turno en este momento</h2>
				   <?php } else { ?>

				   <?php if($NoHayDatos == null){ ?>


	<div class="box box-widget widget-user-2">
	            <!-- Add the bg color to the header using any of the bg-* classes -->
	            <div class="widget-user-header bg-blue">
	              
	              <!-- /.widget-user-image -->
	              <h3 class="widget-user-username"><?php echo $nombreCajero; ?></h3>
	              <h5 class="widget-user-desc">Cajero</h5>
	            </div>
	            <div class="box-footer">
	              <ul class="nav nav-stacked">
	                <h3><li><a href="#">Efectivo <span class="pull-right badge bg-blue"><?php echo number_format($efectivo, 2,",","."); ?> Bs.</span></a></li></h3>
	                <h3><li><a href="#">Puntos <span class="pull-right badge bg-aqua"><?php echo number_format($puntos, 2,",","."); ?> Bs.</span></a></li></h3>

		                <?php foreach ($cadaPunto as $PUNTOS) { ?>

		                	<li><a href="#"><?php echo $PUNTOS['bancopuntos']['nombre']; ':'?> <span class="pull-right badge bg-aqua"><?php echo number_format($PUNTOS[0]['TOTAL'], 2,",","."); ?> Bs.</span></a></li>

			           <?php } ?>

		           	

	                <h3><li><a href="#">Transferencias <span class="pull-right badge bg-green"><?php echo number_format($transferencias, 2,",","."); ?> Bs.</span></a></li></h3>
	                <h3><li><a href="#">Gastos <span class="pull-right badge bg-red"><?php echo number_format($gastos, 2,",","."); ?> Bs.</span></a></li></h3>

	                <div class="row-fluid">
	                	<div class="col-md-4">
	                		<h5>INGRESOS</h5> <span class="form-control badge bg-yellow"><h5><?php echo number_format($total, 2,",","."); ?> Bs.</h5></span>
	                	</div>
	                	<div class="col-md-4">
			                <h5>EGRESOS</h5> <span class="form-control badge bg-red"><h5><?php echo number_format($gastos, 2,",","."); ?> Bs.</h5></span>
			            </div>
			                

			            <div class="col-md-4">
			                <h5>TOTAL</h5> <span class="form-control badge bg-blue"><h5><?php echo number_format($total, 2,",","."); ?> Bs.</h5></span>
			            </div>
	                </div>

	              </ul>
	            </div>
	          </div>

 <?php } else { ?>
				   
					<h2>No existen datos que mostrar </h2>
				   
				   <?php } ?>

				   <?php } ?>

</div>



		
	</div> <!-- /.box-body -->

	 <div class="box-footer">
    <div class="form-group">
      <?php echo $this->Form->button("<i class='fa fa-save'></i> Grabar", array(
        'type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false)); 
      ?>
      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'tickets',  'action' => 'caja',),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>
</div>



<script type="text/javascript">

$("#nuevo").keyup(function(e){
   			
   	var reporteAnterior = $("#anterior").val();
	var reporteNuevo = $("#nuevo").val();

	if (reporteNuevo == '') {
		alert('Debe ingresar el monto del nuevo reporte x / z')
	}else{
		Calcular(reporteAnterior, reporteNuevo);
	}

   	})
	
$("#calcular").click(function(e){

	var reporteAnterior = $("#anterior").val();
	var reporteNuevo = $("#nuevo").val();

	if (reporteNuevo == '') {
		alert('Debe ingresar el monto del nuevo reporte x / z')
	}else{
		Calcular(reporteAnterior, reporteNuevo);
	}

   		

   	})

function Calcular(anterior, nuevo){


		var monto = nuevo - anterior;

		$('.TotalTurno').val(monto);

	}

</script>


