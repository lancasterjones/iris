<?php
	class slider
	{
		define("maximo_en_fila", 4);
		private $titulo;

		function crearSlider($titulo)
		{
?>
			<div id="slider" class="carousel slide" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
				<legend>
					<?php echo $this->$titulo; ?>
				</legend>
				<ol class="carousel-indicators">
					<li data-target="#slider" data-slide-to="0" class="active">
					<li data-target="#slider" data-slide-to="1">
				</ol>
				<div class="carousel-inner">
					<div class="item active">
						<div class="row">

							<?php for($x = 1; $x <= constant("maximo_en_fila"); $x++) { ?> 
								<div class="col-md-3">
									<a href="#" class="thumbnail" style="margin: 0px;">
										<img src="https://tienda.tecnolite.com.mx/media/catalog/product/cache/1/small_image/500x593/9df78eab33525d08d6e5fb8d27136e95/b/o/bombillas_a19led-3.5w-fil-az.jpg">
									</a>
								</div>		
							<?php } ?>

						</div>
					</div><!--Item active-->

					<div class="item">
						<div class="row">

							<?php for($x = 1; $x <= constant("maximo_en_fila"); $x++) { ?> 
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
<?php
		}//metodo crearSlider
	}//cierre de clase

	$main = new slider;
	$main->crearSlider();
?>