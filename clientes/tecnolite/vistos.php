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
	$query = "SELECT mas_vistos.mes,
	       mas_vistos.qty,
	       mas_vistos.foto,
	       mas_vistos.modelo,
	       mas_vistos.vistas
	 	   FROM admin_sistemaproductos.mas_vistos mas_vistos
	       WHERE (mas_vistos.mes = $fecha)
	       ORDER BY mas_vistos.vistas DESC";

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

<div id="slider" class="carousel slide" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
	<legend>Lo + visto</legend>
	<ol class="carousel-indicators">
		<li data-target="#slider" data-slide-to="0" class="active">
		<li data-target="#slider" data-slide-to="1">
		<li data-target="#slider" data-slide-to="2">
	</ol>
	<div class="carousel-inner">
		<div class="item active">
			<div class="row">
				<?php 
					if($elementos > 0)
					{
						for($x = 1; $x <= 4; $x++) 
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
						for($x = 5; $x <= 8; $x++) 
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
						for($x = 9; $x <= 10; $x++) 
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
	<a data-slide="prev" href="#slider" class="left carousel-control"  style="margin-top: 15%;">‹</a>
    <a data-slide="next" href="#slider" class="right carousel-control" style="margin-top: 15%;">›</a>
</div>