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

          //convertir semana a mes
          $year = 2015;
          $calcular_mes = new DateTime();
          $calcular_mes->setISODate($year, $semana);
          $m = $calcular_mes->format('M');

          // variable w indica el numero de mes a consultar
          
          switch ($m) {
            case 'Jan':
               $w = "01";
               break;
            case 'Feb':
               $w = "02";
               break;
            case 'Mar':
               $w = "03";
               break;
            case 'Apr':
               $w = "04";
               break;
            case 'May':
               $w = "05";
               break;
            case 'Jun':
               $w = "06";
               break;
            case 'Jul':
               $w = "07";
               break;
            case 'Aug':
               $w = "08";
               break;
            case 'Sep':
               $w = "09";
               break;
            case 'Oct':
               $w = "10";
               break;
            case 'Nov':
               $w = "11";
               break;
            case 'Dec':
               $w = "12";
              break;
            default:
              break;
          }



          //conexión a base de datos Vende para reportes mas vistos y mas vendidos

          //conectar bd vende
          $con=mysqli_connect("104.236.137.39","admin_fotos","9Fdvi3D4LR","admin_sistemaproductos");
          if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }


          //query mas vendidos
          $sql = "
                SELECT * FROM mas_vendidos
                WHERE mes = '2015".$w."'
                ORDER BY mes DESC
          ";

          //query masvistos
          $sqlvistos = "
                SELECT * FROM mas_vistos
                WHERE mes = '2015".$w."'
                ORDER BY mes DESC
          ";

          $resultado = mysqli_query($con, $sql);
          $masvistos = mysqli_query($con, $sqlvistos);
          //numero de filas query masvistos
          $nVistos = mysqli_num_rows($masvistos);
          $contenedor = array(array());   
          $contador = 0;

          while ($consulta = mysqli_fetch_array($resultado)) {
            $contenedor[$contador][0] = $consulta['sku'];
            $contenedor[$contador][1] = $consulta['foto'];
            $contenedor[$contador][2] = $consulta['cantidad'];
            $contador++;
          }
          //contador masvistos
          $contador = 0;
          while ($cons_masvistos = mysqli_fetch_array($masvistos)){
            $contenedor[$contador][3] = $cons_masvistos['modelo'];
            $contenedor[$contador][4] = $cons_masvistos['foto'];
            $contenedor[$contador][5] = $cons_masvistos['qty'];
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
                      <th><h3>Ventas</h3></th>
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

           <!--
           ==========================================================================
           Es el reporte numero dos-->


           <div class="container-fluid inner">
              <table class="tableizer-table">
                  <tr class="tableizer-firstrow">
                      <th><h3>Lo + vendido</h3></th>
                      <th></th>                      
                      <th></th>                                          
                  </tr>';


                  $fila = 0;
                  for($fila = 0; $fila < 10; $fila++)
                  {
                      if($contenedor[$fila][2] > 0)
                      {
                          $icono = "ok";
                      }else if($contenedor[$fila][2] == 0)
                      {
                          $icono = "remove";
                      }
                  echo '<tr>
                      <td>'. $contenedor[$fila][0] .'</td>
                      <td><img class="pic" src="http://d1x736u1i353au.cloudfront.net/media/catalog/product/'. $contenedor[$fila][1] .'"></td>
                      <td>
                        <div align="center" class="media-middle">
                          <i style="font-size:60px;" class="glyphicon glyphicon-'. $icono.'"></i>
                        </div>
                      </td>
                  </tr>';
                   $icono = "";
                }


           echo   '</table></div>

          <!--
           ======================================================================
           Es el reporte numero tres-->

           <div class="container-fluid inner">
              <table class="tableizer-table">
                  <tr class="tableizer-firstrow">
                      <th><h3>Lo + visto</h3></th>
                      <th></th> 
                      <th></th>
                  </tr>';


                  $fila = 0;
                  $icon = "";
                  for($fila = 0; $fila < $nVistos; $fila++)
                  {
                    if($contenedor[$fila][5] > 0)
                      {
                          $icon = "ok";
                      }else 
                      {
                          $icon = "remove";
                      }

                    echo '
                  <tr>
                      <td>'. $contenedor[$fila][3] .'</td>
                      <td>
                          <img class="pic" src="http://d1x736u1i353au.cloudfront.net/media/catalog/product/'. $contenedor[$fila][4] .'"></td>
                      </td>
                      <td>
                          <div align="center" class="media-middle">
                            <i style="font-size:60px;" class="glyphicon glyphicon-'. $icon.'"></i>
                          </div>
                      </td>
                  </tr>';
                }
           
          echo  "</table></div>";

              //PRUEBA DE REPORTE CONCENTRADO

          echo '
           <div class="container-fluid inner">
              <table class="tableizer-table">
                  <tr class="tableizer-firstrow">
                      <th><img src="imgs/+vendido.png"></th>
                      <th><img src="imgs/+visto.png"></th>                                          
                  </tr>';

          //ciclo que imprime las fias de la tabla
                  for($x = 0; $x < 10; $x++)
                  {

                    if($contenedor[$x][5] > 0)
                      {
                          $icon = "ok";
                      }else 
                      {
                          $icon = "remove";
                      }
                      echo '
                            <tr>
                              <td>
                                  <img class="pic" src="http://d1x736u1i353au.cloudfront.net/media/catalog/product/'. 
                                  $contenedor[$x][1] . '"><div>' . $contenedor[$x][0] .'</div>
                              </td>
                              <td>
                                  <img class="pic" src="http://d1x736u1i353au.cloudfront.net/media/catalog/product/'.
                                   $contenedor[$x][4] . '><div>'. $contenedor[$x][3] .'</div><div>
                                   <i style="font-size:60px;" class="glyphicon glyphicon-'. $icon.'</i></div>
                              </td>
                            </tr>
                      ';
                    }




          echo '</table></div>';


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