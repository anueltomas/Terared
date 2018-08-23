<?php //debug($current_user); ?>
<?php //debug($totales); ?>
<?php //debug($detalles); ?>
<?php //debug($usuarios); ?>
<?php //debug($tickets); ?>
<?php echo $this->Html->script(array('myjs/buscar')); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-list-alt"></i> Tickets</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>

	

     <div class="box-footer">
		<div class="form-group">


			<?php $privilegio = $this->Session->read('privilegio_id'); ?>

			<?php if ($privilegio != 4) { ?>
			<?php echo $this->Html->link("<i class='fa fa-ticket'></i> Ticket Actual", array(
				'action' => 'ticketactual'),array('class' => 'btn bg-navy pull-left', 'escape' => false)); 
			?>
			<?php } ?>

			 <?php echo $this->Html->link("<i class='fa fa-money'></i> Tickets Pagados", array('controller' => 'tickets', 'action' => 'add'),array('class' => 'btn btn-danger pull-left', 'escape' => false, 'data-toggle' => 'modal', 'data-target' => '#modal-pagados')); 
       		 ?> 	
		</div>
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
						<th>Nombre del Cliente</th>
						<th>Monto</th>
						<th>Estado</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pagados as $ticket): ?>
						
					<tr>
				<td><?php echo h($ticket['Ticket']['numeroticket']); ?>&nbsp;</td>

				<td><?php echo h($ticket['Cliente']['nombre']); ?>&nbsp;</td>

				<td><?php echo number_format($ticket['Ticket']['montoticket'], 2,",","."); ?> Bs.</td>

				<?php if ($ticket['Ticket']['estadoticket'] == 'Pagado'){ ?>
					<td><div class="label label-success">Pagado</div></td>
				<?php }else{ ?>
					<td><div class="label label-primary">Facturado</div></td>
				<?php } ?>

				
				
				
						
			


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




	<div class="box-body">
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



      	<!-- TABLA DE TICKETS -->
				<div class="table-responsive">
     				<div class="col-xs-12 col-md-10 col-md-offset-1">
					
						<div class="box-body">
							<div id="listaTickets">

							</div>
							<div class="progress oculto" id="procesando">
			        			<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100% Complete</span>
			        			</div>
			      			</div>
			      		</div>
					</div>
				</div>

			<!-- FIN TABLA DE TICKETS -->
      




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



<!-- REFRESH AUTOMATICO -->
  <script type="text/javascript">

  addEventListener('load', ajax, false);
    
  	
	function ajax(){
		var req = new XMLHttpRequest();

		mostrar();

		req.onreadystatechange = function(){
			if (req.readyState == 4 && req.status == 200) {
				document.getElementById('listaTickets').innerHTML = req.responseText;
			}
		}

		req.open('GET', 'tickets/tabla_tickets', true);
		req.send();
	}

	setInterval(function(){ajax();}, 1000);

	function mostrar(){
		$('#procesando').fadeToggle(2000);
	}
	
</script>


