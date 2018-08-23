<div class="box box-primary box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-user"></i> Registrar Banco</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <?php echo $this->Form->create('Banco'); 
    ?>
    <fieldset>
      <legend><?php echo __('Datos generales'); ?></legend>

      <div class="row-fluid">
        <div class="col-md-4"><?php echo $this->Form->input('nombrebanco', array('label' => 'Denominación', 'class' => 'form-control', 'placeholder' => 'Denominación')); ?>
        </div>       
      </div>   
      <div class="row-fluid">
                  <div class="col-md-4">
                    <div class="checkbox">
                      <label>
                        <?php echo $this->Form->input('estadobanco', array('type' => "checkbox", 'label' => "Estado", 'default' => True)); ?>
                      </label>
                    </div>
                  </div>
              </div>   
    </fieldset>

    </div>
 
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
  <?php echo $this->Form->end(); ?>
</div>





