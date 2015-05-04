<nav class="navbar navbar-inverse sidebar"style="position: fixed;" role="navigation">
    <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Iris</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="reporte_mensual.php">Inicio<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Otros Meses <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-calendar"></span></a>
					<ul class="dropdown-menu forAnimate" role="menu">
						<li><?php $current_year = date("Y"); echo $current_year; ?></li>
						<li class='divider'></li>
						<?php 
							$mes_actual = date('n');
							$limite = 1;
							for($x = $mes_actual; $x >= $limite; $x--){
								//este switch cambia el numero por una palabra para identificar el nombre del mes
							    switch($x){
							        case 1: $mes = "Enero "; break;
							        case 2: $mes = "Febrero "; break;
							        case 3: $mes = "Marzo "; break;
							        case 4: $mes = "Abril "; break;
							        case 5: $mes = "Mayo "; break;
							        case 6: $mes = "Junio "; break;
							        case 7: $mes = "Julio "; break;
							        case 8: $mes = "Agosto "; break;
							        case 9: $mes = "Septiembre "; break;
							        case 10: $mes = "Octubre "; break;
							        case 11: $mes = "Noviembre "; break;
							        case 12: $mes = "Diciembre "; break;
							    }
						?>
						<li><a href="?mes=<?php echo $x;?>"><?php echo $mes; ?> </a>
						<?php
								
						  }
						?>
					</ul>
				</li>
				<li ><a href="#">Categorías<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicons-pie-chart"><i class="fa fa-pie-chart"></i></span></a></li>
				<li ><a href="#losMasVendidos">Los Más Vendidos<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-star-empty"></span></a></li>
				<li ><a href="#losMasVistos">Los Más Vistos<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-star"></span></a></li>
				<li><a href="#" onclick="actualizar();">Sincronizar<i id="icono" style="font-size: 16px;" class="glyphicon glyphicon-refresh hidden-xs pull-right"></i></a></li>
				<li><a href="index.php?logout">Salir <i class="glyphicon glyphicon-log-out hidden-xs pull-right"></i></a></li>
			</ul>
		</div>
	</div>
</nav>

<script>
	function actualizar(){
		//$.get("includes/actualizar_bd.php");
		$('#icono').remove();
		$('a').append("");
		//alert("Sincronización completa!");
		return false;
	}
</script>