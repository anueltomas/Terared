<?php //debug($datosCajero); ?>
<?php //debug($efectivo); ?>
<?php //debug($puntos); ?>
<?php //debug($transferencias); ?>
<?php //debug($cadaPunto); ?>
<?php //debug($gastos); ?>
<?php //debug($total); ?>

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

<div class="col-md-8 col-md-offset-2">
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
</div>

 <?php } else { ?>
				   
					<h2>No existen datos que mostrar </h2>
				   
				   <?php } ?>

				   <?php } ?>

	<div class="box-footer">
		<div class="form-group">
			<?php //echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'principal', 'action' => 'index',),array('type' => 'submit', 'class' => 'btn btn-success pull-right', 'escape' => false)); 
			?>
		</div>
	</div>

		
</div>

	


