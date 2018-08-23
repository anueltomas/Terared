<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TeraRED | Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!--///////////////////////---------------------///////////////////////////// -->
  <!-- Bootstrap 3.3.7 -->
  <?php echo $this->Html->css(array('carousel', 'misEstilos')); ?>

  <?php echo $this->Html->css(array(
        'bootstrap/css/bootstrap.min',
        'bootstrap/css/signin',
        'font-awesome/css/font-awesome.min',
        'adminlte/css/AdminLTE.min',
        'adminlte/css/iCheck/square/_all',
        'adminlte/css/iCheck/all',
        'adminlte/css/skins/_all-skins.min',
        'jquery-ui/jquery-ui.min')
      ); ?>
  <?php echo $this->Html->script(array(
        'jquery/1.12.4/jquery-1.12.4.min',
        'jquery-ui/jquery-ui.min')
      ); ?>

      <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

  <body class="hold-transition skin-blue-light fixed sidebar-mini">
    
    <?php if(isset($current_user)){ ?>
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">
          <?php echo $this->element('MainHeader'); ?>    
      </header>

      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
          <?php echo $this->element('MainSidebar'); ?>    
      </aside>

      <!-- Content Wrapper. Contains page content -->

      <div class="content-wrapper">
        <!-- Content Header (Page header) -->

          
        <section class="content-header">
          <?php echo $this->Flash->render(); ?>
          <h1>
            <small>Inversiones TeraRED "Navega, imprime, copia y más..."</small>
          </h1>

          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $this->name; ?></a></li>
            <li class="active"><?php echo $this->action; ?></li>
          </ol>
          
        </section>

        
        <!-- Main content -->
        <section class="content container-fluid">

          <!--------------------------
            | Your Page Content Here |
            -------------------------->

            <div class="row">
              <?php echo $this->Flash->render(); ?>
            </div>
            
              <?php echo $this->fetch('content'); ?>

           
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <div class="container">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
              <b>Versión 1.0.0</b>
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2017-2018  <a href="#"> Inv. TeraRed C.A.</a>.</strong> All rights reserved.
            <?php  echo $this->element('sql_dump'); ?>
        </div>
      </footer>


      <?php echo $this->Html->script('bootstrap/js/bootstrap.min'); ?>
      <?php echo $this->Html->script('adminlte/js/adminlte.min'); ?>
      <?php echo $this->Html->script('adminlte/js/demo.js'); ?>
       <?php echo $this->Html->script('adminlte/iCheck/icheck.min'); ?>

      <script type="text/javascript">
        var basePath = "<?php echo Router::url('/');?>"
      </script>

    
    <!-- ./wrapper -->
        
      <?php }else{ ?>
      <?php //debug($current_user); ?>
     
      <div class="container" role="main">

             <div class="row">
              <?php echo $this->Flash->render(); ?>
            </div>

              <?php echo $this->fetch('content'); ?>

     </div>
     <?php } ?>
    </div>
  </body>
</html>

