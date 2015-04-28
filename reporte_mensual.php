<?php
    $debug = 0;
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
          include 'includes/side_menu.php';

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

            /*Si el sistema recibe un parametro a traves del metodo get, 
            significa que se seleccionó un mes anterior y se modifica el 
            valor de las variables, sino, el valor de las varibles es del 
            mes actual*/
            if(count($_GET)>0){
              $valorMes = $_GET['mes'];
              $mes_actual = $valorMes;
              //este valor compara al mes que resulta del analisis de cada semana
              $mesComparar = $valorMes;
            }else{
              $mes_actual = date('n');
              $mesComparar = $mes_actual;
            }
            //este switch cambia el numero por una palabra para identificar el nombre del mes
            switch($mes_actual){
                case 1: $mes_actual = "Enero"; break;
                case 2: $mes_actual = "Febrero"; break;
                case 3: $mes_actual = "Marzo"; break;
                case 4: $mes_actual = "Abril"; break;
                case 5: $mes_actual = "Mayo"; break;
                case 6: $mes_actual = "Junio"; break;
                case 7: $mes_actual = "Julio"; break;
                case 8: $mes_actual = "Agosto"; break;
                case 9: $mes_actual = "Septiembre"; break;
                case 10: $mes_actual = "Octubre"; break;
                case 11: $mes_actual = "Noviembre"; break;
                case 12: $mes_actual = "Diciembre"; break;
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
                        if ($debug == 1){
                        echo "semana: " . $semanaReporte[$x];
                      }
                        $semana = $semanaReporte[$x];
                        //query que obtiene ventas y pedidos
                        $query = "
                              SELECT * FROM magento_venta
                              WHERE week = $semana";
                        if ($debug == 1){
                        echo "posicion : " . $x;
                        echo "<h1>Semana: " . $semana . "</h1>";
                      }
                        //Almacenamiento de datos de consulta query ventas y pedidos
                        $consulta_pedidos = mysqli_query($conn, $query);
                        //este ciclo llena los array venta y pedidos
                        while($array_consulta_pedidos = mysqli_fetch_array($consulta_pedidos)){
                            $venta[$x] = $array_consulta_pedidos['cantidad'];
                            $pedidos[$x] = $array_consulta_pedidos['pedidos'];
                            $fraud[$x] = $array_consulta_pedidos['fraudes'];
                        }
                        if ($debug == 1){
                          echo "query: " . $pedidos[$x];
                          echo "venta: " . $venta[$x];
                          echo "Fraudes : " . $fraud[$x];
                        }
                        $x++;
                  }
            }

           //contar elementos del array, para saber la cantidad de columnas a imprimir
           $columnasReporte =  count($semanaReporte);
           
           if ($debug == 1){
           echo "Columnas:  " . $columnasReporte . " Pedidos: " . $pedidos[0];
         }


         /*=============================================================================
          Script para menú slide mas vendidos
         */

          $year = date('Y'); // año actual

          //si se pasa valor a variabla a traves de metodo get se asigna ese valor al mes, si no, el valor del mes actual
          if(count($_GET) > 0){
            $mes_reportes = "0" . $_GET['mes'];
          }else{
            $mes_reportes = date('m');
          }

          //query consulta los mas vendidos
          $query_vendidos = "SELECT * FROM mas_vendidos
                             WHERE mes = " . $year . $mes_reportes .
                             " ORDER BY mes DESC";
          //array con la consulta
          $res_vendidos = mysqli_query($conn, $query_vendidos);
          $contenedor = array(); //array almacena todos los resultados
          $x = 0; //contador
          while($row_vendidos = mysqli_fetch_array($res_vendidos)){
              $contenedor[$x][0] = $row_vendidos['foto'];
              $contenedor[$x][1] = $row_vendidos['sku'];
              $x++; 
          }

          //cuenta los elementos del array para crear espacios para imagenes, crea máximo 10 espacios
          if(count($contenedor) < 10){
            $limite = count($contenedor);
          }else{
            $limite = 10;
          }

           /*=============================================================================
          Script para menú slide mas vistos
         */
          $cont_vistos = array();
          $query_vistos = "SELECT * FROM mas_vistos
                           WHERE mes =" .$year . $mes_reportes .
                           " ORDER BY mes DESC";
          $res_vistos = mysqli_query($conn, $query_vistos);
          $x = 0;
          while($row_vistos = mysqli_fetch_array($res_vistos))
          {
            $cont_vistos[$x][0] = $row_vistos['foto'];
            $cont_vistos[$x][1] = $row_vistos['modelo'];
            $x++;
          }

          if(count($cont_vistos) < 10){
            $limit_vistos = count($cont_vistos);
          }else{
            $limit_vistos = 10;
          }

         ?>

         <!--Div contenedor de la grafica reporte mensual-->
         <div id="container" style="float: left; min-width: 70%; height: 400px; margin: 10% auto 10% 20%"></div>
        </br>

        <!--Slide los más vendidos-->

        <div class="container" id="losMasVendidos" style="width: 70% !important; margin: 20% auto 0 20%;">
        <div class="row">
        <div class="col-md-12">
                    <div id="Carousel" class="carousel slide">
                     
                     <?php

                     ?>
                    <ol class="carousel-indicators">
                        <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#Carousel" data-slide-to="1"></li>
                        <li data-target="#Carousel" data-slide-to="2"></li>
                    </ol>
                     
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        
                    <div class="item active">
                      <div class="row">
                        <?php
                            if($limite > 4){
                                $limite_uno = 4;
                            }else $limite_uno = $limite;
                            for($x = 0; $x < $limite_uno; $x++){
                         ?>
                        <div class="col-md-3">
                          <a href="#" class="thumbnail">
                            <img src="http://d1x736u1i353au.cloudfront.net/media/catalog/product<?php echo $contenedor[$x][0]; ?>" alt="Image" style="max-width:100%;">
                          </a>
                          <h4 style="position: relative; margin: 0px 10%;"><?php echo $contenedor[$x][1]; ?></h4>
                        </div>

                        <?php }  ?>
                      </div><!--.row-->
                    </div><!--.item-->

                    <!--Segunda serie de fotos, de la 5 a la 8-->
                    <?php
                        if($limite >= 4){
                          if($limite < 8) {
                            $limite_dos = $limite;
                          }else $limite_dos = 8;
                    ?>

                      <div class="item">
                      <div class="row">

                      <?php
                          for($y = 4; $y < $limite_dos; $y++)
                          {
                     ?>                  

                        <div class="col-md-3">
                          <a href="#" class="thumbnail">
                            <img src="http://d1x736u1i353au.cloudfront.net/media/catalog/product<?php echo $contenedor[$y][0]; ?>" alt="Image" style="max-width:100%;">
                          </a>
                          <h4 style="position: relative; margin: 0px 10%;"><?php echo $contenedor[$y][1]; ?></h4>
                        </div>
                      
                    
                    <?php
                            } //cierre for

                    ?>
                          </div><!--.row-->
                    </div><!--.item-->
                    <?php
                        }//cierre de if
                    ?>


                     <!--Segunda serie de fotos, de la 9 a la 10-->
                     <?php
                        if($limite >= 8){
                          if($limite < 10) {
                            $limite_tres = $limite;
                          }else $limite_tres = 10;
                    ?>

                      <div class="item">
                      <div class="row">
                     <?php
                          for($y = 8; $y < $limite_tres; $y++)
                          {
                     ?>                  

                        <div class="col-md-3">
                          <a href="#" class="thumbnail">
                            <img src="http://d1x736u1i353au.cloudfront.net/media/catalog/product<?php echo $contenedor[$y][0]; ?>" alt="Image" style="max-width:100%;">
                          </a>
                          <h4 style="position: relative; margin: 0px 10%;"><?php echo $contenedor[$y][1]; ?></h4>
                        </div>
                      
                    
                    <?php
                            } //cierre for

                    ?>
                          </div><!--.row-->
                    </div><!--.item-->
                    <?php
                        }//cierre de if
                    ?>  

                      <?php
                        //el boton de avanzar se muestra solo si hay mas de 4 fotos
                        if($limite > 4){
                      ?>                 
                    </div><!--.carousel-inner-->
                      <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
                      <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
                    </div><!--.Carousel-->
                    <?php 
                            }
                    ?>
                     
        </div>
      </div>
    </div><!--.container-->

  </br>
           <!--Slide los más vistos-->

        <div class="container" id="losMasVistos" style="width: 70% !important; margin: 20% auto 0 20%;">
        <div class="row">
        <div class="col-md-12">
                    <div id="Carousel" class="carousel slide">
                     
                     <?php

                     ?>
                    <ol class="carousel-indicators">
                        <li data-target="#Carousel_vistos" data-slide-to="0" class="active"></li>
                        <li data-target="#Carousel_vistos" data-slide-to="1"></li>
                        <li data-target="#Carousel_vistos" data-slide-to="2"></li>
                    </ol>
                     
                    <!-- Carousel items -->
                    <div class="carousel-inner">
                        
                    <div class="item active">
                      <div class="row">
                        <?php
                            if($limit_vistos > 4){
                                $limite_uno = 4;
                            }else $limite_uno = $limit_vistos;
                            for($x = 0; $x < $limite_uno; $x++){
                         ?>
                        <div class="col-md-3">
                          <a href="#" class="thumbnail">
                            <img src="http://d1x736u1i353au.cloudfront.net/media/catalog/product<?php echo $cont_vistos[$x][0]; ?>" alt="Image" style="max-width:100%;">
                          </a>
                          <h4 style="position: relative; margin: 0px 10%;"><?php echo $cont_vistos[$x][1]; ?></h4>
                        </div>

                        <?php }  ?>
                      </div><!--.row-->
                    </div><!--.item-->

                    <!--Segunda serie de fotos, de la 5 a la 8-->
                    <?php
                        if($limit_vistos >= 4){
                          if($limit_vistos < 8) {
                            $limite_dos = $limit_vistos;
                          }else $limite_dos = 8;
                    ?>

                      <div class="item">
                      <div class="row">

                      <?php
                          for($y = 4; $y < $limite_dos; $y++)
                          {
                     ?>                  

                        <div class="col-md-3">
                          <a href="#" class="thumbnail">
                            <img src="http://d1x736u1i353au.cloudfront.net/media/catalog/product<?php echo $cont_vistos[$y][0]; ?>" alt="Image" style="max-width:100%;">
                          </a>
                          <h4 style="position: relative; margin: 0px 10%;"><?php echo $cont_vistos[$y][1]; ?></h4>
                        </div>
                      
                    
                    <?php
                            } //cierre for

                    ?>
                          </div><!--.row-->
                    </div><!--.item-->
                    <?php
                        }//cierre de if
                    ?>


                     <!--Segunda serie de fotos, de la 9 a la 10-->
                     <?php
                        if($limit_vistos >= 8){
                          if($limit_vistos < 10) {
                            $limite_tres = $limit_vistos;
                          }else $limite_tres = 10;
                    ?>

                      <div class="item">
                      <div class="row">
                     <?php
                          for($y = 8; $y < $limite_tres; $y++)
                          {
                     ?>                  

                        <div class="col-md-3">
                          <a href="#" class="thumbnail">
                            <img src="http://d1x736u1i353au.cloudfront.net/media/catalog/product<?php echo $cont_vistos[$y][0]; ?>" alt="Image" style="max-width:100%;">
                          </a>
                          <h4 style="position: relative; margin: 0px 10%;"><?php echo $cont_vistos[$y][1]; ?></h4>
                        </div>
                      
                    
                    <?php
                            } //cierre for

                    ?>
                          </div><!--.row-->
                    </div><!--.item-->
                    <?php
                        }//cierre de if
                    ?>  

                      <?php
                        //el boton de avanzar se muestra solo si hay mas de 4 fotos
                        if($limit_vistos > 4){
                      ?>                 
                    </div><!--.carousel-inner-->
                      <a data-slide="prev" href="#Carousel_vistos" class="left carousel-control">‹</a>
                      <a data-slide="next" href="#Carousel_vistos" class="right carousel-control">›</a>
                    </div><!--.Carousel-->
                    <?php 
                            }
                    ?>
                     
        </div>
      </div>
    </div><!--.container-->



         <!--Botones para avanzar o atrasar el mes de consulta--
         <button type="button" class="btn btn-default btn-circle btn-lg"><i class="glyphicon glyphicon-menu-left"></i></button>
         <button type="button" class="btn btn-default btn-circle btn-lg"><i class="glyphicon glyphicon-menu-right"></i></button>-->
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


      <?php
        if ($debug == 1){
      ?>
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
         <?php } ?>
     
  </body>

</html>
