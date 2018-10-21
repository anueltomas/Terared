<!-- Logo -->
    <a href="<?php echo Router::url('/'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">T<b>RED</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Tera</b>RED</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <?php //debug($current_user); ?>

              <?php $privilegio = $this->Session->read('privilegio_id'); ?>

              <?php $nombreprivilegio = $this->Session->read('privilegio_nombre'); ?>

              <?php //debug($nombreprivilegio); ?>

              <?php if ($privilegio == 1){ ?>

              <?php //echo $this->Html->image('Tomas_Anuel.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>

              <?php } else { ?>

              <?php //echo $this->Html->image('Tomas_Anuel.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>

              <?php } ?>

              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $nombreprivilegio; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">

              <?php if ($privilegio == 1){ ?>

                <?php echo $this->Html->image('Tomas_Anuel.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>

                <?php } else { ?>
                
                <?php echo $this->Html->image('equipo.png', array('class' => 'img-circle', 'alt' => 'User Image')); ?>

                <?php } ?>

                <p>
                  <?php echo $current_user['nombreusuario']; ?>
                  <small>Miembro de Inversiones Terared C.A.</small>
                </p>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <?php echo $this->Html->link('Salir', array('controller' => 'usuarios', 'action' => 'logout'), array('class' => 'btn btn-default btn-flat')); ?>
                </div>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>
    </nav>