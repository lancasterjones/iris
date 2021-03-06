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

    $cliente = $_SESSION['user_email'];
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
          <div id="fila_uno_info"    class="col-sm-offset-2 col-sm-3"></div>
          <div id="fila_uno_usuarios" class="col-sm-3"></div>
        </div>

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;">
          <div id="fila_dos" class="col-sm-offset-3 col-sm-8"></div>
        </div>

        <div class="row" style="margin-top: 3%; margin-bottom: 3%;"> 
          <div id="fila_tres" class="col-sm-offset-3 col-sm-8"></div>
        </div>
      </div>

  <script>
    //------busca e inserta los modulos html------------------------
    function cargarContenido(elemento, empresa, archivo, mes)
      {
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

    //-------al elegir una opción en el menú se desliza hasta hasta el div correspondiente--

    function deslizar()
    {  
      $("#conf_cliente").click(function(){
          $('html, body').animate({
              scrollTop: $('#fila_dos').offset().top
          }, 1000);
      });
      
    }

    //------trae los colores y url personalizados de la vista cliente----------

    function traerConfiguracion()
      {
        $('#select_cliente').change(function(){
             var cliente = $(this).val();
                if(cliente != '') $('#nuevo_cliente').prop('disabled', true);
                    else $('#nuevo_cliente').prop('disabled', false);

             $.ajax({
                method: "POST",
                url: "includes/traer_configuracion.php",
                data: {cliente: cliente},
                dataType: "text",
                success: function(data){
                    var param = data.split("***");
                    $('#configurar_logo').val(param[0]);

                    $('#configurar_foto').val(param[1]);

                    $('#configurar_pedidos').val(param[2]);
                        $("#muestra_pedidos").css({
                                  "border-style": "solid", 
                                  "border-width": "1px", 
                                  "border-color": "#ccc",
                                  "height" : "40px",
                                  "border-radius" : "5px",
                                  "background-color" : param[2]
                                });

                    $('#configurar_fraudes').val(param[3]);
                        $("#muestra_fraudes").css({
                                  "border-style": "solid", 
                                  "border-width": "1px", 
                                  "border-color": "#ccc",
                                  "height" : "40px",
                                  "border-radius" : "5px",
                                  "background-color" : param[3]
                                });

                    $('#configurar_venta').val(param[4]);
                        $('#muestra_ventas').css({
                                  "border-style": "solid", 
                                  "border-width": "1px", 
                                  "border-color": "#ccc",
                                  "height" : "40px",
                                  "border-radius" : "5px",
                                  "background-color" : param[4]
                                });
                }
             });
        });
      }

    function traerMetricas()
      {
          $('#select_cte_metricas, #select_periodo').change(function(){
                var cliente = $('#select_cte_metricas').val();
                    if(cliente != '') $('#configurar_metricas_cliente').prop('disabled', true);
                        else $('#configurar_metricas_cliente').prop('disabled', false);

                var periodo = $('#select_periodo').val();
                var visitas = $('#configurar_visitas').val();
                var conversion = $('#configurar_conversion').val();
                var ticket = $('#configurar_ticket').val();

                $.ajax({
                    method: "POST",
                    url: "includes/traer_metricas.php",
                    data: {cliente: cliente, periodo: periodo},
                    dataType: "text",
                    success: function(data){
                        var datos = data.split("***");
                        $('#configurar_visitas').val(datos[0]);
                        $('#configurar_conversion').val(datos[1]);
                        $('#configurar_ticket').val(datos[2]);

                        console.log("cliente " + cliente + " periodo: " + periodo + " visitas " + visitas + " conversion " + conversion + " ticket " + ticket);
                    }
                });    //ajax            
          });
      }

    //------almacena los datos del formulario metricas en tabla metricas, db vende--------
    function guardarMetricas()
      {
            var cliente = $('#configurar_metricas_cliente').val();
               if(cliente == '') cliente = $('#select_cte_metricas').val();

            var periodo = $('#select_periodo').val();
            var visitas = $('#configurar_visitas').val();
            var conversion = $('#configurar_conversion').val();
            var ticket = $('#configurar_ticket').val(); 

            $.ajax({
                method: "POST",
                url: "includes/guardar_metricas.php",
                data: {
                    cliente: cliente,
                    fecha: periodo,
                    visitas: visitas,
                    ticket: ticket,
                    conversion: conversion
                },
                success: function(){
                  $('#icono_btn_metri').addClass('fa-check');
                  $('#btn-metricas').html('Guardado');
                      setTimeout(function(){
                            cargarContenido("fila_tres", "vende", "configurar_metricas");
                      }, 3000);
                }
            }); 
      }


    function guardarConfiguracion()
      {
          var cliente = $('#nuevo_cliente').val();
            if(cliente == '') cliente = $('#select_cliente').val();

          var logo    = $('#configurar_logo').val();
          var foto    = $('#configurar_foto').val();
          var pedidos = $('#configurar_pedidos').val();
          var fraudes = $('#configurar_fraudes').val();
          var ventas  = $('#configurar_venta').val();

        $.ajax({
            method: "POST",
            url: "includes/guardar_configuracion.php",
            data: {
                  cliente : cliente,
                  logo: logo,
                  foto: foto,
                  pedidos: pedidos,
                  fraudes: fraudes,
                  ventas: ventas
            },
            success: function()
            {
                $('#icono_btn_conf').addClass('fa-check');
                $('#btn-configuracion').html('Guardado');
                      setTimeout(function(){
                            cargarContenido("fila_dos", "vende", "configurar_cliente");
                      }, 3000);

                console.log("Datos guardados: cliente: " + cliente + " " + logo + " foto: " + foto + " pedidos: " + pedidos + fraudes + ventas);
            } //success
        }); //ajax

      }//funcion
    function comprobarColor()
      {
        $('#configurar_pedidos, #configurar_fraudes, #configurar_venta').change(function(){
              var color = $(this).val();
              var id = $(this).closest('div').attr('id');
              console.log(color + " id " + id);

              //$().css();
        });
      }
    
    $(document).ready(function(){
        cargarContenido("menu", "vende" , "menu");
        cargarContenido("logo_cliente", "vende", "logo");
        cargarContenido("fila_uno_info", "vende", "info");
        cargarContenido("fila_uno_usuarios", "vende", "usuarios");
        cargarContenido("fila_dos", "vende", "configurar_cliente");
        cargarContenido("fila_tres", "vende", "configurar_metricas");
        
    })
  </script>
  <script type="text/javascript" src="includes/jscolor/jscolor.js"></script>
  </body>
</html> 
