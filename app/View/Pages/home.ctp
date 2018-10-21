<div class="container">  

	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
		
        <div class="carousel-inner" role="listbox">

			<div class="item active">
				<?php echo $this->Html->image('tecnologia.jpeg',array('alt' =>'First slide','class' => 'img-responsive'));?>
			</div>
			
			<div class="item">
				<?php echo $this->Html->image('bosque.png',array('alt' =>'First slide','class' => 'img-responsive'));?>
			</div>
			
			<div class="item">
				<?php echo $this->Html->image('naturaleza.jpg',array('alt' =>'First slide','class' => 'img-responsive'));?>
			</div>
		</div>

		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			  <span class="sr-only">Previous</span>
		</a>
		
		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

	</div>

</div>
  