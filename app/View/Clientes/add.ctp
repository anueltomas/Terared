	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="box box-primary">
				<div class="box-body table-responsive">
					  <br>
					  <br>
					    <center><h1>Nuevo Cliente</h1></center>
					  <br>
					    
					    	<?php echo $this->Form->create('Cliente', array('role' => 'form')); ?>
					<fieldset>
					    	<div class="form-group">
					    		<?php echo $this->Form->input('nombre', array('class' => 'form-control', 'label' => 'Nombre y Apellido', 'placeholder' => 'Nombre del cliente')); ?>
					    	</div>

					    	<div class="form-group">
					    		<?php echo $this->Form->button('<span class="fa fa-floppy-o" aria-hidden="true"></span> Grabar',array('type'  => 'submit','class' => 'btn btn-large btn-success pull-left', 'escape' => false));  ?>
					    	</div>
					</fieldset>
		    				<?php echo $this->Form->end(); ?> 
					   
					  
				</div>
			</div>
		</div>
	</div>
