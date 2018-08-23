<?php 
//debug($current_user);
//echo $current_user['id'];
//debug($clientes);
//debug($colas);

echo $this->Html->script('myjs/buscar');
	$this->Paginator->options(array(
		'update' => '#tabla-clientes',
		'before' => $this->Js->get('#procesando')->effect('fadeIn', array('buffer' => false)),
		'complete' => $this->Js->get('#procesando')->effect('fadeOut', array('buffer' => false))
		)
	);

?>

<?php echo $this->Html->script('myjs/clientes.js'); ?>

<!-- -->

<?php //debug($servicios); ?>

<div class="form-group">

						<!-- INICIO VENTANA MODAL -->
					            <div class="modal fade" id="modal-default">
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
						              

						              <div class="form-group">                     
							              <label>Servicio a solicitar:</label>
							              <?php echo $this->Form->input('cola_id', array('options' => array($colas), 'empty' => 'Seleccione--', 'id' => 'cola', 'class' => 'cola', 'form-control select2 select2-hidden-accessible',  'label' => false)) ?>
							            </div>

							            </div>

						              <div class="modal-footer">
						                <button id="cerrarModal" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
						                <button type="button" class="btn btn-primary" id="guardar">Guardar</button>
						              </div>
						            </div>
						            <!-- /.modal-content -->
						          </div>
						          <!-- /.modal-dialog -->
						        </div>
						        <!-- /.modal -->

						<!-- FIN VENTANA MODAL -->
		 				
</div>


<!-- MODAL TICKETS PAGADOS -->
<div class="form-group">

      <!-- INICIO VENTANA MODAL -->
      <div class="modal fade" id="modal-pagados">
       <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tickets pagados</h4>
          </div>
        <div class="col-md-12">    

        	<table class="table">
				<thead>
					<tr>
						<th>N° Ticket</th>
						<th>Nombre</th>
						<th>Monto a pagar</th>
						<th>Estado</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pagados as $ticket): ?>
						
					<tr>
				<td><?php echo h($ticket['Ticket']['numeroticket']); ?>&nbsp;</td>

				<td><?php echo h($ticket['Cliente']['nombre']); ?>&nbsp;</td>

				<td><?php echo number_format($ticket['Ticket']['montoticket'], 2,",","."); ?> Bs.</td>

				<td><?php echo h($ticket['Ticket']['estadoticket']); ?>&nbsp;</td>
			
				
						
			


			</tr>

					<?php endforeach; ?>
				</tbody>
			</table>
            
           
        
     
                                              
                    
        </div>
        <div class="modal-footer">
          <button id="cerrarModal" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
         
        </div>

        <?php


        ?>

                      
        <?php //echo $this->Form->end(); ?>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  </div>

  <!-- FIN VENTANA MODAL -->




<?php echo $this->Html->script(array('myjs/buscar')); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-user-plus"></i> Listado de Clientes</h3>
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
			<?php echo $this->Html->link("<i class='fa fa-plus'></i> Nuevo Cliente", array(
				'action' => 'add'), array('class' => 'btn btn-primary pull-left', 'escape' => false, 'type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#modal-default')); 
				echo $this->Html->link("<i class='fa fa-list-alt'></i> Tickets", array('controller' => 'tickets', 'action' => 'index'), array('class' => 'btn btn-success pull-left', 'escape' => false)); 
			?>

			<?php $privilegio = $this->Session->read('privilegio_id'); ?>

			<?php if ($privilegio != 4) { ?>
			<?php echo $this->Html->link("<i class='fa fa-rocket'></i> Express", array('controller' => 'tickets', 'action' => 'express',),array('class' => 'btn btn-warning pull-left', 'escape' => false)); 
			?>	
			<?php } ?>

			<?php echo $this->Html->link("<i class='fa fa-money'></i> Tickets Pagados", array('controller' => 'tickets', 'action' => 'add'),array('class' => 'btn btn-danger pull-left', 'escape' => false, 'data-toggle' => 'modal', 'data-target' => '#modal-pagados')); 
       		 ?> 	

       		 <?php echo $this->Html->link("<i class='fa fa-ticket'></i> Ticket Actual", array(
				'controller' => 'tickets', 'action' => 'ticketactual'),array('class' => 'btn bg-navy pull-left', 'escape' => false)); 
			?>	
		</div>
	</div>


	<div class="box-body">
		<div class="table-responsive">
			
			<div class="col-xs-12 col-md-8 col-md-offset-2">
		          <div class="box">
		            <div class="box-header with-border">
		              <center><h1 class="box-title">Listado de Clientes</h1></center>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              <div id="tablaClientes">
		              	


		              </div>
				
				
					<div class="progress oculto" id="procesando">
	        			<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100% Complete</span>
	        			</div>
	      			</div>
					

		            </div>
		            <!-- /.box-body -->

		            

		          </div>
		          <!-- /.box -->
		</div>



		</div>
	</div>
	<div class="box-footer">
		<div class="form-group">
			<?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'principal', 'action' => 'index',),array('type' => 'submit', 'class' => 'btn btn-success pull-right', 'escape' => false)); 
			?>
		</div>
	</div>
</div>




<!-- SCRIPT PARA REFRESCAR LA PAGINA AUTOMATICAMENTE
	NOTA: AL MOMENTO DE DEFINIR ESTA VISTA, SE PRESENTO EL SIGUIENTE INCOVENIENTE:
	EL REFRESCAMIENTO AFECTA AL MENU, LO QUE OCASIONA QUE AL DESPLEGARSE LOS SUBMENUS
	AL SEGUNDO SE CIERREN.-->
 
<script type="text/javascript">

  addEventListener('load', ajax, false);
    
  	
	function ajax(){
		var req = new XMLHttpRequest();

		mostrar();

		req.onreadystatechange = function(){
			if (req.readyState == 4 && req.status == 200) {
				document.getElementById('tablaClientes').innerHTML = req.responseText;
			}
		}

		req.open('GET', 'clientes/tabla', true);
		req.send();
	}

	setInterval(function(){ajax();}, 1000);

	function mostrar(){
		$('#procesando').fadeToggle(2000);
	}
	
</script>



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

  



