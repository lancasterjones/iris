var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

					var barChartData = {
						labels : ["January","February","March"],
						datasets : [
							{
								fillColor : "rgba(220,220,220,0.5)",
								strokeColor : "rgba(220,220,220,0.8)",
								highlightFill: "rgba(220,220,220,0.75)",
								highlightStroke: "rgba(220,220,220,1)",
								data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
							},
							{
								fillColor : "rgba(151,187,205,0.5)",
								strokeColor : "rgba(151,187,205,0.8)",
								highlightFill : "rgba(151,187,205,0.75)",
								highlightStroke : "rgba(151,187,205,1)",
								data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
							}
						]

					}


				//piechart
					var pieData = [
				{
					value: 300,
					color:"#F7464A",
					highlight: "#FF5A5E",
					label: "Red"
				},
				{
					value: 50,
					color: "#46BFBD",
					highlight: "#5AD3D1",
					label: "Green"
				},
				{
					value: 100,
					color: "#FDB45C",
					highlight: "#FFC870",
					label: "Yellow"
				},
				{
					value: 40,
					color: "#949FB1",
					highlight: "#A8B3C5",
					label: "Grey"
				},
				{
					value: 120,
					color: "#4D5360",
					highlight: "#616774",
					label: "Dark Grey"
				}

			];


			//variable grafico radar

			var radarChartData = {
				labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
				datasets: [
					{
						label: "My First dataset",
						fillColor: "rgba(220,220,220,0.2)",
						strokeColor: "rgba(220,220,220,1)",
						pointColor: "rgba(220,220,220,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(220,220,220,1)",
						data: [65,59,90,81,56,55,40]
					},
					{
						label: "My Second dataset",
						fillColor: "rgba(151,187,205,0.2)",
						strokeColor: "rgba(151,187,205,1)",
						pointColor: "rgba(151,187,205,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(151,187,205,1)",
						data: [28,48,40,19,96,27,100]
					}
				]
			};


			//dibuja piechart

			window.onload = function(){
				//selecciona etiqueta canvas para piechart
				var ctx = document.getElementById("chart-area").getContext("2d");
				window.myPie = new Chart(ctx).Pie(pieData);
				//selecciona etiqueta canvas para barras
				var ctx = document.getElementById("canvas").getContext("2d");
				window.myBar = new Chart(ctx).Bar(barChartData, {
					responsive : true
				});
				window.myRadar = new Chart(document.getElementById("canvas_radar").getContext("2d")).Radar(radarChartData, {
					responsive: true
				});
			};