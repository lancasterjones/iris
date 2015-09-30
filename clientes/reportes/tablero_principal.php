<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    require_once("../../config/db.php");
    require_once("../../classes/Login.php");
    $login = new Login();

        if ($login->isUserLoggedIn() == false) 
        {
            echo "<script>
                location.href='index.php';
                </script>";
        }

    $global_cliente = $_SESSION['user_email'];
    $current_year   = $_REQUEST['year'];
    $mes_actual     = $_REQUEST['mes'];

    //conexión a base de datos
    $servidor = "104.236.137.39";
    $db_name  = "admin_sistemaproductos";
    $usuario  = "admin_fotos";
    $pass     = "9Fdvi3D4LR";

    $conect = new mysqli($servidor, $usuario, $pass, $db_name)
              or die("Imposible conectar a DB");    

    $consulta = mysqli_query($conect, "SELECT * FROM sistema_multicliente WHERE cliente = '$global_cliente'");
        while($row = mysqli_fetch_array($consulta))
            {
                $pedidos = $row['color_pedidos'];
                $fraudes = $row['color_fraudes'];
                $ventas  = $row['color_ventas'];
            }
              
     function periodoActual()
        {
            $meses = array("Enero", "Febrero", "Marzo", "Abril", 
                "Mayo", "Junio", "Julio", "Agosto", "Septiembre", 
                            "Octubre", "Noviembre", "Diciembre");

            $fecha = $meses[$GLOBALS['mes_actual']-1] . " " . $GLOBALS['current_year'];
            echo $fecha;
        }

    function semanasMesActual()
    {
        $semanas    = new DateTime();

        for($sem = 1; $sem < 53; $sem++)
        {
            $semanas->setISODate($GLOBALS['current_year'], $sem);
            $fecha = $semanas->format('n');
                if($fecha == $GLOBALS['mes_actual']){
                    echo "'S" . $sem . "', ";
                }
        }
    }

    function crearEstadisticas($campo)
    {
        $semanas = new DateTime();
        $year    = $GLOBALS['current_year'];
        $cliente = $_SESSION['user_email'];

        for($sem = 1; $sem < 53; $sem++)
        {
            $semanas->setISODate($GLOBALS['current_year'], $sem);
            $fecha = $semanas->format('n');
                if($fecha == $GLOBALS['mes_actual'])
                {
                    $query = "SELECT magento_venta.week,
                           magento_venta.cliente,
                           magento_venta.`year`,
                           magento_venta.cantidad AS ventas,
                           magento_venta.pedidos,
                           magento_venta.fraudes
                           FROM admin_sistemaproductos.magento_venta magento_venta
                           WHERE (magento_venta.week  = $sem)
                           AND (magento_venta.cliente = '$cliente')
                           AND (magento_venta.`year`  = $year)";
                    $consulta  = mysqli_query($GLOBALS['conect'], $query);
                    $registros = mysqli_fetch_array($consulta);
                    if($registros[$campo] == '') echo "0,";
                    else echo $registros[$campo] . ", ";
                }
        }
    }

?>



<div class="container-fluid" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
    <legend style="color: #C1C1AF;"></legend>
	<div id="reporte_principal"></div>
</div>

<script>
	$(function () {
        $('#reporte_principal').highcharts({
            chart: { zoomType: 'xy' },
            title: { text: '<?php echo $global_cliente; ?>'       },
            subtitle: { text: '<?php periodoActual(); ?>' },
            xAxis: [{
                categories: [<?php semanasMesActual(); ?>],
                crosshair: true
            }],
            yAxis: [{ 
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
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
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
                data: [<?php crearEstadisticas("pedidos"); ?>],
                color: '<?php echo $pedidos; ?>'
            }, {
                name: 'Fraudes',
                type: 'column',
                yAxis: 1,
                data: [<?php crearEstadisticas("fraudes"); ?>],
                color: '<?php echo $fraudes; ?>'
            }, {
                name: 'Venta',
                type: 'spline',
                data: [<?php crearEstadisticas("ventas"); ?>],
                color: '<?php echo $ventas; ?>',
                tooltip: {
                    valuePrefix: '$ '
                }

            }]
        });
    });

    console.log("Pedidos: <?php echo $pedidos; ?> Fraudes: <?php echo $fraudes; ?> Ventas: <?php echo $ventas; ?>");
</script>