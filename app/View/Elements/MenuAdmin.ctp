<nav class="navbar navbar-default navbar-fixed-top">
  <nav id="menu">
      <div class="container" id="main" role="main">

            <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    

                    
                      <?php echo $this->Html->image('logotera.jpg', array('width'=>60, 'height'=>50)); ?>
                      <a class="navbar-brand navbar-right" href="<?php //echo URL; ?>"></a><img src="">
            </div>

          <div id="navbar" class="navbar-collapse collapse">
                      <ul class="menu">

                          <li><?php echo $this->Html->link('Principal', array('controller' => 'principal', 'action' => 'index')); ?></li>

                          <li class="active"><?php echo $this->Html->link('Servicios', array('controller' => 'servicios', 'action' => 'index')); ?>
                              <ul class="submenu">
                                <li><?php echo $this->Html->link('T. Servicios', array('controller' => 'tservicios', 'action' => 'index')); ?></li>
                                <li><?php echo $this->Html->link('Clientes', array('controller' => 'clientes', 'action' => 'index')); ?></li>

                                  <li><?php echo $this->Html->link('Transcriptores', array('controller' => 'transcriptors', 'action' => 'index')); ?></li>
                              </ul>
                          </li>


                          <li class="active"><a href="#s2">Sistema</a>
                              <ul class="submenu">
                                  <li><a href="">Base de Datos</a>
                                  </li>
                                  <li><?php echo $this->Html->link('Usuarios', array('controller' => 'usuarios', 'action' => 'index')); ?></li>
                                  <li><?php echo $this->Html->link('Privilegios', array('controller' => 'privilegios', 'action' => 'index')); ?></li>
                              </ul>
                          </li>

                          <li class="active"><?php echo $this->Html->link('Tickets', array('controller' => 'tickets', 'action' => 'index')) ?>
                              <ul class="submenu">
                                  <li><?php echo $this->Html->link('Documentos', array('controller' => 'documentos', 'action' => 'index')); ?></li>
                                  <li><?php echo $this->Html->link('M. Pagos', array('controller' => 'mpagos', 'action' => 'index')); ?></li>
                              </ul>
                          </li>
                          
                          <li><?php echo $this->Html->link('Acerca de', array('controller' => 'principal', 'action' => 'acercade')); ?></li>
                  </ul>
                      
          </div><!--/.nav-collapse -->

      </div>
  </nav>
</nav>



    