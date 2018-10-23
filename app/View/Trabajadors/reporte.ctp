
<?php echo $this->Html->script(array('myjs/consultar_reporte_transcriptores')); ?>


<div class="box box-danger box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Estadísticas de Transcriptores</h3>




              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>


                <div class="row">
                  <div class="col-md-12">

                    
                      <div class="box-header">
                        <h3 class="box-title"><strong>Rango de fecha a consultar</strong></h3>
                      </div>
                      <div class="box-body">
                        <!-- Date dd/mm/yyyy -->
                        <div class="form-group">
                          
                           <div class="row">
                       

                                <div class="col-md-0">
                                  <?php //echo $this->Form->input('Rango de fecha', array('type'=> 'checkbox', 'div' => false)); ?>
                                </div>
                                <div class="col-md-3">
                                <?php echo $this->Form->input('Desde', array('id' => 'desde', 'type' => 'date', 'dateFormat' => 'DMY')); ?>
                                </div>
                                <div class="col-md-3">
                                <?php echo $this->Form->input('Hasta', array('id' => 'hasta', 'type' => 'date', 'dateFormat' => 'DMY')); ?>
                                </div>
                                <?php echo $this->Form->button('Consultar', array('id' => 'consultar')); ?>
                            

                           </div>
                          
                        </div>
                        <!-- /.form group -->

                      </div>
                    
                  </div>
                </div>

               


          <!--  <div class="box-body">
	              <div id="grafico" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

            </div> -->

            <div class="box-body">
              <div class="table-responsive">
                
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                        <div class="box">
                         
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div id="tablaReporte">
                              


                            </div>
                  
                    <!--
                    <div class="progress oculto" id="procesando">
                          <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><span class="sr-only">100% Complete</span>
                          </div>
                        </div>
                    -->

                          </div>
                          <!-- /.box-body -->

                          

                        </div>
                        <!-- /.box -->
              </div>



              </div>
            </div>


</div>



