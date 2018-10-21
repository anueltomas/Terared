
<div class="box box-danger box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-server"></i> Añadir Frecuencia de Facturación</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>



  <div class="box-body">
  





 <?php echo $this->Form->create('Configuration'); ?>
             <fieldset>
              
                <div class="row-fluid">
                  <div class="col-md-4">
                   
                <div class="col-lg-8">

                   <div class="form-group">
                              <div class="radio">
                                <label>
                                  <input name="opcion" id="option1" value="monto"  type="radio">
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


                    <label>Monto Bs.</label>
                            <div class="input-group">
                              <input class="form-control" type="text" name="monto" id="monto" required> 
                            </div>

                      <label>Cantidad Tickets</label>
                            <div class="input-group">
                              <input class="form-control" type="text" name="cantidad" id="ticket" required> 
                            </div>
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
    function inicio()
    {
      document.getElementById('option1').addEventListener('change',monto,false);
      document.getElementById('option2').addEventListener('change',ticket,false);
      deshabilitar();
    }

    function deshabilitar()
    {
      var ticket = document.getElementById('ticket');
      var monto = document.getElementById('monto');
      ticket.disabled = true;
      monto.disabled = true;
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


