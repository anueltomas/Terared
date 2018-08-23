<?php 

	//debug($datos); 

//$X = round(32.46, PHP_ROUND_HALF_UP );
//echo $X . "<br>";
//$X = round($X);

//echo $X . "<br>";
//$X = (integer) $X;


//echo $X;


?>
<?php echo $this->Html->script(array('myjs/buscar')); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-server"></i> Modificar precios de servicios</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
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

	

     <div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-plus'></i> Nuevo", array(
				'action' => 'add',),array('class' => 'btn btn-primary pull-left', 'escape' => false)); 
			?>			

			<?php echo $this->Html->link("<i class='fa fa-remove'></i> Eliminados", array(
				'action' => 'eliminados',),array('class' => 'btn btn-danger pull-left', 'escape' => false)); 
			?>		

		</div>
	</div>

	<div class="box-body">
	





 <?php echo $this->Form->create('PorcentajePrecio'); ?>
             <fieldset>
              
                <div class="row-fluid">
                  <div class="col-md-4">
                   
					      <div class="col-lg-6">
					      		<label>Cifra %</label>
					                  <div class="input-group">
					                    <input class="form-control" type="text" name="cifra"> 
					                  </div>
					                  <!-- /input-group -->
					      
					                  <div class="form-group">
						                  <div class="radio">
						                    <label>
						                      <input name="opcion" id="optionsRadios1" value="aumentar" checked="" type="radio">
						                      Aumentar
						                    </label>
						                  </div>
						                  <div class="radio">
						                    <label>
						                      <input name="opcion" id="optionsRadios2" value="disminuir" type="radio">
						                      Disminuir
						                    </label>
						                  </div>
					                </div>
					      </div>
 					
                  </div>
                </div>

                

               </fieldset>



 <div class="box-footer">
    <div class="form-group">
      <?php echo $this->Form->button("<i class='fa fa-save'></i> Grabar", array(
        'type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false)); 
      ?>
      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array(
        'action' => 'index',),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>
    </div>
  </div>



      
	</div>
	
	
</div>


