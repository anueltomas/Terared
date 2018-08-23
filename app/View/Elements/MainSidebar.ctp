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
          <a href="#"><i class="fa fa-user-plus"></i> <span>Público</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><?php echo $this->Html->link("<i class='fa  fa-th-list'></i> Clientes", array('controller' => 'clientes', 'action' => 'index'), array('escape' => false)); ?></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-list-alt"></i> <span>Tickets</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><?php echo $this->Html->link("<i class='fa  fa-th-list'></i> Listado de tickets", array('controller' => 'tickets', 'action' => 'index'), array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-ticket'></i> Ticket actual", array('controller' => 'tickets', 'action' => 'ticketactual'), array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link("<i class='fa  fa-rocket'></i> Ticket Express", array('controller' => 'tickets', 'action' => 'express'), array('escape' => false)); ?></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-money"></i> <span>Caja</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><?php echo $this->Html->link("<i class='fa  fa-list-alt'></i> Tickets", array('controller' => 'tickets', 'action' => 'caja'), array('escape' => false)); ?></li>
           
            <li><?php echo $this->Html->link("<i class='fa  fa-th-list'></i> Puntos", array('controller' => 'bancopuntos', 'action' => 'index'), array('escape' => false)); ?></li>
           </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-qrcode"></i> <span>Servicios</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
          <?php if($current_user['privilegio_id'] == '1' || $current_user['privilegio_id'] == '2'): ?>
            <li><?php echo $this->Html->link("<i class='fa fa-tachometer'></i> Gestionar Servicios", array('controller' => 'servicios', 'action' => 'index'), array('escape' => false)); ?></li>
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
          <?php if($current_user['privilegio_id'] == '1' || $current_user['privilegio_id'] == '2'){ ?>
          <ul class="treeview-menu">
            <li><?php echo $this->Html->link("<i class='fa fa-users'></i> Usuarios", array('controller' => 'usuarios', 'action' => 'index'), array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-text-width'></i> Trabajadores", array('controller' => 'trabajadors', 'action' => 'index'), array('escape' => false)); ?></li>
            <li><?php echo $this->Html->link("<i class='fa fa-star-o'></i> Privilegios", array('controller' => 'privilegios', 'action' => 'index'), array('escape' => false)); ?></li>
            <?php } else{ ?>
            <ul class="treeview-menu">
              <li><?php echo $this->Html->link("<i class='fa fa-user'></i> Usuario", array('controller' => 'usuarios', 'action' => 'editarusuario', $current_user['id']), array('escape' => false)); ?></li>

          <?php } ?>
            </ul>
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

    