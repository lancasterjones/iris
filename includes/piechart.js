 $(function () {
    $('#piechart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Sistema IRIS'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                ['Primavera-Verano',   45.0],
                ['Otoño-Invierno',       26.8],
                {
                    name: 'Lookbook',
                    y: 12.8,
                    sliced: true,
                    selected: true
                },
                ['Caballero',    8.5],
                ['Dama',     6.2],
                ['FW',   0.7]
            ]
        }]
    });
});