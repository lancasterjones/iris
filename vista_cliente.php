<?php
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

    $cliente = $_REQUEST['c'];
    $mes     = $_REQUEST['m'];
    $year    = $_REQUEST['y'];
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
    <style type="text/css">
          @import url("http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css");
    </style>
  </head>
  <body>
      <nav id="menu" class="navbar navbar-inverse sidebar" role="navigation"></nav>

      <div class="container-fluid" style="background-color: #FAFAF6;">

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;">
            <div id="logo_vende" class="col-sm-offset-3 col-sm-2"></div>
            <div class="col-sm-4"></div>
            <div id="logo_cliente" class="col-sm-2"></div>
        </div>

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;">
          <div id="fila_uno_info" class="col-sm-offset-2 col-sm-3"></div>
          <div id="fila_uno" class="col-sm-7"></div>
        </div>

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;">
          <div id="fila_dos" class="col-sm-offset-2 col-sm-10"></div>
        </div>

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;"> 
          <div id="fila_tres" class="col-sm-offset-2 col-sm-10"></div>
        </div>
      </div>

  <script>

    function deslizar()
    {      
      $('#menu_vistos').click(function(){
          $('html, body').animate({
              scrollTop: $('#fila_dos').offset().top
          }, 1000);
      });
      $("#menu_vendidos").click(function(){
          $('html, body').animate({
              scrollTop: $('#fila_tres').offset().top
          }, 1000);
      });
      
    }

    function cargarContenido(elemento, empresa, archivo, mes){
      var ruta = "clientes/" + empresa + "/" + archivo + ".php";
      var mes  = '<?php echo $mes; ?>';
      var year = '<?php echo $year; ?>';
        $.ajax({
          method: "POST",
          url: ruta,
          data: {
            mes: mes,
            year: year   },
          dataType: "html",
          success: function(result){
              $("#" + elemento).html(result);
          }
        });

    }

    $(document).ready(function(){
        var cliente = <?php echo "'" .  strtolower($cliente) . "'"; ?>;

        cargarContenido("menu", cliente, "menu");
        cargarContenido("logo_cliente", cliente, "logo");
        cargarContenido("fila_uno_info", cliente, "info");
        cargarContenido("fila_uno", cliente, "tablero_principal");
        cargarContenido("fila_dos", cliente, "vendidos");
        cargarContenido("fila_tres", cliente, "vistos");
        
    })
  </script>

  </body>
</html> 
