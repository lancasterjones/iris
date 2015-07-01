<?php
	require_once("../../config/db.php");
    require_once("../../classes/Login.php");
    $login = new Login();

      if ($login->isUserLoggedIn() == false) 
      {
         echo "<script>
                location.href='index.php';
              </script>";

      } 

    $cliente = $_SESSION['user_email'];
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
	       WHERE (mas_vistos.mes = $fecha) AND mas_vistos.cliente = '$cliente'
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

	$consulta_url = mysqli_query($conect, 
		"SELECT url_foto FROM sistema_multicliente 
			WHERE cliente = '$cliente' ");

		while($row_url = mysqli_fetch_array($consulta_url))
		{
			$url = $row_url['url_foto'];
		}
	
?>

<div id="vistos" class="carousel slide" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
	<legend>Lo + visto</legend>
	<ol class="carousel-indicators">
		<li data-target="#vistos" data-slide-to="0" class="active">

		<?php 
			if($elementos > 4) { 
		?>
			<li data-target="#vistos" data-slide-to="1">

		<?php
			} 
			if($elementos > 8) { 
		?>
			<li data-target="#vistos" data-slide-to="2">
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
									<img style="height: 270px;" src="http://tienda.tecnolite.com.mx/media/catalog/product<?php echo $foto[$x]; ?>">
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

		<?php 
			if($elementos > 4)
			{
		?>
				<div class="item">
					<div class="row">
				<?php				
						if($elementos > 8) $stop = 8;
							else $stop = $elementos;
							
						for($x = 5; $x <= $stop; $x++) 
						{ 
				?> 
							<div class="col-md-3">
								<a href="#" class="thumbnail" style="margin: 0px;">
									<img style="height: 270px;" src="http://tienda.tecnolite.com.mx/media/catalog/product<?php echo $foto[$x]; ?>">
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
				<?php   
				    }  //cierre for
				?>
			</div>
		</div><!--Item-->
		<?php 
			} // cierre if > 4
			if($elementos > 8)
			{
		?>
				<div class="item">
					<div class="row">	
				<?php			
						if($elementos > 10) $stop = 10;
							else $stop = $elementos;

						for($x = 9; $x <= $stop; $x++) 
						{ 
				?> 
							<div class="col-md-3">
								<a href="#" class="thumbnail" style="margin: 0px;">
									<img style="height: 270px;" src="http://tienda.tecnolite.com.mx/media/catalog/product<?php echo $foto[$x]; ?>">
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
				<?php   
				    }
				?>
			</div>
		</div><!--Item-->
	<?php } ?>
	</div>

	<?php
		if($elementos > 4){
	?>
		<a data-slide="prev" href="#vistos" class="left carousel-control"  style="margin-top: 15%;">‹</a>
	    <a data-slide="next" href="#vistos" class="right carousel-control" style="margin-top: 15%;">›</a>
    <?php } ?>

</div>

<script>
	console.log('<?php echo $url; ?>');
</script>