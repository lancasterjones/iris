<div id="slider" class="carousel slide" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
	<legend>Lo + vendido</legend>
	<ol class="carousel-indicators">
		<li data-target="#slider" data-slide-to="0" class="active">
		<li data-target="#slider" data-slide-to="1">
		<li data-target="#slider" data-slide-to="2">
	</ol>
	<div class="carousel-inner">
		<div class="item active">
			<div class="row">

				<?php for($x = 1; $x <= 4; $x++) { ?> 
					<div class="col-md-3">
						<a href="#" class="thumbnail" style="margin: 0px;">
							<img src="http://www.tecnolite.com.mx/hogar/public/images/uploads/products/big/ctl-8050.jpg">
						</a>
					</div>		
				<?php } ?>

			</div>
		</div><!--Item active-->

		<div class="item">
			<div class="row">

				<?php for($x = 1; $x <= 4; $x++) { ?> 
					<div class="col-md-3">
						<a href="#" class="thumbnail" style="margin: 0px;">
							<img src="http://tienda.tecnolite.com.mx/media/catalog/product/cache/1/image/500x593/9df78eab33525d08d6e5fb8d27136e95/t/i/tiras_mled-60-ip68-5050_1.jpg">
						</a>
					</div>		
				<?php } ?>

			</div>
		</div><!--Item-->

		<div class="item">
			<div class="row">

				<?php for($x = 1; $x <= 2; $x++) { ?> 
					<div class="col-md-3">
						<a href="#" class="thumbnail" style="margin: 0px;">
							<img src="https://tienda.tecnolite.com.mx/media/catalog/product/cache/1/small_image/500x593/9df78eab33525d08d6e5fb8d27136e95/b/o/bombillas_a19led-3.5w-fil-bc.jpg">
						</a>
					</div>		
				<?php } ?>

			</div>
		</div><!--Item-->
	</div>
	<a data-slide="prev" href="#slider" class="left carousel-control"  style="margin-top: 15%;">‹</a>
    <a data-slide="next" href="#slider" class="right carousel-control" style="margin-top: 15%;">›</a>
</div>