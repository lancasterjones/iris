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
      ?>

      <div class="container" style="width: 75% !important; float: left; margin: 10% auto;">
          <div class="row">
              <div class="col-md-12">
                  <div id="Carousel" class="carousel slide">
                      <ol class="carousel indicators">
                          <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                      </ol>
                      <div class="carousel-inner">
                          <div class="item-active">
                              <div class="row">
                                  <div class="col-md-3"><a href="#" class="thumbnail"><img src="imgs/+vendido.png"></a></div>
                              </div>
                          </div>
                          <div class="item">
                            <div class="row">
                                <div class="col-md-3"><a href="#" class="thumbnail"><img src="imgs/+vendido.png"></a></div>
                            </div>
                          </div>
                          </div>
                            <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
                            <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


  </body>
</html>
         

