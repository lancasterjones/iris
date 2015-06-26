<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    $current_year = $_REQUEST['year'];
    $mes_actual   = $_REQUEST['mes'];

    //conexión a base de datos
    $servidor = "104.236.137.39";
    $db_name  = "admin_sistemaproductos";
    $usuario  = "admin_fotos";
    $pass     = "9Fdvi3D4LR";

    $conect = new mysqli($servidor, $usuario, $pass, $db_name)
              or die("Imposible conectar a DB");

    

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
        $semanas   = new DateTime();

        for($sem = 1; $sem < 53; $sem++)
        {
            $semanas->setISODate($GLOBALS['current_year'], $sem);
            $fecha = $semanas->format('n');
                if($fecha == $GLOBALS['mes_actual'])
                {
                    //echo rand(1, 50) . ", ";
                    $query = "SELECT magento_venta.week,
           magento_venta.cliente,
           magento_venta.`year`,
           magento_venta.cantidad AS ventas,
           magento_venta.pedidos,
           magento_venta.fraudes
           FROM admin_sistemaproductos.magento_venta magento_venta
           WHERE (magento_venta.week = $sem)
           AND (magento_venta.cliente = 'LOB')
           AND (magento_venta.`year` = 2015)";
                    $consulta  = mysqli_query($GLOBALS['conect'], $query);
                    $registros = mysqli_fetch_array($consulta);
                    $dato      = $registros[$campo];
                    echo $dato[0];
                }
        }
    }

?>



<div class="container-fluid" style="border-top-style: solid; border-color: #E7E7E6; border-width: 3px;">
    <legend >
        <?php periodoActual(); ?>
    </legend>
	<div id="reporte_principal"></div>
</div>

<script>
	$(function () {
        $('#reporte_principal').highcharts({
            chart: { zoomType: 'xy' },
            title: { text: 'TECNOLITE'       },
            subtitle: { text: 'https://tienda.tecnolite.com.mx' },
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
                color: '#FF9900'
            }, {
                name: 'Fraudes',
                type: 'column',
                yAxis: 1,
                data: [<?php crearEstadisticas("fraudes"); ?>],
                color: '#c82536'
            }, {
                name: 'Venta',
                type: 'spline',
                data: [<?php crearEstadisticas("ventas"); ?>],
                color: '#47D147',
                tooltip: {
                    valuePrefix: '$ '
                }

            }]
        });
    });
</script>