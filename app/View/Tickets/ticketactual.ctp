<?php //debug($datos); ?>
<?php //debug($detalles); ?>
<?php //debug($current_user); ?>
<?php echo $this->Html->script('myjs/tickets.js'); ?>
<?php //debug($totalticket); ?>

<?php echo $this->Html->script('myjs/nuevocliente.js'); ?>

<?php echo $this->Html->script(array('myjs/buscar')); ?>

<?php echo $this->Html->script(array('myjs/remove_servicio')); ?>

<?php echo $this->Html->script(array('myjs/edit_cant_serv')); ?>

<?php echo $this->Html->script('jquery-ui/jquery.animate-colors-development.js'); ?>


<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-ticket"></i> Ticket Actual</h3>
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
        <?php //echo $this->Html->link("<i class='fa fa-plus'></i> Servicio", array('controller' => 'detalleTickets', 'action' => 'add', $datos['Ticket']['id']),array('class' => 'btn btn-primary pull-left', 'escape' => false)); 
      ?>  

       <?php echo $this->Html->link("<i class='fa fa-plus'></i> Nuevo Servicio", array('controller' => 'tickets', 'action' => 'add'),array('class' => 'btn btn-primary pull-left', 'escape' => false, 'data-toggle' => 'modal', 'data-target' => '#modal-default')); 
        ?> 

        <?php echo $this->Html->link("<i class='fa fa-plus'></i> Cliente", array('controller' => 'clientes', 'action' => 'add'),array('class' => 'btn btn-default pull-left', 'escape' => false, 'data-toggle' => 'modal', 'data-target' => '#modal-clientes')); 
        ?>


        <?php echo $this->Form->postLink("<i class='fa fa-remove'></i> Eliminar Ticket", array('action' => 'delete', $datos['Ticket']['id']),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false, 'confirm' => __('Realmente desea eliminar éste ticket: %s?', $datos['Ticket']['id']))); 
      ?> 

      <?php //echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $servicio['Servicio']['id']), array('class' => 'btn btn-sm btn-default', 'confirm' => __('Realmente desea eliminar: %s?', $servicio['Servicio']['nombreservicio']))); ?>

      </div>
    </div>




    <!-- MODAL PARA SERVICIOS -->
<div class="form-group">

      <!-- INICIO VENTANA MODAL -->
      <div class="modal fade" id="modal-default">
       <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Añadir Servicios</h4>
          </div>
        <div class="col-md-12">     
                        
                        
          <!-- /.box-header -->         
          <!-- form start -->   
          <?php //echo $this->Form->create('DetalleTicket', array('url' => array('controller' => 'detalleTickets', 'action' => 'add'))); ?>      
                              
          
            <div class="form-group">                     
              <label>Servicios:</label>
              <?php echo $this->Form->input('servicio_id', array('options' => array($listaservicios), 'empty' => 'Seleccione un servicio', 'id' => 'servicio', 'class' => 'servicio', 'form-control select2 select2-hidden-accessible',  'label' => false)) ?>
            </div>

            <div class="form-group">
              <label>Precio Servicio:</label>
              <?php //echo $this->Form->input('precio', array('class' => 'precio form-control my-colorpicker1 colorpicker-element', 'id' => 'precio', 'label' => false, 'type' => 'text', 'value' => '', 'disabled' => true)); ?>
              <input id="precio" class="precio form-control my-colorpicker1 colorpicker-element" type="text" name="precio" disabled="true">
            </div>

            <div class="form-group">
              <label>Cantidad:</label>
              <?php //echo $this->Form->input('cantidad', array('class' => 'numeric form-control my-colorpicker1 colorpicker-element', 'id' => 'cantidad', 'label' => false, 'type' => 'numeric', 'value' => '')); ?>
              <input id="cantidad" type="text" name="cantidad"  class="numeric form-control my-colorpicker1 colorpicker-element">
            </div>

            <div class="form-group">
              <label>Monto:</label>
              <?php //echo $this->Form->input('Monto', array('class' => 'Monto form-control my-colorpicker1 colorpicker-element', 'id' => 'Monto', 'label' => false, 'type' => 'text', 'value' => '', 'disabled' => true)); ?>
              <input id="Monto" type="text" name="monto" disabled="true" class="Monto form-control my-colorpicker1 colorpicker-element">
            </div>
          <?php //Variable de transcriptor para ejemplo ?>
                    
          <?php //Enviando Variable a archivo js para guardar por medio de json ?>
          

           <?php echo $this->Form->hidden('monto', array('class' => 'monto')); ?>
           
        
     
                                              
                    
        </div>
        <div class="modal-footer">
          <button id="cerrarModal" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
          <?php //echo $this->Form->button('Agregar', array('id' => 'guardar', 'class' => 'btn btn-success pull-right', 'escape' => false, 'name' => 'agregar', 'value' => 'agregar')); ?>
          <button data-backdrop="false" data-dismiss="modal"  type="button" class="btn btn-success" id="guardar">Guardar</button>
        </div>

        <?php

          echo $this->Form->hidden('ticket_id', array('id' => 'ticket', 'default' => $datos['Ticket']['id'])); 

          echo $this->Form->hidden('usuario_id', array('id' => 'usuario', 'default' => $current_user['id'])); 

        ?>

                      
        <?php //echo $this->Form->end(); ?>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- FIN VENTANA MODAL -->

  

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



