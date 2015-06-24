<?php
    function periodoActual(){
        $current_year = date("Y");
        $mes_actual   = date("n");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", 
                        "Octubre", "Noviembre", "Diciembre");
        $fecha = $meses[$mes_actual-1] . " " . $current_year;
        echo $fecha;
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
                categories: ['S1'],
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
                data: [2],
            }, {
                name: 'Fraudes',
                type: 'column',
                yAxis: 1,
                data: [5],
                color: '#c82536'
            }, {
                name: 'Venta',
                type: 'spline',
                data: [6],
                tooltip: {
                    valuePrefix: '$ '
                }

            }]
        });
    });
</script>