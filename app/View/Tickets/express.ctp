<?php echo $this->Html->script('myjs/nuevocliente.js'); ?>

<?php echo $this->Html->script(array('myjs/buscar')); ?>


<div class="box box-warning box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-ticket"></i> Ticket Express</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	    <div class="box-footer">
      <div class="form-group">
        <?php //echo $this->Html->link("<i class='fa fa-plus'></i> Servicio", array('controller' => 'detalleTickets', 'action' => 'add', $datos['Ticket']['id']),array('class' => 'btn btn-primary pull-left', 'escape' => false)); 
      ?>  

        <?php echo $this->Html->link("<i class='fa fa-plus'></i> Nuevo Cliente", array('controller' => 'clientes', 'action' => 'add'),array('class' => 'btn btn-default pull-left', 'escape' => false, 'data-toggle' => 'modal', 'data-target' => '#modal-clientes')); 
        ?>


       
      <?php //echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-default', 'confirm' => __('Realmente desea eliminar: %s?', $servicio['Servicio']['nombreservicio']))); ?>

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

	

  


			

<!-- MODAL PARA CLIENTES -->


              <div class="form-group">

            <!-- INICIO VENTANA MODAL -->
                      <div class="modal fade" id="modal-clientes">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Nuevo Cliente</h4>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Nombre y Apellido</label>
                              <input id="nombrecliente" type="text" class="form-control" placeholder="Nombre y Apellido">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button id="cerrarModal" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="guardar_cliente">Guardar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

            <!-- FIN VENTANA MODAL -->

          </div>



			<div class="box-body">
			  			<?php echo $this->Form->create('Cliente'); ?>
			             <fieldset>
			              <legend><?php echo __(''); ?></legend>
			                <div class="row-fluid">
			                  <div class="col-md-4">
			                  <div class="form-group">
				                  <?php echo $this->Form->input('nombre', array('label' => 'Cliente', 'class' => 'form-control', 'placeholder' => 'Nombre del cliente')); ?>
				                </div>
			                  <div class="box-footer">
			                  	<?php echo $this->Form->end('Guardar', array('class' => "btn btn-primary")); ?>
			                  </div>
			                  </div>
			                </div>

			                <!-- /.box-body -->

			               </fieldset>
			            </form>
            </div>



	
	
</div>








<!-- Style PARA EL MODAL -->
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>



  

