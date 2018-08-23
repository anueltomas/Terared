<?php //debug($usuarios); ?>
<?php echo $this->Html->script('myjs/ver_password.js'); ?>

<div class="box-body">


  
      

            <?php echo $this->Form->create('Usuario', array('class' => 'form-signin')); ?>
            <center>
  <?php echo $this->Html->image('logotera.jpg', array('width' => 200, 'height' => 180)); ?>
</center>

            <h2 class="form-signin-heading">Ingreso al Sistema</h2>
            <br>

            <?php echo $this->Form->input('id', array('type' => 'hidden')); ?>

            <?php echo $this->Form->input('username', array(
                  'class' => 'form-control','label' => false,
                  'placeholder' => 'Usuario', 'required' => 'autofocus'
              )); 
            ?>

            <br>

            <?php echo $this->Form->input('password', array('id' => 'contraseña',
                  'class'=> 'form-control','label' => false,
                  'placeholder' => 'Contraseña'
              )); 
            ?> <i class="fa fa-eye" id="show">Descubrir contraseña</i>     
            <br>
            <br>

            <?php echo $this->Form->button('Ingresar',array(
                  'type' => 'submit',
                  'class' => 'btn btn-lg btn-primary btn-block'
              )); 
            ?>

            <?php echo $this->Form->end(); ?>

            <!--
            <form class="form-signin">        
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me"> Recuerdame
                </label>
              </div>
            </form>
            -->

</div>
              