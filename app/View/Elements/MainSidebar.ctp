<!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
        <?php echo $this->Html->image('logotera.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $current_user['nombreusuario']; ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENÚ PRINCIPAL</li>
        <!-- Optionally, you can add icons to the links -->
        
        <li class="treeview">
          <li><?php echo $this->Html->link("<i class='fa  fa-user-plus'></i> Público", array('controller' => 'clientes', 'action' => 'index'), array('escape' => false)); ?></li>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-list-alt"></i> <span>Tickets</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><?php echo $this->Html->link("<i class='fa  fa-th-list'></i> Listado de tickets", array('controller' => 'tickets', 'action' => 'index'), array('escape' => false)); ?></li>

            <?php $privilegio = $this->Session->read('privilegio_id'); ?>

            <?php if ($privilegio == 4) {
              # code...
            } else {?>
            <li><?php echo $this->Html->link("<i class='fa fa-ticket'></i> Actual", array('controller' => 'tickets', 'action' => 'ticketactual'), array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link("<i class='fa  fa-rocket'></i> Express", array('controller' => 'tickets', 'action' => 'express'), array('escape' => false)); ?></li>
            <?php } ?>
          </ul>
        </li>

        <?php if($privilegio == '1' || $privilegio == '2'): ?>

        <li class="treeview">
          <a href="#"><i class="fa fa-money"></i> <span>Caja</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">

           <li><?php echo $this->Html->link("<i class='fa  fa-list-alt'></i> Administrar", array('controller' => 'tickets', 'action' => 'administrar_caja'), array('escape' => false)); ?></li>

            <li><?php echo $this->Html->link("<i class='fa  fa-list-alt'></i> Cobrar", array('controller' => 'tickets', 'action' => 'caja'), array('escape' => false)); ?></li>

            <li><?php echo $this->Html->link("<i class='fa  fa-th-list'></i> Gastos", array('controller' => 'gastos', 'action' => 'index'), array('escape' => false)); ?></li>

            <li><?php echo $this->Html->link("<i class='fa  fa-ticket'></i> Tickets pagados", array('controller' => 'tickets', 'action' => 'pagados'), array('escape' => false)); ?></li>
           
            <li><?php echo $this->Html->link("<i class='fa  fa-th-list'></i> Puntos", array('controller' => 'bancopuntos', 'action' => 'index'), array('escape' => false)); ?></li>

            <li><?php echo $this->Html->link("<i class='fa  fa-th-list'></i> Transferencias", array('controller' => 'bancos', 'action' => 'index'), array('escape' => false)); ?></li>
      
            <li><?php echo $this->Html->link("<i class='fa  fa-list-alt'></i> Resumen de Cierres", array('controller' => 'cierres', 'action' => 'principal'), array('escape' => false)); ?></li>

            <li><?php echo $this->Html->link("<i class='fa  fa-list-alt'></i> Historico de Tickets", array('controller' => 'tickets', 'action' => 'historico_pagos'), array('escape' => false)); ?></li>
           </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-bar-chart"></i> <span>Estadísticas</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">

           <li><?php echo $this->Html->link("<i class='fa  fa-bookmark-o'></i> Generales", array('controller' => 'estadisticas', 'action' => 'index'), array('escape' => false)); ?></li>

           <li><?php echo $this->Html->link("<i class='fa   fa-text-width'></i> Transcriptores", array('controller' => 'trabajadors', 'action' => 'reporte'), array('escape' => false)); ?></li>

           <li><?php echo $this->Html->link("<i class='fa   fa-strikethrough'></i> Servicios", array('controller' => 'servicios', 'action' => 'reporte'), array('escape' => false)); ?></li>

           </ul>
        </li>


         <?php endif; ?>
         
         <?php if($privilegio == '4' ): ?>

        <li class="treeview">
          <a href="#"><i class="fa fa-money"></i> <span>Caja</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">

            <li><?php echo $this->Html->link("<i class='fa  fa-list-alt'></i> Cobrar", array('controller' => 'tickets', 'action' => 'caja'), array('escape' => false)); ?></li>

            <li><?php echo $this->Html->link("<i class='fa  fa-ticket'></i> Tickets pagados", array('controller' => 'tickets', 'action' => 'pagados'), array('escape' => false)); ?></li>

            <li><?php echo $this->Html->link("<i class='fa  fa-th-list'></i> Gastos", array('controller' => 'gastos', 'action' => 'index'), array('escape' => false)); ?></li>
           
             <li><?php echo $this->Html->link("<i class='fa  fa-list-alt'></i> Facturación", array('controller' => 'tickets', 'action' => 'facturar'), array('escape' => false)); ?></li>

             <li><?php echo $this->Html->link("<i class='fa  fa-list-alt'></i> Resumen", array('controller' => 'resumen', 'action' => 'index'), array('escape' => false)); ?></li>


           </ul>
        </li>

         <?php endif; ?>

        <li class="treeview">
          <a href="#"><i class="fa fa-qrcode"></i> <span>Servicios</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
          <?php if($privilegio == '1' || $privilegio == '2'): ?>
            <li><?php echo $this->Html->link("<i class='fa fa-tachometer'></i> Gestionar Servicios", array('controller' => 'servicios', 'action' => 'index'), array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-th-list'></i> Tipos de Servicios", array('controller' => 'tservicios', 'action' => 'index'), array('escape' => false)); ?></li>
          <?php endif; ?>
            <li><?php echo $this->Html->link("<i class='fa fa-th-list'></i> Listado de Servicios", array('controller' => 'servicios', 'action' => 'listado'), array('escape' => false)); ?></li>
          </ul>
        </li>

        
        <li class="treeview">
          <a href="#"><i class="fa fa-strikethrough"></i> <span>Sistema</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <?php if($privilegio == '1' || $privilegio == '2'){ ?>
          <ul class="treeview-menu">
            <li><?php echo $this->Html->link("<i class='fa fa-users'></i> Usuarios", array('controller' => 'usuarios', 'action' => 'index'), array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-text-width'></i> Trabajadores", array('controller' => 'trabajadors', 'action' => 'index'), array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-star-o'></i> Privilegios", array('controller' => 'privilegios', 'action' => 'index'), array('escape' => false)); ?></li>

            <li class="treeview">
                <a href="#"><i class="fa fa-database"></i> <span>Base de Datos</span>
                  <span class="pull-right-container"></span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><?php echo $this->Html->link("<i class='fa fa-user'></i> Respaldar", array('controller' => 'bdatos', 'action' => 'respaldar'), array('escape' => false)); ?></li>
                </ul>

              </li>


          </ul>
            <?php } else{ ?>
            <ul class="treeview-menu">
              <li><?php echo $this->Html->link("<i class='fa fa-user'></i> Usuario", array('controller' => 'usuarios', 'action' => 'editarusuario'), array('escape' => false)); ?></li>
          </ul>
          <?php } ?>
            
        </li>


        <li class="treeview">
          <a href="#"><i class="fa fa-share-alt-square"></i> <span>Ayuda</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><?php echo $this->Html->link("<i class='fa  fa-question-circle'></i> Acerca de", array('controller' => 'principal', 'action' => 'acercade'), array('escape' => false)); ?></li>
          </ul>
        </li>
        
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->

    