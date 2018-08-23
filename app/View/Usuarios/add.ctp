<?php //debug($trabajadors); ?>
<?php echo $this->Html->script(array('myjs/ver_password', 'myjs/comprobar_contraseña')); ?>

<div class="box box-primary box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-user"></i> Registrar Usuario</h3>
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
      <legend><?php echo __('Datos generales'); ?></legend>

      <div class="row-fluid">
        <div class="col-md-4"><?php echo $this->Form->input('nombreusuario', array('label' => 'Nombre de Usuario', 'class' => 'form-control', 'placeholder' => 'Nombre del usuario')); ?>
        </div>
        <div class="col-md-4">
          <label>Trabajador</label>
          <div class="input-group">
            <?php echo $this->Form->input('trabajador_id', array('label' => false, 'class' => 'form-control')); ?>
                    
            <span class="input-group-btn">
              <?php echo $this->Html->link('Nuevo', array('controller' => 'trabajadors', 'action' => 'nuevo'), array('class' => 'btn btn-primary')); ?>
            </span>
                    
          </div>
        </div>
        <div class="col-md-4">
          <label>Privilegio</label>
          <div class="input-group">
            <?php echo $this->Form->input('privilegio_id', array('label' => false, 'class' => 'form-control')); ?>
            <span class="input-group-btn">
              <?php echo $this->Html->link('Nuevo', array('controller' => 'privilegios', 'action' => 'nuevo'), array('class' => 'btn btn-primary')); ?>
            </span>
            
          </div>
        </div>
        
      </div>

       <br>
      <br>
      <br>
      <br>
      <br>
      <br>

       

      <div class="row-fluid">

      <div class="col-md-4"><?php echo $this->Form->input('username', array('label' => 'Username', 'class' => 'form-control', 'placeholder' => 'Login')); ?>
        </div>
        <div class="col-md-4"><?php echo $this->Form->input('contraseña', array('id' => 'contraseña', 'name' => 'contraseña', 'type' => 'password', 'class' => 'form-control', 'label' => 'Contraseña', 'placeholder' => 'Contraseña', 'value' => "")); ?><i class="fa fa-eye", id="show">Descubrir contraseña</i>
        </div>
        <div class="col-md-4"><?php echo $this->Form->input('rcontraseña', array('id' => 'rcontraseña', 'name' => 'rcontraseña','type' => 'password', 'class' => 'form-control', 'label' => 'Comprobar Contraseña', 'placeholder' => 'Comprobar contraseña', 'value' => "")); ?><i class="fa fa-eye", id="show2">Descubrir contraseña</i>
        </div>
        
      </div>

      <div class="row-fluid">
                  <div class="col-md-4">
                    <div class="checkbox">
                      <label>
                        <?php echo $this->Form->input('estadousuario', array('type' => "checkbox", 'label' => "Estado del Usuario", 'default' => True)); ?>
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