<div id="detalleTicket5"></div>
<?php //debug($detalles); ?>

<?php if ($detalles == null) {?>


<h1>Este ticket no tiene servicios asignados</h1>

<?php } else  { ?>

<div id="tablaDetalleTicket">

<div class="col-md-10 col-md-offset-1">

  <table class="table tabla-condensed table-striped">


<thead>

  <tr>

   <th>Código</th>
   <th>Nombre</th>
   <th>Cantidad</th>
   <th>Precio</th>
   <th>Subtotal</th>
   <th></th>

  </tr>

</thead>

<tbody>
<?php $tabindex = 1; ?>
<?php foreach ($detalles as $detalle): ?>

 
<tr>
   
   <div class="row" id="row-<?php echo $detalle['DetalleTicket']['id']; ?>">

    <td><?php echo $detalle['Servicio']['codigoservicio']; ?></td>

     <td><?php echo $detalle['Servicio']['nombreservicio']; ?></td>

    
    <td><?php echo $this->Form->input($detalle['DetalleTicket']['id'], array('div' => false, 'class' => 'edit_cant form-control input-mdall', 'label' => false, 'size' => 2, 'maxlenght' => 3, 'tabindex' => $tabindex++, 'data-id' => $detalle['DetalleTicket']['id'], 'data-servicio' => $detalle['Servicio']['id'], 'value' => $detalle['DetalleTicket']['cantidad'])); ?></td>


    <td><?php echo number_format($detalle['Servicio']['precio'], 2,",","."); ?> Bs.</td>
     
    

      <td>
          
            <span  id="monto">
             <?php echo number_format($detalle['DetalleTicket']['monto'], 2,",",".");  ?>
            </span>
            Bs.
          <div id="subtotal"></div>
      </td>
    
      <td class="actions">
 
        
       <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', '#', array('escapeTitle' => false, 'title' => 'Eliminar servicio', 'id' => $detalle['DetalleTicket']['id'], 'class' => 'remove')); ?>

        <?php //echo $this->Form->postLink(__('Eliminar'), array('controller' => 'detalleTickets', 'action' => 'delete', $detalle['DetalleTicket']['id'], $current_user['id']), array('class' => 'btn btn-sm btn-danger', 'confirm' => __('Realmente desea eliminar este servicio?', $detalle['DetalleTicket']['id']) )); ?></td>


    
     
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

</div>

</div>

<?php } ?>

<br>
<br>
		
	</div>


  <div class="box-footer">
    <div class="form-group">
      <?php echo $this->Html->link("<i class='fa fa-save'></i> Procesar ticket", array('action' => 'guardar_ticket', $datos['Ticket']['id']), array('type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false)); 
      ?>
      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array(
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



  

