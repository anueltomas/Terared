
<div class="box box-danger box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-server"></i> Editar Frecuencia de Facturación</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>



  <div class="box-body">
  





 <?php echo $this->Form->create('Configuration'); ?>
  <?php $tipo_frecuencia = $this->request->data['Configuration']['tipo']; ?>
  <input type="hidden" id="tipo_frecuencia" value=<?php echo $tipo_frecuencia; ?> >  
             <fieldset>
          
                <div class="row-fluid">
                  <div class="col-md-4">
                   
                <div class="col-lg-8">

                   <?php if ($tipo_frecuencia == 'TICKETS') { ?>
                     <div class="form-group">
                              <div class="radio">
                                <label>

                                  <input name="opcion" id="option1" value="monto"  type="radio" >
                                  Por Monto
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input name="opcion" id="option2" value="ticket" type="radio" checked="true">
                                  Por Tickets
                                </label>
                              </div>
                   </div>
                   <?php } else { ?>
                      <div class="form-group">
                              <div class="radio">
                                <label>

                                  <input name="opcion" id="option1" value="monto"  type="radio" checked="true">
                                  Por Monto
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input name="opcion" id="option2" value="ticket" type="radio">
                                  Por Tickets
                                </label>
                              </div>
                   </div>
                   <?php } ?>
                   
                   <?php if ($tipo_frecuencia == 'TICKETS') { ?>

                    <label>Monto Bs.</label>
                            <div class="input-group">
                              <input class="form-control" type="text" name="monto" id="monto" value=<?php echo $this->request->data['Configuration']['monto']; ?> required disabled="true"> 
                            </div>

                      <label>Cantidad Tickets</label>
                            <div class="input-group">
                              <input class="form-control" type="text" name="cantidad" id="ticket" value=<?php echo $this->request->data['Configuration']['ticket'] ?> required > 
                            </div>

                
                    <?php } else { ?>
                      <label>Monto Bs.</label>
                            <div class="input-group">
                              <input class="form-control" type="text" name="monto" id="monto" value=<?php echo $this->request->data['Configuration']['monto']; ?> required> 
                            </div>

                      <label>Cantidad Tickets</label>
                            <div class="input-group">
                              <input class="form-control" type="text" name="cantidad" id="ticket" value=<?php echo $this->request->data['Configuration']['ticket'] ?> required disabled="true"> 
                            </div>
                    <?php } ?>


                            <input class="form-control" type="hidden" name="id"  value=<?php echo $this->request->data['Configuration']['id']; ?> > 
                            <!-- /input-group -->
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



<script type="text/javascript"> 
  addEventListener('load',inicio,false);
  var tipo = document.getElementById('tipo_frecuencia').value;
    function inicio()
    {
      
      if (tipo == "TICKETS") {

        document.getElementById('option1').addEventListener('change',monto,false);
        document.getElementById('option2').addEventListener('change',ticket,true);
        deshabilitar();
      }else {
        document.getElementById('option1').addEventListener('change',monto,true);
        document.getElementById('option2').addEventListener('change',ticket,false);
        deshabilitar();
      }
      
      
    }

    function deshabilitar()
    {
      if (tipo == "TICKETS") {
        var ticket = document.getElementById('ticket');
        var monto = document.getElementById('monto');
        ticket.disabled = false;
        monto.disabled = true;
      }else{
        var ticket = document.getElementById('ticket');
        var monto = document.getElementById('monto');
        ticket.disabled = true;
        monto.disabled = false;
      }
      
    }


    function monto()
    {
      var ticket = document.getElementById('ticket');
      var monto = document.getElementById('monto');
      ticket.disabled = true;
      monto.disabled = false;
    }

    function ticket()
    {
      var ticket = document.getElementById('ticket');
      var monto = document.getElementById('monto');
      ticket.disabled = false;
      monto.disabled = true;
    }
 
</script>


