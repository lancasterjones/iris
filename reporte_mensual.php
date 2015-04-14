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
      ?>
         <script src="http://code.highcharts.com/highcharts.js"></script>
         <script src="http://code.highcharts.com/modules/exporting.js"></script>
         <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>



         <script>
              $(function () {
                $('#container').highcharts({
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: 'Ventas por Semana'
                    },
                    subtitle: {
                        text: 'www.lob.com.mx'
                    },
                    xAxis: [{
                        categories: ['S1', 'S2', 'S3', 'S4'],
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
                        data: [41, 40, 34, 44],
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
     
  </body>

</html>
