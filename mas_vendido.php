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
    <title>Lo más Vendido || IRIS</title>
    <?php 
        include 'includes/head.php';

    ?>
    <script type="text/javascript" src="includes/Chart.js"></script>
    <script type="text/javascript" src="includes/script_reportes.js"></script>
    
  </head>
  <body>
      <?php
          include 'includes/side_menu.php';
          //conectar con base de datos
          include 'includes/db_magento_connect.php';

          //conectar base de datos Vende
          include 'includes/data_base.php';


          $year = date('Y'); // año actual

          //si se pasa valor a variabla a traves de metodo get se asigna ese valor al mes, si no, el valor del mes actual
          if(count($_GET) > 0){
            $mes = $_GET['mes'];
          }else{
            $mes = date('m');
          }

          //query consulta los mas vendidos
          $query_vendidos = "SELECT * FROM mas_vendidos
                             WHERE mes = " . $year . $mes .
                             " ORDER BY mes DESC";
          //array con la consulta
          $res_vendidos = mysqli_query($conn, $query_vendidos);
          $contenedor = array(); //array almacena todos los resultados
          $x = 0; //contador
          while($row_vendidos = mysqli_fetch_array($res_vendidos)){
              $contenedor[$x][0] = $row_vendidos['foto'];
              $x++; 
          }

          //cuenta los elementos del array para crear espacios para imagenes, crea máximo 10 espacios
          if(count($contenedor) < 10){
            $limite = count($contenedor);
          }else{
            $limite = 10;
          }

      ?>




      <div class="container" style="width: 72% !important; float: left; margin: 15% 3%;">
        <div class="row">
        <div class="col-md-12">
                    <div id="Carousel" class="carousel slide">
                     
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
                            for($x = 0; $x < $limite; $x++){
                         ?>
                        <div class="col-md-3">
                          <a href="#" class="thumbnail">
                            <img src="http://d1x736u1i353au.cloudfront.net/media/catalog/product<?php echo $contenedor[$x][0]; ?>" alt="Image" style="max-width:100%;">
                          </a>
                          <p>prueba</p>
                        </div>

                        <?php }  ?>
                      </div><!--.row-->
                    </div><!--.item-->
                     
                    <div class="item">
                      <div class="row">
                        <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
                        <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
                        <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
                        <div class="col-md-3"><a href="#" class="thumbnail"><img src="http://placehold.it/250x250" alt="Image" style="max-width:100%;"></a></div>
                      </div><!--.row-->
                    </div><!--.item-->
                    
                                       
                    </div><!--.carousel-inner-->
                      <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
                      <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
                    </div><!--.Carousel-->
                     
        </div>
      </div>
    </div><!--.container-->

     
  </body>
</html>
         

