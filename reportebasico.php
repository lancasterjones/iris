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
        <li><a href="http://www.vende.io">Vende.io</a></li>
      </ul>
    </div>
  </div>
</nav>
		<div class="container">
			<div class="jumbotron">
			Ventas de la Semana: 
				<?php require 'includes/db_magento_connect.php';
          $semana = date("W");
					$query = "SELECT 
    sum(sales_flat_order.total_paid) Venta
    ,WEEK(sales_flat_order.created_at) Semana
    ,YEAR(sales_flat_order.created_at) Año
  FROM shop_production.sales_flat_order sales_flat_order
  WHERE     sales_flat_order.status IN ('complete', 'processing')
    AND (YEAR(sales_flat_order.created_at) = YEAR(CURDATE())) AND
    AND Semana = $semana
    GROUP BY Semana
    ORDER BY Semana DESC ";
				
          $result = mysqli_query($connm,$query);
          $i = 0;
            while( $row = mysqli_fetch_array($result)) {
            if ($i == 0){
              $venta = $row['Venta'];
            }
          }
          mysqli_free_result($result);
          mysqli_close($connm);
        ?>
          
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title" style="width: 50%">Ventas Semanales <span style="float: right;">S <?php echo $semana; ?></span></h3>
            </div>
            <div class="panel-body">
              Venta: $<?php echo $venta; ?>
            </div>
          </div>



				
				
			</div>

		</div>
	</body>
</html>