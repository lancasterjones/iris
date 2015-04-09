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
    <link href="http://docs.justinav.info/cfbc.css" rel="stylesheet" type="text/css">
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <script type="text/javascript" src="includes/Chart.js"></script>
  <script type="text/javascript" src="includes/script_reportes.js"></script>

  <style type="text/css">
      .pic{
        width: 200px;
      }
  </style>
	</head>
	<body>
  <?php 

       require 'includes/db_magento_connect.php';

       $semana = $_GET["semana"];  //asigna a la variable valor pasado a través de url
        $query ="";

        if($semana > 0)
        {
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


          //conexión a base de datos Vende para reportes mas vistos y mas vendidos

          //conectar bd vende
          $con=mysqli_connect("104.236.137.39","admin_fotos","9Fdvi3D4LR","admin_sistemaproductos");
          if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }else{ echo "Conexion MySql Ok";}
          $query_marzo = "
                SELECT * FROM mas_vendidos
                WHERE mes = '201503'
                ORDER BY mes DESC
          ";

          $restultado = mysqli_query($con, $query_marzo);
          $contenedor = array(array());   
          $contador = 0;

          while ($consulta = mysqli_fetch_array($resultado)) {
            $contenedor[$contador][0] = $consulta['sku'];
            $contador++;
          }


         //menu de navegación
           include 'includes/menu.php';

            echo '
           <header align="center">
                <h2 class="site-title">Reporte de ventas anteriores</h2>
                <p>Semana: '. $semana .'</p>          
           </header>

           <div class="container-fluid inner">
              <table class="tableizer-table">
                  <tr class="tableizer-firstrow">
                    <form action="reportes_anteriores.php" method="post">
                      <th>Ventas</th>
                      <th></th>
                      <th>
                        <div onclick="location.href=\'reportes_anteriores.php\'">
                            <i style="cursor: pointer; font-size: 24px" class="glyphicon glyphicon-circle-arrow-left pull-right"></i>
                        </div>
                      </th>
                    </form>
                  </tr>
                  <tr>
                      <td><canvas id="chart-area" width="100" height="100"/></canvas></td>
                      <td>Monto de venta</td>
                      <td>$'. number_format($venta).'</td>
                  </tr>
                  <tr>
                      <td><canvas id="canvas_line" height="120" width="150"></canvas></td>
                      <td>Pedidos</td>
                      <td>'. $pedidos . '</td>
                  </tr>
                  <tr>
                      <td><canvas id="canvas_radar" width="120" height="120"/></canvas></td>
                      <td>Fraudes</td>
                      <td>'. $fraudes .'($'. number_format($monto_fraudes) . ')</td>
                  </tr>
                  <tr>
                      <td><canvas id="canvas" width="120" height="120"/></td>
                      <td>Acumulado del mes</td>
                      <td><canvas id="chart-area" width="100" height="100"/></canvas></td>
                  </tr>
              </table>
           </div> 

           <!--Es el reporte numero dos-->


           <div class="container-fluid inner">
              <table class="tableizer-table">
                  <tr class="tableizer-firstrow">
                      <th>Lo + visto</th>
                      <th></th>                      
                      <th></th>                      
                    </form>
                  </tr>
                  <tr>
                      <td>'. $contenedor[0][0] .'</td>
                      <td><img class="pic" src="http://d1x736u1i353au.cloudfront.net/media/catalog/product/cache/4/image/9df78eab33525d08d6e5fb8d27136e95/d/v/dvcr0210_2.jpg"></td>
                      <td>
                        <div align="center" class="media-middle">
                          <i style="font-size:60px;" class="glyphicon glyphicon-ok"></i>
                        </div>
                      </td>
                  </tr>
                  <tr>
                      <td>'. $consulta['sku'] .'</td>
                      <td><img class="pic" src="http://d1x736u1i353au.cloudfront.net/media/catalog/product/cache/4/thumbnail/9df78eab33525d08d6e5fb8d27136e95/d/v/dvcr0210.jpg"></td>
                      <td>
                          <div align="center" class="media-middle">
                            <i style="font-size:60px;" class="glyphicon glyphicon-ok"></i>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td>SRL-4086</td>
                      <td><img class="pic" src="http://d1x736u1i353au.cloudfront.net/media/catalog/product/cache/4/thumbnail/9df78eab33525d08d6e5fb8d27136e95/d/v/dvcr0210c_1.jpg"></td>
                      <td>5</td>
                  </tr>
                  <tr>
                      <td>SRL-4086</td>
                      <td><img class="pic" src="http://d1x736u1i353au.cloudfront.net/media/catalog/product/cache/4/thumbnail/9df78eab33525d08d6e5fb8d27136e95/d/v/dvcr0210b_1.jpg"></td>
                      <td>5</td>
                  </tr>
                  <tr>
                      <td>SRL-4086</td>
                      <td><img class="pic" src="http://d1x736u1i353au.cloudfront.net/media/catalog/product/cache/4/thumbnail/9df78eab33525d08d6e5fb8d27136e95/d/b/dbts0119.jpg"></td>
                      <td>5</td>
                  </tr>

          <!--Es el reporte numero tres-->


           <div class="container-fluid inner">
              <table class="tableizer-table">
                  <tr class="tableizer-firstrow">
                      <th>Lo + vendido</th>
                      <th></th> 
                      <th></th>                     
                    </form>
                  </tr>
                  <tr>
                      <td>SRL-4086</td>
                      <td></td>
                      <td>5</td>
                  </tr>
                  <tr>
                      <td>SRL-4086</td>
                      <td></td>
                      <td>5</td>
                  </tr>
                  <tr>
                      <td>SRL-4086</td>
                      <td></td>
                      <td>5</td>
                  </tr>
                  <tr>
                      <td>SRL-4086</td>
                      <td></td>
                      <td>5</td>
                  </tr>
                  <tr>
                      <td>SRL-4086</td>
                      <td></td>
                      <td>5</td>
                  </tr>
           ';

        }else
        {
          // Menú para elegir semana anterior
          //=============================================
          //Se imprime solo si no se ha pasado ningún valor a través de la url

            //menu de navegación
           include 'includes/menu.php';

            echo '
                <header align="center">
                    <h2 class="site-title">Reporte de ventas anteriores</h2>
                    <p>Elige la semana que deseas consultar</p>          
               </header>
            ';
            echo "<div class='container-fluid inner'>";
            echo "<table style='cursor:pointer;' class='tableizer-table'>";
            echo "<tr class='tableizer-firstrow'>";
            echo "<th>Archivo Semanas Anteriores</th></tr>";
            $week = date("W")-2;
            $fin = $week - 10;
               for($sem = $week; $sem > $fin; $sem--)
               {
                  echo "<tr><td><div onclick='location.href=\"reportes_anteriores.php?semana=".$sem."\"'>Semana ";
                  echo $sem;
                  echo "<i class='glyphicon glyphicon-zoom-in pull-right'></i></div></td></tr>";  
               }
               echo "</table></div>";
        }      
          
        ?>

	</body>
</html>