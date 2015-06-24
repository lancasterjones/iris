<?php
    $current_year = date("Y");
    $mes_actual   = date("n");

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

    function pedidos()
    {
        $semanas    = new DateTime();

        for($sem = 1; $sem < 53; $sem++)
        {
            $semanas->setISODate($GLOBALS['current_year'], $sem);
            $fecha = $semanas->format('n');
                if($fecha == $GLOBALS['mes_actual'])
                {
                    echo rand(1, 50) . ", ";
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
                data: [<?php pedidos(); ?>],
                color: '#FF9900'
            }, {
                name: 'Fraudes',
                type: 'column',
                yAxis: 1,
                data: [5, 7],
                color: '#c82536'
            }, {
                name: 'Venta',
                type: 'spline',
                data: [6, 9],
                tooltip: {
                    valuePrefix: '$ '
                }

            }]
        });
    });
</script>