<?php //debug($current_user) ?>
<?php echo $this->Html->script(array('myjs/ver_password', 'myjs/comprobar_contraseña')); ?>

<div class="box box-primary box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-user"></i> Modificar datos de acceso</h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body">
    <?php echo $this->Form->create('Usuario'); 
    ?>
    <fieldset>
      <legend><?php echo __('Usuario/Contraseña'); ?></legend>

      <div class="form-group">
                  <?php echo $this->Form->input('id'); ?>
                </div>
       

      <div class="row-fluid">

      <div class="col-md-4"><?php echo $this->Form->input('username', array('label' => 'Username', 'class' => 'form-control', 'placeholder' => 'Login')); ?>
        </div>
        <div class="col-md-4"><?php echo $this->Form->input('contraseña', array('id' => 'contraseña', 'name' => 'contraseña', 'type' => 'password', 'class' => 'form-control', 'label' => 'Contraseña', 'placeholder' => 'Contraseña')); ?><i class="fa fa-eye", id="show">Descubrir contraseña</i>
        </div>
        <div class="col-md-4"><?php echo $this->Form->input('rcontraseña', array('id' => 'rcontraseña', 'name' => 'rcontraseña','type' => 'password', 'class' => 'form-control', 'label' => 'Comprobar Contraseña', 'placeholder' => 'Comprobar contraseña')); ?><i class="fa fa-eye", id="show2">Descubrir contraseña</i>
        </div>


      </div>
      
    </fieldset>

    </div>
 
  <div class="box-footer">
    <div class="form-group">
      <?php echo $this->Form->button("<i class='fa fa-save'></i> Grabar", array(
        'type' => 'submit', 'class' => 'btn btn-success pull-left', 'escape' => false)); 
      ?>
      <?php if ($current_user['Privilegio']['id'] != 1 || $current_user['Privilegio_id']['id'] != 2) { ?>

      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array('controller' => 'principal', 'action' => 'index',),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>

      <?php } else { ?>

      <?php echo $this->Html->link("<i class='fa fa-arrow-left'></i> Volver", array(
        'action' => 'index',),array('type' => 'submit', 'class' => 'btn btn-danger pull-right', 'escape' => false)); 
      ?>

      <?php } ?>
    </div>
  </div>
  <?php echo $this->Form->end(); ?>
</div>




