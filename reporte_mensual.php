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
  </head>
  <body>
      <?php
          include 'includes/menu.php';
          //conectar con base de datos
          include 'includes/db_magento_connect.php';

          //conectar base de datos Vende
          include 'includes/data_base.php';

          //script con queries para generar info de reportes
          include 'includes/queries_reportes.php';
      ?>
         <script src="http://code.highcharts.com/highcharts.js"></script>
         <script src="http://code.highcharts.com/modules/exporting.js"></script>
         

         <?php

            //año actual
            $current_year = date("Y");

            //Mes actual
            $mes_actual = date("n");

            //asignar mes
           $valorMes = $_GET['mes'];
            if($valorMes != $mes_actual){
              $mes_actual = $valorMes;
            }

            switch($mes_actual){
                case 3:
                  $mes_actual = "Mayo";
                  break;
                case 4:
                  $mes_actual = "Abril";
                  break;
                case 5:
                  $mes_actual = "Mayo";
                  break;
            }

             //arreglo con semanas
             $semanaReporte = array();

             //calcular primer semana del año
             $semAnalisis = new DateTime();
              for($n = 1; $n <3; $n++){
                $semAnalisis->setISODate($current_year, $n);
                      $primer_semana = $semAnalisis->format('n');
                if($primer_semana == 1){
                  $semanaUno = $n;
                  $ajusteSemana = $semanaUno - 1;
                }
              }

            //calcular ultima semana del año


            


            //calcular las semanas contenidas en cada mes
            $mesComparar = date('n');
            $calcular_mes = new DateTime();
            $x = 0;
            $pedidos = array();
            $venta = array();
            $fraud = array();
            for($week = $semanaUno; $week < 54; $week++){ 
              $calcular_mes->setISODate($current_year, $week);
              $mes_formato = $calcular_mes->format('n');
                  if($mes_formato == $mesComparar){                      
                        $semanaReporte[$x] = $week - $ajusteSemana; /*cada año se ajusta la semana dependiendo
                        de cuando empieza*/
                        echo "semana: " . $semanaReporte[$x];
                        $semana = $semanaReporte[$x];
                        //query que obtiene ventas y pedidos
                        $query = "
                          SELECT 
                            count(sales_flat_order.total_paid) Pedidos
                            ,sum(sales_flat_order.total_paid) Venta
                            ,WEEK(sales_flat_order.created_at) Semana
                            ,YEAR(sales_flat_order.created_at) Año
                          FROM shop_production.sales_flat_order sales_flat_order
                          WHERE sales_flat_order.status IN ('complete', 'processing')
                              AND YEAR(sales_flat_order.created_at) = YEAR(CURDATE())
                              AND WEEK(sales_flat_order.created_at) = $semana";
                          //este query trae el valor de fraudes en la semana indicada
                        $fraudes = '
                              SELECT fraudes FROM magento_venta
                              WHERE week = $semana
                        ';
                        echo "posicion : " . $x;
                        //Almacenamiento de datos de consulta query ventas y pedidos
                        $consulta_pedidos = mysqli_query($connm, $query);
                        //almacenar datos de query fraudes
                        $consulta_fraudes = mysqli_query($conn, $fraudes);
                        //este ciclo llena los array venta y pedidos
                        while($array_consulta_pedidos = mysqli_fetch_array($consulta_pedidos)){
                            $venta[$x] = $array_consulta_pedidos['Venta'];
                            $pedidos[$x] = $array_consulta_pedidos['Pedidos'];

                        }
                        //este query llena el array fraudes
                        while($array_consulta_fraudes = mysqli_fetch_array($consulta_fraudes)){
                          $fraud[$x] = $array_consulta_fraudes['fraudes'];
                        }
                        echo "query: " . $pedidos[$x];
                        echo "venta: " . $venta[$x];
                        echo "Fraudes : " . $fraud[$x];

                        $x++;
                  }
            }

           //contar elementos del array, para saber la cantidad de columnas a imprimir
           $columnasReporte =  count($semanaReporte);
           echo "Columnas:  " . $columnasReporte . " Pedidos: " . $pedidos[0];

         ?>

         <!--Div contenedor de la grafica reporte mensual-->
         <div id="container" style="max-width: 85%; height: 400px; margin: 0 auto"></div>
         <script>
              $(function () {
                $('#container').highcharts({
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: '<i class="glyphicon glyphicon-circle-arrow-left"></i>Reporte Mensual: <?php echo $mes_actual . " " . $current_year; ?>' 
                    },
                    subtitle: {
                        text: 'www.lob.com.mx'
                    },
                    xAxis: [{
                        categories: [<?php 
                        for($x = 0; $x < $columnasReporte; $x++){
                            echo "'S " . $semanaReporte[$x] . "', "; 
                         }
                        ?>
                                      ],
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
                        data: [<?php 
                        for($i = 0; $i < $columnasReporte; $i++)
                        echo $pedidos[$i] . ", ";
                        ?>],
                    }, {
                        name: 'Fraudes',
                        type: 'column',
                        yAxis: 1,
                        data: [<?php
                          for($i = 0; $i < $columnasReporte; $i++){
                              echo $fraud[$i] . ", ";
                          }
                        ?>],
                        color: 'red'
                    }, {
                        name: 'Venta',
                        type: 'spline',
                        data: [<?php
                          for($i = 0; $i < $columnasReporte; $i++){
                            echo $venta[$i] . ", ";
                          }

                        ?>],
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
     
  </body>

</html>
