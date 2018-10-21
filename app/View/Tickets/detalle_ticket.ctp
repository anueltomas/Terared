<?php echo $this->Html->script('myjs/remove_servicio.js'); ?>

<?php echo $this->Html->script('myjs/edit_cant_serv.js'); ?>

<?php echo $this->Html->script('jquery-ui/jquery.animate-colors-development.js'); ?>


<div class="col-md-10 col-md-offset-1">

<!--Nueva estructura -->

<table class="table tabla-condensed table-striped">



<thead>

  <tr>

   <th>Código</th>
   <th>Nombre</th>
   <th>Cantidad</th>
   <th>Precio</th>
   <th>Subtotal</th>
   <th>Eliminar</th>

  </tr>

</thead>

<tbody>
<?php $tabindex = 1; ?>
<?php foreach ($detalles as $detalle): ?>
 <?php //debug($servicio); ?>
<tr>
   
   <div class="row" id="row-<?php echo $detalle['DetalleTicket']['id']; ?>">

    <td><?php echo $detalle['Servicio']['codigoservicio']; ?></td>

     <td><?php echo $detalle['Servicio']['nombreservicio']; ?></td>

    
    <td><?php echo $this->Form->input($detalle['DetalleTicket']['id'], array('div' => false, 'class' => 'edit_cant form-control input-mdall', 'label' => false, 'size' => 2, 'maxlenght' => 3, 'tabindex' => $tabindex++, 'data-id' => $detalle['DetalleTicket']['id'], 'data-servicio' => $detalle['Servicio']['id'], 'value' => $detalle['DetalleTicket']['cantidad'])); ?></td>


    <td><?php echo number_format($detalle['Servicio']['precio'], 2,",","."); ?> Bs.</td>
     
    

      <td>
          <div  class="pull-right tr">
            <?php echo number_format($detalle['DetalleTicket']['monto'], 2,",",".");  ?>
            </span>
            Bs.
          </div>
      </td>
    


    <td><?php echo $this->Html->link('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', '#', array('escapeTitle' => false, 'title' => 'Eliminar servicio', 'id' => $detalle['DetalleTicket']['id'], 'class' => 'remove')); ?></td>

     
   </div>

  </tr>
 

<?php endforeach; ?>

</tbody>

</table>






<!-- Nueva estructura -->


</div>