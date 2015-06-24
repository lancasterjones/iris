<?php
    $debug = 0;

      if (version_compare(PHP_VERSION, '5.3.7', '<')) 
      {
          exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
      } 
      else if (version_compare(PHP_VERSION, '5.5.0', '<')) 
      {
          require_once("libraries/password_compatibility_library.php");
      }

    require_once("config/db.php");
    require_once("classes/Login.php");
    $login = new Login();

      if ($login->isUserLoggedIn() == false) 
      {
         echo "<script>
                location.href='index.php';
              </script>";

      } 

    $cliente = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang='es'>
  <head>
    <title><?php echo $cliente; ?> :: IRIS</title>
    <?php include 'includes/head.php'; ?>
    <script type="text/javascript" src="includes/Chart.js"></script>
    <script type="text/javascript" src="includes/script_reportes.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    
  </head>
  <body>
      <?php include 'includes/side_menu.php'; ?>
      <div class="container-fluid">

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;">
            <div id="logo_vende" class="col-sm-offset-3 col-sm-2"></div>
            <div class="col-sm-4"></div>
            <div id="logo_cliente" class="col-sm-2"></div>
        </div><!--row-->

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;">
          <div id="fila_uno" class="col-sm-offset-2 col-sm-10"></div>
        </div><!--row-->

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;">
          <div id="fila_dos" class="col-sm-offset-2 col-sm-10"></div>
        </div><!--row-->

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;"> 
          <div id="fila_tres" class="col-sm-offset-2 col-sm-10"></div>
        </div><!--row-->
      </div>

  <script>
    function cargarContenido(elemento, empresa, archivo){
      var ruta = "clientes/" + empresa + "/" + archivo + ".php";
        $.ajax({
          method: "POST",
          url: ruta,
          dataType: "html",
          success: function(result){
              $("#" + elemento).html(result);
          }
        });

    }

    $(document).ready(function(){
        cargarContenido("logo_vende", "vende", "logo");
        cargarContenido("logo_cliente", "tecnolite", "logo");
        cargarContenido("fila_uno", "tecnolite", "tablero_principal");
        cargarContenido("fila_dos", "tecnolite", "vistos");
        cargarContenido("fila_tres", "tecnolite", "vendidos");

    })
  </script>

  </body>
</html>