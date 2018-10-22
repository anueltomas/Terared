<?php //debug($datosCajero); ?>
<?php //debug($efectivo); ?>
<?php //debug($puntos); ?>
<?php //debug($transferencias); ?>
<?php //debug($cadaPunto); ?>
<?php //debug($gastos); ?>
<?php //debug($total); ?>
<?php //debug($datosTurno); ?>
<?php //debug($cierreAnterior); ?>
<?php //debug($maxFactura); ?>
<?php //debug($minFactura); ?>
<?php //debug($idcierre); ?>
<?php //debug($turnos); ?>

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
		<h3 class="box-title"><i class=""></i> Resumen del Turno</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	



	<div class="box-body">
		
			
			<?php if($datosCajero == null) { ?>
				   	<h2>Usted no es el cajero que está de turno en este momento</h2>
				   <?php } else { ?>

				   <?php if($NoHayDatos == null){ ?>

<div class="col-md-6 ">
	<div class="box box-widget widget-user-2">
	            <!-- Add the bg color to the header using any of the bg-* classes -->
	            <div class="widget-user-header bg-blue">
	              
	              <!-- /.widget-user-image -->
	              <h3 class="widget-user-username"><?php echo $nombreCajero; ?></h3>
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
	                <br>
	              

	                <div class="row-fluid">
	                	<div class="col-md-4">
	                		<h5>INGRESOS</h5> <span class="form-control badge bg-yellow"><h5><?php echo number_format($total, 2,",","."); ?> Bs.</h5></span>
	                	</div>
	                	<div class="col-md-4">
			                <h5>EGRESOS</h5> <span class="form-control badge bg-red"><h5><?php echo number_format($gastos, 2,",","."); ?> Bs.</h5></span>
			            </div>
			                <?php $total = $total + $gastos; ?>

			            <div class="col-md-4">
			                <h5>TOTAL</h5> <span class="form-control badge bg-blue"><h5><?php echo number_format($total, 2,",","."); ?> Bs.</h5></span>
			            </div>
	                </div>
	                </ul>
	            </div>
	              
	            </div>
	          </div>

	<div class="col-md-6 ">
	<div class="box box-widget widget-user-2">

	<div class="widget-user-header bg-olive">
	              
	              <!-- /.widget-user-image -->
	              <h3 class="widget-user-username">Detalles del Turno</h3>
	            </div>

	<div class="box-body no-padding">
	<h4>
		<table class="table table-striped">
			<tbody>
				<tr>
					<th><span>Concepto</span></th>
					<th><span>Valor</span></th>
				</tr>
				<tr>
					<td>Facturas</td>
					<td><?php echo $minFactura[0][0]['MIN']; ?> - <?php echo $maxFactura[0][0]['MAX']; ?></td>
				</tr>
				<tr>
					<td>Inicio</td>
					<td><?php echo $this->Time->format('d-m-Y ; h:i A', h($datosTurno['TurnoCajero']['created'])); ?></td>
				</tr>
				<tr>
					<td>Fin</td>
					<td><?php echo $this->Time->format('d-m-Y ; h:i A', h($datosTurno['TurnoCajero']['modified'])); ?></td>
				</tr>
				<tr>
					<td>Monto del Turno</td>
					<?php $monto = $datosTurno['TurnoCajero']['montoturno'];?>
					<td><?php echo number_format($monto, 2,",","."); ?> Bs.</td>
				</tr>
				
				
				<tr>
					<td>Notas</td>
					<td><?php echo $datosTurno['TurnoCajero']['observaciones']; ?></td>
				</tr>
			</tbody>

		</table>



	</h4>
		
	</div>
	</div>

	<?php echo $this->Html->link("<i class=''></i> Tickets Cobrados", array('action' => 'tickets_cobrados', $idturno, $idcierre), array('type' => 'submit', 'class' => 'btn btn-warning pull-left', 'escape' => false)); 
			?>

	<?php echo $this->Html->link("<i class=''></i> Facturas Emitidas", array('action' => 'facturas_emitidas', $idcierre), array('type' => 'submit', 'class' => 'btn btn-success pull-right', 'escape' => false)); 
			?>
	
	</div>
</div>

 <?php } else { ?>
				   
					<h2>No existen datos que mostrar </h2>
				   
				   <?php } ?>

				   <?php } ?>

	<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('action' => 'detalle', $idcierre), array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
			?>
		</div>
	</div>

		
</div>

	


