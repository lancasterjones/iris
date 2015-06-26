<?php
	//recolectar variables
	$mes  = $_REQUEST['mes'];
	$year = $_REQUEST['year'];

	if($mes < 10) $fecha = $year . "0" . $mes;
	else $fecha = $year . $mes;

	//conexión a base de datos
	$servidor = "104.236.137.39";
	$db_name  = "admin_sistemaproductos";
	$usuario  = "admin_fotos";
	$pass     = "9Fdvi3D4LR";

	$conect = new mysqli($servidor, $usuario, $pass, $db_name)
			  or die("Imposible conectar a DB");

	//crear consulta
	$query = "SELECT mas_vendidos.mes,
	       mas_vendidos.foto,
	       inventarios.modelo,
	       inventarios.inventario,
	       mas_vendidos.cantidad
		   FROM admin_sistemaproductos.inventarios inventarios
	       INNER JOIN admin_sistemaproductos.mas_vendidos mas_vendidos
	       ON (inventarios.sku = mas_vendidos.sku)
	       WHERE (mas_vendidos.mes = '$fecha')
	       ORDER BY mas_vendidos.cantidad DESC";

	$consulta = mysqli_query($conect, $query);
	$x = 1;
		while($row = mysqli_fetch_array($consulta))
		{
			$foto[$x]       = $row['foto'];
			$modelo[$x]     = $row['modelo'];
				if($row['qty'] > 0)				
					$existencia[$x] = 1;				
				else
					$existencia[$x] = 0;
			$elementos = $x;
			$x++;
		}
?>

<div id="vendidos" class="carousel slide" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
	<legend>Lo + vendido</legend>
	<ol class="carousel-indicators">
		<li data-target="#vendidos" data-slide-to="0" class="active">

		<?php 
			if($elementos > 4) { 
		?>
			<li data-target="#vendidos" data-slide-to="1">

		<?php
			} 
			if($elementos > 8) { 
		?>
			<li data-target="#vendidos" data-slide-to="2">
		<?php } ?>

	</ol>
	<div class="carousel-inner">
		<div class="item active">
			<div class="row">
				<?php 
					if($elementos > 0)
					{	
						if($elementos > 4) $stop = 4;
							else $stop = $elementos;

						for($x = 1; $x <= $stop; $x++) 
						{ 
				?> 
							<div class="col-md-3">
								<a href="#" class="thumbnail" style="margin: 0px;">
									<img src="http://d1x736u1i353au.cloudfront.net/media/catalog/product<?php echo $foto[$x]; ?>">
								</a>

								<?php 
									if($existencia[$x] == 1) 
									{ 
							     ?>
										<span class="col-md-offset-4 label label-success">
											<i class="glyphicon glyphicon-ok"></i>							
										</span>
										<span class="label label-default">
								<?php } 
								      elseif($existencia[$x] == 0) 
								      { 
								?>
										<span class="col-md-offset-4 label label-danger"> 
											<i class="glyphicon glyphicon-remove"></i>
										</span>
										<span class="label label-default">
											<?php } echo $modelo[$x]; ?>
										</span>
							</div>		
				<?php   }
				    }
				?>
			</div>
		</div><!--Item active-->

		<div class="item">
			<div class="row">
				<?php 
					if($elementos > 4)
					{
						if($elementos > 8) $stop = 8;
							else $stop = $elementos;
							
						for($x = 5; $x <= $stop; $x++) 
						{ 
				?> 
							<div class="col-md-3">
								<a href="#" class="thumbnail" style="margin: 0px;">
									<img src="http://d1x736u1i353au.cloudfront.net/media/catalog/product<?php echo $foto[$x]; ?>">
								</a>

								<?php 
									if($existencia[$x] == 1) 
									{ 
							     ?>
										<span class="col-md-offset-4 label label-success">
											<i class="glyphicon glyphicon-ok"></i>							
										</span>
										<span class="label label-default">
								<?php } 
								      elseif($existencia[$x] == 0) 
								      { 
								?>
										<span class="col-md-offset-4 label label-danger"> 
											<i class="glyphicon glyphicon-remove"></i>
										</span>
										<span class="label label-default">
											<?php } echo $modelo[$x]; ?>
										</span>								
							</div>		
				<?php   }
				    }
				?>
			</div>
		</div><!--Item-->

		<div class="item">
			<div class="row">
				<?php 
					if($elementos > 8)
					{
						if($elementos > 10) $stop = 10;
							else $stop = $elementos;

						for($x = 9; $x <= $stop; $x++) 
						{ 
				?> 
							<div class="col-md-3">
								<a href="#" class="thumbnail" style="margin: 0px;">
									<img src="http://d1x736u1i353au.cloudfront.net/media/catalog/product<?php echo $foto[$x]; ?>">
								</a>

								<?php 
									if($existencia[$x] == 1) 
									{ 
							     ?>
										<span class="col-md-offset-4 label label-success">
											<i class="glyphicon glyphicon-ok"></i>							
										</span>
										<span class="label label-default">
								<?php } 
								      elseif($existencia[$x] == 0) 
								      { 
								?>
										<span class="col-md-offset-4 label label-danger"> 
											<i class="glyphicon glyphicon-remove"></i>
										</span>
										<span class="label label-default">
											<?php } echo $modelo[$x]; ?>
										</span>
							</div>		
				<?php   }
				    }
				?>
			</div>
		</div><!--Item-->
	</div>
	<?php
		if($elementos > 4){
	?>
		<a data-slide="prev" href="#vendidos" class="left carousel-control"  style="margin-top: 15%;">‹</a>
	    <a data-slide="next" href="#vendidos" class="right carousel-control" style="margin-top: 15%;">›</a>
    <?php } ?>
</div>