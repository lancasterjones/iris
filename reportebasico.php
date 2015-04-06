<?php

?>
<!DOCTYPE html>
<html lang='es'>
	<head>
		<title>Bienvenido || LOB</title>
		<?php 
			  include 'includes/head.php';
		?>     
	</head>
	<body>
	<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Iris</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Inicio <span class="sr-only">(current)</span></a></li>
        <li><a href="#">KPIs</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes Semanales <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Última Semana</a></li>
            <li class="divider"></li>
            <li><a href="#">Anteriores</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Buscar en sitio...">
        </div>
        <button type="submit" class="btn btn-default">Buscar</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="http://www.vende.io">Vende</a></li>
      </ul>
    </div>
  </div>
</nav>
		<div class="container">
			<div class="jumbotron">
			Ventas de la Semana: 
				<?php include 'includes/db_magento_connect.php';
					$result = mysqli_query($connm,"SELECT 
    sum(sales_flat_order.total_paid) Venta
    ,WEEK(sales_flat_order.created_at) Semana
    ,YEAR(sales_flat_order.created_at) Año
  FROM shop_production.sales_flat_order sales_flat_order
  WHERE     sales_flat_order.status IN ('complete', 'processing')
    AND (YEAR(sales_flat_order.created_at) = YEAR(CURDATE()))
  GROUP BY Semana");
					/*$venta = mysqli_fetch_row($mysqli_fetch_row($result);
					$venta_us = $venta[0];
					echo "<br> Venta";
					print_r($venta);
					echo "<br> Venta US:";
					print_r($venta_us);
					echo "<br>";
					echo $venta_us . "</br>"; */
				?>
				
			</div>

		</div>
	</body>
</html>