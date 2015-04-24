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
    <title>Reportes || IRIS</title>
    <?php 
        include 'includes/head.php';

    ?>
    <script type="text/javascript" src="includes/Chart.js"></script>
    <script type="text/javascript" src="includes/script_reportes.js"></script>
    <style>
      #highcharts-0{
        width: 90% !important;
        margin: 0 auto !important;
      }
    </style>
  </head>
  <body>
      <?php
          include 'includes/menu.php';
          //conectar con base de datos
          include 'includes/db_magento_connect.php';

          //script con queries para generar info de reportes
          include 'includes/queries_reportes.php';
      ?>
         <script src="http://code.highcharts.com/highcharts.js"></script>
         <script src="http://code.highcharts.com/modules/exporting.js"></script>
         <!--Div contenedor de la grafica reporte mensual-->
         <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

         <?php

            //año acutla
            $current_year = date("Y");

            //Mes actual
            $mes_actual = date("m");
            switch($mes_actual){
                case 04:
                  $mes_actual = "Abril";
                  break;
                case 05:
                  $mes_actual = "Mayo";
                  break;
            }

             $semana = date("W")-1;

             //arreglo con semanas
             $semanaReporte = array();

            //calcular las semanas contenidas en cada mes
          $calcular_mes = new DateTime();
          $x = 0;
          for($week = 1; $week < 54; $week++){ 
            $calcular_mes->setISODate($current_year, $week);
            $mes_formato = $calcular_mes->format('n');
                if($mes_formato == 4){                      
                      $semanaReporte[$x] = $week;
                      echo $semanaReporte[$x] . " ";
                      $x++;
                }
          }

            
           

            //query que obtiene ventas y pedidos
            $query = "
              SELECT 
              count(sales_flat_order.total_paid) Pedidos
              ,sum(sales_flat_order.total_paid) Venta
              ,WEEK(sales_flat_order.created_at) Semana
              ,YEAR(sales_flat_order.created_at) Año
           FROM shop_production.sales_flat_order sales_flat_order
           WHERE     sales_flat_order.status IN ('complete', 'processing')
            AND YEAR(sales_flat_order.created_at) = YEAR(CURDATE())
            AND WEEK(sales_flat_order.created_at) = $semana";

            //Almacenamiento de datos de consulta query ventas y pedidos
            $consulta_pedidos = mysqli_query($connm, $query);

            //se guarda en un array valores de ventas y pedidos
            while($array_consulta_pedidos = mysqli_fetch_array($consulta_pedidos)){
                $venta = $array_consulta_pedidos['Venta'];
                $pedidos = $array_consulta_pedidos['Pedidos'];
            }






         ?>


         <script>
              $(function () {
                $('#container').highcharts({
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: 'Reporte Mensual: <?php echo $mes_actual . " " . $current_year; ?>' 
                    },
                    subtitle: {
                        text: 'www.lob.com.mx'
                    },
                    xAxis: [{
                        categories: [<?php echo "S ";?>, 'S2', 'S3', 'S4'],
                        crosshair: true
                    }],
                    yAxis: [{ // Primary yAxis
                        min: 1,
                        labels: {
                            format: '${value}',
                            style: {
                                color: Highcharts.getOptions().colors[1]
                            }
                        },
                        title: {
                            text: 'Ventas',
                            style: {
                                color: Highcharts.getOptions().colors[1]
                            }
                        }
                    }, { // Secondary yAxis
                        title: {
                            text: 'Pedidos',
                            style: {
                                color: Highcharts.getOptions().colors[0]
                            }
                        },
                        labels: {
                            format: '{value}',
                            style: {
                                color: Highcharts.getOptions().colors[0]
                            }
                        },
                        opposite: true
                    }],
                    tooltip: {
                        shared: true
                    },
                    series: [{
                        name: 'Pedidos',
                        type: 'column',
                        yAxis: 1,
                        data: [100, 40, 34, 44],
                    }, {
                        name: 'Fraudes',
                        type: 'column',
                        yAxis: 1,
                        data: [3, 2, 5, 5],
                        color: 'red'
                    }, {
                        name: 'Venta',
                        type: 'spline',
                        data: [26559, 32450, 20970, 29070],
                        tooltip: {
                            valuePrefix: '$ '
                        }

                    }]
                });
            });
         </script>

         <table>
            <tr>
                <th>Mes</th>
                <th>Semana</th>
                <th>Mes_F</th>
                <th>Semana_F</th>
                <th>dia_F</th>
            </tr>
            
                
                <?php
                    for($x = 1; $x <18; $x++)
                    {
                      if($x<=5) $mes = "ENERO";
                      if($x>5 && $x <=8) $mes = "FEBRERO";
                      if($x>8 && $x <=13) $mes = "MARZO";
                      if($x>13 && $x <=17) $mes = "ABRIL";
                      echo "<tr><td>" . $mes . "</td>";
                      echo "<td>". $x."</td>";
                   

                    $semana = $x+1;


                    $year = 2015;
          $calcular_mes = new DateTime();
          $calcular_mes->setISODate($year, $semana);
          $m = $calcular_mes->format('M');
          $dia = $calcular_mes->format('d');

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


          echo "<td>" . $m . "</td>";
                      echo "<td>". $x."</td>";
                      echo "<td>". $dia."</td></tr>";

 }


                ?>
            
         </table>

         <?php
              echo  "Ventas " . $venta;
  echo "Pedidos " . $pedidos;
         ?>
     
  </body>

</html>
