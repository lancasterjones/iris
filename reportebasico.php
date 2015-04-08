<?php
    if (version_compare(PHP_VERSION, '5.3.7', '<')) {
        exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
    } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
        // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
        // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
        require_once("libraries/password_compatibility_library.php");
    }

    // include the configs / constants for the database connection
    require_once("config/db.php");

    // load the login class
    require_once("classes/Login.php");

    $login = new Login();

    // ... ask if we are logged in here:
    if ($login->isUserLoggedIn() == false) {
       echo "
          <script>
              location.href='index.php';
          </script>
       ";

    } 
?>
<!DOCTYPE html>
<html lang='es'>
	<head>
		<title>Bienvenido || IRIS</title>
		<?php 
			  include 'includes/head.php';
		?>     

    <link rel="stylesheet" type="text/css" href="includes/estilo_reportes.css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:300,400,700" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Muli:300,400" rel="stylesheet" type="text/css">
	</head>
	<body>
  <?php require 'includes/db_magento_connect.php';
          $semana = date("W")-1;
          $query = "SELECT 
            count(sales_flat_order.total_paid) Pedidos
            ,sum(sales_flat_order.total_paid) Venta
            ,WEEK(sales_flat_order.created_at) Semana
            ,YEAR(sales_flat_order.created_at) Año
          FROM shop_production.sales_flat_order sales_flat_order
          WHERE     sales_flat_order.status IN ('complete', 'processing')
            AND YEAR(sales_flat_order.created_at) = YEAR(CURDATE())
            AND WEEK(sales_flat_order.created_at) = $semana";
        
          $result = mysqli_query($connm,$query);
          $i = 0;
            while( $row = mysqli_fetch_array($result)) {
            if ($i == 0){
              $venta = $row['Venta'];
              $pedidos = $row['Pedidos'];
            }
          }
          mysqli_free_result($result);

            $fraudes = "SELECT 
                         COUNT(sales_flat_order.total_paid) AS Pedidos,
                         SUM(sales_flat_order.total_paid) AS Venta,
                         WEEK(sales_flat_order.created_at) AS Semana,
                         YEAR(sales_flat_order.created_at) AS Año
                        FROM shop_production.sales_flat_order sales_flat_order
                        WHERE (    (    sales_flat_order.status IN ('riskified_declined')
                          AND YEAR(sales_flat_order.created_at) = YEAR(CURDATE()))
                          AND WEEK(sales_flat_order.created_at) = $semana)
                      ";
            $result = mysqli_query($connm,$fraudes);
             while( $row = mysqli_fetch_array($result)) {
              $monto_fraudes = $row['Venta'];
              $fraudes = $row['Pedidos'];
          }



          mysqli_close($connm);
        ?>

	<?php
    //menu de navegación
   include 'includes/menu.php' ?>


   <!--Rerporte de ventas-->
   <header class="lv-bg">
        <h1 class="site-title">Reporte de ventas</h1>
        <p>Semana: <?php echo $semana; ?></p>

   </header>

   <div class="container-fluid inner">
      <table class="tableizer-table">
          <tr class="tableizer-firtrow">
              <th>Ventas</th>
          </tr>
          <tr>
              <td>Monto de venta</td>
              <td>$<?php echo $venta; ?></td>
          </tr>
          <tr>
              <td>Pedidos</td>
              <td><?php echo $pedidos; ?></td>
          </tr>
      </table>
   </div>


		<div class="container">
			<div class="jumbotron">
			 <h1>Reporte de Ventas Semana: <?php echo $semana; ?> </h1>
				
          
          <div class="panel panel-primary" style="width: 50%">
            <div class="panel-heading">
              <h3 class="panel-title">Ventas</h3>
            </div>
            <div class="panel-body">
              <p>Monto Venta: $<?php echo $venta; ?></p>
              <p>Pedidos: <?php echo $pedidos; ?> </p>
              <p>Fraudes: <?php echo $fraudes; ?> ($<?php echo $monto_fraudes; ?>)</p>
              <p>Acumulado del Mes: </p>
            </div>
          </div>



				
				
			</div>

		</div>
	</body>
</html>