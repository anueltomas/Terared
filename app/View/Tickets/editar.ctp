<?php //debug($datos); ?>
<?php //debug($current_user); ?>
<?php //echo $this->Html->script('myjs/tickets.js'); ?>
<?php //debug($totalticket); ?>

<?php echo $this->Html->script(array('myjs/buscar')); ?>

<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-server"></i> Gestión de ticket actual</h3>
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
        <?php echo $this->Html->link("<i class='fa fa-plus'></i> Añadir servicio", array('controller' => 'detalleTickets', 'action' => 'add', $datos['Ticket']['id']),array('class' => 'btn btn-primary pull-left', 'escape' => false)); 
      ?>  

        <?php echo $this->Html->link("<i class='fa fa-plus'></i> Nuevo Cliente", array(
          'action' => '',),array('class' => 'btn btn-default pull-left', 'escape' => false, 'data-toggle' => 'modal', 'data-target' => '#modal-clientes')); 
        ?>      

      </div>
    </div>

  

	<div class="box-body">
	

		<h4>Cliente: <span><?php echo $datos['Cliente']['nombre']; ?></span></h4>
  		<h4>N° Ticket: <span><?php echo $datos['Ticket']['numeroticket']; ?></span></h4>

  	

		

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



<div id="detalleTicket"></div>
<?php //debug($detalles); ?>

<?php if ($detalles == null) {?>


<h1>Este ticket no tiene servicios asignados</h1>

<?php } else  { ?>

<table class="table tabla-condensed table-striped">



<thead>

  <tr>

   <th>Código</th>
   <th>Nombre</th>
   <th>Cantidad</th>
   <th>Precio</th>
   <th>Subtotal</th>
   <th>Acciones</th>

  </tr>

</thead>

<tbody>
<?php $tabindex = 1; ?>
<?php foreach ($detalles as $detalle): ?>

 
<tr>
   
   <div class="row" id="row-<?php echo $detalle['DetalleTicket']['id']; ?>">

    <td><?php echo $detalle['Servicio']['codigoservicio']; ?></td>

     <td><?php echo $detalle['Servicio']['nombreservicio']; ?></td>

    
    <td><?php echo $detalle['DetalleTicket']['cantidad']; ?></td>


    <td><?php echo number_format($detalle['Servicio']['precio'], 2,",","."); ?> Bs.</td>
     
    

      <td>
          
            <span  id="monto-<?php echo $detalle['Servicio']['id']; ?>">
             <?php echo number_format($detalle['DetalleTicket']['monto'], 2,",",".");  ?>
            </span>
            Bs.
          
      </td>
    
      <td class="actions">

        <?php echo $this->Html->link(__('Editar'), array('controller' => 'detalleTickets', 'action' => 'edit', $detalle['DetalleTicket']['id'], $current_user['id']), array('class' => 'btn btn-sm btn-default')); ?>

        <?php echo $this->Form->postLink(__('Eliminar'), array('controller' => 'detalleTickets', 'action' => 'delete', $detalle['DetalleTicket']['id'], $current_user['id']), array('class' => 'btn btn-sm btn-danger', 'confirm' => __('Realmente desea eliminar este servicio?', $detalle['DetalleTicket']['id']) )); ?></td>


    <?php //echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-default', 'confirm' => __('Realmente desea eliminar: %s?', $servicio['Servicio']['nombreservicio']))); ?>
     
   </div>

  </tr>
 

<?php endforeach; ?>

</tbody>



</table>

<h3>
  <span class="total">Total Ticket:</span>
<span id="total" class="total">
    <?php echo number_format($totalticket, 2,",","."); ?> Bs.
</span>
</h3>

<?php } ?>

<br>
<br>
		
	</div>


  <div class="box-footer">
    <div class="form-group">
      <?php echo $this->Html->link("<i class='fa fa-save'></i> Procesar ticket", array('action' => 'guardar_ticket', $datos['Ticket']['id'], $current_user['id']), array('type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false)); 
      ?>
      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Cancelar", array(
        'action' => 'index',),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>
    </div>
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



