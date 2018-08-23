<!-- Static navbar -->
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
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

            <ul class="nav navbar-nav">
                      
             
              <li><?php echo $this->Html->link('Público', array('controller' => 'clientes', 'action' => 'index')); ?></li>

              <li class="dropdown">
              	<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Servicios<span class="caret"></span></a> 
              	<ul class="dropdown-menu">
                  <li><a href="<?php //echo URL; ?>naturales">Listado de Servicios</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="<?php //echo URL; ?>juridicos">Nuevo Servicio</a></li>
                </ul>
              </li>

              <li><a href="<?php //echo URL; ?>usuarios/"><span class="glyphicon glyphicon-tasks"></span>Usuarios</a></li>
              
             
              <li><a href="<?php //echo URL; ?>principal/acercade"><span class="glyphicon glyphicon-bookmark"> </span>Acerca de</a></li>
                        
            </ul>

            <ul class="nav navbar-nav navbar-right"><a class="navbar-brand" href=""><span>Usuario: <strong><?php //echo $_SESSION['nombreusuario']; ?></strong></span></a></ul>

            <form class="navbar-form navbar-left">
              
              <a href="<?php //echo URL; ?>Inicio/cerrar.php" type="button" class="btn btn-default"><i class="glyphicon glyphicon-share"></i> Salir</a>            
            </form>
            
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->